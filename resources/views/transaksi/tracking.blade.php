@extends('layouts.index')

@section('css')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="table-responsive">
                    <h5>Histori Pengiriman</h5>

                    <table class="table table-cart ">
                        <thead>
                            <tr>

                                <th class="product-col">Nomor</th>
                                <th class="product-col">Tanggal</th>
                                <th class="product-col">Jam</th>
                                <th class="product-col">Keterangan</th>


                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nomor = 1;
                            @endphp
                            @if ($data['rajaongkir'] != null)
                                @foreach ($data['rajaongkir']->rajaongkir->result->manifest as $item)
                                    <tr>
                                        <td class="product-col">{{ $nomor++ }}</td>
                                        <td class="product-col">{{ $item->manifest_date }}</td>
                                        <td class="product-col">{{ $item->manifest_time }}</td>
                                        <td class="product-col">{{ $item->manifest_description }}</td>

                                    </tr>

                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-4 ">
               <div class="row">
                <div class="table-responsive">
                    <h5>Pengeriman</h5>
                    <table class="table table-cart ">
                        <thead>
                            @if ($data['rajaongkir'] != null)
                            <tr>
                                <th><b>kurir</b></th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->summary->courier_name}}</th>
                            </tr>
                            <tr>
                                <th><b>Nomor Resi</b></th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->summary->waybill_number}}</th>

                            </tr>
                            <tr>
                                <th><b>Paket</b></th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->summary->service_code}}</th>

                            </tr>
                            <tr>
                                <th><b>Tanggal Resi</b></th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->summary->waybill_date}}</th>

                            </tr>
                            <tr>
                                <th><b>Pengiriman</b></th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->summary->shipper_name}}</th>

                            </tr>
                            <tr>
                                <th><b>Lokasi</b></th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->summary->origin}}</th>

                            </tr>
                            <tr>
                                <th><b>Penerima</b></th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->summary->receiver_name}}</th>

                            </tr>
                            <tr>
                                <th><b>Lokasi</b></th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->summary->destination}}</th>

                            </tr>
                            @endif

                        </thead>

                    </table>
                </div>
                <div class="table-responsive">
                    <h5>Status</h5>
                    <table class="table table-cart ">
                        <thead>
                            @if ($data['rajaongkir'] != null)

                            <tr>
                                <th>status</th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->delivery_status->status}}</th>
                            </tr>
                            <tr>
                                <th>Terima</th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->delivery_status->pod_receiver}}</th>

                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->delivery_status->pod_date}}</th>

                            </tr>
                            <tr>
                                <th>Jam</th>
                                <th>{{$data['rajaongkir']->rajaongkir->result->delivery_status->pod_time}}</th>

                            </tr>
                            @endif


                        </thead>

                    </table>
                </div>
               </div>
            </div>
        </div>
    </div>
    @endsection

    @section('javascript')

    @endsection
