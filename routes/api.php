<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::group(['middleware' => ['auth:api']], function() {
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::prefix('cards')->group(function () {
        Route::get('/', [CardController::class, 'index']);
        Route::post('', [CardController::class, 'store']);
        Route::post('{cardId}/update', [CardController::class, 'update']);
    });

});




