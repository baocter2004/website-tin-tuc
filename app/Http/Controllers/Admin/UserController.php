<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest('id')->paginate(5);
        return view('admin.users.index', compact(['users']));
    }

    public function create()
    {
        $roles = User::USER_ROLE;
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $storeUserRequest)
    {
        try {
            $data = $storeUserRequest->except('image');
            $imagePath = null;

            if ($storeUserRequest->hasFile('image')) {
                $imagePath = Storage::put('users', $storeUserRequest->file('image'));
                $data['image'] = $imagePath;
            }

            User::create($data);

            return redirect()->route('admin.users.index')->with('success', 'Thêm Mới Thành Công !');
        } catch (\Throwable $th) {
            if ($imagePath) {
                Storage::delete($imagePath);
            }
            return redirect()->back()->withErrors('errors', 'Thêm Mới Không Thành Công');
        }
    }


    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.users.show', compact('user'));
        } catch (\Throwable $th) {
            return back()->with('errors', 'Không Thành Công !!!');
        }
    }

    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = User::USER_ROLE;
            return view('admin.users.edit', compact(['user', 'roles']));
        } catch (\Throwable $th) {
            return back()->with('errors', 'Không Thành Công !!!');
        }
    }


    public function update(UpdateUserRequest $updateUserRequest, string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $oldImage = $user->image;

            $data = $updateUserRequest->except('image');

            $data['is_active'] = isset($data['is_active']) ? $data['is_active']  : 0;

            if ($updateUserRequest->hasFile('image')) {
                $data['image'] = Storage::put('users', $updateUserRequest->file('image'));
            }

            $user->update($data);

            if (
                !empty($oldImage)
                && $updateUserRequest->hasFile('image')
                && Storage::exists($oldImage)
            ) {
                Storage::delete($oldImage);
            }

            DB::commit();

            return redirect()->route('admin.users.edit', $user->id)->with('success', 'Thêm Mới Thành Công !');
        } catch (\Throwable $th) {
            return back()->with('errors', 'Lỗi không sửa được !!!');
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            $user->update(['is_active' => 0]);

            return redirect()->route('admin.users.index')->with('success', 'Xóa Thành Công !!!');
        } catch (\Throwable $th) {
            return back()->with('errors', 'Không tìm thấy !!!');
        }
    }

    public function forceDestroy(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            $user->forceDelete();

            if (Storage::exists($user->image)) {
                Storage::delete($user->image);
            }

            DB::commit();
            return redirect()->route('admin.users.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('errors', 'Xóa Không Thành Công !!!');
        }
    }

    public function trash()
    {
        $users = User::latest('id')->onlyTrashed()->paginate(5);
        return view('admin.users.trash', compact(['users']));
    }

    public function restore(string $id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);

            $user->restore();

            $user->update(['is_active' => 1]);

            return redirect()->route('admin.users.index')->with('success', 'Khôi Phục Thành Công !!!');
        } catch (\Throwable $th) {
            return back()->with('errors', 'Có Lỗi Xảy Ra !!!');
        }
    }
}
