@extends('layouts.app')

@section('content')
    <div class="flex justify-center" style="margin-top:25px">
        <font size="28">
            <h1>Laporan Prelist Akhir Musyarah Kelurahan</h1>
        </font>
    </div>
    <br>
    <div class="flex justify-center">
        <div class="w-12/12 bg-white p-6 rounded-lg justify-center flex">
            <table class="shadow-lg bg-white">
                <tr>
                    <td class="text-center border px-8 py-2">Index</td>
                    <td class="text-center border px-8 py-2">NIK</td>
                    <td class="text-center border px-10 py-2">BDT</td>
                    <td class="text-center border px-10 py-2">Nama</td>
                    <td class="text-center border px-8 py-2">Alamat</td>
                    <td class="text-center border px-10 py-2">status</td>
                    <td class="text-center border px-10 py-2">Deskripsi</td>
                    <td class="text-center border px-10 py-2">Delete</td>
                    <!-- <td class="text-center border px-10 py-2">approved</td> -->
                    <!-- <td class="text-center border px-10 py-2">periode</td> -->
                </tr>
                <?php
                    $button_count = 0;  
                    $button_active = 0;
                    $val_checker_status = 0;
                ?>
                @foreach($data as $dt)
                <tr>
                    <?php
                        $button_count += 1;
                        if($dt->penduduk_status == 7){
                            $val_checker_status += 1;
                        }
                    ?>
                    <td class="text-center border px-8 py-2">{{$loop->iteration}}</td>
                    <td class="text-center border px-8 py-2">{{$dt->penduduk_nik}}</td>
                    @if($dt->penduduk_id_bdt)
                        <td class="text-center border px-10 py-2">{{$dt->penduduk_id_bdt}}</td>
                    @else
                        <td class="text-center border px-10 py-2">Belum Ada</td>
                    @endif
                    <td class="text-center border px-10 py-2">{{$dt->penduduk_nama}}</td>
                    <td class="text-center border px-8 py-2">{{$dt->penduduk_alamat}}</td>
                    @if($dt->deskripsi)
                        <?php
                            $button_active += 1;
                        ?>
                        
                        <td class="text-center border px-10 py-2">
                        <a href='/pendudukupdate/{{$dt->penduduk_id}}'>{{$dt->deskripsi}}</a>
                        </td>
                    @else
                        <!-- <td class="text-center border px-10 py-2">Pending</td> -->
                        <td class='border text-center px-8 py-2'>
                            <a href='/pendudukupdate/{{$dt->penduduk_id}}' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>Update</a>
                        </td>
                    @endif
                    
                    <td class="text-center border px-8 py-2">{{$dt->penduduk_deskripsi}}</td>
                    <td class="text-center border px-2 py-2">
                    <a href='/pendudukdelete/{{$dt->penduduk_id}}' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-red-700 hover:bg-red-900 text-white font-normal py-0.5 px-4 mr-1 rounded' onclick="return confirm('Are you sure?')">X</a>
                    </td>
                    <!-- @if($dt->approved_deskripsi)
                        <td class="text-center border px-10 py-2">{{$dt->approved_deskripsi}}</td>
                    @else
                        <td class="text-center border px-10 py-2">Belum di cek</td>
                    @endif -->
                    <!-- <td class="text-center border px-10 py-2">{{$dt->periode}}</td> -->
                    
                </tr>
                @endforeach
             </table>
        </div>
    </div>
    
    @if($button_count == $button_active & $button_count != 0 & $val_checker_status == 0)
        <form action="{{ route('ba_create') }}" method="post">
            @csrf
            <input type="hidden" name="kelurahan_id" id="kelurahan_id" value="{{$kelurahan_id}}">
            <div class="flex justify-center" style="margin-top:25px">
                <button type="submit" id="btn-print" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full" style="width:300px">
                Buat Berita Acara</button>
            </div>
        </form>
    @else
        <div class="flex justify-center" style="margin-top:25px">
            No Data
        </div>
        <div class="flex justify-center" style="margin-top:25px">
            <button type="" class="bg-gray-500 text-white px-4 py-3 rounded font-medium w-full" style="width:300px">
            Tidak Bisa Buat Berita Acara</button>
        </div>
    @endif
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('js/print_pdf.js') }}"></script>
@endsection