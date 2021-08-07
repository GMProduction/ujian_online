<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    //
    public function index(){
        $siswa = User::with('getSiswa')->role('siswa')->paginate(10);
        return view('admin.siswa')->with(['data' => $siswa]);
    }
}
