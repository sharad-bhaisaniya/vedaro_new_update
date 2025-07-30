<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AiSensyService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    protected $aiSensyService;

    public function __construct(AiSensyService $aiSensyService)
    {
        $this->aiSensyService = $aiSensyService;
    }

    public function showLoginWithOtpForm()
    {
        return view('auth.login-with-otp');
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone'  => 'required|string|size:10',
            'action' => 'required|in:login,register',
        ]);

        if ($request->action === 'register') {
            $validator->after(function ($validator) use ($request) {
                if (User::where('phone', $request->phone)->exists()) {
                    $validator->errors()->add('phone', 'Phone number already registered. Please login instead.');
                }
            });

            $validator->sometimes('name', 'required|string|max:255', fn($input) => $input->action === 'register');
            $validator->sometimes('email', 'nullable|email|unique:users,email', fn($input) => $input->action === 'register');

        } else {
            // Login action
            $validator->after(function ($validator) use ($request) {
                if (!User::where('phone', $request->phone)->exists()) {
                    $validator->errors()->add('phone', 'Phone number not found. Please register first.');
                }
            });
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $otp = rand(100000, 999999);
        Session::put('otp_phone', $request->phone);
        Session::put('otp_code', $otp);
        Session::put('otp_expires_at', now()->addMinutes(10));

        if ($request->action === 'register') {
            Session::put('registration_data', [
                'name'  => $request->name,
                'last_name' => $request -> last_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        }

        $result = $this->aiSensyService->sendOtp($request->phone, $otp);

        if (!$result['success']) {
            return redirect()->back()
                ->with('error', 'Failed to send OTP: ' . ($result['message'] ?? 'Unknown error.'))
                ->withInput();
        }

        return redirect()->to('/wh-verify-otp')->with('success', 'OTP sent to your WhatsApp.');

    }

    public function showVerifyOtpForm()
    {
        if (!Session::has('otp_phone')) {
            return redirect()->route('login-with-otp')->with('error', 'Please request a new OTP.');
        }

        return view('auth.wh-verify-otp');

    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (!Session::has('otp_phone') || !Session::has('otp_code') || !Session::has('otp_expires_at')) {
            return redirect()->route('login-with-otp')->with('error', 'OTP session expired. Please try again.');
        }

        if (now()->gt(Session::get('otp_expires_at'))) {
            return redirect()->back()->with('error', 'OTP has expired. Please request a new one.');
        }

        if ($request->otp != Session::get('otp_code')) {
            return redirect()->back()->with('error', 'Invalid OTP. Please try again.');
        }

        // Registration flow
        if (Session::has('registration_data')) {
            $userData = Session::get('registration_data');

            $user = User::create([
                'first_name'     => $userData['name'],
                'last_name'     => $userData['last_name'],
                'email'    => $userData['email'],
                'phone'    => $userData['phone'],
                'password' => Hash::make(rand(100000, 999999)), // Random password
            ]);

            Session::forget('registration_data');
        } else {
            $user = User::where('phone', Session::get('otp_phone'))->first();
            if (!$user) {
                return redirect()->route('login-with-otp')->with('error', 'User not found.');
            }
        }

        Auth::login($user);
        Session::forget(['otp_phone', 'otp_code', 'otp_expires_at']);

        return redirect()->intended(route('home'))->with('success', 'You are now logged in!');
    }
    
    public function resendOtp(Request $request)
{
    if (!Session::has('otp_phone')) {
        return redirect()->route('login-with-otp')->with('error', 'Session expired. Please start again.');
    }

    $phone = Session::get('otp_phone');
    $otp = rand(100000, 999999);

    Session::put('otp_code', $otp);
    Session::put('otp_expires_at', now()->addMinutes(10));

    $result = $this->aiSensyService->sendOtp($phone, $otp);

    if (!$result['success']) {
        return redirect()->back()->with('error', 'Failed to resend OTP: ' . ($result['message'] ?? 'Unknown error.'));
    }

    return redirect()->back()->with('success', 'A new OTP has been sent to your WhatsApp number.');
}

}
