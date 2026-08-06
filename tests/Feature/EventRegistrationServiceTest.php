<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Services\EventRegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRegistrationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_updates_the_event_quota(): void
    {
        $event = Event::create([
            'title' => 'Kanca Workshop', 'slug' => 'kanca-workshop', 'description' => 'Workshop',
            'date' => now()->addDay(), 'capacity' => 3, 'registered_count' => 1,
        ]);

        $registration = app(EventRegistrationService::class)->register($event, [
            'name' => 'Kanca Visitor', 'email' => 'visitor@example.test', 'phone' => '08123456789', 'tickets_count' => 2,
        ]);

        $this->assertSame(2, $registration->tickets_count);
        $this->assertDatabaseHas('events', ['id' => $event->id, 'registered_count' => 3]);
    }

    public function test_registration_is_rejected_when_the_remaining_quota_is_insufficient(): void
    {
        $event = Event::create([
            'title' => 'Kanca Workshop', 'slug' => 'kanca-workshop', 'description' => 'Workshop',
            'date' => now()->addDay(), 'capacity' => 3, 'registered_count' => 2,
        ]);

        $this->expectExceptionMessage('Only 1 ticket(s) remaining for this event.');

        app(EventRegistrationService::class)->register($event, [
            'name' => 'Kanca Visitor', 'email' => 'visitor@example.test', 'phone' => '08123456789', 'tickets_count' => 2,
        ]);
    }
}
