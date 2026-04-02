<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DosenController;
use App\Http\Controllers\Api\MahasiswaController;
use App\Http\Controllers\Api\DatamahasiswaController;
use App\Http\Controllers\Api\HitungController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::get('/users', [UserController::class, 'index']);
Route::apiResource('dosen', DosenController::class);
Route::apiResource('mahasiswa', MahasiswaController::class);
// Route::apiResource('datamahasiswa', DatamahasiswaController::class);
// Endpoint GET
Route::get('datamahasiswa', [DatamahasiswaController::class, 'index']);
// Endpoint POST
Route::post('datamahasiswa', [DatamahasiswaController::class, 'store']);

Route::get('datamahasiswa/{nim}', [DatamahasiswaController::class, 'show']);

Route::post('hitung-luas', [HitungController::class, 'hitungLuas']);
