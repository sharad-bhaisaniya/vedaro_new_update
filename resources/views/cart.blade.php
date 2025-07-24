@extends('layouts.main')

@section('title', 'Cart')

@section('content')
<style>
    .table_header{
        border-bottom: 1px solid #ddd;
        border-top: 1px solid #ddd;
        padding: 10px 0;
        margin: 20px 0;
        color: #333;
    }
    table{
        box-shadow: none !important;
    }
    tbody, td, tfoot, th, thead, tr{
        border: none !important;
    }
    thead{
        display: none !important;
    }
    body{
        background: #FCFAF6;
    }
    .cart-page-one{
        margin-top:100px;
    }
    	#success-message{
		display: none;
    font-weight: 500;
    position: fixed;
    padding: 5px 19px;
    color: #fff;
    background: #8BC34A;
    border-radius: 5px;
	z-index: 1;
	bottom: 25px;
	right: 25px;
	}
	.remove-item{
	        border: 1px solid #ff0000c4;
    padding: 3px 6px;
    background: transparent;
    color: #ff0000a1;
    border-radius: 50px;
    cursor: pointer;
	}

    .free_gift {
        font-size: 22px;
        color: #ff6600; /* Orange color for a celebratory look */
        text-align: center;
        display: inline-block;
        border-radius: 5px;
        animation: congrats-animation 2s ease-in-out infinite, bounce 1.5s ease-in-out infinite;
    }
    .proceed ,  .coupon{
        background: #2D3748;
        transition: all .5s ease-in-out;
        
    }
    .proceed:hover ,  .coupon:hover{
        background: #6B46C1;
    }


    /* Congrats Animation - Initial Bounce */
    @keyframes congrats-animation {
        0% {
            transform: translateY(0);
            color: #ff6600;
            text-shadow: none;
        }
        25% {
            transform: translateY(-10px);
            color: #ff3366;
            text-shadow: 0 0 10px rgba(255, 51, 102, 0.7);
        }
        50% {
            transform: translateY(0);
            color: #33cc33;
            text-shadow: 0 0 15px rgba(51, 204, 51, 0.7);
        }
        75% {
            transform: translateY(-10px);
            color: #ff3366;
            text-shadow: 0 0 10px rgba(255, 51, 102, 0.7);
        }
        100% {
            transform: translateY(0);
            color: #ff6600;
            text-shadow: none;
        }
    }

    /* Bounce Animation - Enhances Celebration Effect */
    @keyframes bounce {
        0% {
            transform: translateY(0);
        }
        25% {
            transform: translateY(-10px);
        }
        50% {
            transform: translateY(0);
        }
        75% {
            transform: translateY(-10px);
        }
        100% {
            transform: translateY(0);
        }
    }

</style>

<!-- <div class="sect_head">
    <h3>Cart</h3>
</div> -->

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="cart-page cart-page-one" style="    margin-top: 150px;">
<h1 class="h1">Cart</h1>

    @if(Auth::check()) <!-- User is logged in -->
        @if ($cartItems->isNotEmpty())
        
            <div class="cart-container">
<p class="table_header">Congratulations, your order qualifies for free shipping</p>

                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--@foreach ($cartItems as $item)-->
                        <!--    <tr>-->
                        <!--        <td class="product-info">-->
                        <!--            <img src="{{ asset('storage/products/' . $item->product->image1) }}" class="img-fluid" alt="{{ $item->product->productName }}">-->
                        <!--            <p>{{ $item->product->productName }}</p>-->
                        <!--            <p class="price">₹{{ number_format($item->product->discountPrice , 2) }}</p>-->
                        <!--        </td>-->
                                
                        <!--        <td class="quantity">-->
                        <!--            <input type="number" value="{{ $item->product_qty }}" min="1" data-id="{{ $item->id }}">-->
                        <!--        </td>-->
                        <!--        <td class="subtotal-amount" id="subtotal-{{ $item->id }}">₹{{ number_format($item->product->discountPrice  * $item->product_qty, 2) }}</td>-->
                        <!--        <td class="remove">-->
                        <!--            <button class="remove-item" data-id="{{ $item->id }}"><i class="fas fa-times"></i></button>-->
                        <!--        </td>-->
                        <!--    </tr>-->
                        <!--@endforeach-->
                        @foreach ($cartItems as $item)
                        @php
                            $product = is_array($item) ? ($item['product'] ?? null) : ($item->product ?? null);
                            $qty = is_array($item) ? $item['product_qty'] : $item->product_qty;
                        @endphp
                    
                        <tr>
                            <td class="product-info">
                                @if ($product)
                                    <img src="{{ asset('storage/products/' . $product->image1) }}" class="img-fluid" alt="{{ $product->productName }}">
                                    <p>{{ $product->productName }}</p>
                                    <p class="price">₹{{ number_format($product->discountPrice, 2) }}</p>
                                     <td class="quantity">
                                    <input type="number" value="{{ $item->product_qty }}" min="1" data-id="{{ $item->id }}">
                                </td>
                                <td class="subtotal-amount" id="subtotal-{{ $item->id }}">₹{{ number_format($item->product->discountPrice  * $item->product_qty, 2) }}</td>
                                <td class="remove">
                                    <button class="remove-item" data-id="{{ $item->id }}"><i class="fas fa-times"></i></button>
                                </td>
                                @else
                                    <p class="text-danger">Product not available</p>
                                @endif
                            </td>
                            @endforeach
                    </tbody>
                </table>
                <!--<button class="update-cart">Update Cart</button>-->
            </div>
        @else
            <p style="text-align: center;">Your cart is empty.</p>
        @endif
    @else <!-- User is not logged in -->
        <p style="text-align: center;">Your cart is saved in session. <br> Please <a href="/login">log in</a> to view your cart.</p>
        
        @php
            // For guest users, fetch the session cart items
            $guestCart = Session::get('cart', []);
        @endphp
        
        @if (!empty($guestCart))
            <div class="cart-container">
<p class="table_header">Congratulations, your order qualifies for free shipping</p>

                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guestCart as $item)
                            @php
                                $product = App\Models\Product::find($item['product_id']);
                            @endphp
                            @if ($product)
                                <tr>
                                    <td class="product-info">
                                        <img src="{{ asset('storage/products/' . $product->image1) }}" class="img-fluid" alt="{{ $product->productName }}">
                                        <div>
                                            <p>{{ $product->productName }}</p>
                                            <p class="price">₹{{ number_format($product->discountPrice , 2) }}</p>
                                            <p>Metal: White Gold</p>
                                        </div>
                                    </td>
                                    <td class="quantity">
                                        <input type="number" value="{{ $item['product_qty'] }}" min="1" data-id="{{ $item['product_id'] }}">
                                    </td>
                                    <td class="subtotal-amount" id="subtotal-{{ $item['product_id'] }}">₹{{ number_format($product->price * $item['product_qty'], 2) }}</td>
                                    <td class="remove">
                                        <button class="remove-item" data-id="{{ $item['product_id'] }}"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center;">Your cart is empty.</p>
        @endif
    @endif
</div>

<!-- Coupon section -->
<div class="cart-page">
    <div class="coupon-section">
        <label for="coupon-code">Coupon:</label>
        <input type="text" id="coupon-code" placeholder="Enter Coupon Code">
        <button class="apply-coupon coupon">Apply Coupon</button>
    </div>
</div>

<!-- Cart totals -->
<div class="cart-page">
    <div class="cart-totals">
        <h3>Cart totals</h3>
        <p class="subtotal_l">
            <span>Subtotal</span>
            <span class="subtotal-amount" id="subtotal-amount">₹{{ number_format($subtotal, 2) }}</span>
        </p>
        <div class="subtotal_l">
            <span>Shipping</span>
            <div>
                <span id="shipping-cost">Flat Rate: ₹{{ number_format($shippingCost, 2) }}</span>
            </div>
        </div>
        <div class="subtotal_l">
            <span style="font-weight:600;">Total</span>
            <div>
                <span id="total-amount" style="font-weight:600;">₹{{ number_format($total, 2) }}</span>
            </div>
        </div>
    </div>
    <a href="/checkout" class="apply-coupon proceed">Proceed To Checkout</a>
</div>


	<!-- Success Message Div -->
	<div id="success-message" style=""></div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
    const shippingCost = 0; // Update with dynamic shipping if needed

    function updateCartTotals() {
        let subtotal = 0;

        $(".cart-table tbody tr").each(function () {
            const qty = parseFloat($(this).find(".quantity input").val()) || 0;
            const price = parseFloat($(this).find(".price").text().replace(/[₹,]/g, "")) || 0;
            const rowSubtotal = qty * price;

            $(this).find(".subtotal-amount").text(`₹${rowSubtotal.toFixed(2)}`);
            subtotal += rowSubtotal;
        });

        let total = subtotal + shippingCost;

        if (total > 1000 && !$("#free-gift-product").length) {
            addFreeGift();
        } else if (total <= 1000 && $("#free-gift-product").length) {
            removeFreeGift();
        }

        $("#subtotal-amount").text(`₹${subtotal.toFixed(2)}`);
        $("#shipping-cost").text(`Flat Rate: ₹${shippingCost.toFixed(2)}`);
        $("#total-amount").text(`₹${total.toFixed(2)}`);

        $.ajax({
            url: "/cart/update-total",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                total: total
            },
            success: function (response) {
                if (response.success) {
                    console.log("Cart total updated successfully in the database.");
                }
            },
        });
    }

    function addFreeGift() {
        const freeGiftHTML = `
            <tr id="free-gift-product">
                <td class="product-info">
                    <img src="assets/images/Kuber_7.webp" class="img-fluid" alt="Free Gift">
                    <p class="free_gift">Free Gift</p>
                </td>
                <td class="price">₹0.00</td>
                <td class="quantity">1</td>
                <td class="subtotal-amount">₹0.00</td>
                <td class="remove">
                    <button class="remove-item" disabled><i class="fas fa-times"></i></button>
                </td>
            </tr>
        `;
        $(".cart-table tbody").append(freeGiftHTML);
        showSuccessMessage("Free gift has been added to your cart.");
    }

    function removeFreeGift() {
        $("#free-gift-product").fadeOut(300, function () {
            $(this).remove();
        });
        showSuccessMessage("Free gift has been removed from your cart.");
    }

    function showSuccessMessage(message) {
        const successMessageDiv = $("#success-message");
        successMessageDiv.text(message).fadeIn().delay(3000).fadeOut();
    }

    $(".quantity input").on("input", function () {
        const id = $(this).data("id");
        const quantity = parseFloat($(this).val()) || 0;
        const price = parseFloat($(this).closest("tr").find(".price").text().replace('₹', '').replace(',', '')) || 0;
        const productSubtotal = price * quantity;

        $(`#subtotal-${id}`).text(`₹${productSubtotal.toFixed(2)}`);
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
                if (response.success) {
                    console.log("Product quantity and subtotal updated successfully.");
                } else {
                    showSuccessMessage(response.message);
                }
            },
        });
    });

    $(".apply-coupon").on("click", function () {
        const couponCode = $("#coupon-code").val();

        $.ajax({
            url: "/cart/apply-coupon",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                coupon_code: couponCode
            },
            success: function (response) {
                if (response.success) {
                    showSuccessMessage("Coupon applied successfully!");

                    let subtotal = 0;
                    $(".quantity input").each(function () {
                        const qty = parseFloat($(this).val()) || 0;
                        const price = parseFloat($(this).closest("tr").find(".price").text().replace('₹', '').replace(',', '')) || 0;
                        subtotal += qty * price;
                    });

                    const discount = response.discount || 0;
                    const discountedTotal = subtotal - discount + shippingCost;

                    $(".subtotal-amount").text(`₹${subtotal.toFixed(2)}`);
                    $("#shipping-cost").text(`Flat Rate: ₹${shippingCost.toFixed(2)}`);
                    $("#total-amount").text(`₹${discountedTotal.toFixed(2)}`);

                    $.ajax({
                        url: "/cart/update-total",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            total: discountedTotal
                        },
                        success: function (response) {
                            if (response.success) {
                                console.log("Total updated in the backend successfully");
                            }
                        }
                    });
                } else {
                    showSuccessMessage(response.message);
                }
            },
        });
    });

    $(".remove-item").on("click", function () {
        const id = $(this).data("id");
        const itemRow = $(this).closest("tr");

        itemRow.fadeOut(300, function () {
            itemRow.remove();
            updateCartTotals();
        });

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
                } else {
                    showSuccessMessage(response.message);
                }
            },
        });
    });

    updateCartTotals();
});

</script>


@endsection



