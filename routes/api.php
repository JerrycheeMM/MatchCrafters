<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CreditNotificationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/credit-notification', [CreditNotificationController::class, 'store']); // this is for one time usage in postman
});

Route::group(['middleware' => ['auth:api']], function() {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/transaction-qr-link', [UserController::class, 'qrLink']); // one time usage only
    });

    Route::prefix('cards')->group(function () {
        Route::get('/', [CardController::class, 'index']);
        Route::post('', [CardController::class, 'store']);
        Route::post('{cardId}/update', [CardController::class, 'update']);
    });

    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::post('{transactionId}/update', [TransactionController::class, 'update']);
        Route::post('/receiver/{accountNumber}', [TransactionController::class, 'store']);
    });
});




