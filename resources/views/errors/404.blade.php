<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">
    </head>
    <body class="font-sans antialiased text-vt-darkGray-900 bg-gray-100 flex flex-col items-center justify-center h-screen m-12">
        <x-illustration-not-found class="w-full md:w-3/4 max-w-prose max-h-full mb-8"/>
        <div class="text-3xl text-center">Page not found!</div>
        <div class="text-center">
            <a href="{{ route('welcome') }}" class="text-vt-pink-700 hover:text-vt-pink-800">
                Go back
            </a>
        </div>
    </body>
</html>

