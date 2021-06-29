
@extends('layouts.app')

@section('content')
    <div class="flex justify-center" style="margin-top:25px">
        <font size="28">
            <h1>Total Keluarga yang Telah Mendapat Bantuan</h1>
        </font>
    </div>
    <br>
    <div class="flex justify-center">
        <div class="w-12/12 bg-white p-6 rounded-lg justify-center flex">
            <table class="shadow-lg bg-white">
                <tr>
                    <td class="text-center border px-8 py-2">Index</td>
                    <td class="text-center border px-10 py-2">Kelurahan</td>
                    <td class="text-center border px-10 py-2">Keluarga</td>
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
                    <td class="text-center border px-8 py-2">{{ucwords($dt->kelurahan_nama)}}</td>
                    <td class="text-center border px-8 py-2">{{$dt->total_keluarga}}</td>
                    
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
@endsection