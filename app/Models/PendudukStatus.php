<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendudukStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'deskripsi'
    ];

    protected $table = 'penduduk_status';
}
