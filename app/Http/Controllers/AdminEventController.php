<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('speaker_name', 'like', '%' . $request->search . '%');
        }

        $events = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('events', 'public');
            $validated['poster'] = '/storage/' . $path;
        } elseif ($request->filled('poster_url')) {
            $validated['poster'] = $request->poster_url;
        } else {
            $validated['poster'] = 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80';
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Community event created successfully!');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $validated = $request->validated();

        if ($validated['title'] !== $event->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
        }

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('events', 'public');
            $validated['poster'] = '/storage/' . $path;
        } elseif ($request->filled('poster_url')) {
            $validated['poster'] = $request->poster_url;
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event details updated successfully!');
    }

    public function participants(Event $event)
    {
        $registrations = EventRegistration::where('event_id', $event->id)->orderBy('registered_at', 'desc')->get();
        return view('admin.events.participants', compact('event', 'registrations'));
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully!');
    }
}
