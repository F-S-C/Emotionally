{{--
    @todo Define the sidebar layout
    @body A layout to be used with a sidebar must be defined. It must extend the layout 'master'.
--}}
@extends('layouts.master')

@section('body')
    <div class="wrapper">
        <nav class="sidebar el-8dp" id="main-navigation" aria-label="Sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand text-center w-100" style="text-decoration: none;" href="{{route('system.home')}}">
                    <img src="{{asset('/logo.png')}}" width="64"
                         height="64"
                         class="d-inline-block d-md-inline-block align-center mx-auto" alt="Emotionally's logo">
                    <img src="{{asset('/app_name.svg')}}" width="150"
                         height="30"
                         class="d-none d-md-inline" alt="Emotionally">
                </a>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item active">
                    <div class="nav-link collapse-button-container">
                        <a type="button" class="collapse-button" data-toggle="collapse" href="#projects-container" role="button" aria-expanded="false" aria-controls="projects-container"></a>
                        <a href="{{route('system.home')}}">Projects</a>
                    </div>
                    <ul class="collapse el-3dp nav flex-column" id="projects-container">
                        <li class="nav-item">
                            <div class="nav-link collapse-button-container">
                                <a type="button" class="collapse-button" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample"></a>
                                <a href="#">Projects</a>
                            </div>
                            <ul class="collapse el-3dp nav flex-column" id="collapseExample2">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">About</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Portfolio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>

        </nav>

        <div class="content sidebar-content">
            <nav class="navbar navbar-expand-lg navbar-dark el-0dp" style="padding: 20px 30px;" aria-label="navbar">
                <div class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2 rounded-pill" type="search" placeholder="Search" aria-label="Search" id="search-bar">
                </div>
{{--                <button class="navbar-toggler" type="button" data-toggle="collapse"--}}
{{--                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"--}}
{{--                        aria-expanded="false" aria-label="Toggle navigation">--}}
{{--                    <span class="navbar-toggler-icon"></span>--}}
{{--                </button>--}}

{{--                <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--                    <ul class="navbar-nav mr-auto">--}}
{{--                        <li class="nav-item active">--}}
{{--                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="#">Link</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
            </nav>
            <main id="main">
                @yield('content')
            </main>
        </div>
    </div>
@endsection

@section('footer-class', 'fixed-bottom')

@section('scripts')
    <script type="text/javascript">
        (function ($) {
            $(document).ready(function () {
                $('.sidebarCollapse').on('click', function () {
                    $('.sidebar, #main').toggleClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
            });
        })(jQuery);
    </script>
@endsection
