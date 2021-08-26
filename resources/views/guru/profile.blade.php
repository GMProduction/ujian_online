@extends('guru.base')
@section('title')
    Dashboard
@endsection
@section('content')

    <section class="m-2">


        <div class="table-container">

            <h5 class="mb-3">Profile Guru</h5>
            <form method="post" id="form" onsubmit="return save()">
                @csrf
                <input id="id" name="id" value="{{$data->id}}" hidden>
                <input id="id" name="roles" value="guru" hidden>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="nama_paket" class="form-label">Nama Guru</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{$data->getGuru->nama}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="mapel" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{$data->username}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_pengerjaan" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="********" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_pengerjaan" class="form-label">Password Konfirmasi</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="********" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">No. Hp</label>
                            <input type="number" class="form-control" id="no_hp" name="no_hp" value="{{$data->getGuru->no_hp}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Alamat</label>
                            <textarea id="alamat" name="alamat" class="form-control" required>{{$data->getGuru->alamat}}</textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </section>


@endsection

@section('script')
    <script src="{{ asset('js/dialog.js') }}"></script>

    <script>
    function save() {
        saveData('Update Data', 'form', '/admin/register');
        return false;
    }
</script>

@endsection
