<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
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
            if ($storeUserRequest->hasFile('image')) {
                $data['image'] = Storage::put('users', $storeUserRequest->file('image'));
            }

            User::create($data);

            return redirect()->route('admin.users.index')->with('success', 'Thêm Mới Thành Công !');
        } catch (\Throwable $th) {
            // return back()->withErrors($th->getMessage());
            return redirect()->back()->with('errors', 'Thêm Mới Không Thành Công');
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.users.show', compact('user'));
        } catch (\Throwable $th) {
            return back()->with('errors', 'Không tìm thấy !!!');
        }
    }

    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = User::USER_ROLE;
            return view('admin.users.edit', compact(['user', 'roles']));
        } catch (\Throwable $th) {
            return back()->with('errors', 'Không tìm thấy !!!');
        }
    }


    public function update(UpdateUserRequest $updateUserRequest, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $oldImage = $user->image;

            $data = $updateUserRequest->except('image');

            if ($updateUserRequest->hasFile('image')) {
                $data['image'] = Storage::put('users', $updateUserRequest->file('image'));
            }

            if (
                !empty($oldImage)
                && $updateUserRequest->hasFile('image')
                && Storage::exists($oldImage)
            ) {
                Storage::delete($oldImage);
            }

            $user->update($data);

            return redirect()->route('admin.users.edit', $user->id)->with('success', 'Thêm Mới Thành Công !');
        } catch (\Throwable $th) {
            return back()->with('errors', 'Lỗi không sửa được !!!');
        }
    }
}
