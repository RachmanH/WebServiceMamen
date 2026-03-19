<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        Dosen::create([
            'nama' => 'Dr. Budi Santoso',
            'nidn' => '01010101',
            'email' => 'budi@kampus.ac.id',
            'prodi' => 'Informatika',
        ]);

        Dosen::create([
            'nama' => 'Dr. Siti Aminah',
            'nidn' => '02020202',
            'email' => 'siti@kampus.ac.id',
            'prodi' => 'Sistem Informasi',
        ]);

        Dosen::create([
            'nama' => 'Dr. Andi Wijaya',
            'nidn' => '03030303',
            'email' => 'andi@kampus.ac.id',
            'prodi' => 'Teknik Komputer',
        ]);
    }
}
