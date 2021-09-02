@extends('layouts.index')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endsection


@section('list')
    <li class="breadcrumb-item ">Home</li>
    <li class="breadcrumb-item active">Keranjang</li>
@endsection

@section('content')
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-cart table-mobile" id="tabel-keranjang">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Harga Penawaran</th>
                                <th>Berat</th>
                                <th>Diskon</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th></th>
                                <th style="width: 30px"></th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasil as $item)

                                <tr>
                                    <td><b>Nama Toko : </b></td>
                                    <td colspan="9">
                                        <b>{{ $item['nama_toko'] }}<br>
                                            <b>{{ 'Rp ' . number_format($item['total'], 0, ',', '.') }}</b>

                                        </b>
                                    </td>
                                    <td>
                                        <button class="btn text-info" style="border-radius: 10px;"
                                            onclick="window.location='{{ route('keranjangbayarall', $item['id_toko_penjual']) }}'">Bayar
                                            Semua</button>
                                    </td>
                                    @foreach ($item['data'] as $item_ok)
                                <tr class="cartpage">
                                    <td>
                                        @php
                                            $text = '';
                                            if ($item_ok['status_transaksi'] == 'keranjang') {
                                                $text = 'hallo kak, saya mau nawaran produk *' . $item_ok['nama_produk'] . '* apakah boleh kak?';
                                            } elseif ($item_ok['status_transaksi'] == 'penawaran') {
                                                $text = 'hallo kak, saya  mau bayar produk *' . $item_ok['nama_produk'] . '*.';
                                            } elseif ($item_ok['status_transaksi'] == 'dibayar') {
                                                $text = 'hallo kak, saya mau konfrimasi pembayaran produk *' . $item_ok['nama_produk'] . '*.';
                                            }
                                            $data = 'https://api.whatsapp.com/send?phone=' . $item_ok['nomor_hp_toko'] . '&text=' . $text . '';
                                        @endphp
                                        {{ $item_ok['status_transaksi'] }}
                                    </td>


                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="#">
                                                    <img src="assets/images/products/table/product-1.jpg"
                                                        alt="Product image" width="80px" height="80px">
                                                </a>
                                            </figure>
                                            <h3 class="product-title">
                                                <a
                                                    href="{{ route('detailproduk', ['nama' => $item_ok['nama_produk'], 'id' => $item_ok['id_produk']]) }}">{{ $item_ok['nama_produk'] }}</a>
                                                <p
                                                    onclick="window.location='{{ route('toko', $item_ok['id_toko_penjual']) }}'">
                                                    {{ $item_ok['nama_toko'] }}</p>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>

                                    <td class="price-col">
                                        <p>{{ 'Rp ' . number_format($item_ok['harga_produk'], 0, ',', '.') }}</p>
                                    </td>
                                    <td class="price-col">
                                        <p>{{ 'Rp ' . number_format($item_ok['penawaran_produk'], 0, ',', '.') }}</p>
                                    </td>

                                    <input type="hidden" id="harga_produk" value="{{ $item_ok['harga_produk'] }}">
                                    <td class="price-col">
                                        <p>{{ $item_ok['berat_produk'] }}</p>
                                    </td>
                                    <td class="price-col">
                                        <p id="diskon_produk">{{ $item_ok['diskon_produk'] }}</p>
                                    </td>
                                    <input type="hidden" id="diskon_produk" value="{{ $item_ok['diskon_produk'] }}">


                                    <td class="quantity-col">
                                        <div class="cart-product-quantity">
                                            <div class="input-group quantity">
                                                <div class="input-group-prepend decrement-btn changeQuantity"
                                                    style="cursor: pointer">
                                                    <span class="input-group-text">-</span>
                                                </div>
                                                <input class="qty-input form-control p-4"
                                                    value="{{ $item_ok['stok_produk'] }}" disabled>
                                                <div class="input-group-append increment-btn changeQuantity"
                                                    style="cursor: pointer">
                                                    <span class="input-group-text">+</span>
                                                </div>
                                            </div>
                                        </div><!-- End .cart-product-quantity -->
                                    </td>

                                    <td class="total-col">
                                        <p id="total_harga">

                                            @if ($item_ok['penawaran_produk'] == null)
                                                @if ($item_ok['diskon_produk'] == null || $item_ok['diskon_produk'] == 0)
                                                    {{ 'Rp ' . number_format($item_ok['harga_produk'] * $item_ok['stok_produk'], 0, ',', '.') }}
                                                @else
                                                    {{ 'Rp ' . number_format(($item_ok['diskon_produk'] / 100) * ($item_ok['harga_produk'] * $item_ok['stok_produk']), 0, ',', '.') }}
                                                @endif
                                            @else
                                                {{ 'Rp ' . number_format($item_ok['harga_produk'], 0, ',', '.') }}
                                            @endif


                                        </p>
                                    </td>
                                    <input type="hidden" id="id_transaksi_sementara"
                                        value="{{ $item_ok['id_transaksi_sementara'] }}">
                                    <td class="remove-col"><button class="btn-remove"><i
                                                class="icon-close"></i></button>
                                    </td>
                                    <td></td>
                                    <td class="price-col">
                                        @if ($item_ok['status_transaksi'] == 'keranjang')

                                            <a href="{{ route('keranjangbayar', ['id_transaksi_sementara' => $item_ok['id_transaksi_sementara']]) }}"
                                                class="btn btn-info m-2" style="border-radius: 10px;">Bayar</a>
                                            <a href="{{ route('keranjangpenawaran', ['id_transaksi_sementara' => $item_ok['id_transaksi_sementara']]) }}"
                                                class="btn btn-danger m-2 " style="border-radius: 10px;">Penawaran</a>
                                            <a href="{{ $data }}" class="btn btn-warning m-2"
                                                style="border-radius: 10px;">Chat</a>

                                        @elseif ($item_ok['status_transaksi'] == "penawaran")

                                            @if ($item_ok['penawaran_produk'] == null)

                                            @else
                                                <a href="{{ route('keranjangbayar', ['id_transaksi_sementara' => $item_ok['id_transaksi_sementara']]) }}"
                                                    class="btn btn-info m-2" style="border-radius: 10px;">Bayar</a>
                                            @endif
                                            <a href="{{ $data }}" class="btn btn-warning m-2"
                                                style="border-radius: 10px;">Chat</a>

                                        @elseif ($item_ok['status_transaksi'] == "dibayar")

                                            <a href="{{ route('keranjangbayar', ['id_transaksi_sementara' => $item_ok['id_transaksi_sementara']]) }}"
                                                class="btn btn-primary m-2" style="border-radius: 10px;">Konfrimasi</a>
                                            <a href="{{ $data }}" class="btn btn-warning m-2"
                                                style="border-radius: 10px;">Chat</a>

                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tr>
                            @endforeach
                        </tbody>

                    </table><!-- End .table table-wishlist -->

                </div><!-- End .col-lg-9 -->
            </div>
        </div><!-- End .container -->

    </div><!-- End .page-content -->

@endsection

@section('javascript')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.increment-btn').click(function(e) {
                e.preventDefault();
                var incre_value = $(this).parents('.quantity').find('.qty-input').val();
                var value = parseInt(incre_value, 10);
                value = isNaN(value) ? 0 : value;
                if (value < 10) {

                    value++;
                    $(this).parents('.quantity').find('.qty-input').val(value);
                }
            });

            $('.decrement-btn').click(function(e) {
                e.preventDefault();
                var decre_value = $(this).parents('.quantity').find('.qty-input').val();
                var value = parseInt(decre_value, 10);
                value = isNaN(value) ? 0 : value;
                if (value > 1) {
                    value--;
                    $(this).parents('.quantity').find('.qty-input').val(value);
                }
            });

        });

        $(document).ready(function() {

            $('.changeQuantity').click(function(e) {
                e.preventDefault();

                var stok = $(this).closest(".cartpage").find('.qty-input').val();
                var id_transaksi_sementara = $(this).closest(".cartpage").find('#id_transaksi_sementara')
                    .val();

                var data = {
                    _token: '{{ csrf_token() }}',
                    'stok': stok,
                    'id_transaksi_sementara': id_transaksi_sementara,
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('stokkeranjang') }}",
                    data: data,
                    dataType: 'JSON',

                    success: function(data) {
                        window.location.reload();
                    },

                });
            });
            $('.btn-remove').click(function(e) {
                e.preventDefault();
                var id_transaksi_sementara = $(this).closest(".cartpage").find('#id_transaksi_sementara')
                    .val();

                var data = {
                    _token: '{{ csrf_token() }}',
                    'id_transaksi_sementara': id_transaksi_sementara,
                };
                var current_object = $(this);
                swal({
                    title: "Apakah Kamu yakin?",
                    text: "Apakak kamu mau membuang belanja dari keranjang?",
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
                            url: "{{ route('hapuskeranjang') }}",
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
