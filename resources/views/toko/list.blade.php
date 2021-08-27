@extends('layouts.index')

@section('css')

@endsection


@section('list')
    <li class="breadcrumb-item ">Profil</li>
    <li class="breadcrumb-item active">Detail Profil</li>
@endsection

@section('content')
    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-6">
                        <figure class="product-media">
                            <a href="product.html">
                                <img src="{{$toko->foto_toko}}"  alt="Product image">
                            </a>
                        </figure><!-- End .product-media -->
                    </div><!-- End .col-6 -->

                    <div class="col-6 justify-content-end">
                        <p class="product-title">Nama Toko</p>
                        <p>{{$toko->nama_toko}}</p>

                        <p class="product-title mt-2">Nomor Telepon</p>
                        <p>{{$toko->nomor_hp_toko}}</p>
                        <p class="product-title mt-2">Alamat</p>
                        <p>{{$toko->alamat.' '.$toko->name_provinces.' '.$toko->name_regencies.' '.$toko->name_districts.' '.$toko->name_villages }}</p>
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="product-title mt-2">Jam Buka</p>
                                <p>{{$toko->toko_buka}}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="product-title mt-2">Jam Buka</p>
                                <p>{{$toko->toko_tutup}}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <p class="product-title mt-2">Sosial Media Facebook</p>
                                <p>{{$toko->sosmed_fb}}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="product-title mt-2">Sosial Media Twitter</p>
                                <p>{{$toko->sosmed_tw}}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="product-title mt-2">Sosial Media Instagram</p>
                                <p>{{$toko->sosmed_ig}}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="product-title mt-2">Sosial Media Youtube</p>
                                <p>{{$toko->sosmed_yt}}</p>
                            </div>
                        </div>
                        <p class="product-title mt-2">Keterangan</p>
                        <p>{!!$toko->keterangan_toko!!}</p>
                    </div><!-- End .col-6 -->
                </div>
            </div><!-- End .product-details-top -->
            <h2 class="title text-center mt-3 mb-4">Produk Toko Ini</h2><!-- End .title text-center -->

            <div class="products mb-3">
                <div class="row justify-content-center">
                    @foreach ($paginator as $item)
                        <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                            <div class="product shadow-sm bg-white rounded">
                                <figure class="product-media">
                                    <a
                                        href="{{ route('detailproduk', ['nama' => $item->nama_produk, 'id' => $item->id_produk]) }}">
                                        <img src="{{ 'https://www.topkeren.com/wp-content/uploads/2019/10/' . $item->foto_produk }}"
                                            alt="Productimage" class="product-image">
                                    </a>
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a>{{ $item->nama_kategori . ' > ' . $item->nama_sub_kategori }}</a>
                                    </div><!-- End .product-cat -->
                                    <h3 class="product-title"><a
                                            href="{{ route('detailproduk', ['nama' => $item->nama_produk, 'id' => $item->id_produk]) }}">{{ $item->nama_produk }}</a>
                                    </h3><!-- End .product-title -->
                                    <div class="product-price">
                                        @if ($item->diskon_produk == 0)

                                            {{ 'Rp ' . number_format($item->harga_produk, 0, ',', '.') }}
                                        @else
                                            <del
                                                class="text-dark">{{ 'Rp ' . number_format($item->harga_produk, 0, ',', '.') }}</del>&nbsp;
                                            {{ 'Rp ' . number_format($item->harga_produk * ($item->diskon_produk / 100), 0, ',', '.') }}

                                        @endif
                                    </div><!-- End .product-price -->
                                    <div class="ratings-container">
                                        <div class="ratings">
                                            @if ($item->rating > 3)
                                                <div class="ratings-val" style="width: 50%;"></div>

                                            @elseif ($item->rating > 4)
                                                <div class="ratings-val" style="width: 80%;"></div>

                                            @else
                                                <div class="ratings-val" style="width: 10%;"></div>

                                            @endif
                                            <!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                        <span class="ratings-text">( {{ $item->total }} )</span>
                                    </div><!-- End .rating-container -->
                                    <a>{{$item->nama_toko}}</a>

                                </div><!-- End .product-body -->
                            </div><!-- End .product -->
                        </div>
                    @endforeach
                </div><!-- End .row -->
            </div>
            {{ $paginator->appends(request()->query())->render('pagination::simple-bootstrap-4') }}
        </div><!-- End .container -->

    </div><!-- End .page-content -->

@endsection

@section('javascript')

@endsection
