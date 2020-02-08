@extends('layouts.sidebar')

@section('title', 'Emotionally')

@section('content')
    @parent

    <section class="container-fluid" id="content">
        <header>
            <h1 class="d-block d-md-inline">Home</h1>
            <nav id="breadcrumbs" class="breadcrumb-container" aria-label="breadcrumbs">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item" aria-current="page"><span class="fas fa-home" aria-hidden="true"></span>
                        Home
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </header>
        <div class="table-responsive">
            <table id="example" class="display w-100 table table-striped table-borderless">
                <thead class="text-uppercase">
                <tr>
                    <th>Name</th>
                    <th class="text-center">Created at</th>
                    <th class="text-center">Modified at</th>
                    <th class="text-center">Videos</th>
                    <th class="text-center">Subprojects</th>
                    <th class="text-center">Average emotion</th>
                    <th><span class="sr-only">Go to report</span></th>
                    <th><span class="sr-only">More</span></th>
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
                               aria-label="Go to report page of project {{ $project->name }}">Report</a>
                        </td>
                        <td>
                            <button class="btn btn-outline-light border-0 rounded-circle">
                                <span class="fas fa-ellipsis-v" aria-hidden="true" title="More options"></span>
                                <span class="sr-only">More options</span>
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
            let table = $('#example').DataTable({
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
            $('#mySearchText').on( 'keyup click enter', function () {
                table.search($('#mySearchText').val()).draw();
            } );
        });
    </script>
@endsection
