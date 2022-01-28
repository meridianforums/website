@extends('layouts.app')
@section('title', trans('app.sign_in'). ' -')
@section('content')
    <div class="container">
        <div class="form_container">
            <div class="form_title">{{ trans('app.sign_in') }}</div>
            <div class="form_subtitle">{{ trans('app.sign_in_page_description') }}</div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form_block">
                    <label for="email">{{ trans('app.user_email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') input-error @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="admin@forums.com">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form_block">
                    <label for="password">{{ trans('app.user_password') }}</label>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="password123"
                           autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form_block">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ trans('app.remember_me') }}
                        </label>
                    </div>
                </div>
                <div>
                    <button type="submit" class="button button_primary">
                        {{ trans('app.sign_in_button') }}
                    </button>
                    @if (Route::has('password.request'))
                        <a class="button button_secondary" href="{{ route('password.request') }}">
                            {{ trans('app.reset_password_button') }}
                        </a>
                    @endif
                </div>
        </div>
        </form>
    </div>
    </div>
@endsection
