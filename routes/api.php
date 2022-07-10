<?php

use App\Http\Controllers\AutfKontroler;
use App\Http\Controllers\SatKontroler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AutfKontroler::class, 'register']);
Route::post('login', [AutfKontroler::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('novi-sat', [SatKontroler::class, 'dodajSat']);
});
