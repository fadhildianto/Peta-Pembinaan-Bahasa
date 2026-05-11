<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = [
        'kegiatan_id',
        'lokasi_id',
        'nama',
        'instansi',
        'email',
        'no_telp',
        'alamat',
    ];

    /**
     * Get the kegiatan this peserta belongs to
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    /**
     * Get the lokasi this peserta belongs to
     */
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
}
