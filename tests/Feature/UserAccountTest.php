<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_users_can_render_their_account_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('account'));

        $response->assertStatus(200);
        $response->assertViewIs('account');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_guests_cant_render_their_account_page()
    {
        $response = $this->get(route('account'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /** @test */
    public function test_users_can_update_their_account_details()
    {
        $user = User::factory()->create([
            'name'     => 'John Doe',
            'username' => 'johndoe',
            'email'    => 'john.doe@email.com',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->post(route('account.update'), [
            'name'                  => 'Jane Doe',
            'username'              => 'janedoe',
            'email'                 => 'jane.doe@email.com',
            'password'              => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('account'));
        $this->assertAuthenticatedAs($user);

        $response->assertSessionHas('success');

        tap($user->fresh(), function ($user) {
            $this->assertEquals('Jane Doe', $user->name);
            $this->assertEquals('janedoe', $user->username);
            $this->assertEquals('jane.doe@email.com', $user->email);
            $this->assertTrue(password_verify('new-password', $user->password));
        });
    }

    /** @test */
    public function test_guests_cannot_update_their_account_details()
    {
        $response = $this->post(route('account.update'), [
            'name'                  => 'Jane Doe',
            'username'              => 'janedoe',
            'email'                 => 'jane.doe@email.com',
            'password'              => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /** @test */
    public function test_account_validation_throws_the_correct_errors()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('account.update'), [
            'name'                  => '',
            'username'              => '',
            'email'                 => '',
            'password'              => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'username', 'email']);

        $this->assertAuthenticatedAs($user);
    }
}
