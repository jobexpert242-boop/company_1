<?php

namespace App\Http\Controllers\BackEnd\Header;

use App\Http\Controllers\Controller;
use App\Models\Header;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HeaderController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/Header/Header', [
            'header' => Header::first(),
        ]);
    }

    public function store(Request $request)
    {
        // validation (recommended)
        $data = $request->validate([
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'pinterest' => 'nullable|string',
            'youtube' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        $header = Header::first();

        if ($header) {
            $header->update($data);
        } else {
            Header::create($data);
        }

        return redirect()->back()->with('status', 'Header saved successfully');
    }
}
