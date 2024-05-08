<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Admin;
use Validator;
use Auth;
use DB;
use Hash;

class LoginController extends Controller
{

    public function __construct(Request $request)
    {
        $this->successStatus = 200;
        $this->notfound = 404;
        $this->unauthorisedStatus = 400;
        $this->internalServererror = 500;
        $this->driverId  = auth('driver')->user()->id??'';
    }



    public function login(Request $req)
    {
        $url = env('APP_URL').'/public/assets/images/profile/';
        $validator = Validator::make($req->all(), [
            "email" => "required",
            "password" => "required",
        ]);
        if ($validator->fails()) {
            $response["status"] = 400;
            $response["response"] = $validator->messages();
            return $response;
        }


        $checkDriver =  Driver::where('email',$req->input('email'))->where('role_id','33')->first();
        if($checkDriver)
        {
           if($checkDriver->status=='1')
            {
                if ($token = Auth::guard("driver")->attempt( $req->only("email", "password"))) {
                    $agent = Driver::Where("email", $req->input("email"))->first();
                    $destinationPath = url('public/assets/driver/profileImage/');
                    return response()->json([
                        "status" => $this->successStatus,
                        "access_token" => $token,
                        "token_type" => "bearer",
                        "expires_in" =>
                            Auth::guard("driver")
                                ->factory()
                                ->getTTL() * 60,
                        'profileImage' => $destinationPath,
                        "driverDetail" => $agent,
                    ]);
                } else {
                    return response()->json([
                        "status" => 400,
                        "message" =>"Not Found"
                    ]);
                }
            }
            else
            {
                    return response()->json([
                        "status" => 400,
                        "message" =>"User account is not active"
                    ]);
            }
        }
        else{
            return response()->json([
                "status" => 400,
                "message" =>"User not found"
            ]);
        }
    }

    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "userName" => "required",
            "mobileno" =>
                "required|string|min:10|max:13|unique:drivers,mobileNo",
                "dialCode" =>"required",
            "email" => "required|email|unique:drivers",
            "enterPassword" => "required",
            // "selectDocument" => "required",
            // "documentType" =>
            //     "required|max:10000|mimes:doc,docx,pdf,jpeg,jpg,png,gif",
        ]);

        if ($validator->fails()) {
            $response["status"] = 400;
            $response["response"] = $validator->messages();
            // return $response;
            return response()->json($response, 500);
        }

        $documentType = "";
        if ($request->hasFile("documentType")) {
            $files = $request->file("documentType");
            $destinationPath = "public/assets/driver/document";
            $file_name =
                md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $documentType = $file_name;
        }

        $driver = new Driver();
        $driver->fullName = $request->userName;
        $driver->userName = $request->userName;
        $driver->mobileNo = $request->mobileno;
        $driver->dialCode = $request->dialCode;
        $driver->email = $request->email;
        $driver->selectDocument = $request->selectDocument;
        $driver->password = Hash::make($request->enterPassword);
        $driver->documentType = $documentType;
        $driver->role_id = 33;
        $driver->status ='2';
        $driver->save();


        $input['name']        = $request->userName;;
        $input['email']       = $request->email;;
        $input['role_id']     = '33';
        $input['password']    = Hash::make($request->enterPassword);
        $input['added_date']  = date("j F, Y");
        $input['status']      = '2';
        $user = Admin::create($input);



        return response()->json([
            "status" => $this->successStatus,
            "message" => "Driver Register Successfully",
        ]);
    }


  public function updateProfile(Request $request)
  {
    $driver= auth('driver')->user()->id;
    $validator = Validator::make($request->all(), [
                              //  'profile_image' =>'required',
                                 'firstName'    =>'required',
                                 'email' => 'required|email|unique:users,id,'.$driver,
                                 'mobileNo'     => 'required|string|min:10|max:13",'
                            ]);

    if ($validator->fails()) {
        $response['status'] = 400;
        $response['response'] = $validator->messages();
        return $response;
    }


    $imageUrl = url('public/assets/driver/profileImage');
    $files = $request->file('profile_iamge');
    if($files)
    {
    $destinationPath = 'public/assets/driver/profileImage';
    $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
    $files->move($destinationPath, $file_name);
    $p_image = $file_name;
    }
    else{
        $agent=Driver::where('id',$driver)->first();
        $p_image = $agent->profile_image;
    }


       $data=array(
                    'profile_image'  => $p_image,
                    'dialCode'       => $request->input('dialCode'),
                    'userName'       => $request->firstName,
                    'email'          => $request->email,
                    'mobileNo'       => $request->mobileNo
                );

        Driver::whereId($driver)->update($data);


        $driverDetail=Driver::whereId($driver)->first();
        return response()->json(
                        [
                        'status' => $this->successStatus,
                        'message'=>'success',
                        'data' =>"User profile updated successfully",
                        'ProfileImageUrl'=>$imageUrl,
                        'agentDetail' =>$driverDetail,

                        ]
            );
  }

  public function uploadDocument(Request $req)
  {

      $allImage= Driver::whereId($this->driverId)->first();

        if ($req->hasFile('driving_license'))
        {
            $files = $req->file('driving_license');
            $destinationPath = 'public/assets/driver/document';
            $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $driving_license = $file_name;
        }
        else{
           $driving_license=$allImage->driving_license;
        }


        if ($req->hasFile('visa'))
        {
            $files = $req->file('visa');
            $destinationPath = 'public/assets/driver/document';
             $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $visa = $file_name;
        }
        else{
            $visa= $allImage->visa;
        }

        if ($req->hasFile('trafficHistory'))
        {
            $files = $req->file('trafficHistory');
            $destinationPath = 'public/assets/driver/trafficHistory';
             $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $trafficHistory = $file_name;
        }
        else
        {
             $trafficHistory=$allImage->traffic_history;
        }

        if ($req->hasFile('policeChceck'))
        {
            $files = $req->file('policeChceck');
            $destinationPath = 'public/assets/driver/driving_license';
             $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $policeChceck = $file_name;
        }
         else
        {
             $policeChceck= $allImage->police_chceck;
        }




         $allDate= Driver::whereId($this->driverId)->first();


         if ($req->input('driving_license_issue_date'))
        {
            $driving_license_issue_date=$req->input('driving_license_issue_date');
        }
         else
        {
             $driving_license_issue_date=$allDate->driving_license_issue_date;
        }

         if ($req->input('issue_date_expiry_date'))
        {
             $issue_date_expiry_date=$req->input('issue_date_expiry_date');
        }
         else
        {
              $issue_date_expiry_date= $allDate->driving_date_expiry_date;
        }

         if ($req->input('visa_issue_date'))
        {
            $visa_issue_date=$req->input('visa_issue_date');
        }
         else
        {
              $visa_issue_date= $allDate->visa_issue_date;
        }

         if ($req->input('visa_expiry_date'))
        {
           $visa_expiry_date=$req->input('visa_expiry_date');
        }
         else
        {
              $visa_expiry_date= $allDate->visa_expiry_date;
        }

         if ($req->input('traffic_history_issue_date'))
        {
            $traffic_history_issue_date=$req->input('traffic_history_issue_date');
        }
         else
        {
             $traffic_history_issue_date=$allDate->driving_license_issue_date;
        }

         if ($req->input('traffic_history_expire_date'))
        {
             $traffic_history_expire_date=$req->input('traffic_history_expire_date');
        }
         else
        {
              $traffic_history_expire_date= $allDate->traffic_history_expiry_date;
        }

         if ($req->input('police_chceck_issue_date'))
        {
           $police_chceck_issue_date=$req->input('police_chceck_issue_date');
        }
         else
        {
              $police_chceck_issue_date= $allDate->police_chceck_issue_date;
        }

         if ($req->input('police_chceck_expiry_date'))
        {
           $police_chceck_expiry_date=$req->input('police_chceck_expiry_date');
        }
         else
        {
              $police_chceck_expiry_date= $allDate->police_chceck_expiry_date;
        }

        $data=array(
            'driving_license' => $driving_license,
            'visa'            => $visa,
            'traffic_history' => $trafficHistory,
            'police_chceck'   => $policeChceck,

            'driving_license_issue_date' =>  $driving_license_issue_date,
            'driving_date_expiry_date' => $issue_date_expiry_date,

            'visa_issue_date'   => $visa_issue_date,
            'visa_expiry_date'  => $visa_expiry_date,

            'traffic_history_issue_date' => $traffic_history_issue_date,
            'traffic_history_expiry_date' => $traffic_history_expire_date,

            'police_chceck_issue_date' => $police_chceck_issue_date,
            'police_chceck_expiry_date' => $police_chceck_expiry_date,
        );

   Driver::whereId($this->driverId)->update($data);

   return response()->json([
    "status" => $this->successStatus,
    "message" => "Document Added Successfully",
]);
}


 public function getDriverDocs(Request $request)
    {
        $Parcels=Driver::select('id','driving_license','visa','traffic_history','police_chceck','driving_license_issue_date','driving_date_expiry_date','visa_issue_date','visa_expiry_date','traffic_history_issue_date','traffic_history_expiry_date','police_chceck_issue_date','police_chceck_expiry_date')->where('id',$this->driverId)->first();

        $driving_license_and_visa_url = env('APP_URL').'public/assets/driver/document';
        $trafficHistory = env('APP_URL').'public/assets/driver/trafficHistory';
        $policeChceck = env('APP_URL').'public/assets/driver/driving_license';


        if($Parcels)
        {
            return response()->json([
                "status" => $this->successStatus,
                "message" => "Success",
                "driving_license_and_visa_url"=>$driving_license_and_visa_url,
                "trafficHistory"=>$trafficHistory,
                "police_check"=>$policeChceck,
                "data" =>$Parcels
            ]);
        }
        else{
            return response()->json([
                "status" => $this->notfound,
                "message" => "not found",
            ]);

        }
    }


    public function forgotPassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email'     => 'required'
        ]);
        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();
            return $response;
        }

        $agetnLogin=Driver::where('email',$req->input('email'))->first();
        if(empty($agetnLogin))
        {
            return response()->json(
                [
                    'status' => $this->notfound,
                    'message' => 'User Not Found.',
                ]
            );
        }
        else
        {

         $driver=Driver::where('email',$req->input('email'))->update([
                                                            'otp'=>123456,
         ]);
         if($driver)
         {
            return response()->json(
                [
                    'status' => $this->successStatus,
                    'message' => 'Otp Send Successfully.',
                ]
            );
         }
         else{
            return response()->json(
                [
                    'status' => $this->notfound,
                    'message' => 'Internal Server Error.',
                ]
            );
         }
        }
    }


    public function verifyOtp(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email'     => 'required',
            'otp'     => 'required'
        ]);
        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();
            return $response;
        }

        $driver=Driver::where('email',$req->input('email'))->first();
        if(empty($driver))
        {
            return response()->json(
                [
                    'status' => $this->notfound,
                    'message' => 'User Not Found.',
                ]
            );
        }
        else
        {
            $driver=Driver::where('email',$req->input('email'))->where('otp',$req->input('otp'))->first();
            if($driver)
            {
                return response()->json(
                    [
                        'status' => $this->successStatus,
                        'message' => 'Otp Verify Successfully.',
                    ]
                );
            }
            else{
                return response()->json(
                    [
                        'status' => $this->notfound,
                        'message' => 'Wrong Otp.',
                    ]
                );
            }
        }
    }


    public function changePassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);
        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();
            return $response;
        }

        $driver=Driver::where('email',$req->input('email'))->first();
        if(empty($driver))
        {
            return response()->json(
                [
                    'status' => $this->notfound,
                    'message' => 'User Not Found.',
                ]
            );
        }
        else
        {
           $driverPassword= Driver::where('email',$req->input('email'))->update(['password'=>Hash::make($req->input('password'))]);
           Admin::where('email',$req->input('email'))->update(['password'=>Hash::make($req->input('password'))]);
           if($driverPassword)
           {
            return response()->json(
                [
                    'status' => $this->successStatus,
                    'message' => 'Password Update Successfully',
                ]
            );
           }
        }


    }

}
