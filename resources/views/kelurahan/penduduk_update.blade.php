@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-12/12 bg-white p-6 rounded-lg justify-center flex">
            <input type="hidden" name="penduduk_id" value="{{$penduduk_id}}">
            <table>
                <tr>
                    <td class="text-center border px-8 py-2">Status baru - {{$penduduk_nama}}</td>
                </tr>
                <tr>
                    <td class='border text-center px-8 py-2'>
                            <a href='/pendudukupdate?penduduk_id={{$penduduk_id}}&penduduk_status_id=1' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>pindah, Bandung</a>
                    </td>
                </tr>
                <tr>
                    <td class='border text-center px-8 py-2'>
                            <a href='/pendudukupdate?penduduk_id={{$penduduk_id}}&penduduk_status_id=2' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>pindah, luar Bandung</a>
                    </td>
                </tr>
                <tr>
                    <td class='border text-center px-8 py-2'>
                            <a href='/pendudukupdate?penduduk_id={{$penduduk_id}}&penduduk_status_id=3' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>mampu</a>
                    </td>
                </tr>
                <tr>
                    <td class='border text-center px-8 py-2'>
                            <a href='/pendudukupdate?penduduk_id={{$penduduk_id}}&penduduk_status_id=4' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>meninggal</a>
                    </td>
                </tr>
                <tr>
                    <td class='border text-center px-8 py-2'>
                            <a href='/pendudukupdate?penduduk_id={{$penduduk_id}}&penduduk_status_id=5' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>meninggal, ahli waris</a>
                    </td>
                </tr>
                <tr>
                    <td class='border text-center px-8 py-2'>
                            <a href='/pendudukupdate?penduduk_id={{$penduduk_id}}&penduduk_status_id=6' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>hilang</a>
                    </td>
                </tr>
                <tr>
                    <td class='border text-center px-8 py-2'>
                        <a href='/pendudukdelete?penduduk_id={{$penduduk_id}}' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-red-700 hover:bg-red-900 text-white font-normal py-0.5 px-4 mr-1 rounded' onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <!-- <div class="flex justify-center" style="margin-top:25px">
        <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full" style="width:300px">
        Apply</button>
    </div> -->
@endsection