<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\Nilai;
use App\Models\Paket;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class APIPaketController extends CustomController
{
    //
    public function ongoing()
    {
        $paket = Paket::where([['tanggal_mulai','>=',$this->now->format('Y-m-d')],['tanggal_selesai','<=',$this->now->format('Y-m-d')]])->get();

        return $this->jsonResponse($paket, 200);
    }

    public function comingSoon(){
        $paket = Paket::where('tanggal_mulai','>',$this->now->format('Y-m-d'))->get();

        return $this->jsonResponse($paket, 200);
    }

    public function detailPaket($id){
        $paket = Paket::with('getSoalId')->find($id);
        return $this->jsonResponse($paket, 200);

    }

    public function getSoal($id){
        $paket = Paket::with('getSoal.getJawaban')->find($id);
        return $this->jsonResponse($paket, 200);
    }

    public function paketFinish(){
        $nilai = Nilai::where('id_siswa','=',Auth::id())->groupBy('id_paket')->get();

        $dataPaket = [];
        foreach ($nilai as $key => $n){
            $idPaket = $n->id_paket;
            $totNilai = Nilai::where([['id_paket','=',$idPaket],['id_siswa','=',Auth::id()]])->sum('nilai');

            $paket = Paket::find($idPaket);
            $dataPaket[$key] = $paket;
            $dataPaket[$key] = Arr::add($dataPaket[$key],'nilai', $totNilai);
        }
        return $dataPaket;
    }

}
