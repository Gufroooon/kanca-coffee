<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Support\Str;

class EventRegistrationService
{
    public function register(Event $event, array $data, ?User $user = null): EventRegistration
    {
        if ($event->is_full) {
            throw new \Exception('Sorry, this community event has reached its maximum seat quota.');
        }

        $ticketsCount = (int) ($data['tickets_count'] ?? 1);
        if (($event->registered_count + $ticketsCount) > $event->capacity) {
            throw new \Exception("Only " . ($event->capacity - $event->registered_count) . " ticket(s) remaining for this event.");
        }

        $qrCode = 'KC-EVT-' . strtoupper(Str::random(8)) . '-' . rand(100, 999);

        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => $user ? $user->id : null,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'tickets_count' => $ticketsCount,
            'status' => 'confirmed',
            'qr_code' => $qrCode,
            'notes' => $data['notes'] ?? null,
            'registered_at' => now(),
        ]);

        $event->increment('registered_count', $ticketsCount);

        return $registration;
    }
}
