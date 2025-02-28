<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kenangid') }}</title>

     <!-- Fonts -->
     <link rel="icon" type="image/x-icon" href="{{ asset('logo.jpg') }}">
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link href="https://fonts.googleapis.com/css2?family=Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
 
     <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="w-full h-screen flex bg-gray-100 dark:bg-gray-900">
        {{ $slot }}
    </div>
</body>
</html>
