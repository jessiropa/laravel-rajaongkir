<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// index route dari controller raja ongkir
Route::get('/', [App\Http\Controllers\RajaOngkirController::class, 'index']);

// get data kota berdasarkan id provinsi 
Route::get('/cities/{provinceId}',[App\Http\Controllers\RajaOngkirController::class, 'getCities']);

// get data kecamatan berdasarkan id kota
Route::get('/districts/{cityId}', [App\Http\Controllers\RajaOngkirController::class, 'getDistricts']);

// post data untuk check ongkir 
Route::post('/check-ongkir', [App\Http\Controllers\RajaOngkirController::class, 'checkOngkir']);
// Route::get('/', function () {
//     return view('welcome');
// });
