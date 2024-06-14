<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ShiftReportsExport;
use App\Helpers\DataTableHelper;
use App\Helpers\DataTableShiftHelper;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Clientbase;
use App\Models\Clientcenter;
use App\Models\Clientrate;
use App\Models\Driver;
use App\Models\Finishshift;
use App\Models\Parcels;
use App\Models\Shift;
use App\Models\States;
use App\Models\Type;
use App\Models\Vehical;
use App\Traits\CommonTrait;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Http\Controllers\ImageController;
use App\Models\State;

class ShiftManagement extends Controller
{
    use CommonTrait;

    public function shift(Request $request)
    {
        $query = Shift::select('id', 'rego', 'odometer', 'driverId', 'parcelsToken', 'client', 'costCenter', 'status', 'state', 'finishStatus', 'vehicleType', 'created_at','createdDate', 'updated_at');
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
            if ($datas['status'] == 'TO_APPROVE') {
                $status = '2';
            }
            $shift = DB::table('clients')->insertGetId([
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
            if ($datas['status'] == 'TO_APPROVE') {
                $status = '2';
            }
            $shift = DB::table('clientrates')->insertGetId([
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
            if ($datas['status'] == 'TO_APPROVE') {
                $status = '2';
            }
            $shift = DB::table('clientbases')->insertGetId([
                'clientName' => $rd[1],
                'cost' => $rd[2],
                'driver' => $rd['3'],
                'base' => $rd['5'],
            ]);
        }
    }

   
    function parseDate($dateString, $timeString) {
        // List of possible datetime formats
        $formats = [
            'd/m/Y H:i:s',
            'd-m-Y H:i:s',
            'd/m/y H:i:s',
            'j/n/Y H:i:s',
            'j/n/y H:i:s',
            'm/d/Y H:i:s',
            'm/d/y H:i:s',
            'n/j/Y H:i:s',
            'n/j/y H:i:s'
        ];
    
        // Try to parse the datetime using the formats
        foreach ($formats as $format) {
            $dateTime = \DateTime::createFromFormat("$format", "$dateString $timeString");
            if ($dateTime !== false) {
                // Adjust for two-digit years if necessary
                $year = $dateTime->format('Y');
                if ($year < 100) {
                    $year += 2000; // Assuming the year is in the 21st century
                    $dateTime->setDate($year, $dateTime->format('m'), $dateTime->format('d'));
                }
                return $dateTime;
            }
        }
    
        return null; // Return null if no format matched
    }
    
    public function sanitizeText($text) {
        // Remove or replace invalid characters
        $text = iconv('UTF-8', 'UTF-8//IGNORE', $text); // Remove invalid UTF-8 characters
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); // Encode special characters
        return $text;
    }
    

    public function importShift(Request $request)
    {
        set_time_limit(300);
        try{
        // Check if the file is present in the request
        if (!$request->hasFile('shift_file')) {
            return redirect()->back()->with('error', 'No file uploaded');
        }
    
        $file = $request->file('shift_file'); // Get the uploaded file
    
        // Check if the file is valid
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Uploaded file is not valid');
        }
    
        $filePath = $file->getRealPath(); // Get the real path of the file
    
        $data = [];
       

        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            // Set the delimiter to comma and the enclosure to double quotes
            while (($row = fgetcsv($handle, 1000, ',', '"')) !== FALSE) {
                $data[] = array_map([$this, 'sanitizeText'], $row); // Sanitize each cell
            }
            fclose($handle);
        }
    
        $clients = DB::table('clients')->select(DB::raw('LOWER(name) AS name'),'id')->get()->pluck('id','name')->toArray();
        $clientbase = DB::table('clientbases')->select(DB::raw('LOWER(base) AS base'),'id')->get()->pluck('id','base')->toArray();
        $clientcenters =DB::table('clientcenters')->select(DB::raw('LOWER(name) AS name'),'id')->get()->pluck('id','name')->toArray();
        $drivers = DB::table('drivers')->select(DB::raw('LOWER(fullName) AS fullName'),'id')->get()->pluck('id','fullName')->toArray();
        $vehicals = DB::table('vehicals')->select(DB::raw('LOWER(rego) AS rego'),'id')->get()->pluck('id','rego')->toArray();
        $vehicals_type = DB::table('types')->select(DB::raw('LOWER(name) AS name'),'id')->get()->pluck('id','name')->toArray();
        $states =DB::table('states')->select(DB::raw('LOWER(name) AS name'),'id')->get()->pluck('id','name')->toArray();
    
        unset($data[0]); // Remove the header row if present
    

        foreach ($data as $kk => $rd) {
            $clientIds = [];
            $clientIds['shiftId'] = preg_replace('/[^0-9]/', '', $rd[0]);
            $clientIds['client']= $clients[strtolower(trim($rd[1]))] ?? DB::table('clients')->insertGetId(['name' => trim($rd[1])]);
            $clientIds['cost']= $clientcenters[strtolower(trim($rd[2]))] ?? DB::table('clientcenters')->insertGetId(['clientId'=>$clientIds['client'],'name' => trim($rd[2])]);
            $clientIds['driver']= $drivers[strtolower(trim($rd[3]))] ?? DB::table('drivers')->insertGetId(['fullName' => trim($rd[3])]);
            $clientIds['base']= $clientbase[strtolower(trim($rd[5]))] ?? DB::table('clientbases')->insertGetId(['base' => trim($rd[5]),'cost_center_name' => trim($rd[2])]);
            $clientIds['vehicle']= $vehicals[strtolower(trim($rd[9]))] ?? DB::table('vehicals')->insertGetId(['rego' => trim($rd[9])]);
            $clientIds['vehicle_type']= $vehicals_type[strtolower(trim($rd[10]))] ?? DB::table('types')->insertGetId(['name' => trim($rd[10])]);
            $clientIds['state']= $states[strtolower(trim($rd[11]))] ?? null;


            // Use the helper function to parse start and finish datetime
            $startDateTime = $this->parseDate($rd[12], $rd[13]);
            $finishDateTime = $this->parseDate($rd[14], $rd[15]);

            $start_at = $startDateTime ? $startDateTime->format('Y-m-d H:i:s') : null;
            $finish_at = $finishDateTime ? $finishDateTime->format('Y-m-d H:i:s') : null;

            $start_date = $startDateTime ? $startDateTime->format('Y-m-d') : null;
            $start_time = $startDateTime ? $startDateTime->format('H:i:s') : null;

            $finish_date = $finishDateTime ? $finishDateTime->format('Y-m-d') : null;
            $finish_time = $finishDateTime ? $finishDateTime->format('H:i:s') : null;



            if($rd[16]=='APPROVED'){
                $status ='1';
                $final_status = '3';
            }elseif($rd[16]=='IN_PROGRESS'){
                $status = '2';
                $final_status = '1';
            }
            elseif($rd[16]=='PAID'){
                $status = '3';
                $final_status = '5';
            }
            elseif($rd[16]=='REJECTED'){
                $status = '4';
                $final_status = '4';
            }
            elseif($rd[16]=='TO_APPROVE'){
                $status = '5';
                $final_status = '2';
            }
    
            // echo $rd[12].' '.$rd[13].'+++++++'.$start_at.'<br>';
            // echo '#######'.$rd[14].' '.$rd[15].'+++++++'.$finish_at.'========'.$finish_date.'<br>';
            

            $shidt =Shift::updateOrCreate(
                ['shiftRandId' => preg_replace('/[^0-9]/', '', $rd[0])],
                [
                    'driverId' => $clientIds['driver'],
                    'state' => $clientIds['state'],
                    'client' => $clientIds['client'],
                    'costCenter' => $clientIds['cost'],
                    'base' => trim($rd[5]),
                    'vehicleType' => $clientIds['vehicle_type'],
                    'rego' => trim($rd[9]),
                    'odometer' => $rd[35],
                    'scanner_id' => $rd[4],
                    'parcelsToken' => $rd[6],
                    'shiftStatus' => $status,
                    'finishStatus' => $final_status,
                    'comment' => $rd[38],
                    'approval_reason' => $rd[39],
                    'shiftStartDate' => $start_at,
                    'finishDate' => $finish_at,
                    'createdDate' => $start_at,
                    'payAmount' => $rd[33],
                    'chageAmount' => $rd[34]
                ]
            );
            
            $shiftId = $shidt->id;
    
            DB::table('finishshifts')->updateOrInsert(
                [
                    'shiftId' => $shiftId,
                    'driverId' => $clientIds['driver'],
                ],
                [
                    'driverId' => $clientIds['driver'],
                    'startDate' => $start_date,
                    'endDate' => $finish_date,
                    'dayHours' => $rd[18],
                    'nightHours' => $rd[19],
                    'totalHours' => $rd[17],
                    'weekendHours' => $rd[20],
                    'startTime' => $start_time,
                    'endTime' => $finish_time,
                    'amount_payable_day_shift' => $rd[21]??0,
                    'amount_chargeable_day_shift' => $rd[22]??0,
                    'amount_payable_night_shift' => $rd[23]??0,
                    'amount_chargeable_night_shift' => $rd[24]??0,
                    'amount_payable_weekend_shift' => $rd[25]??0,
                    'amount_chargeable_weekend_shift' => $rd[26]??0,
                    'parcelsTaken' => $rd[6],
                    'parcelsDelivered' => $rd[7],
                    'odometerStartReading' => $rd[35] ?? 0,
                    'odometerEndReading' => $rd[36] ?? 0,
                    'status' => 2
                ]
                );
    
            DB::table('shiftMonetizeInformation')->updateOrInsert(
                ['shiftId' => $shiftId],
                [
                    'fuelLevyPayable' => is_numeric($rd[27]) ? $rd[27] : 0,
                    'fuelLevyChargeable' => is_numeric($rd[28]) ? $rd[28] : 0,
                    'fuelLevyChargeable250' => is_numeric($rd[29]) ? $rd[29] : 0,
                    'fuelLevyChargeable400' => is_numeric($rd[30]) ? $rd[30] : 0,
                    'extraPayable' => is_numeric($rd[31]) ? $rd[31] : 0,
                    'extraChargeable' => is_numeric($rd[32]) ? $rd[32] : 0,
                    'totalChargeable' => is_numeric($rd[34]) ? $rd[34] : 0,
                ]
            );
        }
        }catch (\Exception $e) {
            return $e->getMessage();
        }
        // dd('--');
    
        return redirect()->back()->with('message', 'Shift Import Updated Successfully!!');
    }

    public function shiftAdd(Request $request)
    {
        try {
            if (request()->isMethod('post')) {
                $driverId = $request->driverId;
                $shift = Shift::where('driverId', $driverId)->first()->id??null;
                if ($shift && Shift::where(['id'=>$shift,'finishStatus'=>'1'])->exists()) {
                    return redirect()->back()->with('error', 'There is a shift in progress for the driver (you can only create a missed shift)');
                } else {
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

                    $selectedClient = $request->client ?? null;
                    $selectedvehicleType = $request->vehicleType ?? null;
                    $selecteddriverId = $request->driverId ?? null;
                    
                    $clientRateData = null;
                    $extra_rate_per_hour = null;

                    if($selectedClient) $clientRateData = json_encode(Clientrate::where(['clientId'=>$selectedClient,'type'=>$selectedvehicleType])->first()->toArray());
                    if($selecteddriverId) $extra_rate_per_hour = Driver::whereId($selecteddriverId)->first()->extra_rate_per_hour;

                    $shiftAdd = $request->except(['_token', 'submit']);
                    $shiftAdd['shiftRandId'] = rand('9999', '0000');
                    $shiftAdd['finishStatus'] = '1';
                    $shiftAdd['shiftStartDate'] = date('Y-m-d H:i:s');
                    $shiftAdd['createdDate'] = date('Y-m-d H:i:s');
                    $shiftAdd['rego'] = $regoId;
                    $shiftAdd['client_data_json'] = $clientRateData;
                    $shiftAdd['extra_rate_person'] = $extra_rate_per_hour;
                    // dd($shiftAdd);
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

    public function calculateShiftHoursWithMinutes($startDate, $endDate)
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

        return [
            'dayHours' => floor($dayMinutes / 60),
            'dayMinutes' => $dayMinutes % 60 < 10 ? '0' . ($dayMinutes % 60) : $dayMinutes % 60,
            'dayMinutesNew' => round(floor($dayMinutes % 60) / 60, 2),
            'dayTotal' => number_format(floor($dayMinutes / 60) + round(floor($dayMinutes % 60) / 60, 2), 2),
            'nightHours' => floor($nightMinutes / 60),
            'nightMinutes' => $nightMinutes % 60 < 10 ? '0' . ($nightMinutes % 60) : $nightMinutes % 60,
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
        $data['parcelsTaken'] = $request->parcelsToken;
        $data['parcel_delivered'] = $request->parcel_delivered;
        $data['odometer_start_reading'] = $request->odometer_start_reading;
        $data['odometer_finish_reading'] = $request->odometer_finish_reading;
        if (request()->isMethod('post')) {

            
            //   return $request->start_date;
            $parcelsTaken = $request->parcelsToken;
            $parcel_delivered = $request->parcel_delivered;
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
            // dd($request->all());
            $shiftAdd = $request->except(['_token', 'submit']);
            $shiftAdd['shiftRandId'] = rand('9999', '0000');
            $shiftAdd['is_missed_shift'] = 1;
            $odometerStart = $request->input('odometer_start_reading') ?? '0';
            $odometerFinish = $request->input('odometer_finish_reading') ?? '0';
            $start_date =  Carbon::parse($request->input('start_date'))->format('Y-m-d H:i:s');
            $end_date = Carbon::parse($request->input('end_date'))->format('Y-m-d H:i:s');
            if (is_numeric($odometerStart) && is_numeric($odometerFinish)) {
                $shiftAdd['odometer'] = $odometerFinish - $odometerStart;
            }

            $selectedClient = $request->client ?? null;
            $selectedvehicleType = $request->vehicleType ?? null;
            $selecteddriverId = $request->driverId ?? null;
            
            $clientRateData = null;
            $extra_rate_per_hour = null;

            if($selectedClient) $clientRateData = json_encode(Clientrate::where(['clientId'=>$selectedClient,'type'=>$selectedvehicleType])->first()->toArray());
            if($selecteddriverId) $extra_rate_per_hour = Driver::whereId($selecteddriverId)->first()->extra_rate_per_hour;


            $shiftAdd['rego'] = $regoId;
            $shiftAdd['shiftStartDate'] = $start_date;
            $shiftAdd['finishDate'] = $end_date;
            $shiftAdd['createdDate'] = date('Y-m-d H:i:s');
            $shiftAdd['client_data_json'] = $clientRateData;
            $shiftAdd['extra_rate_person'] = $extra_rate_per_hour;

            $shify = Shift::create($shiftAdd);
            $getClientID = Shift::whereId($shify->id)->first()->client;
            $query = Shift::where('id', $shify->id);
            $data['shiftView'] = $query->orderBy('id', 'DESC')->with(['getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates', 'getClientCharge' => function ($query) use ($getClientID) {
                $query->where('clientId', $getClientID);
            }])->first();
            $priceCompare = DB::table('personrates')->where('type', $data['shiftView']->vehicleType)->where('personId', $data['shiftView']->driverId)->first();
            $startDate = strtotime($request->start_date);
            $endDate = strtotime($request->end_date);
            $dayStartTime = Carbon::parse($startDate);
            $nightEndTime = Carbon::parse($endDate);
            $result = $this->calculateShiftHoursWithMinutes($startDate, $endDate);
            $dayHr = $result['dayTotal'];
            $nightHr = $result['nightTotal'];
            $saturdayHrs = $result['totalSaturdayHours'];
            $sundayHrs = $result['totalSundayHours'];
            $weekend = $saturdayHrs + $sundayHrs;
            $dayShift = '0';
            $nightShift = '0';
            $sundayHr = '0';
            $saturdayHr = '0';
            $dayShiftCharge = '0';
            $nightShiftCharge = '0';
            $saturdayShiftCharge = '0';
            $sundayShiftCharge = '0';
            $priceOverRideStatus = '0';
            $totalChargeDay = '0';
            
            if (!empty($dayHr) || !empty($nightHr) || !empty($saturdayHrs) || !empty($sundayHrs)) {
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
                        $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight * $nightHr ?? 0;
                        $priceOverRideStatus = '0';
                        $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight * $nightHr;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableNight) {
                            $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight * $nightHr ?? 0;
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
                        $saturdayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday * $saturdayHrs ?? 0;
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
                        $sundayHr = $data['shiftView']->getClientCharge->hourlyRatepayableSunday * $sundayHrs ?? 0;
                        $priceOverRideStatus = '0';
                        $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay) {
                            $sundayHr = $data['shiftView']->getClientCharge->hourlyRatepayableSunday * $sundayHrs ?? 0;
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
                $totalChargeDay = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge;
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
            Shift::whereId($shify->id)->update(['finishStatus' => '2']);
            $Parcel = new Finishshift();
            $Parcel->driverId = $request->input('driverId');
            $Parcel->shiftId = $shify->id;
            $Parcel->odometerStartReading = $odometerStart;
            $Parcel->odometerEndReading = $odometerFinish;
            $Parcel->dayHours = $dayHr;
            $Parcel->nightHours = $nightHr;
            $Parcel->totalHours = $totalHr;
            $Parcel->saturdayHours = $saturdayHrs;
            $Parcel->sundayHours = $sundayHrs;
            $Parcel->weekendHours = $weekend;
            $Parcel->startDate = $start_date;
            $Parcel->endDate = $end_date;
            $Parcel->startTime = $dayStartTime->format('H:i:s');
            $Parcel->endTime = $nightEndTime->format('H:i:s');
            $Parcel->submitted_at = date('Y-m-d H:i:s');
            $Parcel->parcelsTaken = $parcelsTaken;
            $Parcel->parcelsDelivered = $parcel_delivered;
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
        $data['state'] = $request->input('form.state');
        $data['client'] = $request->input('form.client');
        $data['status'] = $request->input('status');
        $data['costCenter'] = $request->input('costCenter');
        $data['base'] = $request->input('base');
        $data['start'] = $request->input('start');
        $data['finish'] = $request->input('finish');
        if ($data['state']) {
            return $data['state'];
            $query = $query->whereIn('state', $data['state']);
        }
        if ($data['client']) {
            $query = $query->whereIn('client', $data['client']);
        }
        $driverRole = Auth::guard('adminLogin')->user()->role_id;
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
            'Total Hours'   => 'id',
        ];
        if ($driverRole == 33) {
            $columnMapping['Total Hours Day Shift'] = ($driverRole == 33) ? 'getFinishShift.dayHours' : null;
            $columnMapping['Total Hours Night Shift'] = ($driverRole == 33) ? 'getFinishShift.nightHours' : null;
            $columnMapping['Total Hours Weekend Shift'] = ($driverRole == 33) ? 'getFinishShift.weekendHours' : null;
        }
        $columnMapping['Amount Chargeable Day Shift'] = 'id';
        $columnMapping['Amount Payable Day Shift'] = 'id';
        $columnMapping['Amount Payable Night Shift'] = 'id';
        $columnMapping['Amount Chargeable Night Shift'] = 'id';
        $columnMapping['Amount Payable Weekend Shift'] = 'id';
        $columnMapping['Amount Chargeable Weekend Shift'] = 'id';
        $columnMapping['Fuel Levy Payable'] = 'getShiftMonetizeInformation.fuelLevyPayable';
        $columnMapping['Fuel Levy Chargeable Fixed'] = 'getShiftMonetizeInformation.fuelLevyChargeable';
        $columnMapping['Fuel Levy Chargeable 250+'] = 'getShiftMonetizeInformation.fuelLevyChargeable250';
        $columnMapping['Fuel Levy Chargeable 400+'] = 'getShiftMonetizeInformation.fuelLevyChargeable400';
        $columnMapping['Extra Payable'] = 'getShiftMonetizeInformation.extraPayable';
        $columnMapping['Extra Chargeable'] = 'getShiftMonetizeInformation.extraChargeable';
        $columnMapping['Total Chargeable'] = 'getShiftMonetizeInformation.totalChargeable';
        $columnMapping['Odometer Start'] = 'getFinishShift.odometerStartReading';
        $columnMapping['Odometer End'] = 'getFinishShift.odometerEndReading';
        $columnMapping['Total Payable'] = 'payAmount';
        $columnMapping['Traveled KM'] = 'id';
        $columnMapping['Comment'] = 'comment';
        $columnMapping['Action'] = 'id';
        $pageStr = 'shift_table';

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
        $query = $query->orderBy('id', 'DESC')->with('getPersonRates', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates', 'getClientReportCharge', 'getDriverName');
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
        $shiftsExport = new ShiftReportsExport($query);

        // Define the filename
        $filename = 'shift_report.csv';

        // Get the CSV content
        $content = $shiftsExport->exportToCsv();

        // Serve the file as a download response
        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=' . $filename)
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function ajaxIndex(Request $request)
    {
        $filters = [
            'base' => $request->input('base'),
            'vehicleType' => $request->input('vehicleType'),
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
            },
        ])->first();
        if ($data['shiftView']->finishStatus == '2') {
            $data['extra_rate_per_hour'] = $data['shiftView']->getDriverName->extra_rate_per_hour ?? '0';
        } else {
            $data['extra_rate_per_hour'] = 0;
        }
        // dd($data['extra_rate_per_hour']);
        // dd($data['shiftView']->getClientCharge);
        $data['weekendHour'] = '';
        $data['dayNight'] = '';
        $data['dayHours'] = '';
        $data['nightHours'] = '';
        $data['nightHour1'] = '';
        $data['saturday1'] = '0';
        $data['sunday1'] = '0';
        $data['dayHours1'] = '';
        $finalAmount = '0';
        $data['weekendTotal'] = '';
        $data['totalWeekendPay'] = '';
        if ($data['shiftView']->getFinishShifts) {
            $data['shiftView']->getFinishShifts->startDate;
            $data['startDate'] = $data['shiftView']->getFinishShifts->startDate;
            $data['endDate'] = $data['shiftView']->getFinishShifts->endDate;
            $data['weekend1'] = Carbon::parse($data['startDate'])->dayName;
            $data['weekend2'] = Carbon::parse($data['endDate'])->dayName;
            $d1 = new DateTime($data['startDate']); // first date
            $d2 = new DateTime($data['endDate'] ?? ''); // second date
            $interval = $d1->diff($d2); // get difference between two dates
            $weekend1 = $data['weekend1'];
            $weekend2 = $data['weekend2'];
            $data['weekendTotal'] = '';
            if ($weekend1 == 'Saturday' || $weekend2 == 'Sunday') {
                $data['weekendHour'] = $interval->format('%h') . ' Hours ' . $interval->format('%i') . ' Minutes';
                $data['saturday1'] = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday ?? 0 * $interval->format('%h');
                $data['dayHours1'] = $data['shiftView']->getFinishShifts->dayHours;
                $data['shiftView']->getClientCharge->hourlyRatePayableDays ?? 0;
                $data['dayHours'] = ($data['shiftView']->getClientCharge->hourlyRatePayableDay ?? '0') * $data['dayHours1'];
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
                $data['dayHours'] = ($data['shiftView']->getClientCharge->hourlyRatePayableDay ?? '0') * $data['dayHours1'];
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
        // dd($request->all());
        $query = Shift::where('id', $id);
        $getClientID = Shift::whereId($id)->first()->client;
        $data['shiftView'] = $query->orderBy('id', 'DESC')->with([
            'getPersonRates', 'getDriverName', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getShiftMonetizeInformation', 'getClientVehicleRates',
            'getClientCharge' => function ($query) use ($getClientID) {
                $query->where('clientId', $getClientID);
            },
        ])->first();
        //    dd( $data['shiftView']);
        $data['allstate'] = States::where('status', '1')->get();
        $data['costCenter'] = DB::table('clientcenters')->select('id', 'name')->where(['status' => '1', 'clientId' => $getClientID])->get();
        $data['client'] = Client::where(['status' => '1'])->get();
        $data['types'] = Type::where(['status' => '1'])->get();
        if (request()->isMethod('post')) {
            // $managementId = $request->input('hrManagerment');
            // if ($managementId == '1') {
                Shift::where('id', $id)->update([
                    'state'    => $request->input('state'),
                    'client'     => $request->input('client'),
                    'costCenter'        => $request->input('costCenter'),
                    'finishStatus' => $request->input('finishStatus'),
                    'base'   => $request->input('base'),
                    'vehicleType'         => $request->input('vehicleType'),
                    'rego'       => $request->input('rego'),
                    'shiftStartDate'    => date('Y-m-d H:i:s',strtotime($request->input('shiftStartDate'))),
                    'scanner_id'  => $request->input('scannerName'),
                    'parcelsToken'    => $request->input('parcelsToken'),
                    'comment'=> $request->input('comments'),
                    'approval_reason'=> $request->input('approvedReason'),
                    'odometer' => $request->input('odometerStartReading'),
                ]);

                // return Redirect::back()->with('message', 'Shift  Updated Successfully!');
            // }
            // if (!in_array($request->input('finishStatus'),[0,1])) {
                $startDate = $request->shiftStartDate;
                $endDate = $request->finishDate;
                $start_date = Carbon::parse($startDate)->format('Y-m-d H:i:s');
                $end_date = Carbon::parse($endDate)->format('Y-m-d H:i:s');
                // dd($start_date,$end_date);
                $startDate = strtotime($start_date);
                $endDate = strtotime($end_date);
                $result = $this->calculateShiftHoursWithMinutes($startDate, $endDate);
                $dayHr = $result['dayTotal'];
                $nightHr = $result['nightTotal'];
                $saturdayHrs = $result['totalSaturdayHours'];
                $sundayHrs = $result['totalSundayHours'];
                $weekend = $saturdayHrs + $sundayHrs;
                $dayShift = '0';
                $nightShift = '0';
                $sundayHr = '0';
                $saturdayHr = '0';
                $dayShiftCharge = '0';
                $nightShiftCharge = '0';
                $saturdayShiftCharge = '0';
                $sundayShiftCharge = '0';
                $priceOverRideStatus = '0';
                $priceCompare = DB::table('personrates')->where('type', $data['shiftView']->vehicleType)->where('personId', $data['shiftView']->driverId)->first();
                
                if (!empty($dayHr) || !empty($nightHr) || !empty($saturdayHrs) || !empty($sundayHrs)) {
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
                            $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight * $nightHr ?? 0;
                            $priceOverRideStatus = '0';
                            $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight * $nightHr;
                        } else {
                            if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableNight) {
                                $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight * $nightHr ?? 0;
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
                            $saturdayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday * $saturdayHrs ?? 0;
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
                    $intValue = (int) $floatValue;
                    if (!empty($intValue)) {
                        if (empty($priceCompare)) {
                            $sundayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSunday * $sundayHrs ?? 0;
                            $priceOverRideStatus = '0';
                            $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                        } else {
                            if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay) {
                                $sundayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSunday * $sundayHrs ?? 0;
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

                $totalPayShiftAmount = $dayShift + $nightShift + $saturdayHr + $sundayHr+(float)$request->input('fuelLevyPayable',0)+(float)$request->input('extraPayable',0);
                Shift::where('id', $id)->update(['payAmount' => $totalPayShiftAmount, 'priceOverRideStatus' => $priceOverRideStatus]);
                $totalChargeDay = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge+(float)$request->input('fuelLevyChargeable250',0)+(float)$request->input('fuelLevyChargeable',0)+(float)$request->input('fuelLevyChargeable400',0)+(float)$request->input('extraChargeable',0);
                // dd($dayShiftCharge , $nightShiftCharge , $saturdayShiftCharge , $sundayShiftCharge,(float)$request->input('fuelLevyChargeable250',0),(float)$request->input('amountChargeablePerService',0),(float)$request->input('fuelLevyChargeable',0),(float)$request->input('fuelLevyChargeable400',0),(float)$request->input('extraChargeable',0));
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
                        $Parcel->startDate = date('Y-m-d',strtotime($start_date));
                        $Parcel->endDate = date('Y-m-d',strtotime($end_date));
                        $Parcel->startTime = date('H:i:s',strtotime($start_date));
                        $Parcel->endTime = date('H:i:s',strtotime($end_date));
                        $Parcel->parcelsTaken = $request->input('parcelsToken');
                        $Parcel->submitted_at = $Parcel->submitted_at ?? date('Y-m-d H:i:s');
                        $Parcel->parcelsDelivered = $request->input('parcelsDelivered');
                        $Parcel->odometerStartReading = $request->input('odometerStartReading');
                        $Parcel->odometerEndReading = $request->input('odometerEndReading');
                        $Parcel->save();
                    }
                } else {
                    return Redirect::back()->with('error', ' Shift Id Not Exist!');
                }

                // return Redirect::back()->with('message', ' Shift Hr. Management Updated Successfully!');
                // }
                // if ($managementId == '3') {
                $shiftMonetizeInformation['amountPayablePerService'] = $request->input('amountPayablePerService');
                $shiftMonetizeInformation['fuelLevyPayable'] = $request->input('fuelLevyPayable');
                $shiftMonetizeInformation['extraPayable'] = $request->input('extraPayable');
                $shiftMonetizeInformation['totalPayable'] = $totalPayShiftAmount;
                $shiftMonetizeInformation['comments'] = $request->input('comments');
                $shiftMonetizeInformation['approvedReason'] = $request->input('approvedReason');
                $shiftMonetizeInformation['amountChargeablePerService'] = $request->input('amountChargeablePerService');
                $shiftMonetizeInformation['fuelLevyChargeable250'] = $request->input('fuelLevyChargeable250');
                $shiftMonetizeInformation['fuelLevyChargeable'] = $request->input('fuelLevyChargeable');
                $shiftMonetizeInformation['fuelLevyChargeable400'] = $request->input('fuelLevyChargeable400');
                $shiftMonetizeInformation['extraChargeable'] = $request->input('extraChargeable');
                $shiftMonetizeInformation['totalChargeable'] = $totalChargeDay;
                
                $shiftMonetize = DB::table('shiftMonetizeInformation')->where('shiftId', $id)->first();
                if ($shiftMonetize) {
                    $shiftMonetizeInformation['shiftId'] = $id;
                    DB::table('shiftMonetizeInformation')->where('shiftId', $id)->update($shiftMonetizeInformation);
                } else {
                    $shiftMonetizeInformation['shiftId'] = $id;
                    DB::table('shiftMonetizeInformation')->insert($shiftMonetizeInformation);
                }
                // DB::table('shifts')->where('id', $id)->update(['payAmount' => $request->input('totalPayable')]);
                // DB::table('shifts')->where('id', $id)->update(['chageAmount' => $request->input('totalChargeable')]);
            // }

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
        if (request()->isMethod('post')) {
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
        $reason = $request->reason ?? null;
        $data['parcelsDetail'] = Shift::whereId($id)->update(['finishStatus' => '3', 'approval_reason' => $reason]);

        return response()->json([
            'status' => 200,
            'message' => 'Shift Approved Successfully!',
        ]);
    }

    public function shiftRejected(Request $request)
    {
        $id = $request->input('shiftId');
        $data['parcelsDetail'] = Shift::whereId($id)->update(['finishStatus' => '4']);

        return response()->json([
            'status' => 200,
            'message' => 'Shift Rejected Successfully!',
        ]);
    }

    public function shiftPaid(Request $request)
    {
        $id = $request->input('shiftId');
        $data['parcelsDetail'] = Shift::whereId($id)->update(['finishStatus' => '5']);

        return response()->json([
            'status' => 200,
            'message' => 'Shift Paid Successfully!',
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
        if ($request->hasFile('addPhoto')) {
            $image = $request->file('addPhoto');
            $dateFolder = 'driver/parcel/finishParcel';
            $items = ImageController::upload($image, $dateFolder);
        }

        $Parcel = new Finishshift();
        $Parcel->driverId = $request->driverId;
        $Parcel->shiftId = $request->shiftId;
        $Parcel->parcelsTaken = $request->startDate;
        $Parcel->endDate = $request->endDate;
        $Parcel->startTime = $request->startTime;
        $Parcel->addPhoto = $items ?? null;
        $Parcel->save();

        if ($Parcel) {
            return response()->json([
                'status' => 200,
                'message' => 'Shift Finished Successfully',
            ]);
        }
    }

    public function getClient(Request $request)
    {
        $getData = Client::select('id', 'name')->where('status', '1')->whereIn('state', $request->input('stateId'))->get();
        if (count($getData) > 0) {
            return response()->json(
                [
                    'success' => 200,
                    'message' => 'Success',
                    'items'    => $getData,
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => 'Not found any items',
                ]
            );
        }
    }

    public function getCostCenter(Request $request)
    {
        $getCostCenter = DB::table('clientcenters')->select('id', 'name', 'base')->where('status', '1')->whereIn('clientId', $request->input('clientId'))->get();
        $getType = Clientrate::select('id', 'clientId', 'type')->with(['getClientType'])->whereIn('clientId', $request->input('clientId'))->get();
        $clientBase = Clientbase::select('id', 'base')->whereIn('clientId', $request->input('clientId'))->get();
        if (count($getCostCenter) > 0) {
            return response()->json(
                [
                    'success' => 200,
                    'message' => 'Success',
                    'items'    => $getCostCenter,
                    'getType' => $getType,
                    'clientBase' => $clientBase,
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => 'Not found any items',
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
        $clientBase = Clientbase::select('id', 'base')->whereIn('clientcentersid', [$clientCenter->id])->get();
        if (count($clientBase) > 0) {
            return response()->json(
                [
                    'success' => 200,
                    'message' => 'Success',
                    'clientBase' => $clientBase,
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => 'Not found any items',
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
                    'success' => 200,
                    'message' => 'Success',
                    'driverRsps'    => $getvehicleTye,
                    'driverRego'    => $driverRego,
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => 'Not found any items s',
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
                    'success' => 200,
                    'message' => 'Success',
                    'items'    => $getData,
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => 'Not found any items',
                ]
            );
        }
    }

    public function getCostCenterB(Request $request)
    {
        $getCostCenter = DB::table('clientcenters')->select('id', 'name', 'base')->where('status', '1')->where('clientId', $request->input('clientId'))->get();
        $getType = Clientrate::select('id', 'clientId', 'type')->with(['getClientType'])->where('clientId', $request->input('clientId'))->get();
        $clientBase = Clientbase::select('id', 'base')->where('clientId', $request->input('clientId'))->get();
        if (count($getCostCenter) > 0) {
            return response()->json(
                [
                    'success' => 200,
                    'message' => 'Success',
                    'items'    => $getCostCenter,
                    'getType' => $getType,
                    'clientBase' => $clientBase,
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => 400,
                    'items' => 'Not found any items',
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


        $shiftsExport = new ShiftReportsExport($shifts);

        // Define the filename
        $filename = 'shift_report.csv';

        // Get the CSV content
        $content = $shiftsExport->exportToCsv();

        // Serve the file as a download response
        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=' . $filename)
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
