@extends('auth.style')

@section('title','Reset')

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
    </style>
@endsection

@section('form-name')
    @lang('auth.reset-password')
@endsection

@section('form')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form @if(session('status')) method="GET" action="{{ route('landing') }}" @else method="POST" action="{{ route('password.email') }}" @endif>
        @csrf
        <div class="form-group">
            <label for="email">@lang('auth.email-address')</label>
            <input type="email" class="form-control input-color @error('email') border border-danger @enderror"
                   id="email" name="email" aria-describedby="email-icon" autocomplete="email"
                   value="<?php if (isset($_GET['email'])) echo $_GET['email']; ?>" placeholder="email@email.com"
                   required @if (session('status')) disabled @endif>
            @error('email')<p class="text-center text-danger">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary w-100" style="color: white;">@if(session('status')) @lang('auth.go-to-landing') @else @lang('auth.send-reset-link') @endif</button>
    </form>
    @if(session('status'))
        <div class="container py-1">&nbsp;</div>
    @else
        <p id="login" class="text-center mt-3">@lang('auth.change-mind') <a
                href="{{ route('login') }}">@lang('auth.login')</a></p>
    @endif
@endsection

@section('scripts')
    @parent
@endsection
