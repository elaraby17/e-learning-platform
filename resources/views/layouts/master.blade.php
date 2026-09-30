<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data x-bind:class="$store.theme.dark ? 'dark' : ''">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E Learning Platform')</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        cairo: ['Cairo', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                dark: localStorage.getItem('theme') === 'dark',
                toggle() {
                    this.dark = !this.dark;
                    localStorage.setItem('theme', this.dark ? 'dark' : 'light');
                }
            });
        });
    </script>
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-8px)
            }
        }

        .float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-white dark:bg-slate-900 transition-colors duration-300">
    @auth
        @include('layouts.partials.sidebar')
    @endauth

    @guest
        <div class="min-h-screen flex flex-col">
            @include('layouts.partials.header')
            <main class="flex-1 p-4">
                @yield('content')
            </main>
            @include('layouts.partials.footer')
        </div>
    @endguest
</body>

</html>
