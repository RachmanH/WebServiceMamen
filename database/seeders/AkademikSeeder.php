<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Ruang;
use App\Models\Jadwal;

class AkademikSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 DOSEN
        $dosen1 = Dosen::create([
            'nama' => 'Dr. Budi Santoso',
            'nidn' => '12345',
            'email' => 'budi@kampus.ac.id',
            'prodi' => 'Informatika'
        ]);

        $dosen2 = Dosen::create([
            'nama' => 'Dr. Siti Aminah',
            'nidn' => '67890',
            'email' => 'siti@kampus.ac.id',
            'prodi' => 'Sistem Informasi'
        ]);

        // 🔹 MATAKULIAH
        $mk1 = Matakuliah::create([
            'kode_mk' => 'IF101',
            'nama_mk' => 'Pemrograman Web'
        ]);

        $mk2 = Matakuliah::create([
            'kode_mk' => 'IF102',
            'nama_mk' => 'Basis Data'
        ]);

        // 🔹 RUANG
        $ruang1 = Ruang::create([
            'nama_ruang' => 'Lab 1',
            'gedung' => 'A'
        ]);

        $ruang2 = Ruang::create([
            'nama_ruang' => 'Lab 2',
            'gedung' => 'B'
        ]);

        // 🔹 MAHASISWA
        $mhs1 = Mahasiswa::create([
            'nama' => 'Andi',
            'nim' => 'M001',
            'email' => 'andi@mail.com',
            'prodi' => 'Informatika'
        ]);

        $mhs2 = Mahasiswa::create([
            'nama' => 'Budi',
            'nim' => 'M002',
            'email' => 'budi@mail.com',
            'prodi' => 'Informatika'
        ]);

        $mhs3 = Mahasiswa::create([
            'nama' => 'Citra',
            'nim' => 'M003',
            'email' => 'citra@mail.com',
            'prodi' => 'Sistem Informasi'
        ]);

        $mhs4 = Mahasiswa::create([
            'nama' => 'Dewi',
            'nim' => 'M004',
            'email' => 'dewi@mail.com',
            'prodi' => 'Sistem Informasi'
        ]);

        // 🔹 JADWAL
        $jadwal1 = Jadwal::create([
            'dosen_id' => $dosen1->id,
            'matakuliah_id' => $mk1->id,
            'ruang_id' => $ruang1->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00:00'
        ]);

        $jadwal2 = Jadwal::create([
            'dosen_id' => $dosen1->id,
            'matakuliah_id' => $mk2->id,
            'ruang_id' => $ruang2->id,
            'hari' => 'Selasa',
            'jam_mulai' => '10:00:00'
        ]);

        $jadwal3 = Jadwal::create([
            'dosen_id' => $dosen2->id,
            'matakuliah_id' => $mk1->id,
            'ruang_id' => $ruang2->id,
            'hari' => 'Rabu',
            'jam_mulai' => '13:00:00'
        ]);

        // 🔹 PIVOT (RELASI MANY-TO-MANY)
        $jadwal1->mahasiswas()->attach([
            $mhs1->id,
            $mhs2->id
        ]);

        $jadwal2->mahasiswas()->attach([
            $mhs2->id,
            $mhs3->id,
            $mhs4->id
        ]);

        $jadwal3->mahasiswas()->attach([
            $mhs1->id,
            $mhs3->id
        ]);

        // 🔥 NOTE:
        // Kedua dosen sudah punya jadwal dengan mahasiswa
    }
}
