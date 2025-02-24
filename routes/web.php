<?php

use App\Http\Controllers\Api\DonwloadController;
use App\Http\Controllers\Api\PayController;
use App\Http\Controllers\Api\ReportController;
use App\Models\Estado;
use App\Models\Clasificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LibrosController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClasificacionController;
use App\Http\Controllers\PaymentController;

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

//MARKETPLACE
Route::get('/marketplace', [App\Http\Controllers\MarketplaceController::class,'index'])->middleware('auth')->name('marketplace.inicio');
Route::get('/marketplace/detalle/{uuid}', [App\Http\Controllers\MarketplaceController::class,'detalleLibro'])->middleware('auth');
Route::get('/marketplace/carrito', [App\Http\Controllers\MarketplaceController::class,'carrito'])->middleware('auth');
Route::get('/marketplace/pago', [App\Http\Controllers\MarketplaceController::class,'pago'])->middleware('auth');
Route::get('/marketplace/compra', [App\Http\Controllers\MarketplaceController::class,'compra'])->middleware('auth');
Route::get('/marketplace/pasarela', [App\Http\Controllers\MarketplaceController::class,'pasarela'])->middleware('auth');
Route::get('/payment/confirmation', [App\Http\Controllers\MarketplaceController::class,'successPayment'])->middleware('auth');
Route::get('/payment/failure', [App\Http\Controllers\MarketplaceController::class,'errorPayment'])->middleware('auth');
Route::get('/landing', [App\Http\Controllers\MarketplaceController::class,'landing']);
Route::get('/landing2', [App\Http\Controllers\MarketplaceController::class,'landing2']);



Route::get('/contacto', [App\Http\Controllers\HomeController::class, 'contacto']);

Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::post('/send/email',[ApiController::class,'sendEmail'])->name('send.email');

Route::post('/create/book', [LibrosController::class,'store']);
Route::post('/request/liga', [LigaController::class,'store']);
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
Route::get('/perfil/{id}',[ClienteController::class,'zonaDescarga'])->name('zona.descarga')->middleware('auth');
Route::post('/descarga/{id}',[LigaController::class,'viewDescarga']);
Route::get('/liga/{id}/edit',[LigaController::class,'edit']);
Route::post('/update/liga/{id}',[LigaController::class,'update']);
Route::post('/delete-liga/{id}',[LigaController::class,'destroy']);

//REGISTRO CLIENTE
Route::get('/cliente',[ClienteController::class,'index']);
Route::post('/registro/paciente',[ClienteController::class,'store'])->name('cliente.registrar');
Route::post('/logout/cliente',[LogoutController::class,'cerrarSesionCliente'])->name('logout.cliente');
Route::get('/login',[ClienteController::class,'index'])->name('login.cliente');
Route::post('/login',[ClienteController::class,'login'])->name('post.login');
Route::get('/registrar/paciente',[ClienteController::class,'registro'])->name('registro.cliente');
//USUARIOS
Route::post('/usuario/create',[UsuarioController::class,'store']);
Route::get('/usuario/{id}/edit',[UsuarioController::class,'edit']);
Route::post('/usuario/{id}',[UsuarioController::class,'update']);
Route::delete('/delete-user/{id}',[UsuarioController::class,'destroy']);
//DOCTOR
Route::get('/registrar/doctor',[DoctorController::class,'index']);
Route::post('/request/registrar/doctor',[DoctorController::class,'store']);
Route::get('/validar/email/doctor',[DoctorController::class,'ValidarEmail']);
Route::get('/validar/phone/doctor',[DoctorController::class,'ValidarPhone']);

//EXPORT EXCEL
Route::get('/export/book',[LibrosController::class,'exportBook'])->name('export.excel');
Route::get('/export/doctor',[DoctorController::class,'exportDoctor'])->name('export.doctor');
Route::get('/export/cliente',[ClienteController::class,'exportClient'])->name('export.cliente');
Route::get('/export/books/doctor',[ReportController::class,'exportBookDoctor']);
Route::get('/export/books/paciente',[ReportController::class,'exportBookPaciente']);
Route::get('/export/books/ventas',[ReportController::class,'exportBookVentas']);

//ENVIO SMS DOCTOR
Route::get('/zona/doctor/{uuid}',[DoctorController::class,'zonaDoctor'])->name('zona.doctor')->middleware('auth');
Route::get('/editar/doctor/{uuid}',[DoctorController::class,'editarDoctor'])->name('editar.doctor')->middleware('auth');
Route::get('/pacientes/doctor/{uuid}',[DoctorController::class,'pacientesDoctor'])->name('paciente.zona.doctor')->middleware('auth');
Route::get('/donwload/book/paciente/{uuid}',[DoctorController::class,'donwloadBook']);
Route::get('/donwload/book/doctor/{book}',[DonwloadController::class,'donwloadBookDoctor']);


Route::get('/login/doctor',[DoctorController::class,'viewDoctor'])->name('login.doctor');

Route::get('/enviar/sms/doctor/{telefono}/{folio}',[DoctorController::class,'smsEnvia']);

Route::post('/zona/login/doctor',[DoctorController::class,'ZonaLoginDoctor'])->name('login.zona.doctor');
Route::post('/logout/doctor',[LogoutController::class,'cerrarSesionDoctor'])->name('logout.doctor');

//DESCARGAR QR
Route::get('/download/qr/{uuid}/{name}',[LigaController::class,'donwload']);


Route::get('/admin/{any}', function () {
    return view('layouts.app');
})->where('any', '.*')->middleware(['auth']);


Route::get('{any}', function () {
    return view('home');
})->where('any', '.*');