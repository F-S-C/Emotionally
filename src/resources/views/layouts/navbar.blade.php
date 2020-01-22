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
        <nav id="main-navigation" class="navbar navbar-expand-lg navbar-dark el-8dp fixed-top" aria-label="Main navigation">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="https://raw.githubusercontent.com/F-S-C/Emotionally/master/logo/logo.png" width="30" height="30"
                         class="d-inline-block align-top" alt="Emotionally's logo">
                    Emotionally
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navigation"
                        aria-controls="main-navigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="main-navigation">
                    @yield('navbar-content')
                </div>
            </div>
        </nav>
    </header>

    <main class="content" id="main">
        @yield('content')
    </main>
@endsection