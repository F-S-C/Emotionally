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

        #main {
            width: calc(100% - 250px);
            padding: 40px;
            min-height: 100vh;
            transition: all 0.3s;
            position: absolute;
            top: 0;
            right: 0;
        }

        /* ---------------------------------------------------
            MEDIAQUERIES
        ----------------------------------------------------- */

        @media (max-width: 768px) {
            .sidebar {
                margin-left: 0;
                width: 70px;
            }

            #main {
                width: calc(100% - 70px);
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
        <nav class="sidebar el-8dp" id="main-navigation">
            <div class="sidebar-header">
                <a class="sidebar-brand text-center w-100" href="#">
                    <img src="https://raw.githubusercontent.com/F-S-C/Emotionally/master/logo/logo.png" width="64"
                         height="64"
                         class="d-inline-block d-md-inline-block align-center mx-auto" alt="Emotionally's logo">
                    <span class="d-none d-md-inline">Emotionally</span>
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
            </ul>

        </nav>

        <main class="content" id="main">
            @yield('content')
        </main>
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
