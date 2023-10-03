<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @stack('csrf_token')
    <title>LH Multimarcas</title>

    @vite('resources/css/app.css')
    @stack('css')
</head>
<body class="w-full min-h-screen max-h-screen flex bg-neutral-100 dark:bg-neutral-700">
    @if(auth()->check())
        <aside class="w-96 py-6 px-4 bg-blue-800 shadow-md">
            @include('layouts.sidebar')
        </aside>
    @endif

    <main class="w-full relative {{ auth()->check() ? 'p-4' : '' }}">
        <div class="w-full absolute top-0 left-0 z-50 p-4">
            @include('layouts.messages')
        </div>
        <div class="{{ auth()->check() ? 'p-4 bg-white rounded shadow-sm' : 'h-screen grid' }}">
            @yield('content')
        </div>
    </main>

    @vite('resources/js/app.js')
    @stack('js')
</body>
</html>
