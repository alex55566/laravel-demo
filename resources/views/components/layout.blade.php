<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Главная страница')</title>
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.ts'])
</head>

<body>
    <div class="layout-page">
        <div class="layout-page--wrapper" id="app">
            {{ $slot }}
        </div>
    </div>
</body>

</html>