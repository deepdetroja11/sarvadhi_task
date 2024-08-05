<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function getRegisterForm()
    {
        return view('register');
    }

    public function userRegister(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        try {
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => '0',
            ]);
            return redirect()->route('login')->with('success', 'User Register successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while register Please try again.');
        }
    }

    public function getLoginForm()
    {
        return view('login');
    }

    public function loginUser(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if ($user->role === '1') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('user.dashboard');
                }
            } else {
                return redirect()->back()->withErrors(['email' => 'The provided credentials are incorrect.']);
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred during login. Please try again.');
        }
    }

    public function userLogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
