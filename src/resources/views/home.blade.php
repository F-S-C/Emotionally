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
                            @include('shared.dropdown-options-menu', ['id'=>'more-project-'.$project->id,'title'=>trans('dashboard.more_options')])
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
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

            $('.clickable').click(function (event) {
                // prevent execution from bubbling if a link or a button were clicked
                if (event.target.tagName.toLowerCase() !== 'a' && event.target.tagName.toLowerCase() !== 'button') {
                    window.location = $(this).data('href');
                }
            })
        });
    </script>
@endsection
