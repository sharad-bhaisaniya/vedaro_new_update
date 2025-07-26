@extends('layouts.main')
@section('title', 'Checkout')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .check_fl {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }

    .check_fl .form_group {
        width: 49%;
    }

    .checkout_fst {
        width: 70%;
        /*background: #f6f6f6cc;*/
        padding: 20px;
        border-radius: 10px;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }

    .checkout_snd {
        width: 30%;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }

    .form_group {
        margin-bottom: 15px;
    }

    .form_group label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }

    .form_group input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        background-color: #fff;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form_group input:focus {
        border-color: #F37254;
        outline: none;
        box-shadow: 0 0 0 3px rgba(243, 114, 84, 0.2);
    }

    .order_item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .product_image {
        width: 60px;
        margin-right: 15px;
        border-radius: 6px;
        object-fit: cover;
    }

    .order_item_details p {
        margin: 3px 0;
        font-size: 14px;
    }

    .order_total {
        font-weight: bold;
        margin-top: 15px;
        font-size: 16px;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: none;
    }

    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #F37254;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Improve checkout button styling */
    #rzp-button {
       
        background-color: #2D3748;
        color: #fff;
        padding: 12px 25px;
        font-size: 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #rzp-button:hover {
        background-color: #ffede7;
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
        .checkout_page_container {
            flex-direction: column;
        }

        .checkout_fst,
        .checkout_snd {
            width: 100%;
        }

        .check_fl .form_group {
            width: 100%;
        }
    }
       body {
        /*background: linear-gradient(to bottom right, #f0f4f8, #dbeafe);*/
            /*background-color: #ebddcc;*/
        font-family: 'Segoe UI', sans-serif;
    }

    .checkout-banner {
        position: relative;
        /*background-image: url('https://cdn.pixabay.com/photo/2021/08/23/14/50/online-shopping-6567977_1280.png');*/
        /*background-size: cover;*/
        /*background-position: center;*/
        padding: 80px 0;
        color: white;
        text-shadow: 1px 1px 6px rgba(0,0,0,0.6);
        text-align: center;
        margin-top: 120px;
        overflow: hidden;
        background-color: white;
    }

    .checkout-banner::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 0;
    }

    .checkout-banner h1,
    .checkout-banner p,
    .checkout-banner i {
        position: relative;
        z-index: 1;
    }

    .checkout-container {
        background-color: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 40px;
    }

    .order_summary {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        padding: 20px 30px;
        transition: 0.3s ease-in-out;
        margin-bottom: 30px;
    }

    .order_summary:hover {
        transform: scale(1.02);
    }

    .section_title {
        font-size: 18px;
        color: #333;
        font-weight: bold;
        margin-bottom: 15px;
    }
       .checkout_fst {
        /*background: linear-gradient(to top right, #eff6ff, #dbeafe);*/
        border-radius: 16px;
        padding: 30px;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }

    .checkout_section {
        max-width: 700px;
        margin: auto;
    }

    .check_fl {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form_group {
        flex: 1 1 45%;
        display: flex;
        flex-direction: column;
        margin-bottom: 15px;
    }

    .form_group label {
        margin-bottom: 5px;
        font-weight: 500;
        color: #374151;
    }

    .form_group input {
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: border 0.3s, box-shadow 0.3s;
        font-size: 15px;
    }

    .form_group input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        outline: none;
    }

    #rzp-button {
       
    
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }

    #rzp-button:hover {
        background: #6B46C1;
    }
    .banner-checkout{
         margin-top: 140px;
         color: #d88256;
  

    }
</style>

<div class="banner-checkout text-center" >
    <i class="bi bi-shield-lock-fill display-2 d-block mb-3"></i>
    <h1 class="display-4 fw-bold " style="font-size:3.0rem; ">Secure Checkout</h1>
  <p class="lead"style="font-size:14px;color:#8e8e8e;">Provide your details and place the order with confidence.</p>
</div>

<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>

<div class="checkout_page_container" style="display: flex; gap: 20px;">
    <div class="checkout_fst">
        <div class="checkout_section">
            <h2 class="section_title">Shipping Address</h2>

            <form id="checkout_form">
                @csrf

                <div class="check_fl">
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
                        <input type="email" id="email" name="email" value="{{ $user->email }}" readonly required>
                    </div>
                    <div class="form_group">
                        <label for="phone">Phone*</label>
                        <input type="number" id="phone" name="phone" value="{{ $user->phone }}" required>
                    </div>
                </div>
@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Address;

    $addresses = Address::where('user_id', Auth::id())->get();
    $defaultAddress = $addresses->firstWhere('is_default', 1);
@endphp

<!-- Dropdown to Choose Address -->
<!--<div class="form-group mb-3">-->
<!--    <label for="addressSelect">Choose Saved Address:</label>-->
<!--    <select id="addressSelect" class="form-control">-->
<!--        <option value="">-- Select an Address --</option>-->
<!--        @foreach ($addresses as $address)-->
<!--            <option -->
<!--                value="{{ $address->id }}"-->
<!--                data-address="{{ $address->address }}"-->
<!--                data-city="{{ $address->city }}"-->
<!--                data-state="{{ $address->state }}"-->
<!--                data-pincode="{{ $address->pincode }}"-->
<!--                {{ $address->is_default ? 'selected' : '' }}-->
<!--            >-->
<!--                {{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}-->
<!--            </option>-->
<!--        @endforeach-->
<!--    </select>-->
<!--</div>-->
  
<!-- Autofill Address Inputs -->
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




{{--Choose Saved Addresses

<!--<div class="form-group mb-3">-->
<!--    <label for="addressDropdown"><strong>Select Address:</strong></label>-->
<!--    <select id="addressDropdown" class="form-control" onchange="fillAddressFields(this)">-->
<!--        <option value="">-- Select Address --</option>-->
<!--        @foreach ($addresses as $address)-->
<!--            <option value="{{ $address->id }}" data-address="{{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}">-->
<!--                {{ $address->address }}, {{ $address->city }}-->
<!--                @if ($address->is_default) (Default) @endif-->
<!--            </option>-->
<!--        @endforeach-->
<!--    </select>-->
<!--</div>-->

--}}






                @php $totalAmount = 0; @endphp
                @foreach ($cartItems as $item)
                    <input type="hidden" name="cartItems[{{ $loop->index }}][product_id]" value="{{ $item->product_id }}">
                    <input type="hidden" name="cartItems[{{ $loop->index }}][quantity]" value="{{ $item->product_qty }}">
                    <input type="hidden" name="cartItems[{{ $loop->index }}][price]" value="{{ $item->product->price }}">
                    @php $totalAmount += $item->product->discountPrice  * $item->product_qty; @endphp
                @endforeach

                <input type="hidden" name="amount" value="{{ $totalAmount }}">
                <button type="button" id="rzp-button" class="update-cart" style=" color: white; padding: 10px 20px; border: none; border-radius: 5px; margin-block: 20px;">
                    Pay with Razorpay ₹{{ number_format($totalAmount, 2) }}
                </button>
                    
                    
                    
                   
{{-- Table View of Addresses --}}
<!--<div class="dropdown">-->
<!--    <button class="btn btn-outline-primary dropdown-toggle mb-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">-->
<!--        Select Default Address-->
<!--    </button>-->
<!--    <div class="dropdown-menu p-3" style="width: 100%; max-width: 600px; ">-->
<!--        <table class="table table-bordered mb-0">-->
<!--            <thead>-->
<!--                <tr>-->
<!--                    <th>Address</th>-->
<!--                    <th class="text-center">Default</th>-->
<!--                </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--                @foreach ($addresses as $address)-->
<!--                    <tr class="{{ $address->is_default ? 'table-primary' : '' }}">-->
<!--                        <td>-->
<!--                            {{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}-->
<!--                        </td>-->
<!--                        <td class="text-center">-->
<!--                            <form action="{{ route('address.setDefault', $address->id) }}" method="POST" class="set-default-form">-->
<!--                                @csrf-->
<!--                                <input type="checkbox" onchange="this.form.submit()" {{ $address->is_default ? 'checked' : '' }}>-->
<!--                            </form>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                @endforeach-->
<!--            </tbody>-->
<!--        </table>-->
<!--    </div>-->
<!--</div>-->


<!--<input type="text" class="form-control mb-3" id="addressInput" placeholder="Selected Address will appear here" readonly>-->

<script>
    function fillAddressFields(select) {
        const selectedOption = select.options[select.selectedIndex];
        const address = selectedOption.getAttribute('data-address');
        document.getElementById('addressInput').value = address || '';
    }
</script>





{{--Addess dropdowns
<!-- Add New Address Button -->
<!--<button type="button" class="btn btn-primary mb-3 d-flex" id="showNewAddressForm">+ Add New Address</button>-->

<!-- New Address Fields (Initially Hidden) -->
<!--<div id="newAddressForm" class="border rounded p-3 mb-3" style="display: none;">-->
<!--   <form method="POST" action="{{ route('user.address.store') }}">-->
<!--    @csrf-->

<!--    <div id="newAddressForm" class="border rounded p-3 mb-3">-->
<!--        <div class="form-group mb-2">-->
<!--            <label>Address</label>-->
<!--            <input type="text" class="form-control" name="address" required>-->
<!--        </div>-->
<!--        <div class="form-group mb-2">-->
<!--            <label>City</label>-->
<!--            <input type="text" class="form-control" name="city" required>-->
<!--        </div>-->
<!--        <div class="form-group mb-2">-->
<!--            <label>Pincode</label>-->
<!--            <input type="text" class="form-control" name="pincode" required>-->
<!--        </div>-->
<!--        <div class="form-group mb-2">-->
<!--            <label>State</label>-->
<!--            <input type="text" class="form-control" name="state" required>-->
<!--        </div>-->

        <!-- ✅ Checkbox for Default Address -->
<!--        <div class="form-check mb-3">-->
<!--            <input class="form-check-input" type="checkbox" name="is_default" value="1" id="setDefaultCheckbox">-->
<!--            <label class="form-check-label" for="setDefaultCheckbox">-->
<!--                Set as default address-->
<!--            </label>-->
<!--        </div>-->

<!--        <div class="modal-footer">-->
<!--            <button type="submit" class="btn btn-primary">Save Address</button>-->
<!--        </div>-->
<!--    </div>-->
<!--</form>-->
<!--</div>-->

<!-- JS Logic -->
<!--<script>-->
<!--    document.getElementById('addressSelect').addEventListener('change', function () {-->
<!--        const selected = this.options[this.selectedIndex];-->
<!--        document.getElementById('inputAddress').value = selected.getAttribute('data-address') || '';-->
<!--        document.getElementById('inputCity').value = selected.getAttribute('data-city') || '';-->
<!--        document.getElementById('inputPincode').value = selected.getAttribute('data-pincode') || '';-->
<!--        document.getElementById('inputState').value = selected.getAttribute('data-state') || '';-->
<!--    });-->

<!--    document.getElementById('showNewAddressForm').addEventListener('click', function () {-->
<!--        const form = document.getElementById('newAddressForm');-->
<!--        form.style.display = form.style.display === 'none' ? 'block' : 'none';-->
<!--    });-->

<!--    document.getElementById('setDefaultBtn').addEventListener('click', function () {-->
<!--        const selectedId = document.getElementById('addressSelect').value;-->

<!--        if (!selectedId) {-->
<!--            alert('Please select an address to set as default.');-->
<!--            return;-->
<!--        }-->

<!--        fetch('/set-default-address', {-->
<!--            method: 'POST',-->
<!--            headers: {-->
<!--                'Content-Type': 'application/json',-->
<!--                'X-CSRF-TOKEN': '{{ csrf_token() }}'-->
<!--            },-->
<!--            body: JSON.stringify({ address_id: selectedId })-->
<!--        })-->
<!--        .then(res => res.json())-->
<!--        .then(data => {-->
<!--            if (data.success) {-->
<!--                alert('Default address updated!');-->
<!--                location.reload();-->
<!--            } else {-->
<!--                alert('Error setting default address.');-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->
 
 
 --}}
                    
                    
                    
                    
                    
                    
            </form>
        </div>
    </div>

    <div class="checkout_snd">
        <div class="checkout_section" style="padding: 20px; border-radius: 10px; margin-bottom: 1rem;">
            <h2 class="section_title">Order Summary</h2>
            <div class="order_summary">
                @foreach ($cartItems as $item)
                    <div class="order_item">
                        <img src="{{ asset('storage/products/' . $item->product->image1) }}" alt="{{ $item->product->name }}" class="product_image">
                        <div class="order_item_details">
                            <p>{{ $item->product->name }}</p>
                            <p>Qty: {{ $item->product_qty }}</p>
                            <p>₹{{ number_format($item->product->discountPrice  * $item->product_qty, 2) }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="order_total">
                    <p>Total: ₹{{ number_format($totalAmount, 2) }}</p>
                </div>
            </div>
        </div>

        @if($totalAmount > 1000) <!-- Example condition for gift eligibility -->
            <div id="free_gift_di" class="checkout_section" style="background: #f6f6f6cc; padding: 20px; border-radius: 10px;">
                <h2 class="section_title" style="color: forestgreen; font-size: 16px; margin-bottom: 0; font-weight: 400; padding: 13px; background: #ffffff; border-radius: 5px;">
                    <i class="fas fa-gift" style="color: orange; margin-right: 10px; font-size: 22px;"></i>
                    CONGRATS! YOU ARE ELIGIBLE FOR A GIFT!
                </h2>
            </div>
        @endif
    </div>
</div>


































<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
{{--<script>
    document.getElementById('rzp-button').addEventListener('click', async function() {
        // Show loading indicator
        document.getElementById('loadingOverlay').style.display = 'flex';

        // Validate form
        if (!validateForm()) {
            alert('Please fill all required fields marked with *');
            document.getElementById('loadingOverlay').style.display = 'none';
            return;
        }

        // Prepare form data
        const formData = {
            order_id: document.getElementById('order_id').value,
            amount: document.querySelector('input[name="amount"]').value,
            phone: document.getElementById('phone').value,
            address: document.getElementById('address_field').value,
            city: document.getElementById('city_field').value,
            postal_code: document.getElementById('postal_code_field').value,
            cartItems: [],
            _token: '{{ csrf_token() }}'
        };

        // Add cart items
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
            // Initiate payment
            const response = await fetch("{{ route('razorpay.initiate') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            // Handle non-JSON responses
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                throw new Error(`Server responded with ${response.status}: ${text}`);
            }

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || 'Payment initialization failed');
            }

            // Razorpay options
            const options = {
                key: data.key,
                amount: data.amount * 100,
                currency: data.currency,
                order_id: data.razorpay_order_id,
                name: "Mahadev Ayurveda",
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
                        // Prepare verification data
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

                        // Verify payment
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

    // Simple form validation
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
</script>--}}
<script>
    document.getElementById('rzp-button').addEventListener('click', async function() {
        // Show loading indicator
        document.getElementById('loadingOverlay').style.display = 'flex';

        // Validate form
        if (!validateForm()) {
            alert('Please fill all required fields marked with *');
            document.getElementById('loadingOverlay').style.display = 'none';
            return;
        }

        // Prepare form data
        const formData = {
            order_id: document.getElementById('order_id').value,
            amount: document.querySelector('input[name="amount"]').value,
            phone: document.getElementById('phone').value,
            address: document.getElementById('address_field').value,
            city: document.getElementById('city_field').value,
            postal_code: document.getElementById('postal_code_field').value,
            cartItems: [],
            _token: '{{ csrf_token() }}'
        };

        // Add cart items
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
            // Initiate payment
            const response = await fetch("{{ route('razorpay.initiate') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            // Handle non-JSON responses
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                throw new Error(`Server responded with ${response.status}: ${text}`);
            }

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || 'Payment initialization failed');
            }

            // Razorpay options
            const options = {
                key: data.key,
                amount: data.amount * 100,
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
                        // Prepare verification data
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

                        // Verify payment
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

    // Simple form validation
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
