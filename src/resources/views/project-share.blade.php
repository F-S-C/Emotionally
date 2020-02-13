@extends('layouts.system')

@section('title', $project->name . ': Share & Permissions')

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
    <div class="table-responsive mt-3">
        <table id="project-table" class="display w-100 table table-striped table-borderless">
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
                        <td class="align-middle">{{$user->name}} {{$user->surname}}</td>
                        <td class="align-middle">{{$user->email}}</td>
                        <td class="text-center align-middle">@include('partials.yes-no', ['ans'=> $user->pivot->read])</td>
                        <td class="text-center align-middle">@include('partials.yes-no', ['ans'=> $user->pivot->modify])</td>
                        <td class="text-center align-middle">@include('partials.yes-no', ['ans'=> $user->pivot->add])</td>
                        <td class="text-center align-middle">@include('partials.yes-no', ['ans'=> $user->pivot->remove])</td>
                        <td class="text-center align-middle">
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
@endsection
