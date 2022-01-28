@extends('layouts.app')
@section('title', trans('app.verify_email'). ' -')
@section('content')
    <div class="container">
        <h1 class="section_title">{{ trans('app.verify_email') }}</h1>
        <div class="section_content">
            @if (session('resent'))
                <div class="success">
                    <i class="fa fa-check"></i>
                    {{ trans('app.new_verification_email_sent') }}
                </div>
            @endif
            {{ trans('app.email_verification_notice') }}
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit"
                        class="button button_primary" title="{{ trans('app.request_new_verification_email') }}">{{ trans('app.request_new_verification_email') }}</button>
            </form>
        </div>
    </div>
@endsection
