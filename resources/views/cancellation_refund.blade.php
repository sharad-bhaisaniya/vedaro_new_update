@extends('layouts.main')
@section('title', 'Cancellation & Refund Policy')
@section('content')


<style>
    .content{
       margin-top: 7%;
    }
</style>

    
    <main class="content">
            <h1 class="text-center" style="    border-bottom: 2px solid #f0f0f0;padding-bottom: 10px;">Cancellation & Refund Policy</h1>

      <section class="policy_section">
        <h2>Cancellation Policy</h2>
        <p>
          Customers can request to cancel their order within 24 hours of placing the order. 
          Cancellations requested after 24 hours will not be accepted as the order may have already been processed.
        </p>
        <p>
          To initiate a cancellation, please contact our support team with your order details.
        </p>
      </section>
      
      <section class="policy_section">
        <h2>Refund Policy</h2>
        <p>
          Refunds are applicable for orders that meet the cancellation criteria or in the case of defective or damaged products. 
          Customers must notify us within 7 days of receiving the product to initiate a refund.
        </p>
        <p>
          Refunds will be processed within 7-10 business days after approval and will be credited back to the original payment method.
        </p>
      </section>

      <section class="policy_section policy_images">
        <div class="policy_text">
          <h2>Important Notes</h2>
          <p>
            Please retain the original packaging and receipt for refunds. Refunds will not be processed without sufficient proof of purchase or in cases where the product has been misused or damaged by the customer.
          </p>
        </div>
        <div class="policy_image">
          <img src="refund-policy.jpg" alt="Refund Policy" />
        </div>
      </section>

      <section class="policy_section">
        <h2>Contact Us</h2>
        <p>
          If you have any questions or concerns regarding our Cancellation & Refund Policy, 
          please contact us at <a href="mailto:support@Vedaro.com">support@Vedaro.com</a> or call us at +91-9079673886
        </p>
      </section>
    </main>




<style>

.cancellation_refund {
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

.policy_section p {
  font-size: 1rem;
  color: #555;
  margin: 10px 0;
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

  .policy_section p {
    font-size: 0.9rem;
  }

  .policy_images {
    flex-direction: column;
  }
}

</style>

@endsection

