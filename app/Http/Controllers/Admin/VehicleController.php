<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DataTableVehicleHelper;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Type;
use App\Models\Vehical;
use DB;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function VehicleAjax(Request $request)
    {
        $query = Vehical::select('*')->orderBy('id', 'DESC');
        $data['checkStatus'] = $request->input('checkStatus') ?? '1';
        $query = $query->where('status', $data['checkStatus']);
        $data['vehical'] = $query->get()->take('10');

        return view('admin.vehicle.ajaxVehicle', $data);
    }

    public function vehicle(Request $request)
    {
        $data['checkStatus'] = $request->input('checkStatus') ?? '1';

        return view('admin.vehicle.vehicle', $data);
    }

    public function getAjaxData(Request $request)
    {
        $query = Vehical::select('*')->orderBy('id', 'DESC');
        if (isset($request->form) && !empty($request->form)) {
            $data['status'] = $request->input('form.checkStatus') ?? '1';
            if ($data['status']) {
                $query->where('status', $data['status']);
            }
        }
        $data['client'] = $query->with(['getVehicleType']);
        $columnMapping = [
            'id' => 'id',
            'Rego' => 'rego',
            'Type' => 'getVehicleType.name',
            'Odometer' => 'odometer',
            'Model' => 'modelName',
            'Status' => 'status',
            'Action' => 'id',
        ];
        $relations = ['getVehicleType'];
        $pageStr = 'client_table';
        $query->with($relations);

        return DataTableVehicleHelper::getData($request, $query, $columnMapping, $pageStr);
    }

    public function vehicleAdd(Request $request)
    {
        if (request()->isMethod('post')) {
            $this->validate($request, [
                'rego' => 'required|unique:vehicals,rego',
            ]);
            $selectType = $request->selectType;
            $rego = $request->rego;
            $odometer = $request->odometer;
            $model = $request->model;
            $driverResponsible = $request->driverResponsible;
            $vehicleControl = $request->vehicleControl;
            $regoDate = $request->regoDate;
            $servicesDue = $request->servicesDue;
            $inspenctionDue = $request->inspenctionDue;
            $id = Vehical::create([
                'vehicalType'   => $selectType,
                'rego'           => $rego,
                'odometer'        => $odometer,
                'modelName'       => $model,
                'driverResponsible' => $driverResponsible,
                'controlVehicle' => $vehicleControl,
                'regoDueDate'     => $regoDate,
                'serviceDueDate'   => $servicesDue,
                'inspectionDueDate' => $inspenctionDue,
            ])->id;
            if ($vehicleControl == '1') {
                Driver::where('id', $driverResponsible)->update(['rego' => $id]);
            }

            return redirect('admin/vehicle')->with('message', 'Vehicle Added Successfully!');
        }
        $data['type'] = Type::get();
        $data['Driverresponsible'] = Driver::where('status', '1')->get();

        return view('admin.vehicle.vehicle-add', $data);
    }

    public function vehicleType(Request $request)
    {
        if (request()->isMethod('post')) {
            $type = Type::where('name', $request->input('typeName'))->first();
            if ($type) {
                return redirect()->back()->with('error', 'Vehicle Type Already Exist');
            } else {
                $typeName = $request->input('typeName');
                $data = [
                    'name' => $typeName,
                ];
                Type::create($data);

                return redirect()->back()->with('message', 'Vehicle Type Added Successfully!');
            }
        }
        $type = Type::orderBy('id', 'desc')->get();

        return view('admin.menuVehicle.type', compact('type'));
    }

    public function vehicleTypeEdit(Request $request)
    {
        $typeName = $request->input('typeName');
        $typeId = $request->input('typeId');
        $data = [
            'name' => $typeName,
        ];
        Type::whereId($typeId)->update($data);

        return redirect()->back()->with('message', 'Vehicle Type Edit Successfully!');
    }

    public function vehicleTypeDelete(Request $request)
    {
        //   return $request->all();
        $typeId = $request->input('typeId');
        Type::whereId($typeId)->delete();

        return redirect()->back()->with('message', 'Vehicle Type Delete Successfully!');
    }

    public function vehicleView($id)
    {
        $vehicleId = Vehical::where('id', $id)->first();
        $vehicleId->types = Type::where('id', $vehicleId->vehicalType)->first()->name ?? '';

        return view('admin.vehicle.vehicle-view', compact('vehicleId'));
    }

    public function vehicleedit(Request $request, $id)
    {
        $vehicleId = Vehical::where('id', $id)->first() ?? '';
        $types = Type::where('id', $vehicleId->vehicalType)->first()->id ?? '';
        $allTypes = Type::get();
        $rsp = DB::table('drivers')->where('id', $vehicleId->driverResponsible)->first()->id ?? '';
        $allresponsibles = DB::table('drivers')->where('status', '1')->orderBy('id', 'DESC')->get();
        if (request()->isMethod('post')) {
            $selectType = $request->input('selectType');
            $rego = $request->input('rego');
            $odometer = $request->input('odometer');
            $model = $request->input('model');
            $driverResponsible = $request->input('driverResponsible');
            $vehicleControl = $request->input('vehicleControl');
            $regoDate = $request->input('regoDate');
            $servicesDue = $request->input('servicesDue');
            $inspenctionDue = $request->input('inspenctionDue');
            $checkStatus = '1';
            $data = [
                'vehicalType'   => $selectType,
                'rego'           => $rego,
                'odometer'        => $odometer,
                'modelName'       => $model,
                'driverResponsible' => $driverResponsible,
                'controlVehicle' => $vehicleControl,
                'regoDueDate'     => $regoDate,
                'serviceDueDate'   => $servicesDue,
                'inspectionDueDate' => $inspenctionDue,
                'checkStatus' => $checkStatus,
            ];
            $updateVehical = Vehical::whereId($id)->update($data);
            if ($vehicleControl == '1') {
                Driver::where('id', $driverResponsible)->update(['rego' => $id]);
            }

            return redirect('admin/vehicle')->with('message', 'Vehicle Type Updated Successfully!');
        }

        return view('admin.vehicle.vehicle-edit', compact('vehicleId', 'allTypes', 'types', 'allresponsibles', 'rsp'));
    }

    public function vehicledelete(Request $request)
    {
        $id = $request->input('common');
        Vehical::where('id', $id)->update(['status' => '2']);

        return redirect('admin/vehicle')->with('message', 'Vehicle Deleted Successfully!');
    }

    public function vehicleStatus(Request $request)
    {
        $client = Vehical::whereId($request->input('clientId'))->update(['status' => $request->input('statusValue')]);
        if ($client) {
            return response()->json([
                'success' => '200',
                'message' => 'Done.',
            ]);
        }
    }
}
