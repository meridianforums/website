@extends('layouts.app')
@section('title', trans('app.admin_stats'). ' -')
@section('content')
    <div class="admin__stats_block">
        <div class="admin__stats__item stats_block">
            {{ trans('app.users_signed_up', ['num' => $users]) }}
        </div>
        <div class="admin__stats__item stats_block">
            {{ trans('app.active_license_keys', ['num' => $projects_licenses_active]) }}
        </div>
        <div class="admin__stats__item stats_block">
            {{ trans('app.total_projects', ['num' => $projects]) }}
        </div>
        <div class="admin__stats__item stats_block">
            {{ trans('app.total_super_admin_users', ['num' => $super_admins]) }}
        </div>
    </div>
    <p>{{ trans('app.users_by_country') }}</p>
    <div class="admin__stats__chart">
        {!! $chart->renderHtml() !!}
    </div>
@endsection

@push('scripts')
    {!! $chart->renderChartJsLibrary() !!}
    {!! $chart->renderJs() !!}
@endpush
