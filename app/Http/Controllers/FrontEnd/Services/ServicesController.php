<?php

namespace App\Http\Controllers\FrontEnd\Services;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChooseUs;
use App\Models\Comment;
use App\Models\Feature;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\ServiceCarousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ServicesController extends Controller
{
    public function services()
    {
        return Inertia::render('FrontEnd/Services/Services', [
            'services' => Service::latest()->get(),
        ]);
    }

    public function serviceDetails($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();

        return Inertia::render('FrontEnd/Services/ServiceDetails', [
            'service' => $service,
            'carousels' => ServiceCarousel::latest()->get(),
            'chooseus' => ChooseUs::latest()->get(),
            'categories' => Category::latest()->get(),
            'portfolios' => Portfolio::latest()->get(),
            'services' => Service::latest()->take(10)->get(),
            'comments' => Comment::where('service_id', $service->id)->latest()->get(),
            'features' => Feature::where('service_id', $service->id)->latest()->get(),
        ]);
    }

    // backend 
    public function index()
    {
        return Inertia::render('BackEnd/Service/ServiceCarousel', [
            'carousels' => ServiceCarousel::latest()->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image',
            'is_active' => 'required|boolean',
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/service-carousel', 'public');
        }

        ServiceCarousel::create($data);

        return back()->with('status', 'Service Carousel created');
    }

    public function update(Request $request, ServiceCarousel $serviceCarousel)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image',
            'is_active' => 'required|boolean',
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {

            // delete old image
            if ($serviceCarousel->image && Storage::disk('public')->exists($serviceCarousel->image)) {
                Storage::disk('public')->delete($serviceCarousel->image);
            }

            $data['image'] = $request->file('image')->store('images/service-carousel', 'public');
        } else {
            // keep old image
            unset($data['image']);
        }

        $serviceCarousel->update($data);

        return back()->with('status', 'Updated successfully');
    }

    public function destroy(ServiceCarousel $serviceCarousel)
    {
        if ($serviceCarousel->image && Storage::disk('public')->exists($serviceCarousel->image)) {
            Storage::disk('public')->delete($serviceCarousel->image);
        }

        $serviceCarousel->delete();

        return back()->with('status', 'Deleted');
    }
}
