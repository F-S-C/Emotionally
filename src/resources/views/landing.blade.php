@extends('layouts.navbar')

@section('title', 'Emotionally')

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
    {{--
        @todo Complete implementation
        @body Complete the layout as designed.
    --}}
@endsection