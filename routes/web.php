<?php

use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

//Route::get('/empleados', function () {
//    return view('empleados.index');
//});

//Route::get('empleado/create', [EmpleadoController::class,'create']);

Route::resource('empleados', EmpleadoController::class)->middleware('auth');
Auth::routes(['register'=>false, 'reset' =>false]);

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

//cuando el usuario se loguee busca controlardor y busca la clase index para ejecutarla
Route::group(['middleware'=>'auth'], function () {
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});
