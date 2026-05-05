<?php

namespace App\Http\Controllers\FrontEnd\Contact;

use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function contact()
    {
        return Inertia::render('FrontEnd/Contact/Contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'subject' => 'nullable',
            'message' => 'nullable',
        ]);

        $contact = Contact::create($data);

        // notification (for admin bell icon)
        $notification = Notification::create([
            'title' => 'New Contact Message',
            'message' => $contact->name . ' sent a message',
            'type' => 'contact',
            'contact_id' => $contact->id,
            'is_read' => false,
        ]);

        broadcast(new NewNotification($notification))->toOthers();

        return back()->with('status', 'Message sent successfully');
    }

    // backend 
    public function contactList()
    {
        return Inertia::render('BackEnd/Contact/ContactList', [
            'contacts' => Contact::latest()->paginate(10),
        ]);
    }

    public function destroy(Contact $contact)
    {
        Notification::where('contact_id', $contact->id)->delete();

        $contact->delete();

        return back()->with('status', 'Contact deleted successfully');
    }
}
