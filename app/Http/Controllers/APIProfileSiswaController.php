<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIProfileSiswaController extends CustomController
{
    //
    public function index(){
        $user = User::with('getSiswa')->find(Auth::id());
        if ($this->request->isMethod('POST')) {
            $this->request->validate(
                [
                    'nama'    => 'required|string',
                    'alamat'  => 'required|string',
                    'kelas'   => 'required',
                    'no_hp'   => 'required',
                ]
            );
            $siswa = Siswa::where('id_user', '=', $user->id);
            $siswa->update($this->request->all());
            $user = User::with(['getSiswa'])->find($user->id);
        }
        return $this->jsonResponse($user,200);
    }
}
