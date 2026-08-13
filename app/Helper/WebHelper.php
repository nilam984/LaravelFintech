<?php

namespace App\Helper;

use App\Models\AssignedScheme;
use App\Models\BankDetail;
use App\Models\BussinessInfo;
use App\Models\GatewayRouting;
use App\Models\GlobalService;
use App\Models\IpWhitelist;
use App\Models\OauthUser;
use App\Models\SchemeRules;
use App\Models\ServiceRequest;
use Exception;
use Illuminate\Http\Request;
use App\Models\PayinTransaction;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WebHelper
{

    public function createUpdateBusiness($request, $userId)
    {

        $existingBusiness = BussinessInfo::where('user_id', $userId)->first();
        $existingBank = BankDetail::where('user_id', $userId)->first();


        $validator = Validator::make($request->all(), [

            // Business Details
            'business_name' => 'required|string|max:255',
            'business_email' => 'required|email|max:255',
            'business_phone' => 'required|digits:10',
            'business_type' => 'required|string|max:100',
            'business_category' => 'required|string|max:100',
            'website_url' => 'required|url|max:255',

            // KYC Details
            'pan' => ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i'],
            'gst' => ['required', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/i'],
            'owner_pan' => ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i'],
            'owner_aadhar' => ['required', 'digits:12'],

            // Address
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pin_code' => 'required|digits:6',
            'full_address' => 'required|string|max:500',

            // Images
            'pan_image' => [
                $existingBusiness && $existingBusiness->pan_image ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],

            'owner_pan_image' => [
                $existingBusiness && $existingBusiness->owner_pan_image ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],

            'owner_aadhar_image_front' => [
                $existingBusiness && $existingBusiness->owner_aadhar_image_front ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],

            'owner_aadhar_image_back' => [
                $existingBusiness && $existingBusiness->owner_aadhar_image_back ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],

            'inside_image' => [
                $existingBusiness && $existingBusiness->inside_image ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
            'outside_image' => [
                $existingBusiness && $existingBusiness->outside_image ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
            'signed_moa_image' => [
                $existingBusiness && $existingBusiness->signed_moa_image ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
            'signed_aoa_image' => [
                $existingBusiness && $existingBusiness->signed_aoa_image ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],


            // Bank Details
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => ['required', 'regex:/^[A-Za-z ]+$/'],
            'account_number' => ['required', 'digits_between:9,18'],
            'ifsc_code' => ['required', 'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/i'],
            'branch_name' => 'required|string|max:255',
            'bank_docs' => [
                $existingBank && $existingBank->bank_docs ? 'nullable' : 'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:4096'
            ],

        ], [
            'business_phone.regex' => 'Enter a valid 10 digit mobile number.',
            'pan.regex' => 'Enter a valid PAN Number.',
            'owner_pan.regex' => 'Enter a valid Owner PAN Number.',
            'gst.regex' => 'Enter a valid GST Number.',
            'owner_aadhar.digits' => 'Aadhaar must be exactly 12 digits.',
            'pin_code.digits' => 'Pincode must be exactly 6 digits.',
            'account_number.digits_between' => 'Account Number must be between 9 and 18 digits.',
            'ifsc_code.regex' => 'Enter a valid IFSC Code.',
            'account_holder_name.regex' => 'Account Holder Name should contain only alphabets.',
        ]);

        if ($validator->fails()) {
            return [
                'code' => 422,
                'response' => [
                    'status' => false,
                    'errors' => $validator->errors(),
                    'message' => $validator->errors()->first(),
                ]
            ];
        }

        DB::beginTransaction();

        try {

            $businessData = [
                'business_name' => $request->business_name,
                'business_email' => $request->business_email,
                'business_phone' => $request->business_phone,
                'pan' => $request->pan,
                'gst' => $request->gst,
                'business_type' => $request->business_type,
                'business_category' => $request->business_category,
                'website_url' => $request->website_url,
                'owner_aadhar' => $request->owner_aadhar,
                'owner_pan' => $request->owner_pan,
                'city' => $request->city,
                'state' => $request->state,
                'pin_code' => $request->pin_code,
                'full_address' => $request->full_address,
            ];

            // Preserve existing images
            $businessData['pan_image'] = $existingBusiness?->pan_image;
            $businessData['owner_pan_image'] = $existingBusiness?->owner_pan_image;
            $businessData['owner_aadhar_image_front'] = $existingBusiness?->owner_aadhar_image_front;
            $businessData['owner_aadhar_image_back'] = $existingBusiness?->owner_aadhar_image_back;
            $businessData['inside_image'] = $existingBusiness?->inside_image;
            $businessData['outside_image'] = $existingBusiness?->outside_image;
            $businessData['signed_moa_image'] = $existingBusiness?->signed_moa_image;
            $businessData['signed_aoa_image'] = $existingBusiness?->signed_aoa_image;

            if ($request->hasFile('pan_image')) {
                $businessData['pan_image'] = $request->file('pan_image')->store('uploads/pan_images', 'public');
            }

            if ($request->hasFile('owner_pan_image')) {
                $businessData['owner_pan_image'] = $request->file('owner_pan_image')->store('uploads/owner_pan_images', 'public');
            }

            if ($request->hasFile('owner_aadhar_image_front')) {
                $businessData['owner_aadhar_image_front'] = $request->file('owner_aadhar_image_front')->store('uploads/owner_aadhar_images', 'public');
            }

            if ($request->hasFile('owner_aadhar_image_back')) {
                $businessData['owner_aadhar_image_back'] = $request->file('owner_aadhar_image_back')->store('uploads/owner_aadhar_images', 'public');
            }

            if ($request->hasFile('inside_image')) {
                $businessData['inside_image'] = $request->file('inside_image')->store('uploads/inside_images', 'public');
            }

            if ($request->hasFile('outside_image')) {
                $businessData['outside_image'] = $request->file('outside_image')->store('uploads/outside_images', 'public');
            }

            if ($request->hasFile('signed_moa_image')) {
                $businessData['signed_moa_image'] = $request->file('signed_moa_image')->store('uploads/signed_moa_images', 'public');
            }

            if ($request->hasFile('signed_aoa_image')) {
                $businessData['signed_aoa_image'] = $request->file('signed_aoa_image')->store('uploads/signed_aoa_images', 'public');
            }

            $business = BussinessInfo::updateOrCreate(
                ['user_id' => $userId],
                $businessData
            );

            DB::commit();

            return [
                'code' => 200,
                'business' => $business,
                'response' => [
                    'status' => true,
                    'message' => 'Business details saved successfully.',
                    'data' => [
                        'business_info' => $business,
                    ],
                ]
            ];
        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'code' => 500,
                'response' => [
                    'status' => false,
                    'message' => $e->getMessage(),
                ]
            ];
        }
    }


    public function createOrUpdateBankDetail($request, $userId, $businessId)
    {
        $oldBank = BankDetail::where('user_id', $userId)->first();

        $bankDoc = $oldBank?->bank_docs;

        if ($request->hasFile('bank_docs')) {
            $bankDoc = $request->file('bank_docs')->store('uploads/bank_docs', 'public');
        }

        return BankDetail::updateOrCreate(
            ['user_id' => $userId],
            [
                'business_info_id' => $businessId,
                'bank_name' => $request->bank_name,
                'account_holder_name' => $request->account_holder_name,
                'account_number' => $request->account_number,
                'ifsc_code' => strtoupper($request->ifsc_code),
                'branch_name' => $request->branch_name,
                'bank_docs' => $bankDoc,
            ]
        );
    }
}
