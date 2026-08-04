<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\BussinessInfo;
use App\Models\GatewayRouting;
use App\Models\GlobalService;
use App\Models\LoadMoney;
use App\Models\OauthUser;
use App\Models\PaymentGateway;
use App\Models\ServiceProduct;
use App\Models\User;
use App\Models\WebHookUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function allusers()
    {
        return view('admin.all-users');
    }

    public function globalServices()
    {
        return view('admin.global-service');
    }

    public function serviceRequest()
    {
        $users = User::where('role', 'user')->orderBy('id', 'desc')->get();
        return view('admin.service-request', compact('users'));
    }

    public function getProducts($service_id)
    {
        return ServiceProduct::where('service_id', $service_id)
            ->select('id', 'product_name')
            ->get();
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'service_name' => 'required|string|max:255|unique:global_services,service_name',
                'status' => 'required|boolean',
            ]);

            GlobalService::create([
                'service_name' => $request->service_name,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Global Service Added Successfully.',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Global Service Store Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'service_name' => 'required|unique:global_services,service_name,' . $request->id,
            'status' => 'required',
        ]);
        $service = GlobalService::findOrFail($request->id);
        $service->update([
            'service_name' => $request->service_name,
            'status' => $request->status,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Service Updated Successfully.',
        ]);
    }


    public function addProduct(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'products' => 'required|array|min:1',
            'products.*.product_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            ServiceProduct::where('service_id', $request->service_id)->delete();
            $insertData = [];
            foreach ($request->products as $product) {
                $insertData[] = [
                    'service_id'  => $request->service_id,
                    'product_name' => trim($product['product_name']),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
            ServiceProduct::insert($insertData);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Products saved successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function gatewayRouting()
    {
        $payinGateways = PaymentGateway::where('gateway_type', 'payin')->where('status', 1)->latest()->get();
        $payoutGateways = PaymentGateway::where('gateway_type', 'payout')->where('status', 1)->latest()->get();
        $payinCurrentRouteId = GatewayRouting::with('gatewayName')->where('gateway_type', 'payin')->first();
        $payoutCurrentRouteId = GatewayRouting::with('gatewayName')->where('gateway_type', 'payout')->first();
        return view('admin.gateway-routing', compact('payinGateways', 'payoutGateways', 'payinCurrentRouteId', 'payoutCurrentRouteId'));
    }

    public function switchGatewayRoute(Request $request)
    {
        try {
            if (!in_array($request->gateway_type, ['payin', 'payout'])) {
                return redirect()->back()->with('error', 'Invalid Gateway type');
            }

            if ($request->gateway_type == 'payin') {

                $request->validate([
                    'payin_gateway_id' => 'required|exists:payment_gateways,id',
                ]);

                $gatewayId = $request->payin_gateway_id;
                $gatewayType = 'payin';
            } else {

                $request->validate([
                    'payout_gateway_id' => 'required|exists:payment_gateways,id',
                ]);

                $gatewayId = $request->payout_gateway_id;
                $gatewayType = 'payout';
            }

            $updatedBy = Auth::user()->id;

            $created = DB::transaction(function () use ($gatewayType, $gatewayId, $updatedBy) {
                return GatewayRouting::updateOrCreate(

                    ['gateway_type' => $gatewayType],

                    [
                        'payment_gateway_id' => $gatewayId,
                        'updated_by' => $updatedBy
                    ]
                );
            });

            if ($created) {
                return redirect()->back()->with('success', 'Gateway Switched Successfully');
            } else {
                return redirect()->back()->with('error', 'Some Error Occured');
            }
        } catch (\Exception $e) {
            Log::error('Gateway switch error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error : ' . $e->getMessage());
        }
    }


    public function loadMoney()
    {
        $users = User::where('role', 'user')->orderBy('id', 'desc')->get();
        return view('admin.load-money', compact('users'));
    }

    public function adminprofile()
    {
        $userId = auth()->id();
        $business = BussinessInfo::where('user_id', $userId)->first();
        $bank = BankDetail::where('user_id', $userId)->first();
        return view('admin.admin-profile', compact('business', 'bank'));
    }


    public function loadMoneyAction(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:load_money,id'],
            'status' => ['required', Rule::in(['approved', 'rejected'])],
            'remark' => ['nullable', 'string', 'max:300'],
        ]);

        if ($validated['status'] === 'rejected' &&   blank($validated['remark'])) {
            return response()->json([
                'success' => false,
                'message' => 'Remark is required for rejection.'
            ], 422);
        }

        DB::beginTransaction();

        try {

            $loadRequest = LoadMoney::lockForUpdate()->findOrFail($validated['id']);

            if ($loadRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'This request has already been processed.'
                ], 422);
            }

            $userId = Auth::user()->id;

            if ($validated['status'] === 'rejected') {

                $loadRequest->update([
                    'status' => 'rejected',
                    'rejection_remark' => $validated['remark'],
                    'updated_by' => $userId,
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Request rejected successfully.'
                ]);
            }


            $user = $loadRequest->user()->lockForUpdate()->first();

            $amount = $loadRequest->amount;

            $user->increment('main_wallet', $amount);


            // Ledger Record
            // WalletTransaction::create([
            //     'user_id'        => $user->id,
            //     'amount'         => $amount,
            //     'type'           => 'credit',
            //     'wallet_type'    => 'main_wallet',
            //     'reference_id'   => $loadRequest->id,
            //     'reference_type' => 'service_request',
            //     'remark'         => 'Service request approved',
            // ]);

            $loadRequest->update([
                'status' => 'approved',
                'updated_by' => $userId,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Request approved successfully.'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error : ' . $e->getMessage()
            ], 500);
        }
    }


    public function userDetails($Id)
    {

        $user = User::with('businessInfo')->find($Id);
        $business = BussinessInfo::where('user_id', $Id)->first();
        $bank = BankDetail::where('user_id', $Id)->first();
        $webhooks = WebHookUrl::with('service')->where('user_id', $Id)->latest()->get();
        $keyDetails = OauthUser::with('service')->where('user_id', $Id)->latest()->get();
        $kycFields = config('kyc.fields');
        return view('admin.user-details', compact('business', 'bank', 'webhooks', 'keyDetails', 'user', 'kycFields'));
    }


    // public function userKycVerify($Id)
    // {

    //     $user = User::with('businessInfo')->find($Id);

    //     if (!$user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'User not found'
    //         ], 404);
    //     }

    //     $businessInfo = $user->businessInfo;

    //     if (!$businessInfo) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Business details not found for this User'
    //         ], 404);
    //     }

    //     $requiredFields = [
    //         $businessInfo->pan,
    //         $businessInfo->pan_image,
    //         $businessInfo->gst,
    //         $businessInfo->website_url,
    //         $businessInfo->owner_aadhar,
    //         $businessInfo->owner_aadhar_image_front,
    //         $businessInfo->owner_aadhar_image_back,
    //         $businessInfo->owner_pan,
    //         $businessInfo->owner_pan_image,
    //     ];

    //     if (collect($requiredFields)->contains(fn($value) => empty($value))) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Profile/KYC related details are incomplete please check'
    //         ], 422);
    //     }

    //     try {
    //         DB::beginTransaction();

    //         $business = BussinessInfo::find($businessInfo->id);

    //         if (!$business) {
    //             throw new \Exception('Business information record not found.');
    //         }

    //         $business->kyc_verified = 1;
    //         $business->save();

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'KYC status updated successfully'
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to update KYC status: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function verifyKyc(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'field'   => 'required|string',
            'status'  => 'required|in:approved,rejected',
            'remark'  => 'nullable|string'
        ]);

        $business = BussinessInfo::where('user_id', $request->user_id)->firstOrFail();
        $kycData = $business->kyc_verification_data ?? [];


        if (auth()->user()->role == 'verification') {
            $level = 'verification';
        } elseif (auth()->user()->role == 'admin') {
            $level = 'admin';
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 403);
        }

        $kycData[$request->field][$level] = [
            'status' => $request->status,
            'remark' => $request->remark,
            'by' => auth()->id(),
            'at' => now()

        ];

        if ($level == 'admin' && $request->status == 'rejected') {

            $kycData[$request->field]['verification']['status'] = 'rejected';

            $kycData[$request->field]['verification']['remark'] =
                "Rejected by Admin: " . $request->remark;
        }

        $business->kyc_verification_data = $kycData;

        if ($level == 'verification') {
            $statuses = collect($kycData)->pluck('verification.status');
            if ($statuses->contains('rejected')) {
                $business->kyc_status = 'verification_rejected';
            } elseif ($statuses->every(fn($status) => $status == 'approved')) {
                $business->kyc_status = 'verification_approved';
            } else {
                $business->kyc_status = 'pending';
            }
            $business->verification_by = auth()->id();
            $business->verification_at = now();
        }


        if ($level == 'admin') {
            $statuses = collect($kycData)->pluck('admin.status');
            if ($statuses->contains('rejected')) {
                $business->kyc_status = 'admin_rejected';
            } elseif ($statuses->every(fn($status) => $status == 'approved')) {
                $business->kyc_status = 'approved';
            }
            $business->admin_verified_by = auth()->id();
            $business->admin_verified_at = now();
        }

        $business->save();
        return response()->json([
            'success' => true,
            'message' => 'KYC updated successfully.'

        ]);
    }

    public function verificationOfficer()
    {
        return view('admin.user-verification');
    }
}
