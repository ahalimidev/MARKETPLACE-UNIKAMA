@extends('layouts.index')

@section('css')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endsection
@section('list')
    <li class="breadcrumb-item ">Home</li>
    <li class="breadcrumb-item">Profil dan Transaksi</li>
    <li class="breadcrumb-item active">{{ $profil->nama_user }}</li>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-9 col-xlg-6 col-md-5 ">

                <div class="shadow-lg bg-white mx-auto">
                    <!-- Nav tabs -->
                    <h4 class="card-title p-4 text-center">Transaksi</h4>

                    <ul class="nav nav-tabs profile-tab" role="tablist">
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#konfrimasitransaksi"
                                role="tab" aria-expanded="false" style="font-size: 12px;">Pembayaran</a> </li>

                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#pengriman" role="tab"
                                aria-expanded="false" style="font-size: 12px;">Pengiriman</a> </li>

                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#terima" role="tab"
                                aria-expanded="false" style="font-size: 12px;">Terima</a> </li>

                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#batal" role="tab"
                                aria-expanded="false" style="font-size: 12px;">Batal</a> </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div class="tab-pane active" id="konfrimasitransaksi" role="tabpanel" aria-expanded="true">
                            <div class="table-responsive">
                                <table class="table table-cart " id="tabel-pembayaran">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 12px;">Nomor Transaksi</th>
                                            <th style="font-size: 12px;">Alamat</th>
                                            <th style="font-size: 12px;">Total dibayar</th>
                                            <th style="font-size: 12px;">Jasa pengirman</th>
                                            <th style="font-size: 12px;">Jumlah Produk</th>
                                            <th style="font-size: 12px;">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($konfrimasi as $item)
                                            <tr class="cart-konfrimasi">
                                                <input type="hidden" id="id_transaksi" value="{{ $item->id_transaksi }}" >

                                                <td class="price-col" style="font-size: 12px;">
                                                    {{ $item->nomor_transaksi }}</td>
                                                <td class="price-col" style="font-size: 12px;">
                                                    {{ $item->lokasi_pengiriman }}</td>

                                                <td class="price-col" style="font-size: 12px;">
                                                    {{ 'Rp ' . number_format($item->total_bayar_kurir + $item->total_bayar_barang, 0, ',', '.') }}
                                                </td>

                                                <td class="price-col" style="text-align: center; font-size: 12px;">
                                                    {{ $item->jasa_kurir }}</td>
                                                <td style="text-align: center; font-size: 12px;" class="price-col">
                                                    {{ $item->total }}</td>

                                                <td class="price-col">

                                                    <button class="btn-info m-1"
                                                        style="border-radius: 5px; min-width: 70px; font-size: 12px;" onclick="window.location.href='{{route('tampildetailpembayaran',$item->id_transaksi)}}' ">Konfrimasi</button>
                                                    <button class="btn-danger m-1 bt-remove-pembayaran"
                                                        style="border-radius: 5px; min-width: 70px; font-size: 12px; ">Batal</button>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $konfrimasi->appends(request()->query())->render('pagination::simple-bootstrap-4') }}

                            </div>
                        </div>
                        <div class="tab-pane" id="pengriman" role="tabpanel" aria-expanded="false">
                            <div class="table-responsive">
                                <table class="table table-cart " id="tabel-selesai">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 12px;">Nomor Transaksi</th>
                                            <th style="font-size: 12px;">Nomor Resi</th>
                                            <th style="font-size: 12px;">Alamat</th>
                                            <th style="font-size: 12px;">Total dibayar</th>
                                            <th style="font-size: 12px;">Jasa pengirman</th>
                                            <th style="font-size: 12px;">Jumlah Produk</th>
                                            <th style="font-size: 12px;">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($selesai as $item)
                                            <tr>

                                                <td class="price-col" style="font-size: 12px;">
                                                    {{ $item->nomor_transaksi }}</td>

                                                <td class="price-col" style="font-size: 12px; text-align: center;">
                                                    {{ $item->nomor_resi }}
                                                </td>
                                                <td class="price-col" style="font-size: 12px;">
                                                    {{ $item->lokasi_pengiriman }}</td>

                                                <td class="price-col" style="font-size: 12px;">
                                                    {{ 'Rp ' . number_format($item->total_bayar_kurir + $item->total_bayar_barang, 0, ',', '.') }}
                                                </td>

                                                <td class="price-col" style="text-align: center; font-size: 12px;">
                                                    {{ $item->jasa_kurir }}</td>
                                                <td style="text-align: center; font-size: 12px;" class="price-col">
                                                    {{ $item->total }}</td>
                                                <td class="price-col">
                                                    <button class="btn-info"
                                                        style="border-radius: 5px; min-width: 70px; font-size: 12px;"  onclick="window.location.href='{{route('tampildetailpengrimanan',$item->id_transaksi)}}' ">Lihat</button>
                                                    <button class="btn-primary"
                                                        style="border-radius: 5px; min-width: 70px; font-size: 12px;" onclick="window.location.href='{{route('tampiltracking',$item->nomor_resi)}}' ">Tracking</button>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $konfrimasi->appends(request()->query())->render('pagination::simple-bootstrap-4') }}
                            </div>
                        </div>
                        <div class="tab-pane" id="terima" role="tabpanel" aria-expanded="false">
                            <div class="table-responsive">
                                <table class="table table-cart " id="tabel-terima">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 12px;">Nomor Transaksi</th>
                                            <th style="font-size: 12px;">Nomor Resi</th>
                                            <th style="font-size: 12px;">Alamat</th>
                                            <th style="font-size: 12px;">Total dibayar</th>
                                            <th style="font-size: 12px;">Jasa pengirman</th>
                                            <th style="font-size: 12px;">Jumlah Produk</th>
                                            <th style="font-size: 12px;">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($terima as $item)
                                            <tr>
                                                <td class="price-col" style="font-size: 12px;">
                                                    {{ $item->nomor_transaksi }}</td>
                                                <td class="price-col" style="font-size: 12px;">
                                                    {{ $item->nomor_resi }}
                                                </td>
                                                <td class="price-col" style="font-size: 12px;">
                                                    {{ $item->lokasi_pengiriman }}</td>

                                                <td class="price-col" style="font-size: 12px;">
                                                    {{ 'Rp ' . number_format($item->total_bayar_kurir + $item->total_bayar_barang, 0, ',', '.') }}
                                                </td>

                                                <td class="price-col" style="text-align: center; font-size: 12px;">
                                                    {{ $item->jasa_kurir }}</td>
                                                <td style="text-align: center; font-size: 12px;" class="price-col">
                                                    {{ $item->total }}</td>
                                                <td class="price-col">
                                                    <button class="btn-info"
                                                    style="border-radius: 5px; min-width: 70px; font-size: 12px;" onclick="window.location.href='{{route('tampildetailtampil',$item->id_transaksi)}}' ">lihat</button>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $terima->appends(request()->query())->render('pagination::simple-bootstrap-4') }}
                            </div>
                        </div>
                        <div class="tab-pane" id="batal" role="tabpanel" aria-expanded="false">
                            <div class="table-responsive">
                                <table class="table table-cart " id="tabel-terima">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 12px;">Nomor Transaksi</th>
                                            <th style="font-size: 12px;">Catatan Batal</th>

                                            <th style="font-size: 12px;">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($batal as $item)
                                            <tr>
                                                <td class="product-col" style="font-size: 12px;">
                                                    {{ $item->nomor_transaksi }}</td>
                                                <td style="font-size: 12px;" class="product-col">
                                                    {{ $item->catatan_batal }}</td>
                                                <td class="price-col">
                                                    <button class="btn-info"
                                                        style="border-radius: 5px; min-width: 70px; font-size: 12px;"  onclick="window.location.href='{{route('tampildetailbatal',$item->id_transaksi)}}' ">Lihat</button>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $terima->appends(request()->query())->render('pagination::simple-bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xlg-6 col-md-5 ">
                <div class="shadow-lg bg-white mx-auto ">
                    <figure>
                        <span>
                            <img src="https://m.media-amazon.com/images/I/514jHGtbYAL.jpg" width="500" height="500">

                        </span>
                    </figure>

                    <div class="p-4">
                        <h5 class=" text-center text-dark">{{ $profil->nama_user }}
                            <p class="card-subtitle text-center mt-1">
                                @if ($profil->jenis_kelamin == 'L')
                                    Laki-laki
                                @else
                                    Perempuan
                                @endif
                            </p>
                        </h5>
                        <p class="card-subtitle text-center text-dark" style=" text-transform: uppercase; font-size: 12px;">
                            {{ $profil->alamat . ' ' . $profil->name_villages . ' ' . $profil->name_districts . ' ' . $profil->name_regencies . ' ' . $profil->name_provinces }}
                        </p>
                    </div>
                    <div class="p-4">
                        <p class="text-dark">Email : </p>
                        <p class="text-dark" style=" font-size: 12px;">{{ $profil->email }}</p>
                    </div>
                    <div class="p-4">
                        <p class="text-dark">Telepon : </p>
                        <p class="text-dark" style=" font-size: 12px;">{{ $profil->telepon }}</p>
                    </div>
                    <button class="btn btn-large col-sm-12 btn-primary"
                        onclick="window.location='{{ route('profildetail') }}'">Pengaturan Profil</button>

                    <button class="btn btn-large col-sm-12 btn-danger"
                        onclick="window.location='{{ route('logout') }}'">Keluar Aplikasi</button>
                </div>

            </div>


        </div>
    </div>
    <div class="mb-4"></div>

@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.bt-remove-pembayaran').click(function(e) {
                e.preventDefault();
                var id_transaksi = $(this).closest(".cart-konfrimasi").find('#id_transaksi').val();
                var data = {
                    _token: '{{ csrf_token() }}',
                    'id_transaksi': id_transaksi,
                };
                console.log(data)

                var current_object = $(this);
                swal({
                    title: "Peringatan",
                    text: "Apakah anda yakin menbatalkan transaksi ini?",
                    type: "error",
                    showCancelButton: true,
                    dangerMode: true,
                    cancelButtonClass: '#DD6B55',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Delete!',
                }, function(result) {
                    if (result) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('hapuskonfrimasipembayaran') }}",
                            data: data,
                            dataType: 'JSON',

                            success: function(data) {
                                window.location.reload();

                            },

                        });
                    }
                });
            });
        });
    </script>
@endsection
