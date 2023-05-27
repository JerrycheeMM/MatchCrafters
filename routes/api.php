<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{userId}', [UserController::class, 'show']);
    Route::post('', [UserController::class, 'store']);
    Route::delete('/{userId}', [UserController::class, 'destroy']);
    Route::post('/{userId}/update', [UserController::class, 'update']);
    Route::post('/{userId}/update-email', [UserController::class, 'updateEmail']);
    Route::post('/{userId}/password/change', [UserController::class, 'adminSendPasswordResetLink']);
});


