<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function testing(Request $request)
    {
        $data1 = 12;
        $data2 = 12;
        $result = $this->sum($data1, $data2);

        return $this->secondControllerMethod($result);
    }

    public function sum($data1, $data2)
    {
        return $data1 + $data2;
    }

    public function secondControllerMethod($result)
    {
        return "Result from second controller method: $result";
    }


    public function redirect(Request $request)
    {
        $data['pageTitle'] = "Dashboard";
        return view('admin.login', $data);
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = "Dashboard";
        return view('admin.login', $data);
    }

    public function profile(Request $request)
    {
        $data['pageTitle'] = "Profile";
        if (request()->isMethod("post")) {
            $name = $request->input('name');
            $email = $request->input('email');
            $userId = $request->input('userId');

            Admin::whereId($userId)->update([
                "name" => $name,
                "email" => $email
            ]);

            return redirect()->back()->with('message', 'Profile Updated Successfully!');
        }
        return view('admin.dashboard.profile', $data);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'confirmed' => 'required',
            'new_password' => 'required|same:confirmed',
        ]);

        Admin::whereId(Auth::guard('adminLogin')->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        Driver::where('email', Auth::guard('adminLogin')->user()->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("message", "Password changed successfully!");
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required:rfc',
            'password' => 'required'
        ]);

        if (DB::table('admins')->where('status', '1')->where('email', $request->input('email'))->first()) {
            if (Auth::guard('adminLogin')->attempt($request->only('email', 'password'))) {
                return redirect()->intended(route('admin.dashboard'))->with('status', 'You are Logged in as Admin!');
            } else {
                return redirect()->back()->withInput()->with('success', 'Login failed, please try again!');
            }
        } else {
            return redirect()->back()->withInput()->with('success', 'This account is not active please contact to admin');
        }
    }

    public function logout()
    {
        $data['pageTitle'] = "logout";
        Auth::guard('adminLogin')->logout();
        return redirect('/admin/');
    }
}
