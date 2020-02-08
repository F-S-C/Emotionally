@extends('layouts.sidebar')

@section('title', 'Emotionally')

@section('content')
    @parent

    <section class="container" id="content">
        <header>
            <h1 class="d-block d-md-inline">Home</h1>
            <nav id="breadcrumbs" class="breadcrumb-container" aria-label="breadcrumbs">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item" aria-current="page"><span class="fas fa-home" aria-hidden="true"></span> Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </header>
        <div class="table-responsive">
            <table id="table_id" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created at</th>
                    <th>Modified at</th>
                    <th>Videos</th>
                    <th>Subprojects</th>
                    <th>Average emotion</th>
                    <th class="sr-only">Go to report</th>
                    <th class="sr-only">More</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>

                        <td>{{$project['id']}}</td>
                        <td>{{$project['name']}}</td>
                        <td>{{$project['created_at']}}</td>
                        <td>{{$project['updated_at']}}</td>
                        <td>{{$project['number_videos']??'X'}}</td>
                        <td>{{$project['number_subprojects']??'X'}}</td>
                        <td>{{$project['emotion'] ??'=)'}}</td>
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
            $('#table_id').DataTable();
        });
    </script>
@endsection
