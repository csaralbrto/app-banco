<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TransactionController;

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
    return view('index');
})->name('home');


/* Ruta de Cuentas */

Route::resource('cuentas', AccountController::class)->only([
    'index', 'create', 'store', 'show', 'update', 'destroy'
]);


/* Ruta de Transferencias */

Route::resource('transferencias', TransferController::class)->only([
    'index', 'create', 'store', 'show', 'update', 'destroy'
]);

Route::get('/transferencias/crearTransferencia/{cedula}', [TransferController::class, 'createTransferencias'])->name('transferencias.crearTransferencia');


/* Ruta de Reportest */

Route::resource('reportes', TransactionController::class)->only([
    'index', 'create', 'store', 'update', 'destroy'
]);
Route::get('/reportes/filtrar/', [TransactionController::class, 'filters'])->name('reportes.filters');
Route::get('/reportes/downloadCSV', [TransactionController::class, 'filters'])->name('reportes.filters');