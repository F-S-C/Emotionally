<div class="col mb-4">
    <div class="project-detail-card card h-100 text-white square"
         data-href="{{route('system.project-details', $project->id)}}">
        <div class="folder-background card-img-top"></div>
        <div class="card-img-overlay project-detail-card-title" id="card-title-project-{{$project->id}}">
            <span class="sr-only">@lang('project-details.project'): </span>
            <h5 class="card-title">{{$project->name}}</h5>
        </div>
        <a class="project-card-link" href="{{route('system.project-details', $project->id)}}"
           aria-labelledby="card-title-project-{{$project->id}}"></a>
        <div class="card-img-overlay project-detail-card-options">
            <div class="dropdown">
                <button class="btn btn-outline-light border-0 rounded-circle dropdown-toggle"
                        type="button" id="more-project-{{$project->id}}" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"
                        title="@lang('project-details.more_options_project', ['name'=>$project->name])">
                    <span class="sr-only">@lang('project-details.more_options_project', ['name'=>$project->name])</span>
                    <span class="fas fa-ellipsis-v" aria-hidden="true"></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="more-project-{{$project->id}}">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
    </div>
</div>
