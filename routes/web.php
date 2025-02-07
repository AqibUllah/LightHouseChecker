<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
    // Catch-all route for Vue.js



Route::prefix('auth')->group(function () {
    Route::get('google',[LoginController::class,'redirectToGoogle']);
    Route::get('google/callback', [LoginController::class, 'googleLogin']);
});


Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');
