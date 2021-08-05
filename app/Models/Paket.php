<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_paket',
        'mapel',
        'waktu_pengerjaan',
        'url_gambar',
        'pengaturan',
        'id_user',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function getSoal(){
        return $this->hasMany(Soal::class,'id_paket');
    }

    public function getSoalId(){
        return $this->hasMany(Soal::class,'id_paket','id')->select(['id','id_paket']);
    }
}
