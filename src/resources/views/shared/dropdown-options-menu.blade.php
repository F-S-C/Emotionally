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
        <a class="dropdown-item" href="{{route('system.delete-project',$item_id)}}">Delete</a>
        <a class="dropdown-item" href="#" name="rename" value="{{ $item_id }}">Rename</a>
        <a class="dropdown-item" href="#">Something else here</a>
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
                    <input type="hidden" id="project_rename_id" name="project_rename_id">
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

@section('scripts')
    <script>
        $(document).ready(function () {
            let renameComplete = $('#project-rename-complete');
            let renameChanging = $('#project-rename-updating');
            let renameError = $('#project-rename-error');
            let form = $('#project-rename-form');
            $('[name=rename]').on('click', function () {
                $('#rename-project-modal').modal('show');
                $('#project_rename_id').val($(this).attr('value'));
                form.show();
                renameError.hide();
                renameChanging.hide();
                renameComplete.hide();
            });

            $('#project-rename-form').on('submit', function (event) {
                event.preventDefault();
                form.hide();
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
        });
    </script>
@endsection
