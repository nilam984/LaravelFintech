<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\BussinessInfo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\GlobalService;
use App\Models\ResellerUser;
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
            'pan_no' => ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
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

    public function getServices()
    {
        $services = GlobalService::with('costSetup')
            ->whereHas('costSetup')
            ->where('status', 1)
            ->latest()
            ->get();

        $html = view('reseller.partials.services', compact('services'))->render();

        return response()->json([
            'status' => true,
            'html' => $html,
        ]);
    }


    public function createPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'mobile' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'pan_no' => ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            // 'pan_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

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


            $totalAmount = $services->sum(function ($service) {
                return (float) ($service->costSetup->cost ?? 0);
            });

            if ($totalAmount <= 0) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid payment amount.',
                ], 422);
            }


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
                'total_amount' => $totalAmount,
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

            $merchantId = env('SABPAISA_MERCHANT_ID');
            $apiKey = env('SABPAISA_API_KEY');
            $secretKey = env('SABPAISA_SECRET_KEY');
            $baseUrl = env('SABPAISA_BASE_URL');

            $amountInPaise = (int) round($totalAmount * 100);
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
                'amount' => $totalAmount,

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


    public function storeUserAfterPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_id' => ['required', 'string'],
            'services' => ['required', 'array', 'min:1'],
            'services.*' => ['required', 'integer', 'exists:global_services,id'],

            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'mobile' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'pan_no' => ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'pan_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        /*
    |--------------------------------------------------------------------------
    | IMPORTANT
    |--------------------------------------------------------------------------
    | Before creating the user, verify the payment with your payment gateway.
    |
    | Example:
    |
    | $payment = PaymentService::verify($request->payment_id);
    |
    | if (!$payment->successful) {
    |     return response()->json(...);
    | }
    |
    |--------------------------------------------------------------------------
    */

        DB::beginTransaction();

        try {

            $password = substr($request->mobile, 2, 6);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($password),
                'role' => 'user',
                'registered_by' => 'reseller',
                'reseller_id' => Auth::id(),
                'status' => true,
                'email_verified_at' => now(),
            ]);

            if (!$user) {
                throw new \Exception('Unable to create user.');
            }

            $panImage = null;

            if ($request->hasFile('pan_image')) {
                $panImage = $request->file('pan_image')
                    ->store('uploads/user_pan', 'public');
            }

            $business = BussinessInfo::updateOrCreate(
                [
                    'user_id' =>  $user->id
                ],
                [
                    'owner_pan' => $request->pan_no,
                    'owner_pan_image' => $panImage,
                ]
            );

            if (!$business) {
                throw new \Exception('Unable to create user details.');
            }

            foreach ($request->services as $serviceId) {

                // Your service-user pivot table logic goes here.

                // Example:
                //
                // UserService::create([
                //     'user_id' => $user->id,
                //     'service_id' => $serviceId,
                // ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User created successfully.',
                'user_id' => $user->id,
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Reseller user creation failed.', [
                'reseller_id' => Auth::id(),
                'email' => $request->email,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Unable to create user. Please try again.',
            ], 500);
        }
    }

    public function resellerReturn(Request $request)
    {
        dd($request->all());
    }
}
