<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
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

Route::middleware('auth:sanctum', 'admin')->group(function () {
    Route::post('/currencies', [CurrencyController::class, 'store']);
    Route::get('/currencies/date/{date}', [CurrencyController::class, 'getCurrenciesOnDate']);
    Route::get('/currencies/date/{date}/currency/{currency}', [CurrencyController::class, 'getCurrencyOnDate']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
