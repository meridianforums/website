<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Account
Breadcrumbs::for('account', function (BreadcrumbTrail $trail) {
    $trail->push(trans('app.account'), route('account'));
});

// Projects
Breadcrumbs::for('projects.index', function (BreadcrumbTrail $trail) {
    $trail->push(trans('app.projects'), route('projects.index'));
});

Breadcrumbs::for('projects.create', function (BreadcrumbTrail $trail) {
    $trail->parent('projects.index');
    $trail->push(trans('app.projects_create'), route('projects.create'));
});

Breadcrumbs::for('projects.edit', function (BreadcrumbTrail $trail, \App\Models\Project  $project) {
    $trail->parent('projects.index');
    $trail->push(trans('app.modify_project_title', ['name' => $project->name]), route('projects.edit', $project));
});

Breadcrumbs::for('projects.show', function (BreadcrumbTrail $trail, \App\Models\Project  $project) {
    $trail->parent('projects.index');
    $trail->push(trans('app.viewing_project_title', ['name' => $project->name]), route('projects.show', $project));
});

// Pages
Breadcrumbs::for('privacy-policy', function (BreadcrumbTrail $trail) {
    $trail->push(trans('app.privacy_policy'), route('privacy-policy'));
});

// Admin Statistics
Breadcrumbs::for('admin.stats', function (BreadcrumbTrail $trail) {
    $trail->push(trans('app.admin_stats'), route('admin.stats'));
});
