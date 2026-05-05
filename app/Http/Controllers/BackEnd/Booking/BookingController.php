<?php

namespace App\Http\Controllers\BackEnd\Booking;

use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'nullable',
            'phone' => 'required',
            'email' => 'required|email',
            'subject' => 'nullable',
            'message' => 'nullable',
        ]);

        $booking = Booking::create($data);

        $notification = Notification::create([
            'title' => 'New Booking',
            'message' => $booking->first_name . ' submitted booking',
            'type' => 'booking',
            'booking_id' => $booking->id,
        ]);

        // broadcast realtime
        broadcast(new NewNotification($notification))->toOthers();

        return back()->with('status', 'Booking submitted');
    }

    // backend 
    public function unreadshow(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        return Inertia::render('BackEnd/Booking/UnreadBooking', [
            'notification' => $notification->load(['booking', 'contact']),
        ]);
    }

    public function bookingNotification()
    {
        return Inertia::render('BackEnd/Booking/BookingList', [
            'bookings' => Booking::latest()->paginate(10),
        ]);
    }

    public function destroy(Booking $booking)
    {
        // delete related notifications
        Notification::where('booking_id', $booking->id)->delete();

        // delete booking
        $booking->delete();

        return back()->with('status', 'Booking deleted');
    }
}
