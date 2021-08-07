<?php

namespace App\Http\Controllers\Guru;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Paket;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class NilaiGuruController extends CustomController
{
    //
    public function index()
    {
        $paket = Paket::where('id_user','=',Auth::id())->paginate(10);

        return view('guru.nilai')->with(['data' => $paket]);
    }

    public function detail($id)
    {
//        $nilai = Nilai::with('getUser.getSiswa')->orderBy('nilai','DESC')->where('id_paket','=',$id)->groupBy('id_siswa')->select('id_siswa')->selectRaw('sum(nilai) as nilai')->get();
        $nilai     = Paket::find($id);
        $getNilai = $nilai->getNilai()->with('getUser.getSiswa')->paginate(10);
        $totalSoal       = Soal::where('id_paket', '=', $id)->count('*');
        $nilai = Arr::add($nilai, 'soal', $totalSoal);
        $nilai = Arr::add($nilai,'nilai', $getNilai);

        $dataNilai = [];
        if ($nilai) {
            foreach ($nilai->nilai as $key => $n) {
                $dataNilai[$key] = $n;
                $salah           = Nilai::where([['id_paket', '=', $id], ['id_siswa', '=', $n->id_siswa], ['nilai', '=', 0]])->count('*');
                $benar           = Nilai::where([['id_paket', '=', $id], ['id_siswa', '=', $n->id_siswa], ['nilai', '!=', 0]])->count('*');

                $totalJawab      = Nilai::where([['id_paket', '=', $id], ['id_siswa', '=', $n->id_siswa]])->count('*');
                $tidakDijawab    = $totalSoal - $totalJawab;

                $dataNilai[$key] = Arr::add($dataNilai[$key], 'benar', $benar);
                $dataNilai[$key] = Arr::add($dataNilai[$key], 'salah', $salah);
                $dataNilai[$key] = Arr::add($dataNilai[$key], 'tidak_dikerjakan', $tidakDijawab);
            }
            $pembuatSoal = Guru::where('id_user', '=', $nilai->id_user)->first();
            if ($pembuatSoal) {
                $pembuatSoal = Arr::add($pembuatSoal, 'roles', 'guru');
                $nilai       = Arr::add($nilai, 'pembuat_soal', $pembuatSoal);
            } else {
                $pembuatSoal = Admin::where('id_user', '=', $nilai->id_user)->first();
                $pembuatSoal = Arr::add($pembuatSoal, 'roles', 'admin');
                $nilai       = Arr::add($nilai, 'pembuat_soal', $pembuatSoal);
            }
        }
//        return $nilai;
        return view('guru.nilai-detail')->with(['data' => $nilai]);
    }
}
