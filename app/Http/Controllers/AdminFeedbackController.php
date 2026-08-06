<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('user')->orderBy('created_at', 'desc')->paginate(10);
        $contactMessages = ContactMessage::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.feedbacks.index', compact('feedbacks', 'contactMessages'));
    }

    public function toggleFeedbackStatus(Feedback $feedback)
    {
        $newStatus = ($feedback->status === 'published') ? 'hidden' : 'published';
        $feedback->update(['status' => $newStatus]);
        return back()->with('success', 'Feedback status updated to ' . $newStatus);
    }

    public function markMessageRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'Contact message marked as read.');
    }
}
