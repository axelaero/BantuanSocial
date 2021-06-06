@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-12/12 bg-white p-6 rounded-lg justify-center flex">
            <table class="shadow-lg bg-white">
                <tr>
                    <td class="text-center border px-8 py-2">Index</td>
                    <td class="text-center border px-8 py-2">NIK</td>
                    <td class="text-center border px-10 py-2">BDT</td>
                    <td class="text-center border px-10 py-2">Nama</td>
                    <td class="text-center border px-8 py-2">Alamat</td>
                    <td class="text-center border px-10 py-2">Periode</td>
                    <td class="text-center border px-10 py-2">status</td>
                    <td class="text-center border px-10 py-2">approved</td>
                    <td class="text-center border px-10 py-2">Deskripsi</td>
                </tr>
                @foreach($data as $dt)
                <tr>
                    <td class="text-center border px-8 py-2">{{$loop->iteration}}</td>
                    <td class="text-center border px-8 py-2">{{$dt->penduduk_nik}}</td>
                    @if($dt->penduduk_id_bdt)
                        <td class="text-center border px-10 py-2">{{$dt->penduduk_id_bdt}}</td>
                    @else
                        <td class="text-center border px-10 py-2">Belum Ada</td>
                    @endif
                    <td class="text-center border px-10 py-2">{{$dt->penduduk_nama}}</td>
                    <td class="text-center border px-8 py-2">{{$dt->penduduk_alamat}}</td>
                    <td class="text-center border px-8 py-2">{{$dt->periode}}</td>  
                    <td class="text-center border px-10 py-2">
                        <a href='/pendudukupdate/{{$dt->penduduk_id}}'>{{$dt->deskripsi}}</a>
                    </td>
                    @if($dt->approved_deskripsi)
                        <td class="text-center border px-10 py-2">{{$dt->approved_deskripsi}}</td>
                    @else
                        <td class="text-center border px-10 py-2">Belum di cek</td>
                    @endif
                    <td class="text-center border px-8 py-2">{{$dt->penduduk_deskripsi}}</td>
                </tr>
                @endforeach
             </table>
        </div>
    </div>
@endsection