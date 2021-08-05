<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\Jawaban;
use App\Models\Nilai;
use App\Models\Paket;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APISoalController extends CustomController
{
    //
    public function getSoal($id)
    {
        $soal = Soal::with(['getJawaban', 'getNilai'])->find($id);

        return $this->jsonResponse($soal, 200);
    }

    public function jawabSoal($id)
    {
        $totNilai = 100;
        $field = $this->request->validate(
            [
                'id_jawaban' => 'required',
            ]
        );
        $soal = Soal::with('getNilai')->find($id);

        $totSoal = Soal::where('id_paket','=',$soal->id)->count('*');
        $nilai = 0;

        if ($this->cekJawaban($id) === (int)$field['id_jawaban']){
           $nilai = $totNilai / $totSoal;
        }
        if ($soal->getNilai) {
            $soal->getNilai()->update(
                [
                    'id_jawaban' => $field['id_jawaban'],
                    'nilai' => $nilai
                ]
            );
        } else {
            Nilai::create(
                [
                    'id_soal'    => $id,
                    'id_jawaban' => $field['id_jawaban'],
                    'id_siswa'   => Auth::id(),
                    'nilai' => $nilai,
                    'id_paket' => $soal->id_paket

                ]
            );
        }


        return response()->json(
            [
                'msg' => 'Berhasil',
            ],
            200
        );
    }

    public function cekJawaban($idSoal){
        $jawaban = Jawaban::where([['id_soal','=',$idSoal],['jawaban_benar','=',1]])->first();
        return $jawaban->id;
    }
}
