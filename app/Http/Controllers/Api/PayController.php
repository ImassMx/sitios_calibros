<?php

namespace App\Http\Controllers\Api;

use Conekta\Order;
use App\Models\Cart;
use App\Models\User;
use Conekta\Conekta;
use Conekta\Customer;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\PurchasedBook;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Mail\SendBooksMail;
use App\Models\BookSale;
use App\Models\Order as ModelsOrder;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class PayController extends Controller
{
    private $books_email;
    private $user_id;
    private $points;
    private $price;

    public function __construct(){
        Conekta::setApiKey(config('conekta.secret'));
    }

    public function processPay($id, Request $request)
    {
        try {
            $user = User::find($id);
            $doc = Doctor::where('user_id', $id)->first();

            $dominio = $request->getSchemeAndHttpHost();
   
            $validCustomer = [
                'name' => $user->name,
                'email' => $user->email
            ];

            $customer = Customer::create($validCustomer);
            $this->price = str_replace(',','',$request->price);
            $resOrder = $this->createOrder($customer->id, $request->quantity, (float) str_replace([',', '.'], '', $request->price), $doc,$dominio);
            return response()->json([
                'error' => false,
                'url' => $resOrder->checkout->url
            ]);
        } catch (\Throwable $th) {
            Log::error(["processPay" => $th]);
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function confirmationConekta(Request $request)
    {
        $body = @file_get_contents('php://input');
        $data = json_decode($body, true);

        $order_id = isset($data["data"]["object"]["id"]) ? $data["data"]["object"]["id"] : null;
        $status = isset($data["data"]["object"]["payment_status"]) ? $data["data"]["object"]["payment_status"] : null;

        if (empty($order_id) && empty($status)) {
            return false;
        }

        $this->updateOrder($order_id, $status);

        return response()->json(["message" => "success"], 200);
    }

    private function createOrder($customer_id, $quantity, $price, $doc,$dominio)
    {
        try {

            $books = Cart::where('user_id', $doc->user_id)->pluck('id')->toArray();
            $this->user_id = $doc->user_id;
            $validOrderWithCheckout = array(
                'line_items' => array(
                    array(
                        'name' => 'Compra de Libros',
                        'description' => 'Compra de libros de enfermedades',
                        'unit_price' => $price,
                        'quantity' => 1,
                        'sku' => 'ca-book',
                        'category' => 'book',
                        'tags' => array('book')
                    )
                ),
                'checkout' => array(
                    'allowed_payment_methods' => array("cash", "card", "bank_transfer"),
                    'type' => 'HostedPayment',
                    'success_url' => $dominio.'/payment/confirmation?doctor=' . $doc->uuid,
                    'failure_url' => $dominio.'/payment/failure?doctor=' . $doc->uuid,
                    'monthly_installments_enabled' => true,
                    'monthly_installments_options' => array(3, 6, 9, 12),
                    "redirection_time" => 30
                ),
                'customer_info' => array(
                    'customer_id'   =>  $customer_id
                ),
                'currency'    => 'mxn',
                'metadata'    => array('books' => implode(', ', $books), 'usuario' => $doc->user_id)
            );
            $order = Order::create($validOrderWithCheckout);

            $this->registerOrder($order, implode(', ', $books), $quantity, $price);
            return $order;
        } catch (\Throwable $th) {
            Log::error(["createOrder" => $th->getMessage()]);
        }
    }

    private function updateOrder($order_id, $status)
    {
        try {
            if (!empty($status) && !empty($order_id)) {
                $order = ModelsOrder::where('order_payment_id', $order_id)->first();
                if (!empty($order)) {
                    $order->state = $status;
                    $order->save();

                    if ($order->state === 'paid') {
                        $this->verifyPayment($order_id);
                    }
                }
            }
        } catch (\Throwable $th) {
            Log::error(["updateOrder" => $th->getMessage()]);
        }
    }

    private function verifyPayment($order)
    {
        try {

            $order = ModelsOrder::where('order_payment_id', $order)->first();

            if ($order->state === 'paid') {

                $ids = explode(', ', $order->books);

                foreach ($ids as $id) {

                    $cart = Cart::where('id', $id)->first();
                    $this->user_id = $cart->user_id;
                    $doc = Doctor::where('user_id',$cart->user_id)->first();
                    $book = BookSale::where('id',$cart->book_sale_id)->first();

                    $purchased = new PurchasedBook();
                    $purchased->user_id = $cart->user_id;
                    $purchased->book_sale_id = $cart->book_sale_id;
                    $purchased->doctor_id = $doc->id;
                    $purchased->order_id = $order->order_payment_id;
                    $purchased->price = $book->price;
                    $purchased->save();

                    $this->points += $book->points;

                    $this->books_email[] = $cart->book_sale_id;

                    $cart->delete();
                }

                $user = User::find($this->user_id);

                $doctor = Doctor::where('user_id',$user->id)->first();
                
                PaymentService::updatedPointsDoctorService($doctor ,$this->points);

                Mail::to($user->email)->send(new SendBooksMail($this->books_email,$doctor));
            }
            
        } catch (\Throwable $th) {
            Log::error([
                'funcion' => 'verifyPayment',
                'message' => $th->getMessage(),
                'line' => $th->getLine()
               ]);
        } catch (Swift_TransportException $e) {
            Log::error([
                'funcion' => 'verifyPayment',
                'email' => $user->email,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
               ]);
        }
    }


    private function registerOrder($order, $books, $quantity, $price)
    {
        try {
            $orders = new ModelsOrder();
            $orders->order_payment_id = $order->id;
            $orders->items = $quantity;
            $orders->books = $books;
            $orders->total = $this->price;
            $orders->save();
        } catch (\Throwable $th) {
            Log::error(["registerOrder" => $th->getMessage()]);
        }
    }
}
