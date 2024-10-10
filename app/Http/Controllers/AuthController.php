<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Login
    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {

        $user = $request->only(keys: ['email', 'password']);

        //xac thuc thong tin cua user
        if (Auth::attempt($user)) {
            return redirect()->route('user.list');
        } else {
            return redirect()->back()->with('message', 'Login false');
        }
    }

    public function getRegister()
    {

        return view('register');
    }

    public function postRegister(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3', 'unique:users'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
            'confirm_password' => ['required', 'same:password'],
            'active' => ['in: 1,2'],
            'role' =>  ['in:admin,user']
        ]);



        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('user_images');
        } else {
            $data['avatar'] = '';
        }

        User::query()->create($data);



        return  redirect()->route('login')->with('message', 'Register success');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
