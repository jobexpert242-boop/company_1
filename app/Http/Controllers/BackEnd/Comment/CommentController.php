<?php

namespace App\Http\Controllers\BackEnd\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/Service/Comment', [
            'comments' => Comment::with('service')->latest()->paginate(10),
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
        ]);

        Comment::create($data);

        return back()->with('status', 'Comment Created');
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $data = $request->validate([
            'icon' => 'required|string',
            'title' => 'required',
            'description' => 'required',
            'service_id' => 'required|exists:services,id',
        ]);

        $comment->update($data);

        return back()->with('status', 'Comment Updated');
    }

    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();

        return back()->with('status', 'Comment Deleted');
    }
}
