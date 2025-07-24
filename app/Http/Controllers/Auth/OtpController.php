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
            'phone' => 'required|numeric|digits_between:10,15|exists:users,phone',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $otp = rand(100000, 999999);
        Session::put('otp_phone', $request->phone);
        Session::put('otp_code', $otp);
        Session::put('otp_expires_at', now()->addMinutes(10));

        // Send OTP via WhatsApp
        $sent = $this->aiSensyService->sendOtp($request->phone, $otp);

        if (!$sent) {
            return redirect()->back()->with('error', 'Failed to send OTP. Please try again.');
        }

        return redirect()->route('verify-otp')->with('success', 'OTP has been sent to your WhatsApp.');
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
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric|digits:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (!Session::has('otp_phone') || !Session::has('otp_code') || !Session::has('otp_expires_at')) {
            return redirect()->route('login-with-otp')->with('error', 'OTP session expired. Please request a new OTP.');
        }

        if (now()->gt(Session::get('otp_expires_at'))) {
            return redirect()->back()->with('error', 'OTP has expired. Please request a new one.');
        }

        if ($request->otp != Session::get('otp_code')) {
            return redirect()->back()->with('error', 'Invalid OTP. Please try again.');
        }

        $user = User::where('phone', Session::get('otp_phone'))->first();

        if (!$user) {
            return redirect()->route('login-with-otp')->with('error', 'User not found. Please register first.');
        }

        Auth::login($user);

        // Clear OTP session
        Session::forget(['otp_phone', 'otp_code', 'otp_expires_at']);

        // Check for intended URL
        $redirectTo = session()->has('url.intended') && !in_array(session('url.intended'), [route('home'), route('login')])
            ? session('url.intended')
            : route('home');

        return redirect()->to($redirectTo)->with('success', 'You are now logged in!');
    }
}