@extends('layouts.main')

@section('title', 'Limited Edition')

@section('content')
<link rel="stylesheet" href="{{ asset('/assets/css/limitedEdition.css') }}">

<main class="mainContainer">
  <div class="main-wrapper">
    <section class="limited-edition-section">
      <div class="text-content">
        <h1>Vedaro Limited Edition</h1>
        <p>
          Vedaro’s Limited Edition is not just jewelry — it’s a statement of rarity.
          Each design is handcrafted in exclusive numbers, blending timeless artistry
          with modern elegance. Once gone, never again.
        </p>
      </div>
      <div class="image-content">
        <img
          src="{{ asset('assets/images/limited_edition/Image_Large.png') }}"
          alt="Limited Edition Rings"
        />
      </div>
    </section>

<section class="product-grid">
    @forelse ($limitedEditionProducts as $product)
        @php
            $variant = null;

            // Default pricing
            $displayPrice = $product->discountPrice ?? $product->price ?? 0;
            $oldPrice = $product->price ?? null;

            // ✅ Handle variant-type products
            if ($product->product_type === 'variant') {
                $variant = App\Models\ProductVariant::where('product_id', $product->id)->first();

                if ($variant) {
                    $displayPrice = $variant->discount_price ?? $variant->price ?? 0;
                    $oldPrice = $variant->price ?? null;
                }
            }

            // ✅ Image handling
            $image = $variant && $variant->image
                ? $variant->image
                : ($product->image1 ?? 'default.jpg');

            // ✅ Stock check
            $inStock = $variant
                ? (($variant->stock_quantity ?? 0) > 0)
                : (($product->current_stock ?? 0) > 0);
        @endphp

        <div class="product-card">
            <div class="product-image position-relative">
                <span class="badge bg-danger text-white">Limited Edition</span>

{{-- ❤️ Wishlist Button --}}
<form class="wishlist-form position-absolute top-0 end-0 m-2">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <button type="submit" class="bg-transparent border-0 wishlist-btn" data-id="{{ $product->id }}">
        <i class="fa-regular fa-heart fs-5 text-light"></i>
    </button>
</form>



                <a href="{{ url('/product_details/' . urlencode($product->productName)) }}">
                    <img 
                        src="{{ asset('storage/products/' . $image) }}" 
                        alt="{{ $product->productName }}" 
                        class="img-fluid rounded-top"
                    />
                </a>
            </div>

            <div class="product-info p-2">
                <h3 class="h6 text-truncate mb-1">{{ $product->productName }}</h3>
                <p class="text-muted small mb-2">{{ Str::limit($product->productDescription1, 120) }}</p>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <span class="price fw-bold">₹{{ number_format($displayPrice, 2) }}</span>
                        @if($oldPrice && $oldPrice > $displayPrice)
                            <span class="old-price text-muted text-decoration-line-through">
                                ₹{{ number_format($oldPrice, 2) }}
                            </span>
                        @endif
                    </div>

                    {{-- Add to Cart or Prebook --}}
                    @if($inStock)
                        <form id="purchaseButtons-{{ $product->id }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_qty" value="1">
                            <button type="submit" class="add-to-cart btn btn-primary btn-sm">
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <form action="{{ url('/product_details/' . urlencode($product->productName)) }}" method="GET">
                            <button type="submit" class="add-to-cart btn btn-outline-secondary btn-sm">
                                Prebook on WhatsApp
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p class="text-center mt-4">No Limited Edition products available at the moment.</p>
    @endforelse
</section>

    <div class="custom-section">
      <img
        src="{{ asset('assets/images/limited_edition/Limited_Edition_Page_Banner_Large.png') }}"
        alt="Box Image"
      />
    </div>

  </div>
</main>

{{-- jQuery and SweetAlert --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // CSRF token setup
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  // Handle Add to Cart
  $(document).on('submit', 'form[id^="purchaseButtons-"]', function(e) {
      e.preventDefault();
      let form = $(this);
      let button = form.find('.add-to-cart');
      let formData = form.serialize();

      $.ajax({
          type: "POST",
          url: "{{ route('cart.add') }}",
          data: formData,
          success: function(response) {
              Swal.fire({
                  icon: 'success',
                  title: 'Added!',
                  text: response.message ?? 'Product added to cart.',
                  timer: 1500,
                  showConfirmButton: false
              });

              button.text('Added').addClass('btn-success').removeClass('btn-primary').prop('disabled', true);
              updateCartCount();
          },
          error: function(xhr) {
              Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: xhr.responseJSON?.message ?? 'Something went wrong!'
              });
          }
      });
  });

  // Update cart count
  function updateCartCount() {
      $.ajax({
          url: "{{ route('cart.count') }}",
          type: "GET",
          success: function(data) {
              $('#cart-count').text(data.count);
          }
      });
  }
</script>

<script>
    // 🛡️ CSRF setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ❤️ Handle Wishlist Add
    $(document).on('submit', 'form.wishlist-form', function(e) {
        e.preventDefault();

        let form = $(this);
        let button = form.find('.wishlist-btn');
        let icon = button.find('i');
        let formData = form.serialize();

        $.ajax({
            type: "POST",
            url: "{{ route('wishlist.store') }}", // ✅ keep your route
            data: formData,
            success: function(response) {
                // ✅ Show SweetAlert success
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message ?? 'Added to wishlist!',
                    showConfirmButton: false,
                    timer: 2000
                });

                // ❤️ Visually toggle the heart
                icon.removeClass('fa-regular text-light')
                    .addClass('fa-solid')
                    .css('color', '#ff0000');
            },
            error: function(xhr) {
                let message = 'Something went wrong!';
                
                // ✅ Handle duplicate wishlist (already exists)
                if (xhr.status === 409) {
                    message = 'Product is already in your wishlist.';
                } else if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'info',
                    title: 'Heads Up!',
                    text: message,
                    showConfirmButton: false,
                    timer: 2000
                });

                // ❤️ If already exists, make sure the heart stays filled
                if (xhr.status === 409) {
                    icon.removeClass('fa-regular text-light')
                        .addClass('fa-solid')
                        .css('color', '#ff0000');
                }
            }
        });
    });
</script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
