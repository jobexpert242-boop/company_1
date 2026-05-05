<?php

namespace App\Http\Controllers\FrontEnd\Termes;

use App\Http\Controllers\Controller;
use App\Models\Termes;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TermesController extends Controller
{
    public function termes()
    {
        return Inertia::render('FrontEnd/Termes/Termes',[
            'termes' => Termes::first()
        ]);
    }

     // backend 
    public function index()
    {
        return Inertia::render('BackEnd/Termes/Termes', [
            'termes' => Termes::first()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $termes = Termes::first();

        if ($termes) {
            $termes->update($data);
        } else {
            Termes::create($data);
        }

        return redirect()->back()->with('status', 'Termes saved successfully');
    }
}
