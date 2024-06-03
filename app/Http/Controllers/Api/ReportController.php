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
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            $purchasedBooks = PurchasedBook::with(['user.doctorReport.especialidad', 'book', 'user.doctorReport.sepomex'])
                ->where(function ($query) use ($filtro) {
                    $query->whereHas('user', function ($userQuery) use ($filtro) {
                        $userQuery->where('name', 'LIKE', '%' . $filtro . '%');
                    })
                        ->orWhereHas('book', function ($bookQuery) use ($filtro) {
                            $bookQuery->where('name', 'LIKE', '%' . $filtro . '%');
                        });
                })
                ->when($startDate, function ($query, $startDate) {
                    return $query->where('created_at', '>=', $startDate);
                })
                ->when($endDate, function ($query, $endDate) {
                    return $query->where('created_at', '<=', $endDate);
                })->paginate(10);

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
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            $cliente = ClientBook::with(['book', 'client.user', 'doctor', 'client.sepomex'])
                ->where(function ($query) use ($filtro) {
                    $query->orWhereHas('book', function ($query) use ($filtro) {
                        $query->where('name', 'LIKE', "%$filtro%");
                    })
                        ->orWhereHas('client', function ($query) use ($filtro) {
                            $query->where('name', 'LIKE', "%$filtro%");
                        });
                })
                ->when($startDate, function ($query, $startDate) {
                    return $query->where('created_at', '>=', $startDate);
                })
                ->when($endDate, function ($query, $endDate) {
                    return $query->where('created_at', '<=', $endDate);
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

    public function reporteConamege(Request $request)
    {
        try {
            $filtro = $request->buscador;
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $books = ClientBook::with(['book', 'client.sepomex', 'doctor.especialidad', 'doctor.sepomex', 'reportBooksMonth'])
                ->withCount('reportBooksMonth as total_books_month')
                ->withCount('reportBooksTotal as total_books_total')
                ->when(!empty($startDate), function ($query) use ($startDate) {
                    return $query->where('created_at', '>=', $startDate);
                })
                ->when(!empty($endDate), function ($query) use ($endDate) {
                    return $query->where('created_at', '<=', $endDate);
                })
                ->whereHas('doctor', function ($query) use ($filtro) {
                    $query->where('nombres', 'LIKE', '%' . $filtro . '%')
                          ->orWhere('apellidos', 'LIKE', '%' . $filtro . '%');
                })
                ->paginate(10);
            return response()->json($books);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }


    public function reporteVentas(Request $request)
    {
        try {

            $filtro = $request->buscador;
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            $medicos = PurchasedBook::whereHas('doctor', function ($query) use ($filtro) {
                $query->where('nombres', 'LIKE', '%' . $filtro . '%')
                      ->orWhere('apellidos', 'LIKE', '%' . $filtro . '%');
            })
            ->when(!empty($startDate), function ($query) use ($startDate) {
                return $query->where('created_at', '>=', $startDate);
            })
            ->when(!empty($endDate), function ($query) use ($endDate) {
                return $query->where('created_at', '<=', $endDate);
            })
            ->orWhere('order_id','LIKE','%'.$filtro.'%')
            ->with(['book', 'doctor'])
            ->orderBy('created_at','desc')
            ->paginate(8);
            

            return response()->json($medicos);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function exportBookDoctor(Request $request)
    {
        $startDate = $request->input('starDate');
        $endDate = $request->input('endDate');
        return Excel::download(new BookDoctor($startDate, $endDate), 'Reporte Libros Doctor.xlsx');
    }

    public function exportBookPaciente(Request $request)
    {
        $startDate = $request->input('starDate');
        $endDate = $request->input('endDate');
        return Excel::download(new BookPaciente($startDate, $endDate), 'Reporte Libros Paciente.xlsx');
    }

    public function exportBookVentas(Request $request)
    {
        $startDate = $request->input('starDate');
        $endDate = $request->input('endDate');
        return Excel::download(new ReportVentas($startDate, $endDate), 'Reporte Ventas.xlsx');
    }
}
