<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'nama',
        'alamat',
        'no_hp',
        'kelas',
        'image'
    ];

    protected $with = 'getKelas';

    public function getKelas(){
        return $this->belongsTo(Kelas::class, 'kelas');
    }
}
