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
                <h2 class="h2 mb-3 " style="    font-size: 50px; font-family:Syne, sans-serif;">Meet our Founder,<br>Bhavya Garodia</h2>
                <div class="lead" style="font-size:16px">
                    <p>Vedaro was founded by Bhavya Garodia, a young visionary from Rajasthan with an old soul and a deep reverence for timeless beauty.</p>
                    <p>
                        Raised amidst the spiritual richness of Indian tradition and driven by a passion for design, Bhavya envisioned a brand where purity meets purpose. Vedaro was born not just to adorn, but to tell stories — of devotion, detail, and quiet luxury. Each piece reflects his belief: that true elegance lies in simplicity, and meaning is the finest ornament.
                        
                        </p>
                                        <p>Today, Vedaro stands as a tribute to handcrafted silver — rare, rooted, and radiant.
                        </p></div>
            </div>

            <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-end">
                <div class="text-center text-md-end">
                    <img
                        src="{{ asset('public/assets/images/about/pic.jpg') }}"
                        alt="Una Langgaard, a white woman with gray hair smiles at the camera."

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
                        <img src="{{ asset('public/assets/images/about/ab1.jpeg') }}" class="card-img-top" alt="A woman in a white pantsuit exits a car.">
                    </a>
                    <!--<div class="card-body d-flex flex-column">-->
                    <!--    <div class="d-flex flex-wrap gap-2 mb-2 small text-muted">-->
                    <!--        <a href="/blogs/news/tagged/news" class="text-decoration-none text-muted">News</a>-->
                    <!--        <span class="text-dark">|</span>-->
                    <!--        <a href="#" class="text-decoration-none text-muted">Tech</a>-->
                    <!--    </div>-->
                    <!--    <h5 class="card-title h5">-->
                    <!--        <a href="/blogs/news/ava-gutierrez-primavera-the-future-of-jewelry-powered-by-ai" class="text-dark text-decoration-none stretched-link"style="font-size:30px">Eva Gutierrez Lindahl &amp; Primavera: The Future of Jewelry</a>-->
                    <!--    </h5>-->
                    <!--</div>-->
                </div>
            </div>

            <div class="col">
                <div class="card h-100  border-0" style="background-color: #FDF1E3;">
                    <a href="/blogs/news/behind-the-collection-small-beautiful-things">
                        <img src="{{ asset('public/assets/images/about/ab2.jpeg') }}" class="card-img-top" alt="An asymmetric gold ring with a break in the middle encrusted in diamonds.">
                    </a>
                    <!--<div class="card-body d-flex flex-column">-->
                    <!--    <div class="d-flex flex-wrap gap-2 mb-2 small text-muted">-->
                    <!--        <a href="/blogs/news/tagged/news" class="text-decoration-none text-muted">News</a>-->
                    <!--        <span class="text-dark">|</span>-->
                    <!--        <a href="/blogs/news/tagged/stories" class="text-decoration-none text-muted">Stories</a>-->
                    <!--    </div>-->
                    <!--    <h5 class="card-title h5">-->
                    <!--        <a href="/blogs/news/behind-the-collection-small-beautiful-things" class="text-dark text-decoration-none stretched-link"style="font-size:30px">Behind the collection: Small, beautiful things</a>-->
                    <!--    </h5>-->
                    <!--</div>-->
                </div>
            </div>

            <div class="col">
                <div class="card h-100  border-0" style="background-color: #FDF1E3;">
                    <a href="/blogs/news/lina-walker-smith-shines-in-primavera-while-filming-in-new-york">
                        <img src="{{ asset('public/assets/images/about/ab4.jpeg') }}" class="card-img-top" alt="A blonde celebrity in a matching white-gold tennis necklace and bracelet set.">
                    </a>
                    <!--<div class="card-body d-flex flex-column">-->
                    <!--    <div class="d-flex flex-wrap gap-2 mb-2 small text-muted">-->
                    <!--        <a href="/blogs/news/tagged/hollywood" class="text-decoration-none text-muted">Hollywood</a>-->
                    <!--        <span class="text-dark">|</span>-->
                    <!--        <a href="/blogs/news/tagged/news" class="text-decoration-none text-muted">News</a>-->
                    <!--    </div>-->
                    <!--    <h5 class="card-title h5">-->
                    <!--        <a href="/blogs/news/lina-walker-smith-shines-in-primavera-while-filming-in-new-york" class="text-dark text-decoration-none stretched-link"style="font-size:30px">Lina Walker-Smith Shines in Primavera While Filming in New York</a>-->
                    <!--    </h5>-->
                    <!--</div>-->
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="#" class="btn  btn-lg text-white " style="background-color:#32304E; border-radius:0;">View All</a>
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






@endsection
