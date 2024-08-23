<?php

use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PayController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SaleController;
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
Route::get('/traer/usuarios',[UsuarioController::class,'usuarios']);
Route::get('/clasificacion',[ClasificacionController::class,'index']);
Route::get('/clasificacion-book',[ClasificacionController::class,'clasificacionBook']);
Route::get('/especialidades',[ApiController::class,'especialidad']);
Route::get('/codigo/postal',[ApiController::class,'codigoPostal']);
Route::get('/show/clientes',[ApiController::class,'clientes']);
Route::get('/show/reporte/doctores',[ApiController::class,'doctores']);
Route::get('/mostrar/folio',[ApiController::class,'folio']);
Route::get('/validar/postal',[ApiController::class,'validatePostal']);

Route::get('/mostrar/datos/slug',[ApiController::class,'getDatosSlug']);

Route::get('/mostrar/logo/slug',[ApiController::class,'getLogo']);

Route::get('/mostrar/datos/doctor/{folio}',[ApiController::class,'getDatosDoctor']);
Route::get('/mostrar/nombre/doctor/{folio}',[ApiController::class,'getNombreDoctor']);

Route::get('/validacion/descargas/{id}',[ApiController::class,'validacionDescarga']);

//VENTAS
Route::get('/catalog/sale/books',[SaleController::class,'showBooks']);
Route::post('/sale/book/create',[SaleController::class,'createBook']);
Route::get('/catalog/category/books',[SaleController::class,'categoryBooks']);
//MARKETPLACE
Route::get('/catalog/categories/marketplace',[CategoryController::class,'categoriesMarketplace']);
Route::get('/catalog/books/marketplace',[BooksController::class,'BooksMarketplace']);
Route::post('/add/product/{book}',[BooksController::class,'addBooksCart']);
Route::get('/info/cart/{user}',[CartController::class,'getCart']);
Route::get('/catalog/products/{user}',[CartController::class,'catalogCart']);
Route::post('/delete/product/{id}',[CartController::class,'deleteProduct']);
Route::get('/information/doctor/{id}',[DoctorController::class,'informationDoctor']);
//PAYMENT
Route::post('/process/payment/{id}',[PayController::class,'processPay']);

//books doctor
Route::get('/books/doctor/{id}',[DoctorController::class,'getBooksDoctor']);
Route::get('/infor/doctor/{id}',[DoctorController::class,'getInfoDoctor']);
Route::get('/editar/doctor/{uuid}',[DoctorController::class,'editarDoctor']);
Route::post('/update/doctor/{uuid}',[DoctorController::class,'updateDoctor']);
Route::get('/send/message',[DoctorController::class,'sendMessagePaciente']);
Route::get('/send/email',[DoctorController::class,'sendEmailPaciente']);
Route::get('/show/pacientes/{uuid}',[DoctorController::class,'getPacientesDoctor']);
Route::delete('/delete/book/{id}',[DoctorController::class,'deleteBook']);
Route::get('/get/book/{uuid}',[DoctorController::class,'getBook']);
Route::post('/update/book/{uuid}',[DoctorController::class,'updateBook']);
Route::get('/categories/show',[CategoryController::class,'showCategories']);
Route::post('/delete/categories/{category}',[CategoryController::class,'deleteCategories']);
Route::get('/categories/edit/{id}',[CategoryController::class,'editCategories']);
Route::post('/categories/update/{id}',[CategoryController::class,'updateCategory']);
Route::post('/category/create',[CategoryController::class,'createCategory']);
Route::get('/validate/email',[ApiController::class,'validateEmail']);
Route::get('/validate/phone',[ApiController::class,'validatePhone']);
Route::get('/validate/book/{id}',[ApiController::class,'validateBook']);
Route::get('/validate/cedula',[ApiController::class,'validateCedula']);
Route::post('/delete/book',[ApiController::class,'deleteBookSale']);
Route::get('/show/uuid/{id}',[ApiController::class,'getUuidDoctor']);
Route::get('/validate/buy/book',[ApiController::class,'validateBuyBook']);

//reportes
Route::get('/report/books/doctor',[ReportController::class,'reportBooksDoctor']);
Route::get('/report/books/paciente',[ReportController::class,'reportBooksPaciente']);
Route::get('/show/reporte/conamege',[ReportController::class,'reporteConamege']);
Route::get('/show/reporte/ventas',[ReportController::class,'reporteVentas']);


Route::post('/webhook', [PayController::class,'confirmationConekta']);
