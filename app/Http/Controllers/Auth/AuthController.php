<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function loginPage()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.dashboard');
        }
        return view('Auth.login');
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($query) {
                    return $query->whereNotNull('email_verified_at');
                }),
            ],
            'mobile' => 'required|string|digits:10',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter email address.',
            'email.unique' => 'Email already exists.',
            'mobile.required' => 'Please enter mobile number.',
            'mobile.digits' => 'Mobile number must be 10 digits.',
            'mobile.unique' => 'Mobile number already exists.',
            'password.required' => 'Please enter password.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {

            $emailOtp = rand(1000, 9999);

            $user = User::updateOrCreate([
                'email' => $request->email,
            ], [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'email_otp' => $emailOtp,
                'email_otp_expire_at' => Carbon::now()->addMinutes(10),
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Registration successful. Please verify your email.',
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

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'No account was found with this email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters long.',
        ]);

        $remember = $request->remember == "on";
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $remember)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ], 401);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (!$this->isActive($user)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'status' => false,
                'message' => 'You are inactive. Please contact the administrator.'
            ], 403);
        }

        $redirect = route('user.dashboard');

        if ($user->role === 'admin') {
            $redirect = route('admin.dashboard');
        }

        return response()->json([
            'status' => true,
            'message' => 'Login Successful',
            'redirect' => $redirect,
        ]);
    }

    public function verifyOtp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        if ($user->email_otp !== $request->otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP.'
            ], 400);
        }

        if (Carbon::now()->gt($user->email_otp_expire_at)) {
            return response()->json([
                'status' => false,
                'message' => 'OTP has expired.'
            ], 400);
        }

        $userUpdate = [
            'email_otp' => null,
            'email_otp_expire_at' => null,
            'email_verified_at' => Carbon::now(),
        ];

        if ($request->escapeEmailVerify === "true") {
            unset($userUpdate['email_verified_at']);
        }

        $user->update($userUpdate);

        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully.'
        ]);
    }

    private function isActive($user): bool
    {
        return (int) $user->status === 1;
    }


    public function userDashboard()
    {
        return view('dashboard.user');
    }

    public function adminDashboard()
    {
        return view('dashboard.admin')->with('success', 'Test');
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.page');
    }


    public function forgotPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ]);
        }

        $otp = rand(1000, 9999);
        $user->update([
            'email_otp' => $otp,
            'email_otp_expire_at' => Carbon::now()->addMinutes(10),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully.'
        ]);
    }


    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }


        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully.'
        ]);
    }
}
