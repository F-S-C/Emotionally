@extends('layouts.system')

@section('title', $project->name)

@section('breadcrumbs')
        <li class="breadcrumb-item">
            <a href="{{route('system.home')}}">
                <span class="fas fa-home" aria-hidden="true"></span>
                @lang('dashboard.home')
            </a>
        </li>
        @foreach($path as $father)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                    <a href="{{route('system.project-details', $father->id)}}">
                        <span class="fas fa-folder" aria-hidden="true"></span>
                        {{$father->name}}
                    </a>
                </li>
        @endforeach
        <li class="breadcrumb-item active" aria-current="page">
            <span class="fas fa-file" aria-hidden="true"></span>
            @lang('dashboard.report')
        </li>
@endsection

@section('inner-content')
    <div class="row">
        <div > Grafico 1 </div>
        <div > Grafico 2 </div>
        <div > Grafico 3 </div>
    </div>
    <div class="row">
        <div > Ultimo Grafico </div >
    </div>
@endsection
