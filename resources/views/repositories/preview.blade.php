<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Preview: {{ $repository->name }} | {{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="flex flex-col min-h-screen bg-vt-blue-100">
            <livewire:repository-preview-status-bar :repository="$repository"/>

            <x-icon-loading-indicator class="h-24 w-24 m-auto" id="loading-indicator"/>
            <iframe id="preview" class="w-full flex-grow" src="/repositories/{{ $repository->id }}/preview/p/index.html"></iframe>
        </div>

        @stack('modals')

        @livewireScripts
        <script src="{{ mix('js/preview-repository.js') }}"></script>
    </body>
</html>
