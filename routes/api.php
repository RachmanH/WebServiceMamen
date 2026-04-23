<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DosenController;
use App\Http\Controllers\Api\MahasiswaController;
use App\Http\Controllers\Api\DatamahasiswaController;
use App\Http\Controllers\Api\HitungController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\MatakuliahController;
use App\Http\Controllers\Api\RuangController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::get('/users', [UserController::class, 'index']);
Route::apiResource('dosen', DosenController::class);
Route::apiResource('mahasiswa', MahasiswaController::class);
Route::apiResource('matakuliah', MatakuliahController::class);
Route::apiResource('ruang', RuangController::class);
// Route::apiResource('datamahasiswa', DatamahasiswaController::class);
// Endpoint GET
Route::get('datamahasiswa', [DatamahasiswaController::class, 'index']);
Route::post('datamahasiswa', [DatamahasiswaController::class, 'store']);

Route::get('datamahasiswa/{nim}', [DatamahasiswaController::class, 'show']);
Route::get('datamahasiswa/{id}', [DatamahasiswaController::class, 'show']);

Route::get('jadwal', [JadwalController::class, 'index']);
Route::post('jadwal', [JadwalController::class, 'store']);
Route::get('jadwal/{id}', [JadwalController::class, 'show']);
Route::put('jadwal/{id}', [JadwalController::class, 'update']);
Route::delete('jadwal/{id}', [JadwalController::class, 'destroy']);

Route::post('hitung-luas', [HitungController::class, 'hitungLuas']);
