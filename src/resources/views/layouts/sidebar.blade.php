{{--
    @todo Define the sidebar layout
    @body A layout to be used with a sidebar must be defined. It must extend the layout 'master'.
--}}
@extends('layouts.master')

@section('head')
    <style>
        .sidebar-brand img {
            transition: width .5s ease, height .5s ease;
        }

        .wrapper {
            display: flex;
            width: 100%;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 999;
            color: #fff;
            transition: all 0.3s;
        }

        .sidebar .sidebar-header {
            padding: 20px;
        }

        .sidebar ul.components {
            padding: 20px 0;
        }

        .sidebar ul p {
            color: #fff;
            padding: 10px;
        }

        .sidebar ul li a {
            padding: 10px;
            font-size: 1.1em;
            display: block;
        }


        .sidebar ul li.active > a,
        a[aria-expanded="true"] {
            color: #fff;
        }

        a[data-toggle="collapse"] {
            position: relative;
        }

        .sidebar-content {
            width: calc(100% - 250px);
            min-height: 100vh;
            transition: all 0.3s;
            position: absolute;
            top: 0;
            right: 0;
        }

        #main {
            padding: 15px;
            width: 100%;
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* ---------------------------------------------------
            MEDIAQUERIES
        ----------------------------------------------------- */

        @media (max-width: 768px) {
            .sidebar {
                margin-left: 0;
                width: 70px;
            }

            .sidebar-content /*,#main*/
            {
                width: calc(100% - 70px);
            }

            #main {
                width: 100%;
            }

            .sidebar-brand img {
                width: 30px;
                height: 30px;
            }
        }

        .sidebar-brand {
            display: inline-block;
            padding-top: 0.32rem;
            padding-bottom: 0.32rem;
            /* margin-right: 1rem; */
            font-size: 1.125rem;
            line-height: inherit;
            white-space: nowrap;
        }
    </style>
@endsection

@section('body')
    <div class="wrapper">
        <nav class="sidebar el-8dp" id="main-navigation" aria-label="Sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand text-center w-100" style="text-decoration: none;" href="#">
                    <img src="logo.png" width="64"
                         height="64"
                         class="d-inline-block d-md-inline-block align-center mx-auto" alt="Emotionally's logo">
                    <img src="./app_name.svg" width="150"
                         height="30"
                         class="d-none d-md-inline" alt="Emotionally">
                </a>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>

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
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
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
