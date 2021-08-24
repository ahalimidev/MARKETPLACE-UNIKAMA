@extends('layouts.index')

@section('css')

@endsection


@section('list')
    <li class="breadcrumb-item ">Home</li>
    <li class="breadcrumb-item ">Detail Produk</li>
    <li class="breadcrumb-item active">{{ $nama }}</li>
@endsection

@section('content')
    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery-image">
                            <figure class="product-main-image">
                                <img src="assets/images/products/single/1.jpg" alt="product image">

                            </figure><!-- End .product-main-image -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="product-details">
                            <h1 class="product-title">{{ $detail_produk->nama_produk }}</h1><!-- End .product-title -->

                            <div class="ratings-container">
                                <div class="ratings">
                                    @if ($detail_produk->rating > 3)
                                        <div class="ratings-val" style="width: 50%;"></div>

                                    @elseif ($detail_produk->rating > 4)
                                        <div class="ratings-val" style="width: 80%;"></div>

                                    @else
                                        <div class="ratings-val" style="width: 10%;"></div>

                                    @endif
                                </div><!-- End .ratings -->
                                <a class="ratings-text" href="#product-review-link" id="review-link">(
                                    {{ $detail_produk->total }} )</a>
                            </div><!-- End .rating-container -->

                            <div class="product-price">
                                @if ($detail_produk->diskon_produk == 0)

                                    {{ 'Rp ' . number_format($detail_produk->harga_produk, 0, ',', '.') }}
                                @else
                                    <del
                                        class="text-dark">{{ 'Rp ' . number_format($detail_produk->harga_produk, 0, ',', '.') }}</del>&nbsp;
                                    {{ 'Rp ' . number_format($detail_produk->harga_produk * ($detail_produk->diskon_produk / 100), 0, ',', '.') }}
                                @endif
                            </div><!-- End .product-price -->



                            <div class="details-filter-row details-row-size">
                                <label for="qty">Stok:</label>
                                <div class="product-details-quantity">
                                    <p>{{ $detail_produk->stok_produk }}</p>
                                </div><!-- End .product-details-quantity -->
                            </div><!-- End .details-filter-row -->
                            <div class="details-filter-row">
                                <label for="qty">Qty:</label>
                                <div class="product-details-quantity">
                                    <input type="number" id="qty" class="form-control" value="1" min="1"
                                        max="{{ $detail_produk->stok_produk }}" step="1" data-decimals="0" required>
                                </div><!-- End .product-details-quantity -->
                            </div><!-- End .details-filter-row -->
                            <div class="product-action-inner">

                                <div class="details-action-col">
                                    <a href="#" class="btn btn-danger col-sm-6 m-1 rounded-sm"><span>Penawaran</span></a>
                                    <a href="#" class="btn btn-primary col-sm-6 m-1 rounded-sm"><span>Keranjang</span></a>
                                </div><!-- End .details-action-wrapper -->



                            </div><!-- End .product-details-action -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                            role="tab" aria-controls="product-desc-tab" aria-selected="true">Keterangan Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="review-info-link" data-toggle="tab" href="#review-info-tab" role="tab"
                            aria-controls="review-info-tab" aria-selected="false">Review Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="store-shipping-link" data-toggle="tab" href="#store-shipping-tab" role="tab"
                            aria-controls="store-shipping-tab" aria-selected="false">Toko</a>
                    </li>

                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                        aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            <h3>Keterangan Produk</h3>
                            {!! $detail_produk->keterangan_produk !!}
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->

                    <div class="tab-pane fade" id="review-info-tab" role="tabpanel" aria-labelledby="review-info-link">
                        <div class="review-info-content">
                            @foreach ($review as $item)
                                <div class="review">
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <h4><a>{{ $item->nama_user }}</a></a></h4>
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    @if ($item->rating > 3)
                                                        <div class="ratings-val" style="width: 50%;"></div>

                                                    @elseif ($item->rating > 4)
                                                        <div class="ratings-val" style="width: 80%;"></div>

                                                    @else
                                                        <div class="ratings-val" style="width: 10%;"></div>

                                                    @endif
                                                </div><!-- End .ratings -->
                                            </div><!-- End .rating-container -->
                                        </div><!-- End .col -->
                                        <div class="col">
                                            <div class="review-content">
                                                <p>{{ $item->komentar }}</p>
                                            </div><!-- End .review-content -->

                                        </div><!-- End .col-auto -->
                                    </div><!-- End .row -->
                                </div>

                            @endforeach
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->

                    <div class="tab-pane fade" id="store-shipping-tab" role="tabpanel"
                        aria-labelledby="store-shipping-link">
                        <div class="store-shipping-content">
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
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->

            <h2 class="title text-center mb-4">Produk Sama Toko Lain</h2><!-- End .title text-center -->
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
