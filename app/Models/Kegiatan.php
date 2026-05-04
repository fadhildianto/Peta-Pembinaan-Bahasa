<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'jenis_kegiatan',
        'tahun',
        'lokasi_id',
        'created_by',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tahun' => 'integer',
    ];

    /**
     * Get the lokasi this kegiatan belongs to
     */
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    /**
     * Get the user who created this kegiatan
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the peserta for this kegiatan
     */
    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }

    /**
     * Get the arsip for this kegiatan
     */
    public function arsip()
    {
        return $this->hasMany(Arsip::class);
    }

    /**
     * Get count of peserta
     */
    public function getPesertaCountAttribute()
    {
        return $this->attributes['peserta_count'] ?? $this->peserta()->count();
    }

    /**
     * Get count of arsip
     */
    public function getArsipCountAttribute()
    {
        return $this->attributes['arsip_count'] ?? $this->arsip()->count();
    }
}
