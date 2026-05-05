<?php

namespace App\Http\Controllers\BackEnd\Banner;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BannerController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/Banner/Banner', [
            'banner' => Banner::first()
        ]);
    }

    public function store(Request $request)
    {
        $fields = [
            'about_image',
            'team_image',
            'service_image',
            'portfolio_image',
            'contact_image',
            'portfoliodetailes_image',
            'project_image',
            'booking_image',
        ];

        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'about_image' => 'nullable|image',
            'team_image' => 'nullable|image',
            'service_image' => 'nullable|image',
            'portfolio_image' => 'nullable|image',
            'contact_image' => 'nullable|image',
            'portfoliodetailes_image' => 'nullable|image',
            'project_image' => 'nullable|image',
            'booking_image' => 'nullable|image',
        ]);

        $banner = Banner::first();

        foreach ($fields as $field) {

            if ($request->hasFile($field)) {

                // delete old image if exists
                if ($banner && $banner->$field && Storage::disk('public')->exists($banner->$field)) {
                    Storage::disk('public')->delete($banner->$field);
                }

                // store new image
                $data[$field] = $request->file($field)->store('images/banners', 'public');
            } else {
                unset($data[$field]);
            }
        }

        if ($banner) {
            $banner->update($data);
        } else {
            Banner::create($data);
        }

        return back()->with('status', 'Banner saved successfully');
    }
}
