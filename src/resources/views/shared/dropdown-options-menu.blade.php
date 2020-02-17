<style>
    .input-color {
        background-color: #232323 !important;
        color: white !important;
    }

    .modal-close {
        color: white !important;
        background-color: transparent;
        border: none;
    }

    .modal-close:hover {
        color: rgba(255, 255, 255, 0.5) !important;
    }
</style>
<!--<a class="dropdown-item" href="{{route('system.delete-project',$item_id)}}">Delete</a>
        <a class="dropdown-item" href="#" name="rename" value="{{$item_id }}">Rename</a>
        <a class="dropdown-item" href="#">Something else here</a>-->
<div class="dropdown more-icon">
    <button class="btn btn-outline-light border-0 rounded-circle dropdown-toggle"
            type="button" id="{{$id}}" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"
            title="{{$title}}">
        <span class="sr-only">{{$title}}</span>
        <span class="fas fa-ellipsis-v" aria-hidden="true"></span>
    </button>
    {{-- TODO: Edit options --}}
    <div class="dropdown-menu" aria-labelledby="{{$id}}">
        <button class="dropdown-item btn btn-link" id="delete-project-btn" data-toggle="modal" data-target="delete-project-modal">Delete</button>
        <button class="dropdown-item btn btn-link" id="rename-project-btn" data-toggle="modal" data-target="rename-project-modal">Rename</button>
        <button class="dropdown-item btn btn-link" id="move-project-btn" data-toggle="modal" data-target="move-project-modal">Move</button>

    </div>
</div>

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
                    <input type="hidden" id="project_rename_id" name="project_rename_id" value="{{$item_id}}">
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
                    <input type="hidden" id="project_delete_id" name="project_delete_id" value="{{$item_id}}">
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

@section('scripts')
    <script>
        $(document).ready(function () {
            let renameComplete = $('#project-rename-complete');
            let renameChanging = $('#project-rename-updating');
            let renameError = $('#project-rename-error');
            let deleteComplete = $('#project-delete-complete');
            let deleteChanging = $('#project-delete-updating');
            let deleteError = $('#project-delete-error');


            $('#rename-project-btn').on('click', function () {
                $('#rename-project-modal').modal('show');
                $('#project_rename_id').val($(this).attr('value'));
                $('#project-rename-form').show();
                renameError.hide();
                renameChanging.hide();
                renameComplete.hide();
            });

            $('#delete-project-btn').on('click', function () {
                $('#delete-project-modal').modal('show');
                $('#project_delete_id').val($(this).attr('value'));
                $('#project-delete-form').show();
                renameError.hide();
                renameChanging.hide();
                renameComplete.hide();
            });

            $('#project-rename-form').on('submit', function (event) {
                event.preventDefault();
                $('#project-rename-form').hide();
                renameChanging.show();
                $.ajax({
                    url: this.action,
                    type: this.method,
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $('#project_new_name').val('');
                        renameChanging.hide();
                        renameComplete.show();
                        $('#rename-project-modal').on('hidden.bs.modal', function () {
                            location.reload();
                        });
                    },
                    error: function (data) {
                        renameChanging.hide();
                        renameError.show();
                        console.log(data);
                    }
                });
            });
            $('#project-delete-form').on('submit', function (event) {
                event.preventDefault();
                $('#project-delete-form').hide();
                deleteChanging.show();
                $.ajax({
                    url: this.action,
                    type: this.method,
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $('#project_delete').val('');
                        deleteChanging.hide();
                        deleteComplete.show();
                        $('#delete-project-modal').on('hidden.bs.modal', function () {
                            location.reload();
                        });
                    },
                    error: function (data) {
                        deleteChanging.hide();
                        deleteError.show();
                        console.log(data);
                    }
                });
            });
        });
    </script>
@endsection
