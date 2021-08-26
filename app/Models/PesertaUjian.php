<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaUjian extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_paket',
        'id_siswa',
        'waktu_mulai',
        'waktu_selesai',
    ];
}
