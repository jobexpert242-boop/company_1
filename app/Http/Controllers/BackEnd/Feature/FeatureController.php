<?php

namespace App\Http\Controllers\BackEnd\Feature;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeatureController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/Service/Feature', [
            'features' => Feature::with('service')->latest()->get(),
            'services' => Service::select('id', 'title')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icon' => 'required|string',
            'title' => 'required',
            'description' => 'required',
            'service_id' => 'required|exists:services,id',
            'is_active' => 'required|boolean',
        ]);
        $data['is_active'] = $request->input('is_active') ? 1 : 0;
        Feature::create($data);

        return back()->with('status', 'Feature Created');
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);

        $data = $request->validate([
            'icon' => 'required|string',
            'title' => 'required',
            'description' => 'required',
            'service_id' => 'required|exists:services,id',
            'is_active' => 'required|boolean',
        ]);
        $data['is_active'] = $request->input('is_active') ? 1 : 0;
        $feature->update($data);

        return back()->with('status', 'Feature Updated');
    }

    public function destroy($id)
    {
        Feature::findOrFail($id)->delete();

        return back()->with('status', 'Feature Deleted');
    }
}
