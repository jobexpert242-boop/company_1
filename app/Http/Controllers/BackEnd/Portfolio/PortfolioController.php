<?php

namespace App\Http\Controllers\BackEnd\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portfolio;
use App\Models\PortfolioImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/Portfolio/Portfolio', [
            'portfolios' => Portfolio::with('images')->latest()->get(),
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:portfolios,slug',
            'image' => 'required|image',
            'description' => 'required',
            'client_name' => 'required',
            'company_name' => 'required',
            'start_date' => 'required|date|before:end_date',
            'end_date'   => 'required|date|after:start_date',
            'client_comment' => 'required|max:255',
            'category_id' => 'required',
            'gallery' => 'nullable',
            'gallery.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // main image
        $data['image'] = $request->file('image')->store('images/portfolio', 'public');

        // REMOVE gallery from insert data
        unset($data['gallery']);

        $portfolio = Portfolio::create($data);

        // gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                PortfolioImage::create([
                    'portfolio_id' => $portfolio->id,
                    'image' => $img->store('images/portfolio/gallery', 'public'),
                ]);
            }
        }

        return back()->with('status', 'Portfolio created');
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:portfolios,slug,' . $portfolio->id,
            'image' => 'nullable|image',
            'description' => 'required',
            'client_name' => 'required',
            'company_name' => 'required',
            'start_date' => 'required|date|before:end_date',
            'end_date'   => 'required|date|after:start_date',
            'client_comment' => 'required|max:255',
            'category_id' => 'required',
            'gallery' => 'nullable',
            'gallery.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {

            // delete old image
            if ($portfolio->image && Storage::disk('public')->exists($portfolio->image)) {
                Storage::disk('public')->delete($portfolio->image);
            }

            $data['image'] = $request->file('image')->store('images/portfolio', 'public');
        } else {
            unset($data['image']);
        }

        // remove gallery from main table update
        unset($data['gallery']);

        $portfolio->update($data);

        if ($request->hasFile('gallery')) {

            foreach ($request->file('gallery') as $img) {
                PortfolioImage::create([
                    'portfolio_id' => $portfolio->id,
                    'image' => $img->store('images/portfolio/gallery', 'public'),
                ]);
            }
        }

        return back()->with('status', 'Portfolio updated successfully');
    }

    public function destroy(Portfolio $portfolio)
    {
        // delete main image
        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        // delete gallery images
        foreach ($portfolio->images as $img) {
            Storage::disk('public')->delete($img->image);
        }

        $portfolio->delete();

        return back()->with('status', 'Deleted');
    }

    public function deleteImage($id)
    {
        $img = PortfolioImage::findOrFail($id);

        Storage::disk('public')->delete($img->image);
        $img->delete();

        return back()->with('status', 'Image deleted');
    }
}
