<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Models\Inspection;
use DB;
use Illuminate\Http\Request;
use Validator;

class InspectionController extends Controller
{
    public $successStatus = 200;
    public $notfound = 404;
    public $unauthorisedStatus = 400;
    public $internalServererror = 500;
    protected $driverId;

    public function __construct(Request $request)
    {
        $this->successStatus = 200;
        $this->notfound = 404;
        $this->unauthorisedStatus = 400;
        $this->internalServererror = 500;
        $this->driverId = auth('driver')->user()->id ?? '';
    }

    public function inspectionRego()
    {

        $vehicleRego = DB::table('vehicals')
            ->select('id', 'rego')
            ->where('controlVehicle', '1')
            ->where('driverResponsible', $this->driverId)
            ->get();

        if (count($vehicleRego) > 0) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Add Induction Rego',
                'data' => $vehicleRego,
            ]);
        } else {
            $vehicleRego = DB::table('vehicals')
                ->select('id', 'rego')->where('status', '1')
                ->get();

            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Add Induction Rego',
                'data' => $vehicleRego,
            ]);
        }
    }

    public function addInspection(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'regoField'     => 'required|numeric',
            'frontImage'    =>  'nullable|image|max:5000',
            'frontLeft'     => 'nullable|image|max:5000',
            'frontRight'    => 'nullable|image|max:5000',
            'leftSide'      => 'nullable|image|max:5000',
            'rightSide'     => 'nullable|image|max:5000',
            'back'          => 'nullable|image|max:5000',
            'backRightSide' => 'nullable|image|max:5000',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $name = $req->input('regoField');
        $notes = $req->input('comment');

        $dateFolder = 'inspection/carimage';

        $frontImage = null;
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
            'driverId'     => $this->driverId,
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
            'driverInspections' => '1',
        ];

        Inspection::insert($data);

        return response()->json([
            'status' => $this->successStatus,
            'message' => 'Inspection added successfully',
        ]);
    }
}
