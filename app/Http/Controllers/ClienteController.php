<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Liga;
use App\Models\User;
use App\Models\Libro;
use App\Models\Doctor;
use App\Models\Estado;
use App\Models\Cliente;
use App\Models\ClientBook;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\ClientExport;
use App\Mail\PacienteWelcome;
use App\Models\BookSale;
use Illuminate\Support\Facades\DB;
use Facade\FlareClient\Http\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;


class ClienteController extends Controller
{
    private $uuid;

    public function index()
    {
        return view('auth-cliente.login');
    }

    public function store(Request $request) {

        try {

            $this->uuid = Str::uuid();
            $usuario = User::create([
                'name' => $request->nombre_paciente,
                'email' => $request->email,
                'password' => Hash::make($this->uuid),
                'celular' => $request->celular
            ])->assignRole('Cliente');

            $client =  Cliente::create([
                'user_id' => $usuario->id,
                'nombre_doctor' => $request->nombre_doctor,
                'folio' => $request->folio,
                'codigo_postal' => $request->codigo,
                'name' => $request->nombre_paciente,
                'uuid' => $this->uuid,
                'created_at' => date('d-m-Y')
            ]);

            $dominio = $request->getSchemeAndHttpHost();

            $request->merge(['password' => $this->uuid]);
            //Mail::to($request->email)->send(new PacienteWelcome($doctor->folio, $dominio));

            $doctor = Doctor::where('folio',$request->folio)->first();
            $book = BookSale::where('uuid',$request->book)->first();

            ClientBook::create([
                'cliente_id' => $client->id,
                'book_sale_id' => $book->id,
                'doctor_id' => $doctor->id,
                'donwloads' => 0
            ]);

            auth()->attempt($request->only('email', 'password'));
            
            return response()->json([
                'error' => false,
                'client_id' => $client->id
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'celular' => 'required|numeric|digits:10'
        ],[
            'celular.required' => 'El número es requerido.',
            'celular.numeric' => 'Debe ingresar un alor numérico.',
            'celular.digits' => 'El número debe ingresar 10 dígitos.'
        ]);

        $validator->validated();

        try {
            $user = User::where('celular', $request->celular)->with('cliente')->first();

            if (empty($user)) {
                return back()->with('mensaje', 'El número de celular no existe.');
            }

            $request->merge(['password' => $user->cliente->uuid]);

            if (!auth()->attempt($request->only(['celular', 'password']), $request->remember)) {
                return back()->with('mensaje', 'El número de celular es incorrecto');
            }

            return redirect()->route('zona.descarga', $user->cliente->id);
        } catch (\Throwable $th) {
            Log::info($th);
            return back()->with('mensaje', 'La liga no existe.');
        }
    }

    public function zonaDescarga($id)
    {
        $paciente = Cliente::where('id',$id)->with('user')->first();

        $books = ClientBook::where('cliente_id',$paciente->id)->with('book')->get();

        return view('principal.app', compact('paciente','books'));
    }

    public function registro(Request $request)
    {   
        $book = $request->book;
        $estados = Estado::all();
        return view('auth-cliente.register', compact('estados','book'));
    }

    public function exportClient(Request $request)
    {
        $startDate = $request->input('starDate');
        $endDate = $request->input('endDate');

        return Excel::download(new ClientExport($startDate,$endDate), 'Reporte Pacientes.xlsx');
    }
}
