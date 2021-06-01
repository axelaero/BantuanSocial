@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-12/12 bg-white p-6 rounded-lg justify-center flex">
            <table class="shadow-lg bg-white">
                <tr>
                    <td class="text-center border px-8 py-2">Index</td>
                    <td class="text-center border px-8 py-2">Berita Acara ID</td>
                    <td class="text-center border px-10 py-2">Kelurahan</td>
                    <td class="text-center border px-10 py-2">Cek</td>
                </tr>
                @foreach($data as $dt)
                <tr>
                    <td class="text-center border px-8 py-2">{{$loop->iteration}}</td>
                    <td class="text-center border px-8 py-2">{{$dt->ba_id}}</td>
                    <td class="text-center border px-8 py-2">{{$dt->kelurahan_nama}}</td>
                    <td class='border text-center px-8 py-2'>
                        <a href='/ba_update/{{$dt->ba_id}}' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>Cek</a>
                    </td>
                </tr>
                @endforeach
             </table>
        </div>
    </div>
@endsection