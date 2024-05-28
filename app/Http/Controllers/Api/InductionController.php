<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Models\Induction;
use App\Models\Inductiondriver;
use App\Models\Inspection;
use DB;
use Illuminate\Http\Request;
use Validator;

class InductionController extends Controller
{
    protected $driverId;

    public function __construct(Request $request)
    {
        $this->driverId = auth('driver')->user()->id ?? '';
    }

    public function allInspection()
    {
        $all = Induction::where('status', '1')->get();
        $url = asset(env('STORAGE_URL'));

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'url'   => $url,
            'data'   => $all,
        ]);
    }

    public function inspectionDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inspection_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }
        $id = $request->inspection_id;
        $url = asset(env('STORAGE_URL'));
        $signatureImage = asset(env('STORAGE_URL'));;
        $inductions = Induction::select('id', 'title', 'description', 'uploadFile', 'status')->where('id', $id)->first();
        $InductionSignature = DB::table('inductiondrivers')->select('id', 'induction_id', 'driverId', 'signature')->where('induction_id', $id)->where('driverId', $this->driverId)->first();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'url'   => $url,
            'signature_url' => $signatureImage,
            'inductionsDetail' => $inductions,
            'InductionSignature'  => $InductionSignature,
        ]);
    }

    public function inspectionDetail2(Request $request)
    {
        $inspections = Inspection::where('driverId', $this->driverId)->with(['getVehicleRego' => function ($query) {
            $query->select('id', 'rego');
        }])
            ->get();
        $destinationPath = asset(env('STORAGE_URL'));

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'Image_Url' => $destinationPath,
            'InductionDetail'   => $inspections,
        ]);
    }

    public function uploadInspection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inspection_id' => 'required|numeric',
            'signature' => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $id = $request->inspection_id;
        $files = $request->file('signature');
        $p_image = null;
        if ($files) {
            $image = $request->file('signature');
            $dateFolder = 'induction/signatureImage';
            $p_image = ImageController::upload($image, $dateFolder);
        }

        $Inductiondriver = Inductiondriver::where('induction_id', $id)->where('driverId', $this->driverId)->first();
        if (empty($Inductiondriver)) {
            Inductiondriver::insert([
                'induction_id' => $id,
                'signature' => $p_image,
                'driverId' => $this->driverId,
            ]);
        } else {
            Inductiondriver::where('induction_id', $id)->update([
                'induction_id' => $id,
                'signature' => $p_image,
                'driverId' => $this->driverId,
            ]);
        }

        return response()->json([
            'status' => 200,
            'destinationPath' => env('SIGNATURE_IMAGE'),
            'message' => 'Signature Updated Successfully',
        ]);
    }
}
