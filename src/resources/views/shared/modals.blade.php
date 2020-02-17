<!-- Modal rinomina progetto -->
<div class="modal fade" id="rename-project-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content el-16dp">
            <div class="modal-header">
                <h5 class="modal-title">Rename project</h5> <!-- TODO: Translate -->
                <button type="button" class="modal-close" data-dismiss="modal"
                        aria-label="{{trans('dashboard.close')}}">
                    <span class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('system.rename-project') }}"
                      id="project-rename-form">
                    @csrf
                    <input type="hidden" id="project_rename_id" name="project_rename_id" >
                    <label for="project_new_name">{{trans('dashboard.project_name')}}</label>
                    <input type="text" class="form-control input-color" id="project_new_name"
                           name="project_name" placeholder="{{trans('dashboard.name')}}" required>

                    <div class="modal-footer mt-3">
                        <button type="button" id="close-rename-project" class="btn btn-secondary"
                                data-dismiss="modal">
                            {{trans('dashboard.close')}}
                        </button>
                        <input type="submit" value="{{ trans('dashboard.submit') }}" class="btn btn-primary"
                               style="color: white;">
                    </div>
                </form>
                <div id="project-rename-complete" class="alert alert-success" role="alert" style="display:none;">
                    {{ trans('dashboard.success') }}
                </div>
                <div id="project-rename-updating" class="alert alert-warning" role="alert" style="display:none;">
                    {{ trans('dashboard.changing') }}
                </div>
                <div id="project-rename-error" class="alert alert-danger" role="alert" style="display:none;">
                    {{ trans('dashboard.error') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal elimina progetto -->
<div class="modal fade" id="delete-project-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content el-16dp">
            <div class="modal-header">
                <h5 class="modal-title">Delete project</h5> <!-- TODO: Translate -->
                <button type="button" class="modal-close" data-dismiss="modal"
                        aria-label="{{trans('dashboard.close')}}">
                    <span class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('system.delete-project') }}"
                      id="project-delete-form">
                    @csrf
                    <input type="hidden" id="project_delete_id" name="project_delete_id">
                    <p>Sei sicuro di voler eliminare il progetto?</p><!-- TODO: Translate -->
                    <div class="modal-footer mt-3">
                        <button type="button" id="close-delete-project" class="btn btn-secondary"
                                data-dismiss="modal">
                            No
                        </button>
                        <button type="button" id="accept-delete-project" class="btn btn-primary"
                                data-dismiss="modal">
                            Si
                        </button>
                    </div>
                </form>
                <div id="project-delete-complete" class="alert alert-success" role="alert" style="display:none;">
                    {{ trans('dashboard.success') }}
                </div>
                <div id="project-delete-updating" class="alert alert-warning" role="alert" style="display:none;">
                    {{ trans('dashboard.changing') }}
                </div>
                <div id="project-delete-error" class="alert alert-danger" role="alert" style="display:none;">
                    {{ trans('dashboard.error') }}
                </div>
            </div>
        </div>
    </div>
</div>
