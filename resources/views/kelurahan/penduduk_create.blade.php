@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-4/12 bg-white p-6 rounded-lg">
            <form action="{{ route('pendudukcreate') }}" method="post">
            @csrf
                <div class="mb-4">
                    <label for="NIK" class="sr-only">NIK</label>
                    <input type="text" name="NIK" id="NIK" placeholder="NIK" 
                    class="bg-gray-100 border-2 w-full p-2 rounded-lg @error('NIK') border-red-500 @enderror" 
                    value="{{ old('NIK') }}">

                    @error('NIK')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="KK" class="sr-only">KK</label>
                    <input type="text" name="KK" id="KK" placeholder="KK" 
                    class="bg-gray-100 border-2 w-full p-2 rounded-lg @error('KK') border-red-500 @enderror" 
                    value="{{ old('KK') }}">

                    @error('KK')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="BDT" class="sr-only">BDT</label>
                    <input type="text" name="BDT" id="BDT" placeholder="BDT" 
                    class="bg-gray-100 border-2 w-full p-2 rounded-lg @error('BDT') border-red-500 @enderror" 
                    value="{{ old('BDT') }}">

                    @error('BDT')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nama" class="sr-only">Nama</label>
                    <input type="text" name="nama" id="nama" placeholder="Nama" 
                    class="bg-gray-100 border-2 w-full p-2 rounded-lg @error('nama') border-red-500 @enderror" 
                    value="{{ old('nama') }}">

                    @error('nama')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="alamat" class="sr-only">Alamat</label>
                    <input type="text" name="alamat" id="alamat" placeholder="Alamat" 
                    class="bg-gray-100 border-2 w-full p-2 rounded-lg @error('alamat') border-red-500 @enderror" 
                    value="{{ old('alamat') }}">

                    @error('alamat')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="rt" class="sr-only">RT</label>
                    <input type="text" name="rt" id="rt" placeholder="RT" 
                    class="bg-gray-100 border-2 w-full p-2 rounded-lg @error('rt') border-red-500 @enderror" 
                    value="{{ old('rt') }}">

                    @error('rt')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="rw" class="sr-only">RW</label>
                    <input type="text" name="rw" id="rw" placeholder="RW" 
                    class="bg-gray-100 border-2 w-full p-2 rounded-lg @error('rw') border-red-500 @enderror" 
                    value="{{ old('rw') }}">

                    @error('rw')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="sr-only">Deskripsi</label>
                    <input type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi" 
                    class="bg-gray-100 border-2 w-full p-2 rounded-lg @error('deskripsi') border-red-500 @enderror" 
                    value="{{ old('deskripsi') }}">

                    @error('deskripsi')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    Kelurahan: {{ auth()->user()->username }}
                    <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">
                        Tambah Penduduk</button>
                </div>
            </form>
        </div>
    </div>
@endsection