<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\BussinessInfo;
use App\Models\GlobalService;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function serviceRequest()
    {
        $services = GlobalService::with('serviceRequest')->where('status', 1)->get();

        return view('user.service-request', compact('services'));
    }

    public function userServiceRequest(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $Id = $request->service_id ?? null;
                $userId = Auth::user()->id;

                $service = GlobalService::where('id', $Id)->where('status', 1)->first();

                if (! $service || ! $Id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Service not found',
                    ]);
                }

                $serviceExists = ServiceRequest::where('user_id', $userId)->where('service_id', $Id)->exists();

                if ($serviceExists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Service already Requested',
                    ]);
                }

                $data = [
                    'user_id' => $userId,
                    'service_id' => $request->service_id,
                    'updated_by' => $userId,
                ];

                $success = ServiceRequest::create($data);

                if ($success) {
                    $status = true;
                    $message = 'Service Requested Successfully';
                } else {
                    $status = false;
                    $message = 'Some error Occured';
                }

                return response()->json([
                    'success' => $status,
                    'message' => $message,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Service Request Error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error : '.$e->getMessage(),
            ]);
        }
    }

    public function userprofile()
    {
        $userId = auth()->id();
        // dd($userId);
        $business = BussinessInfo::where('user_id', $userId)->first();
        // dd($business);
        $bank = BankDetail::where('user_id', $userId)->first();
        return view('user.user-profile', compact('business', 'bank'));
    }
}
