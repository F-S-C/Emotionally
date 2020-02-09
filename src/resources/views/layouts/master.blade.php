<!--
    The main layout for the entire system. It imports all the dependencies and defines all the common sections.
-->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @yield('head', '')

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <title>@yield('title') | Emotionally</title>
</head>
<body>
    <nav aria-labelledby="skip-navigation-link">
        <a id="skip-navigation-link" class="skip-navigation" href="#main">Skip to main content</a>
    </nav>
    @yield('body')

    <footer class="el-8dp text-light @yield('footer-class', '')">
        @section('footer')
            <div class="copyright text-white-50 py-2">
                <div class="container-fluid px-3">
                    <p class="d-inline-block mt-md-1">
                        Copyright &copy; 2019,
                        <a href="https://F-S-C.github.io/" target="_blank">FSC</a>.
                        @lang('metadata.copyright')
                    </p>
                    <img src="fsc_logo_text.png" width="140" alt="Five Students of Computer Science"
                         class="float-md-right d-md-inline-block mr-md-3 d-none">
                    <img src="fsc_logo.svg" width="35" alt="Five Students of Computer Science"
                         class="float-sm-right float-none d-md-none d-sm-inline-block d-none">
                </div>
            </div>
        @show
    </footer>

    <script src="{{mix('/js/app.js')}}" type="text/javascript"></script>

    @yield('scripts', '')
</body>
</html>
