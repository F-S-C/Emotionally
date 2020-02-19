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
                <div class="col-4 text-left">
                    <b>@lang('navbar.title_emotionally')</b>
                </div>
                <div class="col-4 text-center">
                    <b> @lang('navbar.title_information')</b>
                </div>
                <div class="col-4 text-right">
                    <b>@lang('navbar.title_other_link')</b>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4 text-left">
                    @lang('navbar.description_emotionally')
                </div>
                <div class="col-4 ">
                    <p>@lang('navbar.description_information')</p>
                </div>
                <div class="col-4 text-right">
                    <a href="https://f-s-c.github.io/" target="_blank"> FSC</a><br>
                    <a href="https://strumentalmente.it/" target="_blank">Strumentalmente</a><br>
                    <a href="https://github.com/F-S-C/Cicerone" target="_blank">Repository Cicerone</a> <br>
                    <a href="https://github.com/F-S-C/Emotionally" target="_blank">Repository Emotionally</a><br>
                    <a href="https://github.com/F-S-C/StrumentalMente" target="_blank">Repository Strumentalmente</a><br>
                    <a href="https://github.com/F-S-C/The-Doomed-Ship" target="_blank">The Doomed Ship</a><br>
                </div>
            </div>
        </div>
    </div>
    @parent
@endsection
