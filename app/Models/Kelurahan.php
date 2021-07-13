<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'kelurahan_id',
        'kelurahan_nama',
        'kelurahan_alamat',
        'kelurahan_telepon',
        'kelurahan_kodepos',
        'kecamatan_nama',
        'jumlah_rw',
    ];

    protected $attributes = [
        'jumlah_rw' => 0,
    ];

    protected $table = 'kelurahan';
}
