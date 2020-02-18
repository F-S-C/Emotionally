@extends('layouts.navbar')

@section('title', 'Landing')

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
            <a class="nav-link text-center" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-center" href="#">Features</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-center" href="#">About</a>
        </li>
        <li class="nav-item">
            <a class="btn btn-outline-primary nav-link"
               href="{{ route('login') }}">
                @if (Auth::check())
                    {{ trans('landing.system') }}
                @else
                    {{ trans('landing.login') }}
                @endif</a>
        </li>
    </ul>
@endsection

@section('content')
    @parent

    <section id="landing">
        <div class="splash-screen">
            <div class="inner el-12dp">
                <img class="logo" src="{{asset('/logo.png')}}"
                     alt="Emotionally's Logo">
                <h1 itemprop="name">Emotionally</h1>
                <p itemprop="headline">{{ trans('metadata.description') }}</p>
                <div style="margin-top: 1rem;">
                    <a class="btn btn-outline-white btn-rounded waves-effect scroll-down" href="#content">
                        <span class="fas fa-chevron-down"></span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="container my-5" id="content">
        <h2>@lang('landing.features')</h2>
        <div class="row text-center mt-5">
            <div class="col-sm-3">
                <span class="fas fa-grin-alt fa-4x text-primary" aria-hidden="true"></span>
                <p class="my-4 h5">@lang('landing.features1')</p>
                <p>@lang('landing.descriptionfeatures1')</p>
            </div>
            <div class="col-sm-3">
                <span class="fas fa-file-video fa-4x text-primary" aria-hidden="true"></span>
                <p class="my-4 h5">@lang('landing.features2')</p>
                <p>@lang('landing.descriptionfeatures2')</p>
            </div>
            <div class="col-sm-3">
                <span class="fas fa-folder fa-4x text-primary" aria-hidden="true"></span>
                <p class="my-4 h5">@lang('landing.features3')</p>
                <p>@lang('landing.descriptionfeatures3')</p>
            </div>
            <div class="col-sm-3">
                <span class="fas fa-file-export fa-4x text-primary" aria-hidden="true"></span>
                <p class="my-4 h5">@lang('landing.features4')</p>
                <p>@lang('landing.descriptionfeatures4')</p>
            </div>
        </div>
    </section>
    <section class="container my-5">
        <h2>About</h2>
    </section>
@endsection
