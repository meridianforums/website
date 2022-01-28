@extends('layouts.app')
@section('title', trans('app.modify_project_title', ['name' => $project->name]). ' -')
@section('content')
    <div class="container">
        <form action="{{ route('projects.update', ['project' => $project]) }}" method="post"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form_block">
                <label for="name">{{ __('app.project_image') }}</label>
                <input type="file" name="image" id="image"/>
                @error('image')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form_block">
                <label for="name">{{ __('app.project_name') }}</label>
                <input id="name" type="text" class="@error('name') input-error @enderror" name="name" autocomplete="off"
                       value="{{ old('name', $project->name) }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form_block">
                <label for="short_description">{{ __('app.project_short_description') }}</label>
                <input id="short_description" type="text" class="@error('short_description') input-error @enderror"
                       name="short_description"
                       value="{{ old('short_description', $project->short_description)  }}">
                @error('short_description')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form_block">
                <label for="description">{{ __('app.project_description') }}</label>
                <textarea id="description" name="description"
                          class="@error('description') input-error @enderror">{{ old('description', $project->description)  }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form_block">
                <label for="forum_url">{{ __('app.project_forum_url') }}</label>
                <input id="forum_url" type="text" class="@error('forum_url') input-error @enderror" name="forum_url"
                       value="{{ old('forum_url', $project->forum_url)  }}">
                @error('forum_url')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button class="button button_primary" type="submit" name="{{ trans('app.projects_update') }}">
                {{ trans('app.projects_update') }}
            </button>

            <a href="{{ route('projects.show', $project) }}">
                <button class="button button_secondary" type="button" name="{{ trans('app.cancel') }}">
                    {{ trans('app.cancel') }}
                </button>
            </a>

        </form>

    </div>
@endsection
