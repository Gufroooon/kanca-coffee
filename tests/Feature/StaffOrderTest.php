<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffOrderTest extends TestCase
{
    use RefreshDatabase;

    protected $staff;
    protected $menu;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::create(['name' => 'Staff', 'slug' => 'staff']);
        $this->staff = User::factory()->create(['role_id' => $role->id]);

        $category = MenuCategory::create(['name' => 'Coffee', 'slug' => 'coffee', 'position' => 1]);
        $this->menu = Menu::create([
            'category_id' => $category->id,
            'name' => 'Aren Latte',
            'slug' => 'aren-latte',
            'price' => 25000,
            'is_available' => true,
        ]);
    }

    public function test_staff_can_place_order_successfully(): void
    {
        $response = $this->actingAs($this->staff)->post(route('staff.orders.store'), [
            'menu_id' => $this->menu->id,
            'quantity' => 2,
            'table_number' => 5,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->staff->id,
            'table_number' => 5,
            'total_price' => 50000.00,
            'status' => 'pending',
        ]);

        $order = Order::first();
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'menu_id' => $this->menu->id,
            'quantity' => 2,
            'price' => 25000.00,
        ]);
    }

    public function test_order_placement_validation(): void
    {
        // Test invalid quantity
        $response = $this->actingAs($this->staff)->post(route('staff.orders.store'), [
            'menu_id' => $this->menu->id,
            'quantity' => 0,
            'table_number' => 5,
        ]);
        $response->assertSessionHasErrors(['quantity']);

        // Test invalid table number
        $response = $this->actingAs($this->staff)->post(route('staff.orders.store'), [
            'menu_id' => $this->menu->id,
            'quantity' => 2,
            'table_number' => 11,
        ]);
        $response->assertSessionHasErrors(['table_number']);
    }

    public function test_staff_can_update_order_status(): void
    {
        $order = Order::create([
            'user_id' => $this->staff->id,
            'table_number' => 3,
            'total_price' => 25000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->staff)->post(route('staff.orders.update-status', $order), [
            'status' => 'completed',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'completed',
        ]);
    }
}
