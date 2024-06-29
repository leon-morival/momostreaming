<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Momostreaming') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-white ">
    <div
        class="min-h-screen flex bg-gradient-to-r from-blue-300 to-slate-800 flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>


        <div
            class="w-full text-white sm:max-w-md mt-6 px-6 py-4 bg-gradient-to-r from-gray-400 to-slate-400 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}

        </div>
    </div>
</body>

</html>
