<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\KeuanganApiController;
use App\Http\Middleware\MiddlewareApi;

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

Route::post('login', [AuthApiController::class, 'login']);
Route::post('inquiry', [KeuanganApiController::class, 'inquiry']);
Route::get('inquiry', [KeuanganApiController::class, 'inquiry']);
// Route::get('inquiry/{id}', [KeuanganApiController::class, 'inquiry1']);
Route::post('payment', [KeuanganApiController::class, 'payment']);
Route::post('reversal', [KeuanganApiController::class, 'reversal']);


Route::group(['middleware' => [MiddlewareApi::class]], function () {
    Route::post('tagihan', [KeuanganApiController::class, 'tagihan']);
    Route::post('transaksi-spp', [KeuanganApiController::class, 'transaksiSpp']);
    Route::post('pembayaran', [KeuanganApiController::class, 'pembayaran']);
    Route::post('saldo', [KeuanganApiController::class, 'saldo']);
    Route::post('select-tagihan', [KeuanganApiController::class, 'selectedTagihan']);
});
