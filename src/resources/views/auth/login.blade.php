@extends('auth.style')

@section('title','Login')

@section('head')
    @parent
    <style>
        .input-color {
            background-color: #232323 !important;
            color: white !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #232323 inset;
            -webkit-text-fill-color: white;
            caret-color: white;
        }

        .m-fadeOut {
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s linear 300ms, opacity 300ms;
            display: none;
        }

        .m-fadeIn {
            visibility: visible;
            opacity: 1;
            transition: visibility 0s linear 0s, opacity 300ms;
            display: block;
        }
    </style>
@endsection

@section('form-name')
    @lang('auth.login')
@endsection

@section('form')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        @error('email')<p class="text-center text-danger">@lang('auth.bad-login')</p>@enderror
        <div class="form-group">
            <label for="email">@lang('auth.email-address')</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text input-color @error('email') border border-danger @enderror"
                          id="email-icon"><i class="fas fa-envelope" style="padding: 0 1px;"></i></span>
                </div>
                <input type="text" class="form-control input-color @error('email') border border-danger @enderror"
                       id="email" name="email" aria-describedby="email-icon" autocomplete="email"
                       value="{{ old('email') }}" placeholder="email@email.com" required>
                <div class="input-group-append">
                    <span class="input-group-text input-color @error('email') border border-danger @enderror"><a id="go"
                                                                                                                 href="#"><i
                                class="fas fa-arrow-right" style="padding: 0 1px;"></i></a></span>
                </div>
            </div>
        </div>
        <div id="second-part" class="m-fadeOut">
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-color @error('email') border border-danger @enderror"
                              id="password-icon"><i class="fas fa-lock" style="padding: 0 2px;"></i></span>
                    </div>
                    <input type="password"
                           class="form-control input-color @error('email') border border-danger @enderror" id="password"
                           name="password" aria-describedby="password-icon" autocomplete="current-password"
                           placeholder="••••••••" required>
                </div>
            </div>
            <div class="custom-control custom-switch pb-3">
                <input type="checkbox" class="custom-control-input" name="remember"
                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">@lang('auth.remember')</label>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="color: white;">@lang('auth.login')</button>
        </div>
    </form>
    <p id="forgot" class="text-center mt-3 m-fadeOut"><a
            href="{{ route('password.request') }}">@lang('auth.forgot-password')</a></p>
    <p id="signup" class="text-center mt-3 m-fadeIn">@lang('auth.new-user') <a
            href="{{ route('register') }}">@lang('auth.sign-up')</a></p>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            @if($errors->has('email'))
            $("#second-part").removeClass('m-fadeOut').addClass('m-fadeIn');
            $("#forgot").removeClass('m-fadeOut').addClass('m-fadeIn');
            $("#signup").removeClass('m-fadeIn').addClass('m-fadeOut');
            $("#go").removeAttr('href').attr('style', 'color:grey;');
            @else
            $("#go").click(function () {
                $("#second-part").removeClass('m-fadeOut').addClass('m-fadeIn');
                $("#forgot").removeClass('m-fadeOut').addClass('m-fadeIn');
                $("#signup").removeClass('m-fadeIn').addClass('m-fadeOut');
                $("#go").removeAttr('href').attr('style', 'color:grey;');
            });
            $(document).keypress(function (e) {
                var go = $("#go");
                var attr = go.attr('href');
                if (e.which === 13) {
                    if (typeof attr !== typeof undefined && attr !== false) {
                        go.click();
                    }
                }
            });
            @endif
        });
    </script>
@endsection
