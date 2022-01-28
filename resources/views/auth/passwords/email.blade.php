@extends('layouts.app')
@section('title', trans('app.reset_password'). ' -')
@section('content')
    <div class="container">
        <div class="form_container">
            <div class="form_title">{{ trans('app.reset_password') }}</div>
            <div class="form_subtitle">{{ trans('app.reset_password_page_description') }}</div>
            <div>
                @if (session('status'))
                    <div class="success">
                        <i class="fa fa-check"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form_block">
                        <label for="email">{{ trans('app.user_email') }}</label>

                        <input id="email" type="email"
                               class="form-control @error('email') input-error @enderror" name="email"
                               value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="john.bourne@email.com">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="button button_primary">
                            {{ trans('app.reset_password_button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
