<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HitungController extends Controller
{
    public function hitungLuas(Request $request)
    {
        // Validasi
        $request->validate([
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric'
        ]);

        $panjang = $request->panjang;
        $lebar = $request->lebar;

        $luas = $panjang * $lebar;

        return response()->json([
            'success' => true,
            'message' => 'Perhitungan luas berhasil',
            'data' => [
                'panjang' => $panjang,
                'lebar' => $lebar,
                'luas' => $luas
            ]
        ], 200);
    }
}
