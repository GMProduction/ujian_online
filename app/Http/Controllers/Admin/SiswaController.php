<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    //
    public function index(){
        $siswa = User::with('getSiswa')->role('siswa')->paginate(10);
        $kelas = Kelas::all();
        $data = [
            'data' => $siswa,
            'kelas' => $kelas
        ];
//        return $siswa;
        return view('admin.siswa')->with($data);
    }
}
