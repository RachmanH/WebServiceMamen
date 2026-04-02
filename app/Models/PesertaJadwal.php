<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaJadwal extends Model
{
    protected $table = 'peserta_jadwal';

    protected $fillable = [
        'jadwal_id',
        'mahasiswa_id'
    ];
}
