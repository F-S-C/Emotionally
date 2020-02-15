@extends('layouts.master')

@section('head')
    @parent
    <style>
        #main {
            padding: 15px 15px 64px;
            width: 100%;
            min-height: 100%;
            transition: all 0.3s;
        }

        #main {
            width: 100%;
        }
    </style>
@endsection

@section('body')
    <div class="wrapper">
        <nav class="sidebar el-8dp scrollbar-inner" id="main-navigation" aria-label="Sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand text-center w-100  d-flex" style="text-decoration: none;"
                   href="{{route('system.home')}}">
                    <img src="{{asset('/logo.png')}}" width="64"
                         height="64"
                         class="d-inline-block d-md-inline-block align-center mx-auto" alt="Emotionally's logo">
                    <img src="{{asset('/app_name.svg')}}" width="16"
                         height="64"
                         class="d-none d-md-inline-block flex-fill" alt="Emotionally">
                </a>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item active">
                    @if(!Auth::user()->projects->isEmpty())
                        <div class="btn-group collapse-button-container">
                            <a type="button" class="nav-link collapse-button d-none d-md-block" data-toggle="collapse"
                               href="#projects-container"
                               role="button" aria-expanded="false" aria-controls="projects-container"></a>
                            <a class="nav-link text-center text-md-left" href="{{route('system.home')}}">
                                <span aria-hidden="true" class="fas fa-home mr-0 mr-md-1 text-md-center"></span>
                                <span class="d-none d-md-inline">Projects</span>
                            </a>
                        </div>
                    @else
                        <a class="nav-link text-center text-md-left" href="{{route('system.home')}}">
                            <span aria-hidden="true" class="fas fa-home mr-0 mr-md-1 text-md-center"></span>
                            <span class="d-none d-md-inline">Projects</span>
                        </a>
                    @endif
                    <ul class="collapse el-3dp nav flex-column flex-nowrap" id="projects-container">
                        @each('partials.project-tree-view', Auth::user()->projects->where('father_id', null), 'main_project')
                    </ul>
                </li>
                <li class="nav-item text-center text-md-left">
                    <a class="nav-link text-center text-md-left" href="#">
                        <span aria-hidden="true" class="fas fa-info-circle mr-0 mr-md-1 text-md-center"></span>
                        <span class="d-none d-md-inline">About</span>
                    </a>
                </li>
                <li class="nav-item text-center text-md-left">
                    <a class="nav-link" href="#">
                        <span aria-hidden="true" class="fas fa-file-alt mr-0 mr-md-1 text-md-center"></span>
                        <span class="d-none d-md-inline">Portfolio</span>
                    </a>
                </li>
                <li class="nav-item text-center text-md-left">
                    <a class="nav-link" href="#">
                        <span aria-hidden="true" class="fas fa-phone-alt mr-0 mr-md-1 text-md-center"></span>
                        <span class="d-none d-md-inline">Contact</span>
                    </a>
                </li>
                <li class="nav-item text-center text-md-left">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <span aria-hidden="true" class="fas fa-sign-out-alt mr-0 mr-md-1 text-md-center"></span>
                        <span class="d-none d-md-inline">Logout</span>
                    </a>
                </li>
            </ul>

        </nav>

        <div class="content sidebar-content">
            <nav class="navbar navbar-expand-lg navbar-dark el-0dp" style="padding: 20px 30px;" aria-label="navbar">
                <div class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2 rounded-pill" type="search" placeholder="Search"
                           aria-label="Search" id="search-bar">
                </div>

                <div aria-label="Your profile" class="ml-auto form-inline my-2 my-lg-0">
                    <img alt="" aria-hidden="true" class="rounded-circle p-1 border border-text" width="48" height="48"
                         src="https://robohash.org/{{Auth::user()->email}}?set=set3"/>
                    <div class="ml-2">
                        <span aria-label="Your name"
                              class="font-weight-bold text-white d-block">{{Auth::user()->name}} {{Auth::user()->surname}}</span>
                        <small aria-label="Your email" class="d-block">{{Auth::user()->email}}</small>
                    </div>
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
                $('.sidebar').scrollbar();
            });
        })(jQuery);
    </script>
@endsection
