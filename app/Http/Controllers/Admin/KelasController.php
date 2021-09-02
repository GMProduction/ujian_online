<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    //

    public function getKelas(){
        $kelas = Kelas::all();
        return $kelas;
    }
    public function index(){
        if (\request()->isMethod('POST')){
            $field = \request()->validate([
               'nama' => 'required'
            ]);
            if (\request('id')){
                $kelas = Kelas::find(\request('id'));
                $kelas->update(\request()->all());
            }else{
                Kelas::create(\request()->all());
            }
        }
        $kelas = $this->getKelas();
        return view('admin.kelas')->with(['data' => $kelas]);
    }

    public function delete($id){
            Kelas::destroy($id);
            return response()->json(['msg' => 'success']);
    }
}
