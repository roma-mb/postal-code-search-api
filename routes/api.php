<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostalCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
Route::get('/login/verify', [LoginController::class, 'verify'])->name('auth.verify');

Route::middleware('jwt.auth')->group(function () {
    Route::get('/list', [PostalCodeController::class, 'index'])->name('postal.index');
    Route::get('/list/{code}', [PostalCodeController::class, 'show'])->name('postal.show');
});
