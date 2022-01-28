@extends('layouts.app')
@section('title', trans('app.account'). ' -')
@section('content')
    <div class="container">
        <h1 class="section_title">{{ trans('app.account') }}</h1>
        <p class="section_subtitle">{{ trans('app.account_description') }}</p>

        <div class="form_container">
            <form action="{{ route('account.update') }}" method="post">
                @csrf
                @method('POST')
                <div class="form_block">
                    <label for="name">{{ __('app.user_name') }}</label>
                    <input id="name" type="text" class="@error('name') input-error @enderror" name="name"
                           value="{{ request()->user()->name,  old('name')  }}" autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form_block">
                    <label for="username">{{ __('app.user_username') }}</label>
                    <input id="username" type="text" class="@error('username') input-error @enderror" name="username"
                           value="{{ request()->user()->username,  old('username')  }}" autocomplete="username" autofocus>
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form_block">
                    <label for="email">{{ __('app.user_email') }}</label>
                    <input id="email" type="email" class="@error('email') input-error @enderror" name="email"
                           value="{{ request()->user()->email,  old('email')  }}" autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form_block">
                    <label for="password">{{ __('app.user_password') }}</label>
                    <input id="password" type="password" class="@error('password') input-error @enderror" name="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form_block">
                    <label for="password_confirmation">{{ __('app.user_password_confirmation') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation">
                </div>
                    <button class="button button_primary" type="submit" name="{{ trans('app.save_account_changes') }}">
                        {{ trans('app.save_account_changes') }}
                    </button>
                </div>
            </form>
        </div>
@endsection
