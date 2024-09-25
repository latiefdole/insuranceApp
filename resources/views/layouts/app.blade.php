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
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <!-- Styles -->
        @vite('resources/css/app.css')
        @stack('style')
    </head>
    <body class="font-sans antialiased bg-gray-900 text-white">
        <div class="flex h-screen">
        @include('layouts.navigation')

           
            <!-- Main content -->
            <div class="flex-grow p-6 ml-64 overflow-y-auto">
                @yield('content')
            </div>
        </div>

        <!-- Scripts -->
        @vite('resources/js/app.js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @stack('script')
    </body>
</html>
