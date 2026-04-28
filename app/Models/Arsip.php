<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $fillable = [
    'kegiatan_id',
    'nama_file',
    'path_file',
];
}
