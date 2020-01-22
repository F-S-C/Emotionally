@extends('layouts.navbar')

@section('title', 'Emotionally')

@section('head')
    @parent
    <style>
        .splash-screen {
            text-align: center;
            width: 100%;
            height: calc(100vh - 56px);
            background-color: #e55100;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .splash-screen .inner {
            position: absolute;
            top: 50%;
            left: 50%;
            box-shadow: 0 0 24px black;
            border-radius: 15px;
            transform: translate(-50%, -50%);
            padding: 24px;
        }

        .splash-screen .inner .logo {
            width: 20vw;
            max-width: 150px;
            border-radius: 50%;
        }
    </style>
@endsection

@section('navbar-content')
    <ul class="ml-auto navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
            <a class="btn btn-outline-primary" href="#">Log in</a>
        </li>
    </ul>
@endsection

@section('content')
    @parent

    <section id="landing">
        <div class="splash-screen">
            <div class="inner">
                <img class="logo" src="https://raw.githubusercontent.com/F-S-C/Emotionally/master/logo/logo.png">
                <h1 itemprop="name">Strumental<span>Mente</span></h1>
                <h2 itemprop="headline">Dove la musica diventa semplice</h2>
                <div style="margin-top: 1rem;">
                    <a class="btn btn-outline-white btn-rounded waves-effect scroll-down" href="#content"><i
                                class="fas fa-chevron-down"></i></a>
                </div>
            </div>
        </div>
        </div>
    </section>
    <section class="container" id="content">
        robes
    </section>
    {{--
        @todo Complete implementation
        @body Complete the layout as designed.
    --}}
@endsection