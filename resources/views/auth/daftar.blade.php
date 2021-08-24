@extends('layouts.index')

@section('css')

@endsection


@section('list')
<li class="breadcrumb-item ">Home</li>
<li class="breadcrumb-item active">Daftar</li>
@endsection

@section('content')
    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content padding-y">

        <!-- ============================ COMPONENT REGISTER   ================================= -->
        <div class="shadow-lg bg-white mx-auto" style="max-width:786px; padding:20px;">
            <h4 class="card-title mb-4">Pendaftaran</h4>
            <form method="POST" action="{{ route('daftar') }}" enctype="multipart/form-data">
                @csrf
                @if (session('errors'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Something it's wrong:
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif

                <br>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input class="form-control" type="text" name="nama_user">
                </div> <!-- form-group end.// -->
                <label>Jenis Kelamin</label>
                <div class="form-group">
                    <label class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" checked="" type="radio" name="jenis_kelamin" value="L">
                        <span class="custom-control-label"> Laki-laki </span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" type="radio" name="jenis_kelamin" value="P">
                        <span class="custom-control-label"> Perempuan </span>
                    </label>
                </div> <!-- form-group end.// -->
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="text" name="email">

                </div> <!-- form-group end.// -->
                <div class="form-group">
                    <label>Telepon</label>
                    <input class="form-control" type="text" name="telepon">
                </div> <!-- form-group end.// -->
                <div class="form-group">
                    <label>Alamat</label>
                    <input class="form-control" type="text" name="alamat">
                </div> <!-- form-group end.// -->

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Provinsi</label>
                        <select class="form-control" id="provinsi" name="id_provinsi">
                            <option value=""> Pilih Provinsi</option>
                            @foreach ($provinces as $item)
                                <option value="{{ $item->id_provinces }}"> {{ $item->name_provinces }}
                                </option>
                            @endforeach
                        </select>
                    </div> <!-- form-group end.// -->
                    <div class="form-group col-md-6">
                        <label>Kabupaten</label>
                        <select class="form-control" id="kabupaten" name="id_kabupaten"></select>
                    </div> <!-- form-group end.// -->
                    <div class="form-group col-md-6">
                        <label>Kecamatan</label>
                        <select class="form-control" id="kecamatan" name="id_kecamatan"></select>
                    </div> <!-- form-group end.// -->
                    <div class="form-group col-md-6">
                        <label>Desa</label>
                        <select class="form-control" id="desa" name="id_desa"></select>
                    </div> <!-- form-group end.// -->
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input class="form-control" type="text" name="username">
                </div> <!-- form-group end.// -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Password</label>
                        <input class="form-control" type="password"  id="pw1" name="password">
                    </div> <!-- form-group end.// -->
                    <div class="form-group col-md-6">
                        <label>Konfrimasi Password</label>
                        <input class="form-control" type="password" id="pw2" name="password_ulang">
                    </div> <!-- form-group end.// -->

                </div>
                <div class="form-group">
                    <label for="formFile" class="form-label">Foto</label>
                    <br>
                    <input type="file" id="formFile" name="foto">

                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" name="btnSubmit">Register</button>
                </div> <!-- form-group// -->
            </form>
        </div> <!-- card .// -->
        <p class="text-center mt-4 mb-5">Punya akun? <a href="{{ route('login') }}">Login</a></p>
        <!-- ============================ COMPONENT REGISTER  END.// ================================= -->


    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->

@endsection

@section('javascript')
    @parent
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 2000);
    </script>
    <script type="text/javascript">
        window.onload = function () {
            document.getElementById("pw1").onchange = validatePassword;
            document.getElementById("pw2").onchange = validatePassword;
        }
        function validatePassword(){
            var pass2=document.getElementById("pw2").value;
            var pass1=document.getElementById("pw1").value;
            if(pass1!=pass2)
                document.getElementById("pw2").setCustomValidity("Passwords Tidak Sama, Coba Lagi");
            else
                document.getElementById("pw2").setCustomValidity('');
        }
    </script>
    <script type="text/javascript">
        var base_url = window.location.origin;

        $(document).ready(function() {
            $("#provinsi").change(function() {
                var a = $("#provinsi").val();
                $.ajax({
                    type: 'GET',
                    url: base_url + "/api/wilyah_kabupaten/" + a,
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    async: "true",
                    cache: "false",
                    cache: false,
                    success: function(msg) {
                        if (msg) {
                            $("#kabupaten").empty();
                            $("#kecamatan").empty();
                            $("#desa").empty();

                            $("#kabupaten").append('<option>---Pilih Kabupaten---</option>');
                            $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                            $("#desa").append('<option>---Pilih Desa---</option>');
                            $.each(msg, function(key, value) {
                                $("#kabupaten").append('<option value=' + value
                                    .id_regencies + '>' +
                                    value.name_regencies + '</option>');
                            });
                        } else {
                            $("#kabupaten").empty();
                            $("#kecamatan").empty();
                            $("#desa").empty();
                            $("#kabupaten").append('<option>---Pilih Kabupaten---</option>');
                            $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                            $("#desa").append('<option>---Pilih Desa---</option>');
                        }
                    }
                });
                console.log(base_url + "/api/wilyah_kabupaten/" + a);
            });

            $("#kabupaten").change(function() {
                var a = $("#kabupaten").val();
                $.ajax({
                    type: 'GET',
                    url: base_url + "/api/wilyah_kecamatan/" + a,
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    async: "true",
                    cache: "false",
                    cache: false,
                    success: function(msg) {
                        if (msg) {
                            $("#kecamatan").empty();
                            $("#desa").empty();

                            $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                            $("#desa").append('<option>---Pilih Desa---</option>');
                            $.each(msg, function(key, value) {
                                $("#kecamatan").append('<option value=' + value
                                    .id_districts + '>' +
                                    value.name_districts + '</option>');
                            });
                        } else {
                            $("#kecamatan").empty();
                            $("#desa").empty();
                            $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                            $("#desa").append('<option>---Pilih Desa---</option>');
                        }
                    }
                });
            });

            $("#kecamatan").change(function() {
                var a = $("#kecamatan").val();
                $.ajax({
                    type: 'GET',
                    url: base_url + "/api/wilyah_desa/" + a,
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    async: "true",
                    cache: "false",
                    cache: false,
                    success: function(msg) {
                        if (msg) {
                            $("#desa").empty();
                            $("#desa").append('<option>---Pilih Desa---</option>');
                            $.each(msg, function(key, value) {
                                $("#desa").append('<option value=' + value.id_villages +
                                    '>' +
                                    value.name_villages + '</option>');
                            });
                        } else {
                            $("#desa").empty();
                            $("#desa").append('<option>---Pilih Desa---</option>');

                        }
                    }
                });
            });
        });
    </script>
@endsection
