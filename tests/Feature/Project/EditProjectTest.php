<?php

namespace App\Tests\Feature\Project;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param string $url
     * @return \App\Tests\Feature\Project\EditProjectTest
     */
    public function from(string $url): EditProjectTest
    {
        session()->setPreviousUrl(url($url));
        return $this;
    }

    /** @test */
    public function test_users_can_render_project_page_for_their_own_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('projects.edit', $project));

        $response->assertStatus(200);

        $this->assertAuthenticatedAs($user);

        $response->assertViewIs('projects.edit');
        $response->assertViewHas('project', $project);
    }

    /** @test */
    public function test_users_cannot_render_project_page_that_belongs_to_another_user()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        $project = Project::factory()->create(['user_id' => $anotherUser->id]);

        $response = $this->actingAs($user)->get(route('projects.edit', $project));

        $response->assertStatus(403);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_guests_cannot_render_project_page()
    {
        $anotherUser = User::factory()->create();

        $project = Project::factory()->create(['user_id' => $anotherUser->id]);

        $response = $this->get(route('projects.edit', $project));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $this->assertGuest();
    }


    /** @test */
    public function test_users_can_update_their_own_projects()
    {
        $user = User::factory()->create();

        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('projects.update', $project), [
            'name'              => 'New Project Name',
            'short_description' => 'New Project Description',
            'description'       => 'New Project Description Long',
            'forum_url'         => 'https://new-project-url.com',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('projects.show', $project));

        $response->assertSessionHas('success');

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('projects.show', $project));

        tap($project->fresh(), function ($project) {
            $this->assertEquals('New Project Name', $project->name);
            $this->assertEquals('New Project Description', $project->short_description);
            $this->assertEquals('New Project Description Long', $project->description);
            $this->assertEquals('https://new-project-url.com', $project->forum_url);
        });
    }

    /** @test */
    public function test_users_cannot_update_others_projects()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        $project = Project::factory()->create([
            'user_id'           => $user->id,
            'name'              => 'Old Project Name',
            'short_description' => 'Old Project Description',
            'description'       => 'Old Project Description Long',
            'forum_url'         => 'https://old-project-url.com',
        ]);

        $response = $this->actingAs($anotherUser)->put(route('projects.update', $project), [
            'name'              => 'New Project Name',
            'short_description' => 'New Project Description',
            'description'       => 'New Project Description Long',
            'forum_url'         => 'https://new-project-url.com',
        ]);
        $response->assertStatus(403);
        $this->assertAuthenticatedAs($anotherUser);

        $this->assertDatabaseHas('projects', [
            'id'                => $project->id,
            'name'              => 'Old Project Name',
            'short_description' => 'Old Project Description',
            'description'       => 'Old Project Description Long',
            'forum_url'         => 'https://old-project-url.com',
        ]);
    }

    /** @test */
    public function test_guests_cannot_update_projects()
    {
        $project = Project::factory()->create([
            'name'              => 'Old Project Name',
            'short_description' => 'Old Project Description',
            'description'       => 'Old Project Description Long',
            'forum_url'         => 'https://old-project-url.com',
        ]);


        $response = $this->put(route('projects.update', $project), [
            'name'              => 'New Project Name',
            'short_description' => 'New Project Description',
            'description'       => 'New Project Description Long',
            'forum_url'         => 'https://new-project-url.com',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $this->assertGuest();

        $this->assertDatabaseHas('projects', [
            'id'                => $project->id,
            'name'              => 'Old Project Name',
            'short_description' => 'Old Project Description',
            'description'       => 'Old Project Description Long',
            'forum_url'         => 'https://old-project-url.com',
        ]);
    }

    /** @test */
    public function test_validation_rules()
    {
        $user = User::factory()->create();

        $project = Project::factory()->create([
            'user_id'           => $user->id,
            'name'              => 'Old Project Name',
            'short_description' => 'Old Project Description',
            'description'       => 'Old Project Description Long',
            'forum_url'         => 'https://old-project-url.com',
        ]);

        $response = $this->actingAs($user)->put(route('projects.update', $project), [
            'name'              => '',
            'short_description' => '',
            'description'       => '',
            'forum_url'         => '',
        ]);

        $response->assertSessionHasErrors(['name']);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_users_cannot_render_a_non_existent_project()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('projects.show', ['project' => 'non-existent-project']));

        $response->assertStatus(404);
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_guests_cannot_render_a_non_existent_project()
    {
        $response = $this->get(route('projects.show', ['project' => 'non-existent-project']));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /** @test */
    public function test_users_cannot_update_a_non_existent_project()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('projects.update', ['project' => 'non-existent-project']));

        $response->assertStatus(404);
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_guests_cannot_update_a_non_existent_project()
    {
        $response = $this->put(route('projects.update', ['project' => 'non-existent-project']));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
