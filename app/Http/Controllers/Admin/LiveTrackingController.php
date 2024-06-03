<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Parcels;
use App\Models\Shift;
use App\Models\State;
use App\Models\TrackLocation;
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

        if (request()->isMethod('post')) {
            $driverName = $request->input('driverName');
            $shiftId = $request->input('shiftName');
            $locations = DB::table('track_location')->select('latitude as lat', 'longitude as lng')->orderBy('id', 'DESC');

            if ($driverName) {
                $locations->where('driver_id', $driverName);
            }

            if ($shiftId) {
                $locations->where('shiftid', $shiftId);
            }
            $shiftData = Shift::where('id',$shiftId)->first();
            


            $startpoints = ['lat'=>$shiftData->startlatitude??null,'lng'=>$shiftData->startlongitude??null,'address'=>$shiftData->startaddress??null];
            $endpoints = ['lat'=>$shiftData->endlatitude??null,'lng'=>$shiftData->endlongitude??null,'address'=>$shiftData->endaddress??null];
            $locations = $locations->get()->toArray();

            if ($shiftId) {
                $parcelLocation = Parcels::select('id','latitude as lat', 'longitude as lng', 'location', 'scanParcel', 'receiverName','deliveredTo','parcelphoto','deliver_address','parcelDeliverdDate','delivered_latitude','delivered_longitude','status')->orderBy('sorting', 'DESC');
                $parcelLocation->where('shiftid', $shiftId);
                $parcelLocation = $parcelLocation->get()->toArray();

                $beforeParcelImageData = $parcelLocation[0] ? DB::table('addparcelimages')->where('parcelId',$parcelLocation[0]['id'])->first()??null : null;
                $beforeParcelImage =  $beforeParcelImageData ? $beforeParcelImageData->parcelImage : null;
            
            }
        }

        return view('admin.liveTracking.live', compact('locations', 'driver', 'driverName', 'shiftId', 'parcelLocation','startpoints','endpoints','beforeParcelImage'));
    }

    public function getDriverLocation(Request $request)
    {
        $driverName = '';
        $driverIds = Shift::where('shiftStatus','2')->get()->pluck('driverId')->toArray()??null;
        $driver = Driver::whereIn('id',$driverIds)->get();
        $locations = [];
        $parcelLocation = null;
        $startpoints = null;
        $endpoints = null;
        $beforeParcelImage =null;
        
        if (request()->isMethod('post')) {
            $driverName = $request->input('driverName');
            $locations = DB::table('track_location')->select('latitude as lat', 'longitude as lng')->orderBy('id', 'DESC');
            $shiftData = Shift::where(['driverId'=>$driverName,'shiftStatus'=>'2'])->orderBy('id','DESC')->first();

            if ($driverName) {
                $locations->where('driver_id', $driverName);
            }
            
            $startpoints = ['lat'=>$shiftData->startlatitude??null,'lng'=>$shiftData->startlongitude??null,'address'=>$shiftData->startaddress??null];
            $endpoints = ['lat'=>$shiftData->endlatitude??null,'lng'=>$shiftData->endlongitude??null,'address'=>$shiftData->endaddress??null];
            $locations = $locations->get()->toArray();

            if ($shiftData->id) {
                $parcelLocation = Parcels::select('id','latitude as lat', 'longitude as lng', 'location', 'scanParcel', 'receiverName','parcelphoto','deliver_address','parcelDeliverdDate','delivered_latitude','delivered_longitude','status')->orderBy('sorting', 'DESC');
                $parcelLocation->where('shiftid', $shiftData->id);
                $parcelLocation = $parcelLocation->get()->toArray();
                $beforeParcelImageData = $parcelLocation[0] ? DB::table('addparcelimages')->where('parcelId',$parcelLocation[0]['id'])->first()??null : null;
                $beforeParcelImage =  $beforeParcelImageData ? $beforeParcelImageData->parcelImage : null;
            }
        }else{
            foreach ($driver as $alldriver) {
                $location = TrackLocation::select('id', 'driver_id', 'latitude as lat', 'longitude as lng')
                    ->orderBy('id', 'DESC')
                    ->where('driver_id', $alldriver->id)
                    ->first();
                    if (isset($location->driver_id)) {
                        $location->driver = Driver::whereId($location->driver_id ?? '')->first()->toArray() ?? '';
                        $location->shift = Shift::where(['driverId'=>$location->driver_id,'shiftStatus'=>'2'])->orderBy('id','DESC')->first()->toArray() ?? '';
                    }
                    if ($location) {
                        $locations[] = $location->toArray();
                    } else {
                }
            }
        }

        // dd($locations);

        return view('admin.liveTracking.driverLocation', compact('locations','driver','driverName','parcelLocation','startpoints','endpoints','beforeParcelImage'));
    }

    public function getShift(Request $request)
    {
        $typeId = $request->input('typeId');
        $getdriverResponsible = Shift::where('driverId', $typeId)->get();
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
        $state = State::get();

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
        State::whereId($stateId)->update(['status' => '0']);

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
