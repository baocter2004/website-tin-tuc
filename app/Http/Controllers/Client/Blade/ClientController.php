<?php

namespace App\Http\Controllers\Client\Blade;

use App\Events\ArticleViewed;
use App\Http\Controllers\Controller;
use App\Jobs\IncrementViewCount;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{

    public function index()
    {
        $baseQuery = Article::with('category', 'user', 'tags') // eager load tất cả quan hệ ngay từ đầu
            ->where('status', 'published');

        // Lấy 6 bài viết mới nhất
        $articles = (clone $baseQuery)
            ->latest('created_at')
            ->take(6)
            ->get();

        // Lấy bài viết mới nhất trong 6 bài viết đã lấy
        $articleLatest = $articles->first();

        // bài viết trending
        $articleTrending = (clone $baseQuery)
            ->orderByDesc('view_count')
            ->take(5)
            ->get();

        // Lấy 3 bài viết thuộc category name = "văn hóa"
        $category = Category::where('name', 'Văn Hóa')->first();

        // nếu tìm thấy danh mục thì thực hiện truy vấn
        if ($category) {
            // Get the latest 3 articles in the "Văn Hóa" category
            $articleCultures = (clone $baseQuery)
                ->where('category_id', $category->id)  // Use the id of the category found
                ->latest('created_at')
                ->take(3)
                ->get();

            // Get the article with the most views in the "Văn Hóa" category
            $articleCultureViewest = (clone $baseQuery)
                ->where('category_id', $category->id)
                ->orderByDesc('view_count')
                ->first();
        } else {
            $articleCultures = collect();
            $articleCultureViewest = null;
        }

        return view('client.index', compact(
            [
                'articles',
                'articleLatest',
                'articleCultures',
                'articleCultureViewest',
                'articleTrending'
            ]
        ));
    }


    public function singlePost(string $id)
    {
        try {
            $article = Article::with('category', 'user', 'tags', 'paragraphs.mediums')->findOrFail($id);
            $tags = Tag::select('name')->get();

            $userId = auth()->id() ?? null;
            $ipAddress = request()->ip();

            View::create([
                'article_id' => $article->id,
                'user_id' => $userId,
                'ip_address' => $ipAddress,
                'viewed_at' => now(),
            ]);

            ArticleViewed::dispatch($article);

            $recentArticles = $this->recentArticles();

            return view('client.single-post', compact(
                'article',
                'recentArticles',
                'tags'
            ));
        } catch (\Throwable $th) {
            Log::error('Error in singlePost method: ' . $th->getMessage());
            return back()
                ->withErrors(['message' => 'Có lỗi xảy ra, xin lỗi bạn !!!']);
        }
    }

    private function recentArticles()
    {
        try {
            $userId = Auth::check() ? Auth::id() : null;

            // Lấy các ID của bài viết gần đây và thời gian xem mới nhất
            $recentViewIds = DB::table('views')
                ->where('user_id', $userId)
                ->select('article_id', DB::raw('MAX(viewed_at) as viewed_at'))
                ->groupBy('article_id')
                ->orderBy('viewed_at', 'desc')
                ->limit(5)
                ->pluck('article_id');

            // Lấy các bài viết dựa trên các ID đã lấy từ bảng views
            $recentArticles = Article::with('category', 'user', 'tags', 'paragraphs.mediums')
                ->whereIn('id', $recentViewIds)
                ->get()
                ->unique('id');
            return $recentArticles;
        } catch (\Throwable $th) {
            Log::error('Lỗi trong phương thức recentArticles: ' . $th->getMessage());
            return back()
                ->withErrors(['message' => 'Có lỗi xảy ra, xin lỗi bạn !!!']);
        }
    }
}
