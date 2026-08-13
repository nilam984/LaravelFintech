<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Jobs\SendUserOnboardingInitiatedMail;
use App\Models\BussinessInfo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\GlobalService;
use App\Models\ResellerUser;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\SetupCostOrder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ResellerController extends Controller
{
    public function validateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'mobile' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'pan_no' => ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', 'unique:business_infos,pan', 'unique:business_infos,owner_pan'],
            'pan_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'name.required' => 'Please enter the user name.',
            'name.string' => 'Name must be valid text.',
            'name.max' => 'Name cannot exceed 100 characters.',

            'email.required' => 'Please enter the email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email cannot exceed 150 characters.',

            'mobile.required' => 'Please enter the mobile number.',
            'mobile.regex' => 'Please enter a valid 10-digit Indian mobile number.',

            'pan_no.required' => 'Please enter the PAN number.',
            'pan_no.regex' => 'Please enter a valid PAN number. Example: ABCDE1234F.',

            'pan_image.required' => 'Please upload the PAN image.',
            'pan_image.image' => 'PAN image must be a valid image.',
            'pan_image.mimes' => 'PAN image must be JPG, JPEG, or PNG.',
            'pan_image.max' => 'PAN image cannot be larger than 2 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }


        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'A user with this email already exists.',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'User details validated successfully.',
        ]);
    }

    public function createPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'mobile' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'pan_no' => ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'pan_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            'services' => ['required', 'array', 'min:1'],
            'services.*' => [
                'required',
                'integer',
                'exists:global_services,id'
            ],
        ], [
            'name.required' => 'Please enter customer name.',
            'email.required' => 'Please enter customer email.',
            'email.email' => 'Please enter a valid email address.',
            'mobile.required' => 'Please enter customer mobile number.',
            'mobile.regex' => 'Please enter a valid 10-digit Indian mobile number.',
            'pan_no.required' => 'Please enter PAN number.',
            'pan_no.regex' => 'Please enter a valid PAN number.',
            'pan_image.required' => 'Please upload PAN image.',
            'pan_image.image' => 'PAN image must be a valid image.',
            'pan_image.mimes' => 'PAN image must be JPG, JPEG, or PNG.',
            'pan_image.max' => 'PAN image cannot be larger than 2 MB.',

            'services.required' => 'Please select at least one service.',
            'services.array' => 'Invalid services selected.',
            'services.min' => 'Please select at least one service.',
            'services.*.exists' => 'One or more selected services are invalid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();

        try {

            $serviceIds = collect($request->services)
                ->map(fn($id) => (int) $id)
                ->unique()
                ->values();

            $services = GlobalService::with('costSetup')
                ->whereIn('id', $serviceIds)
                ->where('status', 1)
                ->whereHas('costSetup')
                ->get();

            if ($services->count() !== $serviceIds->count()) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'One or more selected services are unavailable.',
                ], 422);
            }


            $baseAmount = $services->sum(function ($service) {
                return (float) ($service->costSetup->cost ?? 0);
            });

            if ($baseAmount <= 0) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid payment amount.',
                ], 422);
            }


            // GST Calculation
            $gstRate = 18;
            $gstAmount = ($baseAmount * $gstRate) / 100;

            // Final amount including GST
            $grandTotal = $baseAmount + $gstAmount;


            $panImage = null;

            if ($request->hasFile('pan_image')) {
                $panImage = $request->file('pan_image')
                    ->store('uploads/user', 'public');
            }


            $merchantTxnId = 'ORD_' .
                now()->format('YmdHis') .
                '_' .
                strtoupper(Str::random(8));

            $order = SetupCostOrder::create([
                'reseller_id' => Auth::id(),
                'user_id' => null,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'pan_no' => strtoupper($request->pan_no),
                'pan_image' => $panImage,
                'service_ids' => $serviceIds->values()->toJson(),
                'amount' => $baseAmount,
                'gst_amount' => $gstAmount,
                'total_amount' => $grandTotal,
                'status' => 'pending',
                'gateway' => 'sabpaisa',
                'gateway_order_id' => $merchantTxnId,
                'gateway_payment_id' => null,
                'gateway_signature' => null,
                'paid_at' => null,
                'failure_reason' => null,
            ]);

            if (!$order) {
                throw new \Exception('Unable to create payment order.');
            }

            $merchantId = config('sabpaisa.merchant_id');
            $apiKey =     config('sabpaisa.api_key');
            $secretKey =  config('sabpaisa.secret_key');
            $baseUrl =    config('sabpaisa.base_url');

            $amountInPaise = (int) round($grandTotal * 100);
            $timestamp = time();

            $checksumString =
                $merchantId . '|' .
                $merchantTxnId . '|' .
                $amountInPaise . '|' .
                'INR|' .
                $timestamp;

            $checksum = hash_hmac(
                'sha256',
                $checksumString,
                $secretKey
            );

            $returnUrl = route('reseller.payment.return');

            $sabPaisaResponse = Http::timeout(30)
                ->withHeaders([
                    'X-Api-Key' => $apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($baseUrl . '/api/v2/payments', [
                    'merchantId' => $merchantId,
                    'merchantTxnId' => $merchantTxnId,
                    'amount' => $amountInPaise,
                    'currency' => 'INR',
                    'customerName' => $request->name,
                    'customerEmail' => $request->email,
                    'customerPhone' => $request->mobile,
                    'returnUrl' => $returnUrl,
                    'checksum' => $checksum,
                    'timestamp' => $timestamp,
                    'description' => 'Setup Cost - ' . $request->name,
                    'metadata' => [
                        'order_id' => (string) $order->id,
                        'reseller_id' => (string) Auth::id(),
                    ],
                ]);



            if (!$sabPaisaResponse->successful()) {

                Log::error('SabPaisa Create Payment Failed', [
                    'order_id' => $order->id,
                    'response' => $sabPaisaResponse->json(),
                ]);

                $order->update([
                    'status' => 'failed',
                    'failure_reason' => $sabPaisaResponse->body(),
                ]);

                DB::commit();

                return response()->json([
                    'status' => false,
                    'message' => 'Unable to initiate payment. Please try again.',
                ], 422);
            }

            $paymentData = $sabPaisaResponse->json();

            if (
                empty($paymentData['paymentId']) ||
                empty($paymentData['checkoutUrl']) ||
                empty($paymentData['clientSecret'])
            ) {

                throw new \Exception(
                    'Invalid payment response received from SabPaisa.'
                );
            }

            $order->update([
                'gateway_payment_id' => $paymentData['paymentId'],
                'status' => 'pending',
            ]);

            DB::commit();


            $checkoutUrl =
                $paymentData['checkoutUrl'] .
                '?clientSecret=' .
                urlencode($paymentData['clientSecret']);

            return response()->json([
                'status' => true,
                'message' => 'Payment initiated successfully.',
                'order_id' => $order->id,
                'merchant_txn_id' => $merchantTxnId,
                'payment_id' => $paymentData['paymentId'],
                'amount' => $grandTotal,

                'checkout_url' => $paymentData['checkoutUrl'],
                'client_secret' => $paymentData['clientSecret'],
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('SabPaisa Payment Creation Error', [
                'reseller_id' => Auth::id(),
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Unable to initiate payment. Please try again. : ' . $e->getMessage(),
            ], 500);
        }
    }


    public function resellerReturn(Request $request)
    {
        $merchantTxnId = $request->input('merchant_txn_id');

        if (!$merchantTxnId) {
            Log::error('SabPaisa return: merchant transaction ID missing.', [
                'response' => $request->all(),
            ]);

            return redirect()
                ->route('reseller.payment.result')
                ->with([
                    'payment_status' => 'failed',
                    'message' => 'Invalid payment response received.',
                ]);
        }

        $order = SetupCostOrder::where('gateway_order_id', $merchantTxnId)->first();

        if (!$order) {
            Log::error('SabPaisa return: order not found.', [
                'merchant_txn_id' => $merchantTxnId,
                'response' => $request->all(),
            ]);

            return redirect()
                ->route('reseller.payment.result')
                ->with([
                    'payment_status' => 'failed',
                    'message' => 'Payment order could not be found.',
                    'merchant_txn_id' => $merchantTxnId,
                ]);
        }

        if ($order->status === 'success' && $order->user_id) {
            return redirect()
                ->route('reseller.payment.result', ['order' => $order->id])
                ->with([
                    'payment_status' => 'success',
                    'message' => 'Payment was already processed successfully.',
                ]);
        }

        // Verify payment with SabPaisa
        try {
            $merchantId = config('sabpaisa.merchant_id');
            $apiKey = config('sabpaisa.api_key');
            $baseUrl = config('sabpaisa.base_url');
            $clientCode = config('sabpaisa.client_code');

            $enquiryResponse = Http::timeout(30)
                ->withHeaders([
                    'X-Api-Key' => $apiKey,
                    'X-Merchant-Id' => $merchantId,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($baseUrl . '/api/v2/payments/enquiry', [
                    'clientCode' => $clientCode,
                    'merchantTxnId' => $merchantTxnId,
                ]);

            if (!$enquiryResponse->successful()) {
                Log::error('SabPaisa payment enquiry failed.', [
                    'order_id' => $order->id,
                    'merchant_txn_id' => $merchantTxnId,
                    'http_status' => $enquiryResponse->status(),
                    'response' => $enquiryResponse->body(),
                ]);

                return redirect()
                    ->route('reseller.payment.result', ['order' => $order->id])
                    ->with([
                        'payment_status' => 'failed',
                        'message' => 'Unable to verify payment with payment gateway. Please contact support.',
                    ]);
            }

            $payment = $enquiryResponse->json();
        } catch (\Throwable $e) {
            Log::error('SabPaisa enquiry exception.', [
                'order_id' => $order->id,
                'merchant_txn_id' => $merchantTxnId,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('reseller.payment.result', ['order' => $order->id])
                ->with([
                    'payment_status' => 'failed',
                    'message' => 'Unable to verify payment at this time.',
                ]);
        }

        // Validate merchant transaction ID
        if (
            empty($payment['merchantTxnId']) ||
            $payment['merchantTxnId'] !== $order->gateway_order_id
        ) {
            Log::critical('SabPaisa merchant transaction ID mismatch.', [
                'order_id' => $order->id,
                'our_merchant_txn_id' => $order->gateway_order_id,
                'gateway_merchant_txn_id' => $payment['merchantTxnId'] ?? null,
            ]);

            return redirect()
                ->route('reseller.payment.result', ['order' => $order->id])
                ->with([
                    'payment_status' => 'failed',
                    'message' => 'Payment verification failed. Please contact support.',
                ]);
        }

        // Validate merchant ID
        if (
            empty($payment['merchantId']) ||
            $payment['merchantId'] !== $merchantId
        ) {
            Log::critical('SabPaisa merchant ID mismatch.', [
                'order_id' => $order->id,
                'expected_merchant_id' => $merchantId,
                'gateway_merchant_id' => $payment['merchantId'] ?? null,
            ]);

            return redirect()
                ->route('reseller.payment.result', ['order' => $order->id])
                ->with([
                    'payment_status' => 'failed',
                    'message' => 'Payment merchant verification failed. Please contact support.',
                ]);
        }

        // Validate metadata
        $metadata = $payment['metadata'] ?? [];

        $gatewayOrderId = isset($metadata['order_id'])
            ? (int) $metadata['order_id']
            : null;

        $gatewayResellerId = isset($metadata['reseller_id'])
            ? (int) $metadata['reseller_id']
            : null;

        if ($gatewayOrderId !== (int) $order->id) {
            Log::critical('SabPaisa order metadata mismatch.', [
                'order_id' => $order->id,
                'gateway_metadata_order_id' => $gatewayOrderId,
            ]);

            return redirect()
                ->route('reseller.payment.result', ['order' => $order->id])
                ->with([
                    'payment_status' => 'failed',
                    'message' => 'Payment order verification failed. Please contact support.',
                ]);
        }

        if ($gatewayResellerId !== (int) $order->reseller_id) {
            Log::critical('SabPaisa reseller metadata mismatch.', [
                'order_id' => $order->id,
                'order_reseller_id' => $order->reseller_id,
                'gateway_reseller_id' => $gatewayResellerId,
            ]);

            return redirect()
                ->route('reseller.payment.result', ['order' => $order->id])
                ->with([
                    'payment_status' => 'failed',
                    'message' => 'Payment reseller verification failed. Please contact support.',
                ]);
        }

        // Check final payment status
        $gatewayStatus = strtoupper($payment['status'] ?? 'FAILED');

        if ($gatewayStatus !== 'SUCCESS') {
            $failureReason =
                $payment['bankResponseMessage']
                ?? $payment['statusMessage']
                ?? $payment['message']
                ?? $request->input('message')
                ?? 'Payment was not successful.';

            $order->update([
                'status' => 'failed',
                'gateway_payment_id' => $payment['txnId'] ?? $order->gateway_payment_id,
                'gateway_signature' => $request->input('signature'),
                'failure_reason' => $failureReason,
            ]);

            return redirect()
                ->route('reseller.payment.result', ['order' => $order->id])
                ->with([
                    'payment_status' => 'failed',
                    'message' => $failureReason,
                ]);
        }

        // Verify payment amount
        $gatewayAmountPaise = $payment['amountPaise'] ?? null;

        if ($gatewayAmountPaise === null) {
            Log::critical('SabPaisa amount missing from enquiry response.', [
                'order_id' => $order->id,
                'merchant_txn_id' => $merchantTxnId,
                'payment_response' => $payment,
            ]);

            return redirect()
                ->route('reseller.payment.result', ['order' => $order->id])
                ->with([
                    'payment_status' => 'failed',
                    'message' => 'Payment amount could not be verified. Please contact support.',
                ]);
        }

        $expectedAmountPaise = (int) round((float) $order->total_amount * 100);

        if ((int) $gatewayAmountPaise !== $expectedAmountPaise) {
            Log::critical('SabPaisa amount mismatch.', [
                'order_id' => $order->id,
                'merchant_txn_id' => $merchantTxnId,
                'expected_amount' => $order->total_amount,
                'expected_amount_paise' => $expectedAmountPaise,
                'gateway_amount_paise' => $gatewayAmountPaise,
            ]);

            $order->update([
                'status' => 'failed',
                'failure_reason' => 'Payment amount mismatch.',
            ]);

            return redirect()
                ->route('reseller.payment.result', ['order' => $order->id])
                ->with([
                    'payment_status' => 'failed',
                    'message' => 'Payment amount verification failed. Please contact support.',
                ]);
        }

        DB::beginTransaction();

        try {
            $order = SetupCostOrder::where('id', $order->id)
                ->lockForUpdate()
                ->first();

            if (!$order) {
                throw new \Exception('Payment order no longer exists.');
            }

            if ($order->status === 'success' && $order->user_id) {
                DB::commit();

                return redirect()
                    ->route('reseller.payment.result', ['order' => $order->id])
                    ->with([
                        'payment_status' => 'success',
                        'message' => 'Payment was already processed successfully.',
                    ]);
            }

            // Create user
            $password = substr($order->mobile, 2, 6);

            $user = User::create([
                'name' => $order->name,
                'email' => $order->email,
                'mobile' => $order->mobile,
                'password' => Hash::make($password),
                'role' => 'user',
                'registered_by' => 'reseller',
                'reseller_id' => $order->reseller_id,
                'status' => true,
                'email_verified_at' => now(),
            ]);

            if (!$user) {
                throw new \Exception('Unable to create user.');
            }

            // Save PAN information
            $business = BussinessInfo::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'owner_pan' => $order->pan_no,
                    'owner_pan_image' => $order->pan_image,
                ]
            );

            if (!$business) {
                throw new \Exception('Unable to create user business information.');
            }

            // Get services
            $serviceIds = json_decode($order->service_ids, true);

            if (!is_array($serviceIds) || empty($serviceIds)) {
                throw new \Exception('No services found for this payment order.');
            }

            $serviceIds = collect($serviceIds)
                ->map(fn($id) => (int) $id)
                ->filter()
                ->unique()
                ->values();

            // Assign services
            foreach ($serviceIds as $serviceId) {

                $data = [
                    'user_id' => $user->id,
                    'service_id' => $serviceId,
                    'updated_by' => $user->id,
                ];

                ServiceRequest::create($data);
            }

            // Update payment order
            $order->update([
                'user_id' => $user->id,
                'status' => 'success',
                'gateway_payment_id' => $payment['txnId'] ?? $order->gateway_payment_id,
                'gateway_signature' => $request->input('signature'),
                'paid_at' => now(),
                'failure_reason' => null,
            ]);

            DB::commit();

            // Send onboarding email through queue
            SendUserOnboardingInitiatedMail::dispatch($order->id);

            return redirect()
                ->route('reseller.payment.result', ['order' => $order->id])
                ->with([
                    'payment_status' => 'success',
                    'message' => 'Payment successful and customer onboarding has been initiated.',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Reseller user creation after payment failed.', [
                'order_id' => $order->id,
                'merchant_txn_id' => $merchantTxnId,
                'reseller_id' => $order->reseller_id,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return redirect()
                ->route('reseller.payment.result', ['order' => $order->id])
                ->with([
                    'payment_status' => 'failed',
                    'message' => 'Payment was successful, but customer onboarding could not be completed. Please contact support.',
                    'merchant_txn_id' => $merchantTxnId,
                ]);
        }
    }


    public function paymentResult($order = null)
    {
        $setupOrder = null;

        if ($order) {
            $setupOrder = SetupCostOrder::where('id', $order)
                ->where('reseller_id', Auth::id())
                ->first();
        }

        return view('reseller.payment-result', [
            'order' => $setupOrder,
            'status' => session('payment_status', 'failed'),
            'message' => session('message', 'Unable to process payment.'),
        ]);
    }
}
