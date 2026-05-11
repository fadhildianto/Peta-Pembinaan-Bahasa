<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div
            class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 {{ Route::is('login') ? 'bg-cover bg-center bg-no-repeat' : 'bg-gray-100 dark:bg-gray-900' }}"
            @if(Route::is('login')) style="background-image: linear-gradient(rgba(15, 23, 42, 0.35), rgba(15, 23, 42, 0.35)), url('{{ asset('images/balai-bahasa-riau.jpg') }}');" @endif
        >
            <div>
                <a href="/">
                    @if(Route::is('login'))
                        <img src="{{ asset('images/logo-bbpr.png') }}" alt="Balai Bahasa Provinsi Riau" class="w-40 h-auto">
                    @else
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    @endif
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
