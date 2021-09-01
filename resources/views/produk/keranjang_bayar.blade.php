@extends('layouts.index')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/css/intlTelInput.css') }}">
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
                    <p class="form-control" id="alamat_pengriman"></p>
                    <Button class="btn btn-primary btn-sm mb-2" style="border-radius: 10px;" id="tambahAlamat">Tambah
                        Alamat</Button>
                    <table class="table table-mobile" id="tabel-keranjang">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Harga Penawaran</th>
                                <th>Berat</th>
                                <th>Diskon</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nomor = 1;
                                $sum = 0;
                            @endphp
                            @foreach ($keranjang as $item)
                                <tr>
                                    <td>{{ $nomor++ }}</td>
                                    <td id="id_keranjang" hidden>{{ $item->id_transaksi_sementara }}</td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->harga_produk }}</td>
                                    <td>{{ $item->penawaran_produk }}</td>
                                    <td id="berat_produk">{{ $item->berat_produk }}</td>
                                    <td>{{ $item->diskon_produk }}</td>
                                    <td>{{ $item->stok_produk }}</td>
                                    <td>
                                        @if ($item->penawaran_produk == null)
                                            {{ 'Rp ' . number_format(($item->diskon_produk / 100) * ($item->harga_produk * $item->stok_produk), 0, ',', '.') }}
                                        @else
                                            {{ 'Rp ' . number_format($item->penawaran_produk, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td hidden>
                                        @php
                                            if ($item->penawaran_produk == null) {
                                                $sum += ($item->diskon_produk / 100) * ($item->harga_produk * $item->stok_produk);
                                            } else {
                                                $sum += $item->penawaran_produk;
                                            }
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table><!-- End .table table-wishlist -->
                    <div class="row">

                        <div class="col-sm-6">

                            <h5>Pilih Jasa Pengiriman</h5>
                            <div id="total_belanja"></div>
                            <Button class="btn btn-primary btn-sm" style="border-radius: 10px;" id="tambah_kurir"
                                type="button" disabled>Tambah Kurir</Button>

                        </div>
                        <div class="col-sm-6">
                            <table style="width:100%" class="mb-5">
                                <tr>
                                    <th>Nama Toko:</th>
                                    <th>{{ $toko->nama_toko }}</th>
                                </tr>
                                <tr>
                                    <th>Total Pembelian:</th>
                                    <th>{{ 'Rp ' . number_format($sum, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th>Ongkir:</th>
                                    <th id="total_ongkir">-</th>
                                </tr>
                                <tr>
                                    <th>Total Pembayaran:</th>
                                    <th id="total_dibayar">-</th>
                                </tr>
                            </table>
                            <Button class="btn btn-danger btn-sm" style="border-radius: 10px;" id="transaksi" type="button"
                                disabled>Selesai</Button>
                        </div>
                    </div><!-- End .col-lg-9 -->
                </div>
            </div><!-- End .container -->

        </div><!-- End .page-content -->
    </div>

    <div class="modal fade " id="modalAlamat" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <form id="formalamat">
                                @csrf
                                <div class="form-row">
                                    <div class="col-sm-12 form-group">
                                        <label>Nama</label>
                                        <input type="text" id="nama" class="form-control" required>
                                    </div> <!-- form-group end.// -->
                                    <div class="col-sm-12 form-group">
                                        <label>Nomor Telepon</label>
                                        <br>
                                        <input type="tel" style=" width: 100%;" name="nomor_telepon" id="phone"
                                            class="form-control phone" required>
                                        <small id="teleponError" style="color: red"></small>
                                    </div> <!-- form-group end.// -->
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12 form-group">
                                        <label>PROVINSI</label>
                                        <select name="provinsi" id="provinsi" class="form-control" required>
                                            <option id="provinsi_option">---PILIH PROVINSI---</option>
                                        </select>
                                        <input type="hidden" name="nama_provinsi" id="nama_provinsi" class="form-control">
                                    </div> <!-- form-group end.// -->
                                    <div class="col-sm-12 form-group">
                                        <label>KOTA</label>
                                        <select name="kota" id="kota" class="form-control" disabled required>
                                            <option>---PILIH KOTA---</option>
                                        </select>
                                        <input type="hidden" name="nama_kota" id="nama_kota" class="form-control">
                                    </div> <!-- form-group end.// -->
                                    <div class="col-sm-12 form-group">
                                        <label>KECAMATAN</label>
                                        <select name="kecamatan" id="kecamatan" class="form-control" disabled required>
                                            <option>---PILIH KECAMATAN---</option>
                                        </select>
                                        <input type="hidden" name="nama_kecamatan" id="nama_kecamatan"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12 form-group">
                                        <label>Nama Desa</label>
                                        <input type="text" name="nama_desa" id="nama_desa" class="form-control" required>
                                    </div> <!-- form-group end.// -->
                                    <div class="col-sm-12 form-group">
                                        <label>Kode Pos</label>
                                        <input type="text" name="kode_pos" id="kode_pos" class="form-control" required>
                                        <small id="kodePosError" style="color: red"></small>
                                    </div> <!-- form-group end.// -->
                                    <div class="col-sm-12 form-group">
                                        <label>Alamat Lengkap</label>
                                        <textarea name="alamat_lengkap" id="alamat_lengkap" rows="1" class="form-control"
                                            required></textarea>
                                    </div> <!-- form-group end.// -->
                                </div>
                                <button type="submit" id="simpan"
                                    class="btn btn--round btn-danger btn--default">Simpan</button>
                                <button class="btn btn--round modal_close" data-dismiss="modal">Batal</button>
                            </form>
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->
    <div class="modal fade rating_modal item_remove_modal" id="modalPilihKurir" tabindex="-1" role="dialog"
        aria-labelledby="myModal2">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">PILIH KURIR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- end /.modal-header -->

                <div class="modal-body p-5">
                    <select name="pilih_kurir" id="pilih_kurir" class="form-control">
                        <option>Pilih Kurir</option>
                        @foreach ($kurir as $item)
                            <option value="{{ $item->nama_kurir . '-/' . $item->id_kecamatan }}">
                                {{ $item->nama_kurir }}
                            </option>
                        @endforeach
                    </select>
                    <br>
                    <div id="kurir" class="custom-radio"></div>
                </div>
                <!-- end /.modal-body -->
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <script src="{{ asset('assets/js/intlTelInput.js') }}"></script>

    <script>
        $(document).ready(function() {


            var hasil_ongkir = "";
            var hasil_service = "";


            let input = document.querySelector('#phone');
            var iti = intlTelInput(input, {
                initialCountry: "id",
                allowDropdown: true,
                utilsScript: "{{ url('assets/js/utils.js') }}"
            });
            $("#phone").on('keyup', function() {
                if (iti.isValidNumber()) {
                    $("#simpan").prop('disabled', false)
                    $("#teleponError").html('')
                } else {
                    $("#simpan").prop('disabled', true);
                    $("#teleponError").html('Nomor telepon tidak valid')
                }
            });
            $("#kode_pos").on('keyup', function() {
                if ($(this).val().length > 5 || !$.isNumeric($(this).val())) {
                    $("#kodePosError").html('Kode pos tidak valid');
                    $("#simpan").prop('disabled', true);
                } else {
                    $("#kodePosError").html('');
                    $("#simpan").prop('disabled', false);
                }
            });
            $("#tambahAlamat").on('click', function() {
                $.ajax({
                    async: true,
                    url: "{{ URL::to('api/gateway/provinsi') }}",
                    type: 'GET',
                    success: function(response) {
                        $("#provinsi option").remove();
                        $("#modalAlamat").modal('show');
                        $("#provinsi").append('<option>---PILIH PROVINSI---</option>');
                        response.provinsi.rajaongkir.results.map(e => {
                            $("#provinsi").append(`
                                <option value='${e.province_id}'>${e.province}</option>
                            `);
                        });
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
            $("#provinsi").on('change', function() {
                $("#nama_provinsi").val($("#provinsi option:selected").html());
                $("#kota").prop('disabled', true);
                $("#kota option").remove();
                $("#kota").append(`
                    <option>---PILIH KOTA---</option>
                    `);
                $("#kecamatan option").remove();
                $("#kecamatan").prop('disabled', true);
                $("#kecamatan").append(`
                            <option>---PILIH KECAMATAN---</option>
                    `);
                $.ajax({
                    async: true,
                    url: "{{ URL::to('api/gateway/kota?provinsi=') }}" + `${$(this).val()}`,
                    type: 'GET',
                    success: function(response) {
                        $("#kota option").remove();
                        response.kota.rajaongkir.results.map(e => {
                            $("#kota").append(`
                                <option value='${e.city_id}'>${e.type} ${e.city_name}</option>
                            `);
                        });
                        $("#kota").prop('disabled', false);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
            $("#kota").on('change', function() {
                $("#nama_kota").val($("#kota option:selected").html());
                $("#kecamatan").prop('disabled', true);
                $.ajax({
                    async: true,
                    url: "{{ URL::to('api/gateway/kecamatan?id=') }}" + $('#kota').val(),
                    type: 'GET',
                    success: function(response) {
                        $("#kecamatan option").remove();
                        response.kecamatan.rajaongkir.results.map(e => {
                            $("#kecamatan").append(`
                                <option value='${e.subdistrict_id}'>${e.subdistrict_name}</option>
                           `);
                        });
                        $("#kecamatan").prop('disabled', false);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
            $("#kecamatan").on('change', function() {
                $("#nama_kecamatan").val($("#kecamatan option:selected").html());

            });

            $("button[id = 'tambah_kurir']").on('click', function() {
                $('#pilih_kurir option').eq(0).prop('selected', true);
                $("#title").html("Pilih Kurir untuk ");
                $("#modalPilihKurir").modal('show');
            });
        });
    </script>
    <script>
        /* attach a submit handler to the form */
        $("#formalamat").submit(function(event) {
            $('.ok').remove();

            /* stop form from submitting normally */
            event.preventDefault();

            /* get the action attribute from the <form action=""> element */
            var $form = $(this),
                nama = $form.find('input[id="nama"]').val(),
                phone = $form.find('input[id="phone"]').val(),
                nama = $form.find('input[id="nama"]').val(),
                nama_desa = $form.find('input[id="nama_desa"]').val(),
                nama_provinsi = $form.find('input[id="nama_provinsi"]').val(),
                nama_kota = $form.find('input[id="nama_kota"]').val(),
                nama_kecamatan = $form.find('input[id="nama_kecamatan"]').val(),
                kode_pos = $form.find('input[id="kode_pos"]').val(),
                alamat_lengkap = $form.find('textarea#alamat_lengkap').val();
            /* Send the data using post with element id name and name2*/
            var aw = nama + ", " + alamat_lengkap + " " + nama_desa + " " + nama_kecamatan + " " + nama_kota +
                " " + nama_provinsi + " " + kode_pos + ", " + phone;

            document.getElementById("alamat_pengriman").innerHTML = aw;
            $('#modalAlamat').modal('toggle');
            $('button[id="tambah_kurir"]').removeAttr('disabled');


        });
        $("#pilih_kurir").on('change', function() {
            var value = $(this).children(":selected").attr("value");
            var split = value.split("-/");

            var id_kecamatan = $('select[name=kecamatan] option').filter(':selected').val();
            var dataku = {
                "_token": "{{ csrf_token() }}",
                "asal": split[1],
                "tujuan": id_kecamatan,
                "berat": document.getElementById("berat_produk").innerHTML + "000",
                "kurir": split[0],
            }
            console.log(dataku);
            $.ajax({
                async: true,
                url: "{{ URL::to('api/ongkir') }}",
                type: 'POST',
                data: dataku,

                success: function(response) {
                    $('.ok').remove();
                    response.ongkir.rajaongkir.results[0].costs.map(e => {
                        $("#kurir").append(`
                            <div class="ok">
                                <input type="radio" name="ongkir" data-service="${e.service}" data-ongkir="${e.cost[0].value}" data-etd="${e.cost[0].etd}">
                                <label for="${e.service}">
                                <span class="circle"></span>${e.service} - Rp. ${numberFormat(e.cost[0].value)} - ${e.cost[0].etd}  hari</label>
                                <br>
                            </div>
                        `);
                    });
                    $("input[name='ongkir']").on('click', function() {
                        let kurir = $("#pilih_kurir").val();
                        let service = $(this).data('service');
                        let ongkir = $(this).data('ongkir');
                        let etd = $(this).data('etd');
                        $("#modalPilihKurir").modal('hide');
                        $("#total_belanja").append(`
                        <table class="table">
                            <tr>
                                    <th>Kurir:</th>
                                    <td>${split[0]}</td>
                                </tr>
                                <tr>
                                    <th>Service:</th>
                                    <td>${service}</td>
                                </tr>
                                <tr>
                                    <th>Ongkir:</th>
                                    <td>${"Rp "+numberFormat(ongkir)}</td>
                                </tr>
                                <tr>
                                    <th>Waktu:</th>
                                    <td>${etd}</td>
                                </tr>
                        </table>
                        `)
                        document.getElementById("total_ongkir").innerHTML = "Rp " +
                            numberFormat(ongkir);
                         hasil_ongkir = ongkir;
                         hasil_service = service+"-"+split[0];
                        document.getElementById("total_dibayar").innerHTML = "Rp " +
                            numberFormat(parseInt("{{ $sum }}") + ongkir);
                        $('button[id="transaksi"]').removeAttr('disabled');

                    });

                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $("button[id = 'transaksi']").on('click', function() {


            let z_id_toko = "{{ $toko->id_toko_penjual }}";
            let z_total_bayar_barang = "{{ $sum }}";
            let z_total_bayar_kurir = hasil_ongkir;
            let z_jasa_kurir = hasil_service;
            let z_lokasi_pengiriman = document.getElementById("alamat_pengriman").innerHTML;

            var id_keranjang = "";
                $("#tabel-keranjang tbody tr").map(function() {
                    var $this = $(this);
                    id_keranjang = $this.find("#id_keranjang").text();
            });
            var datakuz = {
                "_token": "{{ csrf_token() }}",
                "z_id_user" : "{{Session::get('id_user')}}",
                "z_id_toko": z_id_toko,
                "z_total_bayar_barang": z_total_bayar_barang,
                "z_total_bayar_kurir": z_total_bayar_kurir,
                "z_jasa_kurir": z_jasa_kurir,
                "z_lokasi_pengiriman": z_lokasi_pengiriman,
                "z_id_transaksi_semsentara": id_keranjang,
            }
            console.log(datakuz);
            $.ajax({
                async: true,
                url: "{{ URL::to('api/transaksi/one') }}",
                type: 'POST',
                data: datakuz,
                success: function(response) {
                     window.location.href="{{route('profil')}}";
                },
                error: function(error) {
                    console.log(error);

                }
            });
        });
    </script>
    <script>
        function numberFormat(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        }
    </script>
@endsection
