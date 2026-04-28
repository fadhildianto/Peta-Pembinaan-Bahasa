<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = [
    'kegiatan_id',
    'nama',
    'instansi',
];
}
