@extends('layouts.system')

@section('title', trans('dashboard.dashboard'))

@section('breadcrumbs')
    <li class="breadcrumb-item" aria-current="page"><span class="fas fa-home" aria-hidden="true"></span>
        @lang('dashboard.home')
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        @lang('dashboard.dashboard')
    </li>
@endsection

@section('inner-content')
    <div class="table-responsive mt-3">
        <table id="project-table" class="display w-100 table table-striped table-borderless">
            <caption class="sr-only">@lang('dashboard.your_projects')</caption>
            <thead class="text-uppercase">
            <tr>
                <th scope="col">@lang('dashboard.name')</th>
                <th scope="col" class="text-center">@lang('dashboard.created_at')</th>
                <th scope="col" class="text-center">@lang('dashboard.updated_at')</th>
                <th scope="col" class="text-center">@lang('dashboard.videos')</th>
                <th scope="col" class="text-center">@lang('dashboard.subprojects')</th>
                <th scope="col" class="text-center">@lang('dashboard.average_emotion')</th>
                <th scope="col"><span class="sr-only">@lang('dashboard.go_to_report')</span></th>
                <th scope="col"><span class="sr-only">@lang('dashboard.more')</span></th>
            </tr>
            </thead>
            <tbody>
            @if(isset($projects))
                @foreach($projects as $project)
                    <tr class="clickable" data-href="{{route('system.project-details', $project->id)}}">
                        <td>{{$project['name']}}</td>
                        <td class="text-center">{{date('d/m/Y',strtotime($project->created_at))}}</td>
                        <td class="text-center">{{date('d/m/Y', strtotime($project->updated_at))}}</td>
                        <td class="text-center">{{$project->number_of_videos}}</td>
                        <td class="text-center">{{$project->number_of_subprojects}}</td>
                        <td class="text-center">{{$project->average_emotion}}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-md-text"
                               aria-label="@lang('dashboard.go_to_project_report', ['name'=>$project->name])">@lang('dashboard.report')</a>
                        </td>
                        <td>
                            @include('shared.dropdown-options-menu', ['id'=>'more-project-'.$project->id,'title'=>trans('dashboard.more_options'), 'item_id'=>$project->id, 'named' => 'cacca'])
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    @include('shared.modals')
@endsection

@section('scripts')
    @parent
    <script>
        (function ($) {
            $(document).ready(function () {
                let table = $('#project-table').DataTable({
                    "order": [[0, "asc"]],
                    "paging": false,
                    "info": false,
                    "columnDefs": [
                        {
                            "targets": 7,
                            "orderable": false
                        },
                        {
                            "targets": 6,
                            "orderable": false
                        },
                    ],
                    "dom": '<"top"i>rt<"bottom"><"clear">',
                });

                $('#search-bar').on('keydown click change paste mouseup', function () {
                    table.search($('#search-bar').val()).draw();
                });

                $('.clickable').on('click', function (event) {
                    // prevent execution from bubbling if a link or a button were clicked
                    if (event.target.tagName.toLowerCase() !== 'a' && event.target.tagName.toLowerCase() !== 'button') {
                        window.location = $(this).data('href');
                    }
                });

                $('.dropdown-toggle').click(function (e) {
                    e.stopPropagation();
                    $(this).parent().children('.dropdown-menu').toggle();
                });

                //SCRIPT DROPDOWN
                let renameComplete = $('#project-rename-complete');
                let renameChanging = $('#project-rename-updating');
                let renameError = $('#project-rename-error');
                let deleteComplete = $('#project-delete-complete');
                let deleteChanging = $('#project-delete-updating');
                let deleteError = $('#project-delete-error');

                $('.rename-project-btn').on('click', function () {
                    $('#rename-project-modal').modal('show');
                    $('#project_rename_id').val($(this).parent().attr('aria-labelledby').replace('more-project-', ''));
                    $('#project-rename-form').show();
                    renameError.hide();
                    renameChanging.hide();
                    renameComplete.hide();
                });

                $('.delete-project-btn').on('click', function () {
                    $('#delete-project-modal').modal('show');
                    $('#project_delete_id').val($(this).parent().attr('aria-labelledby').replace('more-project-', ''));
                    $('#project-delete-form').show();
                    renameError.hide();
                    renameChanging.hide();
                    renameComplete.hide();
                });

                $('#project-rename-form').on('submit', function (event) {
                    event.preventDefault();
                    $('#project-rename-form').hide();
                    renameChanging.show();
                    $.ajax({
                        url: this.action,
                        type: this.method,
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function (data) {
                            $('#project_new_name').val('');
                            renameChanging.hide();
                            renameComplete.show();
                            $('#rename-project-modal').on('hidden.bs.modal', function () {
                                location.reload();
                            });
                        },
                        error: function (data) {
                            renameChanging.hide();
                            renameError.show();
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
            });
        })(jQuery);
    </script>
@endsection
