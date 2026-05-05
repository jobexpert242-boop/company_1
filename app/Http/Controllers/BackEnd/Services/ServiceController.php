<?php

namespace App\Http\Controllers\BackEnd\Services;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/Service/Service', [
            'services' => Service::latest()->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:services,slug',
            'sub_title' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|image',
            'is_active' => 'required|boolean',
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        $data['image'] = $request->file('image')->store('images/services', 'public');

        Service::create($data);

        return back()->with('status', 'Service Created');
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:services,slug,' . $service->id,
            'sub_title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image',
            'is_active' => 'required|boolean',
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {

            // delete old image
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            $data['image'] = $request->file('image')->store('images/services', 'public');
        } else {
            // keep old image
            unset($data['image']);
        }

        $service->update($data);

        return back()->with('status', 'Service Updated');
    }

    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return back()->with('status', 'Service Deleted');
    }
}
