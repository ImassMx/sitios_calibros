<?php

use App\Http\Controllers\ClasificacionController;
use App\Models\Estado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LibrosController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\UsuarioController;
use App\Models\Clasificacion;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('home');
})->name('inicio');


Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::post('/create/book', [LibrosController::class,'store']);
Route::post('/liga', [LigaController::class,'store']);
Route::get('/admin/login',[LoginController::class,'index'])->name('login');
Route::post('/admin/login',[LoginController::class,'store']);
Route::post('/logout',[LogoutController::class,'store'])->name('logout');
//LIBROS
/* Route::get('crear-libros',[LibrosController::class,'crearLibros'])->name('crear.libros'); */
Route::get('/book/{id}/edit',[LibrosController::class,'show']);
Route::post('/book/{id}',[LibrosController::class,'update']);
Route::post('/des/{id}',[LibrosController::class,'desactivar']);
Route::post('/act/{id}',[LibrosController::class,'activar']);
Route::delete('/eliminar-libros/{id}',[LibrosController::class,'destroy']);
//LIGAS
Route::get('/descargas/{liga:slug}',[ClienteController::class,'zonaDescarga'])->name('zona.descarga');
Route::post('/descarga/{id}',[LigaController::class,'viewDescarga']);
Route::get('/liga/{id}/edit',[LigaController::class,'edit']);
Route::post('/liga/{id}',[LigaController::class,'update']);
Route::post('/delete-liga/{id}',[LigaController::class,'destroy']);

//REGISTRO CLIENTE
Route::get('/cliente',[ClienteController::class,'index']);
Route::post('/registro/cliente',[ClienteController::class,'store'])->name('cliente.registrar');
Route::post('/logout/cliente',[LogoutController::class,'cerrarSesionCliente'])->name('logout.cliente');
Route::get('/login',[ClienteController::class,'index'])->name('login.cliente');
Route::post('/login',[ClienteController::class,'login']);
Route::get('/registrar/cliente',[ClienteController::class,'registro'])->name('registro.cliente');
//USUARIOS
Route::post('/usuario/create',[UsuarioController::class,'store']);
Route::get('/usuario/{id}/edit',[UsuarioController::class,'edit']);
Route::post('/usuario/{id}',[UsuarioController::class,'update']);
Route::delete('/delete-user/{id}',[UsuarioController::class,'destroy']);
//DOCTOR
Route::get('/registrar/doctor',[DoctorController::class,'index']);
Route::post('/registrar-doctor',[DoctorController::class,'store']);
//CLASIFICACION
Route::post('clasificacion/create',[ClasificacionController::class,'store']);
Route::get('/clasificacion/{id}/edit',[ClasificacionController::class,'edit']);
Route::post('/clasificacion/{id}',[ClasificacionController::class,'update']);
Route::delete('/eleminiar-clasificacion/{id}',[ClasificacionController::class,'destroy']);
//EXPORT EXCEL
Route::get('/export/book',[LibrosController::class,'exportBook'])->name('export.excel');
Route::get('/export/doctor',[DoctorController::class,'exportDoctor'])->name('export.doctor');
Route::get('/export/cliente',[ClienteController::class,'exportClient'])->name('export.cliente');

/* Route::view('/{any}', 'home')
->middleware(['auth'])
->where('any','.*'); */

Route::get('/admin/{any}', function () {
    return view('layouts.app');
})->where('any', '.*')->middleware(['auth']);


Route::get('{any}', function () {
    return view('home');
})->where('any', '.*');
