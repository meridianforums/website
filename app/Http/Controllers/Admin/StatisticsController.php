<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class StatisticsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function __invoke(Request $request): \Illuminate\Contracts\View\View
    {
        if (!$request->user()->isSuperAdmin())
        {
            abort(403, 'Unauthorized action.');
        }


        $chart = new LaravelChart(['chart_title'    => 'Users by names',
                                   'report_type'    => 'group_by_string',
                                   'model'          => 'App\Models\User',
                                   'group_by_field' => 'country',
                                   'chart_type'     => 'pie']);

        return view('admin.stats', [
            'projects'                 => Project::all()->count(),
            'projects_licenses_active' => Project::where('is_active', true)->count(),
            'users'                    => User::all()->count(),
            'super_admins'             => User::where('is_super_admin', true)->count(),
            'chart'                    => $chart,
        ]);
    }
}
