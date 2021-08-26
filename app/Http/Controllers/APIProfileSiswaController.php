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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfileImage()
    {
        try {
            $image  = $this->request->files->get('image');
            $data   = User::find(Auth::id());
            $string = null;

            if ($image || $image != '') {
                if ($data && $data->getSiswa->image) {
                    if (file_exists('../public'.$data->getSiswa->image)) {
                        unlink('../public'.$data->getSiswa->image);
                    }

                }

                $textImg = $this->generateImageName('image');
                $string = '/images/siswa/'.$textImg;
                $this->uploadImage('image', $textImg, 'imagesSiswa');
                $data->getSiswa->update(
                    [
                        'image' => $string,
                    ]
                );
            } else {
                if ($data && $data->getSiswa->image) {
                    $string = $data->getSiswa->image;
                }
            }

            return $this->jsonResponse(['msg' => 'Berhasil memperbarui foto', 'data' => $string]);

        } catch (\Exception $err) {
            return $this->jsonResponse(['msg' => $err->getMessage()], 500);
        }
    }


}
