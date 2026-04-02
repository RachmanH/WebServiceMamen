<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $prodiList = ['Informatika', 'Sistem Informasi', 'Teknik Komputer'];

        for ($i = 1; $i <= 10000; $i++) {
            Mahasiswa::create([
                'nama' => 'Mahasiswa ' . $i,
                'nim' => '22' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'email' => 'mahasiswa' . $i . '@mail.com',
                'prodi' => $prodiList[array_rand($prodiList)],
            ]);
        }
    }
}
