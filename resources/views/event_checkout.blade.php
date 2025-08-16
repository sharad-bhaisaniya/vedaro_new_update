<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
   <style>
        :root {
            --primary-color: #007bff;
            --green-button: #28a745;
            --border-color: #e0e0e0;
            --text-color: #343a40;
            --light-text: #6c757d;
            --white: #ffffff;
            --card-border-radius: 8px;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #3B2441;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .checkout-container {
            width: 100%;
            margin: 20px auto;
            background-color: transparent;
            border-radius: var(--card-border-radius);
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 768px) {
            .checkout-container {
                flex-direction: row;
            }
        }

        .customer-info-section {
            flex: 2;
            max-height: 600px;
            overflow-y: auto;
            padding: 25px;
        }

        .customer-info-section::-webkit-scrollbar {
            display: none;
        }

        .order-summary-section {
            flex: 1;
            background-color: var(--white);
            border: 1px solid #f0dfdf;
            padding: 25px;
        }

        h2 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #5a5a5a;
            border-radius: 4px;
            font-size: 14px;
            background:transparent ;
            color: white;
            outline: none;
        }

        .form-row {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        @media (min-width: 576px) {
            .form-row {
                flex-direction: row;
            }
        }

        .form-row .form-group {
            flex: 1;
        }

        .payment-section {
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }

        .payment-provider {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .payment-provider img {
            height: 25px;
            margin-right: 8px;
        }

        .place-order-button {
            width: 100%;
            padding: 12px;
            background-color: var(--green-button);
            color: var(--white);
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 25px;
        }

        .place-order-button:hover {
            background-color: #218838;
        }

        #country {
            max-height: 150px;
            overflow-y: auto;
        }

        .security-note-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: var(--light-text);
        }
    </style>
    <style>
    /* Existing styles remain */

    .form-group {
        margin-bottom: 20px; /* More space between fields */
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 16px;
        /*border: 1px solid var(--border-color);*/
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Space between side-by-side inputs */
    }

    .form-row .form-group {
        flex: 1;
        min-width: 160px;
    }

    /* On small screens, inputs take full width */
    @media (max-width: 576px) {
        .form-group {
            max-width: 100%;
        }
    }
</style>
</head>
<body>
    <div class="checkout-container">
        <div class="customer-info-section">
            @if(session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    {{ session('success') }}
                </div>
            @endif

            <h1>Checkout</h1>
            <h3>Customer information</h3>
            
            <form id="paymentForm">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email Address <span style="color: red;">*</span></label>
                    <input type="email" id="email" name="email" placeholder="Email Address" required>
                </div>

                <h3>Billing details</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="first-name">First name <span style="color: red;">*</span></label>
                        <input type="text" id="first-name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last name <span style="color: red;">*</span></label>
                        <input type="text" id="last-name" name="last_name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address <span style="color: red;">*</span></label>
                    <input type="text" id="address" name="address" placeholder="Street address, house number" required>
                </div>

                <div class="form-group">
                    <label for="city">City <span style="color: red;">*</span></label>
                    <input type="text" id="city" name="city" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="pincode">Pincode <span style="color: red;">*</span></label>
                        <input type="text" id="pincode" name="pincode" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State <span style="color: red;">*</span></label>
                        <input type="text" id="state" name="state" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="country">Country / Region <span style="color: red;">*</span></label>
                    <select id="country" name="country" required></select>
                </div>

                <div class="form-group">
                    <label for="phone">Phone <span style="color: red;">*</span></label>
                    <input type="tel" id="phone" name="phone" required>
                </div>

                <h3>Payment</h3>
                <div class="payment-section">
                    <div class="payment-provider">
                        <img src="https://cdn.razorpay.com/logos/rzp_volpe_white.png" alt="Razorpay Logo" style="height: 30px;">
                        <span>Razorpay</span>
                    </div>
                    <p>Pay securely by Credit/Debit card, UPI, Net Banking or Wallets through Razorpay.</p>
                </div>

                <h2>Pay for your event booking</h2>
                <p>Amount: ₹51.00</p>
                <button type="button" id="rzp-button1" class="place-order-button">Pay Now ₹51.00</button>
            </form>
        </div>
    </div>

    <div class="security-note-footer">
        Payments are secured and encrypted.
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Load countries
            const countrySelect = document.getElementById('country');
            const countries = [
                "Afghanistan","Albania","Algeria","Andorra","Angola","Argentina","Armenia","Australia",
                "Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium",
                "Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil",
                "Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde",
                "Central African Republic","Chad","Chile","China","Colombia","Comoros","Congo",
                "Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica",
                "Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea",
                "Estonia","Eswatini","Ethiopia","Fiji","Finland","France","Gabon","Gambia","Georgia",
                "Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana",
                "Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland",
                "Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kuwait",
                "Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein",
                "Lithuania","Luxembourg","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta",
                "Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco",
                "Mongolia","Montenegro","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal",
                "Netherlands","New Zealand","Nicaragua","Niger","Nigeria","North Korea","North Macedonia",
                "Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru",
                "Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis",
                "Saint Lucia","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe",
                "Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia",
                "Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain",
                "Sri Lanka","Sudan","Suriname","Sweden","Switzerland","Syria","Taiwan","Tajikistan",
                "Tanzania","Thailand","Timor-Leste","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey",
                "Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom",
                "United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam",
                "Yemen","Zambia","Zimbabwe"
            ];

            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country;
                option.textContent = country;
                if (country === "India") {
                    option.selected = true;
                }
                countrySelect.appendChild(option);
            });

            // Handle payment button click
            document.getElementById('rzp-button1').addEventListener('click', function(e) {
                e.preventDefault();
                
                // Validate form
                const form = document.getElementById('paymentForm');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                // Collect form data
                const formData = new FormData(form);
                
                // Disable button to prevent multiple clicks
                document.getElementById('rzp-button1').disabled = true;
                document.getElementById('rzp-button1').textContent = 'Processing...';

                // Initiate payment
                fetch("{{ route('event.initiate') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Open Razorpay checkout
                        const options = {
                            key: data.key,
                            amount: data.amount,
                            currency: "INR",
                            name: "Event Booking",
                            description: "Payment for Event",
                            order_id: data.order_id,
                            handler: function(response) {
                                // Verify payment on server
                                verifyPayment(response, data.event_id);
                            },
                            prefill: {
                                name: formData.get('first_name') + ' ' + formData.get('last_name'),
                                email: formData.get('email'),
                                contact: formData.get('phone')
                            },
                            theme: {
                                color: "#3399cc"
                            }
                        };

                        const rzp1 = new Razorpay(options);
                        rzp1.open();
                    } else {
                        alert('Failed to initiate payment');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred');
                })
                .finally(() => {
                    document.getElementById('rzp-button1').disabled = false;
                    document.getElementById('rzp-button1').textContent = 'Pay Now ₹51.00';
                });
            });

            function verifyPayment(response, eventId) {
                fetch("{{ route('event.payment.verify') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature,
                        event_id: eventId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Payment successful! Event ID: ' + data.event_id);
                        window.location.reload();
                    } else {
                        alert('Payment verification failed: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Payment verification error');
                });
            }
        });
    </script>
</body>
</html>