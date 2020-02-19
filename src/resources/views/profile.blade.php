@extends('layouts.system')

@section('title', trans('dashboard.profile'))

@section('inner-content')
    <div class="row">
        <div class="col-5">
            <div class="modal-body">
                <div id="profile-changed" class="alert alert-success" role="alert" aria-atomic="true"
                     style="display:none;">
                    {{trans('dashboard.profile-changed')}}
                </div>
                <div id="profile-not-changed" class="alert alert-danger" role="alert" aria-atomic="true"
                     style="display:none;">
                    {{trans('dashboard.err-changing-profile')}}
                </div>
                <div id="profile-changing" class="alert alert-warning" role="alert" aria-atomic="true"
                     style="display:none;">
                    {{trans('dashboard.profile-changing')}}
                </div>
                <form method="POST" action="{{ route('system.edit-profile') }}"
                      id="edit-profile-form" novalidate>
                    @csrf
                    <label for="name">{{trans('dashboard.name')}}</label>
                    <input type="text" class="form-control input-color" id="name"
                           name="name" value="{{Auth::user()->name}}" placeholder="">

                    <label class="mt-2" for="surname">{{trans('dashboard.surname')}}</label>
                    <input type="text" class="form-control input-color" id="surname"
                           name="surname" value="{{Auth::user()->surname}}" placeholder="">
                    <label class="mt-2" for="password">{{trans('dashboard.newpassword')}}</label>
                    <input type="password" class="form-control input-color" id="password"
                           name="password" value="" placeholder="{{trans('dashboard.newpassword')}}" required>
                    <label class="mt-2" for="confirm-password">{{trans('dashboard.confirm-password')}}</label>
                    <input type="password" class="form-control input-color" id="confirm-password"
                           name="confirm_password" value="" placeholder="{{trans('dashboard.newpassword')}}" required>
                    <div class="invalid-feedback" id="wrong-new-password">Le password non coincidono.</div>
                    <div class="row mt-4">
                        <div class="col-7">
                            <label class="mt-2" for="old-password">{{trans('dashboard.newpassword')}}</label>
                            <input type="password" class="form-control input-color" id="old-password"
                                   name="old_password" value="" placeholder="{{trans('dashboard.old-password')}}"
                                   required>
                            <div class="invalid-feedback" id="wrong-old-password">La vecchia password è errata.</div>
                        </div>
                        <div class="col-5 mt-3">
                            <div class="mt-4 text-right">
                                <button type="reset" id="close-edit-profile" class="btn btn-secondary"
                                        style="width:80px;color: white;">
                                    {{trans('dashboard.reset')}}
                                </button>
                                <button type="submit" id="submit-edit-profile" class="btn btn-primary"
                                        style="width:80px;color: white;"
                                        value="Invia">{{trans('dashboard.edit')}}</button>
                            </div>
                        </div>
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

                        (function () {
                            'use strict';
                            window.addEventListener('load', function () {
                                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                let forms = document.getElementsByClassName('needs-validation');
                                // Loop over them and prevent submission
                                Array.prototype.filter.call(forms, function (form) {
                                    form.addEventListener('submit', function (event) {
                                        if (form.checkValidity() === false) {
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }
                                        form.classList.add('was-validated');
                                    }, false);
                                });
                            }, false);
                        })();

                        $('#password, #confirm-password').on('change', function () {
                            if (checkPassword()) {
                                $('#wrong-new-password').hide();
                                $('#submit-edit-profile').prop('disabled', false);
                            } else {
                                $('#wrong-new-password').show();
                                $('#submit-edit-profile').prop('disabled', true);
                            }

                        });

                        function checkPassword() {
                            let newPass = $('#password').val();
                            let confirmPass = $('#confirm-password').val();

                            return newPass === confirmPass;
                        }

                        $('#edit-profile-form').on('submit', function (event) {
                            if (checkPassword()) {
                                event.preventDefault();
                                let alertComplete = $('#profile-changed');
                                let alertNotComplete = $('#profile-not-changed');
                                let creating = $('#profile-changing');
                                let form = $('#edit-profile-form');
                                form.hide();
                                alertComplete.hide();
                                alertNotComplete.hide();
                                creating.show();
                                $.post('{{route('system.user.password.check')}}', {
                                    '_token': '{{csrf_token()}}',
                                    'old_password': $('#old-password').val()
                                })
                                    .done(function (data) {
                                        data = JSON.parse(data);
                                        if (data['done']) {
                                            let formData = new FormData($('#edit-profile-form')[0]);
                                            $.ajax({
                                                url: $('#edit-profile-form')[0].action,
                                                type: $('#edit-profile-form')[0].method,
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                cache: false,
                                                success: function (data) {
                                                    creating.hide();
                                                    alertComplete.show();
                                                    $('#user-profile-name-surname').text($('#name').val() + ' ' + $('#surname').val());
                                                    setTimeout(() => {
                                                        $('#password').val('');
                                                        $('#confirm-password').val('');
                                                        $('#old-password').val('');
                                                        form.show();
                                                    })
                                                },
                                                error: function (data) {
                                                    // TODO: ERRORI NELLA CONNESIONE AL SERVER
                                                    creating.hide();
                                                    alertNotComplete.show();
                                                    alertNotComplete.show();
                                                    console.log(data);
                                                    form.show();
                                                }
                                            });
                                        } else {
                                            if (!data.hasOwnProperty('errors')) {
                                                // TODO: Password errata
                                                console.log('FOLD PASSWORD')
                                            } else {
                                                // TODO: ERRORI NELLA RICHIESTA
                                                console.log(data['errors']);
                                            }
                                            creating.hide();
                                            alertNotComplete.show();
                                            console.log(data);
                                            form.show();
                                        }
                                    })
                                    .fail(function (data) {
                                        // TODO: ERRORI NELLA CONNESIONE AL SERVER
                                        creating.hide();
                                        alertNotComplete.show();
                                        console.log(data);
                                        form.show();
                                    });

                            } else {
                                $('.invalid-feedback').show();
                            }
                        });
                    });
                })(jQuery);
            </script>
@endsection
