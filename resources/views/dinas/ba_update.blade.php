@extends('layouts.app')

@section('content')
    <div class="flex justify-center" style="margin-top:25px">
        <font size="28">
            <h1>Berita Acara - {{$ba_id}} - {{ucwords($nama)}}</h1>
            <h5>Periode: {{$periode}} - Part: {{$part}}</h5>
        </font>
    </div>
    <br>
    <form action="" method="get">
        <div class="flex justify-center">
            <div class="w-12/12 p-6 rounded-lg justify-center flex">
                <table>
                    <tr>
                        <td>
                            <input type="hidden" name="ba_id" value={{$ba_id}}>
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
        <form action="{{ route('ba_update') }}" method="post">
        @csrf
            <table class="shadow-lg bg-white">
                <tr>
                    <td class="text-center border px-8 py-2">Index</td>
                    <td class="text-center border px-8 py-2">NIK</td>
                    <td class="text-center border px-8 py-2">ID BDT</td>
                    <td class="text-center border px-10 py-2">Nama</td>
                    <td class="text-center border px-10 py-2">Alamat</td>
                    <td class="text-center border px-10 py-2">RT</td>
                    <td class="text-center border px-10 py-2">RW</td>
                    <td class="text-center border px-10 py-2">Deskripsi</td>
                    <td class="text-center border px-10 py-2">status</td>
                    <td class="text-center border px-10 py-2">approved</td>
                    <td class="text-center border px-10 py-2">reject</td>
                    <td class="text-center border px-10 py-2">Alasan</td>
                </tr>
                @foreach($data as $dt)
                <tr>
                    <td class="text-center border px-8 py-2">{{$loop->iteration}}</td>
                    <td class="text-center border px-8 py-2">{{$dt->penduduk_nik}}</td>
                    @if($dt->penduduk_id_bdt == null)
                        <td class="text-center border px-8 py-2">Belum Ada</td>
                    @else
                        <td class="text-center border px-8 py-2">{{$dt->penduduk_id_bdt}}</td>
                    @endif
                    <td class="text-center border px-10 py-2">{{$dt->penduduk_nama}}</td>   
                    <td class="text-center border px-10 py-2">{{$dt->penduduk_alamat}}</td>  
                    <td class="text-center border px-10 py-2">{{$dt->rt}}</td>  
                    <td class="text-center border px-10 py-2">{{$dt->rw}}</td>  
                    <td class="text-center border px-8 py-2">{{$dt->penduduk_deskripsi}}</td>
                    <td class="text-center border px-10 py-2">{{$dt->status_deskripsi}}</td>
                    <td class="text-center border px-10 py-2">
                        <input name="penduduk_id_approved[{{$loop->iteration}}]" value="{{$dt->penduduk_id}}" id="checkbox-acc-{{$dt->penduduk_id}}" type="checkbox" onclick="checkboxFunctionAcc({{$dt->penduduk_id}})" checked>
                    </td>
                    <td class="text-center border px-10 py-2">
                        <input name="penduduk_id_rejected[{{$loop->iteration}}]" value="{{$dt->penduduk_id}}" id="checkbox-rej-{{$dt->penduduk_id}}" type="checkbox" onclick="checkboxFunctionRej({{$dt->penduduk_id}})">
                    </td>
                    <td class="text-center border px-10 py-2">
                        <input type="hidden" name="deskripsi[{{$loop->iteration}}][penduduk_id]" value="{{$dt->penduduk_id}}">
                        <input type="text" name="deskripsi[{{$loop->iteration}}][data]" id="input-deskripsi-{{$dt->penduduk_id}}">
                    </td>
                </tr>
                @endforeach
             </table>
             <input type="hidden" name="ba_id" value="{{$ba_id}}">
             <div class="flex justify-center" style="margin-top:25px">
                <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full" style="width:300px">
                Submit</button>
            </div>
        </form>
        </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('js/button_status.js') }}"></script>
@endsection