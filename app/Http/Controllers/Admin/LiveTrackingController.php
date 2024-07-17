<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Parcels;
use App\Models\Shift;
use App\Models\State;
use App\Models\TrackLocation;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class LiveTrackingController extends Controller
{
    public function liveTracking(Request $request)
    {
        $locations = '';
        $driver = Driver::with('allshift')->has('allshift')->get();
        $driverName = '';
        $shiftId = '';
        $parcelLocation = null;
        $startpoints = null;
        $endpoints = null;
        $beforeParcelImage = null;
        $selected_driver = null;

        if (request()->isMethod('post')) {
            $driverName = $request->input('driverName');
            $shiftId = $request->input('shiftName');
            $locations = DB::table('track_location')->select('latitude as lat', 'longitude as lng','created_at')->orderBy('id', 'DESC');

            if ($driverName) {
                $locations->where('driver_id', $driverName);
            }

            if ($shiftId) {
                $locations->where('shiftid', $shiftId);
            }
            $shiftData = Shift::where('id',$shiftId)->first();
            
            $startpoints = ['lat'=>$shiftData->startlatitude??null,'lng'=>$shiftData->startlongitude??null,'address'=>$shiftData->startaddress??null];
            $endpoints = ['lat'=>$shiftData->endlatitude??null,'lng'=>$shiftData->endlongitude??null,'address'=>$shiftData->endaddress??null];
            $locations = $locations->get()->map(function ($location) {
                $location->created_at = Carbon::parse($location->created_at)
                    ->setTimezone('Australia/Sydney')
                    ->format('Y-m-d H:i:s');
                return $location;
            })
            ->toArray();
            $selected_driver['driver'] = Driver::whereId($driverName ?? '')->first()->toArray() ?? '';
            $selected_driver['shift'] = Shift::with('getRego')->where(['driverId'=>$driverName,'shiftStatus'=>'2'])->orderBy('id','DESC')->first()->toArray() ?? '';

            
            if ($shiftId) {
                $parcelLocation = Parcels::with('ParcelImage')->select('id','latitude as lat', 'longitude as lng', 'location', 'scanParcel', 'receiverName','deliveredTo','parcelphoto','deliver_address','parcelDeliverdDate','delivered_latitude','delivered_longitude','status','created_at','sorting')->orderByRaw('IFNULL(sorting, id) DESC');
                $parcelLocation->where('shiftid', $shiftData->id);
                $parcelLocation = $parcelLocation->get()->toArray();
            }

          
            if(!$shiftData->endlatitude || !$endpoints['lat']){
                $dataEnd = end($parcelLocation);
                $endpoints = ['lat'=>$dataEnd['lat']??null,'lng'=>$dataEnd['lng']??null,'address'=>$dataEnd['location']??null];
            }
        }

        return view('admin.liveTracking.live', compact('locations', 'driver', 'driverName', 'shiftId', 'parcelLocation','startpoints','endpoints','selected_driver'));
    }

    public function getDriverLocation(Request $request)
    {
        $driverName = '';
        $driverIds = Shift::where(['finishStatus'=>'1','shiftStatus'=>'2'])->orderBy('id','DESC')->get()->pluck('driverId')->toArray()??null;
        $driver = Driver::whereIn('id',$driverIds)->get();
        $locations = [];
        $parcelLocation = null;
        $startpoints = null;
        $endpoints = null;
        $beforeParcelImage =null;
        $selected_driver = null;
        
        if (request()->isMethod('post')) {
            $driverName = $request->input('driverName');
            $locations = DB::table('track_location')->select('latitude as lat', 'longitude as lng','created_at');
            $shiftData = Shift::where(['driverId'=>$driverName,'shiftStatus'=>'2'])->orderBy('id','DESC')->first();
            // $selected_driver = Driver::whereId($driverName ?? '')->first()->toArray();

            $selected_driver['driver'] = Driver::whereId($driverName ?? '')->first()->toArray() ?? '';
            $selected_driver['shift'] = Shift::with('getRego')->where(['driverId'=>$driverName,'shiftStatus'=>'2'])->orderBy('id','DESC')->first()->toArray() ?? '';
           
            if ($driverName) {
                $locations->where(['driver_id'=> $driverName,'shiftid'=>$shiftData->id]);
            }
            
            $startpoints = ['lat'=>$shiftData->startlatitude??null,'lng'=>$shiftData->startlongitude??null,'address'=>$shiftData->startaddress??null];
            $endpoints = ['lat'=>$shiftData->endlatitude??null,'lng'=>$shiftData->endlongitude??null,'address'=>$shiftData->endaddress??null];
            $locations = $locations->orderBy('id', 'ASC')->get()->map(function ($location) {
                $location->created_at = Carbon::parse($location->created_at)
                    ->setTimezone('Australia/Sydney')
                    ->format('Y-m-d H:i:s');
                return $location;
            })
            ->toArray();


            if ($shiftData->id) {
                $parcelLocation = Parcels::with('ParcelImage')->select('id','latitude as lat', 'longitude as lng', 'location', 'scanParcel', 'receiverName','deliveredTo','parcelphoto','deliver_address','parcelDeliverdDate','delivered_latitude','delivered_longitude','status','created_at','sorting')->orderByRaw('IFNULL(sorting, id) DESC');
                $parcelLocation->where('shiftid', $shiftData->id);
                $parcelLocation = $parcelLocation->get()->toArray();
            }

            // dd($parcelLocation);

            if(!$shiftData->endlatitude || !$endpoints['lat']){
                $dataEnd = end($parcelLocation);
                $endpoints = ['lat'=>$dataEnd['lat']??null,'lng'=>$dataEnd['lng']??null,'address'=>$dataEnd['location']??null];
            }
        }else{
            foreach ($driver as $alldriver) {
                $location = TrackLocation::select('id', 'driver_id', 'latitude as lat', 'longitude as lng','created_at')->orderBy('id', 'DESC')->where('driver_id', $alldriver->id)->first();
                    if (isset($location->driver_id)) {
                        $location->driver = Driver::whereId($location->driver_id ?? '')->first()->toArray() ?? '';
                        $location->shift = Shift::with('getRego')->where(['driverId'=>$location->driver_id,'shiftStatus'=>'2'])->orderBy('id','DESC')->first()->toArray() ?? '';
                    }
                    if ($location) {
                        $location->sydney_time = Carbon::parse($location->created_at)
                        ->setTimezone('Australia/Sydney')
                        ->format('Y-m-d H:i:s');
                        $locations[] = $location->toArray();
                    } else {
                }
            }
        }
        // dd($locations);
        return view('admin.liveTracking.driverLocation', compact('locations','driver','driverName','parcelLocation','startpoints','endpoints','selected_driver'));
    }

    public function getShift(Request $request)
    {
        $typeId = $request->input('typeId');
        $getdriverResponsible = Shift::where('driverId', $typeId)->orderBy('id','DESC')->get();
        if ($getdriverResponsible) {
            return response()->json([
                'success' => '200',
                'message' => 'get Shift',
                'vehicleData' => $getdriverResponsible,
            ]);
        }
    }

    public function state(Request $request)
    {
        if (request()->isMethod('post')) {
            $data = State::where('name', $request->input('stateName'))->first();
            if ($data) {
                return redirect()->back()->with('error', 'State Already Exist!');
            } else {
                $stateName = $request->input('stateName');
                $data = [
                    'name' => $stateName,
                ];
                State::create($data);

                return redirect()->back()->with('message', 'State Added Successfully!');
            }
        }
        $state = State::where('status','!=','2')->get();

        return view('admin.state.state', compact('state'));
    }

    public function stateEdit(Request $request)
    {
        $stateName = $request->input('stateName');
        $stateId = $request->input('stateId');
        $state = $request->input('state');
        $data = [
            'name' => $stateName,
            'status' => $state,
        ];
        State::whereId($stateId)->update($data);

        return redirect()->back()->with('message', 'State Edit Successfully!');
    }

    public function stateDelete(Request $request)
    {
        $stateId = $request->input('stateId');
        State::whereId($stateId)->update(['status' => '2']);

        return redirect()->back()->with('message', 'State Delete Successfully!');
    }

    protected function getOptimizedRoute($apiKey, $origin, $destination, $waypoints)
    {
        // Base URL for the Google Directions API
        $baseUrl = 'https://maps.googleapis.com/maps/api/directions/json?';

        // Parameters for the request
        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'waypoints' => 'optimize:true|' . implode('|', $waypoints),
            'key' => $apiKey,
        ];

        // Construct the full URL with parameters
        $url = $baseUrl . http_build_query($params);

        // Send the request using file_get_contents (you can also use cURL)
        $response = file_get_contents($url);

        // Parse the JSON response
        $data = json_decode($response, true);

        // Handle the response
        if ($data['status'] == 'OK') {
            return $data['routes'][0]; // Return the first (and usually only) route
        } else {
            throw new \Exception('Error: ' . $data['status']);
        }
    }

    public function liveTrack()
    {

        // Example usage
        $apiKey = 'AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s';
        $origin = '37.7749,-122.4194';
        $destination = '34.0522,-118.2437'; // Example: Los Angeles, CA
        $waypoints = [
            '36.7783,-119.4179', // Example: Fresno, CA
            '35.3733,-119.0187',  // Example: Bakersfield, CA
        ];

        try {
            $optimizedRoute = $this->getOptimizedRoute($apiKey, $origin, $destination, $waypoints);
            echo '<pre>';
            print_r($optimizedRoute);
            echo '</pre>';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
