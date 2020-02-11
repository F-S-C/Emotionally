@extends('auth.style')

@section('title','Sign Up')

@section('form-name')
    @lang('auth.sign-up')
@endsection

@section('form')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name">@lang('auth.name')</label>
            <input type="text" class="form-control input-color @error('name') border border-danger @enderror"
                   id="name" name="name" autocomplete="name"
                   value="{{ old('name') }}" placeholder="Name" required>
            @error('name')<p class="text-center text-danger">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label for="surname">@lang('auth.surname')</label>
            <input type="text" class="form-control input-color @error('surname') border border-danger @enderror"
                   id="surname" name="surname" autocomplete="surname"
                   value="{{ old('surname') }}" placeholder="Surname" required>
            @error('surname')<p class="text-center text-danger">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label for="email">@lang('auth.email-address')</label>
            <input type="email" class="form-control input-color @error('email') border border-danger @enderror"
                   id="email" name="email" aria-describedby="email-icon" autocomplete="email"
                   value="{{ old('email') }}" placeholder="email@email.com" required>
            @error('email')<p class="text-center text-danger">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password"
                   class="form-control input-color @error('password') border border-danger @enderror" id="password"
                   name="password" autocomplete="new-password"
                   placeholder="••••••••" required>
        </div>
        <div class="form-group">
            <label for="password-confirm">@lang('auth.password-confirm')</label>
            <input type="password"
                   class="form-control input-color @error('password') border border-danger @enderror"
                   id="password-confirm"
                   name="password_confirmation" autocomplete="new-password"
                   placeholder="••••••••" required>
            @error('password')<p class="text-center text-danger">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary w-100" style="color: white;">@lang('auth.sign-up')</button>
    </form>
    <p id="login" class="text-center mt-3">@lang('auth.ext-user') <a
            href="{{ route('login') }}">@lang('auth.login')</a></p>
@endsection

@section('scripts')
    @parent
@endsection
