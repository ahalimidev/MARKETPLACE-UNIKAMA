@extends('layouts.index')

@section('css')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            @php
                $text = 'hallo kak, saya mau konfrimasi pembayaran *' . $transaksi->nomor_transaksi . '* serta bukti pembayarannya dengan nominal ' . number_format($transaksi->total_bayar_kurir + $transaksi->total_bayar_barang, 0, ',', '.');
                $data = 'https://api.whatsapp.com/send?phone=' . $transaksi->nomor_hp_toko . '&text=' . $text . '';
            @endphp
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="helpInputTop"><b>Nomor transaki</b></label>
                    <br>
                    <input type="text" class="form-control" value="{{ $transaksi->nomor_transaksi }}"
                        style="border-radius: 5px;" disabled>

                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="helpInputTop"><b>Total Harga Barang</b></label>
                    <br>
                    <input type="text" class="form-control" value="{{'Rp ' . number_format($transaksi->total_bayar_barang, 0, ',', '.') }}"
                        style="border-radius: 5px;" disabled>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="helpInputTop"><b>Ongkir</b></label>
                    <br>
                    <input type="text" class="form-control" value="{{'Rp ' . number_format($transaksi->total_bayar_kurir, 0, ',', '.') }}"
                        style="border-radius: 5px;" disabled>

                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="helpInputTop"><b>Total Pembayaran</b></label>
                    <br>
                    <input type="text" class="form-control"
                        value="{{ 'Rp ' . number_format($transaksi->total_bayar_barang + $transaksi->total_bayar_kurir, 0, ',', '.') }}"
                        style="border-radius: 5px;" disabled>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="helpInputTop"><b>Jasa Kurir</b></label>
                    <br>
                    <input type="text" class="form-control" value="{{ $transaksi->jasa_kurir }}"
                        style="border-radius: 5px;" disabled>

                </div>
            </div>

            <div class="col-sm-8">
                <div class="form-group">
                    <label for="helpInputTop"><b>Alamat</b></label>
                    <br>
                    <input type="text" class="form-control" value="{{ $transaksi->lokasi_pengiriman }}"
                        style="border-radius: 5px;" disabled>
                </div>
            </div>
        </div>

        <button class="btn btn-primary mb-5 mt-3" style="border-radius: 5px;" onclick="window.open('{{$data}}', '_blank')">Konfrimasi Bayar</button>
        <div class="table-responsive">
            <table class="table table-cart ">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Toko</th>
                        <th>Nama Produk</th>
                        <th>foto</th>
                        <th>Jumlah</th>
                        <th>Harga</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor = 1;
                    @endphp
                    @foreach ($transaksi_detail as $item)
                        <tr>
                            <td class="product-col">{{ $nomor++ }}</td>
                            <td class="product-col">{{ $item->nama_toko }}</td>
                            <td class="product-col">{{ $item->nama_produk }}</td>
                            <td class="product-col">
                                <a href="#">
                                    <img src="assets/images/products/table/product-1.jpg" alt="Product image" width="80px"
                                        height="80px">
                                </a>
                            </td>

                            <td class="product-col">{{ $item->stok_produk }}</td>
                            @if (($item->penawaran_produk == null) | ($item->penawaran_produk == 0))
                                <td class="product-col">{{ 'Rp ' . number_format($item->harga_produk, 0, ',', '.') }}</td>
                            @else
                                <td class="product-col">{{ 'Rp ' . number_format($item->penawaran_produk, 0, ',', '.')  }}</td>
                            @endif

                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('javascript')

@endsection
