@extends('layouts.index')

@section('css')

@endsection


@section('list')
    <li class="breadcrumb-item active"><a href="index.html">Home</a></li>
@endsection

@section('content')
<div class="container mt-2">
    <div class="cat-blocks-container">
        <div class="row">
            @foreach ($menu_kategori as $item)
                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="{{ route('kategori',['nama'=>$item->nama_kategori,'id'=>$item->id_kategori]) }}" class="cat-block">
                        <figure>
                            <span>
                                <img src="{{'https://cdn.pixabay.com/photo/2012/04/14/16/19/'.$item->foto_kategori}}" width="60" height="60" alt="Category image">
                            </span>
                        </figure>

                        <h3 class="cat-block-title">{{$item->nama_kategori}}</h3><!-- End .cat-block-title -->
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="bg-light pt-5 pb-6">
    <div class="container trending-products">
        <div class="heading heading-flex mb-3">
            <div class="heading-left">
                <h2 class="title">Produk Terlaris</h2><!-- End .title -->
            </div><!-- End .heading-left -->
        </div><!-- End .heading -->
        <div class="col-xl-12-3col">
            <div class="tab-content tab-content-carousel just-action-icons-sm">
                <div class="tab-pane p-0 fade show active" id="trending-top-tab" role="tabpanel"
                    aria-labelledby="trending-top-link">
                    <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light"
                        data-toggle="owl" data-owl-options='{"nav": true,"dots": false,"margin": 20,"loop": false,"responsive": {"0": {"items":2},"480": {"items":2},"768": {"items":3},"992": {"items":4}}}'>
                        @foreach ($telaris as $item)
                        <div class="product shadow-sm bg-white rounded">
                            <figure class="product-media">
                                <a href="{{ route('detailproduk', [ 'nama'=> $item->nama_produk, 'id'=>$item->id_produk]) }}">
                                    <img src="{{"https://www.topkeren.com/wp-content/uploads/2019/10/".$item->foto_produk}}"
                                        alt="Product image" class="product-image">
                                </a>
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a>{{$item->nama_kategori.' > '.$item->nama_sub_kategori}}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="{{ route('detailproduk', [ 'nama'=> $item->nama_produk, 'id'=>$item->id_produk]) }}">{{$item->nama_produk}}</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    @if ($item->diskon_produk == 0)

                                        {{ "Rp " . number_format($item->harga_produk,0,',','.')}}
                                    @else
                                        <del class="text-dark">{{"Rp " . number_format($item->harga_produk,0,',','.')}}</del>&nbsp; {{"Rp " . number_format($item->harga_produk  * ($item->diskon_produk / 100),0,',','.')  }}
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
                                    <span class="ratings-text">( {{$item->total}} )</span>
                                </div><!-- End .rating-container -->
                                <a>{{$item->nama_toko}}</a>
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->

                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div><!-- End .row -->
</div>

<div class="mb-5"></div>

<div class="container for-you">
    <div class="heading heading-flex mb-3">
        <div class="heading-left">
            <h2 class="title">Produk Terbaru</h2><!-- End .title -->
        </div><!-- End .heading-left -->
    </div><!-- End .heading -->

    <div class="products">
        <div class="row justify-content-center">

            @foreach ($terbaru as $item)
            <div class="col-6 col-md-3 col-lg-3">
                <div class="product shadow-sm bg-white rounded">
                    <figure class="product-media">
                        <a href="{{ route('detailproduk', [ 'nama'=> $item->nama_produk, 'id'=>$item->id_produk]) }}">
                            <img src="{{"https://www.topkeren.com/wp-content/uploads/2019/10/".$item->foto_produk}}"
                                alt="Productimage" class="product-image">
                        </a>
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <div class="product-cat">
                            <a>{{$item->nama_kategori.' > '.$item->nama_sub_kategori}}</a>
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="{{ route('detailproduk',[ 'nama'=> $item->nama_produk, 'id'=>$item->id_produk]) }}">{{$item->nama_produk}}</a></h3><!-- End .product-title -->
                        <div class="product-price">
                            @if ($item->diskon_produk == 0)

                            {{ "Rp " . number_format($item->harga_produk,0,',','.')}}
                            @else
                            <del class="text-dark">{{"Rp " . number_format($item->harga_produk,0,',','.')}}</del>&nbsp; {{"Rp " . number_format($item->harga_produk  * ($item->diskon_produk / 100),0,',','.')  }}

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
                            <span class="ratings-text">( {{$item->total}} )</span>
                        </div><!-- End .rating-container -->
                        <a>{{$item->nama_toko}}</a>

                    </div><!-- End .product-body -->
                </div><!-- End .product -->
            </div>
            @endforeach

        </div><!-- End .row -->

    </div><!-- End .products -->
</div>
@endsection

@section('javascript')

@endsection
