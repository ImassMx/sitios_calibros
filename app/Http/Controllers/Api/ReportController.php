<?php

namespace App\Http\Controllers\Api;

use App\Exports\BookDoctor;
use App\Exports\BookPaciente;
use App\Models\ClientBook;
use Illuminate\Http\Request;
use App\Models\PurchasedBook;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function reportBooksDoctor(Request $request)
    {
        try {
            Log::info("entra acá");
            $filtro = $request->buscador;
            $purchasedBooks = PurchasedBook::with(['user', 'book'])
                ->where(function ($query) use ($filtro) {
                    $query->whereHas('user', function ($userQuery) use ($filtro) {
                        $userQuery->where('name', 'LIKE', '%' . $filtro . '%');
                    })
                        ->orWhereHas('book', function ($bookQuery) use ($filtro) {
                            $bookQuery->where('name', 'LIKE', '%' . $filtro . '%');
                        });
                })
                ->paginate(10);

            return response()->json($purchasedBooks);
        } catch (\Throwable $th) {
            Log::info($th);
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function reportBooksPaciente(Request $request)
    {
        try {
            $filtro = $request->buscador;
            $cliente = ClientBook::with(['book', 'client','doctor'])
                ->whereHas('book', function ($query) use ($filtro) {
                    $query->where('name', 'LIKE', "%$filtro%");
                })
                ->orWhereHas('client', function ($query) use ($filtro) {
                    $query->where('name', 'LIKE', "%$filtro%");
                })
                ->paginate(10);

            return response()->json($cliente);
        } catch (\Throwable $th) {
            Log::info($th);
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function exportBookDoctor(){
        return Excel::download(new BookDoctor, 'Reporte Libros Doctor.xlsx');
    }

    public function exportBookPaciente(){
        return Excel::download(new BookPaciente, 'Reporte Libros Paciente.xlsx');

    }
}
