<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:10',
            'password' => 'required|string|min:8|confirmed',
        ],[
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter email address.',
            'email.unique' => 'Email already exists.',
            'mobile.required' => 'Please enter mobile number.',
            'mobile.digits' => 'Mobile number must be 10 digits.',
            'mobile.unique' => 'Mobile number already exists.',
            'password.required' => 'Please enter password.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain uppercase, lowercase, number and special character.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try{

            $emailOtp = rand(1000, 9999);
            $mobileOtp = rand(1000, 9999);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'status' => 0,
                'email_otp' => $emailOtp,
                'email_otp_expire_at' => Carbon::now()->addMinutes(10),
                'mobile_otp' => $mobileOtp,
                'mobile_otp_expire_at' => Carbon::now()->addMinutes(10),

            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Registration successful. Please verify your email and mobile number.',
                'data' => $user
            ], 201);


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Registration failed. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
