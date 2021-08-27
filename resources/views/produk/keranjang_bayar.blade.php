@extends('layouts.index')

@section('css')
@endsection


@section('list')
    <li class="breadcrumb-item ">Home</li>
    <li class="breadcrumb-item ">Keranjang</li>
    <li class="breadcrumb-item active">Pembayaran</li>
@endsection

@section('content')
    <div class="page-content">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <h5 class="mt-3">Alamat Pengiriman</h5>
                    <input type="text" value="" class="form-control" disabled>
                    <Button class="btn btn-primary btn-sm mb-2" style="border-radius: 10px;">Tambah Alamat</Button>
                    <table class="table table-cart table-mobile" id="tabel-keranjang">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Berat</th>
                                <th>Diskon</th>
                                <th>Jumlah</th>
                                <th>Total</th>

                            </tr>
                        </thead>
                    </table><!-- End .table table-wishlist -->
                    <div class="row">
                        <div class="col-sm-6">
                            <table style="width:100%" class="mb-5">
                                <tr>
                                    <th>Nama Toko:</th>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <th>Total Pembelian:</th>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <th>Ongkir:</th>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <th>Total Pembayaran:</th>
                                    <td>-</td>
                                </tr>
                            </table>

                        </div>
                        <div class="col-sm-6">

                            <h5>Pilih Jasa Pengiriman</h5>
                            <table class="table">
                                <tr>
                                    <td>Kurir:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Service:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Ongkir:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Waktu:</td>
                                    <td>-</td>
                                </tr>
                            </table>
                            <Button class="btn btn-primary btn-sm col" style="border-radius: 10px;">Tambah Kurir</Button>

                        </div>
                    </div><!-- End .col-lg-9 -->
                </div>
            </div><!-- End .container -->

        </div><!-- End .page-content -->

    @endsection

    @section('javascript')
        @parent

    @endsection
