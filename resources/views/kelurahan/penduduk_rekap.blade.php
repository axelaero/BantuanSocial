@extends('layouts.app')

@section('content')
    <div class="flex justify-center" style="margin-top:25px">
        <font size="28">
            <h1>Rekap Data Penduduk - {{$msg}}</h1>
        </font>
    </div>
    <br>
    <form action="{{ route('pendudukrekap') }}" method="get">
        <div class="flex justify-center">
            <div class="w-12/12 p-6 rounded-lg justify-center flex">
                <table>
                    <tr>
                        <input type="hidden" name="filter" id="" value="{{$filter}}">
                        <input type="hidden" name="stats" value="{{$stats}}">
                        <td>
                            <input type="text" name="searchnik" id="" placeholder="Cari NIK" class="w-12/12 p-3 rounded-lg justify-center flex" style="width:400px;">
                        </td>
                        <td>
                            <button class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full" style="margin-left: 25px;width:200px">Cari</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
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
                <?php
                    $count = 0;
                ?>
                @foreach($data as $dt)
                <?php
                    $count += 1;
                ?>
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
                    <td class="text-center border px-8 py-2">{{$dt->deskripsi}}</td> 
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
             @if($count == 0)  
                <div class="flex justify-center" style="margin-top:25px">
                    No Data
                </div>
             @endif
             <div class="flex justify-center" style="margin-top:25px">
                <a href="/penduduk/report">
                    <button type="" id="btn-print" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full" style="width:300px">
                    Kembali</button>
                </a>
            </div>
@endsection