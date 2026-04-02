<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    protected $fillable = [
        'kode_mk',
        'nama_mk'
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
