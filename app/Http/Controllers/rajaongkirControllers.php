<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Exception;

class rajaongkirControllers extends Controller
{
    protected $client, $token;

    public function __construct()
    {
        $this->client = new Client();
        $this->token = "0f5bc4f275fbc61ad918e465ed73f1f9";
    }

    public function provinsi()
    {
//        $response = $this->client->get('http://guzzlephp.org');
        $request = $this->client->get('https://pro.rajaongkir.com/api/province', [
            'headers' => [
                'key' => $this->token
            ]
        ])->getBody()->getContents();
        $data['provinsi'] = json_decode($request, false);
        return $data;
    }

    public function semuaKota()
    {
//        $response = $this->client->get('http://guzzlephp.org');
        $request = $this->client->get('https://pro.rajaongkir.com/api/city?city', [
            'headers' => [
                'key' => $this->token
            ]
        ])->getBody()->getContents();
        $data['kota'] = json_decode($request, false);
        return $data;
    }

    public function kota(Request $request)
    {
        $id = $request->query('provinsi');
//        $response = $this->client->get('http://guzzlephp.org');
        $request = $this->client->get('https://pro.rajaongkir.com/api/city?province='.$id, [
            'headers' => [
                'key' => $this->token
            ]
        ])->getBody()->getContents();
        $data['kota'] = json_decode($request, false);
        return $data;
    }

    public function kotaId(Request $request)
    {
        $id = $request->query('id');
//        $response = $this->client->get('http://guzzlephp.org');
        $request = $this->client->get('https://pro.rajaongkir.com/api/city?id='.$id, [
            'headers' => [
                'key' => $this->token
            ]
        ])->getBody()->getContents();
        $data['kota'] = json_decode($request, false);
        return $data;
    }

    public function kecamatan(Request $request)
    {
        $id = $request->query('id');
//        $response = $this->client->get('http://guzzlephp.org');
        $request = $this->client->get('https://pro.rajaongkir.com/api/subdistrict?city='.$id, [
            'headers' => [
                'key' => $this->token
            ]
        ])->getBody()->getContents();
        $data['kecamatan'] = json_decode($request, false);
        return $data;
    }

    public function kecamatanId(Request $request)
    {
        $id = $request->query('id');
        $request = $this->client->get('https://pro.rajaongkir.com/api/subdistrict?id='.$id, [
            'headers' => [
                'key' => $this->token
            ]
        ])->getBody()->getContents();
        $data['kecamatan'] = json_decode($request, false);
        return $data;
    }
    public function ongkir(Request $request)
    {
        $asal = $request->asal;
        $tujuan = $request->tujuan;
        $berat = $request->berat;
        $kurir = $request->kurir;

        $request = $this->client->post('https://pro.rajaongkir.com/api/cost',[
            'form_params' => [
                'origin' => $asal,
                'originType' => "subdistrict",
                'destination' => $tujuan,
                'destinationType' => "subdistrict",
                'weight' => $berat,
                'courier' => $kurir
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'key' => $this->token
            ],
        ])->getBody()->getContents();

        $data['ongkir'] = json_decode($request, false);
        return $data;
    }

    public function tracking_check(Request $request)
    {
        $resi = $request->waybill;
        $kurir = $request->courier;

        try{
            $request = $this->client->post('https://pro.rajaongkir.com/api/waybill', [
                'form_params' => [
                    'waybill' => $resi,
                    'courier' => $kurir
                ],
                'headers' => [
                    'key' => $this->token,
                ]
            ])->getBody()->getContents();

            return $request;

        }catch(RequestException $re){

            return $request['rajaongkir'] = json_decode("", false);

        }catch(Exception $e){
            return $request['rajaongkir'] =json_decode("", false);
        }
    }
}
