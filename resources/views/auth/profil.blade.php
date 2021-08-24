@extends('layouts.index')

@section('css')

@endsection


@section('list')
<li class="breadcrumb-item ">Home</li>
<li class="breadcrumb-item">Profil dan Transaksi</li>
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
                <button class="btn btn-large btn-block btn-primary"  onclick="window.location='{{ route('profildetail') }}'">Pengaturan Profil</button>

                <button class="btn btn-large btn-block btn-danger"   onclick="window.location='{{ route('logout') }}'">Keluar Aplikasi</button>
            </div>

        </div>

        <div class="col-lg-8 col-xlg-9 col-md-7">

            <div class="shadow-lg bg-white mx-auto">
                <!-- Nav tabs -->
                <h4 class="card-title p-4 text-center">Transaksi</h4>

                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#penawaran" role="tab"
                            aria-expanded="true">Penawaran</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#belumbayar" role="tab"
                            aria-expanded="false">Harus Dibayar</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#konfrimasitransaksi" role="tab"
                            aria-expanded="false">Konfrimasi Transaksi</a> </li>

                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#pengriman" role="tab"
                            aria-expanded="false">Pengiriman</a> </li>

                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#terima" role="tab"
                            aria-expanded="false">Terima</a> </li>

                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#batal" role="tab"
                            aria-expanded="false">Batal</a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane" id="penawaran" role="tabpanel" aria-expanded="true">
                        <div class="card-block">

                        </div>
                    </div>
                    <div class="tab-pane" id="belumbayar" role="tabpanel" aria-expanded="false">
                        <div class="card-block">

                        </div>
                    </div>
                    <div class="tab-pane" id="konfrimasitransaksi" role="tabpanel" aria-expanded="false">
                        <div class="card-block">

                        </div>
                    </div>
                    <div class="tab-pane" id="pengriman" role="tabpanel" aria-expanded="false">
                        <div class="card-block">

                        </div>
                    </div>
                    <div class="tab-pane" id="terima" role="tabpanel" aria-expanded="false">
                        <div class="card-block">

                        </div>
                    </div>
                    <div class="tab-pane" id="batal" role="tabpanel" aria-expanded="false">
                        <div class="card-block">

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

@endsection
