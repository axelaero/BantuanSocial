<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelasiPBA extends Model
{
    use HasFactory;

    protected $fillable = [
        'relasi_id',
        'penduduk_id',
        'ba_id',
        'cek_dinas',
        'cek_mentri',
    ];

    protected $attributes = [
        'cek_dinas' => 0,
        'cek_mentri' => 0,
    ];

    protected $table = "relasi_penduduk_ba";
}
