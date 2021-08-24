@extends('layouts.index')

@section('css')

@endsection


@section('list')
<li class="breadcrumb-item ">Home</li>
<li class="breadcrumb-item">Profil</li>
<li class="breadcrumb-item">Detail</li>
<li class="breadcrumb-item active">{{$profil->nama_user}}</li>
@endsection

@section('content')

<div class="container">
    <div class="row">
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5 ">
            <div class="shadow-lg bg-white mx-auto ">
                <figure>
                    <span>
                        <img src="https://m.media-amazon.com/images/I/514jHGtbYAL.jpg" swidth="960" height="960">

                    </span>
                </figure>

                <div class="p-4">
                    <h5 class=" text-center text-dark">{{$profil->nama_user}}
                        <p class="card-subtitle text-center mt-1">@if ($profil->jenis_kelamin == "L")
                            Laki-laki
                        @else
                            Perempuan
                        @endif</p>
                    </h5>
                    <p class="card-subtitle text-center text-dark" style=" text-transform: uppercase;">{{$profil->alamat.' '.$profil->name_villages.' '.$profil->name_districts.' '.$profil->name_regencies.' '.$profil->name_provinces   }}</p>
                </div>
                <div class="p-4">
                    <p class="text-dark">Email : </p>
                    <p class="text-dark">{{$profil->email}}</p>
                </div>
                <div class="p-4">
                    <p class="text-dark">Telepon : </p>
                    <p class="text-dark">{{$profil->telepon}}</p>
                </div>
            </div>

        </div>

        <div class="col-lg-8 col-xlg-9 col-md-7">

            <div class="shadow-lg bg-white mx-auto">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item active"> <a class="nav-link" data-toggle="tab" href="#biodata" role="tab"
                            aria-expanded="true">Biodata</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#upload" role="tab"
                            aria-expanded="false">Upload Foto</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#password" role="tab"
                            aria-expanded="false">Baru Password</a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="biodata" role="tabpanel" aria-expanded="true">
                        <div class="card-block">
                            <form method="POST" action="{{ route('profildetailbiodata') }}">
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
                                    <label>Username</label>
                                    <input class="form-control" type="text"  value="{{$profil->username}}" required disabled>
                                </div> <!-- form-group end.// -->
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input class="form-control" type="text" name="nama_user" value="{{$profil->nama_user}}" required>
                                </div> <!-- form-group end.// -->
                                <label>Jenis Kelamin</label>
                                <div class="form-group">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input" checked="" type="radio" name="jenis_kelamin" {{ $profil->jenis_kelamin == 'L' ? 'checked' : '' }} value="L">
                                        <span class="custom-control-label"> Laki-laki </span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input" type="radio" name="jenis_kelamin" {{ $profil->jenis_kelamin == 'P' ? 'checked' : '' }} value="P">
                                        <span class="custom-control-label" > Perempuan </span>
                                    </label>
                                </div> <!-- form-group end.// -->
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" type="text" name="email" value="{{$profil->email}}" required>

                                </div> <!-- form-group end.// -->
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input class="form-control" type="number" name="telepon" value="{{$profil->telepon}}" required>
                                </div> <!-- form-group end.// -->
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input class="form-control" type="text" name="alamat"value="{{$profil->alamat}}" required>
                                </div> <!-- form-group end.// -->

                                <div class="form-row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="squareText">Provinsi</label>
                                            <select class="form-control" id="provinsi" name="id_provinsi" required>
                                                @foreach ($provinces as $item)
                                                    <option value="{{ $item->id_provinces }}"
                                                        {{ $profil->id_provinsi == $item->id_provinces ? 'selected' : '' }}>
                                                        {{ $item->name_provinces }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="squareText">Kabupaten</label>
                                            <select class="form-control" id="kabupaten" name="id_kabupaten" required>

                                                @foreach ($regencies as $item)
                                                    <option value="{{ $item->id_regencies }}"
                                                        {{ $profil->id_kabupaten == $item->id_regencies ? 'selected' : '' }}>
                                                        {{ $item->name_regencies }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="squareText">Kecamatan</label>
                                            <select class="form-control" id="kecamatan" name="id_kecamatan" required>
                                                @foreach ($districts as $item)
                                                    <option value="{{ $item->id_districts }}"
                                                        {{ $profil->id_kecamatan == $item->id_districts ? 'selected' : '' }}>
                                                        {{ $item->name_districts }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="squareText">Desa</label>
                                            <select class="form-control" id="desa" name="id_desa" required>
                                                @foreach ($villages as $item)
                                                    <option value="{{ $item->id_villages }}"
                                                        {{ $profil->id_desa == $item->id_villages ? 'selected' : '' }}>
                                                        {{ $item->name_villages }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-large btn-block btn-primary">Pembaruan</button>

                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" id="upload" role="tabpanel" aria-expanded="false">
                        <div class="card-block">
                            <form method="POST" action="{{ route('profildetailfoto') }}" enctype="multipart/form-data">
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
                                    <label for="formFile" class="form-label">Foto</label>
                                    <br>
                                    <input type="file" id="formFile" name="foto">

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Upload</button>
                                </div> <!-- form-group// -->

                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" id="password" role="tabpanel" aria-expanded="false">
                        <div class="card-block">
                            <form method="POST" action="{{ route('profildetailpassword') }}">
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
                                    <label>Password</label>
                                    <input class="form-control" type="text"  name="password" id="pw1" required >
                                </div> <!-- form-group end.// -->
                                <div class="form-group">
                                    <label>Kofrimasi Password</label>
                                    <input class="form-control" type="text" name="password_ulang" id="pw2" required>
                                </div> <!-- form-group end.// -->
                                <button class="btn btn-large btn-block btn-primary" type="submit">Simpan</button>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<div class="mb-4"></div>

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
