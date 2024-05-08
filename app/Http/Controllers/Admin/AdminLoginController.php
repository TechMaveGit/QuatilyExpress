<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Driver;
use Auth;
use Redirect;
use Validator;
use Hash;
use DB;

class AdminLoginController extends Controller
{
    public function testing(Request $request)
    {
        $data1 = 12;
        $data2 = 12;
        // Call the sum method from the same controller
        $result = $this->sum($data1, $data2);

        // Redirect to another controller method with the result
        return $this->secondControllerMethod($result);
    }

    public function sum($data1, $data2)
    {
        return $data1 + $data2;
    }

    public function secondControllerMethod($result)
    {
        // Process $result in the second controller method
        return "Result from second controller method: $result";
    }


    public function redirect(Request $request)
    {
        $data['pageTitle']="Dashboard";
        return view('admin.login',$data);
    }

    public function index(Request $request)
    {
       // echo "ok"; die;
        $data['pageTitle']="Dashboard";
        return view('admin.login',$data);
    }

    public function profile(Request $request)
    {
        $data['pageTitle']="Profile";
        if(request()->isMethod("post"))
        {
          //  return $request->all();

            $name=$request->input('name');
            $email=$request->input('email');
            $userId=$request->input('userId');

            Admin::whereId($userId)->update([
                                                "name"=>$name,
                                                "email"=>$email
                                            ]);

         return Redirect::back()->with('message', 'Profile Updated Successfully!');

        }
        return view('admin.dashboard.profile',$data);
    }


    public function updatePassword(Request $request)
        {
                # Validation
                $request->validate([
                    'old_password' => 'required',
                    'confirmed' => 'required',
                    'new_password' => 'required|same:confirmed',
                ]);

                #Match The Old Password


                #Update the new Password
                Admin::whereId( Auth::guard('adminLogin')->user()->id)->update([
                    'password' => Hash::make($request->new_password)
                ]);

                Driver::where('email',Auth::guard('adminLogin')->user()->email)->update([
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

        if(DB::table('admins')->where('status','1')->where('email',$request->input('email'))->first())
        {
            if(Auth::guard('adminLogin')->attempt($request->only('email','password')))
            {
            //    return redirect()->route('dashboard');
                //Authentication passed...
                return redirect()
                    ->intended(route('admin.dashboard'))
                    ->with('status','You are Logged in as Admin!');
            }
            else
            {
                return redirect()->back()->withInput()->with('success' , 'Login failed, please try again!');

            }
        }
        else{
            return redirect()->back()->withInput()->with('success' , 'This account is not active please contact to admin');
        }
    }
    public function logout()
    {
          $data['pageTitle'] = "logout";
          Auth::guard('adminLogin')->logout();
		  return redirect('/admin/');
    }


}
