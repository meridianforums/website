<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('projects.index', ['projects' => request()->user()->projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        $this->authorize('create', Project::class);

        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ProjectRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('create', Project::class);

        $request->validated();

        $project = $request->user()->projects()->create([
            'name'              => $request->name,
            'short_description' => $request->short_description,
            'description'       => $request->description,
            'license_key'       => Str::random(40),
        ]);

        $this->updateImage($request, $project);

        session()->flash('success', trans('app.project_created_flash'));

        return redirect()->route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Project $project): \Illuminate\Contracts\View\View
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Project $project): \Illuminate\Contracts\View\View
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ProjectRequest $request
     * @param \App\Models\Project               $project
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ProjectRequest $request, Project $project): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('update', $project);

        $request->validated();

        $project = Project::where('id', $project->id)->firstOrFail();

        $project->update([
            'name'              => $request->name,
            'short_description' => $request->short_description,
            'description'       => $request->description,
            'forum_url'         => $request->forum_url,
        ]);

        $this->updateImage($request, $project);

        session()->flash('success', trans('app.project_updated_flash'));

        return redirect()->route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Project $project): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('forceDelete', $project);

        $project->forceDelete();

        if ($project->image_path)
        {
            Storage::delete($project->image_path);
        }

        session()->flash('success', trans('app.project_deleted_flash'));

        return redirect()->route('projects.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project      $project
     * @return void
     */
    private function updateImage(Request $request, Project $project)
    {
        if ($request->has('image'))
        {
            $image = $request->file('image');

            Image::make($image)
                ->fit(250, 250)
                ->encode('jpg', 90)
                ->save(Storage::disk('public')
                    ->path('projects/' . $project->id . '.jpg'));

            $project->update([
                'image_path' => 'projects/' . $project->id . '.jpg',
            ]);
        }
    }
}
