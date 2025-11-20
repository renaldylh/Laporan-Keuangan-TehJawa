<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Teh Jawa - {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            <!-- Background decoration -->
            <div class="fixed inset-0 -z-10 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-teh-jawa-gold/20 to-teh-jawa-gold-accent/30 rounded-full blur-3xl animate-teh-float"></div>
                <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-teh-jawa-gold/15 to-teh-jawa-cream/40 rounded-full blur-3xl animate-teh-float" style="animation-delay: 1s;"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-teh-jawa-gold/10 to-transparent rounded-full blur-2xl"></div>
            </div>

            <!-- Main container -->
            <div class="w-full max-w-md">
                <!-- Logo section -->
                <div class="text-center mb-8">
                    <a href="/" class="inline-block">
                        <div class="mx-auto mb-4 flex items-center justify-center transform hover:scale-105 transition-all duration-300">
                            <img src="{{ asset('image/tehJawa.jpeg') }}" alt="Teh Jawa Logo" class="w-32 h-auto object-contain">
                        </div>
                        <p class="text-teh-jawa-gray mt-2">Sistem Manajemen Keuangan Premium</p>
                    </a>
                </div>

                <!-- Form container -->
                <div class="card-teh-luxury p-8">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <div class="text-center mt-8">
                    <p class="text-teh-jawa-gray text-sm">
                        © 2024 Teh Jawa. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
