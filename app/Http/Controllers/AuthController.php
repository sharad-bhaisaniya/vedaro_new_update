<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use App\Models\Cart;


class AuthController extends Controller
{
    
    
    public function register(Request $request)
{
    if ($request->isMethod("post")) {
        // Check if the email or phone number already exists in the database
        $existingUser = User::where('email', $request->email)
                            ->orWhere('phone', $request->phone)
                            ->first();

        if ($existingUser) {
            // If the user already exists with either the email or phone number, flash a message and return back
            session()->flash('error', 'The email or phone number is already registered. Please login or use a different one.');
            return redirect()->route('login'); // Or stay on the registration page if you prefer
        }

        $validated = $request->validate([
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "phone" => "required|numeric|digits_between:10,15",
            "email" => [
                "required",
                "email",
                "unique:users,email",
                "regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$/",
            ],
            "password" => "required|string|min:6|confirmed",
        ]);

        $hashedPassword = bcrypt($validated["password"]);
        $validated["password"] = $hashedPassword;

        $otp = rand(100000, 999999);
        Session::put('user_data', $validated);
        Session::put('otp', $otp);

        try {
            Mail::to($validated['email'])->send(new WelcomeMail($otp));
            session()->flash('success', 'OTP has been sent to your email.');
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to send OTP. Please try again later.');
            return redirect()->back();
        }

        return redirect()->route('verify-otp');
    }

    return view('auth.register');
}

    public function verifyOtp(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'otp' => 'required|numeric|digits:6',
            ]);

            $sessionOtp = Session::get('otp');
            $userData = Session::get('user_data');

            if ($request->otp == $sessionOtp) {
                $user = User::create($userData);
                Auth::login($user);
                session()->flash('success', 'Registration successful! Welcome to the platform.');
                return redirect()->route('home');
            } else {
                session()->flash('error', 'Invalid OTP. Please try again.');
                return redirect()->route('verify-otp');
            }
        }

        return view('auth.verify_otp');
    }
    public function showLoginForm()
{
    if (Auth::check()) {
        $user = Auth::user();
        return view('profile', compact('user'));
    } 
    else if (!str_contains(url()->previous(), 'login')) {
        \Illuminate\Support\Facades\Redirect::setIntendedUrl(url()->previous());
    }

    return view('auth.login');
}


public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();
    
    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);
        // dd(session('url.intended'));
        // ✅ Laravel will use session('url.intended') set by middleware
        return redirect()->intended(route('home')); // fallback to home if no intended
        
    }

    return back()->with('error', 'Invalid credentials');
}


// public function login(Request $request)
// {
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//     ]);

//     $user = User::where('email', $request->email)->first();

//     if ($user && Hash::check($request->password, $user->password)) {
//         Auth::login($user);

//         // ✅ Use the previous page before login page
//         $redirectTo = session()->pull('previous_url_before_login', route('home'));

//         // Fallback check
//         if (!$redirectTo || str_contains($redirectTo, 'login') || str_contains($redirectTo, 'register')) {
//             $redirectTo = route('home');
//         }

//         return redirect()->to($redirectTo)->with('success', 'You are now logged in!');
//     }

//     return back()->with('error', 'Invalid credentials.');
// }



    public function fetchRegisteredUsers()
    {
        $users = User::all();
        return view("admin.registered_users", compact("users"));
    }


// public function index()
// {
//     if (Auth::check()) {
//         $user = Auth::user();
//         return view('profile', compact('user'));
//     } else {
//         // Set the intended URL
//         if (!str_contains(url()->previous(), 'login')) {
//             Redirect::setIntendedUrl(url()->full()); // ya url()->current()
//         }

//         return redirect()->route('login');
//     }
// }

    public function home()
    {
        return view("home");
    }

    public function logout()
    {
        Auth::logout();
        session()->flash("success", "You have logged out successfully.");
        return redirect()->route("login");
    }

    public function resendOtp(Request $request)
    {
        $userData = Session::get('user_data');

        if (!$userData) {
            return redirect()->route('register')->with('error', 'Session expired. Please try again.');
        }

        $otp = rand(100000, 999999);
        Session::put('otp', $otp);

        try {
            Mail::to($userData['email'])->send(new WelcomeMail($otp));
            session()->flash('success', 'A new OTP has been sent to your email.');
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP: ' . $e->getMessage());
            session()->flash('error', 'Failed to resend OTP. Please try again later.');
        }

        return redirect()->route('verify-otp');
    }
    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    // Send Reset Link
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Send the reset link
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', __($status)); // Success message
        }

        return back()->withErrors(['email' => __($status)]); // Error message
    }

    // Show Reset Password Form (with token)
    public function showResetPasswordForm($token)
    {
        return view('auth.reset_password', ['token' => $token]);
    }

    // Reset Password (Post request)
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                Auth::login($user); // Automatically log the user in after reset
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', __($status)); // Password reset success
        }

        return back()->withErrors(['email' => [__($status)]]); // Error if something went wrong
    }
    
    
    
    
    
    
    
    public function authenticated(Request $request, $user)
{
    // Get the cart from the session for guest user
    $guestCart = Session::get('cart', []);

    if (!empty($guestCart)) {
        foreach ($guestCart as $item) {
            // Check if the item exists for this user
            $existingCartItem = Cart::where('product_id', $item['product_id'])
                ->where('customer_id', $user->id)
                ->first();

            if ($existingCartItem) {
                // If the item already exists, update the quantity
                $existingCartItem->product_qty += $item['product_qty'];
                $existingCartItem->save();
            } else {
                // If the item does not exist, create a new cart entry
                Cart::create([
                    'product_id' => $item['product_id'],
                    'product_qty' => $item['product_qty'],
                    'customer_id' => $user->id,
                ]);
            }
        }

        // Clear the session cart after migration
        Session::forget('cart');
    }
}
    
}
