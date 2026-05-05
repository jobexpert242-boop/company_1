<?php

namespace App\Http\Controllers\BackEnd\ChooseUs;

use App\Http\Controllers\Controller;
use App\Models\ChooseUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ChooseUsController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/ChooseUs/ChooseUs', [
            'items' => ChooseUs::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icon' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image',
            'is_active' => 'required|boolean'
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/chooseus', 'public');
        }

        ChooseUs::create($data);

        return back()->with('status', 'Created successfully');
    }

    public function update(Request $request, ChooseUs $chooseUs)
    {
        $data = $request->validate([
            'icon' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image',
            'is_active' => 'required|boolean'
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {

            // delete old
            if ($chooseUs->image && Storage::disk('public')->exists($chooseUs->image)) {
                Storage::disk('public')->delete($chooseUs->image);
            }

            $data['image'] = $request->file('image')->store('images/chooseus', 'public');
        } else {
            // keep old image
            unset($data['image']);
        }

        $chooseUs->update($data);

        return back()->with('status', 'Updated successfully');
    }

    public function destroy(ChooseUs $chooseUs)
    {
        if ($chooseUs->image && Storage::disk('public')->exists($chooseUs->image)) {
            Storage::disk('public')->delete($chooseUs->image);
        }

        $chooseUs->delete();

        return back()->with('status', 'Deleted');
    }
}
