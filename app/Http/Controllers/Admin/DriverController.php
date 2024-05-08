<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use Log;
use Auth;

class DriverController extends Controller
{
    public function driver(Request $request)
    {
        $driverRole=  Auth::guard('adminLogin')->user();
        if($driverRole->role_id=='33')
        {
            $driverInspections=$request->input('driverInspections');
            $data['driver']=Driver::where('email',$driverRole->email)->with(['getDriverInspection']);
            if($driverInspections)
            {
                $data['driver']=$data['driver']->where('driverInspections',$driverInspections);
            }
            $data['driver']=$data['driver']->get();
        }
    else{
        $driverInspections=$request->input('driverInspections');
        $data['driver']=Driver::with(['getDriverInspection']);
        if($driverInspections)
        {
          $data['driver']=$data['driver']->where('driverInspections',$driverInspections);
        }
        $data['driver']=$data['driver']->get();
    }





      return view('admin.induction.induction-driver',$data,compact('driverInspections'));
    }

    public function driverInduction(Request $request,$id)
    {

         $driver= Driver::find($id);
        return view('admin.induction.driver-Induction',compact('driver'));
    }


}
