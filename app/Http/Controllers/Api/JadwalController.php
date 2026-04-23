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

    public function show($id)
    {
        $jadwal = Jadwal::with(['dosen', 'matakuliah', 'ruang', 'mahasiswas'])->find($id);
        if (!$jadwal) return response()->json(['message' => 'Not Found'], 404);
        return response()->json($jadwal, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'ruang_id' => 'required|exists:ruangs,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
        ]);

        // Cek bentrok: dosen mengajar di jam yang sama
        $bentrokDosen = Jadwal::where('dosen_id', $request->dosen_id)
            ->where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->exists();

        if ($bentrokDosen) {
            return response()->json(['message' => 'Jadwal bentrok - Dosen sudah mengajar di waktu yang sama'], 409);
        }

        // Cek bentrok: ruangan digunakan di jam yang sama
        $bentrokRuang = Jadwal::where('ruang_id', $request->ruang_id)
            ->where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->exists();

        if ($bentrokRuang) {
            return response()->json(['message' => 'Jadwal bentrok - Ruangan sudah digunakan di waktu yang sama'], 409);
        }

        $jadwal = Jadwal::create($request->all());
        return response()->json($jadwal, 201);
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::find($id);
        if (!$jadwal) return response()->json(['message' => 'Not Found'], 404);

        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'ruang_id' => 'required|exists:ruangs,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
        ]);

        // Cek bentrok (exclude current jadwal)
        $bentrokDosen = Jadwal::where('dosen_id', $request->dosen_id)
            ->where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('id', '!=', $id)
            ->exists();

        if ($bentrokDosen) {
            return response()->json(['message' => 'Jadwal bentrok - Dosen sudah mengajar di waktu yang sama'], 409);
        }

        $bentrokRuang = Jadwal::where('ruang_id', $request->ruang_id)
            ->where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('id', '!=', $id)
            ->exists();

        if ($bentrokRuang) {
            return response()->json(['message' => 'Jadwal bentrok - Ruangan sudah digunakan di waktu yang sama'], 409);
        }

        $jadwal->update($request->all());
        return response()->json($jadwal, 200);
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::find($id);
        if (!$jadwal) return response()->json(['message' => 'Not Found'], 404);

        $jadwal->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
