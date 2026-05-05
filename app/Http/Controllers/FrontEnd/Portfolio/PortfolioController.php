<?php

namespace App\Http\Controllers\FrontEnd\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function portfolio()
    {
        return Inertia::render('FrontEnd/Portfolio/Portfolio', [
            'categories' => Category::latest()->get(),
            'portfolios' => Portfolio::latest()->get(),
        ]);
    }

    public function portfolioDetails($slug)
    {
        $portfolio = Portfolio::with(['images', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        return Inertia::render('FrontEnd/Portfolio/PortfolioDetails', [
            'portfolio' => $portfolio,
            'recent' => Portfolio::latest()->get(),
        ]);
    }
}
