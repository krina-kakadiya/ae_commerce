<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function userLogin(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'         => 'required|email|min:10|max:50',
            'password'      => 'required|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator);
        }

        if (Auth::guard('user')->attempt($request->only('email', 'password'))) {
            $status = Auth::guard('user')->user()->user_status;
            $userName =  Auth::guard('user')->user()->name;

            if ($status == 0) {
                return redirect()->route('user.home')->with(['message' => $userName . " you are login successfully !"]);
            } else {
                Auth::guard('user')->logout();
                return redirect()->route('user.home')->with(['message' => $userName . " you are not authorized by admin ! "]);
            }
        }
        return redirect()->route('user.home')->withInput()->with(['message' => 'Login failed, invalid credentials!']);
    }

    public function logout() {
        $userName =  Auth::guard('user')->user()->name;
        Auth::guard('user')->logout();
        return redirect()->route('user.home')->with(['message' => $userName . " you are logged out successfully ! "]);
    }

    public function registerView() {
        return view('user.pages.auth.register');
    }

    public function checkMail(Request $request) {
        $id = $request->id;
        if (!empty($id)) {
            $rules = array('email' => 'required|min:5|max:50|unique:users,email,' . $id . ',id');
        } else {
            $rules = array('email' => 'required|min:5|max:50|unique:users');
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|min:5',
            'email'         => 'required|email|min:10|max:50',
            'password'      => 'required|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            Auth::guard('user')->login($user);
            Session::flash('message', "$user->name , you are register & login successfully.");
            return redirect()->route('user.home');
        }
    }

    public function profileView() {
        $auth =  Auth::guard('user')->user();
        return view('user.pages.auth.profile', compact('auth'));
    }

    public function updateProfile(Request $request) {
        $id =  Auth::guard('user')->user()->id;
        $validator = Validator::make($request->all(), [
            'name'         => 'required|min:5',
            'email'         => 'required|email|min:10|max:50|unique:users,email,' . $id . ',id',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator);
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return redirect()->route('user.profile.view')->with(['message' => "Profile update successfully !"]);
    }

    public function changePassword(Request $request) {
        // # Validation
        $validator = Validator::make($request->all(), [
            'old_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_password_confirmation' => ['same:new_password'],
        ]);
        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator);
        }
        User::find(auth()->guard('user')->user()->id)->update(['password' => Hash::make($request->new_password)]);
        return redirect()->route('user.profile.view')->with(['message' => "Password change successfully !"]);
    }
}
