@extends('layouts.index')

@section('css')

@endsection


@section('list')
<li class="breadcrumb-item ">Home</li>
<li class="breadcrumb-item ">Pencarian</li>
<li class="breadcrumb-item active" ><a href="#">{{$data}}</a></li>
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
<div class="container">
    <div class="row">
        <aside class="col-lg-3 order-lg-first">
            <div class="sidebar sidebar-shop">
                <div class="widget widget-collapsible">
                    <h3 class="widget-title">
                        Perncarian Produk
                    </h3>
                    <form>
                        <input type="hidden" name='keyword' value="{{$data}}">
                        <select name="filter" id="filter" class="form-control">
                            <option value="terlaris">Terlaris</option>
                            <option value="terbaru">terbaru</option>
                        </select>
                        <button type="submit" class="btn btn-primary col">Cari</button>
                    </form>
                </div>
            </div><!-- End .sidebar sidebar-shop -->

            <div class="sidebar sidebar-shop">
                <div class="widget widget-collapsible">
                    <h3 class="widget-title">
                        Perncarian Harga
                    </h3>
                       <form >
                            <input type="hidden" name='keyword' value="{{$data}}">
                            <input type="text" placeholder="Harga Awal dari 0" class="form-control" name="harga_awal" required>
                            <input type="text" placeholder="Harga Akhir" class="form-control" name="harga_akhir" required>
                            <button class="btn btn-primary col" type="submit">Cari</button>
                       </form>
                </div>
            </div><!-- End .sidebar sidebar-shop -->

        </aside><!-- End .col-lg-3 -->
        <div class="col-lg-9">
            <div class="toolbox">
                <div class="toolbox-left">
                    <div class="toolbox-info">
                        Menampilkan <span>1 Ke {{$paginator->total()}}</span> Produk
                    </div><!-- End .toolbox-info -->
                </div><!-- End .toolbox-left -->

            </div><!-- End .toolbox -->

            <div class="products mb-3">
                <div class="row justify-content-center">
                    @foreach ($paginator as $item)
                    <div class="col-6 col-md-4 col-lg-4 col-xl-3">
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
                    </div>
                    @endforeach
                </div><!-- End .row -->


            </div><!-- End .products -->
            {{ $paginator->appends(request()->query())->render('pagination::simple-bootstrap-4') }}


        </div><!-- End .col-lg-9 -->

    </div><!-- End .row -->
</div><!-- End .container -->
@endsection

@section('javascript')

@endsection
