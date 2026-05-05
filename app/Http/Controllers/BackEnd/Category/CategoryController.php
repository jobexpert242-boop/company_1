<?php

namespace App\Http\Controllers\BackEnd\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('BackEnd/Category/Category', [
            'categories' => Category::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'is_active' => 'required|boolean',
        ]);
        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        Category::create($data);

        return back()->with('status', 'Category created');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'is_active' => 'required|boolean',
        ]);
        $data['is_active'] = $request->input('is_active') ? 1 : 0;

        $category->update($data);

        return back()->with('status', 'Category updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('status', 'Category deleted');
    }
}
