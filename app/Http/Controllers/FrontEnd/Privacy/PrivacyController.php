<?php

namespace App\Http\Controllers\FrontEnd\Privacy;

use App\Http\Controllers\Controller;
use App\Models\Privacy;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrivacyController extends Controller
{
    public function privacy()
    {
        return Inertia::render('FrontEnd/Privacy/Privacy',[
            'privacy' => Privacy::first()
        ]);
    }

    // backend 
    public function index()
    {
        return Inertia::render('BackEnd/Privacy/Privacy', [
            'privacy' => Privacy::first()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $privacy = Privacy::first();

        if ($privacy) {
            $privacy->update($data);
        } else {
            Privacy::create($data);
        }

        return redirect()->back()->with('status', 'Privacy saved successfully');
    }
}
