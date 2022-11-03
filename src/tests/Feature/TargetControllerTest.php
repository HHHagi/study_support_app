<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TargetControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testGuestIndex()
    {
        $response = $this->get(route('targets.index'));
        $response->assertRedirect('login');
    }

    public function testAuthIndex()
    {

        $response = $this->actingAs($this->user)
            ->get(route('targets.index'));

        $response->assertStatus(300)
            ->assertViewIs('contents_views.targets');
    }
}
