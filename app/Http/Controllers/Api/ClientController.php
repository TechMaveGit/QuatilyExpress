<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientBase;
use App\Models\Clientrate;
use App\Models\Driver;
use Auth;
use DB;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class ClientController extends Controller
{
    public $successStatus = 200;
    public $notfound = 404;
    public $unauthorisedStatus = 400;
    public $internalServererror = 500;

    public function allClient(Request $req)
    {
        $stateId = $req->input('state_id');
        $validator = Validator::make($req->all(), [
          'state_id' =>'required|numeric',
        ]);
        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }
        $allClient = Client::select('id', 'name', 'shortName')->where('status', '1')->where('state', $stateId)->get();
        if ($allClient) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'All Client',
                'data'   =>$allClient,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'not found',
            ]);

        }
    }

    public function getProfile(Request $req)
    {
        $driver = auth('driver')->user()->id;
        $driver = Driver::Where('id', $driver)->first();
        $destinationPath = url('assets/driver/profileImage/');

        return response()->json([
                        'status' => $this->successStatus,
                        'profileImage' => $destinationPath,
                        'driverDetail' => $driver,
                    ]);
    }

    public function getCostCenter(Request $request)
    {

        $validator = Validator::make($request->all(), [
                      'clientId' =>'required|numeric',
                  ]);
        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $getCostCenter = DB::table('clientcenters')->select('id', 'name', 'base')->where('staus', '1')->where('clientId', $request->input('clientId'))->get();

        $getType = Clientrate::select('id', 'clientId', 'type')->with(['getClientType'])->where('clientId', $request->input('clientId'))->get();

        $clientBase = ClientBase::select('id', 'base')->where('clientId', $request->input('clientId'))->get();

        if (count($getCostCenter) > 0) {
            return response()->json(
                [
            'success' => 200,
            'message' => 'Success',
            'items'    =>$getCostCenter,
            'getType' =>$getType,
            'clientBase' =>$clientBase,

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

    public function relaodtoken(Request $request)
    {

        if ($request->email) {
            $user = Driver::where('email', $request->email)->first();
            if ($newToken = Auth::guard('driver')->login($user)) {
                return $this->createNewToken($newToken);
            }
        } else {
            try {
                $token = JWTAuth::getToken();
                $newToken = JWTAuth::refresh($token);
            } catch (\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e) {
                // Token has been blacklisted (e.g., user logged out or token invalidated)
                return response()->json(['error' => 'Token has been blacklisted. Please log in again.'], 401);
            } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                // Token and refresh token have both expired
                return response()->json(['error' => 'Token expired. Please log in again.'], 401);
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                // Token is invalid
                return response()->json(['error' => 'Token is invalid.'], 401);
            }
        }

        return $this->createNewToken($newToken);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        //$totalCartproduct = Cart::where('user_id',auth()->user()->id)->count() ?? 0;
        return response()->json([
            'status' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * (60*24*7),
        ]);
    }
}
