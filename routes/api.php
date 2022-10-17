<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ClasificacionController;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/traer/book',[ApiController::class,'libros']);
Route::get('/ligas',[ApiController::class,'ligas']);
Route::get('/libro',[LigaController::class,'zonaDescarga']);
Route::get('/usuarios',[UsuarioController::class,'usuarios']);
Route::get('/clasificacion',[ClasificacionController::class,'index']);
Route::get('/clasificacion-book',[ClasificacionController::class,'clasificacionBook']);
Route::get('/especialidades',[ApiController::class,'especialidad']);
Route::get('/codigo/postal',[ApiController::class,'codigoPostal']);
Route::get('/show/clientes',[ApiController::class,'clientes']);
Route::get('/show/reporte/doctores',[ApiController::class,'doctores']);
Route::get('/mostrar/folio',[ApiController::class,'folio']);

Route::get('/mostrar/datos/slug',[ApiController::class,'getDatosSlug']);

Route::get('/mostrar/logo/slug',[ApiController::class,'getLogo']);

Route::get('/mostrar/datos/doctor/{folio}',[ApiController::class,'getDatosDoctor']);
Route::get('/mostrar/nombre/doctor/{folio}',[ApiController::class,'getNombreDoctor']);

Route::get('/validacion/descargas/{id}',[ApiController::class,'validacionDescarga']);


