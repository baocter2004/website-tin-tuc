<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Media;
use App\Models\mediums;
use App\Models\Paragraph;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ParagraphController extends Controller
{
    public function index()
    {
        $paragraphs = Paragraph::with('mediums', 'article')
            ->orderBy('order')
            ->orderBy('id')
            ->paginate(5);

        return view('admin.articles.paragraphs.index', compact('paragraphs'));
    }
    public function create()
    {
        $articles = Article::select('id', 'title')->get();
        return view('admin.articles.paragraphs.create', compact('articles'));
    }

    public function store()
    {
        request()->validate([
            'order' =>  [
                'required',
                'numeric',
                'min:1',
                'max:5'
            ],
            'article_id' => [
                'required',
                'numeric',
                Rule::exists('articles', 'id')
            ],
            'paragraph' => [
                'required',
                'string',
            ],
            'file_path' => [
                'required',
                'array'
            ],
            'file_path.*' => [
                'required',
                'image',
                'max:2048'
            ]
        ]);
        DB::beginTransaction();
        try {
            $dataParagraph = [
                'order' => request('order'),
                'article_id' => request('article_id'),
                'paragraph' => request('paragraph'),
            ];
            $paragraph = Paragraph::create($dataParagraph);

            if ($paragraph) {
                foreach (request('file_path') as $file_path) {
                    Media::create([
                        'paragraph_id' => $paragraph->id,
                        'file_path' => Storage::put('articles/paragraphs', $file_path)
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('admin.paragraphs.index')
                ->with('success', 'Thêm Mới Thành Công');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::debug("message " . $th->getMessage());
            return back()->withErrors([
                'message' => 'Có Lỗi Xảy Ra !!!'
            ]);
        }
    }

    public function show(string $id)
    {
        try {
            $paragraph = Paragraph::with('mediums', 'article')->findOrFail($id);
            return view('admin.articles.paragraphs.show', compact('paragraph'));
        } catch (\Throwable $th) {
            Log::debug("message " . $th->getMessage());
            return back()->withErrors([
                'message' => 'Có Lỗi Xảy Ra !!!'
            ]);
        }
    }
    public function edit(string $id)
    {
        try {
            $paragraph = Paragraph::with('mediums', 'article')->findOrFail($id);
            $articles = Article::select('id', 'title')->get();
            return view('admin.articles.paragraphs.edit', compact(['paragraph', 'articles']));
        } catch (\Throwable $th) {
            Log::debug("message " . $th->getMessage());
            return back()->withErrors([
                'message' => 'Có Lỗi Xảy Ra !!!'
            ]);
        }
    }
    public function update(string $id)
    {
        request()->validate([
            'order' => [
                'required',
                'numeric',
                'min:1',
                'max:5',
                Rule::unique('paragraphs')->where(function ($query) {
                    return $query->where('article_id', request('article_id'));
                })->ignore($id, 'id')
            ],
            'article_id' => [
                'required',
                'numeric',
                Rule::exists('articles', 'id')
            ],
            'paragraph' => [
                'required',
                'string',
            ],
            'file_path' => [
                'nullable',
                'array'
            ],
            'file_path.*' => [
                'nullable',
                'image',
                'max:2048'
            ]
        ]);

        DB::beginTransaction();

        try {
            // Cập nhật thông tin paragraph
            $dataParagraph = [
                'order' => request('order'),
                'article_id' => request('article_id'),
                'paragraph' => request('paragraph'),
            ];

            $paragraph = Paragraph::with('mediums')->findOrFail($id);
            $paragraph->update($dataParagraph);

            // Kiểm tra nếu request('file_path') có dữ liệu và là mảng
            if (is_array(request('file_path')) && count(request('file_path')) > 0) {
                foreach (request('file_path') as $id => $file_path) {
                    $media = Media::find($id);
                    if ($media) {
                        $oldImage = $media->file_path;

                        $filePath = Storage::put('articles/paragraphs', $file_path);
                        $media->update([
                            'paragraph_id' => $paragraph->id,
                            'file_path' => $filePath,
                        ]);

                        if ($oldImage && Storage::exists($oldImage)) {
                            Storage::delete($oldImage);
                        }
                    } else {
                        $filePath = Storage::put('articles/paragraphs', $file_path);
                        Media::create([
                            'paragraph_id' => $paragraph->id,
                            'file_path' => $filePath,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.paragraphs.index')
                ->with('success', 'Cập Nhật Thành Công');
        } catch (\Throwable $th) {
            // Rollback nếu có lỗi
            DB::rollBack();
            Log::debug("message " . $th->getMessage());
            return back()->withErrors([
                'message' => 'Có Lỗi Xảy Ra !!!' . $th->getMessage()
            ]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $paragraph = Paragraph::with('mediums')->findOrFail($id);

            foreach ($paragraph->mediums as $value) {
                $value->delete();
            }
            $paragraph->delete();

            return view('admin.articles.paragraphs.index')->with('success', 'Xóa Thành Công !!!');
        } catch (\Throwable $th) {
            Log::debug("message " . $th->getMessage());
            return back()->withErrors([
                'message' => 'Có Lỗi Xảy Ra !!!' .  $th->getMessage()
            ]);
        }
    }
    public function forceDestroy(string $id)
    {
        try {
            $paragraph = Paragraph::onlyTrashed()->with('mediums')->findOrFail($id);

            foreach ($paragraph->mediums  as $value) {
                $media = Media::onlyTrashed()->findOrFail($value->id);

                $media->forceDelete();
            }
            $paragraph->forceDelete();

            return redirect()->route('admin.paragraphs.index')->with('success', 'Xóa Thành Công !!!');
        } catch (\Throwable $th) {
            Log::debug("message " . $th->getMessage());
            return back()->withErrors([
                'message' => 'Có Lỗi Xảy Ra !!!' .  $th->getMessage()
            ]);
        }
    }

    public function trash()
    {
        $paragraphs = Paragraph::onlyTrashed()
            ->with(['mediums' => function ($query) {
                $query->onlyTrashed();
            }, 'article'])
            ->orderBy('order')
            ->orderBy('id')
            ->paginate(5);

        return view('admin.articles.paragraphs.trash', compact('paragraphs'));
    }

    public function restore(string $id)
    {
        try {
            $paragraph = Paragraph::onlyTrashed()->findOrFail($id);

            $paragraph->restore();

            foreach ($paragraph->mediums as $media) {
                $media->restore();
            }

            return redirect()->route('admin.paragraphs.index')->with('success', 'Khôi phục Thành Công!');
        } catch (\Throwable $th) {
            Log::debug("message " . $th->getMessage());
            return back()->withErrors([
                'message' => 'Có Lỗi Xảy Ra !!!' .  $th->getMessage()
            ]);
        }
    }
}
