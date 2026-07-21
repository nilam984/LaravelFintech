<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OauthUser;
use App\Models\GlobalService;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OauthUserController extends Controller
{
    public function index()
    {
        $services = GlobalService::where('status',1)->get();
        return view('user.oauthUser' ,compact('services'));
    }



    public function generateClientCredentials(Request $request)
    {
        if (! Auth::check() || Auth::user()->role != 'user') {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $request->validate([
            'service' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $service = GlobalService::where('service_name', $request->service)
                ->where('status', 1)
                ->first();

            if (! $service) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service not found',
                ], 404);
            }

            $userId = Auth::id();

            $serviceRequest = ServiceRequest::where('user_id', $userId)
                ->where('service_id', $service->id)
                ->where('status', 'active')
                ->first();
            
            // dd([
            //     'user_id' => $userId,
            //     'service_id' => $service->id,
            //     'service_request' => $serviceRequest,
            // ]);

            if (! $serviceRequest) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service is not active for this user.',
                ], 403);
            }
            $clientId = strtoupper(Str::random(12));
            $plainSecret = Str::random(32);
            $hashedSecret = hash('sha512', $plainSecret);

            OauthUser::where('user_id', $userId)
                ->where('service_id', $service->id)
                ->delete();

            $credential = OauthUser::create([
                'user_id' => $userId,
                'service_id' => $service->id,
                'client_id' => $clientId,
                'client_secret' => $hashedSecret,
                'status' => 1,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Client Credentials Generated Successfully.',
                'data' => [
                    'client_id' => $credential->client_id,
                    'client_secret' => $plainSecret,
                ],
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
