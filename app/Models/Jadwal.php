<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'dosen_id',
        'matakuliah_id',
        'ruang_id',
        'hari',
        'jam_mulai'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
    }

    public function mahasiswas()
    {
        return $this->belongsToMany(Mahasiswa::class, 'peserta_jadwal');
    }
}
