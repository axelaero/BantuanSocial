@extends('layouts.app')

@section('content')
    <div class="flex justify-center" style="margin-top:25px">
        <font size="28">
            <h1>Update Data Penduduk</h1>
        </font>
    </div>
    <br>
<div class="flex justify-center">
        <div class="w-12/12 bg-white p-6 rounded-lg justify-center flex">
        <form action="{{ route('mentriupdate') }}" method="post">
        @csrf
            <table class="shadow-lg bg-white">
                <tr>
                    <td class="text-center border px-8 py-2">Index</td>
                    <td class="text-center border px-8 py-2">NIK</td>
                    <td class="text-center border px-8 py-2">ID BDT</td>
                    <td class="text-center border px-10 py-2">Nama</td>
                    <td class="text-center border px-10 py-2">Deskripsi</td>
                    <td class="text-center border px-10 py-2">status</td>
                    <td class="text-center border px-10 py-2">approved</td>
                    <td class="text-center border px-10 py-2">reject</td>
                    <td class="text-center border px-10 py-2">Alasan</td>
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
                    <td class="text-center border px-10 py-2">
                        <input type="hidden" name="bdt[{{$loop->iteration}}][penduduk_id]" value="{{$dt->penduduk_id}}">
                        <input type="text" name="bdt[{{$loop->iteration}}][data]">
                    </td>
                    <td class="text-center border px-10 py-2">{{$dt->penduduk_nama}}</td>   
                    <td class="text-center border px-8 py-2">{{$dt->penduduk_deskripsi}}</td>
                    <td class="text-center border px-10 py-2">{{$dt->deskripsi}}</td>
                    <td class="text-center border px-10 py-2">
                        <input name="penduduk_id_approved[{{$loop->iteration}}]" value="{{$dt->penduduk_id}}" id="checkbox-acc-{{$dt->penduduk_id}}" type="checkbox" onclick="checkboxFunctionAcc({{$dt->penduduk_id}})" checked>
                    </td>
                    <td class="text-center border px-10 py-2">
                        <input name="penduduk_id_rejected[{{$loop->iteration}}]" value="{{$dt->penduduk_id}}" id="checkbox-rej-{{$dt->penduduk_id}}" type="checkbox" onclick="checkboxFunctionRej({{$dt->penduduk_id}})">
                    </td>
                    <td class="text-center border px-10 py-2">
                        <input type="hidden" name="deskripsi[{{$loop->iteration}}][penduduk_id]" value="{{$dt->penduduk_id}}">
                        <input type="text" name="deskripsi[{{$loop->iteration}}][data]">
                    </td>
                </tr>
                @endforeach
             </table>
            @if($count != 0)
                <div class="flex justify-center" style="margin-top:25px">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full" style="width:300px">
                    Approved</button>
                </div>
            @else
                <div class="flex justify-center" style="margin-top:25px">
                    No Data
                </div>
            @endif
        </form>
        </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('js/button_status.js') }}"></script>
@endsection