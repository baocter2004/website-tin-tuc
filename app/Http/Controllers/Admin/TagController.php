<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TagController extends Controller
{

    public function index()
    {
        $tags = Tag::latest('id')->paginate(5);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }
    public function store()
    {
        $data = request()->validate([
            'name' => [
                'required',
                'string',
                'max:100'
            ],
            'slug' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('tags', 'slug')
            ]
        ]);

        try {
            // Tạo slug từ name nếu slug không được cung cấp
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name'], "_");
            }

            // Kiểm tra tính duy nhất của slug (nếu cần)
            $originalSlug = $data['slug'];

            $counter = 1;

            while (Tag::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '_' . $counter++;
            }

            Tag::create($data);
            return redirect()->route('admin.tags.index')->with('success', "Thêm Mới Thành Công");
        } catch (\Throwable $th) {
            return back()->with('errors', false);
        }
    }
    public function show(string $id)
    {
        try {
            $tag = Tag::findOrFail($id);

            return view('admin.tags.show', compact('tag'));
        } catch (\Throwable $th) {
            return back()->with('errors', false);
        }
    }
    public function edit(string $id)
    {
        try {
            $Tag = Tag::findOrFail($id);

            return view('admin.tags.edit', compact('Tag'));
        } catch (\Throwable $th) {
            return back()->with('errors', false);
        }
    }
    public function update(string $id)
    {
        $data = request()->validate([
            'name' => [
                'required',
                'string',
                'max:100'
            ],
            'slug' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('tags', 'slug')->ignore($id)
            ]
        ]);

        try {
            // sửa slug từ name nếu slug không được cung cấp
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name'], "_");
            }

            // Kiểm tra tính duy nhất của slug (nếu cần)
            $originalSlug = $data['slug'];

            $counter = 1;

            while (Tag::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                $data['slug'] = $originalSlug . '_' . $counter++;
            }

            $tag = Tag::findOrFail($id);
            $tag->update($data);
            return redirect()->route('admin.tags.index')->with('success', "Sửa Thành Công");
        } catch (\Throwable $th) {
            // return back()->withErrors($th->getMessage());
            return back()->with('errors', false);
        }
    }
    public function destroy(string $id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();
            return redirect()->route('admin.tags.index')->with('success', "Xóa Thành Công");
        } catch (\Throwable $th) {
            return back()->with('errors', false);
        }
    }

    public function forceDestroy(string $id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->forceDelete();
            return back()->with('success', 'Xóa Thành Công');
        } catch (\Throwable $th) {
            return back()->with('errors', false);
        }
    }
    public function trash()
    {
        $tags = Tag::onlyTrashed()->latest('id')->paginate(5);
        return view('admin.tags.trash', compact('tags'));
    }

    public function restore(string $id)
    {
        try {
            $tag = Tag::onlyTrashed()->findOrFail($id);
            $tag->restore();
            return redirect()->route('admin.tags.index')->with('success', 'khôi phục thành công!!!');
        } catch (\Throwable $th) {
            // return back()->withErrors($th->getMessage());
            return back()->with('errors', false);
        }
    }
}
