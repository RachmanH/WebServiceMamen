<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DatamahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $data = Mahasiswa::paginate(10);

        // Cek apakah client minta XML
        if (str_contains($request->header('Accept'), 'application/xml')) {

            $xml = new \SimpleXMLElement('<mahasiswa_list/>');

            foreach ($data as $mhs) {
                $node = $xml->addChild('mahasiswa');
                $node->addChild('id', $mhs->id);
                $node->addChild('nim', $mhs->nim);
                $node->addChild('nama', $mhs->nama);
                $node->addChild('email', $mhs->email); // ✅ sesuai model
                $node->addChild('prodi', $mhs->prodi); // ✅ ganti dari jurusan
                $node->addChild('created_at', $mhs->created_at);
            }

            return response($xml->asXML(), 200)
                ->header('Content-Type', 'application/xml');
        }

        // Default JSON
        return response()->json([
            'data' => $data
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $data = Mahasiswa::find($id);

        // ❌ Handle kalau data tidak ditemukan
        if (!$data) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        // ✅ Jika client minta XML
        if (str_contains($request->header('Accept'), 'application/xml')) {

            $xml = new \SimpleXMLElement('<mahasiswa/>');

            $xml->addChild('id', $data->id);
            $xml->addChild('nim', $data->nim);
            $xml->addChild('nama', $data->nama);
            $xml->addChild('email', $data->email);
            $xml->addChild('prodi', $data->prodi);
            $xml->addChild('created_at', $data->created_at);

            return response($xml->asXML(), 200)
                ->header('Content-Type', 'application/xml');
        }

        // ✅ Default JSON
        return response()->json([
            'data' => $data
        ], 200);
    }
}
