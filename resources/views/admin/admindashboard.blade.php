@extends('layouts.app')

@section('content')
    <!-- <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            Dashboard Admin
        </div>
    </div> -->
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg justify-center flex">
            <table class="shadow-lg bg-white">
                <tr>
                    <td class="text-center border px-8 py-2">Index</td>
                    <td class="text-center border px-8 py-2">Username</td>
                    <td class="text-center border px-8 py-2">Role</td>
                    <td class="text-center border px-8 py-2">Kelurahan</td>
                    <td class="text-center border px-8 py-2">Action</td>
                </tr>
                @foreach($users as $user)
                <tr>
                    <td class="text-center border px-8 py-2">{{$loop->iteration}}</td>
                    <td class="text-center border px-8 py-2">{{$user->username}}</td>
                    <td class="text-center border px-8 py-2">{{$user->role}}</td>
                    @if(!$user->kelurahan_nama)
                        <td class="text-left border px-8 py-2" style="text-align:center;">-</td>
                    @else
                        <td class="text-left border px-8 py-2" style="text-align:center;">{{$user->kelurahan_nama}}</td>
                    @endif
                    <td class='border text-center px-8 py-2'>
                        <a href='' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-green-700 hover:bg-green-900 text-white font-normal py-0.5 px-4 mr-1 rounded'>Edit</a>
                        <a href='' class='btn-primary transition duration-300 ease-in-out focus:outline-none focus:shadow-outline bg-red-700 hover:bg-red-900 text-white font-normal py-0.5 px-4 mr-1 rounded' onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                @endforeach
             </table>
        </div>
    </div>
@endsection