<?php

namespace App\Http\Controllers\FrontEnd\About;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutController extends Controller
{
    public function about()
    {
        return Inertia::render('FrontEnd/About/About',[
            'about' => About::first()
        ]);
    }

    // backend 
    public function index()
    {
        return Inertia::render('BackEnd/About/About', [
            'about' => About::first()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $about = About::first();

        if ($about) {
            $about->update($data);
        } else {
            About::create($data);
        }

        return redirect()->back()->with('status', 'About saved successfully');
    }
}
