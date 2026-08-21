<?php

namespace App\Http\Controllers\User;

use App\Helper\WebHelper;
use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\BankUpdateRequest;
use App\Models\BussinessInfo;
use App\Models\GlobalService;
use App\Models\ServiceRequest;
use App\Models\WebHookUrl;
use App\Models\LoadMoney;
use Illuminate\Http\Request;
use App\Models\PayinTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    protected $webHelper;

    public function __construct(WebHelper $webHelper)
    {
        $this->webHelper = $webHelper;
    }

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
            Log::error('Service Request Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error : ' . $e->getMessage(),
            ]);
        }
    }

    // public function userprofile()
    // {
    //     $userId = auth()->id();
    //     // dd($userId);
    //     $business = BussinessInfo::where('user_id', $userId)->first();
    //     // dd($business);
    //     $bank = BankDetail::where('user_id', $userId)->first();
    //     $webhook = WebHookUrl::where('user_id', auth()->id())->first();
    //     $services = GlobalService::with('serviceRequest')->where('status', 1)->get();

    //     return view('user.user-profile', compact('business', 'bank', 'webhook', 'services'));
    // }


    public function userprofile()
    {

        $userId = Auth::id();

        $business = BussinessInfo::where('user_id', $userId)->first();

        $bank = BankDetail::where('user_id', $userId)->first();

        $webhook = WebHookUrl::where('user_id', Auth::id())->first();
        $lastBankRequest = BankUpdateRequest::where('user_id', $userId)->latest()->first();

        $services = ServiceRequest::with('service')->where('user_id', Auth::id())->where('status', 'active')->get();

        $kycSummary = [
            'status' => 'pending',
            'rejected_fields' => [],
            'pending_fields' => [],
            'authority_pending' => false,
        ];

        $kycData = $business?->kyc_verification_data ?? [];

        $kycFields = config('kyc.fields');

        $kycSummary = [
            'status' => $business?->kyc_status ?? 'pending',
            'fields' => [],
            'rejected_fields' => [],
            'pending_fields' => [],
        ];

        foreach ($kycFields as $key => $field) {

            $verification = $kycData[$key]['verification'] ?? [
                'status' => 'pending',
                'remark' => null,
            ];

            $admin = $kycData[$key]['admin'] ?? [
                'status' => 'pending',
                'remark' => null,
            ];

            $displayStatus = 'pending';
            $displayRemark = null;

            if ($admin['status'] == 'rejected') {

                $displayStatus = 'admin_rejected';

                $displayRemark = $admin['remark'];

                $kycSummary['rejected_fields'][] = [
                    'field' => $field['label'],
                    'remark' => $admin['remark'],
                ];
            } elseif ($verification['status'] == 'rejected') {

                $displayStatus = 'verification_rejected';

                $displayRemark = $verification['remark'];

                $kycSummary['rejected_fields'][] = [
                    'field' => $field['label'],
                    'remark' => $verification['remark'],
                ];
            } elseif (
                $verification['status'] == 'approved' &&
                $admin['status'] == 'approved'
            ) {

                $displayStatus = 'approved';
            } elseif (
                $verification['status'] == 'approved' &&
                $admin['status'] == 'pending'
            ) {

                $displayStatus = 'verification_approved';
            } else {

                $displayStatus = 'pending';

                $kycSummary['pending_fields'][] = $field['label'];
            }

            $kycSummary['fields'][] = [

                'label' => $field['label'],

                'status' => $displayStatus,

                'remark' => $displayRemark,

            ];
        }

        return view('user.user-profile', compact('business',  'bank',  'webhook', 'services', 'kycSummary', 'lastBankRequest'));
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

    public function loadmoneystore(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:1',
                'mode' => 'required|in:cash,online',
                'utr' => 'required_if:mode,online|nullable|string|max:100|unique:load_money,utr',
                'pay_receipt' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $receipt = null;
            $utr = null;

            if ($request->mode == 'online') {
                $utr = $request->utr;
                if ($request->hasFile('pay_receipt')) {
                    $file = $request->file('pay_receipt');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/load-money'), $fileName);
                    $receipt = 'uploads/load-money/' . $fileName;
                }
            }
            $loadMoney = LoadMoney::create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'utr' => $utr,
                'request_id' => 'LM' . date('YmdHis') . rand(100, 999),
                'mode' => $request->mode,
                'pay_receipt' => $receipt,
                'status' => 'pending',
                'updated_by' => Auth::id(),
                'rejection_remark' => null,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Load Money Request Submitted Successfully.',
                'data' => $loadMoney,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function bankUpdateRequest()
    {
        return view('user.bank-update-request');
    }

    public function raiseRequestBankUpdation(Request $request)
    {

        $request->validate([
            'remark' => 'required|string|min:20|max:300'
        ]);

        $userId = Auth::id();
        $business = BussinessInfo::where('user_id', $userId)->first();

        if (!$business || $business?->kyc_status !== 'approved') {
            return response()->json([
                'status' => false,
                'message' => 'Business Details not found or KYC not approved.',
            ]);
        }

        $data = [
            'user_id' => $userId,
            'request_remark' => $request->remark,
            'updated_by' => $userId,
        ];

        $bankRequest = BankUpdateRequest::create($data);

        if ($bankRequest) {
            return response()->json([
                'status' => true,
                'message' => 'Bank updation request submitted.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
            ]);
        }
    }


    public function updateUserBank(Request $request)
    {
        $userId = Auth::id();
        $bank = BankDetail::where('user_id', $userId)->first();

        if (!$bank) {
            return redirect()->back()->with('error', 'Bank Details not found');
        }

        $bankUpdateRequest = BankUpdateRequest::find($request->bank_request_id);

        if (!$bankUpdateRequest) {
            return redirect()->back()->with('error', 'Bank update request not found');
        }

        if ($bankUpdateRequest->status !== 'approved') {
            return redirect()->back()->with('error', 'Only approved requests are allowed to update the bank.');
        }

        $bankImageExists = $bank?->bank_docs ?? null;

        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'ifsc_code' => ['required', 'string', 'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/'],
            'branch_name' => 'required|string|max:255',
            'bank_docs' => [$bankImageExists ? 'nullable' : 'required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048']
        ], [
            'bank_name.required' => 'Bank name is required.',
            'account_holder_name.required' => 'Account holder name is required.',
            'account_number.required' => 'Account number is required.',
            'ifsc_code.required' => 'IFSC code is required.',
            'ifsc_code.regex' => 'Please enter a valid IFSC code.',
            'branch_name.required' => 'Branch name is required.',
            'bank_docs.required' => 'Bank document is required.',
            'bank_docs.image' => 'Bank document must be an image.',
            'bank_docs.mimes' => 'Bank document must be a JPG, JPEG, PNG, or WEBP image.',
            'bank_docs.max' => 'Bank document may not be larger than 2 MB.'
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        DB::beginTransaction();

        try {
            $update = $this->webHelper->createOrUpdateBankDetail($request, $userId, $bank?->business_info_id);

            if ($update) {
                $bankUpdateRequest->status = 'updated';
                $bankUpdateRequest->save();

                DB::commit();

                return redirect()->back()->with('success', 'Bank Updated Successfully');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Bank not Updated');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }


    public function upiInitiation(){
        $users = User::whereIn('id', PayinTransaction::select('user_id')->distinct())->orderBy('name')->get();
        return view('user.upi-services.upi-initiation', compact('users'));
    }

    public function upiCollection(){
        $users = User::whereIn('id', PayinTransaction::select('user_id')->distinct())->orderBy('name')->get();
        return view('user.upi-services.payment-collection', compact('users'));
    }

    public function allUpitransaction(){
        $users = User::whereIn('id', PayinTransaction::select('user_id')->distinct())->orderBy('name')->get();
        return view('user.upi-services.all-upi-transaction', compact('users'));
    }   
}
