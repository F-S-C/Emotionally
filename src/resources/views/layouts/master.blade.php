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
    <title>@yield('title')</title>
</head>
<body>
    <nav aria-labelledby="skip-navigation-link">
        <a id="skip-navigation-link" class="skip-navigation" href="#main" role="button">Skip to main content</a>
    </nav>
    @yield('body')
    <footer class="el-8dp text-light">
        <div class="footer-content py-2 el-4dp">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        Emotionally
                    </div>
                    <div class="col-4">
                        Informazioni
                    </div>
                    <div class="col-4">
                        Altri link
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright text-white-50 py-2">
            <div class="container">
                Copyright &copy; 2019,
                <a href="https://F-S-C.github.io/" target="_blank">FSC</a>.
                @lang('metadata.copyright')
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>

    @yield('scripts', '')
</body>
</html>
