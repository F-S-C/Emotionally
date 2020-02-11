@extends('layouts.sidebar')

@section('content')
    @parent

    <section class="container-fluid" id="content">
        <header class="mb-3">
            <h1 class="d-block d-md-inline">@yield('title')</h1>
            <nav id="breadcrumbs" class="breadcrumb-container" aria-label="breadcrumbs">
                <ol class="breadcrumb bg-transparent">
                    @yield('breadcrumbs')
                </ol>
            </nav>
        </header>

        @yield('inner-content')

    </section>
@endsection

@section("scripts")
    @parent
    <script type="text/javascript" src="{{mix('/js/vendor/affdex.js')}}"></script>
    <script type="text/javascript" src="{{mix('/js/emotion-analysis.js')}}"></script>
@endsection
