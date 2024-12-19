<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest('id')->paginate(5);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
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
                Rule::unique('categories', 'slug')
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

            while (Category::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '_' . $counter++;
            }

            Category::create($data);
            return redirect()->route('admin.categories.index')->with('success', "Thêm Mới Thành Công");
        } catch (\Throwable $th) {
            return back()->with('errors', false);
        }
    }
    public function show(string $id)
    {
        try {
            $category = Category::findOrFail($id);

            return view('admin.categories.show', compact('category'));
        } catch (\Throwable $th) {
            return back()->with('errors', false);
        }
    }
    public function edit(string $id)
    {
        try {
            $category = Category::findOrFail($id);

            return view('admin.categories.edit', compact('category'));
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
                Rule::unique('categories', 'slug')->ignore($id)
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

            while (Category::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                $data['slug'] = $originalSlug . '_' . $counter++;
            }

            $category = Category::findOrFail($id);
            $category->update($data);
            return redirect()->route('admin.categories.index')->with('success', "Sửa Thành Công");
        } catch (\Throwable $th) {
            // return back()->withErrors($th->getMessage());
            return back()->with('errors', false);
        }
    }
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', "Xóa Thành Công");
        } catch (\Throwable $th) {
            return back()->with('errors', false);
        }
    }

    public function forceDestroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->forceDelete();
            return back()->with('success', 'Xóa Thành Công');
        } catch (\Throwable $th) {
            return back()->with('errors', false);
        }
    }
    public function trash()
    {
        $categories = Category::onlyTrashed()->latest('id')->paginate(5);
        return view('admin.categories.trash', compact('categories'));
    }

    public function restore(string $id)
    {
        try {
            $category = Category::onlyTrashed()->findOrFail($id);
            $category->restore();
            return redirect()->route('admin.categories.index')->with('success', 'khôi phục thành công!!!');
        } catch (\Throwable $th) {
            // return back()->withErrors($th->getMessage());
            return back()->with('errors', false);
        }
    }
}
