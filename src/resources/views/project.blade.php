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
        <p>ERRORE</p> {{-- TODO: Change error message --}}
    @else
        <div class="row row-cols-1 row-cols-md-5">
            @each('partials.project-card', $subprojects, 'project')
            @each('partials.video-card', $videos, 'video')
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            $('.project-detail-card').click(function (event) {
                //prevent execution from bubbling
                if (event.target === this) {
                    window.location = $(this).data('href');
                }
            });
        });
    </script>
@endsection
