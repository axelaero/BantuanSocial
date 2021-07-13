@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-4/12 bg-white p-6 rounded-lg">
            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="username" class="sr-only">Username</label>
                    <input type="text" name="username" id="username" placeholder="Username" 
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('username') border-red-500 @enderror" 
                    value="{{ old('username') }}">

                    @error('username')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" placeholder="Choose a password" 
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('password') border-red-500 @enderror" 
                    value="">

                    @error('password')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="sr-only">Password again</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                    placeholder="Repeat your password" 
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('password_confirmation') border-red-500 @enderror" 
                    value="">

                    @error('password_confirmation')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="role" class="sr-only">Role</label>
                    <input type="text" name="role" id="role" placeholder="Role" 
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('role') border-red-500 @enderror" 
                    value="{{ old('role') }}">

                    @error('username')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="kelurahan_id" class="sr-only">Kelurahan ID</label>
                    <input type="text" name="kelurahan_id" id="kelurahan_id" placeholder="Kelurahan ID" 
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('kelurahan_id') border-red-500 @enderror" 
                    value="{{ old('kelurahan_id') }}">

                    @error('username')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">
                        Register</button>
                </div>
            </form>
        </div>
    </div>
@endsection