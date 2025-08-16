<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PayUMoneyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderPaymentController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PreBookingController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\LimitedEditionBannerController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminAuthController;
use App\Mail\WelcomeMail;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\EventController;





// Event Route
Route::get('event',function(){
    return view('events');
});

// Event Checkout route - requires login
Route::get('/event-checkout', [EventController::class, 'index'])
    ->name('event.checkout')
    ->middleware('auth');

// Store event checkout form data
// Start payment (validate form + create Razorpay order)
Route::post('/event-initiate-payment', [EventController::class, 'initiatePayment'])
    ->name('event.initiate');

// Verify payment & save event
Route::post('/event-payment-verify', [EventController::class, 'verify'])
    ->name('event.payment.verify');
    // New booking routes
Route::middleware(['auth'])->group(function () {
    
    Route::get('/events_bookings', [EventController::class, 'showBookings'])
        ->name('events.booking.show');
        
    Route::delete('/bookings/{event}', [EventController::class, 'destroyBooking'])
        ->name('events.booking.destroy');
});


Route::get('/test-aisensy', function () {
    $service = new \App\Services\AiSensyService();
    return $service->sendOtp('8109010648', 123456); // Replace with your number
});


// OTP Authentication Routes
// Show form
Route::get('/login-with-otp', [OtpController::class, 'showLoginWithOtpForm'])->name('login-with-otp');
// Send OTP
Route::post('/wh-send-otp', [OtpController::class, 'sendOtp'])->name('wh.send.otp');
// Show Verify OTP form
Route::get('/wh-verify-otp', [OtpController::class, 'showVerifyOtpForm'])->name('wh.verify.otp');
// Verify OTP
Route::post('/wh-verify-otp', [OtpController::class, 'verifyOtp'])->name('wh.verify.otp.post');
// Resend OTP
Route::post('/wh-resend-otp', [OtpController::class, 'resendOtp'])->name('wh.resend.otp');


// The "Coming Soon" Page Itself - MUST be accessible
Route::get('/comming_soon', function () {
    return view('comming_soon');
})->name('comming_soon');

// Utility Routes (e.g., for setup or testing) - Kept accessible
Route::get('/create-symlink', function () {
    $publicStoragePath = public_path('storage');
    $storagePath = storage_path('app/public');

    if (!File::exists($publicStoragePath)) {
        File::link($storagePath, $publicStoragePath);
        return 'Symbolic link created successfully!';
    }

    return 'Symbolic link already exists.';
});

Route::get('/test-email', function () {
    Mail::raw('This is a basic test email', function ($message) {
        $message->to('vicky21ind@gmail.com')->subject('Test Email');
    });

    return 'Test email sent!';
});

// Admin Authentication Routes - Often needed even when the site is down for maintenance
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


Route::get('/home', function () {
    return view('home');
});

Route::get('/shop', function () {
    return view('shop');
});

Route::get('/my_orders', function () {
    return view('my_orders');
});

Route::get('/limited_edition', [HomeController::class, 'showLimitedEdition'])->name('limited.edition');
Route::post('/limited-banners/{id}/assign-product', [LimitedEditionBannerController::class, 'assignProduct']);
Route::post('/limited-banners/{id}/remove-product', [LimitedEditionBannerController::class, 'removeProduct']);


Route::get('/contact', function () {
    return view('contact');
});

Route::get('/wishlist', function () {
    return view('wishlist');
});

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/user-profile', function () {
    return view('user_profile');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/thanku', function () {
    return view('thanku');
})->name('thanku');

Route::get('/terms_and_condition', function () {
    return view('terms_and_condition');
});

Route::get('/privacy_policy', function () {
    return view('privacy_policy');
});

Route::get('/shipping_policy', function () {
    return view('shipping_policy');
});

Route::get('/cancellation_refund', function () {
    return view('cancellation_refund');
});



Route::get('/user-profile', [HomeController::class, 'showProfile'])->name('user_profile');
// -----------------------------------------------
// Admin Routes (Protected by auth:admin middleware)
// -----------------------------------------------

Route::prefix('admin')->group(function () {

    Route::middleware(['auth:admin'])->group(function () {
        // Admin dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Product Management
        Route::match(['get', 'post'], '/add-product', [AdminController::class, 'add_products'])->name('admin.add_product');
        Route::get('/manage-products', [AdminController::class, 'show_products'])->name('admin.manage_product');
        Route::get('/edit_product/{id}', [AdminController::class, 'edit_product'])->name('admin.edit_product');
        Route::put('/update_product/{id}', [AdminController::class, 'update_product'])->name('admin.update_product');
        Route::delete('/manage-products/{id}', [AdminController::class, 'delete_product'])->name('admin.delete_product');

        // Category Management
        Route::match(['get', 'post'], '/categories', [AdminController::class, 'handleCategoryForm'])->name('admin.categories');
        Route::get('/manage-categories', [AdminController::class, 'manageCategories'])->name('admin.manage_categories');
        Route::get('/edit_category/{id}', [AdminController::class, 'editCategory'])->name('admin.edit_category');
        Route::post('/update_category/{id}', [AdminController::class, 'updateCategory'])->name('admin.update_category');
        Route::delete('/manage-categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.delete_category');
        Route::post('/category/toggle-active/{id}', [AdminController::class, 'toggleActive'])->name('admin.toggle_category');
        Route::post('/admin/category/{id}/toggle-home', [CategoryController::class, 'toggleShowOnHome'])
        ->name('admin.toggle_show_on_home');


 

          // Gift Products
        Route::match(['get', 'post'], '/gift-product', [AdminController::class, 'add_gift_product'])->name('admin.gift-product');
        Route::get('/manage-gift-product', [AdminController::class, 'manage_gift_products'])->name('admin.manage_gift_product');
        Route::post('/gifts/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.toggle_gift_status');


        // Timers
        Route::get('/timers', [AdminController::class, 'timer_management'])->name('admin.timers');

        // Utility
        Route::get('/add-product', [AdminController::class, 'categoriesName'])->name('admin.add_product');
        
         Route::get('/pre-bookings', [PreBookingController::class, 'index'])->name('admin.prebookings');
            Route::post('/pre-bookings/{id}/send-whatsapp', [PreBookingController::class, 'sendWhatsAppReminder'])
        ->name('prebookings.sendWhatsApp');
         
            Route::get('/completed_orders', [OrderController::class, 'completedOrders']);
            Route::get('/pending_orders', [OrderController::class, 'pendingOrders']);
            Route::get('/canceled_orders', [OrderController::class, 'canceledOrders']);
            
            Route::post('/ship_order', [OrderController::class, 'shipOrder'])->name('ship.order');
    });
});

Route::get('admin/', function () {
})->name('index');


Route::get('/dashboard', function () {
    return 'Welcome to Admin Dashboard';
})->name('admin.dashboard');

// -----------------------------------------------
// Authentication Routes (Login, Registration, etc.)
// -----------------------------------------------

// Registration routes
Route::get('/register', [AuthController::class, 'register'])->name('register'); // Registration form
Route::post('/register', [AuthController::class, 'register']); // Handle registration

// Login routes
// Route::get('/login', [AuthController::class, 'index'])->name('login'); // Login form
// web.php
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']); // Handle login

// Logout route
Route::get('/logout', [AuthController::class, 'logout'])->name('logout'); // Logout route

// Home route (Authenticated)
Route::get('/', [HomeController::class, 'ShowOnHome'])->name('home');

// Route::get('/', function () {
//     return view('comming_soon');
// });


Route::get('/admin', function () {
    return view('admin/index');
});



// Route to fetch all products
Route::get('/fetch-products', [HomeController::class, 'fetchProducts'])->name('fetch.products');

// Route to fetch all categories
Route::get('/fetch-categories', [HomeController::class, 'fetchCategories'])->name('fetch.categories');

// Admin route to fetch registered users
Route::get('/admin/registered-users', [AuthController::class, 'fetchRegisteredUsers'])->name('admin.registered_users');

// -----------------------------------------------
// Product Routes
// -----------------------------------------------

// Product details page
Route::get('product_details/{id}', [ProductController::class, 'show'])->name('product.details');
Route::post('/products/{product}/update-weight', [ProductController::class, 'updateWeight']);
Route::post('/product/update-size/{id}', [ProductController::class, 'updateSize'])->name('product.updateSize');


// Main shop page route
Route::get('/shop', [HomeController::class, 'ShowOnShop'])->name('shop');
Route::get('/product/{id}', [HomeController::class, 'index'])->name('product.show');


// Route to fetch products by category
Route::get('/fetch-products-by-category/{categoryId}', [HomeController::class, 'fetchProductsByCategory'])->name('fetch.products.by.category');

// Fetch products with sorting or filtering (AJAX)
Route::get('/fetch-products', [HomeController::class, 'fetchProducts'])->name('fetch.products');

// Fetch all categories (for use with category filter)
Route::get('/fetch-categories', [HomeController::class, 'fetchCategories'])->name('fetch.categories');


// -----------------------------------------------
// Cart Routes (Adding, Updating, Removing items)
// -----------------------------------------------

Route::get('/cart', [CartController::class, 'cart_view'])->name('cart');

// Add to cart functionality
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');

// Cart update functionality
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');

// Remove item from cart
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Get cart count for the user
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

Route::post('/cart/update-totals', [CartController::class, 'updateCartTotals']);

Route::post('/cart/update-total', [CartController::class, 'updateTotal'])->name('cart.updateTotal');



// Apply coupon to cart
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');

Route::get('/checkout', [CartController::class, 'checkout_view'])->name('cart.checkout_view');
Route::get('/checkout-single/{product_id}', [CartController::class, 'singleCheckoutView'])->name('checkout.single');
Route::post('/checkout', [CartController::class, 'store_address'])->name('add.address');

// ----------------------------------------users profile----------------------------------------------

Route::middleware('auth')->group(function () {
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
Route::middleware('auth')->get('/profile', [ProfileController::class, 'show']);


// --------------------------------------------------------------------------------------------------

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/product_details/{id}', [ReviewController::class, 'showProductDetails'])->name('product.details');

// ----------------------------------------pay U money----------------------------------------------
Route::get('pay-u-money-view', [PayUMoneyController::class, 'payUMoneyView'])->name('pay.u.money.view');
Route::post('pay-u-money-view', [PayUMoneyController::class, 'payUMoneyView']);

Route::group(['middleware' => []], function () {
    Route::match(['get', 'post'], '/pay-u/response', [PayUMoneyController::class, 'payUResponse'])->name('pay.u.response');
    Route::match(['get', 'post'], '/pay-u/cancel', [PayUMoneyController::class, 'payUCancel'])->name('pay.u.cancel');
});


// ----------------------------------------pay U money----------------------------------------------

Route::get('verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp');
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend-otp');


Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('order-status/{order_id}', [OrderController::class, 'showStatus'])->name('order.status');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.page');


Route::get('track-order', [OrderController::class, 'trackOrderPage']);
Route::get('track-order/{awbNo}', [OrderController::class, 'trackOrder']);

Route::middleware('auth')->get('/checkout', [CartController::class, 'checkout_view'])->name('checkout');

Route::post('/address', [UserAddressController::class, 'store'])->name('address.store');

Route::get('/address', [UserAddressController::class, 'showForm'])->name('address.form');

Route::get('/login/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

// --------------------------------------Order Routes------------------------------------------------------------

Route::get('/track-order', [OrderController::class, 'trackOrder'])->name('track.order');


Route::get('/fetch-shiprocket-orders', [OrderController::class, 'fetchShiprocketOrders'])->middleware('auth');

Route::post('/cancel-shiprocket-order', [OrderController::class, 'cancelShiprocketOrder']);

// --------------------------------------------------------------------------------------------------

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Route::get('/product_details/{id}', [ReviewController::class, 'showProductDetails'])->name('product.details');
Route::get('/product_details/{productName}', [ReviewController::class, 'showProductDetails'])->name('product.details');


// Initiate Razorpay order (AJAX call from frontend)
Route::post('/razorpay/initiate', [RazorpayController::class, 'initiatePayment'])->name('razorpay.initiate');

// Verify payment after success (AJAX call from frontend after Razorpay payment)
Route::post('/razorpay/verify', [RazorpayController::class, 'verifyPayment'])->name('razorpay.verify');

// Thank You page after successful payment
Route::get('/thank-you', [RazorpayController::class, 'thankYouPage'])->name('razorpay.thankyou');


// Banner Routes------------------------------------------------------------use App\Http\Controllers\BannerController;

Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
Route::patch('/banners/{id}/activate', [BannerController::class, 'activate'])->name('banners.activate');
Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');

// All categories Page products

Route::get('/categories', [CategoryController::class, 'index'])->name('categories_page');

// User Inquiry Routes
Route::get('/admin/inquiries', [InquiryController::class, 'index'])->name('admin.inquiries.index');

// Route for the contact form submission
Route::post('/contact', [InquiryController::class, 'store'])->name('contact.store');

// Global Search Page routes

Route::get('/global-search', function () {
    return view('global_search');
});

// Update user details routes

Route::middleware(['auth'])->group(function () {
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::put('/user/password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::put('/user/address', [UserController::class, 'updateAddress'])->name('user.updateAddress');
});

// PreBooking Order Store Route
Route::post('/prebook/{product_id}', [PreBookingController::class, 'store'])->name('prebook.store');


// Limited Edition Banner's

Route::resource('limited-banners', LimitedEditionBannerController::class);

// Update Addresses store
Route::middleware(['auth'])->group(function () {
    Route::post('/address/store', [AddressController::class, 'store'])->name('user.address.store');
    Route::get('/address/list', [AddressController::class, 'index'])->name('address.index');
    Route::post('/user/address/update', [AddressController::class, 'update'])->name('user.address.update');
    Route::post('/address/set-default/{id}', [AddressController::class, 'setDefault'])->name('address.setDefault');
});



// Routes for Global Search 
Route::get('/global-search', [GlobalSearchController::class, 'search'])->name('global.search');


// Coupon's route

Route::get('/coupon', [CouponController::class, 'index'])->name('coupon.index');
Route::post('/coupon', [CouponController::class, 'store'])->name('coupon.store');
Route::get('/All_Coupons', [CouponController::class, 'show'])->name('coupon.show');
Route::get('/coupon/{coupon}/edit', [CouponController::class, 'edit'])->name('coupon.edit');
Route::put('/coupon/{coupon}', [CouponController::class, 'update'])->name('coupon.update');
Route::delete('/coupon/{id}', [CouponController::class, 'delete'])->name('coupon.delete');
// In web.php
// Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply.coupon');

Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon']);

// Coupon application route (for both guests and authenticated users)
Route::post('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply-coupon');








