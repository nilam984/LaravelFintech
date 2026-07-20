<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\BussinessInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function businessinfo(Request $request)
    {
        $validator = Validator::make($request->all(), [

            // Business Details
            'business_name' => 'required|string|max:255',
            'business_email' => 'required|email|max:255',
            'business_phone' => 'required|digits:10',
            'business_type' => 'nullable|string|max:100',
            'business_category' => 'nullable|string|max:100',
            'website_url' => 'nullable|url|max:255',

            // KYC Details
            'pan' => ['nullable','regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i', ],
            'gst' => ['nullable','regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/i',],
            'owner_pan' => ['nullable','regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i',],
            'owner_aadhar' => ['nullable','digits:12',],

            // Address
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pin_code' => 'nullable|digits:6',
            'full_address' => 'nullable|string|max:500',

            // Images
            'pan_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'owner_pan_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'owner_aadhar_image_front' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'owner_aadhar_image_back' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // Bank Details
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => ['required','regex:/^[A-Za-z ]+$/',],
            'account_number' => ['required','digits_between:9,18',],
            'ifsc_code' => ['required','regex:/^[A-Z]{4}0[A-Z0-9]{6}$/i',],
            'branch_name' => 'nullable|string|max:255',
            'bank_docs' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',

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
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $userId = Auth::id();

            $business = BussinessInfo::firstOrNew([
                'user_id' => $userId,
            ]);

            $business->business_name = $request->business_name;
            $business->business_email = $request->business_email;
            $business->business_phone = $request->business_phone;
            $business->pan = $request->pan;
            $business->gst = $request->gst;
            $business->business_type = $request->business_type;
            $business->business_category = $request->business_category;
            $business->website_url = $request->website_url;
            $business->owner_aadhar = $request->owner_aadhar;
            $business->owner_pan = $request->owner_pan;
            $business->city = $request->city;
            $business->state = $request->state;
            $business->pin_code = $request->pin_code;
            $business->full_address = $request->full_address;

            if ($request->hasFile('pan_image')) {
                $business->pan_image = $request->file('pan_image')->store('uploads/pan_images', 'public');
            }

            if ($request->hasFile('owner_pan_image')) {
                $business->owner_pan_image = $request->file('owner_pan_image')->store('uploads/owner_pan_images', 'public');
            }

            if ($request->hasFile('owner_aadhar_image_front')) {
                $business->owner_aadhar_image_front = $request->file('owner_aadhar_image_front')->store('uploads/owner_aadhar_images', 'public');
            }

            if ($request->hasFile('owner_aadhar_image_back')) {
                $business->owner_aadhar_image_back = $request->file('owner_aadhar_image_back')->store('uploads/owner_aadhar_images', 'public');
            }

            $business->save();

            $oldBank = BankDetail::where('user_id', $userId)->first();

            $bankDoc = $oldBank?->bank_docs;

            if ($request->hasFile('bank_docs')) {
                $bankDoc = $request->file('bank_docs')->store('uploads/bank_docs', 'public');
            }

            $bank = BankDetail::updateOrCreate(
                ['user_id' => $userId],
                [
                    'business_info_id' => $business->id,
                    'bank_name' => $request->bank_name,
                    'account_holder_name' => $request->account_holder_name,
                    'account_number' => $request->account_number,
                    'ifsc_code' => strtoupper($request->ifsc_code),
                    'branch_name' => $request->branch_name,
                    'bank_docs' => $bankDoc,
                ]
            );

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Business and bank details saved successfully.',
                'data' => [
                    'business_info' => $business,
                    'bank_detail' => $bank,
                ],
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
