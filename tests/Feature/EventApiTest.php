<?php

namespace Tests\Feature;
use App\Models\Event;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    // Test Create Event
    public function test_create_event()
    {
        $data = [
            'title' => 'Community Event',
            'description' => 'A community gathering.',
            'event_date' => '2025-02-25',
            'category' => 'Community',
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/events', $data);

        $response->assertStatus(201)
                 ->assertJson($data);
    }

    // Test Get Events
    public function test_get_events()
    {
        Event::factory()->count(3)->create();

        $response = $this->getJson('/api/events');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    // Test Update Event
    public function test_update_event()
    {
        $event = Event::factory()->create();

        $data = [
            'title' => 'Updated Event',
            'description' => 'Updated description.',
            'event_date' => '2025-03-25',
            'category' => 'Updated Category',
        ];

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/events/{$event->id}", $data);

        $response->assertStatus(200)
                 ->assertJson($data);
    }

    // Test Delete Event
    public function test_delete_event()
    {
        $event = Event::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/events/{$event->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Event deleted successfully']);
    }
}
