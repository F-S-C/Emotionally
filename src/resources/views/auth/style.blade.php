@extends('layouts.master')

@section('head')
    @parent
    <style>
        html,
        body {
            height: 100%;
            background-image: url("{{ asset('/people.jpg') }}");
            background-repeat: no-repeat;
            background-position: center;
        }

        .w-small{
            width: 60%!important;
        }

        @media only screen and (max-width: 600px) {
            .w-small {
                width: 100%!important;
            }
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid w-small">
    <div class="container mw-100">
        <div class="row">
            <div class="col py-2 my-4">
                <a href="{{ route('landing') }}">
                    <div class="row">
                        <img src="{{ asset('/logo.png') }}" class="mx-auto d-block img-fluid" width="100"
                             alt="Emotionally's Logo">
                    </div>
                    <div class="row">
                        <img src="{{ asset('/app_name.svg') }}" class="mx-auto d-block" width="150" alt="Emotionally">
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col px-md-5 pt-4 pb-3 mb-2 rounded el-2dp shadow-sm">
                <h2 class="text-center mb-3">@yield('form-name')</h2>
                @yield('form')
            </div>
        </div>
    </div>
    </div>
@endsection

@section('footer')
@endsection
