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

    <section class="container" id="content">
        TODO: IMPLEMENT
    </section>
    {{--
        @todo Complete implementation
        @body Complete the layout as designed.
    --}}
@endsection
