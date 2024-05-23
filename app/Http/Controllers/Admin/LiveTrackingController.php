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

        $allActiveLocation = DB::table('track_location')->get();

        $locations = '';
        $driver = Driver::get();
        $driverName = '';
        $shiftName = $request->input('shiftName');
        $firstLocation = '';
        $parcelLocation = '';
        $doMarkLocation = '';
        $deliver_address = '';
        if (request()->isMethod('post')) {
            $request->all();
            $driverName = $request->input('driverName');
            $shiftName = $request->input('shiftName');
            $shiftId = Shift::select('id', 'base')->where('id', $shiftName)->pluck('id')->toArray();
            $locations = DB::table('track_location')->select('latitude as lat', 'longitude as lng')->orderBy('id', 'DESC');
            $lastLocations = DB::table('track_location')->select('id', 'shiftid')->orderBy('id', 'DESC');
            if ($driverName) {
                $locations->where('driver_id', $driverName);
            }
            if ($shiftId) {
                $locations->whereIn('shiftid', $shiftId);
            }
            $locations = $locations->get()->toArray();
            $lastLocations = $lastLocations->first()->shiftid ?? '';
            $deliver_address = Parcels::where('shiftId', $lastLocations)->first()->deliver_address ?? '';
            if ($shiftId) {
                $parcelLocation = Parcels::select('latitude as lat', 'longitude as lng', 'location', 'scanParcel', 'receiverName')->orderBy('sorting', 'DESC');
                $parcelLocation->whereIn('shiftid', $shiftId);
                $parcelLocation = $parcelLocation->get()->toArray();
                $doMarkLocation = Parcels::select('shiftId')
                    ->orderBy('sorting', 'DESC')
                    ->where('status', '2')
                    ->whereIn('shiftid', $shiftId)
                    ->get()
                    ->toArray();
                $doMarkLocation = DB::table('parcels')
                    ->select('delivered_latitude as lat', 'delivered_longitude as lng', 'deliveredTo', 'deliver_address')
                    ->whereIn('shiftid', $doMarkLocation)
                    ->orderBy('id', 'DESC')
                    ->get();
            }
            if ($shiftId) {
                $firstLocation = DB::table('track_location')
                    ->select('latitude as lat', 'longitude as lng')
                    ->orderBy('id', 'DESC')
                    ->where('shiftId', $shiftId)
                    ->get()
                    ->first();
            } else {
                $firstLocation = '';
            }
            // dd($locations, $shift, $driver, $driverName, $shiftName, $firstLocation, $deliver_address, $parcelLocation, $doMarkLocation);
        }

        return view('admin.liveTracking.live', compact('locations', 'driver', 'driverName', 'shiftName', 'firstLocation', 'deliver_address', 'parcelLocation', 'doMarkLocation'));
    }

    public function getDriverLocation(Request $request)
    {
        $driver = Driver::where('status', '1')->get();
        $locations = [];
        foreach ($driver as $alldriver) {
            $location = TrackLocation::select('id', 'driver_id', 'latitude as lat', 'longitude as lng')
                ->orderBy('id', 'DESC')
                ->where('driver_id', $alldriver->id)
                ->first();
            if (isset($location->driver_id)) {
                $location->name = Driver::whereId($location->driver_id ?? '')->first()->userName ?? '';
            }
            if ($location) {
                $locations[] = $location->toArray();
            } else {
                // Handle the case when no record is found for the current driver ID
                // For example, you can add a default location or skip adding to $locations
            }
        }

        return view('admin.liveTracking.driverLocation', compact('locations'));
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
