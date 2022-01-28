@extends('layouts.app')
@section('title', trans('app.viewing_project_title', ['name' => $project->name]). ' -')
@section('content')
    <div class="container">
        <div id="project">
            <div class="project__inner--left">
                <div class="project__inner__header">
                    <div class="project__inner__icon">
                        <img src="{{ $project->image() }}" alt="{{ $project->name }}" title="{{ $project->name }}"
                             class="project_image"/>
                    </div>
                    <h2>{{ $project->name }}</h2>
                    <p>{{ $project->short_description ?? trans('app.no_product_short_description') }}</p>
                </div>
                <div class="project__inner_content">
                    {{ $project->description ?? trans('app.no_product_description') }}
                </div>
                <div class="project__inner_license">
                    <h3>{{ trans('app.project_license_details') }}</h3>
                    <div>
                        <div id="license">
                            @if(!$project->is_active)
                                <div class="alert alert-danger project__notice">
                                    <i class="fa fa-exclamation-circle alert-icon"></i>
                                    <span>
                                        {{ trans('app.project_disabled_license_warning') }}
                                    </span>
                                </div>
                            @else
                                <button type="button" class="button button_primary" data-micromodal-trigger="modal-1"
                                        title="{{ trans('app.display_license_key') }}">
                                    {{ trans('app.display_license_key') }}
                                </button>
                                <p>{{ trans('app.project_license_details_msg') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="project__inner--right">
                <h4>{{ trans('app.project_actions') }}</h4>
                @can('update', $project)
                    <div>
                        <a href="{{ route('projects.edit', $project) }}">
                            <button type="button" title="{{ trans('app.update_project_details') }}"
                                    class="button button_secondary">
                                {{ trans('app.update_project_details') }}
                            </button>
                        </a>
                    </div>
                    <div>
                        <button type="button" title="{{ trans('app.toggle_project_license_key_status') }}"
                                data-micromodal-trigger="modal-3"
                                class="button button_secondary">
                            {{ trans('app.toggle_project_license_key_status') }}
                        </button>
                    </div>
                @endcan

                @can('forceDelete', $project)
                    <div>
                        <button type="button" title="{{ trans('app.remove_project') }}"
                                data-micromodal-trigger="modal-2"
                                class="button button_secondary">
                            {{ trans('app.remove_project') }}
                        </button>
                    </div>
                @endcan
                <h4>{{ trans('app.project_details') }}</h4>
                @if($project->is_active)
                    <p class="success">{{ trans('app.project_index_status_active') }}</p>
                @else
                    <p class="danger">{{ trans('app.project_index_status_inactive') }}</p>
                @endif
                @if($project->forum_url)
                    <p><i class="icon fa fa-external-link-alt"></i> <a target="_blank"
                                                                href="{{ url($project->forum_url) }}">{{ $project->forum_url }}</a>
                    </p>
                @endif
                <p>{{ trans('app.projected_created_at', ['date' => $project->created_at->diffForHumans()]) }}</p>
                <p>{{ trans('app.projected_updated_at', ['date' => $project->updated_at->diffForHumans()]) }}</p>
                <p>{{ trans('app.project_owner', ['name' => $project->owner->name, 'username' => $project->owner->username]) }}</p>
            </div>
        </div>
    </div>
    @include('partials.modals.license-key')
    @include('partials.modals.delete-project-confirmation')
    @include('partials.modals.toggle-project-license-status')
@endsection
