<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Soal extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'id_paket',
        'soal',
    ];

    public function getJawaban()
    {
        return $this->hasMany(Jawaban::class, 'id_soal')->select(['id', 'id_soal', 'jawaban']);
    }

    public function getJawabanAll()
    {
        return $this->hasMany(Jawaban::class, 'id_soal');
    }

    public function getNilai()
    {
        return $this->hasOne(Nilai::class, 'id_soal')->where('id_siswa', '=', Auth::id())->select(['id_soal', 'id_jawaban']);
    }

    public function getpaket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }
}
