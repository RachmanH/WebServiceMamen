<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar + eager loading
        $query = Jadwal::with([
            'dosen',
            'matakuliah',
            'ruang',
            'mahasiswas'
        ]);

        // 🔥 FILTER NIDN (WAJIB PRAKTIKUM)
        if ($request->nidn) {
            $query->whereHas('dosen', function ($q) use ($request) {
                $q->where('nidn', $request->nidn);
            });
        }

        $jadwal = $query->get();

        // 🔥 HANDLE XML
        if ($request->header('Accept') == 'application/xml') {

            // 🔥 HANDLE DATA KOSONG (PENTING)
            if ($jadwal->isEmpty()) {
                $xml = new \SimpleXMLElement('<akademik_response/>');
                $xml->addChild('status', 'success');
                $xml->addChild('message', 'Data tidak ditemukan');

                return response($xml->asXML(), 200)
                    ->header('Content-Type', 'application/xml');
            }

            // Root XML
            $xml = new \SimpleXMLElement('<akademik_response/>');
            $xml->addChild('status', 'success');

            $list = $xml->addChild('daftar_jadwal');

            foreach ($jadwal as $j) {
                $item = $list->addChild('pertemuan');

                $item->addChild('hari', $j->hari);
                $item->addChild('waktu', $j->jam_mulai);

                // 🔹 Matakuliah
                $mk = $item->addChild('matakuliah');
                $mk->addChild('kode', $j->matakuliah->kode_mk ?? '-');
                $mk->addChild('nama', $j->matakuliah->nama_mk ?? '-');

                // 🔹 Dosen (bonus biar lebih lengkap)
                $dsn = $item->addChild('dosen');
                $dsn->addChild('nidn', $j->dosen->nidn ?? '-');
                $dsn->addChild('nama', $j->dosen->nama ?? '-');

                // 🔹 Ruang (bonus)
                $ruang = $item->addChild('ruang');
                $ruang->addChild('nama', $j->ruang->nama_ruang ?? '-');
                $ruang->addChild('gedung', $j->ruang->gedung ?? '-');

                // 🔹 Peserta (nested looping)
                $peserta = $item->addChild('peserta_kuliah');

                foreach ($j->mahasiswas as $mhs) {
                    $m = $peserta->addChild('mahasiswa');
                    $m->addChild('nim', $mhs->nim);
                    $m->addChild('nama', $mhs->nama);
                }
            }

            return response($xml->asXML(), 200)
                ->header('Content-Type', 'application/xml');
        }

        // 🔥 DEFAULT JSON
        return response()->json([
            'status' => 'success',
            'data' => $jadwal
        ]);
    }
}
