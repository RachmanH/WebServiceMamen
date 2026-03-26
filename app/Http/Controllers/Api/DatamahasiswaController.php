<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DatamahasiswaController extends Controller
{
    // Endpoint GET: Mengambil Data
    public function index()
    {
        $data = [
            ['nim' => '2401001', 'nama' => 'Budi Utomo', 'prodi' =>
            'Informatika'],
            ['nim' => '2401002', 'nama' => 'Siti Aminah', 'prodi' =>
            'Sistem Informasi']
        ];
        return response()->json([
            'success' => true,
            'message' => 'Daftar Mahasiswa Berhasil Diambil',
            'data' => $data
        ], 200);
    }
    // Endpoint POST: Menerima Data Baru
    public function store(Request $request)
    {
        // Validasi Request
        $request->validate([
            'nim' => 'required',
            'nama' => 'required'
        ]);
        // Simulasi menyimpan data
        return response()->json([
            'success' => true,
            'message' => 'Data Mahasiswa Berhasil Disimpan!',
            'data' => $request->all() // Mengembalikan apa yang dikirim client
        ], 201); // Status 201: Created
    }
}
