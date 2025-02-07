<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
   Route::post('google/login',[\App\Http\Controllers\LoginController::class,'loginWithGoogle']);
});

Route::post('lighthouse',[\App\Http\Controllers\LighthouseController::class,'getScore']);
