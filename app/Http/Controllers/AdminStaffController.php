<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminStaffController extends Controller
{
    public function index(Request $request)
    {
        $staffRole = Role::where('slug', 'staff')->first();

        if (! $staffRole) {
            return view('admin.staff.index', [
                'staffMembers' => User::whereRaw('1 = 0')->paginate(10),
            ])->with('error', 'Staff role has not been seeded yet.');
        }

        $query = User::with('role')->where('role_id', $staffRole->id);

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
        }

        $staffMembers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.staff.index', compact('staffMembers'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:30',
            'shift' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $staffRole = Role::where('slug', 'staff')->first();

        if (! $staffRole) {
            return back()->with('error', 'Staff role has not been seeded yet. Please run the database seeder first.');
        }

        User::create([
            'role_id' => $staffRole->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'shift' => $validated['shift'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
            'avatar' => '/images/kanca-logo.jpg',
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'New staff member registered successfully!');
    }

    public function edit(User $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'phone' => 'required|string|max:30',
            'shift' => 'required|string',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'shift' => $validated['shift'],
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff details updated successfully!');
    }

    public function destroy(User $staff)
    {
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff account deleted.');
    }
}
