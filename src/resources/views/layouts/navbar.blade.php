@extends('layouts.master')

@section('head')
    <style>
        body {
            padding-top: 56px; /* Padding for the navbar */
        }
    </style>
@endsection

@section('body')
    <header>
        <nav id="main-navigation" class="navbar navbar-expand-lg navbar-dark el-8dp fixed-top"
             aria-label="Main navigation">
            <div class="container">
                <a class="navbar-brand" style="text-decoration: none;" href="#">
                    <img src="{{asset('/logo.png')}}" width="30"
                         height="30"
                         class="d-inline-block align-top" alt="Emotionally's logo">
                    <img src="{{asset('/app_name.svg')}}" width="150"
                         height="30"
                         class="d-inline-block align-tp" alt="Emotionally">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#main-navigation-content"
                        aria-controls="main-navigation-content" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="main-navigation-content">
                    @yield('navbar-content')
                </div>
            </div>
        </nav>
    </header>

    <main class="content" id="main">
        @yield('content')
    </main>
@endsection

@section('footer')
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
    @parent
@endsection
