<li class="my-1">
    @if($main_project->sub_projects->isEmpty())
        <button class="btn btn-outline-primary btn-list-project" aria-labelledby="project-{{$main_project->id}}" onclick="selectProject(this,{{$main_project->id}})">
            <span class="fas fa-folder mr-1"></span>{{$main_project->name}}</button>
    @else
        <button class="btn btn-outline-primary btn-list-project" aria-labelledby="project-{{$main_project->id}}" onclick="selectProject(this,{{$main_project->id}})">
            <span class="fas fa-folder-open mr-1"></span>{{$main_project->name}}</button>
        <ul class="ml-4 list-unstyled">
            @each('partials.project-tree', $main_project->sub_projects, 'main_project')
        </ul>
    @endif
</li>
