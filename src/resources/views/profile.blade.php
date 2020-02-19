@extends('layouts.system')

@section('title', trans('dashboard.profile'))

@section('inner-content')
<div class="row">
    <div class="col-5">
        <div class="modal-body">
            <div id="password-changed" class="alert alert-success" role="alert" aria-atomic="true"
                 style="display:none;">
                {{trans('dashboard.password-changed')}}
            </div>
            <div id="password-not-changed" class="alert alert-danger" role="alert" aria-atomic="true"
                 style="display:none;">
                {{trans('dashboard.err-changing-password')}}
            </div>
            <div id="password-changing" class="alert alert-warning" role="alert" aria-atomic="true"
                 style="display:none;">
                {{trans('dashboard.password-changing')}}
            </div>
        <form method="POST" action="{{ route('system.edit-profile') }}"
              id="edit-profile-form" novalidate>
            @csrf
        <label for="name">{{trans('dashboard.name')}}</label>
        <input type="text" class="form-control input-color" id="name"
               name="name" value="{{Auth::user()->name}}" placeholder="">

        <label class="mt-2"  for="surname">{{trans('dashboard.surname')}}</label>
        <input type="text" class="form-control input-color" id="surname"
               name="surname" value="{{Auth::user()->surname}}" placeholder="">
        <label class="mt-2"  for="password">{{trans('dashboard.newpassword')}}</label>
        <input type="password" class="form-control input-color" id="password"
               name="password" value="" placeholder="{{trans('dashboard.newpassword')}}" required>
        <label class="mt-2"  for="confirm-password">{{trans('dashboard.confirm-password')}}</label>
        <input type="password" class="form-control input-color" id="confirm-password"
                   name="password" value="" placeholder="{{trans('dashboard.newpassword')}}" required>
            <div class="invalid-feedback">Le password non coincidono.</div>
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

                (function() {
                    'use strict';
                    window.addEventListener('load', function() {
                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        var forms = document.getElementsByClassName('needs-validation');
                        // Loop over them and prevent submission
                        var validation = Array.prototype.filter.call(forms, function(form) {
                            form.addEventListener('submit', function(event) {
                                if (form.checkValidity() === false) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }
                                form.classList.add('was-validated');
                            }, false);
                        });
                    }, false);
                })();

                    $('#password').on('change', function () {
                        if (checkPassword())
                        {
                            $('.invalid-feedback').hide();
                            $('#submit-edit-profile').prop('disabled',false);
                        }
                        else
                        {
                            $('.invalid-feedback').show();
                            $('#submit-edit-profile').prop('disabled',true);
                        }

                    });

                $('#confirm-password').on('change', function () {
                    if (checkPassword())
                    {
                        $('.invalid-feedback').hide();
                        $('#submit-edit-profile').prop('disabled',false);
                    }
                    else
                    {
                        $('.invalid-feedback').show();
                        $('#submit-edit-profile').prop('disabled',true);
                    }
                });


                function checkPassword() {
                  let $newPass =  $('#password').val();
                  let $confirmPass = $('#confirm-password').val();

                  return ($newPass == $confirmPass);
                }

                $('.clickable').click(function (event) {
                    // prevent execution from bubbling if a link or a button were clicked
                    if (event.target.tagName.toLowerCase() !== 'a' && event.target.tagName.toLowerCase() !== 'button') {
                        window.location = $(this).data('href');
                    }
                });

                $('#edit-profile-form').on('submit', function (event) {
                    if(checkPassword())
                    {
                        event.preventDefault();
                        let alertComplete = $('#password-changed');
                        let alertNotComplete = $('#password-not-changed');
                        let creating = $('#password-changing');
                        let form = $('#edit-profile-form');
                        form.hide();
                        alertComplete.hide();
                        alertNotComplete.hide();
                        creating.show();
                        $.ajax({
                            url: this.action,
                            type: this.method,
                            data: new FormData(this),
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function (data) {
                                creating.hide();
                                alertComplete.show();
                                $('#password').val('');
                                $('#confirm-password').val('');
                                $('#create-project-modal').on('hidden.bs.modal', function () {
                                    location.reload();
                                });
                                form.show();
                            },
                            error: function (data) {
                                creating.hide();
                                alertNotComplete.show();
                                console.log(data);
                                form.show();
                            }
                        });
                    }
                    else
                    {
                        $('.invalid-feedback').show();
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
