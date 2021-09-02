@extends('admin.base')
@section('title')
    Dashboard
@endsection
@section('content')

    <section class="m-2">


        <div class="table-container">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-3">Master Kelas</h5>

                <a type="button ms-auto" class="btn btn-primary btn-sm" id="addData">Tambah Kelas
                </a>

            </div>

            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Nama
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
                        <td>{{$d->nama}}</td>
                        <td style="width: 150px"><a class="btn btn-sm btn-primary" id="editData" data-id="{{$d->id}}" data-nama="{{$d->nama}}">Edit</a>
                            <a class="btn btn-sm btn-danger" id="deleteData" data-id="{{$d->id}}" data-nama="{{$d->nama}}">Delete</a></td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="6">Tidak ada data kelas</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
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
                                        <label for="nama_paket" class="form-label">Nama Kelas</label>
                                        <input type="text" class="form-control" id="nama" name="nama">
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
            $('#modal').modal('show');
        })

        function save() {
            var id = $('#modal #id').val();
            var string = 'Tambah';
            if (id){
                string = 'Edit';
            }
            saveData(string+' Data', 'form');
            return false;
        }

        $(document).on('click','#editData', function () {
            $('#modal #id').val($(this).data('id'))
            $('#modal #nama').val($(this).data('nama'));

            $('#modal').modal('show');
        })

        $(document).on('click', '#deleteData', function () {
            deleteData($(this).data('nama'), window.location.pathname+'/'+$(this).data('id')+'/delete');
            return false;
        })
    </script>

@endsection
