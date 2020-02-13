@extends('layouts.system')

@section('title', $project->name . ': Share & Permissions')

@section('head')
    <style>
        .input-color {
            background-color: #232323 !important;
            color: white !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #232323 inset;
            -webkit-text-fill-color: white;
            caret-color: white;
        }
    </style>
@endsection

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
        <span class="fas fa-share-alt" aria-hidden="true"></span>
        Share &amp; Permissions
    </li>
@endsection

@section('inner-content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <details class="card el-1dp p-3 rounded">
        <summary>Share the project</summary>
        <div class="card-body">
            <p>Fill the form to share your project.</p>
            <form id="share-form" method="post"
                  action="{{route('system.permissions.add', ['project_id'=>$project->id])}}">
                @csrf
                @method('PUT')
                <div class="form-group mr-sm-3">
                    <label for="email-input">Email</label>
                    <input class="form-control input-color @error('email') border border-danger @enderror" name="email"
                           id="email-input" type="email"
                           placeholder="email@provider.com" required>
                </div>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="read-input" value="true" checked disabled>
                        <label class="form-check-label" for="read-input">Can read?</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="modify-input" value="true" name="modify">
                        <label class="form-check-label" for="modify-input">Can edit?</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="add-input" value="true" name="add">
                        <label class="form-check-label" for="add-input">Can add?</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="remove-input" value="true" name="remove">
                        <label class="form-check-label" for="remove-input">Can remove?</label>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" id="add-new-permission">
                    <span class="fas fa-plus-circle mr-1" aria-hidden="true"></span>
                    Add
                </button>
            </form>
        </div>
    </details>
    <div class="table-responsive mt-3">
        <table id="permissions-table" class="display w-100 table table-striped table-borderless">
            <caption class="sr-only">@lang('dashboard.your_projects')</caption>
            <thead class="text-uppercase">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">E-mail</th>
                <th scope="col" class="text-center">Can read?</th>
                <th scope="col" class="text-center">Can edit?</th>
                <th scope="col" class="text-center">Can add?</th>
                <th scope="col" class="text-center">Can remove?</th>
                <th scope="col"><span class="sr-only">Delete</span></th>
            </tr>
            </thead>
            <tbody>
            @if(isset($project->users))
                @foreach($project->users as $user)
                    <tr data-href="{{route('system.project-details', $user->id)}}">
                        <td>{{$user->name}} {{$user->surname}}</td>
                        <td>{{$user->email}}</td>
                        <td class="text-center">@include('partials.yes-no', ['ans'=> $user->pivot->read])</td>
                        <td class="text-center">@include('partials.yes-no', ['ans'=> $user->pivot->modify])</td>
                        <td class="text-center">@include('partials.yes-no', ['ans'=> $user->pivot->add])</td>
                        <td class="text-center">@include('partials.yes-no', ['ans'=> $user->pivot->remove])</td>
                        <td class="text-center">
                            <form
                                action="{{route('system.permissions.delete', ['project_id'=>$project->id, 'user_id'=>$user->id])}}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-md-text-danger" type="submit"
                                        onclick="return confirm('Do you really want to revoke all permissions for {{ $user->email  }}?');">
                                    Delete
                                </button>
                            </form>
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
        (function ($) {
            $(document).ready(function () {
                let table = $('#permissions-table').DataTable({
                    "order": [[0, "asc"]],
                    "paging": false,
                    "info": false,
                    "columnDefs": [
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

                $('#share-form input:checkbox').change(function () {
                    $('#add-new-permission').prop('disabled', $('#share-form input:checkbox:checked').length === 0);
                    let canReadInput = $('#read-input');
                });

            });
        })(jQuery);
    </script>
@endsection
