<?php

namespace App\Http\Controllers\Api;

use FPDF;
use Aws\S3\S3Client;
use setasign\Fpdi\Fpdi;
use App\Models\BookSale;
use App\Models\Category;
use Illuminate\Support\Str;
use Aws\Lambda\LambdaClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Owenoj\PDFPasswordProtect\Facade\PDFPasswordProtect;


class SaleController extends Controller
{
    public function showBooks(Request $request)
    {

        try {
            $filtro = $request->buscador;
            $books = BookSale::where('name', 'LIKE', '%' . $filtro . '%')
                ->whereHas('category', function ($query) use ($filtro) {
                    $query->orWhere('name', 'LIKE', '%' . $filtro . '%');
                })
                ->with('category')
                ->paginate(10);
            return response()->json($books);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function createBook(Request $request)
    {
        try {
            //CREAR PASSWORD
            $password = rand(1111111111, 9999999999);

            //CREAR IMAGEN
            $image = $request->file('image');
            $nameImage = 'books/' . Str::uuid() . "." . $image->extension();
            Storage::disk('s3')->put($nameImage, file_get_contents($image));
            $urlImage = Storage::disk('s3')->url($nameImage);

            //CREAR PDF
            $pdf = $request->file('pdf');

            $name = Str::uuid() . "." . $pdf->extension();

            $pdf->move(public_path('archivos'), $name);

            $namePdf = 'pdf/' . $name;

            PDFPasswordProtect::encrypt(public_path('archivos/' . $name), public_path('archivos/' . $name), $password);

            Storage::disk('s3')->put($namePdf, file_get_contents(public_path('archivos/' . $name)));

            $urlPdf = Storage::disk('s3')->url($namePdf);

            BookSale::create([
                'uuid' => Str::uuid(),
                'name' => $request->name,
                'image' => $urlImage,
                'category_id' => $request->category_id,
                'author' => $request->author,
                'description' => $request->description,
                'price' => $request->price,
                'points' => $request->points,
                'pdf' => $urlPdf,
                'password' => $password,
                'active' => $request->active,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => true,
                'message' => 'Hubo un error al registrar el libro , comuniquese con sistemas.'
            ]);
        }
    }

    public function categoryBooks()
    {
        try {
            return response()->json(Category::all());
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
