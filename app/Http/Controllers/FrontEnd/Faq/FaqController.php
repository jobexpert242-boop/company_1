<?php

namespace App\Http\Controllers\FrontEnd\Faq;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqController extends Controller
{
    public function faq()
    {
        return Inertia::render('FrontEnd/FAQ/Faq', [
            'faqs' => Faq::latest()->get()
        ]);
    }

    // backend 
    public function index()
    {
        return Inertia::render('BackEnd/Faq/Faq', [
            'faqs' => Faq::latest()->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'show_home' => 'required|boolean',
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;
        $data['show_home'] = $request->input('show_home') ? 1 : 0;

        Faq::create($data);

        return redirect()->back()->with('status', 'FAQ created');
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'show_home' => 'required|boolean',
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;
        $data['show_home'] = $request->input('show_home') ? 1 : 0;

        $faq->update($data);

        return redirect()->back()->with('status', 'FAQ updated');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->back()->with('status', 'FAQ deleted');
    }
}
