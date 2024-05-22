<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inspection;
use Validator;
use DB;

class InspectionController extends Controller
{


    public function __construct(Request $request)
    {
        $this->successStatus = 200;
        $this->notfound = 404;
        $this->unauthorisedStatus = 400;
        $this->internalServererror = 500;
        $this->driverId  = auth('driver')->user()->id??'';
    }


    public function inspectionRego()
    {

        $vehicleRego = DB::table('vehicals')
                                ->select('id', 'rego')
                              //  ->where('checkStatus', '1')
                                ->where('controlVehicle', '1')
                                ->where('driverResponsible', $this->driverId)
                                ->get();

         if (count($vehicleRego) > 0)
        {
            return response()->json([
                "status" => $this->successStatus,
                "message" => "Add Induction Rego",
                'data' => $vehicleRego
            ]);
        } else
        {
            $vehicleRego = DB::table('vehicals')
                ->select('id', 'rego')->where('status','1')
                ->get();

            return response()->json([
                "status" => $this->successStatus,
                "message" => "Add Induction Rego",
                'data' => $vehicleRego
            ]);
        }

    }


    public function addInspection(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "regoField"     => "required|numeric",
            "frontImage"    =>  'nullable|image|max:5000',
            "frontLeft"     => 'nullable|image|max:5000',
            "frontRight"    => 'nullable|image|max:5000',
            "leftSide"      => 'nullable|image|max:5000',
            "rightSide"     => 'nullable|image|max:5000',
            "back"          => 'nullable|image|max:5000',
            "backRightSide" => 'nullable|image|max:5000'
       ]);


       if ($validator->fails()) {
           $response["status"] = 400;
           $response["response"] = $validator->messages();
           return $response;
       }

        $name=$req->input('regoField');
        $notes=$req->input('comment');

        $frontImage='';
        if ($req->hasFile('frontImage'))
        {
            $files = $req->file('frontImage');
            $destinationPath = 'assets/inspection/carimage';
            $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $frontImage = $file_name;
        }

        $frontLeft='';
        if ($req->hasFile('frontLeft'))
        {
            $files = $req->file('frontLeft');
            $destinationPath = 'assets/inspection/carimage';
            $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $frontLeft = $file_name;
        }

        $frontRight='';
        if ($req->hasFile('frontRight'))
        {
            $files = $req->file('frontRight');
            $destinationPath = 'assets/inspection/carimage';
            $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $frontRight = $file_name;
        }

        $leftSide='';
        if ($req->hasFile('leftSide'))
        {
            $files = $req->file('leftSide');
            $destinationPath = 'assets/inspection/carimage';
            $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $leftSide = $file_name;
        }

        $rightSide='';
        if ($req->hasFile('rightSide'))
        {
            $files = $req->file('rightSide');
            $destinationPath = 'assets/inspection/carimage';
            $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $rightSide = $file_name;
        }

        $back='';
        if ($req->hasFile('back'))
        {
            $files = $req->file('back');
            $destinationPath = 'assets/inspection/carimage';
            $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $back = $file_name;
        }

        $backLeftSide='';
        if ($req->hasFile('backLeftSide'))
        {
            $files = $req->file('backLeftSide');
            $destinationPath = 'assets/inspection/carimage';
            $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $backLeftSide = $file_name;
        }

        $backRightSide='';
        if ($req->hasFile('backRightSide'))
        {
            $files = $req->file('backRightSide');
            $destinationPath = 'assets/inspection/carimage';
            $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $backRightSide = $file_name;
        }

        $cockpit='';
        if ($req->hasFile('cockpit'))
        {
            $files = $req->file('cockpit');
            $destinationPath = 'assets/inspection/carimage';
            $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $cockpit = $file_name;
        }

          $data = [
                      "regoNumber"   => $name,
                      "driverId"     => $this->driverId,
                      "notes"        => $notes,
                      "front"        => $frontImage,
                      "frontleft"    => $frontLeft,
                      "frontRight"   => $frontRight,
                      "leftSide"     => $leftSide,
                      "rightSide"    => $rightSide,
                      "backSide"    => $back,
                      "backLeftSide" => $backLeftSide,
                      "backRightSide"=> $backRightSide,
                      "cockpit"     => $cockpit,
                      "driverInspections" =>'1'
                    ];

        //   $CheckInspection= Inspection::where('driverId',$this->driverId)->first();
        //   if(empty($CheckInspection))
        //   {
            Inspection::insert($data);
            return response()->json([
                "status" => $this->successStatus,
                "message" => "Inspection added successfully",
            ]);
        //   }
        //   else{
        //     return response()->json([
        //         "status" => $this->successStatus,
        //         "message" => "Alredy Added",
        //     ]);

        //   }
    }
}
