<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;

class LicenseKeyVerificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param String $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(string $key): \Illuminate\Http\JsonResponse
    {
        $project = Project::where('license_key', $key)->first();

        if (!$project)
        {
            return response()->json([
                'active'       => false,
                'message'       => 'Invalid license key.',
                'creation_date' => null,
            ], 200);
        }

        if (!$project->is_active)
        {
            return response()->json([
                'active'       => false,
                'message'       => 'License key is not active.',
                'creation_date' => $project->created_at->format('Y-m-d'),
            ], 200);
        }


        return response()->json([
            'active'        => true,
            'message'       => 'License key is valid.',
            'creation_date' => $project->created_at->format('Y-m-d'),
        ], 200);
    }
}
