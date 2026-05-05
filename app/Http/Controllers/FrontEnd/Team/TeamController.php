<?php

namespace App\Http\Controllers\FrontEnd\Team;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TeamController extends Controller
{
    public function team()
    {
        return Inertia::render('FrontEnd/Team/Team', [
            'teams' => Team::latest()->get()
        ]);
    }

    public function teamDetails($id)
    {
        $team = Team::findOrFail($id);

        return Inertia::render('FrontEnd/Team/TeamDetails', [
            'team' => $team,
        ]);
    }

    // backend 
    public function index()
    {
        return Inertia::render('BackEnd/Team/Team', [
            'teams' => Team::latest()->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'podobi' => 'required|string',
            'image' => 'nullable|image',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'linkdin' => 'nullable|string',
            'youtube' => 'nullable|string',
            'email' => 'required|string',
            'website' => 'required|string',
            'description' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        // image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/teams', 'public');
        }

        Team::create($data);

        return back()->with('status', 'Team created');
    }

    public function update(Request $request, Team $team)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'podobi' => 'required|string',
            'image' => 'nullable|image',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'linkdin' => 'nullable|string',
            'youtube' => 'nullable|string',
            'email' => 'required|string',
            'website' => 'required|string',
            'description' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        // if new image uploaded
        if ($request->hasFile('image')) {

            if ($team->image && Storage::disk('public')->exists($team->image)) {
                Storage::disk('public')->delete($team->image);
            }

            $data['image'] = $request->file('image')->store('images/teams', 'public');
        } else {
            unset($data['image']);
        }

        $team->update($data);

        return back()->with('status', 'Team updated');
    }

    public function destroy(Team $team)
    {
        if ($team->image && Storage::disk('public')->exists($team->image)) {
            Storage::disk('public')->delete($team->image);
        }

        $team->delete();

        return back()->with('status', 'Team Deleted');
    }
}
