@extends('layouts.app')

@section('content')
<div class="flex justify-center">
        <div class="w-12/12 bg-white p-6 rounded-lg justify-center flex">
        <form action="" method="post">
        @csrf
            <table class="shadow-lg bg-white">
                <tr>
                    <td class="text-center border px-8 py-2">Index</td>
                    <td class="text-center border px-8 py-2">NIK</td>
                    <td class="text-center border px-10 py-2">Nama</td>
                    <td class="text-center border px-10 py-2">Deskripsi</td>
                    <td class="text-center border px-10 py-2">status</td>
                    <td class="text-center border px-10 py-2">approved</td>
                </tr>
                @foreach($data as $dt)
                <tr>
                    <td class="text-center border px-8 py-2">{{$loop->iteration}}</td>
                    <td class="text-center border px-8 py-2">{{$dt->penduduk_nik}}</td>
                    <td class="text-center border px-10 py-2">{{$dt->penduduk_nama}}</td>   
                    <td class="text-center border px-8 py-2">{{$dt->penduduk_deskripsi}}</td>
                    <td class="text-center border px-10 py-2">{{$dt->penduduk_status}}</td>
                    <td class="text-center border px-10 py-2">
                    <input name="penduduk_id[{{$loop->iteration}}]" value="{{$dt->penduduk_id}}" type="checkbox">
                    </td>
                </tr>
                @endforeach
             </table>
             <div class="flex justify-center" style="margin-top:25px">
                <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full" style="width:300px">
                Approved</button>
            </div>
        </form>
        </div>
    </div>
@endsection