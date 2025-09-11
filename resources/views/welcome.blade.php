<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $web_setting->nama_web ?? config('app.name') }}</title>

    {{-- Favicon dan Font (opsional) --}}
    @if(!empty($web_setting->logo_web))
        <link rel="icon" type="image/png" href="{{ $web_setting->logo_web }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    {{-- BLOK KODE DEVTOOLS DITAMBAHKAN DI SINI --}}
    @production
        <script>
            // Mengatur host koneksi, persis seperti arahan dokumentasi
            // Kita gunakan '127.0.0.1' agar lebih pasti daripada 'localhost'
            window.__VUE_DEVTOOLS_HOST__ = '127.0.0.1';
            // Port default adalah 8098
            window.__VUE_DEVTOOLS_PORT__ = '8098';
        </script>
        {{-- Memuat skrip client langsung dari proxy DevTools yang berjalan di lokal --}}
        <script src="http://127.0.0.1:8098"></script>
    @endproduction

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 text-gray-900">
    <div id="app"></div>
</body>
</html>