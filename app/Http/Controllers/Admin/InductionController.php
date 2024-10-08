<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Models\Induction;
use App\Models\Inductiondriver;
use Illuminate\Http\Request;

class InductionController extends Controller
{
    public function induction(Request $req)
    {
        $query = Induction::orderBy('id', 'DESC');
        $data['selectStatus'] = $req->input('selectStatus') ?? '1';
        $query = $query->where('status', $data);
        $data['induction'] = $query->get();

        return view('admin.induction.induction', $data);
    }

    public function inductiondelete(Request $req)
    {
        $id = $req->input('common');
        Induction::orderBy('id', 'DESC')->where('id', $id)->update(['status' => '0']);

        return redirect()->route('induction')->with('message', 'Induction Delete Successfully!');
    }

    public function uploadSignature(Request $req, $id)
    {

        $data['induction_id'] = $id;
        if (request()->isMethod('post')) {
            $items = null;
            if ($req->hasFile('uploadFile')) {
                $image = $req->file('uploadFile');
                $dateFolder = 'induction/signatureImage';
                $items = ImageController::upload($image, $dateFolder);
            }
            $packageItem = [
              'induction_id'     => $req->input('induction_id'),
              'driverId'     => $req->input('driverName'),
              'signature' => $items,
            ];
            Inductiondriver::insert($packageItem);

            return redirect()->route('induction')->with('message', 'Induction Signature Updated Successfully!');
        }

        return view('admin.induction.induction-add-signature', $data);
    }

    public function driveruploadSignature(Request $req, $id)
    {
        $data['induction_id'] = $id;
        if (request()->isMethod('post')) {
            $items = '';
            if ($req->hasFile('uploadFile')) {
                $image = $req->file('uploadFile');
                $dateFolder = 'induction/signatureImage';
                $items = ImageController::upload($image, $dateFolder);
            }
            $packageItem = [
              'induction_id'     => $req->input('induction_id'),
              'driverId'     => $req->input('driverName'),
              'signature' => $items,
            ];
            Inductiondriver::insert($packageItem);

            return redirect()->route('induction')->with('message', 'Induction Signature Updated Successfully!');
        }

        return view('admin.induction.induction-add-signature', $data);
    }

    public function inductionAdd(Request $req)
    {
        if (request()->isMethod('post')) {
            $name = $req->input('name');
            $status = $req->input('status');
            $description = $req->input('description');

            $items = '';
            if ($req->hasFile('uploadFile')) {
                $image = $req->file('uploadFile');
                $dateFolder = 'induction/image';
                $items = ImageController::upload($image, $dateFolder);
            }

            $packageItem = [
              'title'     => $name,
              'description' => $description,
              'status'    => $status,
              'uploadFile' => $items,
            ];
            Induction::insert($packageItem);

            return redirect()->route('induction')->with('message', 'Induction Added Successfully!');
        }

        return view('admin.induction.induction-add');
    }

    public function inductionDriver(Request $req, $id)
    {
        $data['inductiondriver'] = Inductiondriver::where('induction_id', $id)->with(['getDriver:id,fullName,surname,userName,email,mobileNo'])->get();

        return view('admin.induction.induction-driver-signature', $data);
    }

    public function inductionEdit(Request $req, $id)
    {
        $data['inductionDetail'] = Induction::whereId($id)->first();

        if (request()->isMethod('post')) {
            $name = $req->input('name');
            $description = $req->input('description');
            $status = $req->input('status');

            if ($req->hasFile('uploadFile')) {
                $image = $req->file('uploadFile');
                $dateFolder = 'induction/image';
                $items = ImageController::upload($image, $dateFolder);
            } else {
                $items = Induction::whereId($id)->first()->uploadFile;
            }

            $data = [
              'title'     => $name,
              'description' => $description,
              'status'    => $status,
              'uploadFile' => $items,
            ];
            Induction::whereId($id)->update($data);

            return redirect()->route('induction')->with('message', 'Induction Updated Successfully!');
        }

        return view('admin.induction.induction-edit', $data);
    }

    public function inductionView(Request $req, $id)
    {
        $data['inductionDetail'] = Induction::whereId($id)->first();

        if (request()->isMethod('post')) {
            $name = $req->input('name');
            $description = $req->input('description');
            $status = $req->input('status');
            if ($req->hasFile('uploadFile')) {
                $image = $req->file('uploadFile');
                $dateFolder = 'induction/image';
                $items = ImageController::upload($image, $dateFolder);
            } else {
                $items = Induction::whereId($id)->first()->uploadFile;
            }

            $data = [
              'title'     => $name,
              'description' => $description,
              'status'    => $status,
              'uploadFile' => $items,
            ];
            Induction::whereId($id)->update($data);

            return redirect()->route('induction')->with('message', 'Induction Updated Successfully!');
        }

        return view('admin.induction.induction-view', $data);
    }
}
