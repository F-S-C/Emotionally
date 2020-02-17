<li class="nav-item">
    @if($main_project->sub_projects->isEmpty())
        <button class="btn btn-primary" onclick="document.getElementById('project_selected_id').setAttribute('value', {{$main_project->id}}); if(this.hasClass('disabled'))this.addClass('disabled'); else this.removeClass('disabled');">
            <span aria-hidden="true" class="fas fa-folder mr-1"></span>
            {{$main_project->name}}
        </button>
    @else
        <div class="collapse-button-container">
            <button class="btn btn-primary ml-3" onclick="document.getElementById('project_selected_id').setAttribute('value', {{$main_project->id}});">
                <span aria-hidden="true" class="project-sidebar-icon mr-1"></span>
                {{$main_project->name}}
            </button>
        </div>
        <ul class="collapse el-3dp nav flex-column flex-nowrap" id="sidebar-project-tree-{{$main_project->id}}">
            @each('partials.project-tree-view', $main_project->sub_projects, 'main_project')
        </ul>
    @endif
</li>
