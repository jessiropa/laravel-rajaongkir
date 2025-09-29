<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function index(){
        // mengambil data provinsi dari API RajaOngkir 
        $response = Http::withHeaders([
            // header yang dibutuhkan api raja ongkir 
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        // mengecek isi dari feedback balik dari permintaan ke api 
        if($response->successful()){
            // mengambil data provinsi hasil dari respon json 
            // jika data tidak ada, maka akan dibungkus dengan array kosong
            $provinces = $response->json()['data'] ?? [];
        }else{
            $provinces = [];
        }

        return view('rajaongkir', compact('provinces'));
    }
}
