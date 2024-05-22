<?php
namespace App\Http\Controllers\Admin;
use App\Helpers\DataTableHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Clientaddress;
use App\Models\Clientbase;
use App\Models\Clientrate;
use App\Models\Type;
use App\Models\Clientcenter;
use App\Models\States;
use App\Exports\ClientsExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ClientController extends Controller
{
    public function clients(Request $request)
    {
        $data['status'] = $request->input('clientStatus') ?? '1';
        $data['name'] = $request->input('name');
        $data['mobileNo'] = $request->input('mobileNo');
        $data['state'] = $request->input('state');
        return view('admin.client.client', $data);
    }

    public function clientsAjax(Request $request)
    {
        $query = Client::orderBy('id','DESC');
        if (isset($request->form) && !empty($request->form)) {
            $data['status'] = $request->input('form.clientStatus') ?? '1';
            $data['name'] = $request->input('form.name');
            $data['mobileNo'] = $request->input('form.mobileNo');
            $data['state'] = $request->input('form.state');
            $query->where('status', $data['status']);
            if ($data['name']) {
                $query->where('name', $data['name']);
            }
            if ($data['mobileNo']) {
                $query->where('mobilePhone', $data['mobileNo']);
            }
            if ($data['state']) {
                $query->where('state', $data['state']);
            }
        }
        $data['client'] = $query->with(['getState'])->get();
        $columnMapping = [
            'id' => 'id',
            'Name' => 'name',
            'Short Name' => 'shortName',
            'Abn' => 'abn',
            'Phone Principal' => 'phonePrinciple',
            'State' => 'getState.name',
            'Status' => 'status',
            'Action' => 'id',
        ];
        $pageStr = "client_table";
        return DataTableHelper::getData($request, $query, $columnMapping, $pageStr);
    }

    //   public function exportClients(Request $request)
    //     {
    //         $query = Client::query();
    //         if ($request->filled('clientStatus')) {
    //             $query->where('status', $request->input('clientStatus'));
    //         }
    //         if ($request->filled('name')) {
    //             $query->where('name', 'like', '%' . $request->input('name') . '%');
    //         }
    //         if ($request->filled('mobileNo')) {
    //             $query->where('mobilePhone', 'like', '%' . $request->input('mobileNo') . '%');
    //         }
    //         if ($request->filled('state')) {
    //             $query->where('state', $request->input('state'));
    //         }
    //         $clients = $query->get();
    //         return Excel::download(new ClientsExport($clients), 'clients.xlsx');
    //     }

    public function exportClients(Request $request)
    {
        $query = Client::query();
        // Check if any filter input is provided
        if ($request->filled('clientStatus') || $request->filled('name') || $request->filled('mobileNo') || $request->filled('state')) {
            // Apply provided filters
            if ($request->filled('clientStatus')) {
                $query->where('status', $request->input('clientStatus'));
            }
            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            }
            if ($request->filled('mobileNo')) {
                $query->where('mobilePhone', 'like', '%' . $request->input('mobileNo') . '%');
            }
            if ($request->filled('state')) {
                $query->where('state', $request->input('state'));
            }
        } else {
            // No filter input found, export active clients by default
            $query->where('status', '1'); // Adjust this condition based on your data
        }
        // Fetch clients based on applied filters or default condition
        $clients = $query->get();
        return Excel::download(new ClientSExport($clients), 'clients.xlsx');
    }

    public function clientAddfirst(Request $request)
    {
        $data['getStates'] = States::where('status', '1')->get();
        $data['types'] = Type::get();
        $data['selectClient'] = Client::get();
        $data['types'] = Type::get();
        return view('admin.client.client-add', $data);
    }

    public function addClient(Request $request)
    {
        //    dd($request->all());
        $name       = $request->input('name');
        $shortName  = $request->input('shortName');
        $acn        = $request->input('acn');
        $abn        = $request->input('abn');
        $state      = $request->input('state');
        $phonePrinciple = $request->input('phonePrinciple');
        $mobilePhone = $request->input('mobilePhone');
        $phomneAux   = $request->input('phomneAux');
        $website     = $request->input('website');
        $notes       = $request->input('notes');
        $clientId   = Client::insertGetId([
            'name'         => $name,
            'shortName'    => $shortName,
            'acn'          => $acn,
            'abn'          => $abn,
            'state'         => $state,
            'phonePrinciple' => $phonePrinciple,
            'mobilePhone'   => $mobilePhone,
            'phomneAux'     => $phomneAux,
            'website'       => $website,
            'notes'          => $notes,
        ]);
        $zipCode = $request->input('zipCode');
        $zipCode = json_decode(json_encode($zipCode));
        if ($zipCode) {
            $zipCode = count($zipCode);
        }
        for ($i = 0; $i < $zipCode; $i++) {
            Clientaddress::insertGetId([
                'clientId'      => $clientId,
                'zipCode'       => $request->input('zipCode')[$i],
                'unit'          => $request->input('unit')[$i],
                'addressNumber' => $request->input('addressNumber')[$i],
                'streetAddress' => $request->input('streetAddress')[$i],
                'suburb'        => $request->input('suburb')[$i],
                'city'          => $request->input('city')[$i],
                'state'         => $request->input('stateId')[$i]
            ]);
        }
        $type = $request->input('hourlyRate');
        $type = json_decode(json_encode($type));
        if ($type) {
            $type = count($type);
        }
        for ($i = 0; $i < $type; $i++) {
            $selectType = DB::table('types')->where('name', $request->input('selectType')[$i])->first()->id;
            Clientrate::insertGetId([
                'clientId'                    => $clientId,
                'type'                        => $selectType,
                'hourlyRateChargeableDays'    => $request->input('hourlyRate')[$i],
                'ourlyRateChargeableNight'     => $request->input('hourlyRateChargeable')[$i],
                'hourlyRateChargeableSaturday' => $request->input('HourlyRateChargeableSaturday')[$i],
                'hourlyRateChargeableSunday'   => $request->input('HourlyRateChargeableSunday')[$i],
                'hourlyRatePayableDay'         => $request->input('HourlyRatePayableDay')[$i],
                'hourlyRatePayableNight'       => $request->input('HourlyRatePayableNight')[$i],
                'hourlyRatePayableSaturday'    => $request->input('HourlyRatePayableSaturday')[$i],
                'hourlyRatePayableSunday'    => $request->input('HourlyRatePayableSunday')[$i]
            ]);
        }
        $CostCenterName = $request->input('CostCenterName1');
        $CostCenterName = json_decode(json_encode($CostCenterName));
        $costCenterNameIds = [];
        if ($CostCenterName) {
            $CostCenterName = count($CostCenterName);
        }
        for ($i = 0; $i < $CostCenterName; $i++) {
            $getClientId = Clientcenter::insertGetId([
                'clientId'             => $clientId,
                'name'                 => $request->input('CostCenterName1')[$i],
            ]);
            $costCenterNameIds[$request->input('CostCenterName1')[$i]] = $getClientId;
        }
        $clientBase = $request->input('clientBase');
        $clientBase = json_decode(json_encode($clientBase));
        if ($clientBase) {
            $clientBase = count($clientBase);
        }
        for ($i = 0; $i < $clientBase; $i++) {
            $clientcentersid = $costCenterNameIds[$request->input('CostCenterName')[$i]] ?? null;
            Clientbase::insertGetId([
                'clientId'             => $clientId,
                'base'                 =>  $request->input('clientBase')[$i],
                'cost_center_name'     =>  $request->input('CostCenterName')[$i],
                'clientcentersid'      =>  $clientcentersid,
                'location'             =>  $request->input('CostCenterLocation')[$i],
            ]);
        }
        return redirect()->route('clients')->with('message', 'Client Basic Information Added Successfully!!');
    }

    public function clientValidateState(Request $request)
    {
        $clientName = $request->input('clientId');
        $stateId = $request->input('state');
        $message = '';
        $clientData = Client::where('name', $clientName)->where('state', $stateId)->first();
        if ($clientData) {
            return response()->json(['status' => 200, 'message' => $message]);
        } else {
            return response()->json(['status' => 400, 'message' => $message]);
        }
    }

    public function clientView(Request $request, $id)
    {
        $data['client'] = Client::with('getaddress', 'getrates', 'getCenter', 'getState')->where('id', $id)->first();
        $data['clientbase'] = Clientbase::orderBy('id', 'DESC')->where('clientId', $id)->get();
        $data['ClientcenterName'] = Clientcenter::select('id', 'name')->orderBy('id', 'DESC')->where('status', 1)->where('clientId', $id)->get();
        return view('admin.client.client-view', $data);
    }

    public function clientEdit(Request $request, $id)
    {
        if (request()->isMethod("post")) {
            $clientId = $id;
            $addressValue = $request->input('addressValue');
            if ($addressValue == '1') {
                $data = array(
                    'name'     => $request->input('name'),
                    'shortName' => $request->input('shortName'),
                    'acn'       =>   $request->input('acn'),
                    'abn'       =>   $request->input('abn'),
                    'state'      =>   $request->input('state'),
                    'phonePrinciple' =>   $request->input('phonePrinciple'),
                    'mobilePhone'    =>   $request->input('mobilePhone'),
                    'phomneAux'       =>   $request->input('phoneAux'),
                    'faxPhone'        =>      $request->input('faqPhone'),
                    'website'         =>     $request->input('webSite'),
                    'notes'           => $request->input('Notes'),
                );
                Client::whereId($id)->update($data);
                return redirect()->back()->with('message', 'Client Basic Information Updated Successfully!');
            }
            if ($addressValue == '2') {
                //  return $request->input('addressstate');
                $clientId = Clientaddress::insertGetId([
                    'clientId'      => $request->input('clientId'),
                    'zipCode'       => $request->input('zipCode') ?? '',
                    'unit'          => $request->input('unit') ?? '',
                    'addressNumber' => $request->input('address') ?? '',
                    'streetAddress' => $request->input('street') ?? '',
                    'suburb'        => $request->input('suburd') ?? '',
                    'city'          => $request->input('city') ?? '',
                    'state'         => $request->input('state') ?? ''
                ]);
                $clientData = Clientaddress::orderBy('id', 'DESC')->where('id', $clientId)->first();
                return response()->json([
                    'success' => '200',
                    'message' => 'Product saved successfully.',
                    'data'   => $clientData
                ]);
            }
            if ($addressValue == '6') {
                $clientId = $request->input('clientId');
                $clientDetail = Client::whereId($clientId)->first();
                $checkClientbase = Clientbase::where('clientId', $clientDetail->id)->where('base', $request->input('clientBase'))->first();
                if (($checkClientbase)) {
                    return response()->json([
                        'success' => '400',
                        'message' => 'Already Added',
                    ]);
                } else {
                    $cleintBaseId = DB::table('clientcenters')->where('status', '1')->where('name', $request->input('clientCenterName'))->where('clientId', $clientDetail->id)->first();
                    $Clientrate = Clientbase::insertGetId([
                        'clientId'             => $clientDetail->id,
                        'base'                 =>  $request->input('clientBase'),
                        'cost_center_name'     =>  $request->input('clientCenterName'),
                        'clientcentersid'      =>  $cleintBaseId->id,
                        'location'             =>  $request->input('baseLocation'),
                    ]);
                    $ClientBase = Clientbase::orderBy('id', 'DESC')->where('id', $Clientrate)->first();
                    $Clientcenter = Clientcenter::orderBy('id', 'DESC')->get();
                    return response()->json([
                        'success' => '200',
                        'message' => 'Clien Base saved successfully',
                        'data'   => $ClientBase,
                    ]);
                }
            }
            if ($addressValue == '3') {
                $clientrate = Clientrate::where('clientId', $request->input('clientId'))->where('type', $request->input('type'))->first();
                if ($clientrate) {
                    $clientRate = Clientrate::where('clientId', $request->input('clientId'))->where('type', $request->input('type'))->update([
                        'clientId'                    => $request->input('clientId'),
                        'type'                        => $request->input('type'),
                        'hourlyRateChargeableDays'    => $request->input('hourlyRate') ?? $clientrate->hourlyRateChargeableDays,
                        'ourlyRateChargeableNight'     => $request->input('hourlyRateChargeable') ?? $clientrate->ourlyRateChargeableNight,
                        'hourlyRateChargeableSaturday' => $request->input('HourlyRateChargeableSaturday') ?? $clientrate->hourlyRateChargeableSaturday,
                        'hourlyRateChargeableSunday'   => $request->input('HourlyRateChargeableSunday') ?? $clientrate->hourlyRateChargeableSunday,
                        'hourlyRatePayableDay'         => $request->input('HourlyRatePayableDay') ?? $clientrate->hourlyRatePayableDay,
                        'hourlyRatePayableNight'       => $request->input('HourlyRatePayableNight') ?? $clientrate->hourlyRatePayableNight,
                        'hourlyRatePayableSaturday'    => $request->input('HourlyRatePayableSaturday') ?? $clientrate->hourlyRatePayableSaturday,
                        'hourlyRatePayableSunday'      => $request->input('HourlyRatePayableSunday') ?? $clientrate->hourlyRatePayableSunday,
                    ]);
                    $clientrate = $clientrate->id;
                    $clientRate = Clientrate::orderBy('id', 'DESC')->where('type', $request->input('type'))->where('id', $clientrate)->first();
                    $clientRate->typeName = Type::whereId($clientRate->type)->first()->name;
                    return response()->json([
                        'success' => '300',
                        'message' => 'Client rate updated successfully.',
                        'data'   => $clientRate
                    ]);
                } else {
                    //     return $request->all();
                    $clientrate = Clientrate::insertGetId([
                        'clientId'                    => $request->input('clientId'),
                        'type'                        => $request->input('type'),
                        'hourlyRateChargeableDays'    => $request->input('hourlyRate') ?? '0',
                        'ourlyRateChargeableNight'     => $request->input('hourlyRateChargeable') ?? '0',
                        'hourlyRateChargeableSaturday' => $request->input('HourlyRateChargeableSaturday') ?? '0',
                        'hourlyRateChargeableSunday'   => $request->input('HourlyRateChargeableSunday') ?? '0',
                        'hourlyRatePayableDay'         => $request->input('HourlyRatePayableDay') ?? '0',
                        'hourlyRatePayableNight'       => $request->input('HourlyRatePayableNight') ?? '0',
                        'hourlyRatePayableSaturday'    => $request->input('HourlyRatePayableSaturday') ?? '0',
                        'hourlyRatePayableSunday'      => $request->input('HourlyRatePayableSunday') ?? '0',
                    ]);
                    $clientRate = Clientrate::orderBy('id', 'DESC')->where('id', $clientrate)->first();
                    $clientRate->typeName = Type::whereId($clientRate->type)->first()->name;
                    return response()->json([
                        'success' => '200',
                        'message' => 'Client rate saved successfully.',
                        'data'   => $clientRate
                    ]);
                }
            }
            if ($addressValue == '4') {
                $clientId = $request->input('clientId');
                $clientDetail = Client::whereId($clientId)->first();
                $checkCost = Clientcenter::where('clientId', $clientDetail->id)->where('name', $request->input('name'))->first();
                if (empty($checkCost)) {
                    $Clientrate = Clientcenter::insertGetId([
                        'clientId'             => $clientDetail->id,
                        'name'                 => $request->input('name'),
                        'state'                => $clientDetail->state,
                        'location'                 =>  $request->input('location'),
                        'client'               => $request->input('selectClient'),
                    ]);
                    $Clientrate = Clientcenter::orderBy('id', 'DESC')->with('getCenterName', 'getCenterState')->where('id', $Clientrate)->first();
                    return response()->json([
                        'success' => '200',
                        'message' => 'Clien center saved successfully.',
                        'data'   => $Clientrate,
                    ]);
                } else {
                    return response()->json([
                        'success' => '400',
                        'message' => 'Already Added',
                    ]);
                }
            }
        }
        $data['Editclient'] = Client::orderBy('id', 'DESC')->with('getaddress', 'getCenter.getCenterName', 'getrates.getType', 'getCenterState')->where('id', $id)->first();
        //    dd($data['Editclient']);
        $data['clientbase'] = Clientbase::orderBy('id', 'DESC')->where('clientId', $id)->get();
        //  dd($data['clientbase']);
        $data['ClientcenterName'] = Clientcenter::select('id', 'name')->orderBy('id', 'DESC')->where('status', '1')->where('clientId', $id)->get();
        $data['clientId'] = $id;
        $data['types'] = Type::get();
        $data['selectClient'] = Client::get();
        $data['getStates'] = States::get();
        return view('admin.client.client-edit', $data);
    }


    public function clientRateEdit(Request $request)
    {
        $clientRate = Clientrate::where('clientId', $request->input('clientId'))->where('type', $request->input('typeiD'))->update([
            'clientId'                    => $request->input('clientId'),
            'type'                        => $request->input('type'),
            'hourlyRateChargeableDays'    => $request->input('hourlyRate') ?? '0',
            'ourlyRateChargeableNight'     => $request->input('hourlyRateChargeable') ?? '0',
            'hourlyRateChargeableSaturday' => $request->input('HourlyRateChargeableSaturday') ?? '0',
            'hourlyRateChargeableSunday'   => $request->input('HourlyRateChargeableSunday') ?? '0',
            'hourlyRatePayableDay'         => $request->input('HourlyRatePayableDay') ?? '0',
            'hourlyRatePayableNight'       => $request->input('hourlyRatePayableNight1') ?? '0',
            'hourlyRatePayableSaturday'    => $request->input('HourlyRatePayableSaturday') ?? '0',
            'hourlyRatePayableSunday'      => $request->input('HourlyRatePayableSunday') ?? '0',
        ]);
        return redirect()->back()->with('message', 'Client Rate Updated  Successfully!!');
    }


    public function clientdelete(Request $request)
    {
        $id = $request->input('clientId');
        $deleteData = Clientaddress::whereId($id)->delete();
        if ($deleteData) {
            return response()->json([
                'success' => '200',
                'message' => 'Clien Delete  successfully.',
            ]);
        }
    }


    public function deleteClient(Request $request)
    {
      $id = $request->input('id');
      try {
          //code...
          Client::whereId($id)->update(['status' => '2']);
          return true;
      } catch (\Throwable $th) {
          return false;
          //throw $th;
      }
    }

    public function clientbase(Request $request)
    {
        $id = $request->input('clientId');
        $deleteData = Clientbase::whereId($id)->delete();
        if ($deleteData) {
            return response()->json([
                'success' => '200',
                'message' => 'Clien Base  successfully.',
            ]);
        }
    }

    public function clientlistDelete(Request $request, $id)
    {
        $deleteData = Client::whereId($id)->update(['status' => '2']);
        if ($deleteData) {
            return redirect()->back()->with('message', 'Client Deleted Successfully!');
        }
    }

    public function clientrate(Request $request)
    {
        $id = $request->input('clientId');
        $deleteData = Clientrate::whereId($id)->delete();
        if ($deleteData) {
            return response()->json([
                'success' => '200',
                'message' => 'Client Rate Deleted Successfully!',
            ]);
        } else {
            return response()->json([
                'success' => '400',
                'message' => 'Server Error!',
            ]);
        }
    }
    
    public function clientcenters(Request $request)
    {
        $id = $request->input('clientId');
        $Clientcenter = Clientcenter::where('id', $id)->first()->name;
        $deleteData = Clientcenter::whereId($id)->delete();
        $deleteData = Clientbase::where('cost_center_name', $Clientcenter)->delete();
        if ($deleteData) {
            return response()->json([
                'success' => '200',
                'message' => 'Client Center Deleted Successfully!',
            ]);
        } else {
            return response()->json([
                'success' => '400',
                'message' => 'Server Error!',
            ]);
        }
    }
    public function clientStatus(Request $request)
    {
        $client = Client::whereId($request->input('clientId'))->update(['status' => $request->input('statusValue')]);
        if ($client) {
            return response()->json([
                'success' => '200',
                'message' => 'Done.',
            ]);
        }
    }
}
