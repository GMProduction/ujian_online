<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\PesertaUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIPesertaUjianController extends CustomController
{
    //
    public function index($id)
    {
        $peserta = PesertaUjian::where([['id_siswa', '=', Auth::id()], ['id_paket', '=', $id]])->first();
        if ($peserta) {
            return $peserta;
        }

        $peserta = PesertaUjian::create(
            [
                'id_paket'    => $id,
                'id_siswa'    => Auth::id(),
                'waktu_mulai' => $this->now->format('Y-m-d H-i-s'),
                'waktu_selesai' => null
            ]
        );
        $peserta = PesertaUjian::where([['id_siswa', '=', Auth::id()], ['id_paket', '=', $id]])->first();
        return $peserta;
    }

    public function setSelesai($id)
    {
        $peserta = PesertaUjian::where([['id_siswa', '=', Auth::id()], ['id_paket', '=', $id]])->first();
        if ($peserta) {
            if ($peserta->waktu_selesai == null) {
                $peserta->update(
                    [
                        'waktu_selesai' => $this->now->format('Y-m-d H-i-s'),
                    ]
                );
                return $peserta;
            }
            return response()->json(['Sudah selesai mengerjakan']);
        }
        return response()->json(['Data tidak ditemukan']);
    }
}
