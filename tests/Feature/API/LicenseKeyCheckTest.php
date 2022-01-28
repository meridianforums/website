<?php

namespace Tests\Feature\API;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class LicenseKeyCheckTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ThrottleRequests::class);
    }

    /** @test */
    public function test_response_is_false_if_license_does_not_exist()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/license/123456789');

        $response->assertStatus(200);
        $response->assertJson([
            'active'        => false,
            'message'       => 'Invalid license key.',
            'creation_date' => null,
        ]);
    }

    /** @test */
    public function test_response_is_false_if_license_is_disabled()
    {
        Project::factory()->create([
            'license_key' => '123456789',
            'is_active'   => false,
        ])
        ;

        $this->withoutExceptionHandling();

        $response = $this->get('/api/license/123456789');

        $response->assertStatus(200);
        $response->assertJson([
            'active'        => false,
            'message'       => 'License key is not active.',
            'creation_date' => Carbon::now()->format('Y-m-d'),
        ]);
    }

    /** @test */
    public function test_response_is_true_if_license_is_active()
    {
        Project::factory()->create([
            'license_key' => '123456789',
            'is_active'   => true,
        ])
        ;

        $this->withoutExceptionHandling();

        $response = $this->get('/api/license/123456789');

        $response->assertStatus(200);
        $response->assertJson([
            'active'        => true,
            'message'       => 'License key is valid.',
            'creation_date' => Carbon::now()->format('Y-m-d'),
        ]);
    }
}
