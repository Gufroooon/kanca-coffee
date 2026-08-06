<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffAttendanceFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_clock_in_is_persisted_and_shown_after_dashboard_refresh(): void
    {
        $role = Role::create(['name' => 'Staff', 'slug' => 'staff']);
        $staff = User::factory()->create(['role_id' => $role->id, 'shift' => 'Morning Shift (07:00 - 15:00)']);

        $response = $this->actingAs($staff)->post(route('staff.attendance.clock-in'), [
            'latitude' => -6.2297123,
            'longitude' => 106.8080456,
            'accuracy' => 12.5,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('attendances', [
            'user_id' => $staff->id,
            'date' => now()->toDateString(),
            'clock_in_latitude' => -6.2297123,
            'clock_in_longitude' => 106.8080456,
        ]);

        $this->actingAs($staff)->get(route('staff.dashboard'))
            ->assertOk()
            ->assertSee('CLOCK OUT NOW')
            ->assertSee('Saved Clock-In Location');
    }
}
