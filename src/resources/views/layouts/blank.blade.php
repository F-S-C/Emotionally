<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('head', '')

    <title>@yield('title') | Emotionally</title>
</head>
<body>
    @yield('body')

    <script src="{{mix('/js/app.js')}}" type="text/javascript"></script>

    @yield('scripts', '')
</body>
</html>
