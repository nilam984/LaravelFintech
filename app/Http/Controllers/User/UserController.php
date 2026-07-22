<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\BussinessInfo;
use App\Models\GlobalService;
use App\Models\ServiceRequest;
use App\Models\WebHookUrl;
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
        $webhook = WebHookUrl::where('user_id', auth()->id())->first();
        $services = GlobalService::with('serviceRequest')->where('status', 1)->get();

        return view('user.user-profile', compact('business', 'bank', 'webhook', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:global_services,id',
            'webhook_url' => 'required|url',
            'status' => 'required|boolean',

        ]);

        $exists = WebHookUrl::where('user_id', Auth::id())
            ->where('service_id', $request->service_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Webhook already exists for this service.',
            ]);

        }

        WebHookUrl::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'webhook_url' => $request->webhook_url,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Webhook Added Successfully.',
        ]);
    }

    public function edit($id)
    {
        try {

            $webhook = WebHookUrl::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $webhook,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_id' => 'required|exists:global_services,id',
            'webhook_url' => 'required|url',
            'status' => 'required|boolean',
        ]);

        $exists = WebHookUrl::where('user_id', Auth::id())
            ->where('service_id', $request->service_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Webhook already exists for this service.',
            ]);
        }

        $webhook = WebHookUrl::findOrFail($id);

        $webhook->update([
            'service_id' => $request->service_id,
            'webhook_url' => $request->webhook_url,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Webhook Updated Successfully.',
        ]);
    }

    public function loadMoney()
    {
        return view('user.load-money');
    }
}
