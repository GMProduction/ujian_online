@extends('guru.base')
@section('title')
    Dashboard
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('summernote/summernote.css') }}" type="text/css">
@endsection
@section('content')

    <section class="m-2">


        <div class="table-container">

            <form method="post" id="formSoal">
                @csrf
                <input id="id" name="id" hidden>
                <div class="form-group m-2">
                    <label for="soal">Soal</label>
                    <textarea id="soal" name="soal" required></textarea>
                </div>
                <div class="m-2">
                    <label class="form-label">Pilihan jawaban</label>
                    <div class="m-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="jawaban_benar" value="0" id="jawaban_benar0" aria-label="Radio button for following text input">
                                </div>
                            </div>
                            <input id="id_jawaban0" name="id_jawaban[]" hidden>
                            <input type="text" class="form-control" id="jawaban0" name="jawaban[]" aria-label="Text input with radio button" required>
                        </div>
                    </div>
                    <div class="m-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="jawaban_benar" value="1" id="jawaban_benar1" aria-label="Radio button for following text input">
                                </div>
                            </div>
                            <input id="id_jawaban1" name="id_jawaban[]" hidden>
                            <input type="text" class="form-control" id="jawaban1" name="jawaban[]" aria-label="Text input with radio button" required>
                        </div>
                    </div>
                    <div class="m-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="jawaban_benar" value="2" id="jawaban_benar2" aria-label="Radio button for following text input">
                                </div>
                            </div>
                            <input id="id_jawaban2" name="id_jawaban[]" hidden>
                            <input type="text" class="form-control" id="jawaban2" name="jawaban[]" aria-label="Text input with radio button" required>
                        </div>
                    </div>
                    <div class="m-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="jawaban_benar" value="3" id="jawaban_benar3" aria-label="Radio button for following text input">
                                </div>
                            </div>
                            <input id="id_jawaban3" name="id_jawaban[]" hidden>
                            <input type="text" class="form-control" id="jawaban3" name="jawaban[]" aria-label="Text input with radio button" required>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col m-2">
                        <a class="btn btn-primary w-100" id="kembali">Kembali</a>
                    </div>
                    <div class="col m-2">
                        <button type="submit" class="btn btn-success w-100">Simpan</button>
                    </div>
                </div>
            </form>

        </div>

    </section>


@endsection

@section('script')
    <script src="{{ asset('summernote/summernote.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $("#soal").summernote();
                {{--            $.each('{{}}')--}}
            var q = getParameter('q');
            $('#jawaban_benar0').attr('checked', '')
            if (q) {
                getData(q);
            }
            var url = window.location.pathname;
            console.log(url)
        })

        $(document).on('click', '#kembali', function () {
            var url = window.location.pathname;
            var page = '{{request('page') ? '?page='.request('page') : ''}}';
            url = url + page;
            url = url.replace('/soal', '')
            $(this).attr('href', url);
        })

        function getParameter(a) {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const page_type = urlParams.get(a)
            return page_type;
        }

        function getData(id) {
            var url = window.location.pathname;
            $.get(url + '/detail', {'q': id}, function (data) {
                console.log(data);
                $("#soal").summernote("code", data['soal']);
                $('#formSoal #id').val(data['id'])
                $.each(data['get_jawaban_all'], function (key, value) {
                    $('#jawaban' + key).val(value['jawaban'])
                    $('#id_jawaban' + key).val(value['id'])
                    $('#jawaban_benar' + key).val(value['id'])
                    if (value['jawaban_benar'] === 1) {
                        $('#jawaban_benar' + key).attr('checked', '')
                    }
                })
            })
        }

    </script>

@endsection
