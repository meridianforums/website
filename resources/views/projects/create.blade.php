@extends('layouts.app')
@section('title', trans('app.projects_create'). ' -')
@section('content')
    <div class="container">
        <form action="{{ route('projects.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form_block">
                <label for="name">{{ __('app.project_image') }}</label>
                <input type="file" name="image" id="image" />
                @error('image')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form_block">
                <label for="name">{{ __('app.project_name') }}</label>
                <input id="name" type="text" class="@error('name') input-error @enderror" name="name" autocomplete="off"
                       value="{{ old('name')  }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form_block">
                <label for="short_description">{{ __('app.project_short_description') }}</label>
                <input id="short_description" type="text" class="@error('short_description') input-error @enderror" name="short_description"
                       value="{{ old('short_description')  }}">
                @error('short_description')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form_block">
                <label for="description">{{ __('app.project_description') }}</label>
                <textarea id="description" name="description"  class="@error('description') input-error @enderror">{{ old('description')  }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button class="button button_primary" type="submit" name="{{ trans('app.projects_create') }}">
                {{ trans('app.projects_create') }}
            </button>

            <a href="{{ route('projects.index') }}">
                <button class="button button_secondary" type="button" name="{{ trans('app.cancel') }}">
                    {{ trans('app.cancel') }}
                </button>
            </a>

        </form>

    </div>
@endsection
