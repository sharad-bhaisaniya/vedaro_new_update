@extends('layouts.main')

@section('title', 'About')

@section('content')
    <!-- Hero Section -->
  <section 
  class="hero-section d-flex align-items-center justify-content-center text-center px-3" 
  style="
    background-image: url('https://cdn.pixabay.com/photo/2015/05/31/15/04/plastic-792092_1280.jpg');
    height: 100vh;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    position: relative;
    color: #fff;
  "
>
  <!-- Optional: Dark overlay for better text readability -->
  <div style="position:absolute; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.4); z-index:1;"></div>

  <div class="text-center px-3" style="z-index: 2; max-width: 700px;">
    <p class="text-uppercase small fw-bold mb-3" style="letter-spacing: 2px;">About VEDARO</p>
    <h2 class="display-5 fw-semibold lh-sm">
      Scandinavian elegance<br>
      <span style="color: #f2c5c5;">with a New York pulse</span>
    </h2>
  </div>
</section>

<!--------------------------------------------------------External Section----------------------------------------------------------------------------->
<section id="founder-section" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 text-center  mb-4 mb-md-0">
                <h2 class="h2 mb-3 " style="    font-size: 50px; font-family:Syne, sans-serif;">Meet our Founder,<br> Una Langgaard</h2>
                <div class="lead" style="font-size:16px">
                    <p>Primavera was founded by Una Langgaard, a Copenhagen-born designer who moved to New York in the 90's.</p>
                    <p>Growing up surrounded by the quiet elegance of Scandinavian design, she was also fascinated by the energy and chaos of New York. From the beginning, Primavera was about balance — sleek, architectural lines softened by the asymmetry of a petal, a vine, or the curve of a wave. Today, Primavera is celebrated as the epitome of quiet luxury.</p>
                </div>
            </div>

            <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-end">
                <div class="text-center text-md-end">
                    <img
                        src="//primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=2200"
                        alt="Una Langgaard, a white woman with gray hair smiles at the camera."
                        srcset="//primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=200 200w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=300 300w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=400 400w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=500 500w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=600 600w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=800 800w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=1000 1000w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=1200 1200w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=1400 1400w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=1600 1600w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=1800 1800w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=2000 2000w, //primavera-precision.myshopify.com/cdn/shop/files/una-langgaard.jpg?v=1738239436&amp;width=2200 2200w"
                        width="2200" height="2200" loading="lazy" class="img-fluid rounded"
                    >
                </div>
            </div>
        </div>
    </section>

  <!-- -----------------------------------------------company---------------------------------------------------------------- -->
<section class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <img src="https://cdn.pixabay.com/photo/2017/06/17/17/31/jewellery-2412842_1280.jpg" alt="Jewelry" class="img-fluid rounded shadow" style="height: 400px; width: 100%; object-fit: cover;">
                </div>
                <div class="col-md-6 text-center ">
                    <p class="text-uppercase small text-secondary mb-2">Our Commitment</p>
                    <h2 class="display-6 fw-semibold lh-sm mb-4">
                        Sustainably Crafted,<br>Eternally Beautiful
                    </h2>
                    <p class="text-secondary mb-4">
                        At VEDARO, luxury meets responsibility. Our fine jewelry is crafted with ethically
                        sourced gemstones and recycled precious metals, ensuring beauty without compromise.
                        We partner with sustainable suppliers to create pieces that shine with integrity—for
                        you and the planet.
                    </p>
                    <a href="#" class="btn btn-dark px-4 py-2 rounded-0">
                        About
                    </a>
                </div>
            </div>
        </div>
    </section>
  <!-- ---------------------------------------------------------------------------------------------------------------------- -->
  <!--<section class="bg-[#FDF1E7] px-3 py-5">-->
  <!--      <div class="text-center mb-5">-->
  <!--        <p class="small tracking-widest text-muted text-uppercase">-->
  <!--          Recent Entries From The-->
  <!--        </p>-->
  <!--        <h2 class="fs-3 fw-semibold text-dark">VEDARO Journal</h2>-->
  <!--      </div>-->

  <!--      <div class="row g-4 mx-auto" style="max-width: 1200px">-->
  <!--        <div class="col-12 col-md-4">-->
  <!--          <img src="https://cdn.pixabay.com/photo/2023/09/02/11/43/woman-8228723_1280.jpg" alt="Card 1" class="w-100 img-fluid" style="min-height: 600px; object-fit: cover">-->
  <!--          <p class="small text-uppercase text-muted mt-3">News | Tech</p>-->
  <!--          <h3 class="fs-5 fw-medium text-dark mt-1">-->
  <!--            Eva Gutierrez Lindahl &amp; VEDARO: The Future of Jewelry-->
  <!--          </h3>-->
  <!--          <div class="mt-3">-->
  <!--            <button class="btn bg-[#1E1E3F] text-white px-4 py-2 small text-uppercase" style="background-color: #1E1E3F">-->
  <!--              View All-->
  <!--            </button>-->
  <!--          </div>-->
  <!--        </div>-->

  <!--        <div class="col-12 col-md-4">-->
  <!--          <img src="https://cdn.pixabay.com/photo/2021/12/07/02/38/woman-6851973_1280.jpg" alt="Card 2" class="w-100 img-fluid" style="min-height: 600px; object-fit: cover">-->
  <!--          <p class="small text-uppercase text-muted mt-3">News | Stories</p>-->
  <!--          <h3 class="fs-5 fw-medium text-dark mt-1">-->
  <!--            Behind the collection: Small, beautiful things-->
  <!--          </h3>-->
  <!--          <div class="mt-3">-->
  <!--            <button class="btn bg-[#1E1E3F] text-white px-4 py-2 small text-uppercase" style="background-color: #1E1E3F">-->
  <!--              View All-->
  <!--            </button>-->
  <!--          </div>-->
  <!--        </div>-->

  <!--        <div class="col-12 col-md-4">-->
  <!--          <img src="https://cdn.pixabay.com/photo/2020/12/08/19/12/woman-5815354_1280.jpg" alt="Card 3" class="w-100 img-fluid object-cover" style="min-height: 600px">-->
  <!--          <p class="small text-uppercase text-muted mt-3">Hollywood | News</p>-->
  <!--          <h3 class="fs-5 fw-medium text-dark mt-1">-->
  <!--            Lina Walker-Smith Shines in VEDARO While Filming in New York-->
  <!--          </h3>-->
  <!--          <div class="mt-3">-->
  <!--            <button class="btn  text-white px-4 py-2 small text-uppercase" style="background-color: #1E1E3F">-->
  <!--              View All-->
  <!--            </button>-->
  <!--          </div>-->
  <!--        </div>-->
  <!--      </div>-->
  <!--    </section>-->
  
  <section id="blog-posts-section" class="py-5" style="background-color: #FDF1E3;">
    <div class="container container-xl">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <p class="text-muted mb-2">Recent Entries From The</p>
                <h2 class="display-4 fw-bold">Primavera Journal</h2>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <div class="card h-100  border-0" style="background-color:#FDF1E3;">
                    <a href="/blogs/news/ava-gutierrez-primavera-the-future-of-jewelry-powered-by-ai">
                        <img src="//primavera-precision.myshopify.com/cdn/shop/articles/eva-gutierrez-lindahl_4954340f-6b10-472d-87de-26554edb1533.jpg?v=1743070230&amp;width=2500" class="card-img-top" alt="A woman in a white pantsuit exits a car.">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex flex-wrap gap-2 mb-2 small text-muted">
                            <a href="/blogs/news/tagged/news" class="text-decoration-none text-muted">News</a>
                            <span class="text-dark">|</span>
                            <a href="/blogs/news/tagged/tech" class="text-decoration-none text-muted">Tech</a>
                        </div>
                        <h5 class="card-title h5">
                            <a href="/blogs/news/ava-gutierrez-primavera-the-future-of-jewelry-powered-by-ai" class="text-dark text-decoration-none stretched-link"style="font-size:30px">Eva Gutierrez Lindahl &amp; Primavera: The Future of Jewelry</a>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100  border-0" style="background-color: #FDF1E3;>
                    <a href="/blogs/news/behind-the-collection-small-beautiful-things">
                        <img src="//primavera-precision.myshopify.com/cdn/shop/articles/blog-2_ed53c0c2-3c16-4dcb-92d3-9cf250db00c5.jpg?v=1740459552&amp;width=2500" class="card-img-top" alt="An asymmetric gold ring with a break in the middle encrusted in diamonds.">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex flex-wrap gap-2 mb-2 small text-muted">
                            <a href="/blogs/news/tagged/news" class="text-decoration-none text-muted">News</a>
                            <span class="text-dark">|</span>
                            <a href="/blogs/news/tagged/stories" class="text-decoration-none text-muted">Stories</a>
                        </div>
                        <h5 class="card-title h5">
                            <a href="/blogs/news/behind-the-collection-small-beautiful-things" class="text-dark text-decoration-none stretched-link"style="font-size:30px">Behind the collection: Small, beautiful things</a>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100  border-0" style="background-color: #FDF1E3;">
                    <a href="/blogs/news/lina-walker-smith-shines-in-primavera-while-filming-in-new-york">
                        <img src="//primavera-precision.myshopify.com/cdn/shop/articles/instagram-1_7c6247e8-2245-4d57-ab7b-ab62f8a9537b.jpg?v=1740459609&amp;width=2500" class="card-img-top" alt="A blonde celebrity in a matching white-gold tennis necklace and bracelet set.">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex flex-wrap gap-2 mb-2 small text-muted">
                            <a href="/blogs/news/tagged/hollywood" class="text-decoration-none text-muted">Hollywood</a>
                            <span class="text-dark">|</span>
                            <a href="/blogs/news/tagged/news" class="text-decoration-none text-muted">News</a>
                        </div>
                        <h5 class="card-title h5">
                            <a href="/blogs/news/lina-walker-smith-shines-in-primavera-while-filming-in-new-york" class="text-dark text-decoration-none stretched-link"style="font-size:30px">Lina Walker-Smith Shines in Primavera While Filming in New York</a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="/blogs/news" class="btn  btn-lg text-white " style="background-color:#32304E; border-radius:0;">View All</a>
            </div>
        </div>
    </div>
</section>

<section class="d-flex align-items-center justify-content-center px-3 py-5 text-white" style="background-image: url('https://cdn.pixabay.com/photo/2018/10/10/06/16/ring-3736503_1280.jpg'); background-size: cover; background-position: center; min-height: 100vh;">
  <div class="text-center container" style="max-width: 600px;">
    <p class="text-uppercase small mb-3">Stay Connected</p>
    <h1 class="display-4 fw-bold mb-4">Subscribe to<br>our Newsletter</h1>
    <p class="mb-4">
      Sign up for VEDARO's newsletter and be the first to discover the latest collections, special
      offers, and behind-the-scenes glimpses.
    </p>
    <form class="row g-2 justify-content-center">
      <div class="col-12 col-sm-auto">
        <input type="email" class="form-control px-3 py-2" placeholder="Email">
      </div>
      <div class="col-12 col-sm-auto">
        <button type="submit" class="btn btn-light text-dark px-4 py-2">Subscribe</button>
      </div>
    </form>
  </div>
</section>

  <!-- ----------------------------------------------------team-------------------------------------------------------------- -->
  <section class="bg-[#FDF1E7] py-5 px-3">
      <div class="container mx-auto row g-4 text-center" style="max-width: 1140px">
        <div class="col-12 col-md-4 d-flex flex-column align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#1E1E3F] mb-3" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l8.5 5.1L20 7M3 17l8.5-5.1L20 17M3 12l8.5 5.1L20 12"></path>
          </svg>
          <h3 class="fs-5 fw-medium text-[#1E1E3F] mb-2">
            Free Shipping &amp; Returns
          </h3>
          <p class="text-muted">
            We offer worldwide complimentary<br>shipping and returns on all
            orders.
          </p>
        </div>

        <div class="col-12 col-md-4 d-flex flex-column align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#1E1E3F] mb-3" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 100 20 10 10 0 000-20zM2 12h20"></path>
          </svg>
          <h3 class="fs-5 fw-medium text-[#1E1E3F] mb-2">
            Committed to Climate Action
          </h3>
          <p class="text-muted">
            We're committed to using sustainable<br>materials in a responsible
            way.
          </p>
        </div>

        <div class="col-12 col-md-4 d-flex flex-column align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#1E1E3F] mb-3" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6
                           3.5 4 5.5 4c1.54 0 3.04.99 3.57 2.36h1.87C13.46 4.99
                           14.96 4 16.5 4 18.5 4 20 6 20 8.5c0 3.78-3.4 6.86-8.55
                           11.54L12 21.35z"></path>
          </svg>
          <h3 class="fs-5 fw-medium text-[#1E1E3F] mb-2">Customer Love</h3>
          <p class="text-muted">
            Speak to one of our expert consultants<br>via email or text,
            Monday through Sunday.
          </p>
        </div>
      </div>
    </section>


  <!-- ----------------------------------------footer------------------------------------------ -->
  <!-- -----------------------------------------------Why Choose Us------------------------------------------- -->
{{-- <div class="container py-5">
  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="display-4">Why Choose <span class="text-warning">Mahakaaal Creations?</span></h2>
      <p>At Mahakaaal Creations, we stand as a symbol of spirituality, authenticity, and divine craftsmanship. Here’s why our customers trust us:</p>
    </div>
  </div>
  <div class="row">
    <!-- Reason 1 -->
    <div class="col-md-4 mb-4">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">Authentic & Divine Products</h5>
          <p class="card-text">
            We offer only the most authentic and handcrafted spiritual items, ensuring that every product brings true blessings and divine energy into your life.
          </p>
        </div>
      </div>
    </div>
    <!-- Reason 2 -->
    <div class="col-md-4 mb-4">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">Uncompromising Quality</h5>
          <p class="card-text">
            Each product undergoes strict quality checks, ensuring that we only offer the finest and most durable spiritual items for your home and rituals.
          </p>
        </div>
      </div>
    </div>
    <!-- Reason 3 -->
    <div class="col-md-4 mb-4">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">Exceptional Customer Service</h5>
          <p class="card-text">
            We are committed to providing a seamless shopping experience, with dedicated customer support to ensure your complete satisfaction.
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <!-- Reason 4 -->
    <div class="col-md-4 mb-4">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">A True Spiritual Connection</h5>
          <p class="card-text">
            Our products aren’t just items – they are tools that help you connect deeply with your spiritual practices, bringing you closer to the divine.
          </p>
        </div>
      </div>
    </div>
    <!-- Reason 5 -->
    <div class="col-md-4 mb-4">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">Worldwide Delivery</h5>
          <p class="card-text">
            No matter where you are, we bring Mahakaaal Creations'  offerings to your doorstep, making them accessible to devotees across the globe.
          </p>
        </div>
      </div>
    </div>
    <!-- Reason 6 -->
    <div class="col-md-4 mb-4">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">Sustainable Practices</h5>
          <p class="card-text">
            We are committed to sustainability, using eco-friendly materials and ethical sourcing practices to protect both the divine and the environment.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container py-5">
  <div class="row align-items-center">

    <div class="col-md-12">
      <h2 class="display-4">Contact
          <span class="text-warning">  Us</span></h2>
      <p>

        <b>  We invite </b>  you to explore our diverse offerings and immerse yourself in the spiritual experience that Mahakaaal Creations provides. From sacred idols to thoughtful gifts, each product is a testament to the divine energy that Mahakal represents. Join us in celebrating the power of Mahakaal, and let our creations be a part of your spiritual journey.


      </p>
      Got a question or need assistance? Reach out to us at <span class="text-warning">support@mahakaaal.com </span>or call us at <span class="text-warning"> +91 90796 73886.</span>



      </p>
    </div>



    </div>
  </div>
</div>



<style>
  .text-warning {
    --bs-text-opacity: 1;
    color: #ee2d7a !important; /* This is the new color */
}
</style>
 --}}







@endsection
