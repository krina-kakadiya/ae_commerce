<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    public function showLogin() {
        return view('admin.pages.auth.login');
    }

    public function doLogin(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator);
        }

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
                return redirect()->route('admin.dashboard')->with('message', 'You are logged in as admin!');
        }
        return redirect()->route('admin.login')->withInput()->with(['message' => 'Invalid Credentials, Please Try Again !']);
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with(['message' => 'Admin has been logged out successfully!']);
    }

    public function adminDashboard() {
        $categoryCount = Category::all()->count();
        $productCount = Product::all()->count();
        $userCount = User::all()->count();
        $orderCount = Order::all()->count();
        return view('admin.pages.dashboard.index',compact('categoryCount','productCount','userCount','orderCount'));
    }
}
