<?php

namespace App\Http\Controllers\API;

use App\Helper\APIHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        try {

            $authData = $this->apiHelper->validateHeaderRequest($request);

            if ($authData['userId']) {
                $userId =  $authData['userId'];
            }

            $this->apiHelper->checkKycVerified($userId);
            return true;
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}


 // public function PayinApi(Request $request)
    // {
    //     // dd($request->all());
    //     $userId = CommonHelper::getUserIdUsingKeyAndSecret($request->header());
    //     if (!$userId) {
    //         return response()->json([
    //             'message' => 'Invalid Credentials'
    //         ]);
    //     }
    //     $data = DB::table('users')->where('id', $userId)->first();
    //     $findtype = DB::table('global_config')->select('attribute_1')->where('slug', 'default_payin_route')->first();
    //     // $type = $data->payin_switch ?$data->payin_switch:'rabbitpe';
    //     $type = $findtype->attribute_1;
    //     // dd($type);

    //     $status = CommonHelper::isServiceEnabled($userId, 'srv_162607709190', 'isserviceEnabled');
    //     // dd($status);
    //     // if(!$status){
    //     //     return response()->json([
    //     //         'status'=> false,
    //     //         'message'=> 'Downtime started now'
    //     //     ]);
    //     // }

    //     // return response()->json([
    //     //     'status'=> false,
    //     //     'message'=> 'Downtime started now'
    //     // ]);
    //     // if($userId == '554'){
    //     //     $type = 'laraware';
    //     // } 

    //     // return response()->json([
    //     //     'status' => false,
    //     //     'message' => 'Service is under maintenance',
    //     // ]);

    //     $isActive = CommonHelper::isuserActiveServiceAccount($userId);
    //     // dd($isActive);
    //     if (!$isActive) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Your are inactive user, Please contact to the administrator',
    //         ]);
    //     }

    //     $isActiveServices = CommonHelper::isServiceEnabled($userId, 'srv_162607709190', 'isserviceEnabled');
    //     //  dd($isActiveServices);
    //     if (!$isActiveServices) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Service is down Please Contact to the admin',

    //         ]);
    //     }
    //     // switch ($type) {
    //     //     case 'cgpey':
    //     //         try {
    //     //             $rules = [
    //     //                 "name" => ["required", "max:100", "regex:/^[A-Za-zÀ-ÿ]{2,30}(\s+[A-Za-zÀ-ÿ]{2,30})+$/"],
    //     //                 'mobile_number' => 'required|digits:10',
    //     //                 'amount' => 'required|numeric|min:10',
    //     //                 'transaction_id' => 'required|string|max:100|unique:kavach_payins,client_txn_id',
    //     //             ];
    //     //             $messages = ['name.regex' => 'Please Enter a valid full name (Only Indian names, Indian characters, spaces, and dots allowed).'];
    //     //             // if ($userId == '554') {
    //     //             //     $rules['pan'] = 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i';
    //     //             // }

    //     //             $request->validate($rules, $messages);

    //     //             $url = $this->cgpeyPayinUrl;


    //     //             $payload = [
    //     //                 'name' => $request->name,
    //     //                 'mobile_number' => $request->mobile_number,
    //     //                 'transaction_id' => $request->transaction_id,
    //     //                 'amount' => $request->amount,
    //     //             ];
    //     //             // dd($payload);
    //     //             $response = Http::withHeaders([
    //     //                 'x-api-key'    => $this->apikey,
    //     //                 'x-secret-key' => $this->secretkey,
    //     //                 'ip-address'   => $this->ip,
    //     //                 'Content-Type' => 'application/json',
    //     //             ])
    //     //                 ->timeout(40)
    //     //                 ->connectTimeout(30)
    //     //                 ->retry(
    //     //                     3,
    //     //                     2000,
    //     //                     function ($exception, $request) {

    //     //                         return $exception instanceof ConnectionException;
    //     //                     }
    //     //                 )
    //     //                 ->post($url, $payload);



    //     //             $result = $response->json();
    //     //             // dd($result);
    //     //             $alldata = FeeTaxDedectionHelper::FeeTaxDeduction($userId, $request->amount);

    //     //             if ($response->successful()) {

    //     //                 $upiUrl = $result['data']['intentData'];

    //     //                 $orderID = $this->generateOrderId();

    //     //                 parse_str(parse_url($upiUrl, PHP_URL_QUERY), $params);

    //     //                 $pa = $params['pa'] ?? null;
    //     //                 \DB::table('kavach_payins')->insert([
    //     //                     'cust_name' => $request->name,
    //     //                     'cust_mobile' => $request->mobile_number,
    //     //                     'client_txn_id' =>  $request->transaction_id,
    //     //                     'amount' => $request->amount,
    //     //                     'fee' => $alldata['fee'],
    //     //                     'tax' => $alldata['tax'],
    //     //                     'net_amount' => $alldata['netAmount'],

    //     //                     'cust_email' => $data->email,
    //     //                     'user_id' => $data->id,
    //     //                     'txn_id' => $result['data']['txnId'],
    //     //                     'txn_order_id' => $orderID,
    //     //                     'status' => $result['data']['status'],
    //     //                     'type'  => $type,
    //     //                     'root' => $pa,
    //     //                     'created_at' => now(),
    //     //                     'updated_at' => now(),
    //     //                 ]);

    //     //                 return response()->json([
    //     //                     'status' => true,
    //     //                     'message' => 'Payment initiated successfully',
    //     //                     'data' => [
    //     //                         'amount' => $result['data']['amount'],
    //     //                         'message' => $result['data']['statusDesc'],
    //     //                         'orderid' => $result['data']['clientRefId'],
    //     //                         'payment_link' => $result['data']['intentData'],
    //     //                         'txnid' => $orderID
    //     //                     ]
    //     //                 ]);
    //     //             } else {
    //     //                 return response()->json([
    //     //                     'message' => 'API ERROR',
    //     //                     'status' => false,
    //     //                 ]);
    //     //             }
    //     //         } catch (\Exception $e) {
    //     //             Log::error('CGPEY Payin Error', ['error' => $e->getMessage()]);
    //     //             return response()->json([
    //     //                 'status' => false,
    //     //                 'message' => $e->getMessage(),
    //     //             ], 500);
    //     //         }

    //     //         break;

    //     //     case 'spiralpay':

    //     //         try {
    //     //             $request->validate([
    //     //                 'name' => 'required|string|max:100',
    //     //                 'mobile_number' => 'required|digits:10',
    //     //                 'amount' => 'required|numeric|min:100',
    //     //                 'transaction_id' => 'required|string|max:100|unique:kavach_payins,client_txn_id',
    //     //             ]);

    //     //             $token = \App\Helpers\SpiralPayHelper::getToken();
    //     //             // dd($token);
    //     //             $headers = [
    //     //                 'Authorization' => 'Bearer ' . $token,
    //     //                 'Content-Type' => 'application/json',
    //     //             ];

    //     //             $payload = [
    //     //                 "txnId"   => $request->transaction_id,
    //     //                 "amount"  => $request->amount,
    //     //                 "name"    => $request->name,
    //     //                 "email"   => $data->email,
    //     //                 "mobileNumber" => $request->mobile_number,
    //     //             ];

    //     //             $response = Http::withHeaders($headers)->post($this->spiralpayUrl, $payload);

    //     //             $result = $response->json();
    //     //             \Log::info('SpiralPay API Response:', $response->json());

    //     //             $alldata = FeeTaxDedectionHelper::FeeTaxDeduction($userId, $request->amount);
    //     //             // dd($result);

    //     //             if ($response->successful()) {

    //     //                 $upiUrl = $result['qr_intent'];

    //     //                 $orderID = $this->generateOrderId();

    //     //                 parse_str(parse_url($upiUrl, PHP_URL_QUERY), $params);
    //     //                 $pa = $params['pa'] ?? null;

    //     //                 \DB::table('kavach_payins')->insert([
    //     //                     'cust_name' => $request->name,
    //     //                     'cust_mobile' => $request->mobile_number,
    //     //                     'client_txn_id' =>  $request->transaction_id,
    //     //                     'amount' => $request->amount,
    //     //                     'fee' => $alldata['fee'],
    //     //                     'tax' => $alldata['tax'],
    //     //                     'net_amount' => $alldata['netAmount'],
    //     //                     'cust_email' => $data->email,
    //     //                     'user_id' => $data->id,
    //     //                     'txn_id' => $result['transaction_id'],
    //     //                     'txn_order_id' => $orderID,
    //     //                     'status' => 'INITIATED',
    //     //                     'type'  => $type,
    //     //                     'root' => $pa,
    //     //                     'created_at' => now(),
    //     //                     'updated_at' => now(),
    //     //                 ]);

    //     //                 return response()->json([
    //     //                     'status' => true,
    //     //                     'message' => 'Payment initiated successfully',
    //     //                     'data' => [
    //     //                         'status' => 'INITIATED',
    //     //                         'amount' => $request->amount,
    //     //                         'message' => $result['message'],
    //     //                         'orderid' => $orderID,
    //     //                         'payment_link' => $result['qr_intent'],
    //     //                         'txnid' => $result['transaction_id']
    //     //                     ]
    //     //                 ]);
    //     //             } else {
    //     //                 return response()->json([
    //     //                     'status' => false,
    //     //                     'message' => $result,
    //     //                 ]);
    //     //             }

    //     //             return response()->json([
    //     //                 'success' => false,
    //     //                 'data'    => $response->json(),
    //     //             ]);
    //     //         } catch (\Exception $e) {
    //     //             return response()->json([
    //     //                 'success' => false,
    //     //                 'message' => $e->getMessage(),
    //     //             ], 500);
    //     //         }

    //     //         break;

    //     //     case 'risexpay':
    //     //         try {
    //     //             $request->validate([
    //     //                 'name'           => 'required|string|max:100',
    //     //                 'mobile_number'  => 'required|digits:10',
    //     //                 'amount'         => 'required|numeric|min:10',
    //     //                 'transaction_id' => 'required|string|max:100|unique:kavach_payins,client_txn_id',
    //     //             ]);

    //     //             $payload = [
    //     //                 "mid"             => $this->risexpay_mid,
    //     //                 "apikey"          => $this->risexpay_apikey,
    //     //                 "amount"          => $request->amount,
    //     //                 "customer_mobile" => $request->mobile_number,
    //     //                 "redirect_url"    => 'https://app.tejopay.com/',
    //     //                 "remark1"         => $request->name,
    //     //                 "remark2"         => $request->transaction_id,
    //     //             ];

    //     //             $signData = PayinSignatureHelper::generateRisexPaySignature(
    //     //                 $payload,
    //     //                 $this->risexpay_payin_secretKey
    //     //             );

    //     //             // dd($signData);

    //     //             $headers = [
    //     //                 'Content-Type' => 'application/json',
    //     //                 'X-Timestamp' => $signData['timestamp'],
    //     //                 'X-Signature' => $signData['signature'],
    //     //             ];

    //     //             $response = Http::withHeaders($headers)->post($this->risexpay_url, $payload);

    //     //             $result = $response->json();
    //     //             Log::info('RisexPay API Response:', $response->json());

    //     //             $alldata = FeeTaxDedectionHelper::FeeTaxDeduction($userId, $request->amount);

    //     //             if ($response->successful()) {

    //     //                 $upiUrl = $result['data']['payment_url'];

    //     //                 $orderID = $this->generateOrderId();

    //     //                 parse_str(parse_url($upiUrl, PHP_URL_QUERY), $params);
    //     //                 $pa = $params['pa'] ?? null;

    //     //                 DB::table('kavach_payins')->insert([
    //     //                     'cust_name'     => $request->name,
    //     //                     'cust_mobile'   => $request->mobile_number,
    //     //                     'client_txn_id' => $result['data']['order_id'],
    //     //                     'amount'        => $request->amount,
    //     //                     'fee'           => $alldata['fee'],
    //     //                     'tax'           => $alldata['tax'],
    //     //                     'net_amount'    => $alldata['netAmount'],
    //     //                     'cust_email'    => $data->email,
    //     //                     'user_id'       => $data->id,
    //     //                     'txn_id'        => $request->transaction_id,
    //     //                     'txn_order_id'  => $orderID,
    //     //                     'status'        => 'INITIATED',
    //     //                     'type'          => $type,
    //     //                     'root'          => $pa,
    //     //                     'created_at'    => now(),
    //     //                     'updated_at'    => now(),
    //     //                 ]);

    //     //                 return response()->json([
    //     //                     'status'  => true,
    //     //                     'message' => 'Payment initiated successfully',
    //     //                     'data'    => [
    //     //                         'status'       => 'INITIATED',
    //     //                         'amount'       => $request->amount,
    //     //                         'orderid'      => $orderID,
    //     //                         'payment_link' => $result['data']['payment_url'],
    //     //                         'txnid'        => $result['data']['order_id'],
    //     //                         'client_txn_id' => $request->transaction_id,
    //     //                     ],
    //     //                 ]);
    //     //             } else {
    //     //                 return response()->json([
    //     //                     'status'  => false,
    //     //                     'message' => $result,
    //     //                 ]);
    //     //             }
    //     //         } catch (Exception $e) {
    //     //             return response()->json([
    //     //                 'status'  => false,
    //     //                 'message' => $e->getMessage(),
    //     //             ], 400);
    //     //         }
    //     //         break;
    //     //     case 'payupay':
    //     //         try {
    //     //             $request->validate([
    //     //                 'name' => 'required|string|max:100',
    //     //                 'mobile_number' => 'required|regex:/^[6-9]\d{9}$/',
    //     //                 'amount' => 'required|numeric|min:10',
    //     //                 'transaction_id' => 'required|string|max:100|unique:kavach_payins,txn_id',
    //     //             ], [
    //     //                 'name.required' => 'Name is required.',
    //     //                 'name.string' => 'Name must be a valid string.',
    //     //                 'name.max' => 'Name cannot exceed 100 characters.',

    //     //                 'mobile_number.required' => 'Mobile number is required.',
    //     //                 'mobile_number.regex' => 'Please enter a valid 10-digit mobile number.',

    //     //                 'amount.required' => 'Amount is required.',
    //     //                 'amount.numeric' => 'Amount must be a valid amount.',
    //     //                 'amount.min' => 'Minimum amount should be 10.',

    //     //                 'transaction_id.required' => 'Transaction ID is required.',
    //     //                 'transaction_id.string' => 'Transaction ID must be a valid string.',
    //     //                 'transaction_id.max' => 'Transaction ID cannot exceed 100 characters.',
    //     //                 'transaction_id.unique' => 'This Transaction ID already exists.',
    //     //             ]);

    //     //             $payU = new PayuPayHelper();
    //     //             $tokenResponse = $payU->generateToken();

    //     //             if ($tokenResponse['success'] === false) {
    //     //                 return response()->json([
    //     //                     'status' => false,
    //     //                     'message' => 'Failed token Generation',
    //     //                 ]);
    //     //             }

    //     //             $bearerToken = 'Bearer ' . $tokenResponse['data']['access_token'];

    //     //             $payload = [
    //     //                 "subAmount" => $request->amount,
    //     //                 "isPartialPaymentAllowed" => false,
    //     //                 "description" => "Payment Request for : $request->transaction_id",
    //     //                 "source" => "API"
    //     //             ];

    //     //             $headers = [
    //     //                 'merchantId' =>  $payU->merchantId,
    //     //                 'Content-Type' => 'application/json',
    //     //                 'Accept' => 'application/json',
    //     //                 'Authorization' =>  $bearerToken,
    //     //             ];

    //     //             $orderID = $this->generateOrderId();

    //     //             $feeData = FeeTaxDedectionHelper::FeeTaxDeduction($userId, $request->amount);

    //     //             DB::table('kavach_payins')->insert([
    //     //                 'cust_name'     => $request->name,
    //     //                 'cust_mobile'   => $request->mobile_number,
    //     //                 'client_txn_id' => '',
    //     //                 'amount'        => $request->amount,
    //     //                 'fee'           => $feeData['fee'],
    //     //                 'tax'           => $feeData['tax'],
    //     //                 'net_amount'    => $feeData['netAmount'],
    //     //                 'cust_email'    => $data->email,
    //     //                 'user_id'       => $data->id,
    //     //                 'txn_id'        => $request->transaction_id,
    //     //                 'txn_order_id'  => $orderID,
    //     //                 'status'        => 'INITIATED',
    //     //                 'type'          => $type,
    //     //                 'root'          => null,
    //     //                 'created_at'    => now(),
    //     //                 'updated_at'    => now(),
    //     //             ]);

    //     //             $response = Http::withHeaders($headers)->post($payU->payU_PayinUrl, $payload);
    //     //             $result = $response->json();

    //     //             Log::info('PayU API Response:', $response->json());

    //     //             if ($response->successful()) {

    //     //                 $paymentLink  = $result['result']['paymentLink'] ?? null;
    //     //                 $invoiceNo    = $result['result']['invoiceNumber'] ?? null;

    //     //                 if (!$paymentLink || !$invoiceNo) {
    //     //                     return response()->json([
    //     //                         'status'  => false,
    //     //                         'message' => 'Invalid response received from Provider',
    //     //                     ], 500);
    //     //                 }

    //     //                 KavachPayin::where('txn_id', $request->transaction_id)->update(['client_txn_id' => $invoiceNo]);

    //     //                 return response()->json([
    //     //                     'status'  => true,
    //     //                     'message' => 'Payment initiated successfully',
    //     //                     'data'    => [
    //     //                         'status'       => 'INITIATED',
    //     //                         'amount'       => $request->amount,
    //     //                         'orderid'      => $orderID,
    //     //                         'payment_link'  => $paymentLink,
    //     //                         'txnid'         => $invoiceNo,
    //     //                         'client_txn_id' => $request->transaction_id,
    //     //                     ],
    //     //                 ]);
    //     //             } else {
    //     //                 return response()->json([
    //     //                     'status'  => false,
    //     //                     'message' => $result,
    //     //                 ]);
    //     //             }
    //     //         } catch (Exception $e) {
    //     //             return response()->json([
    //     //                 'status'  => false,
    //     //                 'message' => $e->getMessage(),
    //     //             ], 400);
    //     //         }
    //     //         break;
    //     //     case 'nextpay':
    //     //         try {
    //     //             $request->validate([
    //     //                 'name' => 'required|string|max:100',
    //     //                 'mobile_number' => 'required|regex:/^[6-9]\d{9}$/',
    //     //                 'amount' => 'required|numeric|min:10',
    //     //                 'transaction_id' => 'required|string|max:100|unique:kavach_payins,client_txn_id',
    //     //             ], [
    //     //                 'name.required' => 'Name is required.',
    //     //                 'name.string' => 'Name must be a valid string.',
    //     //                 'name.max' => 'Name cannot exceed 100 characters.',

    //     //                 'mobile_number.required' => 'Mobile number is required.',
    //     //                 'mobile_number.regex' => 'Please enter a valid 10-digit mobile number.',

    //     //                 'amount.required' => 'Amount is required.',
    //     //                 'amount.numeric' => 'Amount must be a valid amount.',
    //     //                 'amount.min' => 'Minimum amount should be 10.',

    //     //                 'transaction_id.required' => 'Transaction ID is required.',
    //     //                 'transaction_id.string' => 'Transaction ID must be a valid string.',
    //     //                 'transaction_id.max' => 'Transaction ID cannot exceed 100 characters.',
    //     //                 'transaction_id.unique' => 'This Transaction ID already exists.',
    //     //             ]);

    //     //             $payload = [
    //     //                 "amount" => $request->amount,
    //     //                 "customer_name" => $request->name ?? '',
    //     //                 "customer_mobile" => $request->mobile_number,
    //     //                 "remarks" => "Payment Request for : $request->transaction_id",
    //     //                 "client_order_id" => $request->transaction_id,
    //     //                 "return_url" => "https://app.tejopay.com/",
    //     //             ];



    //     //             // $signData = PayinSignatureHelper::generateRisexPaySignature(
    //     //             //     $payload,
    //     //             //     $this->risexpay_payin_secretKey
    //     //             // );

    //     //             // dd($payload);

    //     //             $headers = [
    //     //                 'Content-Type' => 'application/json',
    //     //                 //     'X-Timestamp' => $signData['timestamp'],
    //     //                 //     'X-Signature' => $signData['signature'],
    //     //             ];

    //     //             $response = Http::withHeaders($headers)->post($this->nextpay_url, $payload);
    //     //             $result = $response->json();
    //     //             Log::info('NextPay API Response:', $response->json());
    //     //             $alldata = FeeTaxDedectionHelper::FeeTaxDeduction($userId, $request->amount);

    //     //             if ($response->successful()) {

    //     //                 $upiUrl = $result['data']['payment_url'];

    //     //                 $orderID = $this->generateOrderId();

    //     //                 parse_str(parse_url($upiUrl, PHP_URL_QUERY), $params);
    //     //                 $pa = $params['pa'] ?? null;

    //     //                 DB::table('kavach_payins')->insert([
    //     //                     'cust_name'     => $request->name,
    //     //                     'cust_mobile'   => $request->mobile_number,
    //     //                     'client_txn_id' => $result['data']['order_id'],
    //     //                     'amount'        => $request->amount,
    //     //                     'fee'           => $alldata['fee'],
    //     //                     'tax'           => $alldata['tax'],
    //     //                     'net_amount'    => $alldata['netAmount'],
    //     //                     'cust_email'    => $data->email,
    //     //                     'user_id'       => $data->id,
    //     //                     'txn_id'        => $request->transaction_id,
    //     //                     'txn_order_id'  => $orderID,
    //     //                     'status'        => 'INITIATED',
    //     //                     'type'          => $type,
    //     //                     'root'          => $pa,
    //     //                     'created_at'    => now(),
    //     //                     'updated_at'    => now(),
    //     //                 ]);

    //     //                 return response()->json([
    //     //                     'status'  => true,
    //     //                     'message' => 'Payment initiated successfully',
    //     //                     'data'    => [
    //     //                         'status'       => 'INITIATED',
    //     //                         'amount'       => $request->amount,
    //     //                         'orderid'      => $orderID,
    //     //                         'payment_link' => $result['data']['payment_url'],
    //     //                         'txnid'        => $result['data']['order_id'],
    //     //                         'client_txn_id' => $request->transaction_id,
    //     //                     ],
    //     //                 ]);
    //     //             } else {
    //     //                 return response()->json([
    //     //                     'status'  => false,
    //     //                     'message' => $result,
    //     //                 ]);
    //     //             }
    //     //         } catch (Exception $e) {
    //     //             return response()->json([
    //     //                 'status'  => false,
    //     //                 'message' => $e->getMessage(),
    //     //             ], 400);
    //     //         }
    //     //         break;

    //     //     case 'rabbitpe':

    //     //         try {


    //     //             $request->validate([
    //     //                 'name' => 'required|string|max:100',
    //     //                 'mobile_number' => 'required|digits:10',
    //     //                 'amount' => 'required|numeric|min:1',
    //     //                 'transaction_id' => 'required|string|max:100|unique:kavach_payins,client_txn_id',
    //     //             ]);


    //     //             $url = $this->rabbitUrl . 'api/payment.php';


    //     //             $payload = [
    //     //                 'action' => 'create_order',
    //     //                 'customer_name' => $request->name,
    //     //                 'customer_phone' => $request->mobile_number,
    //     //                 'order_id' => $request->transaction_id,
    //     //                 'amount' => $request->amount,
    //     //             ];

    //     //             $string_to_sign = $this->rabbitApiKey . '|' . json_encode($payload) . '|' . time();
    //     //             $signature = hash_hmac('sha256', $string_to_sign, $this->rabbitApiSecret);

    //     //             $response = Http::withHeaders([
    //     //                 'X-API-Token'    => $this->rabbitApiKey,
    //     //                 'X-Signature' =>  $signature,
    //     //                 'Content-Type' => 'application/json',
    //     //             ])->post($url, $payload);


    //     //             $result = $response->json();

    //     //             Log::info('Rabbit Payin Response', [
    //     //                 'request' => $payload,
    //     //                 'response' => $result,
    //     //             ]);


    //     //             if ($response->failed() || !isset($result['success']) || $result['success'] != true) {
    //     //                 return response()->json([
    //     //                     'status' => false,
    //     //                     'message' => $result['message'] ?? 'Rabbit API Error',
    //     //                     'data' => $result
    //     //                 ], 400);
    //     //             }


    //     //             \DB::beginTransaction();


    //     //             DB::table('kavach_payins')->insert([
    //     //                 'cust_name' => $request->name,
    //     //                 'cust_mobile' => $request->mobile_number,
    //     //                 'client_txn_id' =>  $request->transaction_id,
    //     //                 'amount' => $request->amount,
    //     //                 'cust_email' => $data->email,
    //     //                 'user_id' => $data->id,
    //     //                 'txn_id' => $result['transaction_id'],
    //     //                 'status' => 'INITIATED',
    //     //                 'type'  => $type,
    //     //                 'created_at' => now(),
    //     //                 'updated_at' => now(),
    //     //             ]);

    //     //             \DB::commit();


    //     //             return response()->json([
    //     //                 'status' => true,
    //     //                 'message' => $result['message'] ?? 'Payment initiated successfully',
    //     //                 'data' => [
    //     //                     'amount' => $result['amount'],
    //     //                     'status' => 'INITIATED',
    //     //                     'orderid' => $result['transaction_id'],
    //     //                     'payment_link' => $result['checkout_url'],
    //     //                     'txnid' => $result['razorpay_order_id'],
    //     //                 ]
    //     //             ]);
    //     //         } catch (\Exception $e) {
    //     //             \DB::rollBack();
    //     //             Log::error('Rabbit Payin Error', ['error' => $e->getMessage()]);
    //     //             return response()->json([
    //     //                 'status' => false,
    //     //                 'message' => $e->getMessage(),
    //     //             ], 500);
    //     //         }
    //     //         break;


    //     //     case 'gammingpe':

    //     //         try {


    //     //             $request->validate([
    //     //                 'name' => 'required|string|max:100',
    //     //                 'mobile_number' => 'required|digits:10',
    //     //                 'amount' => 'required|numeric|min:1',
    //     //                 'transaction_id' => 'required|string|max:100|unique:kavach_payins,client_txn_id',
    //     //             ]);
    //     //             // dd($request->transaction_id);

    //     //             $url = $this->gamingPayApiUrl;


    //     //             $payload = [
    //     //                 'externalTransactionId' => $request->transaction_id,
    //     //                 'Amount' => $request->amount,
    //     //                 'returnUrl' => 'https://www.google.com/',

    //     //             ];

    //     //             // dd($payload);

    //     //             $response = Http::withHeaders([

    //     //                 'Content-Type' => 'application/json',
    //     //                 'secretkey' => $this->gammingtApiSecret,
    //     //                 'saltkey' => $this->gammingApiSaltKey,
    //     //             ])->post($url, $payload);


    //     //             $result = $response->json();
    //     //             // dd($result);
    //     //             Log::info('Gamming Payin Response', [
    //     //                 'request' => $payload,
    //     //                 'response' => $result,
    //     //             ]);


    //     //             $success = (
    //     //                 isset($result['responseCode']) &&
    //     //                 $result['responseCode'] === 'SUCCESS' &&
    //     //                 isset($result['responseStatus']) &&
    //     //                 strtolower($result['responseStatus']) === 'success'
    //     //             );

    //     //             $failed = (
    //     //                 isset($result['statuscode']) &&
    //     //                 strtoupper($result['statuscode']) === 'FAILED'
    //     //             );

    //     //             if ($response->failed() || !$success || $failed) {
    //     //                 return response()->json([
    //     //                     'status' => false,
    //     //                     'message' => $result['message'] ?? 'Gamming Pay API Error',
    //     //                     'data' => $result
    //     //                 ], 400);
    //     //             }

    //     //             try {

    //     //                 DB::beginTransaction();


    //     //                 DB::table('kavach_payins')->insert([
    //     //                     'cust_name' => $request->name,
    //     //                     'cust_mobile' => $request->mobile_number,
    //     //                     'client_txn_id' => $request->transaction_id,
    //     //                     'amount' => $request->amount,
    //     //                     'cust_email' => $data->email,
    //     //                     'user_id' => $data->id,
    //     //                     'txn_id' => $result['data']['apiTxnId'],
    //     //                     'status' => 'INITIATED',
    //     //                     'type' => $type,
    //     //                     'created_at' => now(),
    //     //                     'updated_at' => now(),
    //     //                 ]);

    //     //                 DB::commit();

    //     //                 return response()->json([
    //     //                     'status' => true,
    //     //                     'message' => $result['message'] ?? 'Payment initiated successfully',
    //     //                     'data' => [
    //     //                         'amount' => $request->amount,
    //     //                         'status' => 'INITIATED',
    //     //                         'orderid' => $result['data']['extTransactionId'],
    //     //                         'payment_link' => $result['data']['qrString'],
    //     //                         'txnid' => $result['data']['apiTxnId'],
    //     //                         'api_url' => $result['data']['url']
    //     //                     ]
    //     //                 ]);
    //     //             } catch (\Exception $e) {
    //     //                 DB::rollBack();
    //     //                 Log::error('gamming pe Payin Error', ['error' => $e->getMessage()]);

    //     //                 return response()->json([
    //     //                     'status' => false,
    //     //                     'message' => $e->getMessage(),
    //     //                 ], 500);
    //     //             }
    //     //         } catch (\Exception $e) {

    //     //             return response()->json([
    //     //                 'status' => false,
    //     //                 'message' => $e->getMessage(),
    //     //             ], 500);
    //     //         }

    //     //         break;



    //     //     case 'laraware':
    //     //         try {
    //     //             $rules = [
    //     //                 'name' => 'required|string|max:100',
    //     //                 'mobile_number' => 'required|digits:10',
    //     //                 'amount' => 'required|numeric|min:100',
    //     //                 'transaction_id' => 'required|string'
    //     //             ];

    //     //             // if ($userId == '554') {
    //     //             //     $rules['pan'] = 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i';
    //     //             // }

    //     //             $request->validate($rules);



    //     //             $order = DB::table('kavach_payins')
    //     //                 ->select('client_txn_id')
    //     //                 ->where('client_txn_id', $request->transaction_id)
    //     //                 ->lockForUpdate()
    //     //                 ->first();

    //     //             if (!empty($order)) {


    //     //                 return response()->json([
    //     //                     'status' => false,
    //     //                     'message' => 'Payment already initiated using this transaction_id' . '  ' . $request->transaction_id,

    //     //                 ]);
    //     //             }


    //     //             $url = $this->larawareUrl;


    //     //             $payload = [
    //     //                 'customer_name' => $request->name,
    //     //                 'customer_mobile' => $request->mobile_number,
    //     //                 'reference_id' => $request->transaction_id,
    //     //                 'amount' => $request->amount,
    //     //                 'purpose' => 'Product Purchase',
    //     //                 'expiry_minutes' => 30,

    //     //             ];
    //     //             $method = 'POST';

    //     //             $timestamp = time();
    //     //             $rawBody = json_encode($payload, JSON_UNESCAPED_SLASHES);



    //     //             $stringToSign = $method . '|' . '/api/v1/collection/generate-dynamic-qr' . '|' . $timestamp . '|' . $rawBody;
    //     //             $secretKey = $this->larawareApiSecret;

    //     //             $signature = hash_hmac('sha256', $stringToSign, $secretKey);
    //     //             $response = Http::withHeaders([
    //     //                 'Content-Type' => 'application/json',
    //     //                 'X-Client-ID'    => $this->larawareApiKeys,
    //     //                 'X-Signature' =>  $signature,
    //     //                 'X-Timestamp'   => $timestamp,
    //     //                 'X-Request-ID'   => $request->transaction_id,


    //     //             ])->timeout(30)
    //     //                 ->connectTimeout(10)
    //     //                 ->post($url, $payload);


    //     //             $result = $response->json();

    //     //             $alldata = FeeTaxDedectionHelper::FeeTaxDeduction($userId, $request->amount);
    //     //             // dd($alldata);
    //     //             if ($response->successful()) {
    //     //                 $api = $result['data'];


    //     //                 $upiUrl = $api['upi_intent'];

    //     //                 $orderID = $this->generateOrderId();



    //     //                 \DB::table('kavach_payins')->insert([
    //     //                     'cust_name' => $request->name,
    //     //                     'cust_mobile' => $request->mobile_number,
    //     //                     'client_txn_id' =>  $request->transaction_id,
    //     //                     'amount' => $request->amount,
    //     //                     'fee' => $alldata['fee'],
    //     //                     'tax' => $alldata['tax'],
    //     //                     'net_amount' => $alldata['netAmount'],
    //     //                     'cust_email' => $data->email,
    //     //                     'user_id' => $data->id,
    //     //                     'txn_id' => $api['order_id'],
    //     //                     'status' => $api['status'],
    //     //                     'type'  => $type,
    //     //                     'txn_order_id'  => $orderID,

    //     //                     'created_at' => now(),
    //     //                     'updated_at' => now(),
    //     //                 ]);

    //     //                 return response()->json([
    //     //                     'status' => true,
    //     //                     'message' => 'Payment initiated successfully',
    //     //                     'data' => [
    //     //                         'amount' => $api['gross_amount'],
    //     //                         'message' => 'qr genrated successfully',
    //     //                         'orderid' => $orderID,
    //     //                         'payment_link' => $upiUrl,
    //     //                         'txnid' => $api['reference_id']
    //     //                     ]
    //     //                 ]);
    //     //             } else {
    //     //                 return response()->json([
    //     //                     'message' => 'API ERROR',
    //     //                     'status' => false,
    //     //                 ]);
    //     //             }
    //     //         } catch (\Exception $e) {
    //     //             Log::error('laraware Payin Error', ['error' => $e->getMessage()]);
    //     //             return response()->json([
    //     //                 'status' => false,
    //     //                 'message' => $e->getMessage(),
    //     //             ], 500);
    //     //         }

    //     //         break;


    //     //     default:
    //     //         return response()->json([
    //     //             'status' => false,
    //     //             'message' => 'Invalid payin type.',
    //     //         ], 400);
    //     // }


    // }
