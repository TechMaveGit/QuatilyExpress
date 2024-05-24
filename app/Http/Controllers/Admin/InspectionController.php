<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Models\Inspection;
use App\Models\Vehical;
use Auth;
use DB;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function inspection()
    {
        $driverRole = Auth::guard('adminLogin')->user();
        $query = Inspection::with('getAppDriver')->orderBy('id', 'DESC');
        if ($driverRole->role_id == '33') {
            $driverId = DB::table('drivers')->where('status', '1')->where('email', $driverRole->email)->first()->id;
            $query = $query->where('driverId', $driverId);
        }
        $data['inspection'] = $query->with('getAppDriver')->get();

        return view('admin.inspection.inspection', $data);
    }

    public function inspectionAdd(Request $req)
    {
        if (request()->isMethod('post')) {

            $name = $req->input('selectrego');
            $notes = $req->input('notes');

            $frontImage = null;
            $dateFolder = 'inspection/carimage';

            if ($req->hasFile('frontImage')) {
                $image = $req->file('frontImage');
                $frontImage = ImageController::upload($image, $dateFolder);
            }

            $frontLeft = null;
            if ($req->hasFile('frontLeft')) {
                $image = $req->file('frontLeft');
                $frontLeft = ImageController::upload($image, $dateFolder);
            }

            $frontRight = null;
            if ($req->hasFile('frontRight')) {
                $image = $req->file('frontRight');
                $frontRight = ImageController::upload($image, $dateFolder);
            }

            $leftSide = null;
            if ($req->hasFile('leftSide')) {
                $image = $req->file('leftSide');
                $leftSide = ImageController::upload($image, $dateFolder);
            }

            $rightSide = null;
            if ($req->hasFile('rightSide')) {
                $image = $req->file('rightSide');
                $rightSide = ImageController::upload($image, $dateFolder);
            }

            $back = null;
            if ($req->hasFile('back')) {
                $image = $req->file('back');
                $dateFolder = 'inspection/carimage';
                $back = ImageController::upload($image, $dateFolder);
            }

            $backLeftSide = null;
            if ($req->hasFile('backLeftSide')) {
                $image = $req->file('backLeftSide');
                $backLeftSide = ImageController::upload($image, $dateFolder);
            }

            $backRightSide = null;
            if ($req->hasFile('backRightSide')) {
                $image = $req->file('backRightSide');
                $backRightSide = ImageController::upload($image, $dateFolder);
            }

            $cockpit = null;
            if ($req->hasFile('cockpit')) {
                $image = $req->file('cockpit');
                $cockpit = ImageController::upload($image, $dateFolder);
            }

            $data = [
                'regoNumber'   => $name,
                'Notes'        => $notes,
                'front'        => $frontImage,
                'frontleft'    => $frontLeft,
                'frontRight'   => $frontRight,
                'leftSide'     => $leftSide,
                'rightSide'    => $rightSide,
                'backSide'    => $back,
                'backLeftSide' => $backLeftSide,
                'backRightSide' => $backRightSide,
                'cockpit'     => $cockpit,
            ];

            $driverRole = Auth::guard('adminLogin')->user();
            if ($driverRole->role_id == '33') {
                $driverId = DB::table('drivers')->where('email', $driverRole->email)->first()->id;
                $data['driverId'] = $driverId;
            }
            Inspection::insert($data);

            return redirect()->route('inspection')->with('message', 'Inspection Added Successfully!');
        }

        $checkRego = Auth::guard('adminLogin')->user();
        if ($checkRego->role_id == '33') {
            $driverId = DB::table('drivers')->where('email', $checkRego->email)->first();
            $data['regos'] = DB::table('vehicals')->where('status', '1')->select('id', 'rego')->where('controlVehicle', '1')->where('driverResponsible', $driverId->id ?? '')->get();
        } else {
            $data['regos'] = DB::table('vehicals')->where('status', '1')->select('id', 'rego')->get();
        }

        return view('admin.inspection.inspection-add', $data);
    }

    public function inspectionView(Request $req, $id)
    {
        $data['inspection'] = Inspection::with('getAppDriver')->whereId($id)->first();
        if (request()->isMethod('post')) {
            $name = $req->input('selectrego');
            $notes = $req->input('notes');

            $dateFolder = 'inspection/carimage';
            if ($req->hasFile('frontImage')) {
                $image = $req->file('frontImage');
                $frontImage = ImageController::upload($image, $dateFolder);
            } else {
                $frontImage = $data['inspection']->front;
            }

            if ($req->hasFile('frontLeft')) {
                $image = $req->file('frontLeft');
                $frontLeft = ImageController::upload($image, $dateFolder);
            } else {
                $frontLeft = $data['inspection']->frontleft;
            }

            if ($req->hasFile('frontRight')) {
                $image = $req->file('frontRight');
                $frontRight = ImageController::upload($image, $dateFolder);
            } else {
                $frontRight = $data['inspection']->frontRight;
            }

            if ($req->hasFile('leftSide')) {
                $image = $req->file('leftSide');
                $leftSide = ImageController::upload($image, $dateFolder);
            } else {
                $leftSide = $data['inspection']->leftSide;
            }

            if ($req->hasFile('rightSide')) {
                $image = $req->file('rightSide');
                $rightSide = ImageController::upload($image, $dateFolder);
            } else {
                $rightSide = $data['inspection']->rightSide;
            }

            if ($req->hasFile('back')) {
                $image = $req->file('back');
                $back = ImageController::upload($image, $dateFolder);
            } else {
                $back = $data['inspection']->backSide;
            }

            if ($req->hasFile('backLeftSide')) {
                $image = $req->file('backLeftSide');
                $backLeftSide = ImageController::upload($image, $dateFolder);
            } else {
                $backLeftSide = $data['inspection']->backLeftSide;
            }

            if ($req->hasFile('backRightSide')) {
                $image = $req->file('backRightSide');
                $backRightSide = ImageController::upload($image, $dateFolder);
            } else {
                $backRightSide = $data['inspection']->backRightSide;
            }

            if ($req->hasFile('cockpit')) {
                $image = $req->file('cockpit');
                $cockpit = ImageController::upload($image, $dateFolder);
            } else {
                $cockpit = $data['inspection']->cockpit;
            }

            $data = [
                'regoNumber'   => $name,
                'notes'        => $notes,
                'front'        => $frontImage,
                'frontleft'    => $frontLeft,
                'frontRight'   => $frontRight,
                'leftSide'     => $leftSide,
                'rightSide'    => $rightSide,
                'backSide'    => $back,
                'backLeftSide' => $backLeftSide,
                'backRightSide' => $backRightSide,
                'cockpit'     => $cockpit,
            ];
            Inspection::whereId($id)->update($data);

            return redirect()->route('inspection')->with('message', 'Inspection Updated Successfully!');
        }
        $data['rego'] = Vehical::get();

        return view('admin.inspection.inspection-view', $data);
    }

    public function inspectionedit(Request $req, $id)
    {
        $data['inspection'] = Inspection::with('getAppDriver')->whereId($id)->first();
        if (request()->isMethod('post')) {
            $name = $req->input('selectrego');
            $notes = $req->input('notes');

            $dateFolder = 'inspection/carimage';
            if ($req->hasFile('frontImage')) {
                $image = $req->file('frontImage');
                $frontImage = ImageController::upload($image, $dateFolder);
            } else {
                $frontImage = $data['inspection']->front;
            }

            if ($req->hasFile('frontLeft')) {
                $image = $req->file('frontLeft');
                $frontLeft = ImageController::upload($image, $dateFolder);
            } else {
                $frontLeft = $data['inspection']->frontleft;
            }

            if ($req->hasFile('frontRight')) {
                $image = $req->file('frontRight');
                $frontRight = ImageController::upload($image, $dateFolder);
            } else {
                $frontRight = $data['inspection']->frontRight;
            }

            if ($req->hasFile('leftSide')) {
                $image = $req->file('leftSide');
                $leftSide = ImageController::upload($image, $dateFolder);
            } else {
                $leftSide = $data['inspection']->leftSide;
            }

            if ($req->hasFile('rightSide')) {
                $image = $req->file('rightSide');
                $rightSide = ImageController::upload($image, $dateFolder);
            } else {
                $rightSide = $data['inspection']->rightSide;
            }

            if ($req->hasFile('back')) {
                $image = $req->file('back');
                $back = ImageController::upload($image, $dateFolder);
            } else {
                $back = $data['inspection']->backSide;
            }

            if ($req->hasFile('backLeftSide')) {
                $image = $req->file('backLeftSide');
                $backLeftSide = ImageController::upload($image, $dateFolder);
            } else {
                $backLeftSide = $data['inspection']->backLeftSide;
            }

            if ($req->hasFile('backRightSide')) {
                $image = $req->file('backRightSide');
                $backRightSide = ImageController::upload($image, $dateFolder);
            } else {
                $backRightSide = $data['inspection']->backRightSide;
            }

            if ($req->hasFile('cockpit')) {
                $image = $req->file('cockpit');
                $cockpit = ImageController::upload($image, $dateFolder);
            } else {
                $cockpit = $data['inspection']->cockpit;
            }

            $data = [
                'regoNumber'   => $name,
                'notes'        => $notes,
                'front'        => $frontImage,
                'frontleft'    => $frontLeft,
                'frontRight'   => $frontRight,
                'leftSide'     => $leftSide,
                'rightSide'    => $rightSide,
                'backSide'    => $back,
                'backLeftSide' => $backLeftSide,
                'backRightSide' => $backRightSide,
                'cockpit'     => $cockpit,
            ];
            Inspection::whereId($id)->update($data);

            return redirect()->route('inspection')->with('message', 'Inspection Updated Successfully!');
        }

        $data['rego'] = Vehical::where('status', '1')->get();

        return view('admin.inspection.inspection-edit', $data);
    }
}
