<?php

namespace App\Http\Controllers\Guru;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\Jawaban;
use App\Models\Kelas;
use App\Models\Paket;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SoalGuruController extends CustomController
{
    //

    public function paketAll()
    {
        if ($this->request->isMethod('POST')) {
            $fild = $this->request->validate(
                [
                    'mapel'            => 'required',
                    'waktu_pengerjaan' => 'required',
                    'pengaturan'       => 'required',
                    'tanggal_mulai'    => 'required',
                    'tanggal_selesai'  => 'required',

                ]
            );
            $img  = $this->request->files->get('url_gambar');

            if ($img || $img != '') {
                $image     = $this->generateImageName('url_gambar');
                $stringImg = '/images/paket/'.$image;
                $this->uploadImage('url_gambar', $image, 'imagePaket');
                $fild = Arr::add($fild, 'url_gambar', $stringImg);
            }
            Arr::set($fild, 'id_user', Auth::id());
            Arr::set($fild, 'id_kelas', (int)$this->request->get('id_kelas'));


            if ($this->request->get('id')) {
                $paket = Paket::find($this->request->get('id'));
                if ($img && $paket->url_gambar) {
                    if (file_exists('../public'.$paket->url_gambar)) {
                        unlink('../public'.$paket->url_gambar);
                    }
                }
                $paket->update($fild);
            } else {
                Paket::create($fild);
            }

            return response()->json(
                [
                    'msg' => 'berhasil',
                ],
                200
            );
        }
        $paket = Paket::with('getKelas')->where('id_user', '=', Auth::id())->paginate(10);
        $kelas = Kelas::all();
        $data  = [
            'data'  => $paket,
            'kelas' => $kelas,
        ];

//return $paket;
        return view('guru.paket')->with($data);
    }

    public function paketSoal($id)
    {
        $paket = Paket::find($id);
        $soal  = $paket->getSoal()->paginate(10);

        $paket = Arr::add($paket, 'soal', $soal);

        return view('guru.paket-soal')->with(['data' => $paket]);
    }

    public function soal($id)
    {
        $id_soal = $this->request->get('q');
        if ($this->request->isMethod('POST')) {
            $jawaban   = $this->request->get('jawaban');
            $idJawaban = $this->request->get('id_jawaban');
            $benar     = $this->request->get('jawaban_benar');
            $soal      = $this->request->get('soal');
            if ($id_soal) {
                $soalData = Soal::find($id_soal);
                $soalData->update(['soal' => $soal]);

                foreach ($idJawaban as $key => $ij) {
                    $jawab = Jawaban::find($ij);
                    $jawab->update(['jawaban' => $jawaban[$key], 'jawaban_benar' => 0]);
                    if ($ij == $benar) {
                        $jawab->update(['jawaban_benar' => 1]);
                    }
                }
            } else {
                $soalData    = Soal::create(
                    [
                        'id_paket' => $id,
                        'soal'     => $soal,
                    ]
                );
                $dataJawaban = [];
                foreach ($jawaban as $key => $Jw) {
                    $dataJawaban[$key] = [
                        'jawaban' => $Jw,
                    ];
                    if ($key == $benar) {
                        $dataJawaban[$key] = Arr::add($dataJawaban[$key], 'jawaban_benar', 1);
                    } else {
                        $dataJawaban[$key] = Arr::add($dataJawaban[$key], 'jawaban_benar', 0);

                    }
                }
                $soalData->getJawabanAll()->createMany($dataJawaban);
            }
        }

        return view('guru.paket-soal-jawaban');
    }

    public function getDetailSoal($id)
    {
        $id_soal = $this->request->get('q');

        $paket = Soal::with(['getJawabanAll', 'getPaket'])->where('id_paket', '=', $id)->find($id_soal);

        return $paket;
    }

    public function deletePaket($id)
    {
        Paket::destroy($id);

        return $this->jsonResponse('berhasil', 200);
    }

    public function deteleSoal($id)
    {
        Soal::destroy($id);

        return $this->jsonResponse('berhasil', 200);
    }
}
