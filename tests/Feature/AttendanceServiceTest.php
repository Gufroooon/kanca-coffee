<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AttendanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_clock_in_persists_real_gps_coordinates(): void
    {
        $user = User::factory()->create(['shift' => 'Morning Shift (07:00 - 15:00)']);

        $attendance = app(AttendanceService::class)->clockIn($user, -6.2297123, 106.8080456, 12.5, 'Arrived at store');

        $this->assertSame($user->id, $attendance->user_id);
        $this->assertDatabaseHas('attendances', [
            'id' => $attendance->id,
            'clock_in_latitude' => -6.2297123,
            'clock_in_longitude' => 106.8080456,
            'clock_in_accuracy' => 12.5,
        ]);
        $this->assertDatabaseHas('attendance_logs', ['attendance_id' => $attendance->id, 'action' => 'clock_in']);
    }
}
