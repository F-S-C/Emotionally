@extends('layouts.master')

@section('body')
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="https://getbootstrap.com/docs/4.4/assets/brand/bootstrap-solid.svg" width="30" height="30"
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

    <main class="content" style="padding-top: 56px;" id="main">
        @yield('content')
    </main>
@endsection