@extends('layouts.main')

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

</style>

<div class="checkout-flow-container">
    <div class="checkout-flow-summary">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
            <a href="#"><img src="https://api.iconify.design/ic:outline-arrow-back.svg?color=gray&height=24" alt="Back"></a>
            <h2 style="margin: 0;">Order Summary</h2>
        </div>
        <div class="checkout-flow-product">
            <img src="https://cdn.pixabay.com/photo/2019/06/17/13/39/ring-4279997_1280.jpg" alt="Product">
            <div class="checkout-flow-details">
                <h4>Enticing petit drop earing</h4>
                <div>
                    <span class="price">₹44,112.11</span>
                    <span class="old-price">₹54,112.11</span>
                </div>
            </div>
        </div>

        <table class="checkout-flow-table">
            <tr>
                <td>Subtotal</td>
                <td>₹44,112.11</td>
            </tr>
            <tr>
                <td>GST(%)</td>
                <td>₹xxx</td>
            </tr>
            <tr>
                <td>Shipping</td>
                <td>Free</td>
            </tr>
            <tr class="total">
                <td>Total Due</td>
                <td>₹44,112.11</td>
            </tr>
        </table>
    </div>

    <div class="checkout-flow-steps">
        <div class="checkout-flow-step-header">
            <span id="flow-step-shipping" class="active">Shipping</span>
            <span>—</span>
            <span id="flow-step-payment">Payment</span>
            <span>—</span>
            <span id="flow-step-confirm">Confirmed</span>
        </div>

        <div id="flow-shipping" class="checkout-flow-section active">
            <h3>Contact Details</h3>
            <div class="checkout-form-grid">
                <input type="text" placeholder="First Name" required value="Vasanth">
                <input type="text" placeholder="Last Name" required value="Kumar V">
                <input type="text" placeholder="Email" required value="vasanth@gmail.com">
                <input type="text" placeholder="Phone" required value="+91 98765-43210">
            </div>

            <h3 style="margin-top: 30px;">Shipping Details</h3>
            <div class="checkout-form-grid">
                <input type="text" placeholder="Flat" required value="1/88a, Radha Illam">
                <input type="text" placeholder="Address" required value="Nalli Road">
                <input type="text" placeholder="City" required value="Sirumugai, Coimbatore">
                <input type="text" placeholder="State" required value="Tamil Nadu">
            </div>
            <input type="text" placeholder="Pin Code" required value="641 302">

            <div class="checkout-flow-btn-container">
                <button class="checkout-flow-btn" onclick="goToStep('payment')">Continue</button>
            </div>
        </div>

        <div id="flow-payment" class="checkout-flow-section">
            <h3>Payment Methods</h3>
            <div class="payment-options">
                <label><input type="radio" name="pay" checked> Pay on Delivery <br><span>Pay with cash on delivery</span></label>
                <label><input type="radio" name="pay"> Credit/Debit Card <br><span>Pay with your Credit / Debit Card</span></label>
                <label><input type="radio" name="pay"> BHIM UPI <br><span>Make payment through Gpay, Phonepay, Paytm etc</span></label>
                <label><input type="radio" name="pay"> EMI <br><span>Make payment with EMI</span></label>
            </div>
            <div class="checkout-flow-btn-container">
                <button class="checkout-flow-btn" onclick="goToStep('confirm')">Pay ₹44,112.11</button>
            </div>
        </div>

        <div id="flow-confirm" class="checkout-flow-section">
            <div class="checkout-flow-success">
                <div class="checkout-flow-success-icon">✔</div>
                <h2>Order Placed Successfully</h2>
                <button class="checkout-flow-btn">View Order</button><br><br>
                <a href="/">Back to Home</a>
            </div>
        </div>
    </div>
</div>

<script>
    function goToStep(step) {
        document.querySelectorAll('.checkout-flow-section').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.checkout-flow-step-header span').forEach(s => s.classList.remove('active', 'done'));

        if (step === 'shipping') {
            document.getElementById('flow-shipping').classList.add('active');
            document.getElementById('flow-step-shipping').classList.add('active');
        } else if (step === 'payment') {
            document.getElementById('flow-payment').classList.add('active');
            document.getElementById('flow-step-shipping').classList.add('done');
            document.getElementById('flow-step-payment').classList.add('active');
        } else if (step === 'confirm') {
            document.getElementById('flow-confirm').classList.add('active');
            document.getElementById('flow-step-shipping').classList.add('done');
            document.getElementById('flow-step-payment').classList.add('done');
            document.getElementById('flow-step-confirm').classList.add('active');
        }
    }
</script>

@endsection