<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ToggleProjectController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Project $project): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('update', $project);

        $project->update([
            'is_active' => !$project->is_active,
        ]);

        $project->fresh();

        if ($project->is_active)
        {
            session()->flash('success', trans('app.project_status_enabled_flash'));
        }
        else
        {
            session()->flash('success', trans('app.project_status_disabled_flash'));
        }

        return redirect()->route('projects.show', ['project' => $project]);
    }
}
