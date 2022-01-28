@extends('layouts.app')
@section('title', trans('app.projects'). ' -')
@section('content')
    <div class="container">
        <div id="index">
            <div class="project__cta">
                <a href="{{ route('projects.create') }}">
                    <button title="{{ trans('app.projects_create') }}" class="button button_primary">
                        {{ trans('app.projects_create') }}
                    </button>
                </a>
            </div>
            <table class="projects_table">
                <thead>
                <tr>
                    <th colspan="1" id="projects_table_icon">{{ trans('app.project_index_image') }}</th>
                    <th colspan="1">{{ trans('app.project_index_name') }}</th>
                    <th colspan="1">{{ trans('app.project_index_status') }}</th>
                    <th colspan="1">{{ trans('app.project_index_created_at') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td colspan="1" id="projects_table_icon"><a href="{{ route('projects.show', $project) }}"><img
                                    src="{{ $project->image() }}" alt="{{ $project->name }}"/></a></td>
                        <td colspan="1"><a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a></td>
                        <td colspan="1">
                            <div
                                class="project_status @if($project->is_active == true) status_okay @else status_bad @endif">
                                    <span>
                                         @if($project->is_active == true)
                                            {{ trans('app.project_index_status_active') }}
                                        @else
                                            {{ trans('app.project_index_status_inactive') }}
                                        @endif
                                    </span>
                            </div>
                        </td>
                        <td colspan="1">{{ $project->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">{{ trans('app.project_index_no_projects') }}</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4">{{ trans('app.project_amount_footer', ['amount' => $projects->count()]) }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
