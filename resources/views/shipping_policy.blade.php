@extends('layouts.main')
@section('title', 'Shipping Policy')
@section('content')


<style>
    .content{
        margin-top: 7%;
    }
</style>

<main class="content">
        <h1 class="text-center" style="    border-bottom: 2px solid #f0f0f0;padding-bottom: 10px;">Shipping Policy</h1>
    <section class="policy_section">
        <h2>Shipping Overview</h2>
        <p>
            At Vedaro, we are committed to delivering your orders promptly and efficiently. This Shipping Policy outlines the terms and conditions regarding the shipping and delivery of our products.
        </p>
    </section>
    
    <section class="policy_section">
        <h2>Shipping Destinations</h2>
        <p>
            We currently ship to the following locations:
        </p>
        <ul>
            <li>Domestic (All over India)</li>
            <li>International shipping to selected countries (please contact our support team for details).</li>
        </ul>
        <p>
            If your location is not listed, please reach out to us for assistance.
        </p>
    </section>
    
    <section class="policy_section">
        <h2>Shipping Charges</h2>
        <p>
            Shipping charges are calculated based on the following criteria:
        </p>
        <ul>
            <li>Order weight and dimensions.</li>
            <li>Shipping destination (domestic or international).</li>
            <li>Shipping method selected (standard or express).</li>
        </ul>
        <p>
            Shipping charges will be displayed during the checkout process before payment.
        </p>
    </section>
    
    <section class="policy_section">
        <h2>Processing Time</h2>
        <p>
            Orders are typically processed within 1-3 business days from the date of purchase. During peak seasons or sales, processing times may be slightly longer. 
        </p>
        <p>
            You will receive a confirmation email with tracking details once your order has been shipped.
        </p>
    </section>
    
    <section class="policy_section">
        <h2>Estimated Delivery Times</h2>
        <ul>
            <li><strong>Domestic Orders:</strong> 5-7 business days.</li>
            <li><strong>International Orders:</strong> 10-15 business days, depending on the destination.</li>
        </ul>
        <p>
            Please note that delivery times are estimates and may vary due to factors beyond our control, such as weather conditions, customs clearance, or courier delays.
        </p>
    </section>
    
    <section class="policy_section policy_images">
        <div class="policy_text">
            <h2>Shipping Methods</h2>
            <p>
                We offer the following shipping methods for your convenience:
            </p>
            <ul>
                <li>Standard Shipping: Cost-effective delivery with tracking.</li>
                <li>Express Shipping: Faster delivery for urgent orders.</li>
            </ul>
        </div>
        <div class="policy_image">
            <img src="shipping-methods.jpg" alt="Shipping Methods" />
        </div>
    </section>
    
    <section class="policy_section">
        <h2>Order Tracking</h2>
        <p>
            Once your order is shipped, you will receive an email containing the tracking number and a link to track your order in real-time. 
        </p>
        <p>
            If you have any issues tracking your order, please contact our support team.
        </p>
    </section>
    
    <section class="policy_section">
        <h2>Undeliverable Packages</h2>
        <p>
            In the event that a package is deemed undeliverable due to an incorrect address, failed delivery attempts, or refusal to accept the package, the customer will be responsible for any reshipping costs.
        </p>
    </section>

    <section class="policy_section">
        <h2>Damaged or Lost Shipments</h2>
        <p>
            If your order arrives damaged or is lost during transit, please contact us within 7 days of the expected delivery date. We will investigate the matter and take appropriate action, which may include a replacement or refund.
        </p>
    </section>
    
    <section class="policy_section">
        <h2>Contact Us</h2>
        <p>
            If you have any questions or concerns regarding our Shipping Policy, please contact us at 
            <a href="mailto:support@Vedaro.com">support@Vedaro.com</a> or call us at +91-9079673886
        </p>
    </section>
</main>

<style>

.shipping_policy {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* Main Content */
.content {
  flex: 1;
  padding: 20px;
}

.policy_section {
  margin-bottom: 30px;
}

.policy_section h2 {
  font-size: 1.5rem;
  color: #3c3b6e;
  margin-bottom: 10px;
}

.policy_section p, .policy_section ul {
  font-size: 1rem;
  color: #555;
  margin: 10px 0;
}

.policy_section ul {
  list-style-type: disc;
  padding-left: 20px;
}

.policy_section a {
  color: #3c3b6e;
  text-decoration: none;
}

.policy_section a:hover {
  text-decoration: underline;
}

/* Side by Side Section */
.policy_images {
  display: flex;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
}

.policy_images .policy_text {
  flex: 1;
}

.policy_images .policy_image {
  flex: 1;
  text-align: center;
}

.policy_images .policy_image img {
  max-width: 100%;
  border-radius: 10px;
}

/* Responsive Design */
@media (max-width: 768px) {

  .policy_section h2 {
    font-size: 1.2rem;
  }

  .policy_section p, .policy_section ul {
    font-size: 0.9rem;
  }

  .policy_images {
    flex-direction: column;
  }
}

</style>

@endsection
