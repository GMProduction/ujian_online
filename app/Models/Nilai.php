<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_soal',
        'id_jawaban',
        'id_siswa',
        'nilai',
        'id_paket'
    ];

    public function getSoal(){
        return $this->belongsTo(Soal::class,'id_soal');
    }

    public function getUser(){
        return $this->belongsTo(User::class, 'id_siswa')->select(['id','username']);
    }

    public function getPaket(){
        return $this->belongsTo(Paket::class,'id_paket');

    }

    public static function setNilai(){
        return Nilai::orderBy('nilai','DESC')->groupBy('id_siswa')->select(['id_siswa','id_paket'])->selectRaw('sum(nilai) as nilai');
    }


}
