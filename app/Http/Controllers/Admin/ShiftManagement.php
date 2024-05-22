<?php
namespace App\Http\Controllers\Admin;
use App\Exports\ShiftReportsExport;
use App\Helpers\DataTableHelper;
use App\Helpers\DataTableShiftHelper;
use DateTime;
use ZipArchive;
use Carbon\Carbon;
use App\Models\rego;
use App\Models\Type;
use App\Models\Shift;
use App\Models\Client;
use App\Models\Driver;
use App\Models\States;
use App\Models\Parcels;
use App\Models\Vehical;
use App\Models\Clientbase;
use App\Models\Clientrate;
use App\Models\Finishshift;
use App\Traits\CommonTrait;
use App\Imports\UsersImport;
use App\Models\Alldropdowns;
use App\Models\Clientcenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\shiftMonetizeInformation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
class ShiftManagement extends Controller
{
    use CommonTrait;
    public function shift(Request $request)
    {
        $query = Shift::select('id', 'rego', 'odometer', 'driverId', 'parcelsToken', 'client', 'costCenter', 'status', 'state', 'finishStatus', 'vehicleType', 'created_at', 'updated_at');
        $data['status'] = $request->input('shiftStatus');
        if ($data['status']) {
            $query = $query->where('status', $data['status']);
        }
        $data['shift'] = $query->orderBy('id', 'DESC')->with('getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name')->get();
        
        return view('admin.shift.shift', $data);
    }
    public function importClient(Request $request)
    {
        $file = $request->file('excel_file');
        $filePath = $file->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = [];
        $clientIds = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $kk => $cell) {
                $rowData[] = $cell->getValue();
            }
            $data[] = $rowData;
        }
        unset($data[0]);
        foreach ($data as $kk => $rd) {
            $clientIds[$kk] =
                [
                    'id' => $rd[0],
                    'clientName' => $rd[1],
                    'cost' => $rd[2],
                    'driver' => $rd['3'],
                    'base' => $rd['5'],
                    'parcelTaken' => $rd['6'],
                ];
        }
        foreach ($clientIds as $datas) {
            if ($datas['status'] == "TO_APPROVE") {
                $status = '2';
            }
            $shift =  DB::table('clients')->insertGetId([
                'clientName' => $rd[1],
                'cost' => $rd[2],
                'driver' => $rd['3'],
                'base' => $rd['5'],
            ]);
        }
    }
    public function importClientRate(Request $request)
    {
        $file = $request->file('excel_file');
        $filePath = $file->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = [];
        $clientIds = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $kk => $cell) {
                $rowData[] = $cell->getValue();
            }
            $data[] = $rowData;
        }
        unset($data[0]);
        foreach ($data as $kk => $rd) {
            $clientIds[$kk] =
                [
                    'id' => $rd[0],
                    'clientName' => $rd[1],
                    'cost' => $rd[2],
                    'driver' => $rd['3'],
                    'base' => $rd['5'],
                    'parcelTaken' => $rd['6'],
                ];
        }
        foreach ($clientIds as $datas) {
            if ($datas['status'] == "TO_APPROVE") {
                $status = '2';
            }
            $shift =  DB::table('clientrates')->insertGetId([
                'clientName' => $rd[1],
                'cost' => $rd[2],
                'driver' => $rd['3'],
                'base' => $rd['5'],
            ]);
        }
    }
    public function importClientBase(Request $request)
    {
        $file = $request->file('excel_file');
        $filePath = $file->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = [];
        $clientIds = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $kk => $cell) {
                $rowData[] = $cell->getValue();
            }
            $data[] = $rowData;
        }
        unset($data[0]);
        foreach ($data as $kk => $rd) {
            $clientIds[$kk] =
                [
                    'id' => $rd[0],
                    'clientName' => $rd[1],
                    'cost' => $rd[2],
                    'driver' => $rd['3'],
                    'base' => $rd['5'],
                    'parcelTaken' => $rd['6'],
                ];
        }
        foreach ($clientIds as $datas) {
            if ($datas['status'] == "TO_APPROVE") {
                $status = '2';
            }
            $shift =  DB::table('clientbases')->insertGetId([
                'clientName' => $rd[1],
                'cost' => $rd[2],
                'driver' => $rd['3'],
                'base' => $rd['5'],
            ]);
        }
    }
    //  public function importShift(Request $request)
    //     {
    //         $file = $request->file('excel_file');
    //         $filePath = $file->getRealPath();
    //         $spreadsheet = IOFactory::load($filePath);
    //         $worksheet = $spreadsheet->getActiveSheet();
    //         $data = [];
    //         $clientIds = [];
    //         foreach ($worksheet->getRowIterator() as $row) {
    //             $rowData = [];
    //             foreach ($row->getCellIterator() as $kk=>$cell) {
    //                 $rowData[] = $cell->getValue();
    //             }
    //             $data[] = $rowData;
    //         }
    //         unset($data[0]);
    //         foreach($data as $kk=>$rd)
    //         {
    //             $clientIds[$kk] = [
    //                                     'id' => $rd[0],
    //                                     'clientName' => $rd[1],
    //                                     'cost' => $rd[2],
    //                                     'driver' =>$rd['3'],
    //                                     'base' =>$rd['5'],
    //                                     'parcelTaken' =>$rd['6'],
    //                                     'parcelDelivery' =>$rd['7'],
    //                                     'outstandingParcel'  =>$rd['8'],
    //                                     'rego'  =>$rd['9'],
    //                                     'vehicleType'  =>$rd['10'],
    //                                     'state'  =>$rd['11'],
    //                                     'DateStart'  =>$rd['12'],
    //                                     'timeStart'  =>$rd['13'],
    //                                     'dateFinish'  =>$rd['14'],
    //                                     'finishTime'  =>$rd['15'],
    //                                     'status'  =>$rd['16'],
    //                                     'totalPayable'  =>$rd['33'],
    //                                     'totalHr'  =>$rd['17'],
    //                                     'dayhr'  =>$rd['18'],
    //                                     'nighthr'  =>$rd['19'],
    //                                     'weekendhr'  =>$rd['20'],
    //                                     'amountPayableDayShift'  =>$rd['21'],
    //                                     'amountChargeableDayShift'  =>$rd['22'],
    //                                     'amountPayableNightShift' =>$rd['23'],
    //                                     'amountChargeableNightShift'  =>$rd['24'],
    //                                     'amountPayableWeekendShift'  =>$rd['25'],
    //                                     'amountChargeableWeekendShift'  =>$rd['26'],
    //                                     'odometerStart'   =>$rd['35'],
    //                                     'odometerEnd'   =>$rd['36'],
    //                                     'fuelLevyPayable'=>$rd['27'],
    //                                     'fuelLevyChargeableFixed'=>$rd['28'],
    //                                     'fuelLevyChargeable250'=>$rd['29'],
    //                                     'FuelLevyChargeable400'=>$rd['30'],
    //                                     'ExtraPayable' =>$rd['31'],
    //                                     'ExtraChargeAble' =>$rd['32'],
    //                                     'TotalChargeable'=>$rd['34'],
    //                                     'traveledKm'=>$rd['37'],
    //                                     'comment'=>$rd['38'],
    //                                 ];
    //         }
    //         foreach($clientIds as $datas)
    //         {
    //             if($datas['status']=="TO_APPROVE")
    //             {
    //                 $status='2';
    //             }
    //             if($datas['status']=="APPROVED")
    //             {
    //                 $status='3';
    //             }
    //             // Start Date
    //              $phpDateTime = Date::excelToDateTimeObject($datas['DateStart']);
    //              $startDate = $phpDateTime->format('Y/m/d');
    //              // End Date
    //               // End Date
    //               $phpDateTime = Date::excelToDateTimeObject($datas['dateFinish']);
    //               $endDate = $phpDateTime->format('Y/m/d');
    //               // End Date
    //              $clientName=Client::where('name',$datas['clientName'])->first()->id?? 0;
    //              $state=States::where('name',$datas['state'])->first()->id?? 0;
    //              $driver=Driver::where('fullName',$datas['driver'])->first()->id?? 0;
    //              $clientcenters=DB::table('clientcenters')->where('name',$datas['cost'])->first()->id?? 0;
    //              $vehicleRego=DB::table('vehicals')->where('rego',$datas['rego'])->first()->id?? 0;
    //              $type=DB::table('types')->where('name',$datas['vehicleType'])->first()->id?? 0;
    //             $shift =  DB::table('shifts')->insertGetId([
    //                                     'shiftRandId' => $datas['id'],
    //                                     'client'      => $clientName,
    //                                     'state'       => $state,
    //                                     'driverId'    => $driver,
    //                                     'costCenter'  => $clientcenters,
    //                                     'base'        => $datas['base'],  /////
    //                                     'rego'        => $vehicleRego,
    //                                     'vehicleType' => $type,
    //                                     'parcelsToken'=> $datas['parcelTaken'],
    //                                     'shiftStartDate'=>$startDate.' '.$datas['timeStart'],
    //                                     'finishStatus' => $status,
    //                                     'payAmount' => $datas['totalPayable'],
    //                                     'chageAmount' => $datas['TotalChargeable'],
    //                                 ]);
    //               Finishshift::insert([
    //                                    'startDate' =>$startDate,
    //                                    'endDate' =>$endDate,
    //                                    'startTime'=>$datas['timeStart'],
    //                                    'endTime'=>$datas['finishTime'],
    //                                     'shiftId'=> $shift,
    //                                     'driverId'=> $driver,
    //                                     'totalHours' =>$datas['totalHr'],
    //                                     'dayHours' =>$datas['dayhr'],
    //                                     'nightHours' =>$datas['nighthr'],
    //                                     'weekendHours' =>$datas['weekendhr'],
    //                                     'amount_payable_day_shift' =>$datas['amountPayableDayShift'],
    //                                     'amount_chargeable_day_shift'=>$datas['amountChargeableDayShift'],
    //                                     'amount_payable_night_shift'=>$datas['amountPayableNightShift'],
    //                                     'amount_chargeable_night_shift'=>$datas['amountChargeableNightShift'],
    //                                     'amount_payable_weekend_shift'=>$datas['amountPayableWeekendShift'],
    //                                     'amount_chargeable_weekend_shift'=>$datas['amountChargeableWeekendShift'],
    //                                     'odometerStartReading' =>$datas['odometerStart'],
    //                                     'odometerEndReading' =>$datas['odometerEnd'],
    //                                 ]);
    //              DB::table('shiftMonetizeInformation')->insert([
    //                                                                 'shiftId'=>$shift,
    //                                                                 'fuelLevyPayable' =>$datas['fuelLevyPayable'],
    //                                                                 'fuelLevyChargeable' =>$datas['fuelLevyChargeableFixed'],
    //                                                                 'fuelLevyChargeable250' =>$datas['fuelLevyChargeable250'],
    //                                                                 'fuelLevyChargeable400' =>$datas['FuelLevyChargeable400'],
    //                                                                 'extraPayable' =>$datas['ExtraPayable'],
    //                                                                 'extraChargeable' =>$datas['ExtraChargeAble'],
    //                                                                 'totalChargeable' =>$datas['TotalChargeable'],
    //                                                             ]);
    //          }
    //         // Access the data array, which contains row and column information
    //       //  dd($data);
    //         // $desiredRowIndex = 2;
    //         // foreach ($worksheet->getRowIterator() as $key => $row)
    //         // {
    //             // $rowData = [];
    //             // foreach ($row->getCellIterator() as $cell) {
    //             //     $rowData[] = $cell->getValue();
    //             // }
    //             // // Process the row data as needed
    //             // // Assuming you want values from the second column (index 1)
    //             //     $valueFromSecondColumn = $rowData[1] ?? null;
    //             //     // Process the value as needed
    //             //     if ($valueFromSecondColumn !== null) {
    //             //         dd($valueFromSecondColumn);
    //             //     }
    //             // $rowData = [];
    //             // foreach ($row->getCellIterator() as $cell) {
    //             //     $rowData[] = $cell->getValue();
    //             // }
    //             // // Get first row
    //             // $clientId = $rowData[1] ?? null;
    //             // if ($clientId !== null && $clientId !== '') {
    //             //     $clientIds[] = $clientId;
    //             // }
    //             // $clientName = $rowData[3] ?? null;
    //             // if ($clientName !== null && $clientName !== '') {
    //             //     $clientNames[] = $clientName;
    //             // }
    //             // $clientState = $rowData[10] ?? null;
    //             // if ($clientState !== null && $clientState !== '') {
    //             //     $clientStates[] = $clientState;
    //             // }
    //             // End first Row
    //             // foreach ($row->getCellIterator() as $cell) {
    //             //     // Check if the cell belongs to the desired row
    //             //     if ($cell->getRow() == $desiredRowIndex) {
    //             //         $valueFromDesiredRow = $cell->getValue();
    //             //         // Process the value as needed
    //             //         dd($valueFromDesiredRow);
    //             //     }
    //             // }
    //    //     }
    //         // foreach($clientNames as $clientNm)
    //         // {
    //         //     if($clientNm != "Client")
    //         //     {
    //         //         foreach($clientIds as $clientId)
    //         //         {
    //         //             echo $clientNm;
    //         //            //  Client::where('id', $clientId)->update(['name' => $clientNm]);
    //         //         }
    //         //         // $stateId = Client::find($clientIds)->state;
    //         //         // States::where('id', $stateId)->update(['name' => $clientNames[10]]);
    //         //     }
    //         // }
    //          return redirect()->back()->with('message', 'Shift Import Updated Successfully!!');
    //     }
    public function importShift(Request $request)
    {
        $file = $request->file('excel_file');
        $filePath = $file->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = [];
        $clientIds = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $kk => $cell) {
                $rowData[] = $cell->getValue();
            }
            $data[] = $rowData;
        }
        unset($data[0]);
        // unset($data[1]);
        foreach ($data as $kk => $rd) {
            $clientIds[$kk] = [
                'shiftId'         => $rd[0],
                'parcel_taken'    => $rd[4],
                'parcel_delivery' => $rd[5],
                'state'           =>  $rd[8],
                'created_at'      => $rd[9],
                'date_start' => $rd[10],
                'time_start' => $rd[11],
                'date_finish' => $rd[12],
                'time_finish' => $rd[13],
                'total_hours'  => $rd['15'],
                'amount_chargeable_day_shift' => $rd['16'],
                'amount_payable_day_shift'  => $rd['17'],
                'amount_payable_night_shift'  => $rd['18'],
                'amount_chargeable_night_shift' => $rd['19'],
                'amount_payable_weekend_shift' => $rd['20'],
                'amount_chargeable_weekend_shift' => $rd['21'],
                'fuel_levy_pay' => $rd['22'],
                'fuel_levy_charge' => $rd['23'],
                'fuel_levy_chargeable' => $rd['24'],
                'fuel_levy_chargeable400' => $rd['25'],
                'extra_payable' => $rd['26'],
                'extra_chargeable' => $rd['27'],
                'total_chargeable' => $rd['28'],
                'odometer_start' => $rd['29'],
                'odometer_end' => $rd['30'],
                'total_payable' => $rd['31'],
                'traveled_km' => $rd['32'],
                'comment' => $rd['33']
            ];
        }
        // dd($clientIds);
        foreach ($clientIds as $datas) {
            // if ($datas['odometer_start'] && $datas['odometer_end'])
            // {
            //     return Redirect::back()->with('warning', 'Odometer Start  And Odometer End Can Not be Null ');
            //  }
            $phpDateTime = Date::excelToDateTimeObject($datas['date_finish']);
            $created_at = $phpDateTime->format('Y/m/d H:s:i');
            $shift = preg_replace("/[^0-9]/", "", $datas['shiftId']);
            dd($datas['total_payable'],);
            Shift::where('shiftRandId', $shift)->update([
                'payAmount' => $datas['total_payable'],
                'created_at' => $created_at,
            ]);
            Finishshift::where('shiftId', $shift)->update([
                //  'startTime' =>$datas['time_start'],
                'totalHours' => $datas['total_hours'],
                // 'endDate' =>$datas['date_finish'],
                //  'dayHours' =>$datas['total_morning'],
                //  'nightHours' =>$datas['total_night'],
                // 'weekendHours' =>$datas['hours_weekend_shift'],
                'amount_payable_day_shift' => $datas['amount_payable_day_shift'],
                'amount_chargeable_day_shift' => $datas['amount_chargeable_day_shift'],
                'amount_payable_night_shift' => $datas['amount_payable_night_shift'],
                'amount_chargeable_night_shift' => $datas['amount_chargeable_night_shift'],
                'amount_payable_weekend_shift' => $datas['amount_payable_weekend_shift'],
                'amount_chargeable_weekend_shift' => $datas['amount_chargeable_weekend_shift'],
                'odometerStartReading' => $datas['odometer_start'] ?? 0,
                'odometerEndReading' => $datas['odometer_end'] ?? 0,
            ]);
            DB::table('y')->where('shiftId', $shift)->update([
                'fuelLevyPayable' => $datas['fuel_levy_pay'],
                'fuelLevyChargeable' => $datas['fuel_levy_charge'],
                'fuelLevyChargeable250' => $datas['fuel_levy_chargeable'],
                'fuelLevyChargeable400' => $datas['fuel_levy_chargeable400'],
                'extraPayable' => $datas['extra_payable'],
                'extraChargeable' => $datas['extra_chargeable'],
                'totalChargeable' => $datas['total_chargeable'],
            ]);
        }
        return redirect()->back()->with('message', 'Shift Import Updated Successfully!!');
    }
    // public function importShift(Request $request)
    // {
    //     $file = $request->file('excel_file');
    //     $filePath = $file->getRealPath();
    //     $spreadsheet = IOFactory::load($filePath);
    //     $worksheet = $spreadsheet->getActiveSheet();
    //     $data = [];
    //     $clientIds = [];
    //     foreach ($worksheet->getRowIterator() as $row) {
    //         $rowData = [];
    //         foreach ($row->getCellIterator() as $kk => $cell) {
    //             $rowData[] = $cell->getValue();
    //         }
    //         $data[] = $rowData;
    //     }
    //     unset($data[0]);
    //     foreach ($data as $kk => $rd) {
    //         $clientIds[$kk] = [
    //             'id' => $rd[1],
    //             'name' => $rd[3],
    //             'state' => $rd[10],
    //             'clientcenters' => $rd['4'],
    //             'shiftId' => $rd['2'],
    //             'created_at' => $rd['11'],
    //             'date_start' => $rd['12'],
    //             'time_start'  => $rd['13'],
    //             'endDate'  => $rd['14'],
    //             'time_finish'  => $rd['15'],
    //             'total_hours'  => $rd['18'],
    //             'total_morning'  => $rd['19'],
    //             'total_night'  => $rd['20'],
    //             'hours_weekend_shift'  => $rd['21'],
    //             'amount_payable_day_shift'  => $rd['23'],
    //             'amount_chargeable_day_shift'  => $rd['22'],
    //             'amount_payable_night_shift'  => $rd['24'],
    //             'amount_chargeable_night_shift' => $rd['25'],
    //             'amount_payable_weekend_shift' => $rd['26'],
    //             'amount_chargeable_weekend_shift' => $rd['27'],
    //             'fuel_levy_pay' => $rd['28'],
    //             'fuel_levy_charge' => $rd['29'],
    //             'fuel_levy_chargeable' => $rd['30'],
    //             'fuel_levy_chargeable400' => $rd['31'],
    //             'extra_payable' => $rd['32'],
    //             'extra_chargeable' => $rd['33'],
    //             'total_chargeable' => $rd['34'],
    //             'odometer_start' => $rd['35'],
    //             'odometer_end' => $rd['36'],
    //             'total_payable' => $rd['37'],
    //             'traveled_km' => $rd['38']
    //         ];
    //     }
    //     //   dd($clientIds);
    //     foreach ($clientIds as $datas) {
    //         if (isset($datas['date_start']) && $datas['date_start'] !== 'N/A') {
    //             $phpDateTime = Date::excelToDateTimeObject($datas['date_start']);
    //             $startDate = $phpDateTime->format('Y/m/d');
    //             // End Date  date_finish
    //         } else {
    //             $startDate = 'N/A';
    //         }
    //         // End Date
    //         if (isset($datas['endDate']) && $datas['endDate'] !== 'N/A') {
    //             $phpDateTime = Date::excelToDateTimeObject($datas['endDate']);
    //             $endDateTimestamp = $phpDateTime->getTimestamp();
    //             $endDate = date('Y/m/d', $endDateTimestamp);
    //         } else {
    //             $endDate = 'N/A';
    //         }
    //         // End Date
    //         $shift = preg_replace("/[^0-9]/", "", $datas['shiftId']);
    //         //   return $datas['time_start'];
    //         Shift::where('id', $shift)->update([
    //             'payAmount' => $datas['total_payable'],
    //             // 'created_at'=>$datas['created_at'],
    //             //    'shiftStartDate'=>$startDate  timeStart
    //             'shiftStartDate' => $startDate
    //         ]);
    //         Finishshift::where('shiftId', $shift)->update([
    //             'startTime' => $datas['time_start'],
    //             'totalHours' => $datas['total_hours'],
    //             'endDate' => $endDate,
    //             'dayHours' => $datas['total_morning'],
    //             'nightHours' => $datas['total_night'],
    //             'weekendHours' => $datas['hours_weekend_shift'],
    //             'amount_payable_day_shift' => $datas['amount_payable_day_shift'],
    //             'amount_chargeable_day_shift' => $datas['amount_chargeable_day_shift'],
    //             'amount_payable_night_shift' => $datas['amount_payable_night_shift'],
    //             'amount_chargeable_night_shift' => $datas['amount_chargeable_night_shift'],
    //             'amount_payable_weekend_shift' => $datas['amount_payable_weekend_shift'],
    //             'amount_chargeable_weekend_shift' => $datas['amount_chargeable_weekend_shift'],
    //             'odometerStartReading' => $datas['odometer_start'],
    //             'odometerEndReading' => $datas['odometer_end'],
    //         ]);
    //         DB::table('shiftMonetizeInformation')->where('shiftId', $shift)->update([
    //             'fuelLevyPayable' => $datas['fuel_levy_pay'],
    //             'fuelLevyChargeable' => $datas['fuel_levy_charge'],
    //             'fuelLevyChargeable250' => $datas['fuel_levy_chargeable'],
    //             'fuelLevyChargeable400' => $datas['fuel_levy_chargeable400'],
    //             'extraPayable' => $datas['extra_payable'],
    //             'extraChargeable' => $datas['extra_chargeable'],
    //             'totalChargeable' => $datas['total_chargeable'],
    //         ]);
    //     }
    //     // Access the data array, which contains row and column information
    //     //  dd($data);
    //     // $desiredRowIndex = 2;
    //     // foreach ($worksheet->getRowIterator() as $key => $row)
    //     // {
    //     // $rowData = [];
    //     // foreach ($row->getCellIterator() as $cell) {
    //     //     $rowData[] = $cell->getValue();
    //     // }
    //     // // Process the row data as needed
    //     // // Assuming you want values from the second column (index 1)
    //     //     $valueFromSecondColumn = $rowData[1] ?? null;
    //     //     // Process the value as needed
    //     //     if ($valueFromSecondColumn !== null) {
    //     //         dd($valueFromSecondColumn);
    //     //     }
    //     // $rowData = [];
    //     // foreach ($row->getCellIterator() as $cell) {
    //     //     $rowData[] = $cell->getValue();
    //     // }
    //     // // Get first row
    //     // $clientId = $rowData[1] ?? null;
    //     // if ($clientId !== null && $clientId !== '') {
    //     //     $clientIds[] = $clientId;
    //     // }
    //     // $clientName = $rowData[3] ?? null;
    //     // if ($clientName !== null && $clientName !== '') {
    //     //     $clientNames[] = $clientName;
    //     // }
    //     // $clientState = $rowData[10] ?? null;
    //     // if ($clientState !== null && $clientState !== '') {
    //     //     $clientStates[] = $clientState;
    //     // }
    //     // End first Row
    //     // foreach ($row->getCellIterator() as $cell) {
    //     //     // Check if the cell belongs to the desired row
    //     //     if ($cell->getRow() == $desiredRowIndex) {
    //     //         $valueFromDesiredRow = $cell->getValue();
    //     //         // Process the value as needed
    //     //         dd($valueFromDesiredRow);
    //     //     }
    //     // }
    //     //     }
    //     // foreach($clientNames as $clientNm)
    //     // {
    //     //     if($clientNm != "Client")
    //     //     {
    //     //         foreach($clientIds as $clientId)
    //     //         {
    //     //             echo $clientNm;
    //     //            //  Client::where('id', $clientId)->update(['name' => $clientNm]);
    //     //         }
    //     //         // $stateId = Client::find($clientIds)->state;
    //     //         // States::where('id', $stateId)->update(['name' => $clientNames[10]]);
    //     //     }
    //     // }
    //     return redirect()->back()->with('message', 'Data Updated Successfully!!');
    // }
    public function shiftAdd(Request $request)
    {
        try {
            if (request()->isMethod("post")) {
                $driverId  = $request->driverId;
                $shift = Shift::where('driverId', $driverId)->first()->id;
                $checkExisted = FinishShift::where('shiftId', $shift)->first();
                if ($checkExisted !="") {
                    return redirect()->back()->with('error','Shift has started already, please finish your current shift');
                }
                else{
                    $inputtypeRego1 = $request->input('inputtypeRego1');
                    $inputtypeRego2 = $request->input('inputtypeRego2');
                    if ($inputtypeRego2) {
                        $regoId = Vehical::where('rego', $inputtypeRego2)->first();
                        $regoId = $regoId->id;
                    } else {
                        $vehicleType = $request->input('vehicleType');
                        $vehicle = new Vehical();
                        $vehicle->vehicalType = $vehicleType;
                        $vehicle->rego = $inputtypeRego1;
                        $vehicle->save();
                        $regoId = $vehicle->id;
                    }
                    $shiftAdd = $request->except(['_token', 'submit']);
                    $shiftAdd['shiftRandId'] = rand('9999', '0000');
                    $shiftAdd['finishStatus'] = '1';
                    $shiftAdd['shiftStartDate'] = date('Y-m-d H:i');
                    $shiftAdd['rego'] = $regoId;
                    $shift = Shift::create($shiftAdd);
                    return Redirect::route('admin.shift.report')->with('message', 'Shift Added Successfully!!');
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('Something went wrong');
        }
        $data['driverAdd'] = Driver::where('status', '1')->get();
        $data['client'] = Client::get();
        $data['type'] = Type::get();
        $data['regoAll'] = Vehical::where('status', '1')->get();
        $data['states'] = States::where('status', '1')->get();
        return view('admin.shift.shift-add', $data);
    }
    function calculateShiftHoursWithMinutes($startDate, $endDate)
    {
        $dayMinutes = 0;
        $nightMinutes = 0;
        $saturdayMinutes = 0;
        $sundayMinutes = 0;
        while ($startDate < $endDate) {
            $currentHour = date('H', $startDate);
            $currentMinute = date('i', $startDate);
            if (date('N', $startDate) < 6 && ($currentHour >= 4 && $currentHour < 18)) {
                $dayMinutes++;
            } elseif (date('N', $startDate) < 6 && ($currentHour >= 18 || $currentHour < 4)) {
                $nightMinutes++;
            } elseif ($currentHour >= 0 && $currentHour <= 23 && date('N', $startDate) == 6) { // Saturday
                $saturdayMinutes++;
            } elseif ($currentHour >= 0 && $currentHour <= 23 && date('N', $startDate) == 7) { // Sunday
                $sundayMinutes++;
            }
            $startDate = strtotime('+1 minute', $startDate);
        }
        return  [
            'dayHours' => floor($dayMinutes / 60),
            'dayMinutes' => $dayMinutes % 60 < 10 ? "0" . ($dayMinutes % 60) : $dayMinutes % 60,
            'dayMinutesNew' => round(floor($dayMinutes % 60) / 60, 2),
            'dayTotal' => number_format(floor($dayMinutes / 60) + round(floor($dayMinutes % 60) / 60, 2), 2),
            'nightHours' => floor($nightMinutes / 60),
            'nightMinutes' => $nightMinutes % 60 < 10 ? "0" . ($nightMinutes % 60) : $nightMinutes % 60,
            'nightMinutesNew' => round(floor($nightMinutes % 60) / 60, 2),
            'nightTotal' => number_format(floor($nightMinutes / 60) + round(floor($nightMinutes % 60) / 60, 2), 2),
            'saturdayHours' => floor($saturdayMinutes / 60),
            'saturdaMinutes' => $saturdayMinutes % 60,
            'saturdayMinutesNew' => round(floor($saturdayMinutes % 60) / 60, 2),
            'totalSaturdayHours' => number_format(floor($saturdayMinutes / 60) + round(floor($saturdayMinutes % 60) / 60, 2), 2),
            'sundayHours' => floor($sundayMinutes / 60),
            'sundayMinutes' => $sundayMinutes % 60,
            'sundayMinutesNew' => round(floor($sundayMinutes % 60) / 60, 2),
            'totalSundayHours' => number_format(floor($sundayMinutes / 60) + round(floor($sundayMinutes % 60) / 60, 2), 2),
        ];
    }
    public function shiftMissedAdd(Request $request)
    {
        $data['parcelsTaken']           = $request->parcelsToken;
        $data['parcel_delivered']       = $request->parcel_delivered;
        $data['odometer_start_reading'] = $request->odometer_start_reading;
        $data['odometer_finish_reading'] = $request->odometer_finish_reading;
        if (request()->isMethod("post")) {
            //   return $request->start_date;
            $parcelsTaken           = $request->parcelsToken;
            $parcel_delivered       = $request->parcel_delivered;
            $data['odometer_start_reading'] = $request->odometer_start_reading;
            $data['odometer_finish_reading'] = $request->odometer_finish_reading;
            $end_date = $request->input('end_date');
            if (empty($end_date)) {
                return redirect()->back()->with('info', 'Please Add End Date');
            }
            $inputtypeRego1 = $request->input('inputtypeRego1');
            $inputtypeRego2 = $request->input('inputtypeRego2');
            if ($inputtypeRego2) {
                $regoId = Vehical::where('rego', $inputtypeRego2)->first();
                $regoId = $regoId->id;
            } else {
                $vehicleType = $request->input('vehicleType');
                $vehicle = new Vehical();
                $vehicle->vehicalType = $vehicleType;
                $vehicle->rego = $inputtypeRego1;
                $vehicle->save();
                $regoId = $vehicle->id;
            }
            $shiftAdd = $request->except(['_token', 'submit']);
            $shiftAdd['shiftRandId'] = rand('9999', '0000');
            $odometerStart = $request->input('odometer_start_reading') ?? '0';
            $odometerFinish = $request->input('odometer_finish_reading') ?? '0';
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            if (is_numeric($odometerStart) && is_numeric($odometerFinish)) {
                $shiftAdd['odometer'] = $odometerFinish - $odometerStart;
            }
            $shiftAdd['rego'] = $regoId;
            $shiftAdd['shiftStartDate'] = $start_date;
            $shiftAdd['finishDate'] = $end_date;
            $shify = Shift::create($shiftAdd);
            $getClientID = Shift::whereId($shify->id)->first()->client;
            $query = Shift::where('id', $shify->id);
            $data['shiftView'] = $query->orderBy('id', 'DESC')->with(['getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates', 'getClientCharge' => function ($query) use ($getClientID) {
                $query->where('clientId', $getClientID);
            }])->first();
            $priceCompare = DB::table('personrates')->where('type', $data['shiftView']->vehicleType)->where('personId', $data['shiftView']->driverId)->first();
            $startDate    = strtotime($request->start_date);
            $endDate      = strtotime($request->end_date);
            $dayStartTime = Carbon::parse($startDate);
            $nightEndTime = Carbon::parse($endDate);
            $result = $this->calculateShiftHoursWithMinutes($startDate, $endDate);
            $dayHr       =   $result['dayTotal'];
            $nightHr     =   $result['nightTotal'];
            $saturdayHrs =   $result['totalSaturdayHours'];
            $sundayHrs   =   $result['totalSundayHours'];
            $weekend     =   $saturdayHrs + $sundayHrs;
            $dayShift           = '0';
            $nightShift         = '0';
            $sundayHr           = '0';
            $saturdayHr         = '0';
            $dayShiftCharge     =  '0';
            $nightShiftCharge    = '0';
            $saturdayShiftCharge = '0';
            $sundayShiftCharge   = '0';
            $priceOverRideStatus = '0';
            $totalChargeDay      = '0';
            if (!empty($dayHr) || !empty($nightHr)   || !empty($saturdayHrs)   || !empty($sundayHrs)) {
                if (!empty($dayHr)) {
                    if (empty($priceCompare)) {
                        $dayShift = $data['shiftView']->getClientCharge->hourlyRatePayableDay * $dayHr;
                        $priceOverRideStatus = '0';
                        $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays * $dayHr ?? 0;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay) {
                            $dayShift = $data['shiftView']->getClientCharge->hourlyRatePayableDay * $dayHr ?? 0;
                            $priceOverRideStatus = '0';
                            $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays * $dayHr ?? 0;
                        } else {
                            $priceComparehourlyRatePayableDays = !empty($priceCompare->hourlyRatePayableDays) ? $priceCompare->hourlyRatePayableDays : 1;
                            $dayShift = $priceComparehourlyRatePayableDays * $dayHr;
                            $priceOverRideStatus = '1';
                            $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays * $dayHr ?? 0;
                        }
                    }
                }
                if (!empty($nightHr)) {
                    if (empty($priceCompare)) {
                        $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight  * $nightHr ?? 0;
                        $priceOverRideStatus = '0';
                        $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight * $nightHr;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableNight) {
                            $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight  * $nightHr ?? 0;
                            $priceOverRideStatus = '0';
                            $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight * $nightHr;
                        } else {
                            $priceComparehourlyRatePayableNight = !empty($priceCompare->hourlyRatePayableNight) ? $priceCompare->hourlyRatePayableNight : '1';
                            $nightShift = $priceComparehourlyRatePayableNight * $nightHr;
                            $priceOverRideStatus = '1';
                            $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight * $nightHr;
                        }
                    }
                }
                if (!empty($saturdayHrs)) {
                    if (empty($priceCompare)) {
                        $saturdayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday  * $saturdayHrs ?? 0;
                        $priceOverRideStatus = '0';
                        $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday * $saturdayHrs;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay) {
                            $saturdayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday * $saturdayHrs ?? 0;
                            $priceOverRideStatus = '0';
                            $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday * $saturdayHrs;
                        } else {
                            $saturdayHr = $priceCompare->hourlyRatePayableSaturday * $saturdayHrs;
                            $priceOverRideStatus = '1';
                            $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday * $saturdayHrs;
                        }
                    }
                }
                if (!empty($sundayHrs)) {
                    if (empty($priceCompare)) {
                        $sundayHr = $data['shiftView']->getClientCharge->hourlyRatepayableSunday  * $sundayHrs ?? 0;
                        $priceOverRideStatus = '0';
                        $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay) {
                            $sundayHr = $data['shiftView']->getClientCharge->hourlyRatepayableSunday  * $sundayHrs ?? 0;
                            $priceOverRideStatus = '0';
                            $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                        } else {
                            $sundayHr = $priceCompare->hourlyRatepayableSunday * $sundayHrs;
                            $priceOverRideStatus = '1';
                            $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                        }
                    }
                }
                if ($inputtypeRego1) {
                    $rego = $request->input('inputtypeRego1');
                } else {
                    $rego = $request->input('inputtypeRego2');
                }
                $driverResponsible = $request->input('driverId');
                $totalPayShiftAmount = $dayShift + $nightShift + $saturdayHr + $sundayHr;
                $totalChargeDay   = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge;
                Shift::where('id', $shify->id)->update(['payAmount' => $totalPayShiftAmount, 'priceOverRideStatus' => $priceOverRideStatus]);
                DB::table('clientcharge')->insert(['shiftId' => $shify->id, 'driverResponsible' => $driverResponsible, 'rego' => $rego, 'amount' => $totalPayShiftAmount, 'status' => '0']);  // O is pay to Driver
                DB::table('clientcharge')->insert(['shiftId' => $shify->id, 'driverResponsible' => $driverResponsible, 'rego' => $rego, 'amount' => $totalChargeDay, 'status' => '1']); // 1 is charge to admin
                // is Driver Payable
            }
            // Client charage Amount
            Shift::where('id', $shify->id)->update(['chageAmount' => $totalChargeDay]);
            $totalHr = $data = $dayHr + $nightHr;
            // End client Charge Amount
            $driverPay = Client::where('id', $getClientID)->first();
            $driverIncome = $totalPayShiftAmount ?? '0' + $driverPay->driverPay ?? '0';
            Client::where('id', $getClientID)->update(['driverPay' => $driverIncome]);
            $adminCharge = Client::where('id', $getClientID)->first();
            $chargeAdmin = $totalChargeDay ?? '' + $adminCharge->adminCharge ?? '0';
            Client::where('id', $getClientID)->update(['adminCharge' => $chargeAdmin]);
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
            shift::whereId($shify->id)->update(['finishStatus' => '2']);
            $Parcel                       = new Finishshift();
            $Parcel->driverId             = $request->input('driverId');
            $Parcel->shiftId              = $shify->id;
            $Parcel->odometerStartReading = $odometerStart;
            $Parcel->odometerEndReading      = $odometerFinish;
            $Parcel->dayHours              = $dayHr;
            $Parcel->nightHours              = $nightHr;
            $Parcel->totalHours              = $totalHr;
            $Parcel->saturdayHours          = $saturdayHrs;
            $Parcel->sundayHours          = $sundayHrs;
            $Parcel->weekendHours          = $weekend;
            $Parcel->startDate              = $start_date;
            $Parcel->endDate              = $end_date;
            $Parcel->startTime              = $dayStartTime->format('H:i:s');
            $Parcel->endTime              = $nightEndTime->format('H:i:s');
            $Parcel->parcelsTaken           = $parcelsTaken;
            $Parcel->parcelsDelivered      = $parcel_delivered;
            $Parcel->save();
            return Redirect::route('admin.shift.report')->with('message', 'Missed Shift  Added Successfully!');
        }
        $data['driver'] = Driver::get();
        $data['client'] = Client::get();
        $data['type'] = Type::get();
        $data['regoAll'] = Vehical::where('status', '1')->get();
        $data['states'] = States::where('status', '1')->get();
        return view('admin.shift.missed-shift', $data);
    }
    public function myshift(Request $request)
    {
        $data['state'] = DB::table('states')->where('status', '1')->get();
        $data['clients'] = Client::where('status', '1')->get();
        $data['costCenter'] = Clientcenter::select('id', 'name')->get();
        $data['clientbases'] = DB::table('clientbases')->select('id', 'base')->get();
        $data['statusData'] = $request->input('status');
        if (empty($data['statusData'])) {
            $data['statusData'][] = '2';
        } else {
            $data['statusData'] = $request->input('status');
        }
        return view('admin.shift.myShift', $data);
    }
    public function myAjaxshift(Request $request)
    {
        $query = Shift::orderBy('id', 'DESC');
        $data['state'] =  $request->input('form.state');
        $data['client'] = $request->input('form.client');
        $data['status'] = $request->input('status');
        $data['costCenter'] = $request->input('costCenter');
        $data['base'] = $request->input('base');
        $data['start'] = $request->input('start');
        $data['finish'] = $request->input('finish');
        if ($data['state']) {
            return  $data['state'];
            $query = $query->whereIn('state', $data['state']);
        }
        if ($data['client']) {
            $query = $query->whereIn('client', $data['client']);
        }
        $driverRole =  Auth::guard('adminLogin')->user()->role_id;
        $columnMapping = [
            'Shift Id'   => 'shiftRandId',
            'Client'   => 'getClientName.name',
            'Cost'   => 'getCostCenter.name',
            'Driver'   => 'getDriverName.userName',
            'Parcels Taken'   => 'id',
            'Parcels Delivered'   => 'getFinishShift.parcelsDelivered',
            'REGO'   => 'getVehicalsRego.rego',
            'Vehicle Type'   => 'getVehicleType.name',
            'State'   => 'getStateName.name',
            'Created Date'   => 'createdDate',
            'Date Start'   => 'shiftStartDate',
            'Time Start'   => 'getFinishShift.startTime',
            'Date Finish'   => 'getFinishShift.endDate',
            'Time Finish'   => 'getFinishShift.endTime',
            'Status'   => 'finishStatus',
            'Total Hours'   => 'id'
        ];
        if ($driverRole == 33) {
            $columnMapping['Total Hours Day Shift'] = ($driverRole == 33) ? 'getFinishShift.dayHours' : null;
            $columnMapping['Total Hours Night Shift'] = ($driverRole == 33) ? 'getFinishShift.nightHours' : null;
            $columnMapping['Total Hours Weekend Shift'] = ($driverRole == 33) ? 'getFinishShift.weekendHours' : null;
        }
        $columnMapping['Amount Chargeable Day Shift']   = 'id';
        $columnMapping['Amount Payable Day Shift']   = 'id';
        $columnMapping['Amount Payable Night Shift']   = 'id';
        $columnMapping['Amount Chargeable Night Shift']   = 'id';
        $columnMapping['Amount Payable Weekend Shift']   = 'id';
        $columnMapping['Amount Chargeable Weekend Shift']   = 'id';
        $columnMapping['Fuel Levy Payable']   = 'getShiftMonetizeInformation.fuelLevyPayable';
        $columnMapping['Fuel Levy Chargeable Fixed']   = 'getShiftMonetizeInformation.fuelLevyChargeable';
        $columnMapping['Fuel Levy Chargeable 250+']   = 'getShiftMonetizeInformation.fuelLevyChargeable250';
        $columnMapping['Fuel Levy Chargeable 400+']   = 'getShiftMonetizeInformation.fuelLevyChargeable400';
        $columnMapping['Extra Payable']   = 'getShiftMonetizeInformation.extraPayable';
        $columnMapping['Extra Chargeable']   = 'getShiftMonetizeInformation.extraChargeable';
        $columnMapping['Total Chargeable']   = 'getShiftMonetizeInformation.totalChargeable';
        $columnMapping['Odometer Start']   = 'getFinishShift.odometerStartReading';
        $columnMapping['Odometer End']   = 'getFinishShift.odometerEndReading';
        $columnMapping['Total Payable']   = 'payAmount';
        $columnMapping['Traveled KM']   = 'id';
        $columnMapping['Comment']   = 'comment';
        $columnMapping['Action']   = 'id';
        $pageStr = "shift_table";
        return DataTableShiftHelper::getData($request, $query, $columnMapping, $pageStr);
    }
    public function shiftreport(Request $request)
    {
        $userId = Auth::guard('adminLogin')->user();
        $query = Shift::orderBy('id', 'DESC');
        $data['state'] = '';
        $data['clients'] = '';
        $data['statusData'] = $request->input('status');
        if (empty($data['statusData'])) {
            $data['statusData'][] = '2';
        } else {
            $data['statusData'] = $request->input('status');
        }
        $data['costCenter'] = '';
        $data['clients'] = [];
        $data['start'] = '';
        $data['finish'] = '';
        $data['statefilter'][] = '';
        $query = $query->WhereIn('finishStatus', $data['statusData']);
        $data['statefilter'] = $request->input('state');
        $data['clients'] = $request->input('client');
        // echo "<pre>";
        // print_r(  $data['clients']);
        $data['costCenter'] = $request->input('costCenter');
        $data['base'] = $request->input('base');
        $data['start'] = $request->input('start');
        $data['finish'] = $request->input('finish');
        if ($data['statefilter']) {
            $query = $query->WhereIn('state', $data['statefilter']);
        }
        if ($data['clients']) {
            //  return $data['clients'];
            $query = $query->WhereIn('client', $data['clients']);
        }
        if ($data['costCenter']) {
            $query = $query->WhereIn('costCenter', $data['costCenter']);
        }
        if ($data['base']) {
            $query = $query->WhereIn('base', $data['base']);
        }
        //   }
        if ($data['start']) {
            $sdate = $data['start'];
            $query = $query->whereHas('getFinishShifts', function (Builder $query) use ($sdate) {
                $query->where('startDate', '<=', $sdate);
            });
        }
        if ($data['finish']) {
            $enddate = $data['finish'];
            $query = $query->whereHas('getFinishShifts', function (Builder $query) use ($enddate) {
                $query->where('endDate', '>=', $enddate);
            });
        }
        if ($userId->role_id == '33') {
            $driverId = Driver::where('email', $userId->email)->first()->id;
            $query = $query->where('driverId', $driverId);
            $query = $query->whereNotIn('finishStatus', [0, 1]);
        }
        $search = '';
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $clientsSearch = DB::table('clients')
                ->where('name', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
            $drivers = DB::table('drivers')
                ->where('userName', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
            $clientbases = DB::table('clientbases')
                ->where('cost_center_name', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
            $rego = DB::table('vehicals')
                ->where('rego', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
            $types = DB::table('types')
                ->where('name', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
            $states = DB::table('states')
                ->where('name', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
        } else {
            $clientsSearch[] = '';
            $drivers[] = '';
            $clientbases[] = '';
            $rego[] = '';
            $types[] = '';
            $states[] = '';
        }
        $query = $query->orderBy('id', 'DESC')->with('getPersonRates', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates', 'getClientReportCharge','getDriverName');
        if (substr($search, 0, 2) === 'QE' && is_numeric(substr($search, 2))) {
            $search = substr($search, 2);
        } else {
            $search = $search;
        }
        if ($search) {
            $query->where(function ($q) use ($search, $clientsSearch, $drivers, $clientbases, $rego, $types, $states) {
                $q->where('shiftRandId', $search)
                    ->orWhereIn('client', $clientsSearch)
                    ->orWhereIn('driverId', $drivers)
                    ->orWhereIn('base', $clientbases)
                    ->orWhereIn('rego', $rego)
                    ->orWhereIn('vehicleType', $types)
                    ->orWhereIn('state', $states);
            });
        }
        $itemsPerPage = request('countData', 10);
        $data['itemsPerPage'] = request('countData', 10);
        if ($itemsPerPage == 'all') {
            $data['shift'] = $query->paginate($itemsPerPage);
        } else {
            $data['shift'] = $query->paginate($itemsPerPage);
        }
        $data['state'] = DB::table('states')->where('status', '1')->get();
        $data['client'] = Client::where('status', '1')->get();
        $data['shiftstatus'] = DB::table('shiftstatus')->where('status', '2')->get();
        $data['clientcenter'] = Clientcenter::select('id', 'name')->get();
        $data['clientbases'] = DB::table('clientbases')->select('id', 'base')->get();
        return view('admin.shift.shiftReport', $data, compact('itemsPerPage'));
    }
    public function exportShift(Request $request)
    {
        $query = Shift::orderBy('id', 'DESC');
        $data['state'] = '';
        $data['clients'] = '';
        $data['statusData'] = $request->input('status');
        if (empty($data['statusData'])) {
            $data['statusData'][] = '2';
        } else {
            $data['statusData'] = $request->input('status');
        }
        $data['costCenter'] = '';
        $data['clients'] = [];
        $data['start'] = '';
        $data['finish'] = '';
        $data['statefilter'][] = '';
        $query = $query->WhereIn('finishStatus', $data['statusData']);
        $data['statefilter'] = $request->input('state');
        $data['clients'] = $request->input('client');
        // echo "<pre>";
        // print_r(  $data['clients']);
        $data['costCenter'] = $request->input('costCenter');
        $data['base'] = $request->input('base');
        $data['start'] = $request->input('start');
        $data['finish'] = $request->input('finish');
        if ($data['statefilter']) {
            $query = $query->WhereIn('state', $data['statefilter']);
        }
        if ($data['clients']) {
            //  return $data['clients'];
            $query = $query->WhereIn('client', $data['clients']);
        }
        if ($data['costCenter']) {
            $query = $query->WhereIn('costCenter', $data['costCenter']);
        }
        if ($data['base']) {
            $query = $query->WhereIn('base', $data['base']);
        }
        //   }
        if ($data['start']) {
            $sdate = $data['start'];
            $query = $query->whereHas('getFinishShifts', function (Builder $query) use ($sdate) {
                $query->where('startDate', '<=', $sdate);
            });
        }
        if ($data['finish']) {
            $enddate = $data['finish'];
            $query = $query->whereHas('getFinishShifts', function (Builder $query) use ($enddate) {
                $query->where('endDate', '>=', $enddate);
            });
        }
        if ($userId->role_id == '33') {
            $driverId = Driver::where('email', $userId->email)->first()->id;
            $query = $query->where('driverId', $driverId);
            $query = $query->whereNotIn('finishStatus', [0, 1]);
        }
        $search = '';
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $clientsSearch = DB::table('clients')
                ->where('name', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
            $drivers = DB::table('drivers')
                ->where('userName', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
            $clientbases = DB::table('clientbases')
                ->where('cost_center_name', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
            $rego = DB::table('vehicals')
                ->where('rego', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
            $types = DB::table('types')
                ->where('name', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
            $states = DB::table('states')
                ->where('name', 'like', "%$search%")
                ->pluck('id')
                ->toArray();
        } else {
            $clientsSearch[] = '';
            $drivers[] = '';
            $clientbases[] = '';
            $rego[] = '';
            $types[] = '';
            $states[] = '';
        }
        $query = $query->orderBy('id', 'DESC')->with('getPersonRates', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates', 'getClientReportCharge');
        if (substr($search, 0, 2) === 'QE' && is_numeric(substr($search, 2))) {
            $search = substr($search, 2);
        } else {
            $search = $search;
        }
        if ($search) {
            $query->where(function ($q) use ($search, $clientsSearch, $drivers, $clientbases, $rego, $types, $states) {
                $q->where('shiftRandId', $search)
                    ->orWhereIn('client', $clientsSearch)
                    ->orWhereIn('driverId', $drivers)
                    ->orWhereIn('base', $clientbases)
                    ->orWhereIn('rego', $rego)
                    ->orWhereIn('vehicleType', $types)
                    ->orWhereIn('state', $states);
            });
        }
        return Excel::download(new ShiftReportsExport($query), 'shifts.xlsx');
    }
    public function ajaxIndex(Request $request)
    {
        $filters = [
            'base' => $request->input('base'),
            'vehicleType' => $request->input('vehicleType')
        ];
        $columnMapping = [
            'base' => 'base',
            'vehicleType' => 'vehicleType',
            'getStateName.name' => 'get_state_name.name',
            'chageAmount' => 'chageAmount',
        ];
        $columns = ['base', 'vehicleType', 'getStateName.name', 'chageAmount'];
        $relations = [];
        $query = Shift::with(['getPersonRates', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates', 'getClientReportCharge'])->has('getStateName');
        return DataTableHelper::getData($request, $query, $columns, $columnMapping, $filters);
    }
    public function shiftReportView(Request $request, $id)
    {
        $query = Shift::where('id', $id);
        $getClientID = Shift::whereId($id)->first()->client;
        $data['shiftView'] = $query->orderBy('id', 'DESC')->with([
            'getPersonRates', 'getDriverName', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates',
            'getClientCharge' => function ($query) use ($getClientID) {
                $query->where('clientId', $getClientID);
            }
        ])->first();
        if ($data['shiftView']->finishStatus == '2') {
            $data['extra_rate_per_hour'] = $data['shiftView']->getDriverName->extra_rate_per_hour ?? '0';
        } else {
            $data['extra_rate_per_hour'] = 0;
        }
        // dd($data['extra_rate_per_hour']);
        // dd($data['shiftView']->getClientCharge);
        $data['weekendHour'] = '';
        $data['dayNight']    = '';
        $data['dayHours']    = '';
        $data['nightHours']  = '';
        $data['nightHour1']  = '';
        $data['saturday1']   = '0';
        $data['sunday1']     = '0';
        $data['dayHours1']   = '';
        $finalAmount = '0';
        $data['weekendTotal'] = '';
        $data['totalWeekendPay'] = '';
        if ($data['shiftView']->getFinishShifts) {
            $data['shiftView']->getFinishShifts->startDate;
            $data['startDate'] = $data['shiftView']->getFinishShifts->startDate;
            $data['endDate']   =  $data['shiftView']->getFinishShifts->endDate;
            $data['weekend1']  = Carbon::parse($data['startDate'])->dayName;
            $data['weekend2']  = Carbon::parse($data['endDate'])->dayName;
            $d1 = new DateTime($data['startDate']); // first date
            $d2 = new DateTime($data['endDate'] ?? ''); // second date
            $interval = $d1->diff($d2); // get difference between two dates
            $weekend1 = $data['weekend1'];
            $weekend2 = $data['weekend2'];
            $data['weekendTotal'] = '';
            if ($weekend1 == "Saturday" || $weekend2 == 'Sunday') {
                $data['weekendHour'] = $interval->format('%h') . " Hours " . $interval->format('%i') . " Minutes";
                $data['saturday1'] = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday ?? 0 * $interval->format('%h');
                $data['dayHours1'] = $data['shiftView']->getFinishShifts->dayHours;
                $data['shiftView']->getClientCharge->hourlyRatePayableDays ?? 0;
                $data['dayHours']  = ($data['shiftView']->getClientCharge->hourlyRatePayableDay ?? '0') * $data['dayHours1'];
                //  $data['dayHours1']=$data['shiftView']->getFinishShifts->dayHours;
                //  $data['dayHours']=($data['shiftView']->getClientCharge->hourlyRatePayableDay??'0')*$data['dayHours1'];
                $data['nightHour1'] = $data['shiftView']->getFinishShifts->nightHours;
                $data['nightHours'] = ($data['shiftView']->getClientCharge->hourlyRatePayableNight ?? '0') * $data['nightHour1'];
                $finalAmount = $data['dayHours'] + $data['nightHours'];
                // admin side
                $adminCharge1 = $data['shiftView']->getClientCharge->hourlyRateChargeableDays ?? '0' * $data['dayHours1'] ?? '0';
                $adminCharge2 = $data['shiftView']->getClientCharge->ourlyRateChargeableNight ?? '0' * $data['nightHour1'] ?? '0';
                $adminCharageAmount = $adminCharge1 + $adminCharge2;
                $data['weekendTotal'] = $data['dayHours1'] + $data['nightHour1'];
                $data['totalWeekendPay'] = $data['dayHours'] + $data['nightHours'];
                // End admin Side
                DB::table('clientrates')->where('id', $data['shiftView']->getClientCharge->id ?? '')->update(['driverEarning' => $finalAmount, 'adminCharageAmount' => $adminCharageAmount]);
            } else {
                $data['dayHours1'] = $data['shiftView']->getFinishShifts->dayHours;
                $data['shiftView']->getClientCharge->hourlyRatePayableDays ?? 0;
                $data['dayHours']  = ($data['shiftView']->getClientCharge->hourlyRatePayableDay ?? '0') * $data['dayHours1'];
                //  $data['dayHours1']=$data['shiftView']->getFinishShifts->dayHours;
                //  $data['dayHours']=($data['shiftView']->getClientCharge->hourlyRatePayableDay??'0')*$data['dayHours1'];
                $data['nightHour1'] = $data['shiftView']->getFinishShifts->nightHours;
                $data['nightHours'] = ($data['shiftView']->getClientCharge->hourlyRatePayableNight ?? '0') * $data['nightHour1'];
                $finalAmount = $data['dayHours'] + $data['nightHours'];
                // admin side
                $adminCharge1 = $data['shiftView']->getClientCharge->hourlyRateChargeableDays ?? '0' * $data['dayHours1'] ?? '0';
                $adminCharge2 = $data['shiftView']->getClientCharge->ourlyRateChargeableNight ?? '0' * $data['nightHour1'] ?? '0';
                $adminCharageAmount = $adminCharge1 + $adminCharge2;
                // End admin Side
                DB::table('clientrates')->where('id', $data['shiftView']->getClientCharge->id ?? '')->update(['driverEarning' => $finalAmount, 'adminCharageAmount' => $adminCharageAmount]);
            }
        }
        $data['allstate'] = States::where('status', '1')->get();
        $data['costCenter'] = DB::table('clientcenters')->select('id', 'name')->where(['status' => '1'])->get();
        $data['client'] = Client::where(['status' => '1'])->get();
        $data['types'] = Type::where(['status' => '1'])->get();
        $data['driverAdd'] = Driver::get();
        return view('admin.shift.shift-report-view', $data, compact('finalAmount'));
    }
    public function shiftReportEdit(Request $request, $id)
    {
        $query = Shift::where('id', $id);
        $getClientID = Shift::whereId($id)->first()->client;
        $data['shiftView'] = $query->orderBy('id', 'DESC')->with([
            'getPersonRates', 'getDriverName', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getShiftMonetizeInformation', 'getClientVehicleRates',
            'getClientCharge' => function ($query) use ($getClientID) {
                $query->where('clientId', $getClientID);
            }
        ])->first();
        //    dd( $data['shiftView']);
        $data['allstate'] = States::where('status', '1')->get();
        $data['costCenter'] = DB::table('clientcenters')->select('id', 'name')->where(['status' => '1', 'clientId' => $getClientID])->get();
        $data['client'] = Client::where(['status' => '1'])->get();
        $data['types'] = Type::where(['status' => '1'])->get();
        if (request()->isMethod("post")) {
            $managementId = $request->input('hrManagerment');
            if ($managementId == '1') {
                Shift::where('id', $id)->update([
                    'state'    => $request->input('state'),
                    'client'     => $request->input('client'),
                    'costCenter'        => $request->input('costCenter'),
                    'finishStatus' => $request->input('finishStatus'),
                    'base'   => $request->input('base'),
                    'vehicleType'         => $request->input('vehicleType'),
                    'rego'       => $request->input('rego'),
                    'createdDate'    => $request->input('createdDate'),
                    'scanner_id'  => $request->input('scannerName'),
                    'parcelsToken'    => $request->input('parcelToken')
                ]);
                return Redirect::back()->with('message', 'Shift  Updated Successfully!');
            }
            if ($managementId == '2') {
                $startDate = $request->startDate;
                $endDate = $request->finishDate;
                $start_date = Carbon::parse($startDate)->format('Y-m-d H:i');
                $end_date = Carbon::parse($endDate)->format('Y-m-d H:i');
                $startDate    = strtotime($start_date);
                $endDate      = strtotime($end_date);
                $result       = $this->calculateShiftHoursWithMinutes($startDate, $endDate);
                $dayHr       =   $result['dayTotal'];
                $nightHr     =   $result['nightTotal'];
                $saturdayHrs =   $result['totalSaturdayHours'];
                $sundayHrs   =   $result['totalSundayHours'];
                $weekend     =   $saturdayHrs + $sundayHrs;
                $dayShift           = '0';
                $nightShift         = '0';
                $sundayHr           = '0';
                $saturdayHr         = '0';
                $dayShiftCharge     =  '0';
                $nightShiftCharge    = '0';
                $saturdayShiftCharge = '0';
                $sundayShiftCharge   = '0';
                $priceOverRideStatus = '0';
                $priceCompare = DB::table('personrates')
                    ->where('type', $data['shiftView']->vehicleType)
                    ->where('personId', $data['shiftView']->driverId)
                    ->first();
                if (!empty($dayHr) || !empty($nightHr)   || !empty($saturdayHrs)   || !empty($sundayHrs)) {
                    if (!empty($dayHr)) {
                        if (empty($priceCompare)) {
                            $dayShift = $data['shiftView']->getClientCharge->hourlyRatePayableDay * $dayHr;
                            $priceOverRideStatus = '0';
                            $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays * $dayHr ?? 0;
                        } else {
                            if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay) {
                                $dayShift = $data['shiftView']->getClientCharge->hourlyRatePayableDay * $dayHr ?? 0;
                                $priceOverRideStatus = '0';
                                $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays * $dayHr ?? 0;
                            } else {
                                $priceComparehourlyRatePayableDays = !empty($priceCompare->hourlyRatePayableDays) ? $priceCompare->hourlyRatePayableDays : 1;
                                $dayShift = $priceComparehourlyRatePayableDays * $dayHr;
                                $priceOverRideStatus = '1';
                                $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays * $dayHr ?? 0;
                            }
                        }
                    }
                    if (!empty($nightHr)) {
                        if (empty($priceCompare)) {
                            $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight  * $nightHr ?? 0;
                            $priceOverRideStatus = '0';
                            $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight * $nightHr;
                        } else {
                            if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableNight) {
                                $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight  * $nightHr ?? 0;
                                $priceOverRideStatus = '0';
                                $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight * $nightHr;
                            } else {
                                $priceComparehourlyRatePayableNight = !empty($priceCompare->hourlyRatePayableNight) ? $priceCompare->hourlyRatePayableNight : '1';
                                $nightShift = $priceComparehourlyRatePayableNight * $nightHr;
                                $priceOverRideStatus = '1';
                                $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight * $nightHr;
                            }
                        }
                    }
                    if (!empty($saturdayHrs)) {
                        if (empty($priceCompare)) {
                            $saturdayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday  * $saturdayHrs ?? 0;
                            $priceOverRideStatus = '0';
                            $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday * $saturdayHrs;
                        } else {
                            if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay) {
                                $saturdayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday * $saturdayHrs ?? 0;
                                $priceOverRideStatus = '0';
                                $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday * $saturdayHrs;
                            } else {
                                $saturdayHr = $priceCompare->hourlyRatePayableSaturday * $saturdayHrs;
                                $priceOverRideStatus = '1';
                                $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday * $saturdayHrs;
                            }
                        }
                    }
                    $floatValue = $sundayHrs;
                    $intValue = (int)$floatValue;
                    if (!empty($intValue)) {
                        if (empty($priceCompare)) {
                            $sundayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSunday  * $sundayHrs ?? 0;
                            $priceOverRideStatus = '0';
                            $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                        } else {
                            if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay) {
                                $sundayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSunday  * $sundayHrs ?? 0;
                                $priceOverRideStatus = '0';
                                $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                            } else {
                                $sundayHr = $priceCompare->hourlyRatepayableSunday * $sundayHrs;
                                $priceOverRideStatus = '1';
                                $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                            }
                        }
                    }
                }
                $totalPayShiftAmount = $dayShift + $nightShift + $saturdayHr + $sundayHr;
                Shift::where('id', $id)->update(['payAmount' => $totalPayShiftAmount, 'priceOverRideStatus' => $priceOverRideStatus]);
                $totalChargeDay   = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge;
                Shift::where('id', $id)->update(['chageAmount' => $totalChargeDay]);
                $totalHr = $data = $dayHr + $nightHr;
                $driverPay = Client::where('id', $getClientID)->first();
                $driverIncome = $totalPayShiftAmount ?? '0' + $driverPay->driverPay ?? '0';
                Client::where('id', $getClientID)->update(['driverPay' => $driverIncome]);
                $adminCharge = Client::where('id', $getClientID)->first();
                $chargeAdmin = $totalChargeDay ?? '' + $adminCharge->adminCharge ?? '0';
                Client::where('id', $getClientID)->update(['adminCharge' => $chargeAdmin]);
                $existingFinishshiftId = $id;
                if ($existingFinishshiftId) {
                    // return Carbon::parse($endDate)->format('Y-m-d');
                    $Parcel = Finishshift::where('shiftId', $existingFinishshiftId)->first();
                    if ($Parcel) {
                        $Parcel->dayHours = $dayHr;
                        $Parcel->nightHours = $nightHr;
                        $Parcel->totalHours = $totalHr;
                        $Parcel->saturdayHours = $saturdayHrs;
                        $Parcel->sundayHours = $sundayHrs;
                        $Parcel->weekendHours = $weekend;
                        $Parcel->startDate = Carbon::parse($startDate)->format('Y-m-d');
                        $Parcel->endDate = Carbon::parse($endDate)->format('Y-m-d');
                        $Parcel->startTime = Carbon::parse($startDate)->format('H:i');
                        $Parcel->endTime = Carbon::parse($endDate)->format('H:i');
                        $Parcel->save();
                    }
                } else {
                    return Redirect::back()->with('error', ' Shift Id Not Exist!');
                }
                return Redirect::back()->with('message', ' Shift Hr. Management Updated Successfully!');
            }
            if ($managementId == '3') {
                $shiftMonetizeInformation = $request->except(['_token', 'hrManagerment']);
                $shiftMonetize = DB::table('shiftMonetizeInformation')->where('shiftId', $id)->first();
                if ($shiftMonetize) {
                    $shiftMonetizeInformation['shiftId'] = $id;
                    DB::table('shiftMonetizeInformation')->where('shiftId', $id)->update($shiftMonetizeInformation);
                } else {
                    $shiftMonetizeInformation['shiftId'] = $id;
                    DB::table('shiftMonetizeInformation')->insert($shiftMonetizeInformation);
                }
                DB::table('shifts')->where('id', $id)->update(['payAmount' => $request->input('totalPayable')]);
                DB::table('shifts')->where('id', $id)->update(['chageAmount' => $request->input('totalChargeable')]);
            }
            return Redirect::back()->with('message', 'Shift Updated Successfully!');
        }
        $data['driverAdd'] = Driver::get();
        if ($data['shiftView']->finishStatus == '2') {
            $data['extra_rate_per_hour'] = $data['shiftView']->getDriverName->extra_rate_per_hour ?? '0';
        } else {
            $data['extra_rate_per_hour'] = 0;
        }
        // dd($data);
        // $data['extra_rate_per_hour'] = + $shiftView->getDriverName->extra_rate_per_hour
        return view('admin.shift.shift-report-edit', $data);
    }
    public function routeMap(Request $request, $id)
    {
        $data['id'] = $id;
        $data['parcels'] = Parcels::where('shiftId', $id)->get();
        if (request()->isMethod("post")) {
            $sortId = $request->input('sort');
            $sortingType = json_decode(json_encode($sortId));
            foreach ($sortingType as $sortOrder => $id) {
                $menu = Parcels::find($id);
                $menu->sorting = $sortOrder + 1;
                $menu->save();
            }
        }
        return view('admin.shift.shift-route-map', $data);
    }
    public function shiftparcels($id)
    {
        $data['parcelsDetail'] = Parcels::where('shiftId', $id)->with('ParcelImage')->get();
        $data['shiftLocation'] = Shift::whereId($id)->first();
        // dd($data['parcelsDetail']);
        return view('admin.shift.shift-parcels', $data);
    }
    public function shiftapr(Request $request)
    {
        $id = $request->input('shiftId');
        $data['parcelsDetail'] = Shift::whereId($id)->update(['finishStatus' => '3']);
        return response()->json([
            "status" => 200,
            "message" => "Shift Approved Successfully!",
        ]);
    }
    public function shiftRejected(Request $request)
    {
        $id = $request->input('shiftId');
        $data['parcelsDetail'] = Shift::whereId($id)->update(['finishStatus' => '4']);
        return response()->json([
            "status" => 200,
            "message" => "Shift Rejected Successfully!",
        ]);
    }
    public function shiftPaid(Request $request)
    {
        $id = $request->input('shiftId');
        $data['parcelsDetail'] = Shift::whereId($id)->update(['finishStatus' => '5']);
        return response()->json([
            "status" => 200,
            "message" => "Shift Paid Successfully!",
        ]);
    }
    public function shiftapprove(Request $request)
    {
        $id = $request->input('shiftId');
        $data['parcelsDetail'] = Shift::whereId($id)->update(['shiftStatus' => '1']);
        return Redirect::back()->with('message', 'Shift Approved Successfully!');
    }
    public function packageDeliver(Request $request)
    {
        $files = $request->file('addPhoto');
        $destinationPath = 'assets/driver/parcel/finishParcel';
        $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
        $files->move($destinationPath, $file_name);
        $items = $file_name;
        $Parcel                       = new Finishshift();
        $Parcel->driverId             = $request->driverId;
        $Parcel->shiftId               = $request->shiftId;
        $Parcel->parcelsTaken           = $request->startDate;
        $Parcel->endDate               = $request->endDate;
        $Parcel->startTime               = $request->startTime;
        $Parcel->addPhoto             = $items;
        $Parcel->save();
        if ($Parcel) {
            return response()->json([
                "status" => 200,
                "message" => "Shift Finished Successfully",
            ]);
        }
    }
    public function getClient(Request $request)
    {
        $getData = Client::select('id', 'name')->where('status', '1')->whereIn('state', $request->input('stateId'))->get();
        if (count($getData) > 0) {
            return response()->json(
                [
                    "success" => 200,
                    "message" => "Success",
                    "items"    => $getData
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => "Not found any items",
                ]
            );
        }
    }
    public function getCostCenter(Request $request)
    {
        $getCostCenter = DB::table('clientcenters')->select('id', 'name', 'base')->where('status', '1')->whereIn('clientId', $request->input('clientId'))->get();
        $getType = Clientrate::select('id', 'clientId', 'type')->with(['getClientType'])->whereIn('clientId', $request->input('clientId'))->get();
        $clientBase = ClientBase::select('id', 'base')->whereIn('clientId', $request->input('clientId'))->get();
        if (count($getCostCenter) > 0) {
            return response()->json(
                [
                    "success" => 200,
                    "message" => "Success",
                    "items"    => $getCostCenter,
                    "getType" => $getType,
                    "clientBase" => $clientBase
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => "Not found any items",
                ]
            );
        }
    }
    public function getClientBase(Request $request)
    {
        // return $request->all();
        //    $clientCenter=Clientcenter::select('id','base')->whereIn('clientId',$request->input('clientId'))->first()->name??'';
        //    $clientBase=ClientBase::select('id','base')->whereIn('clientId',$clientCenter)->get();
        $clientCenter = Clientcenter::where('id', $request->input('costCenterId'))->first();
        $clientBase = ClientBase::select('id', 'base')->whereIn('clientcentersid', [$clientCenter->id])->get();
        if (count($clientBase) > 0) {
            return response()->json(
                [
                    "success" => 200,
                    "message" => "Success",
                    "clientBase" => $clientBase
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => "Not found any items",
                ]
            );
        }
    }
    public function getDriverResponiable(Request $request)
    {
        $driverResponsible = Vehical::where('status', '1')->where('vehicalType', $request->input('vehicleTye'))->pluck('driverResponsible')->toArray();
        $driverRego = Vehical::select('id', 'rego')->where('status', '1')->where('vehicalType', $request->input('vehicleTye'))->where('status', '1')->get();
        $getvehicleTye = Driver::select('id', 'userName')->where('status', '1')->whereIn('id', $driverResponsible)->get();
        if (count($getvehicleTye) > 0) {
            return response()->json(
                [
                    "success" => 200,
                    "message" => "Success",
                    "driverRsps"    => $getvehicleTye,
                    "driverRego"    => $driverRego
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => "Not found any items s",
                ]
            );
        }
    }
    public function getClientA(Request $request)
    {
        $getData = Client::select('id', 'name')->where('state', $request->input('stateId'))->get();
        if (count($getData) > 0) {
            return response()->json(
                [
                    "success" => 200,
                    "message" => "Success",
                    "items"    => $getData
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => "Not found any items",
                ]
            );
        }
    }
    public function getCostCenterB(Request $request)
    {
        $getCostCenter = DB::table('clientcenters')->select('id', 'name', 'base')->where('status', '1')->where('clientId', $request->input('clientId'))->get();
        $getType = Clientrate::select('id', 'clientId', 'type')->with(['getClientType'])->where('clientId', $request->input('clientId'))->get();
        $clientBase = ClientBase::select('id', 'base')->where('clientId', $request->input('clientId'))->get();
        if (count($getCostCenter) > 0) {
            return response()->json(
                [
                    "success" => 200,
                    "message" => "Success",
                    "items"    => $getCostCenter,
                    "getType" => $getType,
                    "clientBase" => $clientBase
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => "Not found any items",
                ]
            );
        }
    }
    public function exportShiftReport(Request $request)
    {
        // dd($request->input('status'));
        $query = Shift::orderBy('id', 'DESC');
        // Apply default status filter if no filter input is found
        if ($request->status == '') {
            $query->whereIn('finishStatus', [3]); // Default status filter for "Active"
        }
        // dd($request->input('status'));
        // Apply filters
        if ($request->status) {
            $query->whereIn('finishStatus', $request->input('status'));
        }
        if ($request->state) {
            $query->whereIn('state', $request->input('state'));
        }
        if ($request->client) {
            $query->whereIn('client', $request->input('client'));
        }
        if ($request->costCenter) {
            $query->whereIn('costCenter', $request->input('costCenter'));
        }
        if ($request->base) {
            $query->whereIn('base', $request->input('base'));
        }
        if ($request->start) {
            $query->whereHas('getFinishShifts', function ($query) use ($request) {
                $query->where('startDate', '<=', $request->input('start'));
            });
        }
        if ($request->finish) {
            $query->whereHas('getFinishShifts', function ($query) use ($request) {
                $query->where('endDate', '>=', $request->input('finish'));
            });
        }
        // Fetch data
        $shifts = $query->orderBy('id', 'DESC')
            ->with(['getDriverName', 'getRego', 'getPersonRates', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates', 'getClientReportCharge'])
            ->get();
        // dd($shifts->getClientReportCharge);
        // Pass filters to the export class
        // $filters = $request->only(['status', 'state', 'client', 'costCenter', 'base', 'start', 'finish', 'search']);
        // Export data with headings and filters
        return Excel::download(new ShiftReportsExport($shifts), 'shift_report.xlsx');
    }
}
