@extends('layouts.master')

@section('body')
    <style>
        html,
        body {
            height: 100%;
        }

        .primary-container {
            height: 80%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <div class="primary-container container">
        <div class="row">
            <div class="col p-5">
                    <div class="row">
                        <img src="{{ asset('/logo.png') }}" class="mx-auto d-block mt-5" width="110" alt="Emotionally's Logo">
                    </div>
                    <div class="row">
                        <img src="{{ asset('/app_name.svg') }}" class="mx-auto d-block" width="150" alt="Emotionally">
                    </div>
            </div>
            <div class="w-100"></div>
            <div class="col px-4 px-md-5 pt-4 pb-3 mx-4 mx-sm-0 rounded el-2dp shadow-sm">
                <h1 class="text-center mb-3">@yield('form-name')</h1>
                @yield('form')
            </div>
        </div>
    </div>
    @endsection

@section('footer')
    @endsection
