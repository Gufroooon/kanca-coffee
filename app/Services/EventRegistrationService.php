<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventRegistrationService
{
    public function register(Event $event, array $data, ?User $user = null): EventRegistration
    {
        $ticketsCount = (int) ($data['tickets_count'] ?? 1);

        return DB::transaction(function () use ($event, $data, $user, $ticketsCount) {
            $event = Event::query()->lockForUpdate()->findOrFail($event->id);
            if ($event->status === 'cancelled' || $event->date->isPast()) {
                throw new \Exception('Registration is no longer available for this event.');
            }
            if (($event->registered_count + $ticketsCount) > $event->capacity) {
                throw new \Exception('Only '.max(0, $event->available_seats).' ticket(s) remaining for this event.');
            }

            $registration = EventRegistration::create([
                'event_id' => $event->id, 'user_id' => $user?->id, 'name' => $data['name'], 'email' => $data['email'],
                'phone' => $data['phone'], 'tickets_count' => $ticketsCount, 'status' => 'confirmed',
                'qr_code' => 'KC-EVT-'.strtoupper(Str::random(8)).'-'.rand(100, 999),
                'notes' => $data['notes'] ?? null, 'registered_at' => now(),
            ]);
            $event->increment('registered_count', $ticketsCount);

            return $registration;
        });
    }
}
