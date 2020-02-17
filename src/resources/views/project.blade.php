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
    @if($subprojects->isEmpty() && $videos->isEmpty())
        <div class="text-center">
            <img style="height: 40vh" class="mb-3" aria-hidden="true"
                 src="{{asset('/images/undraw_sentiment_analysis.svg')}}"
                 alt="@lang('project-details.short-empty-project')">
            <p>@lang('project-details.empty-project')
                @if($project->father_id == "")
                    @lang('project-details.add-project') @lang('project-details.or')
                @endif
                @lang('project-details.upload-video')</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5">
            @each('partials.project-card', $subprojects, 'project')
            @each('partials.video-card', $videos, 'video')
        </div>
    @endif
    @include('shared.modals')
@endsection

@section('scripts')
    @parent
    <script>
        (function ($) {
            $(document).ready(function () {
                $('.project-detail-card').click(function (event) {
                    //prevent execution from bubbling
                    if (event.target === this) {
                        window.location = $(this).data('href');
                    }
                });

                $('#add-sub-proj').click(function () {
                    $('#create-project-modal').modal('show');
                });

                $('#upload-som').click(function () {
                    let dropdown = $('.dropdown-menu');
                    if (dropdown.hasClass('show'))
                        dropdown.removeClass('show');
                    else
                        dropdown.addClass('show');
                });

                //SCRIPT DROPDOWN
                let projectRenameComplete = $('#project-rename-complete');
                let projectRenameChanging = $('#project-rename-updating');
                let projectRenameError = $('#project-rename-error');
                let videoRenameComplete = $('#video-rename-complete');
                let videoRenameChanging = $('#video-rename-updating');
                let videoRenameError = $('#video-rename-error');
                let deleteComplete = $('#project-delete-complete');
                let deleteChanging = $('#project-delete-updating');
                let deleteError = $('#project-delete-error');


                $('.rename-project-btn').on('click', function () {
                    $('#rename-project-modal').modal('show');
                    $('#project_rename_id').val($(this).parent().attr('aria-labelledby').replace('more-project-', ''));
                    $('#project-rename-form').show();
                    videoRenameError.hide();
                    videoRenameChanging.hide();
                    videoRenameComplete.hide();
                });

                $('.rename-video-btn').on('click', function () {
                    $('#rename-video-modal').modal('show');
                    $('#video_rename_id').val($(this).parent().attr('aria-labelledby').replace('more-video-', ''));
                    $('#video-rename-form').show();
                    projectRenameError.hide();
                    projectRenameChanging.hide();
                    projectRenameComplete.hide();
                });

                $('.delete-project-btn').on('click', function () {
                    $('#delete-project-modal').modal('show');
                    $('#project_delete_id').val($(this).parent().attr('aria-labelledby').replace('more-project-', ''));
                    $('#project-delete-form').show();
                    projectRenameError.hide();
                    projectRenameChanging.hide();
                    projectRenameComplete.hide();
                });

                $('#project-rename-form').on('submit', function (event) {
                    event.preventDefault();
                    $('#project-rename-form').hide();
                    projectRenameChanging.show();
                    $.ajax({
                        url: this.action,
                        type: this.method,
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function (data) {
                            $('#project_new_name').val('');
                            projectRenameChanging.hide();
                            projectRenameComplete.show();
                            $('#rename-project-modal').on('hidden.bs.modal', function () {
                                location.reload();
                            });
                        },
                        error: function (data) {
                            projectRenameChanging.hide();
                            projectRenameError.show();
                            console.log(data);
                        }
                    });
                });

                $('#project-delete-form').on('submit', function (event) {
                    event.preventDefault();
                    $('#project-delete-form').hide();
                    deleteChanging.show();
                    $.ajax({
                        url: this.action,
                        type: this.method,
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function (data) {
                            $('#project_delete').val('');
                            deleteChanging.hide();
                            deleteComplete.show();
                            $('#delete-project-modal').on('hidden.bs.modal', function () {
                                location.reload();
                            });
                        },
                        error: function (data) {
                            deleteChanging.hide();
                            deleteError.show();
                            console.log(data);
                        }
                    });
                });

                $('#video-rename-form').on('submit', function (event) {
                    event.preventDefault();
                    $('#video-rename-form').hide();
                    videoRenameChanging.show();
                    $.ajax({
                        url: this.action,
                        type: this.method,
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function (data) {
                            $('#video_new_name').val('');
                            videoRenameChanging.hide();
                            videoRenameComplete.show();
                            $('#rename-video-modal').on('hidden.bs.modal', function () {
                                location.reload();
                            });
                        },
                        error: function (data) {
                            videoRenameChanging.hide();
                            videoRenameError.show();
                            console.log(data);
                        }
                    });
                });
            });
        })(jQuery);
    </script>
@endsection
