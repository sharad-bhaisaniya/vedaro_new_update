@extends('layouts.main')
@section('title', 'Checkout')
@section('content')

<style>
    /* Base Styles */
    body {
        font-family: sans-serif;
        color: #0f2a1d;
        background-color: #f2ecdd;
        margin: 0;
        padding: 0;
    }

    .checkout-flow-container {
        display: flex;
        flex-direction: column;
        gap: 40px;
        padding: 40px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Media query for desktop layout */
    @media (min-width: 1024px) {
        .checkout-flow-container {
            flex-direction: row;
            justify-content: center;
        }

        .checkout-flow-summary,
        .checkout-flow-steps {
            flex: 1;
        }

        .checkout-flow-steps {
            max-width: 600px;
        }

        .checkout-flow-summary {
            max-width: 400px;
        }
    }

    .checkout-flow-summary {
        padding: 20px;
        border-radius: 10px;
    }

    .checkout-flow-summary h2 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 1.5rem;
    }

    .checkout-flow-product {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
    }

    .checkout-flow-product img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
    }

    .checkout-flow-details h4 {
        margin: 0;
        font-size: 1.1rem;
    }

    .checkout-flow-details .price {
        font-weight: bold;
        color: #0f2a1d;
    }

    .checkout-flow-details .old-price {
        text-decoration: line-through;
        color: #888;
        margin-left: 10px;
        font-size: 0.9rem;
    }

    .checkout-flow-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .checkout-flow-table td {
        padding: 12px 0;
        border-bottom: 1px solid #aaa;
    }

    .checkout-flow-table td:last-child {
        text-align: right;
    }

    .checkout-flow-table .total {
        font-weight: bold;
        font-size: 1.2rem;
        border-bottom: none;
    }

    /* Checkout Steps Section */
    .checkout-flow-steps {
        padding: 20px;
        border-radius: 10px;
    }

    .checkout-flow-step-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        font-weight: bold;
    }

    .checkout-flow-step-header span {
        color: #aaa;
        cursor: pointer;
    }

    .checkout-flow-step-header .active {
        color: #0f2a1d;
    }

    .checkout-flow-step-header .done {
        color: #0f2a1d;
    }

    .checkout-flow-step-header .done::after {
        content: "✔";
        margin-left: 5px;
        font-size: 14px;
        color: green;
    }

    .checkout-flow-section {
        display: none;
    }

    .checkout-flow-section.active {
        display: block;
    }

    /* Form and Buttons */
    .checkout-flow-section h3 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 1.3rem;
    }

    .checkout-flow-section input[type="text"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #0f2a1d;
        border-radius: 8px;
        box-sizing: border-box;
        background-color: #f2ecdd;
        color: #0f2a1d;
    }

    .checkout-form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
    }

    @media (min-width: 768px) {
        .checkout-form-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .checkout-flow-section label {
        display: block;
        margin-bottom: 15px;
    }

    .checkout-flow-btn-container {
        display: flex;
        justify-content: flex-end;
        width: 100%;
        margin-top: 20px;
    }

    .checkout-flow-btn {
        padding: 12px 30px;
        background-color: #0f2a1d;
        color: #f2ecdd;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .checkout-flow-btn:hover {
        background-color: #214d3c;
    }

    .checkout-flow-success {
        text-align: center;
        padding: 40px 20px;
    }

    .checkout-flow-success-icon {
        font-size: 4rem;
        color: green;
        margin-bottom: 15px;
    }

    .checkout-flow-success h2 {
        margin: 0 0 10px 0;
        font-size: 1.8rem;
    }

    .checkout-flow-success a {
        color: #0f2a1d;
        text-decoration: none;
        font-weight: bold;
    }
  .email-phone {
    width: 100%;
    padding: 12px 15px;
    font-size: 1rem;
    border: 1px solid #0f2a1d;
    border-radius: 8px;
    background-color: #f2ecdd;
    color: #0f2a1d;
    box-sizing: border-box;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.email-phone:focus {
    border-color: #214d3c;
    box-shadow: 0 0 0 3px rgba(33, 77, 60, 0.25);
    outline: none;
}

.product-tax {
    font-size: 0.73em;
    color: #555;
    margin-left: 10px;
}
</style>

<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>

<div class="checkout-flow-container">
    <div class="checkout-flow-summary">
        <h2>Order Summary</h2>
        <div class="order-summary">
            @php
                $calculatedSubtotal = 0;
                $cartItemsWithPrices = [];
            @endphp

            @foreach ($cartItems as $item)
                @php
                    $taxGroup = App\Models\TaxGroup::find($item->product->tax_rate);
                    $productTaxRate = 0;
                    if ($taxGroup) {
                        $productTaxRate = $taxGroup->taxes->sum('rate');
                    }
                    
                    // Handle variant products - get price based on size
                    $itemPrice = $item->product->discountPrice;
                    $originalPrice = $item->product->price;
                    $variantId = null;
                    
                    if ($item->product->product_type == 'variant' && $item->size) {
                        $variant = \App\Models\ProductVariant::where('product_id', $item->product->id)
                                                            ->where('size', $item->size)
                                                            ->first();
                        if ($variant) {
                            $itemPrice = $variant->discount_price;
                            $originalPrice = $variant->price;
                            $variantId = $variant->id;
                        }
                    }
                    
                    $itemTotal = $itemPrice * $item->product_qty;
                    $calculatedSubtotal += $itemTotal;
                    
                    // Store item with calculated prices for later use
                    $cartItemsWithPrices[] = [
                        'item' => $item,
                        'itemPrice' => $itemPrice,
                        'itemTotal' => $itemTotal,
                        'productTaxRate' => $productTaxRate,
                        'variantId' => $variantId
                    ];
                @endphp
                <div class="checkout-flow-product">
                    <img src="{{ asset('storage/products/' . $item->product->image1) }}" alt="{{ $item->product->name }}" class="product_image">
                    <div class="checkout-flow-details">
                        <h4>{{ $item->product->name }}</h4>
                        <p>Qty: {{ $item->product_qty }}</p>
                        <p>Size: {{ $item->size ?? "free"}}</p>
                        <div class="price-and-tax-container">
                            <span class="price">₹{{ number_format($itemTotal, 2) }}</span>
                            @if($productTaxRate > 0)
                                <span class="product-tax">(+ {{ $productTaxRate }}% Tax)</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            
            @php
                // Recalculate all totals based on actual variant prices
                $subtotal = $calculatedSubtotal;
                $totalAfterDiscount = $subtotal - $discountAmount;
                
                // Recalculate tax based on actual prices
                $totalTaxRate = 0;
                foreach ($cartItems as $item) {
                    $taxGroupId = $item->product->tax_rate;
                    $taxGroup = App\Models\TaxGroup::find($taxGroupId);
                    if ($taxGroup) {
                        $taxes = $taxGroup->taxes;
                        $itemTaxRate = $taxes->sum('rate');
                        $totalTaxRate += $itemTaxRate;
                    }
                }
                
                $taxAmount = ($totalAfterDiscount * $totalTaxRate) / 100;

                $totalShippingFee = 0;
                foreach ($cartItems as $item) {
                    $shippingFee = $item->product->shipping_fee ?? 0;
                    $totalShippingFee += $shippingFee;
                }

                $grandTotal = $totalAfterDiscount + $taxAmount + $totalShippingFee;
            @endphp
            
            <table class="checkout-flow-table">
                <thead>
                    <tr>
                        <td><b>Subtotal</b></td>
                        <td class="sub-total">₹{{ number_format($subtotal, 2) }}</td>
                    </tr>
                </thead>
                <tbody>
                    @if ($discountAmount > 0)
                    <tr>
                        <td><b>Coupon Discount ({{ $appliedCoupon }})</b></td>
                        <td>- ₹{{ number_format($discountAmount, 2) }}</td>
                    </tr>
                    @endif

                    <tr>
                        <td>Total GST</td>
                        <td>₹{{ number_format($taxAmount, 2) }}</td>
                    </tr>

                    <tr>
                        <td>Shipping</td>
                        @if ($totalShippingFee > 0)
                            <td>₹{{ number_format($totalShippingFee, 2) }}</td>
                        @else
                            <td>Free</td>
                        @endif
                    </tr>
                    
                    <tr>
                        <td><b>Total Due</b></td>
                        <td class="total">₹{{ number_format($grandTotal, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="checkout-flow-steps">
        <div class="checkout-flow-section active">
            <h3>Shipping Address</h3>
            <form id="checkout_form">
                @csrf

                <div class="checkout-form-grid">
                    <div class="form_group">
                        <label for="order_id">Order ID</label>
                        <input type="text" id="order_id" name="order_id" value="#MAHA-{{ Str::random(6) }}{{ $user->id }}" readonly required>
                    </div>
                    <div class="form_group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="{{ $user->first_name }} {{ $user->last_name }}" readonly required>
                    </div>
                    <div class="form_group">
                        <label for="email">Email</label>
                        <input type="email" class="email-phone" id="email" name="email" value="{{ $user->email }}" readonly required>
                    </div>
                    <div class="form_group">
                        <label for="phone">Phone*</label>
                        <input type="number" class="email-phone" id="phone" name="phone" value="{{ $user->phone }}" required>
                    </div>
                </div>

                @php
                    use Illuminate\Support\Facades\Auth;
                    use App\Models\Address;

                    $addresses = Address::where('user_id', Auth::id())->get();
                    $defaultAddress = $addresses->firstWhere('is_default', 1);
                @endphp

                <div class="form-group mb-3">
                    <label for="inputAddress">Address:</label>
                    <input type="text" name="address" id="address_field" class="form-control"
                        value="{{ $defaultAddress ? $defaultAddress->address : '' }}">
                </div>

                <div class="form-group mb-3">
                    <label for="inputCity">City:</label>
                    <input type="text" name="city" id="city_field" class="form-control"
                        value="{{ $defaultAddress ? $defaultAddress->city : '' }}">
                </div>

                <div class="form-group mb-3">
                    <label for="inputPincode">Pincode:</label>
                    <input type="text" name="pincode" id="postal_code_field" class="form-control"
                        value="{{ $defaultAddress ? $defaultAddress->pincode : '' }}">
                </div>

                <div class="form-group mb-3">
                    <label for="inputState">State:</label>
                    <input type="text" name="state" id="inputState" class="form-control"
                        value="{{ $defaultAddress ? $defaultAddress->state : '' }}">
                </div>
                
                {{-- Hidden fields with correct variant prices --}}
                @foreach($cartItemsWithPrices as $index => $cartItemData)
                    <input type="hidden" name="cartItems[{{ $index }}][product_id]" value="{{ $cartItemData['item']->product_id }}">
                    <input type="hidden" name="cartItems[{{ $index }}][quantity]" value="{{ $cartItemData['item']->product_qty }}">
                    <input type="hidden" name="cartItems[{{ $index }}][price]" value="{{ $cartItemData['itemPrice'] }}">
                    <input type="hidden" name="cartItems[{{ $index }}][size]" value="{{ $cartItemData['item']->size }}">
                    <input type="hidden" name="cartItems[{{ $index }}][variant_id]" value="{{ $cartItemData['variantId'] }}">
                    <input type="hidden" name="cartItems[{{ $index }}][tax_rate]" value="{{ $cartItemData['item']->product->tax_rate }}">
                    <input type="hidden" name="cartItems[{{ $index }}][shipping_fee]" value="{{ $cartItemData['item']->product->shipping_fee ?? 0 }}">
                @endforeach
                
                <input type="hidden" name="amount" value="{{ $grandTotal }}">
                <div class="checkout-flow-btn-container">
                    <button type="button" id="rzp-button" class="checkout-flow-btn update-cart">
                        Pay with Razorpay ₹{{ number_format($grandTotal, 2) }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('rzp-button').addEventListener('click', async function() {
        document.getElementById('loadingOverlay').style.display = 'flex';
        
        if (!validateForm()) {
            alert('Please fill all required fields marked with *');
            document.getElementById('loadingOverlay').style.display = 'none';
            return;
        }

        const formData = {
            order_id: document.getElementById('order_id').value,
            amount: '{{ $grandTotal }}',
            phone: document.getElementById('phone').value,
            address: document.getElementById('address_field').value,
            city: document.getElementById('city_field').value,
            postal_code: document.getElementById('postal_code_field').value,
            cartItems: [],
            _token: '{{ csrf_token() }}'
        };

        document.querySelectorAll('input[name^="cartItems"]').forEach(input => {
            const match = input.name.match(/cartItems\[(\d+)\]\[(\w+)\]/);
            if (match) {
                const index = match[1];
                const field = match[2];
                if (!formData.cartItems[index]) {
                    formData.cartItems[index] = {};
                }
                formData.cartItems[index][field] = input.value;
            }
        });

        try {
            const response = await fetch("{{ route('razorpay.initiate') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                throw new Error(`Server responded with ${response.status}: ${text}`);
            }

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || 'Payment initialization failed');
            }

            const options = {
                key: data.key,
                amount: data.amount,
                currency: data.currency,
                order_id: data.razorpay_order_id,
                name: "Vedaro",
                description: "Order #" + formData.order_id,
                prefill: {
                    name: document.getElementById('full_name').value,
                    email: document.getElementById('email').value,
                    contact: formData.phone
                },
                notes: {
                    address: formData.address
                },
                handler: async function(response) {
                    try {
                        const verificationData = {
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_signature: response.razorpay_signature,
                            order_id: formData.order_id,
                            amount: formData.amount,
                            phone: formData.phone,
                            address: formData.address,
                            city: formData.city,
                            postal_code: formData.postal_code,
                            cartItems: formData.cartItems,
                            _token: '{{ csrf_token() }}'
                        };

                        const verifyResponse = await fetch("{{ route('razorpay.verify') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(verificationData)
                        });

                        const verifyData = await verifyResponse.json();

                        if (verifyData.success) {
                            window.location.href = "{{ route('thanku') }}?order_id=" + verifyData.order_id;
                        } else {
                            throw new Error(verifyData.message || 'Payment verification failed');
                        }
                    } catch (error) {
                        console.error('Verification error:', error);
                        alert('Payment verification failed: ' + error.message);
                        document.getElementById('loadingOverlay').style.display = 'none';
                    }
                },
                theme: {
                    color: "#F37254"
                },
                modal: {
                    ondismiss: function() {
                        document.getElementById('loadingOverlay').style.display = 'none';
                    }
                }
            };

            const rzp = new Razorpay(options);
            rzp.open();
        } catch (error) {
            console.error('Payment error:', error);
            alert('Payment failed: ' + error.message);
            document.getElementById('loadingOverlay').style.display = 'none';
        }
    });

    function validateForm() {
        const requiredFields = [
            'phone',
            'address_field',
            'city_field',
            'postal_code_field'
        ];
        return requiredFields.every(id => {
            const field = document.getElementById(id);
            return field && field.value.trim() !== '';
        });
    }
</script>
@endsection