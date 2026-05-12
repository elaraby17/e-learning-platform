<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LMS @yield('title')</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}">
</head>

<body class="antialiased bg-[#f8fafc] overflow-x-hidden">
    @auth
        @include('layouts.partials.sidebar')
    @endauth
    @guest
        <main class="flex-1 p-8 mt-8">
            @include('layouts.partials.header')
            <div class="min-h-screen bg-gray-50/50" dir="rtl">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    @yield('content')
                </div>
                @include('layouts.partials.footer')
        </main>
    @endguest

</body>

</html>
