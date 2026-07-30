<?php

namespace App\Http\Controllers\API;

use App\Helper\APIHelper;
use App\Http\Controllers\Controller;
use App\Models\PayinTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PayinController extends Controller
{
    protected $apiHelper;

    public function __construct(APIHelper $apiHelper)
    {
        $this->apiHelper = $apiHelper;
    }

    public function payin(Request $request)
    {
        $userId = null;
        $serviceId = null;
        $amount = $request->amount;

        $validator = Validator::make(
            $request->all(),
            [
                'payerName'    => 'required|string|min:3|max:50',
                'payerEmail'   => 'required|email|max:50',
                'payerMobile'  => ['required', 'regex:/^(?:\+91|91)?[6-9]\d{9}$/'],
                'orderId' => 'required|string|max:20|unique:payin_transactions,user_order_id',
                'amount'        => 'required|numeric|min:100',
            ],
            [
                'payerName.required' => 'Payer name is required.',
                'payerName.string' => 'Payer name must be a valid string.',
                'payerName.min' => 'Payer name must be at least 3 characters.',
                'payerName.max' => 'Payer name cannot exceed 50 characters.',

                'payerEmail.required' => 'Payer email is required.',
                'payerEmail.email' => 'Please enter a valid email address.',
                'payerEmail.max' => 'Payer email cannot exceed 50 characters.',

                'payerMobile.required' => 'Payer mobile number is required.',
                'payerMobile.regex' => 'Please enter a valid Indian mobile number.',

                'orderId.required' => 'Order ID is required.',
                'orderId.string' => 'Order ID must be a valid string.',
                'orderId.max' => 'Order ID cannot exceed 20 characters.',
                'orderId.unique' => 'This Order ID already exists.',

                'amount.required' => 'Amount is required.',
                'amount.numeric' => 'Amount must be a valid number.',
                'amount.min' => 'Minimum transaction amount is ₹100.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }


        try {

            $authData = $this->apiHelper->validateHeaderRequest($request, 'Payin');

            if ($authData['userId']) {
                $userId =  $authData['userId'];
                $serviceId =  $authData['serviceId'];
            }

            $this->apiHelper->checkKycVerified($userId);
            $this->apiHelper->checkIpWhiteListed($userId, $serviceId);
            $this->apiHelper->checkUserServiceActive($userId, $serviceId);
            $feeTax =  $this->apiHelper->schemeAndFeeTax($userId, $serviceId, $amount);
            $referenceId =  $this->apiHelper->generateReferenceId();
            $gatewayType =  $this->apiHelper->defaultGateway('payin');


            $payinData = [
                'user_id' => $userId,
                'payer_name' => $request->payerName,
                'payer_mobile' => $request->payerMobile,
                'payer_email' => $request->payerEmail,
                'user_order_id' => $request->orderId,
                'payment_reference_id' => $referenceId,
                'amount' => $request->amount,
                'fee' => $feeTax['fee'],
                'tax' => $feeTax['tax'],
                'final_amount' => $feeTax['finalAmount'],
                'gateway_type' => $gatewayType,
                'remarks' => "Payin request for this orderId : $request->orderId",
                'updated_by' => $userId,
            ];

            DB::beginTransaction();

            try {

                PayinTransaction::create($payinData);

                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Request Accepted Successfully'
                ]);
            } catch (\Exception $e) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Error : ' . $e->getMessage()
                ]);
            }

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
