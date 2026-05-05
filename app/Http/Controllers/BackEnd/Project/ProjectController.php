<?php

namespace App\Http\Controllers\BackEnd\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/Project/Project', [
            'projects' => Project::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icon' => 'required|string',
            'number' => 'required|integer|digits_between:1,10',
            'name' => 'required|string',
            'is_active' => 'required|boolean'
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        Project::create($data);

        return back()->with('status', 'Project created');
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'icon' => 'required|string',
            'number' => 'required|integer|digits_between:1,10',
            'name' => 'required|string',
            'is_active' => 'required|boolean'
        ]);

        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        $project->update($data);

        return back()->with('status', 'Project updated');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with('status', 'Deleted');
    }
}
