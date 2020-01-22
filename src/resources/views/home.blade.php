@extends('layouts.sidebar')

@section('title', 'Emotionally')

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
            <a class="btn btn-outline-primary nav-link" href="#">Log in</a>
        </li>
    </ul>
@endsection

@section('content')
    @parent

    <section id="landing">
        <div class="splash-screen">
            <div class="inner el-12dp">
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
    <section class="container" id="content">
        robes
    </section>
    {{--
        @todo Complete implementation
        @body Complete the layout as designed.
    --}}
@endsection