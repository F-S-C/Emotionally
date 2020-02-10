@extends('auth.style')

@section('title','Log-in')

@section('head')
    @parent
    <style>
        .input-color {
            background-color: #232323!important;
            color: white!important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active  {
            -webkit-box-shadow: 0 0 0px 1000px #232323 inset;
            -webkit-text-fill-color: white;
            caret-color: white;
        }
    </style>
@endsection

@section('form-name','Log-in')

@section('form')
    <form>
        <div class="form-group">
            <label for="email">{{ __('E-Mail Address') }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text input-color" id="email-icon"><i class="fas fa-envelope" style="padding: 0 1px;"></i></span>
                </div>
                <input type="text" class="form-control input-color" id="email" aria-describedby="email-icon" required>
            </div>
        </div>
        <div id="second">
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-color" id="password-icon"><i class="fas fa-lock" style="padding: 0 2px;"></i></span>
                    </div>
                    <input type="password" class="form-control input-color" id="password" aria-describedby="password-icon" autocomplete="on" required>
                </div>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember-me">
                <label class="form-check-label" for="remember-me">@lang('auth.remember')</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">@lang('auth.login')</button>
        </div>
    </form>
    <p class="text-center mt-3"><a id="alex" href="#">@lang('auth.forgot-password')</a></p>
@endsection

@section('script')
    @parent
    <script>
        //Script qui
    </script>
@endsection
