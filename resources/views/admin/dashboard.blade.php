@extends('admin.base')
@section('title')
Dashboard
@endsection
@section('content')

    <section class="m-2">


        <div class="table-container">

            <h5 class="mb-3">Paket Soal</h5>

            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Gambar
                    </th>
                    <th>
                        Mata Pelajaran
                    </th>
                    <th>
                        Kelas
                    </th>
                    <th>
                        Guru
                    </th>
                    <th>
                        Waktu Pengerjaan
                    </th>
                    <th>
                        Jumlah Soal
                    </th>
                    <th>
                        Tanggal Mulai
                    </th>
                    <th>
                        Tanggal Selesai
                    </th>
                    <th>
                        Action
                    </th>
                </tr>

                </thead>
                <tbody>
                @forelse($paket as $key => $d)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td><img src="{{$d->url_gambar}}" height="75px"></td>
                        <td>{{$d->mapel}}</td>
                        <td>{{$d->getKelas->nama}}</td>
                        <td>{{$d->getUser->getGuru ? $d->getUser->getGuru->nama : ''}}</td>
                        <td>{{$d->waktu_pengerjaan}}</td>
                        <td>{{count($d->getSoal)}}</td>
                        <td>{{date('d F Y', strtotime($d->tanggal_mulai))}}</td>
                        <td>{{date('d F Y', strtotime($d->tanggal_selesai))}}</td>
                        <td><a class="btn btn-sm btn-success" data-id="{{$d->id}}" href="{{route('nilai_paket',['id' => $d->id])}}">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada paket pakt</td>
                    </tr>
                @endforelse
                </tbody>

            </table>

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
                        Mata Pelajaran
                    </th>
                    <th>
                        Nilai
                    </th>
                </tr>

                </thead>
                <tbody>
                @forelse($nilai as $key => $d)
                    <tr>
                        <td>{{ $key + 1}}</td>
                        <td>{{$d->getUser->getSiswa->nama}}</td>
                        <td>{{$d->getUser->getSiswa->getKelas->nama}}</td>
                        <td>{{$d->getPaket->mapel}}</td>
                        <td>{{$d->nilai}}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak siswa yang mengerjakan</td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>
    </section>


@endsection

@section('script')


@endsection
