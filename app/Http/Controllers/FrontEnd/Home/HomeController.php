<?php

namespace App\Http\Controllers\FrontEnd\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChooseUs;
use App\Models\CompanyLogo;
use App\Models\Faq;
use App\Models\HomeCarousel;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home()
    {
        return Inertia::render('Home', [

            // instant load
            'carousels' => fn() => HomeCarousel::latest()->get(),

            // deferred load
            'services' => Inertia::defer(
                fn() =>
                Service::latest()->take(6)->get()
            ),

            'projects' => Inertia::defer(
                fn() =>
                Project::latest()->get()
            ),

            'logos' => Inertia::defer(
                fn() =>
                CompanyLogo::latest()->get()
            ),

            'categories' => Inertia::defer(
                fn() =>
                Category::latest()->get()
            ),

            'portfolios' => Inertia::defer(
                fn() =>
                Portfolio::latest()->get()
            ),

            'chooseus' => Inertia::defer(
                fn() =>
                ChooseUs::latest()->get()
            ),

            'faqs' => Inertia::defer(
                fn() =>
                Faq::latest()->get()
            ),
        ]);
    }

    // backend 
    public function index()
    {
        return Inertia::render('BackEnd/Home/HomeCarousel', [
            'carousels' => HomeCarousel::latest()->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image',
            'is_active' => 'required|boolean',
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/carousel', 'public');
        }

        HomeCarousel::create($data);

        return back()->with('status', 'Carousel created');
    }

    public function update(Request $request, HomeCarousel $homeCarousel)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image',
            'is_active' => 'required|boolean',
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {

            if ($homeCarousel->image && Storage::disk('public')->exists($homeCarousel->image)) {
                Storage::disk('public')->delete($homeCarousel->image);
            }

            $data['image'] = $request->file('image')->store('images/carousel', 'public');
        } else {
            unset($data['image']);
        }

        $homeCarousel->update($data);

        return back()->with('status', 'Carousel updated');
    }

    public function destroy(HomeCarousel $homeCarousel)
    {
        if ($homeCarousel->image && Storage::disk('public')->exists($homeCarousel->image)) {
            Storage::disk('public')->delete($homeCarousel->image);
        }

        $homeCarousel->delete();

        return back()->with('status', 'Deleted');
    }
}
