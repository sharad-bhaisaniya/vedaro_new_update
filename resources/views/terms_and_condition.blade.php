@extends('layouts.main')
@section('title', 'Terms and Conditions')
@section('content')

<div class="sect_head"></div>

<main class="content">
    <section class="policy_section">
        <h2>Welcome to Mahakaaal</h2>
        <p>
            By accessing or using our website and services, you agree to be bound by the following terms and conditions. Please read these terms carefully before using our platform. If you do not agree to any of the terms, you must refrain from using our services.
        </p>
    </section>

    <section class="policy_section">
        <h2>Eligibility</h2>
        <p>
            To use our website, you must:
        </p>
        <ul>
            <li>Be at least 18 years old or have parental/guardian consent.</li>
            <li>Provide accurate and complete information during registration or checkout.</li>
            <li>Comply with all applicable local, state, and national laws and regulations.</li>
        </ul>
    </section>

    <section class="policy_section">
        <h2>Account Responsibilities</h2>
        <p>
            You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. If you suspect unauthorized access to your account, notify us immediately.
        </p>
    </section>

    <section class="policy_section">
        <h2>Prohibited Activities</h2>
        <p>
            While using our website, you agree not to:
        </p>
        <ul>
            <li>Engage in fraudulent activities or provide false information.</li>
            <li>Use our platform for illegal purposes or in violation of applicable laws.</li>
            <li>Interfere with the operation of our website or compromise its security.</li>
            <li>Upload viruses, malware, or harmful scripts.</li>
        </ul>
    </section>

    <section class="policy_section">
        <h2>Pricing and Payments</h2>
        <p>
            All prices displayed on our website are inclusive of applicable taxes unless stated otherwise. We reserve the right to change product prices without prior notice. Payments must be made via the payment methods specified at checkout.
        </p>
    </section>

    <section class="policy_section">
        <h2>Order Cancellation</h2>
        <p>
            Orders can be canceled within 24 hours of placement. Once the order has been processed or shipped, cancellations will no longer be accepted. For more details, refer to our <a href="/cancellation-policy">Cancellation Policy</a>.
        </p>
    </section>

    <section class="policy_section policy_images">
        <div class="policy_text">
            <h2>Limitation of Liability</h2>
            <p>
                We strive to ensure the accuracy of the information on our website. However, we are not responsible for:
            </p>
            <ul>
                <li>Errors or inaccuracies in product descriptions.</li>
                <li>Delays in product availability due to unforeseen circumstances.</li>
                <li>Any direct or indirect losses resulting from the use of our website.</li>
            </ul>
        </div>
        <div class="policy_image">
            <img src="terms-conditions-liability.jpg" alt="Limitation of Liability" />
        </div>
    </section>

    <section class="policy_section">
        <h2>Intellectual Property</h2>
        <p>
            All content on our website, including text, images, graphics, logos, and software, is the property of Mahakaaal or its content suppliers and is protected under copyright and trademark laws. Unauthorized use of this content is prohibited.
        </p>
    </section>

    <section class="policy_section">
        <h2>Third-Party Links</h2>
        <p>
            Our website may contain links to third-party websites. We do not endorse or assume responsibility for the content, products, or services provided by these external sites. Accessing these links is at your own risk.
        </p>
    </section>

    <section class="policy_section">
        <h2>Governing Law</h2>
        <p>
            These terms and conditions are governed by the laws of [Your Jurisdiction]. Any disputes arising from the use of our services will be resolved under the jurisdiction of courts in [Your Jurisdiction].
        </p>
    </section>

    <section class="policy_section">
        <h2>Changes to the Terms</h2>
        <p>
            We reserve the right to update or modify these terms and conditions at any time without prior notice. Your continued use of our website following any changes constitutes your acceptance of the revised terms.
        </p>
    </section>

    <section class="policy_section">
        <h2>Contact Us</h2>
        <p>
            If you have any questions or concerns regarding these terms, please contact us at 
            <a href="mailto:support@mahakaaal.com">support@mahakaaal.com</a> or call us at +91-9079673886
        </p>
    </section>
</main>

<style>

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
