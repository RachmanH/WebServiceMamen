<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        Mahasiswa::create([
            'nama' => 'Ahmad Fauzi',
            'nim' => '220001',
            'email' => 'ahmad@mail.com',
            'prodi' => 'Informatika',
        ]);

        Mahasiswa::create([
            'nama' => 'Dewi Lestari',
            'nim' => '220002',
            'email' => 'dewi@mail.com',
            'prodi' => 'Sistem Informasi',
        ]);

        Mahasiswa::create([
            'nama' => 'Rizky Pratama',
            'nim' => '220003',
            'email' => 'rizky@mail.com',
            'prodi' => 'Teknik Komputer',
        ]);
    }
}
