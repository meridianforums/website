<?php

namespace Tests\Feature\Project;

use App\Models\Project;
use App\Models\User;
use Faker\Provider\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CreateProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_users_can_render_create_project_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('projects.create'));

        $response->assertStatus(200);
        $response->assertViewIs('projects.create');

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_guests_cant_render_create_project_page()
    {
        $response = $this->get(route('projects.create'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $this->assertGuest();
    }

    /** @test */
    public function test_user_can_create_new_projects()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('projects.store'), [
            'name'              => 'Project 1',
            'short_description' => 'Short description',
            'description'       => 'This is my full description.',
            'image'             => UploadedFile::fake()->image('image.jpg'),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('projects.show', Project::first()));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('projects', [
            'name'              => 'Project 1',
            'short_description' => 'Short description',
            'description'       => 'This is my full description.',
        ]);

        tap(Project::first(), function ($project) use ($user) {
            $this->assertEquals('Project 1', $project->name);
            $this->assertEquals('Short description', $project->short_description);
            $this->assertEquals('This is my full description.', $project->description);
            $this->assertEquals($project->user_id, $user->id);
            $this->assertNotNull($project->image_path);
        });

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_guests_cannot_create_new_projects()
    {
        $response = $this->post(route('projects.store'), [
            'name'              => 'Project 1',
            'short_description' => 'Short description',
            'description'       => 'This is my full description.',
            'image'             => UploadedFile::fake()->image('image.jpg'),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $this->assertGuest();
    }

    /** @test */
    public function test_validation_rules()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('projects.store'), [
            'name'              => '',
            'short_description' => '',
            'description'       => '',
            'image'             => UploadedFile::fake()->image('image.jpg'),
        ]);

        $response->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('projects', [
            'name'              => '',
            'short_description' => '',
            'description'       => '',
        ]);

        $this->assertAuthenticatedAs($user);
    }
}
