<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    protected $registrationService;

    public function __construct(EventRegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $events = $query->orderBy('date', 'asc')->paginate(6)->withQueryString();
        $featuredEvents = Event::where('is_featured', true)->where('date', '>=', now()->toDateString())->take(3)->get();

        return view('community.index', compact('events', 'featuredEvents'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $relatedEvents = Event::where('id', '!=', $event->id)->where('date', '>=', now()->toDateString())->take(3)->get();

        return view('community.show', compact('event', 'relatedEvents'));
    }

    public function register(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'tickets_count' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|string',
        ]);

        try {
            $registration = $this->registrationService->register($event, $validated, Auth::user());

            return back()->with('success', "Event registration successful! Your Ticket Pass QR Code is: {$registration->qr_code}");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
