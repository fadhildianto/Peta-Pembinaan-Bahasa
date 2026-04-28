<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lokasi;
class Kegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'jenis_kegiatan',
        'tahun',
        'lokasi_id',
        'deskripsi',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }

    public function arsip()
    {
        return $this->hasMany(Arsip::class);
    }

}
