@extends('layouts.main')

@section('content')

    <style>
        /* Using a standard font since custom fonts from local files are not supported */
       /* Using a standard font since custom fonts from local files are not supported */
body {
    font-family: sans-serif;
    background-color: #f2ecdd;
    color: #0f2a1d;
    margin: 0;
    padding: 0;
}
.account-container-main {
    display: flex;
    justify-content: center;
}

/* The main container for the entire page */
.account-container {
    display: flex;
    flex-direction: column; /* Stacks vertically on smaller screens */
    width: 100%;
    max-width: 1300px;
    padding: 20px;
    gap: 20px;
}

/* Media query for larger screens (e.g., tablets and desktops) */
@media (min-width: 768px) {
    .account-container {
        flex-direction: row; /* Switches to a row layout */
        padding: 40px;
        gap: 40px;
    }
}

/* Sidebar styling */
.sidebar-acc {
    width: 100%; /* Takes full width on mobile */
    border-bottom: 1px solid #ddd;
    padding-bottom: 20px;
}

/* Adjusts sidebar for desktop view */
@media (min-width: 768px) {
    .sidebar-acc {
        width: 250px;
        border-bottom: none;
        border-right: 1px solid #ddd;
    }
}

.sidebar-acc h2 {
    margin-bottom: 30px;
}

.menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu li {
    border-bottom: 1px solid #ddd;
}

.menu li:first-child {
    border-top: 1px solid #ddd;
}

.menu a {
    display: block;
    padding: 15px;
    text-decoration: none;
    color: #0f2a1d;
}

.menu a.active {
    background-color: #0f2a1d;
    color: #f2ecdd;
    border-radius: 10px;
}

/* Main content area */
.content {
    flex: 1;
    overflow-y: auto; /* Enables vertical scrolling for the content area */
    padding-top: 20px;
}

/* Hides all content sections by default */
.content-section {
    display: none;
}

/* Shows the active content section */
.content-section.active {
    display: block;
}

.content h3 {
    margin-bottom: 20px;
}

/* Form layout */
.form-grid {
    display: grid;
    grid-template-columns: 1fr; /* Single column on mobile */
    gap: 15px;
}

/* Switches to a two-column grid on larger screens */
@media (min-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 12px;
    margin-bottom: 5px;
}

.form-group input {
    padding: 8px;
    border: 1px solid #0f2a1d;
    border-radius: 5px;
    background-color: #f2ecdd;
    color: #0f2a1d;
    font-size: 14px;
}

/* Media query to revert to larger font sizes on desktop */
@media (min-width: 768px) {
    .form-group label {
        font-size: 14px;
    }
    .form-group input {
        font-size: 16px;
        padding: 10px;
    }
}

/* Edit button styling */
.btn-edit {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #0f2a1d;
    color: #f2ecdd;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.btn-edit:hover {
    opacity: 0.9;
}

.btn-container-in {
    margin: 20px 0;
}

/* Order section styling */
.order-tabs {
    display: flex;
    justify-content: flex-start;
    margin-bottom: 20px;
    background-color: #e2d9c4;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #ccc;
}

.order-tab {
    padding: 10px 20px;
    cursor: pointer;
    font-weight: bold;
    color: #666;
    transition: background-color 0.3s, color 0.3s;
    width: 50%;
    text-align: center;
}

.order-tab.active {
    background-color: #0f2a1d;
    color: #f2ecdd;
}

.order-card {
    background-color: #f5f2e8;
    border-radius: 15px;
    padding: 10px 30px;
    margin-bottom: 20px;
    display: flex;
    flex-direction: row; /* Stacks elements vertically on smaller screens */
    gap: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

@media (min-width: 500px) {
    .order-card {
        flex-direction: row; /* Switches to row on larger screens */
    }
}

.order-card img {
    width: 100px;
    height: 100px;
    border-radius: 10px;
    object-fit: cover;
}

.order-details {
    flex-grow: 1;
}

.order-details h4 {
    margin: 0 0 5px 0;
    font-size: 16px;
}

.order-details p {
    margin: 0;
    font-size: 14px;
    color: #666;
}

.order-details .price {
    font-size: 16px;
    font-weight: bold;
    color: #0f2a1d;
}

.order-details .old-price {
    text-decoration: line-through;
    color: #aaa;
    font-size: 14px;
    margin-left: 5px;
}

.order-actions {
    display: flex;
    gap: 10px;
    flex-direction: row; /* Arranges buttons side-by-side on mobile */
    align-items: center;
    justify-content: center;
}

@media (min-width: 500px) {
    .order-actions {
        flex-direction: column; /* Switches to vertical on larger screens */
        align-items: flex-end;
    }
   
}

.order-btn {
    padding: 6px 10px;
    border-radius: 8px;
    cursor: pointer;
    border: 1px solid #0f2a1d;
    font-size: 10px;
}

.track-btn {
    background-color: #0f2a1d;
    color: #f2ecdd;
}

.cancel-btn {
    background-color: transparent;
    color: #0f2a1d;
}

.view-details {
    font-size: 12px;
    color: #0f2a1d;
    text-decoration: none;
    align-self: flex-start;
    margin-top: 5px;
}

@media (min-width: 500px) {
    .view-details {
        align-self: center;
    }
    .order-tab{
        font-size:0.8rem;
    }
    
}

@media (max-width: 500px) {
     .order-details .price{
        font-size:10px
    }
    .order-details h4{
        font-size:12px
        
    }
    .btn-container-in{
        margin:10px;
    display: flex;
    gap: 10px;
    }
    .order-card img{
        width: 80px;
    }
}
/*btn color*/
.save-btns{
    background-color: #0f2a1d;
    color: white;
}
/*carts style*/
/* Cart-specific tweaks */
.cart-card {
    align-items: center;
    background-color: #fffbe9;
}

.cart-img {
    width: 90px;
    height: 90px;
    border-radius: 8px;
    object-fit: cover;
}

.cart-title {
    font-size: 16px;
    margin-bottom: 5px;
}

.cart-price {
    margin: 5px 0;
}

.cart-qty {
    font-size: 14px;
    color: #444;
}

.cart-summary {
    background: #f2ecdd;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    margin-top: 20px;
}

.cart-summary h4 {
    margin-bottom: 15px;
}

.cart-summary p {
    margin: 5px 0;
    font-size: 14px;
}

.cart-summary .cart-total {
    font-size: 16px;
    color: #0f2a1d;
    font-weight: bold;
}

.empty-cart {
    padding: 40px;
    text-align: center;
    font-size: 16px;
    background-color: #fffbe9;
    border-radius: 12px;
}
/*favorite products*/
    .favorite-items {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 15px;
    }
    .favorite-item {
        border: 1px solid #ccc;
        padding: 10px;
        width: 150px;
        text-align: center;
        border-radius: 8px;
        background: #f9f9f9;
    }
    .favorite-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin-bottom: 8px;
    }




    </style>

    <div class="account-container-main">
        <div class="account-container">
            <div class="sidebar-acc">
                <h2>My Account</h2>
                <ul class="menu">
                    <li><a href="#" class="nav-link active" data-section="personal-info">Personal Information</a></li>
                    <li><a href="#" class="nav-link" data-section="my-orders">My orders</a></li>
                    <li><a href="#" class="nav-link" data-section="favorite">Favorite</a></li>
                    <li><a href="#" class="nav-link" data-section="cart">Cart</a></li>
                        <li><a href="#" class="nav-link" data-section="addressSection">Manage Address</a></li> {{-- NEW --}}
                    <li><a href="#" class="nav-link" data-section="sign-out">Sign out</a></li>
                </ul>
            </div>

            
         <div class="content">
            {{-- Personal Info --}}
           <div id="personal-info" class="content-section active">
    <h3>Personal Information</h3>
    <form id="personalInfoForm" method="POST" action="{{ route('user.updateProfile') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" 
                       value="{{ $user->first_name ?? '' }}" disabled>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" 
                       value="{{ $user->last_name ?? '' }}" disabled>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" 
                       value="{{ $user->email ?? '' }}" disabled>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" 
                       value="{{ $user->phone ?? '' }}" disabled>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-select" disabled>
                    <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
        </div>

        <div class="btn-container-in">
            <button type="button" class="btn-edit" id="editBtn">✏ Edit</button>
            <button type="submit" class="btn save-btns" id="saveBtn" style="display:none;">💾 Save</button>
        </div>
    </form>
</div>


                <div id="my-orders" class="content-section">
                    <div class="order-tabs">
                        <div class="order-tab active" data-tab="current-order">Current Order</div>
                        <div class="order-tab" data-tab="previous-purchase">Previous Purchase</div>
                    </div>

                    <div id="current-order" class="order-tab-content active">
                        <div class="order-card">
                            <img src="https://cdn.pixabay.com/photo/2021/06/22/21/20/ring-6357278_1280.jpg" alt="Product Image">
                            <div class="order-details">
                                <h4>Enticing petit drop earing</h4>
                                <p><span class="price">₹44,112.11</span> <span class="old-price">₹54,112.11</span></p>
                                <div class="btn-container-in">
                                    <button class="order-btn track-btn">Track Shipment</button>
                                    <button class="order-btn cancel-btn">Cancel Order</button>
                                </div>
                            </div>
                            <div class="order-actions">
                                <a href="#" class="view-details">view details</a>
                            </div>
                        </div>

                        <div class="order-card">
                            <img src="https://cdn.pixabay.com/photo/2018/05/08/16/11/gold-ring-with-eye-3383363_1280.png" alt="Product Image">
                            <div class="order-details">
                                <h4>Enchanting Gold Ring</h4>
                                <p><span class="price">₹44,112.11</span> <span class="old-price">₹54,112.11</span></p>
                                <div class="btn-container-in">
                                    <button class="order-btn track-btn">Track Shipment</button>
                                    <button class="order-btn cancel-btn">Cancel Order</button>
                                </div>
                            </div>
                            <div class="order-actions">
                                <a href="#" class="view-details">view details</a>
                            </div>
                        </div>

                        <div class="order-card">
                            <img src="https://cdn.pixabay.com/photo/2016/11/29/03/40/amethyst-1867160_1280.jpg" alt="Product Image">
                            <div class="order-details">
                                <h4>Stunning Amethyst Pendant</h4>
                                <p><span class="price">₹44,112.11</span> <span class="old-price">₹54,112.11</span></p>
                                <div class="btn-container-in">
                                    <button class="order-btn track-btn">Track Shipment</button>
                                    <button class="order-btn cancel-btn">Cancel Order</button>
                                </div>
                            </div>
                            <div class="order-actions">
                                <a href="#" class="view-details">view details</a>
                            </div>
                        </div>
                    </div>

                    <div id="previous-purchase" class="order-tab-content" style="display: none;">
                        <div class="order-card">
                            <img src="https://cdn.pixabay.com/photo/2016/11/29/03/40/amethyst-1867160_1280.jpg" alt="Product Image">
                            <div class="order-details">
                                <h4>Stunning Amethyst Pendant</h4>
                                <p>Order Placed: 17 July 2025</p>
                                <p>Order Number: 106-89716282-898902</p>
                                <p>Delivered: 21 July 2025</p>
                            </div>
                            <div class="order-actions">
                                <a href="#" class="view-details">view details</a>
                            </div>
                        </div>
                        <div class="order-card">
                            <img src="https://cdn.pixabay.com/photo/2021/06/22/21/20/ring-6357278_1280.jpg" alt="Product Image">
                            <div class="order-details">
                                <h4>Enticing petit drop earing</h4>
                                <p>Order Placed: 17 July 2025</p>
                                <p>Order Number: 106-89716282-898902</p>
                                <p>Delivered: 21 July 2025</p>
                            </div>
                            <div class="order-actions">
                                <a href="#" class="view-details">view details</a>
                            </div>
                        </div>
                        <div class="order-card">
                            <img src="https://cdn.pixabay.com/photo/2018/05/08/16/11/gold-ring-with-eye-3383363_1280.png" alt="Product Image">
                            <div class="order-details">
                                <h4>Enchanting Gold Ring</h4>
                                <p>Order Placed: 17 July 2025</p>
                                <p>Order Number: 106-89716282-898902</p>
                                <p>Delivered: 21 July 2025</p>
                            </div>
                            <div class="order-actions">
                                <a href="#" class="view-details">view details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!--<div id="favorite" class="content-section">-->
                <!--    <h3>Favorite Items</h3>-->
                <!--    <p>You have no saved favorite items.</p>-->
                <!--</div>-->
                <div id="favorite" class="content-section">
                    <h3>Favorite Items</h3>
                
                    <div class="favorite-items">
                        @forelse($wishlistItems as $wishlistItem)
                            @php
                                $product = $wishlistItem;
                                $variant = null;
                
                                // Default prices
                                $displayPrice = $product->discountPrice ?? $product->price ?? 0;
                                $oldPrice = $product->price ?? null;
                
                                // ✅ If product type is 'variant', find its variant and override prices
                                if ($product->product_type === 'variant') {
                                    $variant = App\Models\ProductVariant::where('product_id', $product->id)
                                        ->first();
                
                                    if ($variant) {
                                        $displayPrice = $variant->discount_price ?? $variant->price ?? 0;
                                        $oldPrice = $variant->price ?? null;
                                    }
                                }
                
                                // ✅ Select correct image
                                $image = $variant && $variant->image
                                    ? $variant->image
                                    : ($product->image1 ?? null);
                            @endphp
                
                            <div class="favorite-item">
                                <img src="{{ asset('storage/products/' . $image) }}" alt="{{ $product->productName }}">
                                <p>{{ $product->productName }}</p>
                                <p>
                                    ₹ {{ number_format($displayPrice, 2) }}
                                    <!--@if($oldPrice && $oldPrice > $displayPrice)-->
                                    <!--    <span class="line-through text-gray-500 text-sm ml-2">₹ {{ number_format($oldPrice, 2) }}</span>-->
                                    <!--@endif-->
                                </p>
                            </div>
                        @empty
                            <p>No favorite items found.</p>
                        @endforelse
                    </div>
                </div>
                




                <!--<div id="cart" class="content-section">-->
                <!--    <h3>Your Cart</h3>-->
                <!--    <p>Your cart is empty.</p>-->
                <!--</div>-->
                <div id="cart" class="content-section">
                    <h3>Your Cart ({{ count($cartItems) }} items)</h3>
                
                    @if(count($cartItems) > 0)
                      <div class="row">
                    @foreach($cartItems as $item)
                        @php
                            // Extract product and quantity
                            $product = is_array($item) ? ($item['product'] ?? null) : ($item->product ?? null);
                            $qty = is_array($item) ? ($item['product_qty'] ?? 1) : ($item->product_qty ?? 1);
                            $size = is_array($item) ? ($item['size'] ?? null) : ($item->size ?? null);
                
                            $variant = null;
                            $displayPrice = $product->discountPrice ?? $product->price ?? 0;
                            $oldPrice = $product->price ?? null;
                
                            // ✅ Check if this product is variant type
                            if ($product && $product->product_type === 'variant') {
                                // Find the variant that matches this size
                                $variant = App\Models\ProductVariant::where('product_id', $product->id)
                                    ->when($size, fn($q) => $q->where('size', $size))
                                    ->first();
                
                                // If variant exists, use its prices
                                if ($variant) {
                                    $displayPrice = $variant->discount_price ?? $variant->price ?? 0;
                                    $oldPrice = $variant->price ?? null;
                                }
                            }
                
                            // ✅ Get image (variant image if exists, else product image)
                            $image = $variant && $variant->image
                                ? $variant->image
                                : ($product->image1 ?? null);
                        @endphp
                
                        <div class="col-md-6 mb-4 cart-item"
                             id="cart-item-{{ $item->id }}"
                             data-id="{{ $item->id }}"
                             data-price="{{ $displayPrice }}"
                             data-qty="{{ $qty }}">
                
                            <div class="order-card cart-card h-100 d-flex">
                                {{-- Product Image --}}
                                <img src="{{ asset('storage/products/' . $image) }}"
                                     alt="{{ $product->productName }}"
                                     class="cart-img me-3">
                
                                <div class="order-details flex-grow-1">
                                    {{-- Product Name + Size --}}
                                    <h4 class="cart-title product-name mb-1">
                                        {{ $product->productName }}
                                        @if($size)
                                            <small class="text-muted">(Size: {{ $size }})</small>
                                        @endif
                                    </h4>
                
                                    {{-- Price --}}
                                    <p class="cart-price mb-1">
                                        <span class="price product-price text-dark">
                                            ₹{{ number_format($displayPrice, 2) }}
                                        </span>
                                        @if($oldPrice && $oldPrice > $displayPrice)
                                            <span class="old-price text-muted">
                                                <s>₹{{ number_format($oldPrice, 2) }}</s>
                                            </span>
                                        @endif
                                    </p>
                
                                    {{-- Quantity --}}
                                    <p class="cart-qty mb-2">Qty: <strong>{{ $qty }}</strong></p>
                
                                    {{-- Remove --}}
                                    <button type="button"
                                            class="order-btn cancel-btn btn btn-sm btn-danger remove-item-btn"
                                            data-id="{{ $item->id }}">
                                        🗑 Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                
                        {{-- Cart Summary --}}
                        <div class="cart-summary mt-4 p-3 border rounded">
                            <h4>Order Summary</h4>
                            <div class="summary-breakdown"></div>
                            <p><strong>Subtotal:</strong> <span id="summary-subtotal">₹{{ number_format($subtotal, 2) }}</span></p>
                            <p class="cart-total"><strong>Total:</strong> <span id="summary-total">₹{{ number_format($total, 2) }}</span></p>
                        </div>
                
                    @else
                        <div class="empty-cart text-center p-4">
                            <p>🛒 Your cart is empty.</p>
                        </div>
                    @endif
             
                </div>
            


                
                
                <!--Add new address section-->
                 {{-- ✅ New Manage Address Section --}}
            @php
                use Illuminate\Support\Facades\Auth;
                use App\Models\Address;
                $addresses = \App\Models\Address::where('user_id', Auth::id())->get();
            @endphp

            <div id="addressSection" class="content-section">
                <h3>Manage Address</h3>
                <div class="card mb-4">
                    <div class="card-header">
                        <label for="savedAddressSelect" class="form-label">Your Saved Addresses</label>
                    </div>
                    <div class="card-body">
                        {{-- Address Selection --}}
                        <select id="savedAddressSelect" class="form-control mb-3" onchange="showUpdateForm(this)">
                            <option value="">-- Select Saved Address --</option>
                            @foreach($addresses as $address)
                                <option value="{{ htmlspecialchars(json_encode($address), ENT_QUOTES, 'UTF-8') }}">
                                    {{ $address->address }}, {{ $address->city }}, {{ $address->state }}, {{ $address->pincode }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Edit Button --}}
                        <button id="editAddressBtn" type="button" class="btn btn-warning mb-3" style="display: none;" onclick="editSelectedAddress()">Edit Selected Address</button>

                        {{-- Update Address Form --}}
                        <form id="updateAddressForm" method="POST" action="{{ route('user.address.update') }}" style="display: none;">
                            @csrf
                            <input type="hidden" name="id" id="updateAddressId">

                            <div class="mb-3">
                                <label>Address Line</label>
                                <input type="text" name="address" class="form-control" id="updateAddress" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>City</label>
                                    <input type="text" name="city" class="form-control" id="updateCity" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>State</label>
                                    <input type="text" name="state" class="form-control" id="updateState" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Pincode</label>
                                    <input type="text" name="pincode" class="form-control" id="updatePincode" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Country</label>
                                    <input type="text" name="country" class="form-control" id="updateCountry" value="India" required>
                                </div>
                            </div>
                            <button type="submit" class="btn save-btns">Update Address</button>
                        </form>

                        {{-- Add New Address --}}
                        <button type="button" class="btn save-btns  mt-4" onclick="toggleNewAddressForm()">+ Add New Address</button>

                        <form id="newAddressForm" action="{{ route('user.address.store') }}" method="POST" class="mt-3" style="display: none;">
                            @csrf
                            <div class="mb-3">
                                <label>Address Line</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>City</label>
                                    <input type="text" name="city" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>State</label>
                                    <input type="text" name="state" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Pincode</label>
                                    <input type="text" name="pincode" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Country</label>
                                    <input type="text" name="country" class="form-control" value="India" required>
                                </div>
                            </div>
                            <button type="submit" class="btn save-btns">Save New Address</button>
                        </form>
                    </div>
                </div>
            </div>
                
                
                

                <div id="sign-out" class="content-section">
                    <h3>Sign Out</h3>
                    <p>Are you sure you want to sign out?</p>
                    <button class="btn-edit" onclick="window.location.href='/logout'">Sign Out</button>
                </div>
            </div>
        </div>
    </div>

   <script>
document.addEventListener('DOMContentLoaded', () => {
    // ==========================
    // Sidebar Navigation
    // ==========================
    const navLinks = document.querySelectorAll('.nav-link');
    const contentSections = document.querySelectorAll('.content-section');

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const sectionId = link.getAttribute('data-section');

            navLinks.forEach(nav => nav.classList.remove('active'));
            contentSections.forEach(section => section.classList.remove('active'));

            link.classList.add('active');
            document.getElementById(sectionId).classList.add('active');
        });
    });

    // ==========================
    // Personal Info Edit/Save Toggle
    // ==========================
    const editBtn = document.getElementById("editBtn");
    const saveBtn = document.getElementById("saveBtn"); // optional save button
    const inputs = document.querySelectorAll("#personal-info .form-group input, #personal-info .form-group select");

    if (editBtn) {
        editBtn.addEventListener("click", (e) => {
            e.preventDefault();
            const isDisabled = inputs[0].disabled;

            // Toggle all fields
            inputs.forEach(input => input.disabled = !isDisabled);

            if (isDisabled) {
                // Editing mode
                editBtn.style.display = "none";
                if (saveBtn) saveBtn.style.display = "inline-block";
            } else {
                // Cancel editing (if you want a cancel flow)
                editBtn.textContent = "✏ Edit";
                if (saveBtn) saveBtn.style.display = "none";
            }
        });
    }
});

// ==========================
// Address Section Functions
// ==========================
function showUpdateForm(select) {
    const data = select.value ? JSON.parse(select.value) : null;
    if (data) {
        document.getElementById('editAddressBtn').style.display = 'block';
        document.getElementById('updateAddressId').value = data.id;
        document.getElementById('updateAddress').value = data.address;
        document.getElementById('updateCity').value = data.city;
        document.getElementById('updateState').value = data.state;
        document.getElementById('updatePincode').value = data.pincode;
        document.getElementById('updateCountry').value = data.country || 'India';
    } else {
        document.getElementById('editAddressBtn').style.display = 'none';
        document.getElementById('updateAddressForm').style.display = 'none';
    }
}

function editSelectedAddress() {
    document.getElementById('updateAddressForm').style.display = 'block';
}

function toggleNewAddressForm() {
    const form = document.getElementById('newAddressForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>



<!--script for remove items -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Remove Item
    $(document).on("click", ".remove-item-btn", function () {
        const id = $(this).data("id");
        const itemRow = $(`#cart-item-${id}`);

        if (!itemRow.length) return;

        // Remove from UI immediately
        itemRow.fadeOut(300, function () {
            $(this).remove();
            updateCartTotals(); // update totals instantly
        });

        // Tell server to remove item
        $.ajax({
            url: "/cart/remove",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
            },
            success: function (response) {
                if (response.success) {
                    showSuccessMessage("Item removed from cart!");
                    
            // ✅ update header counter
            $("#cart_counter").text(response.count);

            // hide badge if empty
            if (response.count <= 0) {
                $("#cart_counter").hide();
            } else {
                $("#cart_counter").show();
            }
       
                } else {
                    showErrorMessage(response.message || "Something went wrong!");
                }
            },
            error: function () {
                showErrorMessage("Failed to remove item. Try again!");
            }
        });
    });

    // Update Cart Totals
    function updateCartTotals() {
        let subtotal = 0;
        $(".summary-breakdown").empty();

        $(".cart-item").each(function () {
            const price = parseFloat($(this).data("price")) || 0;
            const qty = parseInt($(this).data("qty")) || 1;
            const name = $(this).find(".product-name").text();
            const rowSubtotal = price * qty;

            subtotal += rowSubtotal;

            $(".summary-breakdown").append(`
                <div class="d-flex justify-content-between mb-2">
                    <span>${name} (x${qty})</span>
                    <span>₹${rowSubtotal.toFixed(2)}</span>
                </div>
            `);
        });

        $("#summary-subtotal").text(`₹${subtotal.toFixed(2)}`);
        $("#summary-total").text(`₹${subtotal.toFixed(2)}`);
                       

        // If no items left → show empty cart message
        if ($(".cart-item").length === 0) {
            $(".cart-summary").remove();
            $("#cart .row").replaceWith(`
                <div class="empty-cart text-center p-4">
                    <p>🛒 Your cart is empty.</p>
                </div>
            `);
        }
    }

    // SweetAlert Helpers
    function showSuccessMessage(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
            timer: 2000,
            showConfirmButton: false
        });
    }

    function showErrorMessage(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        });
    }

    // Init on page load
    $(document).ready(function () {
        updateCartTotals();
    });
</script>




    
    
    
@endsection