@extends('guru.base')

@section('content')

    <section class="m-2">
        <div class="container-fluid table-container">
            <h5 class="fw-bold">{{$data->nama_paket}}</h5>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="mb-3">

                        <label class="form-label">Cover</label>
                        <a class="d-block" id="cover" style="cursor: pointer" target="_blank"
                           href="{{$data->url_gambar}}">
                            <img src="{{$data->url_gambar}}"
                                 style="height: 150px;  object-fit: cover"/>

                        </a>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Mapel</label>
                        <p class="fw-bold" id="mapel">{{$data->mapel}} ( {{$data->getKelas ? $data->getKelas->nama : ''}} )</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pembuat Soal</label>
                        <p class="fw-bold" id="pembuat">{{$data->pembuat_soal->nama}} ({{$data->pembuat_soal->roles}}) </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Waktu Pengerjaan</label>
                        <p class="fw-bold" id="waktu">{{$data->waktu_pengerjaan}} Menit</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Soal</label>
                        <p class="fw-bold" id="waktu">{{$data->soal}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">


                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <p class="fw-bold" id="mulai">{{date('d F Y', strtotime($data->tanggal_mulai))}}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <p class="fw-bold" id="selesai">{{date('d F Y', strtotime($data->tanggal_selesai))}}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pengaturan</label>
                       <div class="overflow-auto" style="height: 200px">
                           <p class="fw-bold" id="pengaturan" style="">{!! $data->pengaturan !!}</p>
                       </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-container">

            <h5 class="mb-3">Nilai Siswa</h5>

            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Nama Siswa
                    </th>
                    <th>
                        Kelas
                    </th>

                    <th>
                        Jumlah Benar
                    </th>
                    <th>
                        Jumlah Salah
                    </th>
                    <th>
                        Tidak Dijawab
                    </th>
                    <th>
                        Nilai
                    </th>
                </tr>

                </thead>
                <tbody>
                @forelse($data->nilai as $key => $d)
                    <tr>
                        <td>{{ $key + 1}}</td>
                        <td>{{$d->getUser->getSiswa->nama}}</td>
                        <td>{{$d->getUser->getSiswa->getKelas->nama}}</td>
                        <td>{{$d->benar}}</td>
                        <td>{{$d->salah}}</td>
                        <td>{{$d->tidak_dikerjakan}}</td>
                        <td>{{$d->nilai}}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak siswa yang mengerjakan</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
            <div class="d-flex justify-content-end">
                {{$data->nilai->links()}}
            </div>
        </div>


    </section>


@endsection

@section('script')
<script>

</script>

@endsection
