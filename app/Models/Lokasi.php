<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $fillable = [
        'nama_kabupaten',
        'latitude',
        'longitude',
        'deskripsi',
        'zoom_level',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'zoom_level' => 'integer',
    ];

    /**
     * Get the kegiatans for this lokasi
     */
    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class);
    }

    /**
     * Get count of kegiatans
     */
    public function getKegiatanCountAttribute()
    {
        return $this->attributes['kegiatans_count'] ?? $this->kegiatans()->count();
    }
}
