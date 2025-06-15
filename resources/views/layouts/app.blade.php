<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kuis Edukatif Farhad')</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background-color: #f0f2f5;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    @include('layouts.navbar')

    <div class="max-w-7xl mx-auto">
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
