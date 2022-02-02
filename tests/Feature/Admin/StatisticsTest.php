<?php

namespace Tests\Feature\Admin;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class StatisticsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_admins_can_render_statistics_page()
    {
        $admin = User::factory()->superAdmin()->create();

        $response = $this->actingAs($admin)->get(route('admin.stats'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.stats');
        $response->assertSeeText(trans('app.admin_stats'));

        $this->assertAuthenticatedAs($admin);
        $this->assertTrue($admin->isSuperAdmin());
    }

    /** @test */
    public function test_users_cant_render_statistics_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.stats'));

        $response->assertStatus(403);

        $this->assertAuthenticatedAs($user);
        $this->assertFalse($user->isSuperAdmin());
    }

    /** @test */
    public function test_guests_cant_render_statistics_page()
    {
        $response = $this->get(route('admin.stats'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $this->assertGuest();
    }

    /** @test */
    public function test_statistics_page_shows_correct_data()
    {
        $admin = User::factory()->superAdmin()->create();

        User::factory()->create();
        User::factory()->create();

        Project::factory()->create(['is_active' => true]);
        Project::factory()->create(['is_active' => true]);
        Project::factory()->create(['is_active' => false]);

        $response = $this->actingAs($admin)->get(route('admin.stats'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.stats');

        $response->assertSeeText(trans('app.users_signed_up', ['num' => '6']));
        $response->assertSeeText(trans('app.total_super_admin_users', ['num' => '1']));
        $response->assertSeeText(trans('app.active_license_keys', ['num' => '2']));
        $response->assertSeeText(trans('app.total_projects', ['num' => '3']));

        $this->assertAuthenticatedAs($admin);
        $this->assertTrue($admin->isSuperAdmin());
    }
}
