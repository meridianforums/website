<?php

namespace App\Tests\Feature\Project;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_users_can_delete_their_own_projects()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('projects.destroy', $project));

        $response->assertStatus(302);
        $response->assertRedirect(route('projects.index'));

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    /** @test */
    public function test_users_cannot_delete_other_users_projects()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $response = $this->actingAs($user)->delete(route('projects.destroy', $project));

        $response->assertStatus(403);

        $this->assertDatabaseHas('projects', ['id' => $project->id]);
    }

    /** @test */
    public function users_cannot_delete_non_existing_projects()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('projects.destroy', ['project' => 999]));

        $response->assertStatus(404);
    }

    /** @test */
    public function test_guests_cannot_delete_projects()
    {
        $project = Project::factory()->create();

        $response = $this->delete(route('projects.destroy', $project));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('projects', ['id' => $project->id]);
    }

    /** @test */
    public function guests_cannot_delete_non_existing_projects()
    {
        $response = $this->delete(route('projects.destroy', ['project' => 999]));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
