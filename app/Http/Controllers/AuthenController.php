<?php

namespace App\Http\Controllers;

use App\Events\RegisterSuccessed;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class AuthenController extends Controller
{
    public function showFormRegister()
    {
        return view('auth.register');
    }
    public function handleRegister()
    {
        $data = request()->validate([
            "first_name" => ['required'],
            "last_name" => ['required'],
            "email" => [
                'required',
                Rule::unique('users'),
                'email'
            ],
            "password" => [
                'required',
                'confirmed',
                'string',
                'min:8', // Độ dài tối thiểu
                'regex:/[a-z]/', // Ít nhất 1 chữ cái thường
                'regex:/[0-9]/', // Ít nhất 1 chữ số
                'regex:/[\W_]/', // Ít nhất 1 ký tự đặc biệt
            ],
        ]);

        try {
            $data['password'] = Hash::make(request('password'));
            $user = User::query()->create($data);

            Auth::login($user);

            RegisterSuccessed::dispatch($user);

            request()->session()->regenerate();

            return redirect()->route('client.index')->with('success', true);
        } catch (\Throwable $th) {
            // return back()->withErrors($th->getMessage());
            return back()->with('success', false);
        }
    }
    public function showFormLogin()
    {
        return view('auth.login');
    }
    public function handleLogin()
    {
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = request()->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            request()->session()->regenerate();

            /**
             * @var User
             */
            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('client.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }
    public function verify($id, $hash)
    {
        $user = User::findOrFail($id);

        // Kiểm tra hash và email
        if (sha1($user->email) === $hash) {
            // Xác nhận email
            $user->email_verified_at = now();
            $user->is_active = 1;
            $user->save();

            return redirect()->route('client.index')->with('success', 'Email của bạn đã được xác thực.');
        }

        return redirect()->route('index')->with('error', 'Liên kết xác thực không hợp lệ.');
    }
}
