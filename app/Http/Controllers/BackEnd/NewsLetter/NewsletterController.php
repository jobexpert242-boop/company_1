<?php

namespace App\Http\Controllers\BackEnd\NewsLetter;

use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $newsletter = Newsletter::create($data);

        // create notification
        $notification = Notification::create([
            'title' => 'New Subscription',
            'message' => $newsletter->email . ' subscribed',
            'is_read' => false,
        ]);

        // realtime broadcast
        broadcast(new NewNotification($notification))->toOthers();

        return back()->with('status', 'Subscribed successfully');
    }

    // backend 
    public function newsletterList()
    {
        return Inertia::render('BackEnd/NewsLetter/NewsletterList', [
            'newsletter' => Newsletter::latest()->paginate(10),
        ]);
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return back()->with('status', 'Newsletter deleted successfully');
    }
}
