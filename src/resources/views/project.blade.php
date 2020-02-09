@extends('layouts.system')

@section('head')
    @parent
    <style>
        .square {
            width: 100%;
            padding-bottom: 100%;
            background-size: cover;
            background-position: center;
        }

        .card-title {
            margin: 0;
        }

        .card-img-overlay {
            top: unset;
            bottom: 0;
            text-align: center;
        }

        .card {
            position: relative;
            overflow: hidden;
        }

        .bg-video-placeholder {
            position: absolute;
            height: 130%;
            width: 130%;
            left: -15%;
            top: -15%;
            background-size: cover;
            background-position: center;
            filter: blur(10px);
            opacity: 0.5;
        }

        .folder-background::before {
            opacity: 0.75;
            font-size: 4rem;
            position: absolute;
            font-family: 'Font Awesome 5 Free Regular', fantasy;
            font-weight: 400;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            content: "\f07b";
        }

        .video-background::before {
            opacity: 0.75;
            font-size: 4rem;
            position: absolute;
            font-family: 'Font Awesome 5 Free', fantasy;
            font-weight: 900;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            content: "\f03d";
        }
    </style>
@endsection

@section('title', $project->name)

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('system.home')}}">
            <span class="fas fa-home" aria-hidden="true"></span>
            @lang('dashboard.home')
        </a>
    </li>
    @foreach($path as $father)
        @if(!$loop->last)
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                <a href="{{route('system.project-details', $father->id)}}">
                    <span class="fas fa-folder" aria-hidden="true"></span>
                    {{$father->name}}
                </a>
            </li>
        @else
            <li class="breadcrumb-item active" aria-current="page">
                <span class="fas fa-folder" aria-hidden="true"></span>
                {{$father->name}}
            </li>
        @endif
    @endforeach
@endsection

@section('inner-content')
    @if(!isset($subprojects) && !isset($videos))
        <p>ERRORE</p>
    @else
        <div class="row row-cols-1 row-cols-md-5">
            @foreach($subprojects as $project)
                <div class="col mb-4">
                    <div class="card h-100 el-8dp text-white square">
                        <div class="folder-background card-img-top"></div>
                        <div class="card-img-overlay">
                            <span class="sr-only">Project: </span>
                            <h5 class="card-title">{{$project->name}}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach($videos as $video)
                <div class="col mb-4">
                    <div class="card h-100 el-8dp text-white square">
                        <div class="card-img-top bg-video-placeholder"
                             style="background-image: url('{{$video->thumbnail}}')"></div>
                        <div class="video-background card-img-top"></div>
                        <div class="card-img-overlay">
                            <span class="sr-only">Video: </span>
                            <h5 class="card-title">{{$video->name}}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{--    @foreach(array_merge($subprojects, $videos) as $element)--}}
        {{--    @endforeach--}}
    @endif
@endsection

@section('scripts')
    @parent
    <script>
    </script>
@endsection
