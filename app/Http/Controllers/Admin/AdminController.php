<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeResellerMail;
use App\Models\BankDetail;
use App\Models\BankUpdateRequest;
use App\Models\BussinessInfo;
use App\Models\CostSetup;
use App\Models\GatewayRouting;
use App\Models\GlobalService;
use App\Models\LoadMoney;
use App\Models\Menu;
use App\Models\OauthUser;
use App\Models\PaymentGateway;
use App\Models\ResellerDetail;
use App\Models\ServiceProduct;
use App\Models\User;
use App\Models\WebHookUrl;
use App\Services\MailService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function allusers()
    {
        $services = GlobalService::with('costSetup')->whereHas('costSetup')->where('status', 1)->latest()->get();
        return view('admin.all-users', compact('services'));
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
        } catch (Exception $e) {
            Log::error('Global Service Store Error: ' . $e->getMessage());

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
                    'service_id' => $request->service_id,
                    'product_name' => trim($product['product_name']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            ServiceProduct::insert($insertData);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Products saved successfully.',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
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
            if (! in_array($request->gateway_type, ['payin', 'payout'])) {
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
                        'updated_by' => $updatedBy,
                    ]
                );
            });

            if ($created) {
                return redirect()->back()->with('success', 'Gateway Switched Successfully');
            } else {
                return redirect()->back()->with('error', 'Some Error Occured');
            }
        } catch (Exception $e) {
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
        $userId = Auth::id();
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

        if ($validated['status'] === 'rejected' && blank($validated['remark'])) {
            return response()->json([
                'success' => false,
                'message' => 'Remark is required for rejection.',
            ], 422);
        }

        DB::beginTransaction();

        try {

            $loadRequest = LoadMoney::lockForUpdate()->findOrFail($validated['id']);

            if ($loadRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'This request has already been processed.',
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
                    'message' => 'Request rejected successfully.',
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
                'message' => 'Request approved successfully.',
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error : ' . $e->getMessage(),
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

    public function verifyKyc(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'field' => 'required|string',
            'status' => 'required|in:approved,rejected',
            'remark' => 'nullable|string',
        ]);

        $business = BussinessInfo::where('user_id', $request->user_id)->firstOrFail();
        $kycData = $business->kyc_verification_data ?? [];

        if (Auth::user()->role == 'verification') {
            $level = 'verification';
        } elseif (Auth::user()->role == 'admin') {
            $level = 'admin';
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $kycData[$request->field][$level] = [
            'status' => $request->status,
            'remark' => $request->remark,
            'by' => Auth::id(),
            'at' => now(),

        ];

        if ($level == 'admin' && $request->status == 'rejected') {

            $kycData[$request->field]['verification']['status'] = 'rejected';

            $kycData[$request->field]['verification']['remark'] =
                'Rejected by Admin: ' . $request->remark;
        }

        $business->kyc_verification_data = $kycData;

        // if ($level == 'verification') {
        //     $statuses = collect($kycData)->pluck('verification.status');
        //     if ($statuses->contains('rejected')) {
        //         $business->kyc_status = 'verification_rejected';
        //     } elseif ($statuses->every(fn($status) => $status == 'approved')) {
        //         $business->kyc_status = 'verification_approved';
        //     } else {
        //         $business->kyc_status = 'pending';
        //     }
        //     $business->verification_by = Auth::id();
        //     $business->verification_at = now();
        // }

        // if ($level == 'admin') {
        //     $statuses = collect($kycData)->pluck('admin.status');
        //     if ($statuses->contains('rejected')) {
        //         $business->kyc_status = 'admin_rejected';
        //     } elseif ($statuses->every(fn($status) => $status == 'approved')) {
        //         $business->kyc_status = 'approved';
        //     }
        //     $business->admin_verified_by = Auth::id();
        //     $business->admin_verified_at = now();
        // }

        if ($level == 'verification') {

            $allFields = config('kyc.fields');

            $hasRejected = false;
            $allApproved = true;

            foreach ($allFields as $field => $config) {

                $status = $kycData[$field]['verification']['status'] ?? 'pending';

                if ($status === 'rejected') {
                    $hasRejected = true;
                }

                if ($status !== 'approved') {
                    $allApproved = false;
                }
            }

            if ($hasRejected) {
                $business->kyc_status = 'verification_rejected';
            } elseif ($allApproved) {
                $business->kyc_status = 'verification_approved';
            } else {
                $business->kyc_status = 'pending';
            }

            $business->verification_by = Auth::id();
            $business->verification_at = now();
        }

        if ($level == 'admin') {

            $allFields = config('kyc.fields');

            $hasRejected = false;
            $allApproved = true;

            foreach ($allFields as $field => $config) {

                $status = $kycData[$field]['admin']['status'] ?? 'pending';

                if ($status === 'rejected') {
                    $hasRejected = true;
                }

                if ($status !== 'approved') {
                    $allApproved = false;
                }
            }

            if ($hasRejected) {
                $business->kyc_status = 'admin_rejected';
            } elseif ($allApproved) {
                $business->kyc_status = 'approved';
            } else {
                // Verification is complete, but Admin is still reviewing
                $business->kyc_status = 'verification_approved';
            }

            $business->admin_verified_by = Auth::id();
            $business->admin_verified_at = now();
        }

        $business->save();

        return response()->json([
            'success' => true,
            'message' => 'KYC updated successfully.',

        ]);
    }

    public function verificationOfficer()
    {
        return view('admin.user-verification');
    }

    public function costSetup()
    {
        $services = GlobalService::where('status', 1)->get();
        return view('admin.cost-setup', compact('services'));
    }

    public function storeCostSetup(Request $request)
    {
        try {
            $request->validate([
                'service_id' => 'required|exists:global_services,id',
                'cost' => 'required|numeric|min:0',
            ]);

            $exists = CostSetup::where('service_id', $request->service_id)->exists();
            if ($exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cost already exists for this service.',
                ], 422);
            }

            $costSetup = CostSetup::create([
                'service_id' => $request->service_id,
                'cost' => $request->cost,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Cost setup saved successfully.',
                'data' => $costSetup,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateCostSetup(Request $request, $id)
    {
        try {

            $request->validate([
                'service_id' => 'required|exists:global_services,id',
                'cost' => 'required|numeric|min:0',
            ]);

            $cost = CostSetup::findOrFail($id);
            $cost->update([
                'service_id' => $request->service_id,
                'cost' => $request->cost,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Cost updated successfully.',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function bankUpdateRequest()
    {
        $users = User::where('role', 'user')->orderBy('id', 'desc')->get();
        return view('admin.bank-update-request', compact('users'));
    }


    public function bankRequestUpdate(Request $request)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'id' => [
                'required',
                Rule::exists('bank_update_requests', 'id')->where(function ($query) {
                    return $query->where('status', 'pending');
                }),
            ],
            'remark' => 'required_if:status,rejected|nullable|string'
        ]);

        $bankRequest = BankUpdateRequest::where('id', $request->id)->first();

        if (!$bankRequest) {
            return response()->json([
                'status' => false,
                'message' => 'Bank updation request not found.',
            ]);
        }

        $data = [
            'status' => $request->status,
            'reject_remark' => $request->remark,
            'updated_by' => Auth::id(),
        ];

        if ($bankRequest->update($data)) {
            return response()->json([
                'status' => true,
                'message' => 'Bank Updation Request Updated Successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
            ]);
        }
    }

    public function menus()
    {
        $menus = Menu::query()
            ->whereNull('parent_id')
            ->with([
                'children' => function ($query) {
                    $query->orderBy('sort_order');
                }
            ])
            ->orderBy('sort_order')
            ->get();

        $roles = [
            'admin' => 'Admin',
            'user' => 'User',
            'reseller' => 'Reseller',
            'verification' => 'Verification',
        ];

        return view('admin.menu', compact('menus',  'roles'));
    }


    public function updateMenu(Request $request)
    {
        $request->validate([
            'menus' => ['required', 'array'],
            'menus.*' => ['nullable', 'array'],
            'menus.*.visible_for' => ['nullable', 'array'],
            'menus.*.visible_for.*' => [
                'in:default,admin,user,reseller,verification'
            ],
        ]);


        DB::transaction(function () use ($request) {

            foreach ($request->input('menus', []) as $menuId => $menuData) {

                $visibleFor = $menuData['visible_for'] ?? [];

                if (in_array('default', $visibleFor)) {
                    $visibleFor = ['default'];
                } else {
                    $visibleFor = array_unique($visibleFor);
                }

                Menu::whereKey($menuId)->update([
                    'visible_for' => implode(',', $visibleFor),
                ]);
            }
        });


        return redirect()
            ->back()
            ->with('success', 'Menu permissions updated successfully.');
    }

    public function resellerUsers()
    {
        return view('admin.reseller-user');
    }

    public function onboardReseller(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->where(function ($query) {
                return $query->whereNotNull('email_verified_at');
            })],
            'mobile' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'aadhar_no' => ['required', 'digits:12'],
            'pan_no' => ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'aadhar_front_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'aadhar_back_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'pan_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'name.required' => 'Please enter the reseller name.',
            'name.string' => 'Name must be a valid text.',
            'name.max' => 'Name cannot exceed 100 characters.',
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email cannot exceed 150 characters.',
            'mobile.required' => 'Please enter the mobile number.',
            'mobile.regex' => 'Mobile number must be a valid 10-digit Indian mobile number.',
            'aadhar_no.required' => 'Please enter the Aadhaar number.',
            'aadhar_no.digits' => 'Aadhaar number must be exactly 12 digits.',
            'pan_no.required' => 'Please enter the PAN number.',
            'pan_no.regex' => 'Please enter a valid PAN number. Example: ABCDE1234F.',
            'aadhar_front_image.required' => 'Please upload the Aadhaar front image.',
            'aadhar_front_image.image' => 'Aadhaar front must be a valid image.',
            'aadhar_front_image.mimes' => 'Aadhaar front image must be JPG, JPEG, or PNG.',
            'aadhar_front_image.max' => 'Aadhaar front image cannot be larger than 2 MB.',
            'aadhar_back_image.required' => 'Please upload the Aadhaar back image.',
            'aadhar_back_image.image' => 'Aadhaar back must be a valid image.',
            'aadhar_back_image.mimes' => 'Aadhaar back image must be JPG, JPEG, or PNG.',
            'aadhar_back_image.max' => 'Aadhaar back image cannot be larger than 2 MB.',
            'pan_image.required' => 'Please upload the PAN image.',
            'pan_image.image' => 'PAN image must be a valid image.',
            'pan_image.mimes' => 'PAN image must be JPG, JPEG, or PNG.',
            'pan_image.max' => 'PAN image cannot be larger than 2 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $password = substr($request->mobile, 2, 6);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($password),
                'role' => 'reseller',
                'registered_by' => 'admin',
                'status' => true,
                'email_verified_at' => now(),
            ]);

            if (!$user) {
                throw new \Exception('Unable to create reseller user.');
            }

            $resellerData = [
                'reseller_id' => $user->id,
                'aadhar_no' => $request->aadhar_no,
                'pan_no' => $request->pan_no,
                'updated_by' => Auth::id(),
            ];

            // Aadhaar Front
            if ($request->hasFile('aadhar_front_image')) {
                $resellerData['aadhar_front_image'] =
                    $request->file('aadhar_front_image')
                    ->store('uploads/reseller_images', 'public');
            }

            // Aadhaar Back
            if ($request->hasFile('aadhar_back_image')) {
                $resellerData['aadhar_back_image'] =
                    $request->file('aadhar_back_image')
                    ->store('uploads/reseller_images', 'public');
            }

            // PAN
            if ($request->hasFile('pan_image')) {
                $resellerData['pan_image'] =
                    $request->file('pan_image')
                    ->store('uploads/reseller_images', 'public');
            }

            $reseller = ResellerDetail::create($resellerData);

            if (!$reseller) {
                throw new \Exception('Unable to create reseller details.');
            }

            DB::commit();

            try {
                app(MailService::class)->send(
                    to: $user->email,
                    mailable: new WelcomeResellerMail(
                        user: $user,
                        password: $password
                    ),
                    name: $user->name
                );
            } catch (\Throwable $mailException) {
                Log::error('Reseller welcome email failed.', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $mailException->getMessage(),
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Reseller Onboarded Successfully'
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Reseller onboarding failed.', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Unable to onboard reseller : ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateReseller(Request $request)
    {

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Reseller user not found.'
            ], 422);
        }

        $reseller = ResellerDetail::where('reseller_id', $user->id)->first();

        if (!$reseller) {
            return response()->json([
                'status' => false,
                'message' => 'Reseller details not found.'
            ], 422);
        }

        $aadharFrontRule = $reseller->aadhar_front_image  ? ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048']  : ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'];
        $aadharBackRule = $reseller->aadhar_back_image  ? ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048']  : ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'];
        $panImageRule = $reseller->pan_image   ? ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048']   : ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'];

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users')
                    ->ignore($request->user_id)
                    ->where(function ($query) {
                        return $query->whereNotNull('email_verified_at');
                    })
            ],

            'mobile' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'aadhar_no' => ['required', 'digits:12'],
            'pan_no' => ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'aadhar_front_image' => $aadharFrontRule,
            'aadhar_back_image' => $aadharBackRule,
            'pan_image' => $panImageRule,
        ], [

            'user_id.required' => 'Invalid reseller user.',
            'user_id.exists' => 'Reseller user not found.',

            'name.required' => 'Please enter the reseller name.',
            'name.string' => 'Name must be a valid text.',
            'name.max' => 'Name cannot exceed 100 characters.',

            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email cannot exceed 150 characters.',
            'email.unique' => 'This email is already registered.',

            'mobile.required' => 'Please enter the mobile number.',
            'mobile.regex' => 'Mobile number must be a valid 10-digit Indian mobile number.',

            'aadhar_no.required' => 'Please enter the Aadhaar number.',
            'aadhar_no.digits' => 'Aadhaar number must be exactly 12 digits.',

            'pan_no.required' => 'Please enter the PAN number.',
            'pan_no.regex' => 'Please enter a valid PAN number. Example: ABCDE1234F.',

            'aadhar_front_image.required' => 'Please upload the Aadhaar front image.',
            'aadhar_front_image.image' => 'Aadhaar front must be a valid image.',
            'aadhar_front_image.mimes' => 'Aadhaar front image must be JPG, JPEG, or PNG.',
            'aadhar_front_image.max' => 'Aadhaar front image cannot be larger than 2 MB.',

            'aadhar_back_image.required' => 'Please upload the Aadhaar back image.',
            'aadhar_back_image.image' => 'Aadhaar back must be a valid image.',
            'aadhar_back_image.mimes' => 'Aadhaar back image must be JPG, JPEG, or PNG.',
            'aadhar_back_image.max' => 'Aadhaar back image cannot be larger than 2 MB.',

            'pan_image.required' => 'Please upload the PAN image.',
            'pan_image.image' => 'PAN image must be a valid image.',
            'pan_image.mimes' => 'PAN image must be JPG, JPEG, or PNG.',
            'pan_image.max' => 'PAN image cannot be larger than 2 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
            ]);

            $reseller->aadhar_no = $request->aadhar_no;
            $reseller->pan_no = $request->pan_no;
            $reseller->updated_by = Auth::id();

            if ($request->hasFile('aadhar_front_image')) {

                if ($reseller->aadhar_front_image && Storage::disk('public')->exists($reseller->aadhar_front_image)) {
                    Storage::disk('public')->delete(
                        $reseller->aadhar_front_image
                    );
                }

                $reseller->aadhar_front_image = $request->file('aadhar_front_image')->store('uploads/reseller_images', 'public');
            }

            if ($request->hasFile('aadhar_back_image')) {

                if ($reseller->aadhar_back_image &&  Storage::disk('public')->exists($reseller->aadhar_back_image)) {
                    Storage::disk('public')->delete(
                        $reseller->aadhar_back_image
                    );
                }

                $reseller->aadhar_back_image =  $request->file('aadhar_back_image')->store('uploads/reseller_images', 'public');
            }

            if ($request->hasFile('pan_image')) {

                if ($reseller->pan_image && Storage::disk('public')->exists($reseller->pan_image)) {
                    Storage::disk('public')->delete(
                        $reseller->pan_image
                    );
                }

                $reseller->pan_image =  $request->file('pan_image')->store('uploads/reseller_images', 'public');
            }

            $reseller->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Reseller updated successfully.'
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Reseller update failed.', [
                'user_id' => $request->user_id,
                'email' => $request->email,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Unable to update reseller : ' . $e->getMessage()
            ], 500);
        }
    }

    public function getReseller($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Reseller user not found.'
            ], 404);
        }

        $reseller = ResellerDetail::where('reseller_id', $user->id)->first();

        if (!$reseller) {
            return response()->json([
                'status' => false,
                'message' => 'Reseller details not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,

            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,

                'aadhar_no' => $reseller->aadhar_no,
                'pan_no' => $reseller->pan_no,

                'aadhar_front_image' => $reseller->aadhar_front_image
                    ? asset('storage/' . $reseller->aadhar_front_image)
                    : null,

                'aadhar_back_image' => $reseller->aadhar_back_image
                    ? asset('storage/' . $reseller->aadhar_back_image)
                    : null,

                'pan_image' => $reseller->pan_image
                    ? asset('storage/' . $reseller->pan_image)
                    : null,
            ]
        ]);
    }
}
