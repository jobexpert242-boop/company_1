<?php

namespace App\Http\Controllers\BackEnd\CompanyLogo;

use App\Http\Controllers\Controller;
use App\Models\CompanyLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CompanyLogoController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/CompanyLogo/CompanyLogo', [
            'logos' => CompanyLogo::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'link' => 'nullable|string',
            'image' => 'nullable|image',
            'is_active' => 'required|boolean'
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/company-logos', 'public');
        }

        CompanyLogo::create($data);

        return back()->with('status', 'Logo created');
    }

    public function update(Request $request, CompanyLogo $companyLogo)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'link' => 'nullable|string',
            'image' => 'nullable|image',
            'is_active' => 'required|boolean'
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {

            // delete old
            if ($companyLogo->image && Storage::disk('public')->exists($companyLogo->image)) {
                Storage::disk('public')->delete($companyLogo->image);
            }

            $data['image'] = $request->file('image')->store('images/company-logos', 'public');
        } else {
            // keep old image
            unset($data['image']);
        }

        $companyLogo->update($data);

        return back()->with('status', 'Logo updated');
    }

    public function destroy(CompanyLogo $companyLogo)
    {
        if ($companyLogo->image && Storage::disk('public')->exists($companyLogo->image)) {
            Storage::disk('public')->delete($companyLogo->image);
        }

        $companyLogo->delete();

        return back()->with('status', 'Deleted');
    }
}
