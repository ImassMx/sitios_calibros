<?php

namespace App\Http\Controllers\Api;

use App\Models\ClientBook;
use App\Exports\BookDoctor;
use Illuminate\Http\Request;
use App\Exports\BookPaciente;
use App\Exports\ReportVentas;
use App\Models\PurchasedBook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportController extends Controller
{
    public function reportBooksDoctor(Request $request)
    {
        try {

            $filtro = $request->buscador;
            $purchasedBooks = PurchasedBook::with(['user.doctorReport.especialidad', 'book', 'user.doctorReport.sepomex'])
            ->where(function ($query) use ($filtro) {
                $query->whereHas('user', function ($userQuery) use ($filtro) {
                    $userQuery->where('name', 'LIKE', '%' . $filtro . '%');
                })
                    ->orWhereHas('book', function ($bookQuery) use ($filtro) {
                        $bookQuery->where('name', 'LIKE', '%' . $filtro . '%');
                    });
            })
                ->paginate(10);

            $purchasedBooks->each(function ($purchasedBook) {
                $purchasedBook->loadCount(['clientBook as total_downloads' => function ($query) {
                    $query->select(DB::raw('SUM(donwloads)'));
                }]);
            });

            return response()->json($purchasedBooks);
        } catch (\Throwable $th) {
            Log::error($th);
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
            $cliente = ClientBook::with(['book', 'client.user', 'doctor', 'client.sepomex'])
                ->whereHas('book', function ($query) use ($filtro) {
                    $query->where('name', 'LIKE', "%$filtro%");
                })
                ->orWhereHas('client', function ($query) use ($filtro) {
                    $query->where('name', 'LIKE', "%$filtro%");
                })
                ->paginate(10);

            return response()->json($cliente);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function reporteConamege(Request $request){
        try {
            $filtro = $request->buscador;
            
            $books = ClientBook::with(['book','client.sepomex','doctor.especialidad','doctor.sepomex','reportBooksMonth'])
                     ->withCount('reportBooksMonth as total_books_month')
                     ->withCount('reportBooksTotal as total_books_total')
                     ->paginate(10);
            return response()->json($books);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }


    public function reporteVentas(Request $request){
        try {

            $filtro = $request->buscador;

            $medicos = PurchasedBook::whereHas('doctor', function ($query) use ($filtro) {
                $query->where('nombres', 'LIKE', '%' . $filtro . '%')
                      ->orWhere('apellidos', 'LIKE', '%' . $filtro . '%');
            })
            ->with(['book', 'doctor'])->paginate(8); 

            return response()->json($medicos);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function exportBookDoctor()
    {
        return Excel::download(new BookDoctor, 'Reporte Libros Doctor.xlsx');
    }

    public function exportBookPaciente()
    {
        return Excel::download(new BookPaciente, 'Reporte Libros Paciente.xlsx');
    }

    public function exportBookVentas(){
        return Excel::download(new ReportVentas, 'Reporte Ventas.xlsx');

    }
}
