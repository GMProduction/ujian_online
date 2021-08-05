@extends('admin.base')
@section('title')
    Dashboard
@endsection

@section('content')

    <section class="m-2">


        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-3">Paket Soal : {{$data->nama_paket}}</h5>

                <a type="button ms-auto" class="btn btn-primary btn-sm" id="addData">Tambah Soal
                </a>

            </div>

            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Soal
                    </th>
                    <th>
                        Action
                    </th>
                </tr>

                </thead>
                <tbody>
                @forelse($data->getSoal as $key => $d)
                    <tr>
                        <td style="width: 50px">{{$key + 1}}</td>
                        <td>{!! $d->soal !!}</td>
                        <td style="width: 150px"><a class="btn btn-sm btn-primary" data-id="{{$d->id}}" id="edit">Edit</a>
                            <a class="btn btn-sm btn-danger">Delete</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            Tidak ada soal
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>


    </section>


@endsection

@section('script')
    <script>



        $(document).on('click', '#edit', function () {
            var url = window.location.href;
            var id = $(this).data('id');
            url = url + '/soal?q=' + id;
            $(this).attr('href', url);
        })

        $(document).on('click', '#addData', function () {
            var url = window.location.href;
            url = url + '/soal';
            $(this).attr('href', url);
        })
    </script>

@endsection
