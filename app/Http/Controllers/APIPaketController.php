<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\Nilai;
use App\Models\Paket;
use App\Models\PesertaUjian;
use App\Models\Siswa;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class APIPaketController extends CustomController
{
    //
    public function ongoing()
    {
        $siswa = Siswa::where('id_user','=', Auth::id())->first();
        $paket = Paket::where([['id_kelas','=',$siswa->kelas],['tanggal_mulai','<=',$this->now->format('Y-m-d')],['tanggal_selesai','>=',$this->now->format('Y-m-d')]])->get();
        return $this->jsonResponse($paket, 200);
    }

    public function comingSoon(){
        $siswa = Siswa::where('id_user','=', Auth::id())->first();
        $paket = Paket::where([['id_kelas','=',$siswa->kelas],['tanggal_mulai','>',$this->now->format('Y-m-d')]])->get();
        return $this->jsonResponse($paket, 200);
    }

    public function detailPaket($id){
        $paket = Paket::with('getSoalId')->find($id);
        return $this->jsonResponse($paket, 200);
    }

    public function getSoal($id){
        $siswa = Siswa::where('id_user','=', Auth::id())->first();
        $paket = Paket::with('getSoal.getJawaban')->where('id_kelas','=',$siswa->kelas)->find($id);
        return $this->jsonResponse($paket, 200);
    }

    public function paketFinish(){
        $peserta = PesertaUjian::where([['id_siswa','=',Auth::id()],['waktu_selesai','!=',null]])->groupBy('id_paket')->get();
        $dataPaket = [];
        foreach ($peserta as $key => $n){
            $idPaket = $n->id_paket;
            $totNilai = Nilai::where([['id_paket','=',$idPaket],['id_siswa','=',Auth::id()]])->sum('nilai');
            $paket = Paket::find($idPaket);
            $dataPaket[$key] = $paket;
            $dataPaket[$key] = Arr::add($dataPaket[$key],'nilai', (int)$totNilai);
        }
        return $dataPaket;
    }

}
