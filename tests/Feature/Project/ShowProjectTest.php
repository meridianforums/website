<?php

namespace App\Tests\Feature\Project;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ShowProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_users_can_view_their_own_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('projects.show', $project));

        $response->assertSuccessful();
        $response->assertViewIs('projects.show');
        $response->assertViewHas('project');

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_users_cannot_view_others_projects()
    {
        $user = User::factory()->create();

        $userB = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($userB)->get(route('projects.show', $project));

        $response->assertStatus(403);

        $this->assertAuthenticatedAs($userB);
    }

    /** @test */
    public function test_users_cannot_view_projects_that_dont_exist()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('projects.show', ['project' => 'fake-project']));

        $response->assertStatus(404);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_guests_cannot_view_projects()
    {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.show', $project));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_guests_cannot_view_projects_that_do_not_exist()
    {
        $response = $this->get(route('projects.show', ['project' => 'fake-project']));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
