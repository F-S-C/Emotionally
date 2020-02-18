@extends('layouts.system')

@section('title', trans('dashboard.profile'))

@section('breadcrumbs')
    <!--<li class="breadcrumb-item" aria-current="page"><span class="fas fa-home" aria-hidden="true"></span>
        @lang('dashboard.home')
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        @lang('dashboard.dashboard')
    </li>-->
@endsection

@section('inner-content')
<div class="row">
    <div class="col-5">
        <form method="POST" action="{{ route('system.edit-profile') }}"
              id="edit-profile-form">
            @csrf
        <label for="name">{{trans('dashboard.name')}}</label>
        <input type="text" class="form-control input-color" id="name"
               name="name" value="{{Auth::user()->name}}" placeholder="">

        <label class="mt-2"  for="surname">{{trans('dashboard.surname')}}</label>
        <input type="text" class="form-control input-color" id="surname"
               name="surname" value="{{Auth::user()->surname}}" placeholder="">
        <label class="mt-2"  for="password">Nuova password</label>
        <input type="password" class="form-control input-color" id="password"
               name="password" value="" placeholder="Nuova password">
            <div class="mt-4 text-right">
            <button type="reset" id="close-edit-profile" class="btn btn-secondary">
                Annulla
            </button>
            <button type="submit" id="submit-edit-profile" class="btn btn-primary"
                    style="color: white;" value="Invia" >Modifica</button>
            </div>
        </form>


    </div>


    <div class="col-6">

    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script>(function ($) {
            $(document).ready(function () {
                let table = $('#project-table').DataTable({
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

                $('#search-bar').on('keydown click change paste mouseup', function () {
                    table.search($('#search-bar').val()).draw();
                });

                $('.clickable').click(function (event) {
                    // prevent execution from bubbling if a link or a button were clicked
                    if (event.target.tagName.toLowerCase() !== 'a' && event.target.tagName.toLowerCase() !== 'button') {
                        window.location = $(this).data('href');
                    }
                })
            });
        })(jQuery);
    </script>
@endsection
