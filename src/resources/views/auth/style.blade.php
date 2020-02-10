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

        .primary-container {
            height: 80%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection

@section('body')
    <div class="primary-container container">
        <div class="row">
            <div class="col p-5">
                <a href="{{ route('landing') }}">
                    <div class="row">
                        <img src="{{ asset('/logo.png') }}" class="mx-auto d-block mt-5" width="110"
                             alt="Emotionally's Logo">
                    </div>
                    <div class="row">
                        <img src="{{ asset('/app_name.svg') }}" class="mx-auto d-block" width="150" alt="Emotionally">
                    </div>
                </a>
            </div>
            <div class="w-100"></div>
            <div class="col px-4 px-md-5 pt-4 pb-3 mx-4 mx-sm-0 rounded el-2dp shadow-sm">
                <h2 class="text-center mb-3">@yield('form-name')</h2>
                @yield('form')
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
