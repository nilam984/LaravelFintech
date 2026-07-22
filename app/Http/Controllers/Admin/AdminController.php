<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\BussinessInfo;
use App\Models\GatewayRouting;
use App\Models\GlobalService;
use App\Models\PaymentGateway;
use App\Models\ServiceProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
}
