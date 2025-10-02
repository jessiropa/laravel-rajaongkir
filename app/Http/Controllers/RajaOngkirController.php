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

    // mengambil data kota berdasarkan provinsi 
    public function getCities($provinceId){
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}");

        if($response->successful()){
            return response()->json($response->json()['data'] ?? []);
        }
    }

    // mengambil data kecamatan berdasarkan kota
    public function getDistricts($cityId){
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$cityId}");

        if($response->successful()){
            return response()->json($response->json()['data'] ?? []);
        }
    }

    // check ongkir 
    public function checkongkir(Request $request){
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->post('https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost', [
            'origin'      => 5895, // ID kecamatan sukolilo
            'destination' => $request->input('district_id'), // ID kecamatan tujuan
            'weight'      => $request->input('weight'), // Berat dalam gram
            'courier'     => $request->input('courier'), // Kode kurir (jne, tiki, pos)
        ]);

        if($response->successful()){
            return response()->json($response->json()['data'] ?? []);
        }

        return response()->json([], 200);
    }
}
