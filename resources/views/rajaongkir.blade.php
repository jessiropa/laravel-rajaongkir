<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Raja Ongkir V2 - SantriKoding.com</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <style>
        .loader{border:4px solid #f3f3f3;border-top:4px solid #4f46e5;border-radius:50%;width:30px;height:30px;animation:spin 1s linear infinite;margin:0 auto;display:none}@keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
    </style>
</head>
<body class="bg-gray-200 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-xl shadow w-full max-w-2xl">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Kalkulator Ongkos Kirim (V2)</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
        <!-- provinsi -->
            <div>
                <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi Tujuan</label>
                    <select id="province" name="province_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base bg-gray-200 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow">
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach($provinces as $province)
                        <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                        @endforeach
                    </select>
            </div>

        <!-- kota / kabupaten -->
            <div>
                <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi Tujuan</label>
                <select id="city" name="city_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base bg-gray-200 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm disabled:bg-gray-50 disabled:cursor-not-allowed">
                    <option value="">-- Pilih Kota / Kabupaten --</option>
                </select>
            </div>

        <!-- kecamatan -->
            <div>
                <label for="district" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan Tujuan</label>
                <select id="district" name="district_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base bg-gray-200 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm disabled:bg-gray-50 disabled:cursor-not-allowed">
                    <option value="">-- Pilih Kecamatan --</option>
                </select>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function(){

        // inisialisasi dropdown kota / kabupaten
        $('select[name="province_id"]').on('change', function(){
            let provinceId = $(this).val();
            if(provinceId){
                jQuery.ajax({
                    url:`/cities/${provinceId}`,
                    type: "GET",
                    dataType : "json",
                    success: function(response){
                        $('select[name="city_id"]').empty();
                        $('select[name="city_id"]').append(`<option value="">-- Pilih Kota / Kabupaten --</option>`);
                        $.each(response, function(index, value){
                            $('select[name="city_id"]').append(`<option value="${value.id}">${value.name}</option>`);
                        });
                    }
                });
            }else{
                $('select[name="city_id"]').append(`<option value="">-- Pilih Kota / Kabupaten --</option>`);
            }
        });

        // inisialisasi dropdown kecamatan 
        $('select[name="city_id"]').on('change', function(){
            let cityId = $(this).val();
            if(cityId){
                jQuery.ajax({
                    url:`/districts/${cityId}`,
                    type: "GET",
                    dataType : "json",
                    success: function(response){
                        $('select[name="district_id"]').empty();
                        $('select[name="district_id"]').append(`<option value="">-- Pilih Kecamatan --</option>`);
                        $.each(response, function(index, value){
                            $('select[name="district_id"]').append(`<option value="${value.id}">${value.name}</option>`);
                        });
                    }
                });
            }else{
                $('select[name="district_id"]').append(`<option value="">-- Pilih Kecamatan --</option>`);
            }
        });
    });
</script>
</html>