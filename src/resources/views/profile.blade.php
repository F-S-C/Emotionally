@extends('layouts.system')

@section('title', trans('dashboard.profile'))

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
        <label class="mt-2"  for="password">{{trans('dashboard.newpassword')}}</label>
        <input type="password" class="form-control input-color" id="password"
               name="password" value="" placeholder="{{trans('dashboard.newpassword')}}">
            <div class="mt-4 text-right">
            <button type="reset" id="close-edit-profile" class="btn btn-secondary"  style="width:80px;color: white;">
                {{trans('dashboard.reset')}}
            </button>
            <button type="submit" id="submit-edit-profile" class="btn btn-primary"
                    style="width:80px;color: white;" value="Invia" >{{trans('dashboard.edit')}}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    @parent
        <script>
        (function ($) {
            $(document).ready(function () {
                $('#side-home-btn').removeClass('active');
                $('#side-profile-btn').addClass('active');

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
