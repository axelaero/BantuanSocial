@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg" style="text-align:center">
            <form action="{{ route('periodecreate')}}" method="post">
            @csrf
                Periode : {{$data}}
                <div class="flex justify-center" style="margin-top:25px">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full" style="width:300px">
                    Buat Periode Baru</button>
                </div>
            </form>
        </div>
    </div>
@endsection