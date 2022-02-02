<?php

namespace App\Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_is_super_admin()
    {
        $user = User::factory()->superAdmin()->create();

        $this->assertTrue($user->isSuperAdmin());
    }

    /** @test */
    public function user_is_not_super_admin()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->isSuperAdmin());
    }
}
