<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function(){
    return response()->json(['message' => 'Welcome to POS API']);
});

Route::post('login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('me', [LoginController::class, 'me']);
    Route::apiResource('user', UserController::class);
});


