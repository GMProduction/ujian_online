<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Paket;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APINilaiController extends Controller
{
    //
    public function index($id){
        $nilai = Nilai::where([['id_paket','=',$id],['id_siswa','=',Auth::id()]])->sum('nilai');
        $salah = Nilai::where([['id_paket','=',$id],['id_siswa','=',Auth::id()],['nilai','=',0]])->count('*');
        $benar = Nilai::where([['id_paket','=',$id],['id_siswa','=',Auth::id()],['nilai','!=',0]])->count('*');
        $totalSoal = Soal::where('id_paket','=',$id)->count('*');
        $totalJawab = Nilai::where([['id_paket','=',$id],['id_siswa','=',Auth::id()]])->count('*');
        $tidakDijawab = $totalSoal - $totalJawab;
        $data = [
            'nilai' =>(int) $nilai,
            'soal' => $totalSoal,
            'benar' => $benar,
            'salah' => $salah,
            'tidak dikerjakan' => $tidakDijawab
        ];
        return $data;
    }

    public function rangking($id){
        $nilai = Nilai::with('getUser.getSiswa')->orderBy('nilai','DESC')->where('id_paket','=',$id)->groupBy('id_siswa')->select('id_siswa')->selectRaw('sum(nilai) as nilai')->get();
        return $nilai;
    }
}
