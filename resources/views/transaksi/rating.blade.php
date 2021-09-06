@extends('layouts.index')

@section('css')

@endsection


@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="helpInputTop"><b>Nama Toko</b></label>
                <br>
                <input type="text" class="form-control"
                value="{{$transaksi_detail->nama_toko}}"
                style="border-radius: 5px;" disabled>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="helpInputTop"><b>Nama Produk</b></label>
                <br>
                <input type="text" class="form-control"
                value="{{$transaksi_detail->nama_produk}}"
                style="border-radius: 5px;" disabled>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="helpInputTop"><b>Jumlah</b></label>
                <br>
                <input type="text" class="form-control"
                value="{{$transaksi_detail->stok_produk}}"
                style="border-radius: 5px;" disabled>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="helpInputTop"><b>Harga</b></label>
                <br>
                <input type="text" class="form-control"
                value="{{ 'Rp ' . number_format($transaksi_detail->harga_produk, 0, ',', '.') }}"
                style="border-radius: 5px;" disabled>
            </div>
        </div>

    </div>
    <form action="{{route('komrat',$transaksi_detail->id_transaksi_detail)}}" method="POST">
        @csrf
        @method('PUT')
        <h5 class="modal-title header-center" id="title">BERIKAN RATING DAN KOMENTAR PRODUK INI</h5>
        <br>
        <div class="form-group">
            <select class="form-control" name="rating" id="rating" required>
                <option selected>Pilih Rating</option>
                <option value="1">Sangat Buruk</option>
                <option value="2">Buruk</option>
                <option value="3">Cukup</option>
                <option value="4">Baik</option>
                <option value="5">Sangat Baik</option>
            </select>
        </div>
        <input type="text" name="komentar" id="komentar" class="form-control"
            placeholder="Masukkan Komentar" required>
        <button class="btn btn-primary col">Terima</button>
    </form>
</div>
@endsection
@section('javascript')

@endsection
