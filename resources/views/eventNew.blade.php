@extends('layouts.main')

@section('title', 'Limited Edition')

@section('content')
  <link rel="stylesheet" href="{{ asset('/assets/css/event.css') }}">

<!-- 1 section -->


  <section class="section">
    <div class="section-content">
      <h1>Best Out of Waste &<br> Divine Creativity</h1>
      <p>Transform simple materials into divine beauty! Participate and showcase your devotion and creativity.</p>
      <p>Whether it’s a traditional look, a festive theme, or an eco-friendly masterpiece, your laddu gopal ji’s divine attire can win exciting cash prizes & blessings!</p>
      <!--<button class="btn" id="participateBtn">Participate now</button>-->
    </div>
    <div class="section-image">
      <img src="https://darshanaya.com/cdn/shop/files/4_333ae617-e545-418d-b479-b05d68cb0a59.png?v=1750089352" alt="Laddu Gopal"> <!-- replace with your image path -->
    </div>
  </section>


<!-- 2 section -->



<section class="prizes-section">
  <h2>Win Exciting Cash Prizes!</h2>
  <div class="prizes">
    <div class="prize-card">
      <!-- <div class="medal gold">1st</div> -->
       <img src="https://img.freepik.com/free-vector/first-prize-ribbon-award-vector_53876-43814.jpg?semt=ais_hybrid&w=740&q=80" alt="">
      <p>Cash Prize: ₹21,000</p>
    </div>
    <div class="prize-card">
      <!-- <div class="medal silver">2nd</div> -->
       <img src="https://img.freepik.com/free-vector/first-prize-ribbon-award-vector_53876-43814.jpg?semt=ais_hybrid&w=740&q=80" alt="">
      <p>Cash Prize: ₹11,000</p>
    </div>
    <div class="prize-card">
      <!-- <div class="medal bronze">3rd</div> -->
       <img src="https://img.freepik.com/free-vector/first-prize-ribbon-award-vector_53876-43814.jpg?semt=ais_hybrid&w=740&q=80" alt="">
      <p>Cash Prize: ₹5,100</p>
    </div>
  </div>

  <div class="consultation">
    <div class="checkmarkContainer" >
        <div class="checkmark">
            ✔
        </div>
    </div>
    <p class="consultationFee">Get a consultation for just ₹1100 for a group of 11 people!</p>
  </div>
</section>


<section class="event-img-container">
  <div class="event-img">
    <img src="{{ asset('assets/images/eventImg.png') }}" alt="logo">
  </div>
</section>

<!-- third section -->


<section class="steps-section">
  <h2>Simple Steps to Register & Participate!</h2>

  <div class="steps-container">
    <div class="step"> 
      <h3>Step 1</h3>
      <p>Click on "Register Now" <br> and fill out the form</p>
    </div>
    <div class="step">
      <h3>Step 2</h3>
      <p>Pay the ₹51 registration <br> fee (Payment options: UPI, Debit Card, etc.)</p>
    </div>
    <div class="step">
      <h3>Step 3</h3>
      <p>Receive a WhatsApp confirmation <br> upon successful registration</p>
    </div>
  </div>

  <div class="steps-container">
    <div class="step">
      <h3>Step 4</h3>
      <p>Submit 5 images + 1 <br> video of the decorated idol.</p>
    </div>
    <div class="step">
      <h3>Step 5</h3>
      <p>Upload a 1-minute story video <br> explaining the concept <br> and how you plan to use the donation.</p>
    </div>
  </div>

  <!--<button class="participate-btn">Participate now</button>-->
</section>

<!-- 4 section -->


<section class="fee-section">
  <div class="fee-content">
    <h2>Purpose of the ₹51 Registration Fee</h2>
    <p>
      Helps filter out spam or fake entries and ensures that only serious devotees participate.
    </p>
    <p>
      Maintains the quality and authenticity of the competition
    </p>
    <h3>100% Donation to Gaushala</h3>
    <p>
      Every rupee collected will be donated to a Gaushala for the welfare of cows, who are dear to Laddu Gopal Ji.
    </p>
    <ul>
      <li>Feeding & healthcare of cows.</li>
      <li>Shelter maintenance & support for abandoned cows.</li>
      <li>Promoting kindness & seva towards Gau Mata.</li>
    </ul>
  </div>
  <div class="fee-image">
    <img src="https://give.do/blog/wp-content/uploads/2024/11/Krishnayan-Gaushala-6.png" alt="Gaushala Image"> <!-- replace with your image -->
  </div>
</section>

<!-- 5 section -->


<section class="rules-section">
  <h2><span class="scroll">📜</span> Rules for Participation</h2>

  <div class="rules-grid">
    <div class="rule-card">
      <h3>Eligibility</h3>
      <ul>
        <li>Open to all devotees, regardless of age or location.</li>
        <li>Each participant can submit only one entry idol.</li>
      </ul>
    </div>

    <div class="rule-card">
      <h3>Theme & Categories</h3>
      <ul>
        <li>Best Traditional Look (Classic and festive attires)</li>
        <li>Most Creative Attire (Unique themes and innovative designs)</li>
        <li>Best Out of Waste (Eco-friendly and upcycled materials)</li>
      </ul>
    </div>

    <div class="rule-card">
      <h3>File Format & Size</h3>
      <ul>
        <li>Photos: JPEG, PNG (Max 10 MB per image)</li>
        <li>Videos: MP4 (Max 60 seconds, Max 50 MB)</li>
      </ul>
    </div>

    <div class="rule-card">
      <h3>Devotional Touch</h3>
      <ul>
        <li>Incorporation of spiritual and traditional elements in the attire.</li>
      </ul>
    </div>

    <div class="rule-card">
      <h3>Presentation</h3>
      <ul>
        <li>Overall visual appeal, including background, props, and setup.</li>
      </ul>
    </div>

    <div class="rule-card">
      <h3>Fair Play</h3>
      <ul>
        <li>Any attempt to manipulate votes, use fake accounts, or violate the guidelines will result in immediate disqualification.</li>
      </ul>
    </div>
    
    <div class="rule-card">
        <h3>Story Content: A short (under 1-minute) video explaining</h3>
        <ul>
            <li>The concept behind the dressing.</li>
            <li>The creative process and elements used.</li>
            <li>How you propose to use the donated money for a noble cause.</li>
        </ul>
    </div>
</div>
</section>


<!-- 6 section -->



<section class="winners-section">
  <h2>🏆 🎉 How Winners Will Be Announced?</h2>

  <div class="winners-container">
    <div class="winner-step">
      <p>Winners will be notified via WhatsApp.</p>
    </div>
    <div class="winner-step">
      <p>Results will also be published on Vedaro website & social media.</p>
    </div>
    <div class="winner-step">
      <p>Timeline: Results declared within 10-15 working days after the competition closes.</p>
    </div>
    <div class="winner-step">
      <p>💰 Prize Distribution <br> Cash prizes will be transferred via Bank/UPI Payment.</p>
    </div>
  </div>
</section>


<!-- 7 section -->

<section class="criteria-section">
  <h2>Judging Criteria & Voting Process</h2>
  <p class="criteria-subtitle">
    Your creativity, devotion, and effort will be evaluated <br>
    based on the following criteria
  </p>

  <h3 class="criteria-question">How Will Your Entry Be Judged?</h3>

  <div class="criteria-box">
    <div class="criteria-left">
      <p><strong>Creativity:</strong> How uniquely and beautifully is Laddu Gopal Ji dressed?</p>

      <p><strong>Devotional Touch:</strong> Incorporation of spiritual and traditional elements in the attire.</p>

      <p><strong>Story Content:</strong> A short (under 1-minute) video explaining: <br>
        • The concept behind the dressing. <br>
        • The creative process and elements used. <br>
        • How you propose to use the donated money for a noble cause.
      </p>
    </div>

    <div class="criteria-right">
      <p><strong>Use of Waste Materials:</strong> Special emphasis on the “Best Out of Waste” concept to create an innovative presentation.</p>

      <p><strong>Presentation:</strong> Overall visual appeal, including background, props, and setup.</p>

      <p><strong>Fair Play:</strong> Any attempt to manipulate votes, use fake accounts, or violate the guidelines will result in immediate disqualification.</p>
    </div>
  </div>

  <p class="criteria-note">
    Note: The competition is not about the cost of the dress, but about creativity, devotion, and innovation using available resources!
  </p>
</section>

<!-- 8th section -->

<section class="verification-section">
  <h2>Verification & Fairness Policy</h2>
  <p>
    To ensure a fair, transparent, and devotional competition, we have implemented strict
    verification guidelines.
  </p>

  <div class="verification-grid">
    <div class="verify-card">
      <h3><span class="icon">✅</span> Authenticity Check</h3>
      <ul>
        <li>If required, participants must show their full setup on a live video call within 24 hours of the request.</li>
        <li>This ensures that the submitted entry is genuine and originally created by the participant.</li>
        <li>Failure to comply with the authenticity check will result in disqualification.</li>
      </ul>
    </div>

    <div class="verify-card">
      <h3><span class="icon cross">❌</span> Disqualification Rules</h3>
      <ul>
        <li>The same image/video is forwarded from two different numbers.</li>
        <li>The entry is not submitted from the registered mobile number.</li>
        <li>Any attempt to manipulate votes, use fake accounts, or violate guidelines is detected.</li>
      </ul>
    </div>
  </div>

  <div class="verification-footer">
    <p>📜 Vedaro reserves the right to take action against any unfair practices to maintain the devotional and competitive spirit of the event.</p>
    <p>🌟 Participate with honesty, devotion, and creativity! 🌟</p>
    <p>Would you like to add any additional verification steps?</p>
  </div>
</section>



<!-- 9th section -->

<section class="faq-section">
  <h2>Frequently Asked Questions <span style="color:red;">❓</span></h2>

  <div class="faq">
    <button class="faq-question">WHO CAN PARTICIPATE IN THIS COMPETITION?</button>
    <div class="faq-answer">
      <p>Anyone who meets the eligibility criteria can participate in this competition.</p>
    </div>
  </div>

  <div class="faq">
    <button class="faq-question">HOW DO I REGISTER FOR THE COMPETITION?</button>
    <div class="faq-answer">
      <p>You can register by filling out the registration form and completing the payment process.</p>
      <p>You can register by filling out the registration form and completing the payment process.</p>
      <p>You can register by filling out the registration form and completing the payment process.</p>
    </div>
  </div>

  <div class="faq">
    <button class="faq-question">HOW SHOULD I SUBMIT MY ENTRY?</button>
    <div class="faq-answer">
      <p>You need to upload your images and videos through the submission form provided after registration.</p>
    </div>
  </div>

  <div class="faq">
    <button class="faq-question">WHAT SHOULD I INCLUDE IN MY SUBMISSION?</button>
    <div class="faq-answer">
      <p>Make sure to include all required images, videos, and story explanations as per the competition guidelines.</p>
    </div>
  </div>

  <div class="faq">
    <button class="faq-question">WHAT ARE THE DRESS THEMES?</button>
    <div class="faq-answer">
      <p>The competition will provide specific dress themes, which will be shared during registration.</p>
    </div>
  </div>

  <div class="faq">
    <button class="faq-question">WHAT ARE THE FILE FORMAT AND SIZE REQUIREMENTS?</button>
    <div class="faq-answer">
      <p>Images must be in JPG/PNG format and videos in MP4 format, with size limits mentioned in the guidelines.</p>
    </div>
  </div>

  <div class="faq">
    <button class="faq-question">CAN I SUBMIT MULTIPLE ENTRIES?</button>
    <div class="faq-answer">
      <p>Yes, multiple entries are allowed but each requires a separate registration.</p>
    </div>
  </div>

  <div class="faq">
    <button class="faq-question">HOW WILL THE WINNERS BE SELECTED?</button>
    <div class="faq-answer">
      <p>Winners will be selected by a jury based on creativity, presentation, and adherence to guidelines.</p>
    </div>
  </div>
</section>

<!-- javascript -->


<!-- 9th section -->

<script>
const questions = document.querySelectorAll('.faq-question');

questions.forEach(q => {
  q.addEventListener('click', () => {
    q.classList.toggle('active');
    let answer = q.nextElementSibling;
    if (q.classList.contains('active')) {
      answer.style.maxHeight = answer.scrollHeight + "px";
      answer.style.padding = "15px";
    } else {
      answer.style.maxHeight = null;
      answer.style.padding = "0 15px";
    }
  });
});
</script>


<!-- 8th section -->

<script>
  // Fade-in animation for cards
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".verify-card").forEach((card, i) => {
      card.style.opacity = 0;
      setTimeout(() => {
        card.style.transition = "opacity 0.8s ease";
        card.style.opacity = 1;
      }, i * 300);
    });
  });
</script>



<!-- sixth section script -->


<script>
  // Animate boxes when they come into view
  const winnerSteps = document.querySelectorAll('.winner-step');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if(entry.isIntersecting){
        entry.target.classList.add('visible');
      }
    });
  }, {threshold: 0.2});

  winnerSteps.forEach(step => observer.observe(step));
</script>



<!-- third section script -->


<script>
  // Small fade-in animation when scrolling
  const steps = document.querySelectorAll('.step');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if(entry.isIntersecting){
        entry.target.classList.add('visible');
      }
    });
  }, {threshold: 0.2});

  steps.forEach(step => {
    observer.observe(step);
  });
</script>



<!-- second section script -->


<script>
  // Example small JS effect: pulse checkmark on load
  document.addEventListener("DOMContentLoaded", () => {
    const check = document.querySelector(".checkmark");
    check.animate(
      [
        { transform: "scale(0.5)", opacity: 0 },
        { transform: "scale(1.2)", opacity: 1 },
        { transform: "scale(1)", opacity: 1 }
      ],
      {
        duration: 800,
        easing: "ease-out"
      }
    );
  });
</script>



<!-- first section script -->
  <script>
    document.getElementById("participateBtn").addEventListener("click", () => {
      alert("Thank you for participating! 🎉");
    });
  </script>

@endsection

