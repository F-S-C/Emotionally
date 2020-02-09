@extends('layouts.sidebar')

@section('title', 'Emotionally')

@section('content')
    @parent

    <section class="container-fluid" id="content">
        <header>
            <h1 class="d-block d-md-inline">@lang('dashboard.home')</h1>
            <nav id="breadcrumbs" class="breadcrumb-container" aria-label="breadcrumbs">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item" aria-current="page"><span class="fas fa-home" aria-hidden="true"></span>
                        @lang('dashboard.home')
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @lang('dashboard.dashboard')
                    </li>
                </ol>
            </nav>
        </header>
        <div class="table-responsive mt-3">
            <table id="project-table" class="display w-100 table table-striped table-borderless"
                   aria-label="@lang('dashboard.your_projects')">
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
                @foreach($projects as $project)
                    <tr>
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
                            <button class="btn btn-outline-light border-0 rounded-circle">
                                <span class="fas fa-ellipsis-v" aria-hidden="true" title="@lang('dashboard.more_options')"></span>
                                <span class="sr-only">@lang('dashboard.more_options')</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </section>
@endsection

@section('scripts')
    @parent
    <script>
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
            $('#search-bar').on('keydown click', function () {
                table.search($('#search-bar').val()).draw();
            });
        });
    </script>
@endsection
