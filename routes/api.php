<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:api'])->prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::get('me', [AuthController::class, 'check'])->middleware('auth:sanctum');
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::middleware('auth:sanctum')->apiResource('user', UserController::class);

    Route::middleware('auth:sanctum')->prefix('worker')->group(function () {
        Route::apiResource('jabatan', JabatanController::class);
        Route::apiResource('mapel', MataPelajaranController::class);
        Route::apiResource('pegawai', PegawaiController::class);
    });

    Route::get('/', function () {
        date_default_timezone_set('Asia/Jakarta');

        return response()->json([
            'status' => 'online',
            'date' => date('Y-m-d H:i:s'),
        ], 200);
    });
});
