<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::orderBy('id')->get();
        return view('user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {

    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {

    // }

    public function postAlterPass(Request $request)
    {
        $user = User::query()->where('email', $request->email)->first();
        if ($user) {

            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required', 'min:6'],
                'confirm_password' => ['required', 'same:password'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $password = $request->password;
            $confirm_password = $request->confirm_password;

            if ($password == $confirm_password) {
                $user->password = Hash::make($password);
                $user->save();
                return redirect()->back()->with([
                    'success' => 'password changed',
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => 'new password and confirm password not same',
                ]);
            }
        } else {
            return redirect()->back()->with([
                'error' => 'email is error',
            ]);
        }

        // if ($email) {

        // }

        // return view('user.alter-pass');
    }

    public function changePass()
    {
        return view('user.alter-pass');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::query()->findOrFail($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::query()->findOrFail($id);
        return view('user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::query()->findOrFail($id);

        if (empty($user)) {
            return redirect()->route('user.index')->with('error', 'Product not found');
        }


        $rules = [
            'name' => 'required',
            'email' => 'email|required|unique:users,email,' . $user->id,
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('user.edit', $user->id)->withErrors($validator)->withInput();
        }
        $user->role = $request->role;
        $user->active = $request->active ?? 1;
        $user->name = $request->name;
        $user->email = $request->email;


        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('user_images');
        }

        $user->save();
        return redirect()->route('user.edit', $user->id)->with('success', 'Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
