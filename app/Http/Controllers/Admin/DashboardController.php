<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')->get();

        $labels = $categories->pluck('name');
        $data = $categories->pluck('articles_count');

        $top5ArticleViewest = Article::select('articles.*')
            ->withCount(['views' => function ($query) {
                $query->whereYear('created_at', '=', now()->year)
                    ->whereMonth('created_at', '=', now()->month);
            }])
            ->orderByDesc('views_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'labels',
            'data',
            'top5ArticleViewest'
        ));
    }
}
