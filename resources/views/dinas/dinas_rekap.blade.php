@extends('layouts.app')

@section('content')
    <div class="flex justify-center" style="margin-top:25px">
        <font size="28">
            <h1>Rekap Data Penduduk Kelurahan {{ucwords($name)}}</h1>
        </font>
    </div>
    <br>
    <div class="flex justify-center">
        <div class="w-12/12 bg-white p-6 rounded-lg justify-center flex">
            <table class="shadow-lg bg-white">
                <tr>
                    <td class="text-center border px-8 py-2">Index</td>
                    <td class="text-center border px-8 py-2">Status</td>
                    <td class="text-center border px-10 py-2">Jumlah (orang)</td>
                    <td class="text-center border px-10 py-2">Lihat Laporan </td>
                </tr>
                <tr>
                    <td class="text-center border px-8 py-2">1</td>
                    <td class="text-center border px-8 py-2">Data Baru</td>
                    <td class="text-center border px-8 py-2">{{$jumlah[1]}} orang</td>
                    <td class='border text-center px-8 py-2'>
                        <a href='/dinas/rekapstatus?kelurahan_id={{$kelurahan_id}}&filter=2&stats=1' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>Lihat</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center border px-8 py-2">2</td>
                    <td class="text-center border px-8 py-2">Data Baru</td>
                    <td class="text-center border px-8 py-2">{{$jumlah[11]}} orang</td>
                    <td class='border text-center px-8 py-2'>
                        <a href='/dinas/rekapstatus?kelurahan_id={{$kelurahan_id}}&filter=2&stats=5' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>Lihat</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center border px-8 py-2">3</td>
                    <td class="text-center border px-8 py-2">Approved Dinsos</td>
                    <td class="text-center border px-8 py-2">{{$jumlah[2]}} orang</td>
                    <td class='border text-center px-8 py-2'>
                        <a href='/dinas/rekapstatus?kelurahan_id={{$kelurahan_id}}&filter=2&stats=2' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>Lihat</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center border px-8 py-2">4</td>
                    <td class="text-center border px-8 py-2">Ditolak Dinsos</td>
                    <td class="text-center border px-8 py-2">{{$jumlah[3]}} orang</td>
                    <td class='border text-center px-8 py-2'>
                        <a href='/dinas/rekapstatus?kelurahan_id={{$kelurahan_id}}&filter=2&stats=6' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>Lihat</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center border px-8 py-2">5</td>
                    <td class="text-center border px-8 py-2">Masuk DTKS</td>
                    <td class="text-center border px-8 py-2">{{$jumlah[4]}} orang</td>
                    <td class='border text-center px-8 py-2'>
                        <a href='/dinas/rekapstatus?kelurahan_id={{$kelurahan_id}}&filter=2&stats=3' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>Lihat</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center border px-8 py-2">6</td>
                    <td class="text-center border px-8 py-2">Ditolak DTKS</td>
                    <td class="text-center border px-8 py-2">{{$jumlah[5]}} orang</td>
                    <td class='border text-center px-8 py-2'>
                        <a href='/dinas/rekapstatus?kelurahan_id={{$kelurahan_id}}&filter=2&stats=7' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>Lihat</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center border px-8 py-2">7</td>
                    <td class="text-center border px-8 py-2">Periode Ini</td>
                    <td class="text-center border px-8 py-2">{{$jumlah[9]}} orang</td>
                    <td class='border text-center px-8 py-2'>
                        <a href='/dinas/rekapstatus?kelurahan_id={{$kelurahan_id}}&periode=1' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>Lihat</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center border px-8 py-2">8</td>
                    <td class="text-center border px-8 py-2">Seluruh Data</td>
                    <td class="text-center border px-8 py-2">{{$jumlah[10]}} orang</td>
                    <td class='border text-center px-8 py-2'>
                        <a href='/dinas/rekapstatus?kelurahan_id={{$kelurahan_id}}' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>Lihat</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="flex justify-center" style="margin-top:25px">
        <a href="/dinas/report">
            <button type="" id="btn-print" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full" style="width:300px">
            Kembali</button>
        </a>
    </div>
@endsection