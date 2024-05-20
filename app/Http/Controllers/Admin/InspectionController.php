<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Induction;
use App\Models\Inspection;
use App\Models\Vehical;
use App\Models\rego;
use DB;
use Auth;


class InspectionController extends Controller
{
    public function inspection()
    {
      $driverRole=  Auth::guard('adminLogin')->user();
      $query=Inspection::orderBy('id','DESC');
      if($driverRole->role_id=='33')
      {
        $driverId= DB::table('drivers')->where('status','1')->where('email',$driverRole->email)->first()->id;
        $query=$query->where('driverId',$driverId);
      }
      $data['inspection'] =$query->with('getAppDriver')->get();

      return view('admin.inspection.inspection',$data);
    }

    public function inspectionAdd(Request $req)
    {
      if(request()->isMethod("post"))
      {

        $name=$req->input('selectrego');
        $notes=$req->input('notes');

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
                      "Notes"        => $notes,
                      "front"        => $frontImage,
                      "frontleft"    => $frontLeft,
                      "frontRight"   => $frontRight,
                      "leftSide"     => $leftSide,
                      "rightSide"    => $rightSide,
                      "backSide"    => $back,
                      "backLeftSide" => $backLeftSide,
                      "backRightSide"=> $backRightSide,
                      "cockpit"     => $cockpit,
                    ];

        $driverRole=  Auth::guard('adminLogin')->user();
        if($driverRole->role_id=='33')
        {
            $driverId= DB::table('drivers')->where('email',$driverRole->email)->first()->id;
            $data['driverId'] = $driverId;
        }

        Inspection::insert($data);

          return redirect()->route('inspection')->with('message', 'Inspection Added Successfully!');
      }

      $checkRego= Auth::guard('adminLogin')->user();
      if($checkRego->role_id=='33')
      {
         $driverId= DB::table('drivers')->where('email',$checkRego->email)->first();
         $data['regos']=DB::table('vehicals')->where('status','1')->select('id','rego')->where('controlVehicle','1')->where('driverResponsible', $driverId->id??'')->get();
      }
      else{
      $data['regos']=DB::table('vehicals')->where('status','1')->select('id','rego')->get();
      }

      return view('admin.inspection.inspection-add',$data);

    }

    public function inspectionView(Request $req,$id)
    {
        $data['inspection']=Inspection::whereId($id)->first();
       if(request()->isMethod("post"))
         {

            $name=$req->input('selectrego');

            $notes=$req->input('notes');

            if ($req->hasFile('frontImage'))
            {
                $files = $req->file('frontImage');
                $destinationPath = 'assets/inspection/carimage';
                $file_name1 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name1);
                $frontImage = $file_name1;
            }
            else{
               $frontImage=$data['inspection']->front;
            }



            if ($req->hasFile('frontLeft'))
            {
                $files = $req->file('frontLeft');
                $destinationPath = 'assets/inspection/carimage';
                $file_name2 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name2);
                $frontLeft = $file_name2;
            }
            else{
                $frontLeft=$data['inspection']->frontleft;
             }



            if ($req->hasFile('frontRight'))
            {
                $files = $req->file('frontRight');
                $destinationPath = 'assets/inspection/carimage';
                $file_name3 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name3);
                $frontRight = $file_name3;
            }
            else{
                $frontRight=$data['inspection']->frontRight;
             }



            if ($req->hasFile('leftSide'))
            {
                $files = $req->file('leftSide');
                $destinationPath = 'assets/inspection/carimage';
                $file_name4 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name4);
                $leftSide = $file_name4;
            }
            else{
                $leftSide=$data['inspection']->leftSide;
             }



            if ($req->hasFile('rightSide'))
            {
                $files = $req->file('rightSide');
                $destinationPath = 'assets/inspection/carimage';
                $file_name5 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name5);
                $rightSide = $file_name5;
            }
            else{
                $rightSide=$data['inspection']->rightSide;
             }



            if ($req->hasFile('back'))
            {
                $files = $req->file('back');
                $destinationPath = 'assets/inspection/carimage';
                $file_name6 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name6);
                $back = $file_name6;
            }
            else{
                $back=$data['inspection']->backSide;
             }


            if ($req->hasFile('backLeftSide'))
            {
                $files = $req->file('backLeftSide');
                $destinationPath = 'assets/inspection/carimage';
                $file_name7 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name7);
                $backLeftSide = $file_name7;
            }
            else{
                $backLeftSide=$data['inspection']->backLeftSide;
             }


            if ($req->hasFile('backRightSide'))
            {
                $files = $req->file('backRightSide');
                $destinationPath = 'assets/inspection/carimage';
                $file_name8 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name8);
                $backRightSide = $file_name8;
            }
            else{
                $backRightSide=$data['inspection']->backRightSide;
             }



            if ($req->hasFile('cockpit'))
            {
                $files = $req->file('cockpit');
                $destinationPath = 'assets/inspection/carimage';
                $file_name9 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name9);
                $cockpit = $file_name9;
            }
            else{
                $cockpit=$data['inspection']->cockpit;
             }


              $data = [
                          "regoNumber"   => $name,
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
                        ];
                Inspection::whereId($id)->update($data);

              return redirect()->route('inspection')->with('message', 'Inspection Updated Successfully!');
        }

        $data['rego'] =Vehical::get();
        return view('admin.inspection.inspection-view',$data);
    }


    public function inspectionedit(Request $req,$id)
    {
        $data['inspection']=Inspection::whereId($id)->first();
       if(request()->isMethod("post"))
         {

            $name=$req->input('selectrego');

            $notes=$req->input('notes');

            if ($req->hasFile('frontImage'))
            {
                $files = $req->file('frontImage');
                $destinationPath = 'assets/inspection/carimage';
                $file_name1 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name1);
                $frontImage = $file_name1;
            }
            else{
               $frontImage=$data['inspection']->front;
            }



            if ($req->hasFile('frontLeft'))
            {
                $files = $req->file('frontLeft');
                $destinationPath = 'assets/inspection/carimage';
                $file_name2 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name2);
                $frontLeft = $file_name2;
            }
            else{
                $frontLeft=$data['inspection']->frontleft;
             }



            if ($req->hasFile('frontRight'))
            {
                $files = $req->file('frontRight');
                $destinationPath = 'assets/inspection/carimage';
                $file_name3 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name3);
                $frontRight = $file_name3;
            }
            else{
                $frontRight=$data['inspection']->frontRight;
             }



            if ($req->hasFile('leftSide'))
            {
                $files = $req->file('leftSide');
                $destinationPath = 'assets/inspection/carimage';
                $file_name4 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name4);
                $leftSide = $file_name4;
            }
            else{
                $leftSide=$data['inspection']->leftSide;
             }



            if ($req->hasFile('rightSide'))
            {
                $files = $req->file('rightSide');
                $destinationPath = 'assets/inspection/carimage';
                $file_name5 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name5);
                $rightSide = $file_name5;
            }
            else{
                $rightSide=$data['inspection']->rightSide;
             }



            if ($req->hasFile('back'))
            {
                $files = $req->file('back');
                $destinationPath = 'assets/inspection/carimage';
                $file_name6 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name6);
                $back = $file_name6;
            }
            else{
                $back=$data['inspection']->backSide;
             }


            if ($req->hasFile('backLeftSide'))
            {
                $files = $req->file('backLeftSide');
                $destinationPath = 'assets/inspection/carimage';
                $file_name7 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name7);
                $backLeftSide = $file_name7;
            }
            else{
                $backLeftSide=$data['inspection']->backLeftSide;
             }


            if ($req->hasFile('backRightSide'))
            {
                $files = $req->file('backRightSide');
                $destinationPath = 'assets/inspection/carimage';
                $file_name8 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name8);
                $backRightSide = $file_name8;
            }
            else{
                $backRightSide=$data['inspection']->backRightSide;
             }



            if ($req->hasFile('cockpit'))
            {
                $files = $req->file('cockpit');
                $destinationPath = 'assets/inspection/carimage';
                $file_name9 = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name9);
                $cockpit = $file_name9;
            }
            else{
                $cockpit=$data['inspection']->cockpit;
             }


              $data = [
                          "regoNumber"   => $name,
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
                        ];
                Inspection::whereId($id)->update($data);

              return redirect()->route('inspection')->with('message', 'Inspection Updated Successfully!');
        }

        $data['rego'] =Vehical::where('status','1')->get();
        return view('admin.inspection.inspection-edit',$data);
    }
}
