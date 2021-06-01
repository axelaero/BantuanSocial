<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'penduduk_nik',
        'penduduk_kk',
        'penduduk_id_bdt',
        'penduduk_nama',
        'penduduk_alamat',
        'penduduk_status',
        'penduduk_deskripsi',
        'periode',
        'kelurahan_id',
        'approved_status',
        'rt',
        'rw',
    ];

    protected $attributes = [
        'penduduk_status' => 0,
        'approved_status' => 1,
    ];

    protected $table = 'penduduk';
}
