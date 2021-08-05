@extends('admin.base')
@section('title')
    Dashboard
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('summernote/summernote.css') }}" type="text/css">
@endsection
@section('content')

    <section class="m-2">


        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-3">Paket Soal</h5>

                <a type="button ms-auto" class="btn btn-primary btn-sm" id="addData">Tambah Paket Soal
                </a>

            </div>

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
                        Nama Paket
                    </th>
                    <th>
                        Mata Pelajaran
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
                        <td>{{$d->nama_paket}}</td>
                        <td>{{$d->mapel}}</td>
                        <td>{{$d->waktu_pengerjaan}}</td>
                        <td>{{date('d F Y', strtotime($d->tanggal_mulai))}}</td>
                        <td>{{date('d F Y', strtotime($d->tanggal_selesai))}}</td>
                        <td><a class="btn btn-sm btn-success" data-id="{{$d->id}}" href="{{route('paket_soal',['id' => $d->id])}}">Detail</a>
                            <a class="btn btn-sm btn-primary" data-id="{{$d->id}}" data-nama="{{$d->nama_paket}}" data-mapel="{{$d->mapel}}" data-waktu="{{$d->waktu_pengerjaan}}"
                               data-mulai="{{$d->tanggal_mulai}}" data-selesai="{{$d->tanggal_selesai}}" data-img="{{$d->url_gambar}}" data-pengaturan="{{$d->pengaturan}}" id="editData">Edit</a>
                            <a class="btn btn-sm btn-danger">Delete</a></td>
                    </tr>
                @empty
                @endforelse
                </tbody>

            </table>

        </div>
        <div class="modal  fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Form Paket Soal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form" method="post" enctype="multipart/form-data" onsubmit="return saveData()">

                        <div class="modal-body">
                            @csrf
                            <input id="id" name="id" hidden>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama_paket" class="form-label">Nama Paket</label>
                                        <input type="text" class="form-control" id="nama_paket" name="nama_paket">
                                    </div>
                                    <div class="mb-3">
                                        <label for="mapel" class="form-label">Mata Pelajaran</label>
                                        <input type="text" class="form-control" id="mapel" name="mapel">
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu_pengerjaan" class="form-label">Waktu Pengerjaan</label>
                                        <input type="number" class="form-control" id="waktu_pengerjaan" name="waktu_pengerjaan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                                    </div>


                                </div>
                                <div class="col-6">

                                    <div class="mb-3">
                                        <label for="kuotaEvent" class="form-label">Gambar Paket</label>
                                        <input type="file" class="form-control" accept="image/*" id="url_gambar" name="url_gambar">
                                        <a class="d-block mt-2" id="imgGambar" style="cursor: pointer; width: 100%" target="_blank"
                                           href="">
                                            <img src="" class="d-none"
                                                 style="height: 120px; object-fit: cover"/>

                                        </a>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="pengaturan" class="form-label">Pengaturan</label>
                                        <textarea class="" id="pengaturan" name="pengaturan"></textarea>

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
    <script src="{{ asset('summernote/summernote.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#pengaturan').summernote();
        })
        $(document).on('click', '#addData', function () {
            $('#modal #id').val('');
            $('#modal #nama_paket').val('');
            $('#modal #mapel').val('');
            $('#modal #waktu_pengerjaan').val('');
            $('#modal #tanggal_mulai').val('');
            $('#modal #tanggal_selesai').val('');
            $('#pengaturan').summernote('code', '');
            $('#imgGambar').attr('href', '');
            $('#imgGambar img').addClass('d-none')
            $('#modal').modal('show')
        })

        $(document).on('click', '#editData', function () {
            $('#modal #id').val($(this).data('id'));
            $('#modal #nama_paket').val($(this).data('nama'));
            $('#modal #mapel').val($(this).data('mapel'));
            $('#modal #waktu_pengerjaan').val($(this).data('waktu'));
            $('#modal #tanggal_mulai').val($(this).data('mulai'));
            $('#modal #tanggal_selesai').val($(this).data('selesai'));
            $('#pengaturan').summernote('code', $(this).data('pengaturan'));
            $('#imgGambar').attr('href', $(this).data('img'));
            $('#imgGambar img').attr('src', $(this).data('img')).removeClass('d-none')
            $('#modal').modal('show')
        })

        $(document).on('change', '#url_gambar', function (evt) {
            var file = evt.target.files[0];
            console.log(file)
            $('#imgGambar').attr('href', URL.createObjectURL(file))
            $('#imgGambar img').attr('src', URL.createObjectURL(file)).removeClass('d-none')
        })

        function saveData() {
            var form_data = new FormData($('#form')[0]);
            $
            swal({
                title: "Data paket",
                text: "Apa kamu yakin ?",
                icon: "info",
                buttons: true,
                primariMode: true,
            })
                .then((res) => {
                    if (res) {
                        $.ajax({
                            type: "POST",
                            data: form_data,
                            async: true,
                            processData: false,
                            contentType: false,
                            headers: {
                                'Accept': "application/json"
                            },
                            success: function (data, textStatus, xhr) {
                                console.log(data);

                                if (xhr.status === 200) {
                                    swal("Data Updated ", {
                                        icon: "success",
                                    }).then((dat) => {
                                        window.location.reload();
                                    });
                                } else {
                                    swal(data['msg'])
                                }
                                console.log(data);
                            },
                            complete: function (xhr, textStatus) {
                                console.log(xhr.status);
                                console.log(textStatus);
                            },
                            error: function (error, xhr, textStatus) {
                                // console.log("LOG ERROR", error.responseJSON.errors);
                                // console.log("LOG ERROR", error.responseJSON.errors[Object.keys(error.responseJSON.errors)[0]][0]);
                                console.log(xhr.status);
                                console.log(textStatus);
                                console.log(error.responseJSON);
                                swal(error.responseJSON.errors[Object.keys(error.responseJSON.errors)[0]][0])
                            }
                        })
                    }
                });
            return false;
        }
    </script>

@endsection
