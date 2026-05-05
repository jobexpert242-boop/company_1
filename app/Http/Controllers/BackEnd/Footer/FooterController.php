<?php

namespace App\Http\Controllers\BackEnd\Footer;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FooterController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/Footer/Footer', [
            'footer' => Footer::first()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'newsletter_text' => 'nullable|string',
            'location' => 'nullable|string',
            'sales' => 'nullable|string',
            'support' => 'nullable|string',
            'email_one' => 'nullable|email',
            'email_two' => 'nullable|email',
        ]);

        $footer = Footer::first();

        if ($footer) {
            $footer->update($data);
        } else {
            Footer::create($data);
        }

        return redirect()->back()->with('status', 'Footer saved successfully');
    }
}
