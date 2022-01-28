<?php

namespace App\Tests\Unit;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_project_images_can_be_deleted()
    {
        $project = Project::factory()->create(['image_path' => 'test.jpg']);

        $project->deleteImage();

        tap(Project::first(), function ($project) {
            $this->assertNull($project->image_path);
        });
    }

    /** @test */
    public function test_project_image_path_is_correct()
    {
        $project = Project::factory()->create(['image_path' => 'test.jpg']);

        $this->assertEquals('/storage/test.jpg', $project->image());
    }
}
