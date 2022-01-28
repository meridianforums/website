<?php

namespace Tests\Feature\Project;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToggleProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_toggle_their_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id, 'is_active' => false]);

        $response = $this->actingAs($user)->post(route('projects.toggle', $project));

        tap($project->fresh(), function ($project) use ($response) {
            $this->assertTrue($project->is_active);
        });

        $response->assertRedirect(route('projects.show', $project));
        $response->assertStatus(302);
        $response->assertSessionHas('success');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_users_cant_toggle_others_projects()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id, 'is_active' => false]);
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->post(route('projects.toggle', $project));

        tap($project->fresh(), function ($project) use ($response) {
            $this->assertFalse($project->is_active);
        });

        $response->assertStatus(403);

        $this->assertAuthenticatedAs($otherUser);
    }

    /** @test */
    public function test_users_cannot_toggle_projects_that_do_not_exist()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('projects.toggle', 1));

        $response->assertStatus(404);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_guests_cannot_toggle_projects()
    {
        $project = Project::factory()->create(['is_active' => false]);

        $response = $this->post(route('projects.toggle', $project));

        tap($project->fresh(), function ($project) use ($response) {
            $this->assertFalse($project->is_active);
        });

        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    /** @test */
    public function test_guests_cannot_toggle_projects_that_do_not_exist()
    {
        $response = $this->post(route('projects.toggle', 1));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
