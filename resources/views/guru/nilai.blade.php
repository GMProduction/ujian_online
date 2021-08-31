@extends('guru.base')
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
                        Waktu Pengerjaan
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
                @forelse($data as $key => $d)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td><img src="{{$d->url_gambar}}" height="75px"></td>
                        <td>{{$d->mapel}}</td>
                        <td>{{$d->getKelas ? $d->getKelas->nama : ''}}</td>
                        <td>{{$d->waktu_pengerjaan}}</td>
                        <td>{{date('d F Y', strtotime($d->tanggal_mulai))}}</td>
                        <td>{{date('d F Y', strtotime($d->tanggal_selesai))}}</td>
                        <td><a class="btn btn-sm btn-success" data-id="{{$d->id}}" href="{{route('nilai_paket_guru',['id' => $d->id])}}">Detail</a>
                            </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada paket soal</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
            <div class="d-flex justify-content-end">
                {{$data->links()}}
            </div>
            </div>



    </section>


@endsection

@section('script')


@endsection
