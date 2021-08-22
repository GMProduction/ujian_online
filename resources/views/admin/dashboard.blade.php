@extends('admin.base')
@section('title')
Dashboard
@endsection
@section('content')

    <section class="m-2">


        <div class="table-container">

            {{-- <h5 class="mb-3">Permintaan peminjaman barang</h5>

                <table class="table table-striped table-bordered ">
                    <thead>
                        <th>
                            #
                        </th>
                        <th>
                            Tanggal Pinjam
                        </th>
                        <th>
                            Nama Barang
                        </th>
                        <th>
                            Jumlah Pinjam
                        </th>

                        <th>
                            Nama Siswa
                        </th>

                        <th>
                            Mapel
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Action
                        </th>

                    </thead>


                </table>

            </div> --}}

        <div class="table-container">

        <h5 class="mb-3">Barang yang sedang di pinjam</h5>

            <table class="table table-striped table-bordered ">
                <thead>
                    <th>
                        #
                    </th>
                    <th>
                        Tanggal Pinjam
                    </th>
                    <th>
                        Nama Barang
                    </th>
                    <th>
                        Jumlah Pinjam
                    </th>

                    <th>
                        Nama Siswa
                    </th>

                    <th>
                        Mapel
                    </th>

                    <th>
                        Status
                    </th>

                </thead>


            </table>

        </div>
    </section>


@endsection

@section('script')


@endsection
