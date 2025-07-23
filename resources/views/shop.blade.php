@extends('layouts.main')

@section('content')
<div class="container-fluid" style="margin-block:150px;">
    
    
     {{--<script>
      function toggleFilterSidebar() {
        const sidebar = document.getElementById("filterSidebar");
        const backdrop = document.getElementById("filterBackdrop");

        sidebar.classList.toggle("active");
        backdrop.classList.toggle("active");

        // Hide/show scrollbar on body to prevent content from shifting
        if (sidebar.classList.contains("active")) {
          document.body.style.overflow = "hidden";
        } else {
          document.body.style.overflow = "";
        }
      }
    </script>--}}
  {{--  <style>
          /* General Styles for Filter Sidebar (Default: Large Screens) */
          #filterSidebar {
            position: fixed;
            top: 0;
            right: -100%; /* Initially off-screen to the right */
            width: 85%;
            max-width: 320px; /* Max width for larger screens */
            height: 100vh;
            background-color: #fff;
            z-index: 1055;
            overflow-y: auto;
            transition: right 0.3s ease-in-out;
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.2);
          }
    
          #filterSidebar.active {
            right: 0; /* Slides into view from the right */
          }
    
          /* General Styles for Backdrop (Default: Large Screens) */
          #filterBackdrop {
            position: fixed;
            inset: 0;
            z-index: 1050;
            background: rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(4px);
            display: none; /* Hidden by default */
            transition: opacity 0.3s ease-in-out; /* Smooth fade */
            opacity: 0;
          }
    
          #filterBackdrop.active {
            display: block; /* Show the backdrop */
            opacity: 1;
          }
    
          /* Swatch Circle - Keep as is */
          .swatch-circle {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 1px solid #ccc;
            background-size: cover;
            background-position: center;
            display: inline-block;
          }
    
          /* MEDIA QUERY FOR SMALL SCREENS (<= 767.98px) */
          @media (max-width: 767.98px) {
            #filterSidebar {
              right: unset; /* Remove the right property from large screen */
              left: -100%; /* Instead, slide in from the left */
              width: 80%; /* Adjust width for small screens */
              /* max-width is still effective but won't be hit with 80% width on small screens */
              background: rgba(255, 255, 255, 0.95); /* Semi-transparent white */
              backdrop-filter: blur(8px); /* Stronger blur for sidebar */
              box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15); /* Shadow for left slide */
              transform: translateX(0); /* Reset transform */
              transition: left 0.3s ease-in-out; /* Transition 'left' property */
            }
    
            #filterSidebar.active {
              left: 0; /* Slides into view from the left */
            }
    
            /* Remove overlay-blur, use filterBackdrop consistently */
            /* If you want a different backdrop style for small screens, define it here */
            #filterBackdrop.active {
              background: rgba(
                0,
                0,
                0,
                0.3
              ); /* Slightly darker backdrop for small screens */
              backdrop-filter: blur(
                5px
              ); /* Stronger blur for backdrop on small screens */
            }
          }
        </style> --}}
       {{--    <div class="layout-container" style="margin-top:100px;">
          <main class="product-content">
            <div class="d-block d-md-none text-end p-2">
              <button
                class="btn btn-outline-dark btn-sm"
                onclick="toggleFilterSidebar()"
              >
                Filters
              </button>
            </div>
    
            <div class="container py-4 position-relative">
              <div class="row">
                <div class="col-md-4 col-lg-3 d-none d-md-block">
                  <button
                    class="btn btn-outline-dark btn-sm"
                    onclick="toggleFilterSidebar()"
                  >
                    Open Filters
                  </button>
                  
                </div>
    
                <div class="col-md-8 col-lg-9">
                  <form
                    class="d-flex align-items-center gap-2 justify-content-between mb-3"
                  >
                    <div>
                      <p class="mb-0">Showing <strong>4</strong> products</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                      <label for="SortBy" class="mb-0">Sort by:</label>
                      <select id="SortBy" class="form-select form-select-sm w-auto">
                        <option value="manual">Featured</option>
                        <option value="best-selling">Best selling</option>
                        <option value="title-ascending">A-Z</option>
                        <option value="title-descending">Z-A</option>
                        <option value="price-ascending">Price, low to high</option>
                        <option value="price-descending">Price, high to low</option>
                        <option value="created-ascending">Old to new</option>
                        <option value="created-descending">New to old</option>
                      </select>
                    </div>
                  </form>
                </div>
              </div>
            </div>
    
            <div id="filterBackdrop" onclick="toggleFilterSidebar()"></div>
    
            <aside id="filterSidebar">
              <div
                class="border-bottom p-3 d-flex justify-content-between align-items-center"
              >
                <h5 class="mb-0">Filters</h5>
                <button class="btn-close" onclick="toggleFilterSidebar()"></button>
              </div>
    
              <div class="p-3">
                <div class="mb-3">
                  <button
                    class="btn btn-sm btn-link p-0"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#filterCategory"
                  >
                    <strong>Category</strong>
                  </button>
                  <div class="collapse show" id="filterCategory">
                    <div class="form-check mt-2">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="cat1"
                      /><label class="form-check-label" for="cat1"
                        >Bracelets (2)</label
                      >
                    </div>
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="cat2"
                      /><label class="form-check-label" for="cat2"
                        >Earrings (3)</label
                      >
                    </div>
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="cat3"
                      /><label class="form-check-label" for="cat3"
                        >Necklaces (4)</label
                      >
                    </div>
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="cat4"
                      /><label class="form-check-label" for="cat4">Rings (4)</label>
                    </div>
                  </div>
                </div>
    
                <div class="mb-3">
                  <button
                    class="btn btn-sm btn-link p-0"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#filterMaterial"
                  >
                    <strong>Material</strong>
                  </button>
                  <div class="collapse show" id="filterMaterial">
                    <div class="form-check mt-2 d-flex align-items-center gap-2">
                      <input class="form-check-input" type="checkbox" id="mat1" />
                      <span
                        class="swatch-circle"
                        style="
                          background-image: url('//primavera-precision.myshopify.com/cdn/shop/files/yellow-gold-swatch.jpg?v=1737658404');
                        "
                      ></span>
                      <label class="form-check-label" for="mat1"
                        >Yellow Gold (12)</label
                      >
                    </div>
                    <div class="form-check d-flex align-items-center gap-2">
                      <input class="form-check-input" type="checkbox" id="mat2" />
                      <span
                        class="swatch-circle"
                        style="
                          background-image: url('//primavera-precision.myshopify.com/cdn/shop/files/white-gold-swatch.jpg?v=1737658382');
                        "
                      ></span>
                      <label class="form-check-label" for="mat2"
                        >White Gold (1)</label
                      >
                    </div>
                    <div class="form-check d-flex align-items-center gap-2">
                      <input class="form-check-input" type="checkbox" id="mat3" />
                      <span
                        class="swatch-circle"
                        style="
                          background-image: url('//primavera-precision.myshopify.com/cdn/shop/files/rose-gold-swatch_2.jpg?v=1737660379');
                        "
                      ></span>
                      <label class="form-check-label" for="mat3"
                        >Rose Gold (2)</label
                      >
                    </div>
                  </div>
                </div>
    
                <div class="mb-3">
                  <button
                    class="btn btn-sm btn-link p-0"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#filterStone"
                  >
                    <strong>Stone</strong>
                  </button>
                  <div class="collapse show" id="filterStone">
                    <div class="form-check mt-2">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="stone1"
                      /><label class="form-check-label" for="stone1"
                        >Amethyst (3)</label
                      >
                    </div>
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="stone2"
                      /><label class="form-check-label" for="stone2"
                        >Diamond (6)</label
                      >
                    </div>
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="stone3"
                      /><label class="form-check-label" for="stone3"
                        >Emerald (1)</label
                      >
                    </div>
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="stone4"
                      /><label class="form-check-label" for="stone4"
                        >Pearl (2)</label
                      >
                    </div>
                  </div>
                </div>
    
                <div class="mb-4">
                  <strong class="d-block mb-2">Price Range</strong>
                  <div class="input-group mb-2">
                    <span class="input-group-text">From</span>
                    <input type="number" class="form-control" placeholder="0" />
                  </div>
                  <div class="input-group">
                    <span class="input-group-text">To</span>
                    <input type="number" class="form-control" placeholder="9500" />
                  </div>
                </div>
    
                <div class="d-grid gap-2">
                  <button class="btn btn-dark">View Items (14)</button>
                  <a href="#" class="btn btn-outline-secondary">Clear All</a>
                </div>
              </div>
            </aside>
          </main>
        </div>--}}





<style>
    @media (min-width: 768px) and (max-width: 950px) {
  .all-cards {
    width: 300px !important;
  }
}
</style>
    
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-4">
            <div class="p-3 border rounded bg-light">
                <h5 class="mb-4 text-uppercase text-center" style="font-weight: bold; color: #b08d57;">Jewellery Categories</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{route('shop')}}" class="text-decoration-none text-dark">All Category Products</a>
                        <!--<span class="badge bg-warning text-dark rounded-pill">New</span>-->
                    </li>
                    @foreach($categories as $cat)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('product.show', ['id' => $cat->id]) }}" class="text-decoration-none text-dark">
                                {{ $cat->name }}
                            </a>
                            <span class="badge bg-warning text-dark rounded-pill">New</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="col-md-8">
            <h4 class="mb-4 text-uppercase" style="color: #b08d57; font-weight: bold;">
                @if(request('category'))
                    {{ $currentCategoryName ?? 'Selected Category' }} Products
                @else
                    All Jewellery Category Products
                @endif
            </h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @forelse($products as $product)
                <div class="col all-cards">
                    <div class="card h-100 border-0 shadow-sm position-relative">
                        <img src="{{ asset('storage/products/' . $product->image1) }}" class="img-front" alt="{{ $product->productName }}" style="height: 220px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title text-uppercase" style="color: #b08d57;">{{ $product->name }}</h6>
                            <p class="small text-secondary">{{ $product->productName }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a  href="/product_details/{{ $product->id }}" class="btn btn-outline-warning w-100 text-uppercase">View Details</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted">No products found in this category.</p>
                </div>
                @endforelse
            </div>
        </main>
    </div>
</div>
@endsection



