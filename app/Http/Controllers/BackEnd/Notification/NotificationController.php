<?php

namespace App\Http\Controllers\BackEnd\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/Notification/Notification', [
            'notifications' => Notification::latest()->paginate(20),
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        // return response()->json(['status' => true]);
        return back();
    }
}
