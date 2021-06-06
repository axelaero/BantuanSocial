<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan Sosial</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-200">
    <nav class="p-6 bg-white flex justify-between mb-6">
        <ul class="flex items-center">
            <li>
                <a href="/" class="p-3">Home</a>
            </li>
            @auth
                @if(auth()->user()->role == 0 || auth()->user()->role == 1)
                    <li>
                        <a href="{{ route('admindashboard') }}" class="p-3">Dashboard Admin</a>
                    </li>
                @endif
                @if(auth()->user()->role == 3)
                    <li>
                        <a href="{{ route('pendudukdashboard') }}" class="p-3">Data Baru</a>
                    </li>
                    <li>
                        <a href="{{ route('pendudukcreateview') }}" class="p-3">Pembuatan Data Baru</a>
                    </li>
                    <li>
                        <a href="{{ route('pendudukreport') }}" class="p-3">Report</a>
                    </li>
                @endif
                @if(auth()->user()->role == 2)
                    <li>
                        <a href="{{ route('dinasdashboard') }}" class="p-3">Dashboard Dinas</a>
                    </li>
                    <li>
                        <a href="{{ route('mentridashboard') }}" class="p-3">Pengecekan oleh Mentri</a>
                    </li>
                    <li>
                        <a href="{{ route('periode') }}" class="p-3">Pengaturan Periode</a>
                    </li>
                @endif
            @endauth
        </ul>
        <ul class="flex items-center">
            @auth
                <li>
                    <a href="" class="p-3">Hi, {{ auth()->user()->username }}!</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="post" class="p-3 inline">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            @endauth

            @guest
                <li>
                    <a href="{{ route('login') }}" class="p-3">Login</a>
                </li>
                <li>
                    <a href="{{ route('register')}}" class="p-3">Register</a>
                </li>
            @endguest
        </ul>
    </nav>
    @yield('content')
</body>
</html>