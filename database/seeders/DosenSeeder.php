<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $prodiList = ['Informatika', 'Sistem Informasi', 'Teknik Komputer'];
        $gelarDepan = ['Dr.', 'Prof.', 'Ir.'];

        for ($i = 1; $i <= 10000; $i++) {
            Dosen::create([
                'nama' => $gelarDepan[array_rand($gelarDepan)] . ' Dosen ' . $i,
                'nidn' => str_pad($i, 8, '0', STR_PAD_LEFT),
                'email' => 'dosen' . $i . '@kampus.ac.id',
                'prodi' => $prodiList[array_rand($prodiList)],
            ]);
        }
    }
}
