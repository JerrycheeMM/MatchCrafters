<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/transactions', [App\Http\Controllers\TransactionPageController::class, 'index'])->name('transactions.page.index');
    Route::get('/transactions/export', [App\Http\Controllers\TransactionPageController::class, 'export'])->name('transactions.page.export');
    Route::get('/approve/{transactionId}', [App\Http\Controllers\TransactionPageController::class, 'approve'])->name('transactions.page.approve');
    Route::get('/reject/{transactionId}', [App\Http\Controllers\TransactionPageController::class, 'reject'])->name('transactions.page.reject');
});


