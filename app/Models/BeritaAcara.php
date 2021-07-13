<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelurahan_id',
        'periode',
        'total_usulan',
        'total_perbaikan',
        'cek_dinas',
        'part',
    ];

    protected $attributes = [
        'cek_dinas' => 0,
        'part' => 1,
    ];

    protected $table = "berita_acara";
}
