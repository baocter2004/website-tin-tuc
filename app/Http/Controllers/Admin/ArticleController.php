<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('tags', 'paragraphs')->latest('id')->paginate(5);
        return view('admin.articles.index', compact('articles'));
    }
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();
        $statuses = Article::STATUSES;
        return view('admin.articles.create', compact(['categories', 'tags', 'statuses']));
    }
    public function store(StoreArticleRequest $storeArticleRequest)
    {
        DB::beginTransaction();
        try {
            $dataArticle = [
                'title' => $storeArticleRequest->title,
                'category_id' => $storeArticleRequest->category_id,
                'content' => $storeArticleRequest->content,
                'summary' => $storeArticleRequest->summary,
                'status' => $storeArticleRequest->status
            ];
            $imagePath = null;

            if ($storeArticleRequest->hasFile('image')) {
                $imagePath = Storage::put('articles', $storeArticleRequest->file('image'));
                $dataArticle['image'] = $imagePath;
            }

            if (empty($dataArticle['slug'])) {
                $dataArticle['slug'] = Str::slug($dataArticle['title'], "_");
            }

            // Kiểm tra tính duy nhất của slug (nếu cần)
            $originalSlug = $dataArticle['slug'];

            $counter = 1;

            while (Article::where('slug', $dataArticle['slug'])->exists()) {
                $dataArticle['slug'] = $originalSlug . '_' . $counter++;
            }

            if (Auth::check()) {
                $dataArticle['auth_id'] = auth()->id();
            } else {
                return redirect()->route('auth.login')->withErrors([
                    'message' => 'Bạn Cần Đăng Nhập !!'
                ]);
            }

            if ($dataArticle['status'] === 'deleted') {
                $dataArticle['delete_reason'] = $storeArticleRequest->delete_reason;
            }

            if ($dataArticle['status'] === Article::STATUSES[1]) {
                $dataArticle['publish_at'] = now();
            }

            $article = Article::query()->create($dataArticle);

            if (!empty(request('tags'))) {
                $article->tags()->sync($storeArticleRequest->tags);
            }

            if (!empty(request('tags'))) {
                $article->tags()->sync($storeArticleRequest->tags);
            }

            if (!empty($storeArticleRequest->new_tags)) {
                foreach ($storeArticleRequest->new_tags as $tagName) {
                    if (empty($tagName)) {
                        continue;
                    }

                    $slug = Str::slug($tagName, "_");
                    $originalSlug = $slug;
                    $counter = 1;
                    while (Tag::where('slug', $slug)->exists()) {
                        $slug = $originalSlug . '_' . $counter++;
                    }
                    $tag = Tag::firstOrCreate(['name' => $tagName], ['slug' => $slug]);
                    $article->tags()->syncWithoutDetaching($tag->id);
                }
            }

            DB::commit();

            return redirect()->route('admin.articles.index')->with('success', 'Thêm Thành Công!!!');
        } catch (\Throwable $th) {
            DB::rollBack();

            if ($imagePath) {
                Storage::delete($imagePath);
            }

            Log::error("Lỗi : - " . $th->getMessage());

            return back()->withErrors(['message' => 'Có Lỗi !!!']);
        }
    }
    public function show(string $id)
    {
        try {
            $article = Article::with('tags', 'paragraphs')->findOrFail($id);
            return view('admin.articles.show', compact('article'))->with('success', 'Tìm Thành Công !!!');
        } catch (\Throwable $th) {
            Log::error("Lỗi : - " . $th->getMessage());

            return back()
                ->withErrors([
                    'message' => 'Có Lỗi Xảy Ra Rồi !!!'
                ]);
        }
    }

    public function edit(string $id)
    {
        try {
            $article = Article::with('tags')->findOrFail($id);
            $categories = Category::select('id', 'name')->get();
            $tags = Tag::select('id', 'name')->get();
            $articleTags = $article->tags->pluck('id')->all();
            $statuses = Article::STATUSES;
            return view('admin.articles.edit', compact(['article', 'categories', 'tags', 'statuses', 'articleTags']))
                ->with('success', 'Tìm Thành Công !!!');
        } catch (\Throwable $th) {
            Log::error("Lỗi : - " . $th->getMessage());

            return back()
                ->withErrors([
                    'message' => 'Có Lỗi Xảy Ra Rồi !!!'
                ]);
        }
    }

    public function update(UpdateArticleRequest $updateArticleRequest, string $id)
    {
        DB::beginTransaction();
        try {
            $article = Article::findOrFail($id);
            $oldImage = $article->image;

            $dataArticle = [
                'title' => $updateArticleRequest->title,
                'category_id' => $updateArticleRequest->category_id,
                'content' => $updateArticleRequest->content,
                'summary' => $updateArticleRequest->summary,
                'status' => $updateArticleRequest->status
            ];

            if ($updateArticleRequest->hasFile('image')) {
                $imagePath = Storage::put('articles', $updateArticleRequest->file('image'));
                $dataArticle['image'] = $imagePath;
            }

            // Xử lý slug nếu tiêu đề thay đổi hoặc slug trống
            if (empty($dataArticle['slug']) || $dataArticle['title'] !== $article->title) {
                $dataArticle['slug'] = Str::slug($dataArticle['title'], "_");

                $originalSlug = $dataArticle['slug'];
                $counter = 1;

                while (Article::where('slug', $dataArticle['slug'])->where('id', '!=', $id)->exists()) {
                    $dataArticle['slug'] = $originalSlug . '_' . $counter++;
                }
            }

            if (Auth::check()) {
                $dataArticle['auth_id'] = auth()->id();
            } else {
                return redirect()->route('auth.login')->withErrors([
                    'message' => 'Bạn Cần Đăng Nhập !!'
                ]);
            }

            if ($dataArticle['status'] === 'deleted') {
                $dataArticle['delete_reason'] = $updateArticleRequest->delete_reason;
            }

            if ($dataArticle['status'] === Article::STATUSES[1]) {
                $dataArticle['publish_at'] = now();
            }

            $article->update($dataArticle);

            if (
                $updateArticleRequest->hasFile('image')
                && !empty($oldImage)
                && Storage::exists($oldImage)
            ) {
                Storage::delete($oldImage);
            }

            if (!empty(request('tags'))) {
                $article->tags()->sync($updateArticleRequest->tags);
            }

            DB::commit();

            return redirect()->route('admin.articles.index')->with('success', 'Cập Nhật Thành Công!!!');
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($imagePath)) {
                Storage::delete($imagePath);
            }
            Log::error("Lỗi : - " . $th->getMessage());

            return back()->withErrors(['message' => 'Có Lỗi !!!']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->delete();

            return redirect()->route('admin.articles.index')
                ->with('success', 'xóa thành công');
        } catch (\Throwable $th) {
            Log::error("Lỗi : - " . $th->getMessage());

            return back()->withErrors(['message' => 'Có Lỗi !!!']);
        }
    }

    public function forceDestroy(string $id)
    {
        DB::beginTransaction();
        try {
            $article = Article::findOrFail($id);
            $article->tags()->sync([]);
            $article->forceDelete();

            DB::commit();
            return redirect()->route('admin.articles.index')
                ->with('success', 'xóa thành công');
        } catch (\Throwable $th) {
            Log::error("Lỗi : - " . $th->getMessage());

            DB::rollBack();
            return back()->withErrors(['message' => 'Có Lỗi !!!']);
        }
    }
    public function trash()
    {
        $articles = Article::with('user', 'tags', 'category')->onlyTrashed()->latest('deleted_at')->paginate(5);
        return view('admin.articles.trash', compact('articles'));
    }
    public function restore(string $id)
    {
        DB::beginTransaction();
        try {
            $article = Article::onlyTrashed()->findOrFail($id);
            $article->restore();
            if (!empty($article->tags)) {
                $article->tags()->sync($article->tags->pluck('id')->toArray());
            }
            DB::commit();
            return redirect()->route('admin.articles.index')->with('success', 'Khôi phục và đồng bộ tags thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Lỗi khôi phục bài viết: " . $th->getMessage());
            return back()->withErrors(['message' => 'Có lỗi xảy ra trong quá trình khôi phục!']);
        }
    }
}
