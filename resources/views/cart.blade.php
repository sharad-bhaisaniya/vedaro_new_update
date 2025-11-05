@extends('layouts.main')

@section('title', 'Cart')

@section('content')

<style>
                .row1 {
                display: flex;
                justify-content: space-between;
                gap: 20px;
                flex-wrap: wrap;
                }

                /* Left side */
                .left-side {
                flex: 1 1 65%; /* Adjusted for better layout */
                min-width: 300px;
                }

                /* Right side */
                .right-side {
                flex: 1 1 30%;
                min-width: 280px;
                }

                /* Product image */
                .product-img {
                width: 120px;
                height: 120px;
                object-fit: cover;
                }

                .recommend-section .row {
                    display: grid;
                    grid-template-columns: repeat(8, 1fr);
                    gap: 12px;
                }

                .box-item{
                    width:100%;
                }

                .cardItem {
                border: 2px solid #ccc;   
                border-radius: 8px;      
                background-color:transparent;  
                padding:20px;
                margin: 20px 0;
                }

                /* New Styles for coupon and total sections */
                .coupon-section {
                    display: flex;
                    margin-top: 15px;
                }

                .coupon-section input {
                    flex-grow: 1;
                    border-radius: 4px 0 0 4px;
                }

                .coupon-section button {
                    border-radius: 0 4px 4px 0;
                    background-color: #1a3c2d;
                    color: white;
                    border: 1px solid #1a3c2d;
                }

                .summary-details {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 10px;
                }

                .summary-details.total {
                    font-weight: bold;
                    font-size: 1.1em;
                }

                .quantity-control {
                    display: flex;
                    align-items: center;
                }

                .quantity-control button {
                    width: 30px;
                    height: 30px;
                    background-color: transparent;
                    border: 1px solid #ccc;
                    font-size: 16px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                }

                .quantity-control input {
                    width: 40px;
                    text-align: center;
                    border: 1px solid #ccc;
                    height: 30px;
                }

                .quantity-control button.plus {
                    background-color: #1a3c2d;
                    color: white;
                }

                .product-info-new {
                    display: flex;
                    align-items: center;
                    flex-wrap: wrap;
                    gap: 15px;
                }

                .remove-item-new {
                    border: none;
                    background-color: transparent;
                    color: #ff0000;
                    cursor: pointer;
                }


                /* Mobile responsive */
                @media (max-width: 992px) {
                .row1 {
                    flex-direction: column;
                }
                .left-side,
                .right-side {
                    flex: 1 1 100%;
                }
                }


                @media (max-width: 1000px) {
                    .recommend-section .row {
                        grid-template-columns: repeat(4, 1fr);
                    }
                }
                @media (max-width: 768px) {
                    .recommend-section .row {
                        grid-template-columns: repeat(3, 1fr);
                    }
                }


                @media (max-width: 500px) {
                    .recommend-section .row {
                        grid-template-columns: repeat(2, 1fr);
                    }
                }

                .free_gift {
                    font-size: 1em;
                    color: #ff6600;
                    font-weight: bold;
                    animation: congrats-animation 2s ease-in-out infinite, bounce 1.5s ease-in-out infinite;
                }

                @keyframes congrats-animation {
                    0% { transform: translateY(0); color: #ff6600; }
                    25% { transform: translateY(-5px); color: #ff3366; }
                    50% { transform: translateY(0); color: #33cc33; }
                    75% { transform: translateY(-5px); color: #ff3366; }
                    100% { transform: translateY(0); color: #ff6600; }
                }

                @keyframes bounce {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-5px); }
                }
                
                
                .suggest-anchor{
                    color: black;
                    text-decoration: none;
                }

</style>


<div class="container my-5">
    <h3 class="mb-4">My Cart</h3>




<div class="row1">

<div class="left-side">
    {{-- Success & Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
    $isLoggedIn = auth()->check();
    $cartItemsData = $isLoggedIn ? $cartItems : session('cart', []);
    @endphp

    {{-- ✅ YEH NAYA SUBTOTAL CALCULATION ADD KAREN --}}
    @php
    // Calculate subtotal properly including variant products
    $subtotal = 0;
    $hasVariantProducts = false;

    foreach($cartItemsData as $item) {
        $product = $isLoggedIn ? $item->product : \App\Models\Product::find($item['product_id']);
        $quantity = $isLoggedIn ? $item->product_qty : $item['product_qty'];
        
        if($product) {
            if($product->product_type == 'variant') {
                $hasVariantProducts = true;
                $size = $isLoggedIn ? ($item->size ?? null) : ($item['size'] ?? null);
                $variantId = $isLoggedIn ? ($item->variant_id ?? null) : ($item['variant_id'] ?? null);
                
                // Find variant price using same logic as display
                $variant = null;
                if($variantId) {
                    $variant = \App\Models\ProductVariant::find($variantId);
                } else if($size) {
                    $variant = \App\Models\ProductVariant::where('product_id', $product->id)
                                                        ->where('size', $size)
                                                        ->first();
                } else {
                    $variant = \App\Models\ProductVariant::where('product_id', $product->id)->first();
                }
                
                if($variant) {
                    $subtotal += $variant->discount_price * $quantity;
                } else {
                    // Fallback to product price if variant not found
                    $subtotal += $product->discountPrice * $quantity;
                }
            } else {
                // Simple product
                $subtotal += $product->discountPrice * $quantity;
            }
        }
    }

    // Free gift product
    $giftProduct = \App\Models\GiftProduct::where('is_active', true)->first();
    $total = $subtotal;
    @endphp

    @if(!empty($cartItemsData) && count($cartItemsData) > 0)
        @foreach($cartItemsData as $item)
            @php
                $product = $isLoggedIn ? $item->product : \App\Models\Product::find($item['product_id']);
                $quantity = $isLoggedIn ? $item->product_qty : $item['product_qty'];
                $size = $isLoggedIn ? ($item->size ?? null) : ($item['size'] ?? null);

                $displayPrice = $product->discountPrice;
                $originalPrice = $product->price;
                $variantName = null;
                $variantId = null;

                if($product && $product->product_type == 'variant'){
                    // For variant products, find the exact variant based on size
                    $variantId = $isLoggedIn ? ($item->variant_id ?? null) : ($item['variant_id'] ?? null);
                    
                    if($size && !$variantId) {
                        // If we have size but no variant ID, find the variant by product_id and size
                        $variant = \App\Models\ProductVariant::where('product_id', $product->id)
                                                            ->where('size', $size)
                                                            ->first();
                    } else {
                        // Otherwise use the variant ID or get first variant
                        $variant = $variantId 
                                    ? \App\Models\ProductVariant::find($variantId) 
                                    : \App\Models\ProductVariant::where('product_id', $product->id)->first();
                    }

                    if($variant){
                        $displayPrice = $variant->discount_price;
                        $originalPrice = $variant->price;
                        $variantName = $variant->size ?? $variant->name;
                        $variantId = $variant->id;
                    }
                }
                
                // Generate unique identifier for this cart item
                $itemIdentifier = $isLoggedIn ? $item->id : ($product->id . '-' . ($size ?? 'default'));
            @endphp

            @if($product)
                <div class="cardItem cart-item" data-id="{{ $isLoggedIn ? $item->id : $itemIdentifier }}" data-product-id="{{ $product->id }}" data-size="{{ $size }}" data-variant-id="{{ $variantId }}">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="product-info-new">
                            <img src="{{ asset('storage/products/' . $product->image1) }}" 
                                 class="rounded me-3 product-img" 
                                 alt="{{ $product->productName ?? $product->product_name }}"/>
                            <div>
                                <h6 class="mb-1 product-name">
                                    {{ $product->productName ?? $product->product_name }}
                                    @if($variantName) 
                                        ({{ $variantName }})
                                    @elseif($size)
                                        (Size: {{ $size }})
                                    @endif
                                </h6>
                                <p class="mb-1 fw-bold product-price">₹{{ number_format($displayPrice, 2) }}</p>
                                @if($originalPrice != $displayPrice)
                                    <small class="text-muted"><s>₹{{ number_format($originalPrice, 2) }}</s></small>
                                @endif
                
                                {{-- Quantity controls --}}
                                <div class="quantity-control mt-2">
                                    <button class="btn btn-outline-secondary minus-btn" type="button">-</button>
                                    <input type="text" class="form-control text-center bg-transparent quantity-input" 
                                           value="{{ $quantity }}" min="1" 
                                           data-id="{{ $isLoggedIn ? $item->id : $itemIdentifier }}"
                                           data-product-id="{{ $product->id }}"
                                           data-size="{{ $size }}"
                                           data-variant-id="{{ $variantId }}">
                                    <button class="btn btn-outline-secondary plus-btn" type="button">+</button>
                                </div>

                                {{-- Gift wrap --}}
                                @if($product->product_type == 'simple')
                                <div class="form-check mt-2">
                                    <input class="form-check-input gift-wrap-checkbox" 
                                           type="checkbox" 
                                           id="gift-{{ $isLoggedIn ? $item->id : $itemIdentifier }}" 
                                           data-gift-wrap-cost="150"
                                           data-product-id="{{ $product->id }}"
                                           data-variant-id=""
                                           data-item-id="{{ $isLoggedIn ? $item->id : $itemIdentifier }}">
                                    <label class="form-check-label small" 
                                           for="gift-{{ $isLoggedIn ? $item->id : $itemIdentifier }}">
                                        Add a Gift Wrap and a message (+₹150)
                                    </label>
                                </div>
                                @elseif($product->product_type == 'variant' && $variantId)
                                <div class="form-check mt-2">
                                    <input class="form-check-input gift-wrap-checkbox" 
                                           type="checkbox" 
                                           id="gift-{{ $isLoggedIn ? $item->id : $itemIdentifier }}" 
                                           data-gift-wrap-cost="150"
                                           data-product-id="{{ $product->id }}"
                                           data-variant-id=""
                                           data-item-id="{{ $isLoggedIn ? $item->id : $itemIdentifier }}">
                                    <label class="form-check-label small" 
                                           for="gift-{{ $isLoggedIn ? $item->id : $itemIdentifier }}">
                                        Add a Gift Wrap and a message (+₹150)
                                    </label>
                                </div>
                                @endif
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-danger mt-2 mt-md-0 remove-item-btn" 
                                data-id="{{ $isLoggedIn ? $item->id : $itemIdentifier }}"
                                data-product-id="{{ $product->id }}"
                                data-size="{{ $size }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Free gift product for orders above 1000 --}}
        @if($subtotal > 1000 && isset($giftProduct))
            <div class="cardItem free-gift-item" id="free-gift-product">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="product-info-new">
                        <img src="{{ asset('storage/products/' . $giftProduct->product_image1) }}" 
                             class="rounded me-3 product-img" 
                             alt="{{ $giftProduct->productName }}"/>
                        <div>
                            <h6 class="mb-1">{{ $giftProduct->productName }}</h6>
                            <p class="mb-1 fw-bold free_gift">Free Gift</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @else
        <div class="alert alert-info text-center">Your cart is empty.</div>
    @endif
</div>

    <div class="right-side">
        <div class="cardItem">
            <h6 class="mb-3">Order Summary:</h6>
            <div class="summary-breakdown"></div>
            <div class="summary-details border-top pt-2 mt-2">
                <span>Subtotal:</span>
                <span id="summary-subtotal">₹{{ number_format($subtotal, 2) }}</span>
            </div>
        
            <div class="summary-details coupon-discount" style="display:none;">
                <span>Discount:</span>
                <span id="summary-discount">₹0.00</span>
            </div>
            <div class="summary-details total fw-bold">
                <span>Estimated total:</span>
                <span id="summary-total">₹{{ number_format($total, 2) }}</span>
            </div>
            <div class="coupon-section mt-3">
                <input type="text" name="coupon_code" id="coupon-code" class="form-control" placeholder="Enter Coupon Code">
                <button class="btn apply-coupon">Apply</button>
            </div>
            <a href="/checkout" class="btn btn-success w-100 mt-3">
                <i class="fas fa-lock"></i> Checkout Securely
            </a>
        </div>
    </div>
</div>


    
    <div class="recommend-section mt-5">
      <h5 class="mb-3">Don’t Miss Out</h5>
    @php
    $products = App\Models\Product::where('add_timer', 1)
            ->inRandomOrder()
            ->take(6)
            ->get();

@endphp

<div class="row g-3">
    @foreach ($products as $product)
        @php
            // If product type is 'variant', get its variants
            $variants = $product->product_type === 'variant'
                ? App\Models\ProductVariant::where('product_id', $product->id)->get()
                : collect();

            $firstVariant = $variants->first();
        @endphp

        <div class="col-6 col-md-3 box-item">
            <a href="{{ route('product.details', $product->productName) }}" class="suggest-anchor text-decoration-none">
                <div class="small-card">
                    <img 
                        src="{{ asset('storage/products/' . $product->image1) }}" 
                        class="card-img-top rounded mb-2" 
                        alt="{{ $product->productName }}"
                    >

                    <p class="mb-1 small">{{ $product->productName }}</p>

                    {{-- ✅ Price logic --}}
                    @if($product->product_type === 'variant' && $firstVariant)
                        <p class="fw-bold small mb-0">
                            ₹{{ number_format($firstVariant->discount_price ?? 0, 2) }}
                        </p>
                        @if($firstVariant->price > $firstVariant->discount_price)
                            <p class="text-muted small mb-0">
                                <s>₹{{ number_format($firstVariant->price, 2) }}</s>
                            </p>
                        @endif
                    @else
                        <p class="fw-bold small mb-0">
                            ₹{{ number_format($product->discountPrice ?? $product->price ?? 0, 2) }}
                        </p>
                        @if(!empty($product->old_price) && $product->old_price > ($product->discountPrice ?? $product->price))
                            <p class="text-muted small mb-0">
                                <s>₹{{ number_format($product->old_price, 2) }}</s>
                            </p>
                        @endif
                    @endif
                </div>
            </a>
        </div>
    @endforeach
</div>


        
      </div>
    </div>
</div>

<div id="success-message" style="display: none; font-weight: 500; position: fixed; padding: 5px 19px; color: #fff; background: #8BC34A; border-radius: 5px; z-index: 1; bottom: 25px; right: 25px;"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    $(document).ready(function () {
        let currentDiscount = 0;
        let appliedCouponCode = '';
        const GIFT_WRAP_COST = 150;

        // -------- Update Cart Totals -------- //
        function updateCartTotals() {
            let subtotal = 0;
            let totalGiftWrapCost = 0;

            // Clear previous summary items
            $('.summary-breakdown').empty();

            // Calculate subtotal
            $(".cart-item").each(function () {
                const item = $(this);
                const quantity = parseInt(item.find(".quantity-input").val()) || 0;
                const price = parseFloat(item.find(".product-price").text().replace(/[₹,]/g, "")) || 0;
                const productName = item.find(".product-name").text();
                const rowSubtotal = quantity * price;

                subtotal += rowSubtotal;

                // Gift wrap
                if (item.find('.gift-wrap-checkbox').is(':checked')) {
                    totalGiftWrapCost += GIFT_WRAP_COST;
                }

                // Add item in summary
                $('.summary-breakdown').append(`
                    <div class="d-flex justify-content-between mb-2">
                        <span>${productName}</span>
                        <span>₹${rowSubtotal.toFixed(2)}</span>
                    </div>
                `);
            });

            // Shipping (example: free > 1000)
            let shippingCost = (subtotal > 1000) ? 0 : 0;
            let totalBeforeDiscount = subtotal + shippingCost + totalGiftWrapCost;
            let total = totalBeforeDiscount - currentDiscount;

            // ---------- Free Gift Logic (AJAX) ---------- //
            if (subtotal > 1000) {
                if (!$("#free-gift-product").length) {
                    $.ajax({
                        url: "/cart/free-gift",
                        method: "POST",
                        data: { _token: "{{ csrf_token() }}" },
                        success: function (response) {
                            if (response.success && response.html) {
                                $(".left-side").append(response.html);
                            }
                        }
                    });
                }
            } else {
                $("#free-gift-product").remove();
            }

            // ---------- Update DOM ---------- //
            $("#summary-subtotal").text(`₹${subtotal.toFixed(2)}`);
            $("#summary-shipping").text(`₹${shippingCost.toFixed(2)}`);

            if (totalGiftWrapCost > 0) {
                if ($('#gift-wrap-summary').length === 0) {
                    $('.summary-breakdown').after(`
                        <div class="summary-details" id="gift-wrap-summary">
                            <span>Gift Wrap:</span>
                            <span>₹${totalGiftWrapCost.toFixed(2)}</span>
                        </div>
                    `);
                } else {
                    $('#gift-wrap-summary span:last').text(`₹${totalGiftWrapCost.toFixed(2)}`);
                }
            } else {
                $('#gift-wrap-summary').remove();
            }

            if (currentDiscount > 0) {
                $(".coupon-discount").show();
                $("#summary-discount").text(`-₹${currentDiscount.toFixed(2)}`);
            } else {
                $(".coupon-discount").hide();
            }

            $("#summary-total").text(`₹${total.toFixed(2)}`);

            // ---------- Update Total in DB ---------- //
            $.ajax({
                url: "/cart/update-total",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    total: total,
                    discount: currentDiscount,
                    coupon_code: appliedCouponCode
                },
                success: function (response) {
                    if (response.success) {
                        console.log("Cart total updated successfully.");
                    }
                },
            });
        }

        // -------- Success Message -------- //
        function showSuccessMessage(message) {
            const successMessageDiv = $("#success-message");
            successMessageDiv.text(message).fadeIn().delay(3000).fadeOut();
        }

        // -------- Quantity Input -------- //
        $(document).on("input", ".quantity-input", function () {
            const id = $(this).data("id");
            const quantity = parseInt($(this).val()) || 0;

            if (quantity < 1) {
                $(this).val(1);
                return;
            }

            const item = $(this).closest(".cart-item");
            const price = parseFloat(item.find(".product-price").text().replace(/[₹,]/g, "")) || 0;
            const productSubtotal = price * quantity;

            updateCartTotals();

            $.ajax({
                url: "/cart/update",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    quantity: quantity,
                    subtotal: productSubtotal
                },
                success: function (response) {
                    if (!response.success) {
                        showSuccessMessage(response.message);
                    }
                },
            });
        });

        // -------- Plus / Minus -------- //
        $(document).on('click', '.plus-btn', function () {
            const input = $(this).siblings('.quantity-input');
            input.val(parseInt(input.val()) + 1).trigger('input');
        });

        $(document).on('click', '.minus-btn', function () {
            const input = $(this).siblings('.quantity-input');
            let currentVal = parseInt(input.val());
            if (currentVal > 1) {
                input.val(currentVal - 1).trigger('input');
            }
        });

        // -------- Gift Wrap -------- //
        $(document).on('change', '.gift-wrap-checkbox', function () {
            updateCartTotals();
        });

        // -------- Apply Coupon -------- //
        $(".apply-coupon").on("click", function () {
            const couponCode = $("#coupon-code").val().trim();

            if (!couponCode) {
                showSuccessMessage("Please enter a coupon code");
                return;
            }

            $.ajax({
                url: "/cart/apply-coupon",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    coupon_code: couponCode
                },
                success: function (response) {
                    if (response.success) {
                        currentDiscount = parseFloat(response.discount) || 0;
                        appliedCouponCode = couponCode;

                        $("#summary-discount").text(`-₹${currentDiscount.toFixed(2)}`);
                        $(".coupon-discount").show();

                        // Server se total overwrite
                        $("#summary-total").text(`₹${response.total.toFixed(2)}`);

                        showSuccessMessage(response.message);
                    } else {
                        currentDiscount = 0;
                        appliedCouponCode = '';
                        $(".coupon-discount").hide();
                        showSuccessMessage(response.message);
                        updateCartTotals();
                    }
                },
                error: function () {
                    currentDiscount = 0;
                    appliedCouponCode = '';
                    $(".coupon-discount").hide();
                    showSuccessMessage("Error applying coupon. Please try again.");
                    updateCartTotals();
                }
            });
        });

        // -------- Remove Item -------- //
      $(document).on("click", ".remove-item-btn", function () {
    const id = $(this).data("id");
    const variant_id = $(this).data("variant-id"); // get variant id if exists
    const itemRow = $(this).closest(".cart-item");

    itemRow.fadeOut(300, function () {
        $(this).remove();
        updateCartTotals();
    });

    $.ajax({
        url: "/cart/remove",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: id,
            variant_id: variant_id // send variant_id
        },
        success: function (response) {
            if (response.success) {
                showSuccessMessage("Item removed from cart!");
                
                // update header counter
                $("#cart_counter").text(response.count);
                if (response.count <= 0) {
                    $("#cart_counter").hide();
                } else {
                    $("#cart_counter").show();
                }
            } else {
                showSuccessMessage(response.message);
            }
        },
    });
});

        // -------- Init on Page Load -------- //
        updateCartTotals();
    });
</script>

@endsection