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

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('Auth.login');
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|digit:10',
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
        try {

            $emailOtp = rand(1000, 9999);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'email_otp' => $emailOtp,
                'email_otp_expire_at' => Carbon::now()->addMinutes(10),
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



        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
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
        return view('dashboard.admin');
    }
}
