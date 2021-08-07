@extends('admin.base')
@section('title')
    Dashboard
@endsection
@section('content')

    <section class="m-2">


        <div class="table-container">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-3">Master Siswa</h5>

                <a type="button ms-auto" class="btn btn-primary btn-sm" id="addData">Tambah Siswa
                </a>

            </div>

            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Username
                    </th>
                    <th>
                        Nama
                    </th>
                    <th>
                        Kelas
                    </th>
                    <th>
                        Alamat
                    </th>
                    <th>
                        No. Hp
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
                        <td>{{$d->username}}</td>
                        <td>{{$d->getSiswa->nama}}</td>
                        <td>{{$d->getSiswa->kelas}}</td>
                        <td>{{$d->getSiswa->alamat}}</td>
                        <td>{{$d->getSiswa->no_hp}}</td>
                        <td style="width: 150px"><a class="btn btn-sm btn-primary" id="editData" data-kelas="{{$d->getSiswa->kelas}}" data-username="{{$d->username}}" data-hp="{{$d->getSiswa->no_hp}}" data-id="{{$d->id}}" data-nama="{{$d->getSiswa->nama}}" data-alamat="{{$d->getSiswa->alamat}}">Edit</a>
                            <a class="btn btn-sm btn-danger">Delete</a></td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="6">Tidak ada data siswa</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
            <div class="d-flex justify-content-end">
                {{$data->links()}}
            </div>
        </div>
        <div class="modal  fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Form Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form" method="post" enctype="multipart/form-data" onsubmit="return save()">

                        <div class="modal-body">
                            @csrf
                            <input id="id" name="id" hidden>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nama_paket" class="form-label">Nama Siswa</label>
                                        <input type="text" class="form-control" id="nama" name="nama">
                                    </div>
                                    <div class="mb-3">
                                        <label for="mapel" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username">
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu_pengerjaan" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu_pengerjaan" class="form-label">Password Konfirmasi</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_selesai" class="form-label">Kelas</label>
                                        <input type="text" class="form-control" id="kelas" name="kelas">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_selesai" class="form-label">No. Hp</label>
                                        <input type="number" class="form-control" id="no_hp" name="no_hp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_selesai" class="form-label">Alamat</label>
                                        <textarea id="alamat" name="alamat" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="konfirmasi" class="btn btn-primary w-100 " type="submit">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </section>


@endsection

@section('script')
    <script src="{{ asset('js/dialog.js') }}"></script>

    <script>
        $(document).on('click', '#addData', function () {
            $('#modal #id').val('');
            $('#modal #nama').val('');
            $('#modal #kelas').val('');
            $('#modal #alamat').val('');
            $('#modal #no_hp').val('');
            $('#modal #username').val('');
            $('#modal #password').val('');
            $('#modal #password_confirmation').val('');
            $('#modal').modal('show');
        })

        function save() {
            var id = $('#modal #id').val();
            var string = 'Tambah';
            if (id){
                string = 'Edit';
            }
            saveData(string+' Data', 'form', '/admin/register');
            return false;
        }

        $(document).on('click','#editData', function () {
            $('#modal #id').val($(this).data('id'))
            $('#modal #nama').val($(this).data('nama'))
            $('#modal #alamat').val($(this).data('alamat'))
            $('#modal #kelas').val($(this).data('kelas'))
            $('#modal #no_hp').val($(this).data('hp'))
            $('#modal #username').val($(this).data('username'))
            $('#modal #password').val('*********')
            $('#modal #password_confirmation').val('*********')
            $('#modal').modal('show');
        })
    </script>

@endsection
