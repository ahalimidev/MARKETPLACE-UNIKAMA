@extends('layouts.index')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

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
                    <input type="text" class="form-control"
                        value="{{ 'Rp ' . number_format($transaksi->total_bayar_barang, 0, ',', '.') }}"
                        style="border-radius: 5px;" disabled>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="helpInputTop"><b>Ongkir</b></label>
                    <br>
                    <input type="text" class="form-control"
                        value="{{ 'Rp ' . number_format($transaksi->total_bayar_kurir, 0, ',', '.') }}"
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
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="helpInputTop"><b>Tanggal Dibayar</b></label>
                    <br>
                    <input type="text" class="form-control" value="{{ $transaksi->tanggal_dibayar }}"
                        style="border-radius: 5px;" disabled>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="helpInputTop"><b>Tanggal Dikirim</b></label>
                    <br>
                    <input type="text" class="form-control" value="{{ $transaksi->tanggal_kirim }}"
                        style="border-radius: 5px;" disabled>

                </div>
            </div>
        </div>

        <button class="btn btn-primary mb-5 mt-3" style="border-radius: 5px;"
            onclick="window.location.href='{{ route('tampiltracking', $transaksi->nomor_resi) }}' ">Tracking</button>
        <button class="btn btn-danger mb-5 mt-3 bt-terima-barang" style="border-radius: 5px; ">Barang Terima</button>

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
                                <td class="product-col">{{ 'Rp ' . number_format($item->harga_produk, 0, ',', '.') }}
                                </td>
                            @else
                                <td class="product-col">
                                    {{ 'Rp ' . number_format($item->penawaran_produk, 0, ',', '.') }}</td>
                            @endif

                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {


            $('.bt-terima-barang').click(function(e) {
                e.preventDefault();

                var data = {
                    _token: '{{ csrf_token() }}',
                    'id_transaksi': "{{ $transaksi->id_transaksi }}",
                };
                console.log(data);

                var current_object = $(this);
                swal({
                    title: "Apakah Kamu yakin?",
                    text: "Apakah Barang sudah sampai di tangan anda?",
                    type: "info",
                    showCancelButton: true,
                    cancelButtonClass: '#DD6B55',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Terima',
                }, function(result) {
                    if (result) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('terimabarang') }}",
                            data: data,
                            dataType: 'JSON',

                            success: function() {
                              return window.location.href = "{{route('tampildetailtampil', $transaksi->id_transaksi)}}"
                            },

                        });
                    }
                });
            });
        });
    </script>
@endsection
