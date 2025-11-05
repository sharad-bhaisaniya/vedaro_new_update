@extends('layouts.main')
@section('title', 'Product Details')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/productdetails.css') }}">


   <style>
    .size-btn {
        margin: 3px;
        padding: 5px 10px;
        cursor: pointer;
        border: 1px solid #ccc;
        background: #f8f8f8;
        border-radius: 4px;
    }
    .size-btn.active ,.size-box.active {
        border-color: #007bff;
        background: #0f2a1d;
        color: #fff;
    }
</style>
<style>
    /* CSS from previous response. Add it here. */
    .reviews-section { padding: 2rem 0; font-family: Arial, sans-serif; }
    .reviews-container { max-width: 900px; margin: 0 auto; padding: 0 1rem; }
    .reviews-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .reviews-header h2 { font-size: 1.8rem; font-weight: bold; }
    .reviews-header .stars { color: #ffc107; font-size: 1.5rem; }
    .write-review-btn { padding: 0.5rem 1rem; border: 1px solid #007bff; color: white; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; text-decoration: none; }
    .write-review-btn:hover { background-color: #0056b3; }
    .reviews-slider { position: relative; display: flex; align-items: center; }
    .slider-content { display: flex; width: 100%; overflow: hidden; }
    .review-card { flex-shrink: 0; width: 100%; padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px; background-color: #f9f9f9; margin: 0 10px; display: none; animation: fade-in 0.5s ease-in-out; }
    .review-card.active { display: block; }
    .review-card h4 { margin: 0 0 0.5rem; font-size: 1.2rem; font-weight: 600; }
    .review-card .date { color: #888; font-size: 0.9rem; }
    .review-card .stars { color: #ffc107; margin-top: 0.5rem; }
    .review-nav { position: absolute; top: 50%; transform: translateY(-50%); background-color: transparent; border: none; font-size: 2rem; color: #555; cursor: pointer; z-index: 10; }
    .review-nav.prev { left: -20px; }
    .review-nav.next { right: -20px; }
    @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }

    /* Styles for the review form section */
    .review-form-container { padding: 2rem 0; max-width: 700px; margin: 0 auto; }
    .review-title { font-size: 1.5rem; margin-bottom: 1.5rem; text-align: center; }
    .review-form-group { margin-bottom: 1rem; }
    .review-label { display: block; font-weight: bold; margin-bottom: 0.5rem; }
    .review-input, .review-textarea { width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
    .review-textarea { resize: vertical; min-height: 100px; }
    .star-rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; }
    .star-rating input[type="radio"] { display: none; }
    .star-rating label { font-size: 2rem; color: #ccc; cursor: pointer; transition: color 0.2s ease-in-out; }
    .star-rating label:hover,
    .star-rating label:hover ~ label { color: #ffc107; }
    .star-rating input[type="radio"]:checked ~ label { color: #ffc107; }
    .review-btn { width: 100%; padding: 1rem;  border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; }
</style>

  <div class="main-container-product">
    <!-- Fixed Gallery Section -->
 <div class="product-gallery-container">
    <div class="product-section">
        <div class="product-gallery">
            <div class="main-image">
                <img id="main-product-image" src="{{ asset('/storage/products/' . $product->image1) }}" alt="Product">
            </div>
         <div class="thumbnail-row">
    @if(!empty($product->image1))
        <div class="thumbnail">
            <img class="thumbnail-image"
                 src="{{ asset('storage/products/' . $product->image1) }}"
                 data-image="{{ asset('storage/products/' . $product->image1) }}"
                 alt="">
        </div>
    @endif

    @if(!empty($product->image2))
        <div class="thumbnail">
            <img class="thumbnail-image"
                 src="{{ asset('storage/products/' . $product->image2) }}"
                 data-image="{{ asset('storage/products/' . $product->image2) }}"
                 alt="">
        </div>
    @endif

    @if(!empty($product->image3))
        <div class="thumbnail">
            <img class="thumbnail-image"
                 src="{{ asset('storage/products/' . $product->image3) }}"
                 data-image="{{ asset('storage/products/' . $product->image3) }}"
                 alt="">
        </div>
    @endif
</div>

        </div>
    </div>
</div>

<div class="product-content">
          <div class="product-details">
            @php
    $variants = App\Models\ProductVariant::where('product_id', $product->id)->get();
@endphp

<div class="product-details">
    <h1>{{ $product->productName }}</h1>

    <!-- Price & Stock -->
    <div id="variant-price-stock">
        @if($product->product_type != 'variant')
            <div>
                <span class="price">₹{{ $product->discountPrice }}</span>
                @if($product->price != $product->discountPrice)
                    <span class="old-price"><s>₹{{ $product->price }}</s></span>
                @endif
            </div>
            @if($product->current_stock > 0)
                <div class="stock">Hurry up! Only {{ $product->current_stock }} item(s) in stock.</div>
            @endif
        
            <div class="size-container">
                <p class="size-title">Size</p>
                <div class="size-options">
                    <button class="size-box active">Free Size</button>               
                </div>
            </div>
        @else
            @php
                $firstVariant = $variants->first();
            @endphp
            <div>
                <span class="price">₹{{ $firstVariant->discount_price }}</span>
                @if($firstVariant->price != $firstVariant->discount_price)
                    <span class="old-price"><s>₹{{ $firstVariant->price }}</s></span>
                @endif
            </div>
            @if($firstVariant->stock > 0)
                <div class="stock">Hurry up! Only {{ $firstVariant->stock }} item(s) in stock.</div>
            @endif
        @endif
    </div>

    <!-- Size Buttons -->
    @if($product->product_type == 'variant' && $variants->isNotEmpty())
        <div class="size-container">
            <p class="size-title">Size</p>
            <div class="size-options">
                @foreach ($variants as $variant)
                    <button 
                        class="size-btn {{ $loop->first ? 'active' : '' }}" 
                        data-id="{{ $variant->id }}" 
                        data-price="{{ $variant->price }}" 
                        data-discount="{{ $variant->discount_price }}" 
                        data-stock="{{ $variant->stock }}"
                        data-size="{{ $variant->size }}"
                    >
                        {{ $variant->size }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif
</div>

        <div class="features">
            
            
          <div class="feature">
             <div>
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.74 6.61049C19.2146 6.2944 18.6131 6.12738 18 6.12738C17.3869 6.12738 16.7854 6.2944 16.26 6.61049L15.4845 7.07699C13.6053 8.20829 11.4958 8.90243 9.312 9.10799L8.8245 9.15449C8.35978 9.19818 7.92807 9.41363 7.61377 9.75872C7.29947 10.1038 7.12519 10.5537 7.125 11.0205V13.4865C7.12492 15.5495 7.54003 17.5915 8.34559 19.4907C9.15116 21.3899 10.3307 23.1076 11.814 24.5415L16.6965 29.262C17.0462 29.6002 17.5136 29.7892 18 29.7892C18.4864 29.7892 18.9538 29.6002 19.3035 29.262L24.186 24.5415C25.6693 23.1076 26.8488 21.3899 27.6544 19.4907C28.46 17.5915 28.8751 15.5495 28.875 13.4865V11.0205C28.8748 10.5537 28.7005 10.1038 28.3862 9.75872C28.0719 9.41363 27.6402 9.19818 27.1755 9.15449L26.688 9.10949C24.5041 8.90347 22.3945 8.20882 20.5155 7.07699L19.74 6.61049Z" fill="#0F2A1D"/>
                </svg>
             </div>
              <p>6 Months<br>Warranty</p></div>
              
              
          <div class="feature">
              <div><svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M27.6474 10.6994C24.8687 10.5569 22.3987 11.7444 20.7837 13.7038C20.7837 13.7038 18.9668 16.055 18.9668 16.0432C18.9668 16.0432 16.6749 19.0475 16.6868 19.0475L14.7156 21.6363L14.5612 21.8382C13.4331 23.3463 11.4381 24.1894 9.33619 23.5719C8.5492 23.3346 7.83907 22.8932 7.27799 22.2925C6.71692 21.6918 6.32491 20.9532 6.14182 20.1519C5.97811 19.458 5.97332 18.736 6.1278 18.04C6.28228 17.344 6.59204 16.6918 7.03394 16.1323C7.47584 15.5728 8.03846 15.1204 8.67976 14.8088C9.32106 14.4973 10.0245 14.3347 10.7374 14.3332C12.1743 14.3332 13.2431 14.9388 13.9793 15.58C14.7631 16.2688 15.9624 16.1619 16.6037 15.3307C17.1618 14.6063 17.0906 13.5613 16.4256 12.9438C12.6731 9.50003 5.57182 10.2838 3.30369 15.0694C0.358694 21.28 4.84744 27.4075 10.7374 27.4075C13.3262 27.4075 15.6418 26.2557 17.1737 24.4032L17.6843 23.7382C17.6843 23.7382 18.9787 22.04 18.9787 22.0519C18.9787 22.0519 21.2706 19.0475 21.2587 19.0475L23.2656 16.4232L23.4081 16.245C24.4412 14.8438 26.2224 14.0482 28.1818 14.4282C29.9156 14.7725 31.3524 16.1263 31.7799 17.8482C32.5637 20.9713 30.2124 23.7857 27.2081 23.7857C25.7949 23.7857 24.7262 23.18 23.9899 22.5269C23.804 22.3639 23.5866 22.2408 23.3511 22.1652C23.1156 22.0897 22.8671 22.0634 22.621 22.0879C22.375 22.1124 22.1366 22.1872 21.9206 22.3076C21.7046 22.4281 21.5157 22.5917 21.3656 22.7882C20.7837 23.5482 20.8906 24.605 21.6031 25.2463C22.7074 26.2319 24.5956 27.4313 27.2081 27.4313C32.1956 27.4313 36.1737 23.0494 35.4968 17.9313C34.9743 13.9888 31.6018 10.9013 27.6474 10.6994Z" fill="#0F2A1D"/>
                    </svg></div>
              <p>Lifetime<br>Plating</p></div>
              
              
          <div class="feature">
              <div>
                  <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.76959 18.204C9.76959 17.82 9.84159 17.464 9.98559 17.136C10.1376 16.8 10.3456 16.512 10.6096 16.272C10.8736 16.032 11.1896 15.844 11.5576 15.708C11.9256 15.572 12.3336 15.504 12.7816 15.504C13.4136 15.504 13.9456 15.628 14.3776 15.876C14.8096 16.124 15.1576 16.452 15.4216 16.86C15.6856 17.26 15.8736 17.716 15.9856 18.228C16.1056 18.732 16.1656 19.244 16.1656 19.764C16.1656 20.268 16.1016 20.78 15.9736 21.3C15.8456 21.82 15.6376 22.292 15.3496 22.716C15.0616 23.14 14.6896 23.484 14.2336 23.748C13.7776 24.012 13.2176 24.148 12.5536 24.156C12.2336 24.156 11.9256 24.128 11.6296 24.072C11.3416 24.016 11.0856 23.94 10.8616 23.844C10.6456 23.74 10.4696 23.624 10.3336 23.496C10.2056 23.368 10.1416 23.228 10.1416 23.076V21.996C10.1416 21.956 10.1456 21.92 10.1536 21.888C10.1696 21.864 10.1896 21.84 10.2136 21.816C10.2376 21.792 10.2736 21.78 10.3216 21.78C10.4416 21.78 10.5336 21.852 10.5976 21.996C10.6616 22.14 10.7456 22.328 10.8496 22.56C10.9296 22.744 11.0296 22.904 11.1496 23.04C11.2776 23.168 11.4176 23.276 11.5696 23.364C11.7216 23.444 11.8856 23.504 12.0616 23.544C12.2376 23.576 12.4096 23.592 12.5776 23.592C12.8896 23.584 13.1696 23.496 13.4176 23.328C13.6736 23.16 13.8936 22.932 14.0776 22.644C14.2616 22.348 14.4056 22 14.5096 21.6C14.6216 21.2 14.6896 20.768 14.7136 20.304C14.4176 20.488 14.0856 20.632 13.7176 20.736C13.3576 20.84 13.0016 20.892 12.6496 20.892C12.1776 20.892 11.7576 20.82 11.3896 20.676C11.0296 20.532 10.7296 20.336 10.4896 20.088C10.2496 19.84 10.0696 19.556 9.94959 19.236C9.82959 18.908 9.76959 18.564 9.76959 18.204ZM13.0216 20.232C13.2536 20.24 13.5296 20.196 13.8496 20.1C14.1696 20.004 14.4616 19.86 14.7256 19.668C14.7256 19.148 14.6816 18.668 14.5936 18.228C14.5136 17.788 14.3936 17.408 14.2336 17.088C14.0736 16.768 13.8696 16.52 13.6216 16.344C13.3816 16.16 13.0936 16.072 12.7576 16.08C12.5256 16.08 12.3136 16.136 12.1216 16.248C11.9296 16.352 11.7656 16.5 11.6296 16.692C11.4936 16.876 11.3856 17.096 11.3056 17.352C11.2336 17.6 11.1976 17.872 11.1976 18.168C11.1976 18.424 11.2296 18.676 11.2936 18.924C11.3576 19.164 11.4616 19.384 11.6056 19.584C11.7576 19.776 11.9496 19.932 12.1816 20.052C12.4136 20.172 12.6936 20.232 13.0216 20.232ZM22.5014 17.628C22.5014 18.052 22.3934 18.448 22.1774 18.816C21.9694 19.176 21.7014 19.516 21.3734 19.836C21.0534 20.148 20.7054 20.444 20.3294 20.724C19.9614 20.996 19.6134 21.256 19.2854 21.504C18.9654 21.752 18.6974 21.988 18.4814 22.212C18.2734 22.436 18.1694 22.656 18.1694 22.872C18.1694 22.936 18.1894 22.98 18.2294 23.004C18.2694 23.028 18.3174 23.04 18.3734 23.04H20.6774C20.9894 23.04 21.2294 22.992 21.3974 22.896C21.5734 22.8 21.7094 22.7 21.8054 22.596C21.9094 22.484 21.9934 22.38 22.0574 22.284C22.1214 22.188 22.2054 22.14 22.3094 22.14C22.3654 22.14 22.4054 22.156 22.4294 22.188C22.4534 22.22 22.4734 22.252 22.4894 22.284C22.4974 22.324 22.5014 22.372 22.5014 22.428L22.3214 23.724C22.3134 23.78 22.2974 23.832 22.2734 23.88C22.2414 23.912 22.2054 23.944 22.1654 23.976C22.1254 24.008 22.0654 24.024 21.9854 24.024C21.8814 24.024 21.7974 24.02 21.7334 24.012C21.6694 24.004 21.5454 24 21.3614 24H17.3174C17.2134 24 17.1254 23.972 17.0534 23.916C16.9814 23.852 16.9454 23.736 16.9454 23.568C16.9454 23.112 17.0454 22.7 17.2454 22.332C17.4534 21.964 17.7134 21.616 18.0254 21.288C18.3374 20.96 18.6734 20.648 19.0334 20.352C19.3934 20.056 19.7294 19.756 20.0414 19.452C20.3534 19.148 20.6094 18.828 20.8094 18.492C21.0174 18.156 21.1214 17.792 21.1214 17.4C21.1214 17.152 21.0734 16.944 20.9774 16.776C20.8814 16.608 20.7574 16.472 20.6054 16.368C20.4614 16.256 20.2974 16.176 20.1134 16.128C19.9374 16.08 19.7654 16.056 19.5974 16.056C19.4214 16.056 19.2454 16.08 19.0694 16.128C18.9014 16.168 18.7414 16.236 18.5894 16.332C18.4374 16.428 18.3054 16.548 18.1934 16.692C18.0814 16.836 17.9934 17.008 17.9294 17.208C17.8574 17.432 17.7894 17.616 17.7254 17.76C17.6694 17.904 17.5814 17.976 17.4614 17.976C17.4134 17.976 17.3734 17.964 17.3414 17.94C17.3094 17.916 17.2854 17.892 17.2694 17.868C17.2534 17.836 17.2454 17.8 17.2454 17.76L17.1854 16.704C17.1694 16.536 17.2294 16.38 17.3654 16.236C17.5014 16.092 17.6854 15.964 17.9174 15.852C18.1574 15.74 18.4334 15.652 18.7454 15.588C19.0574 15.524 19.3814 15.492 19.7174 15.492C20.1254 15.492 20.5014 15.544 20.8454 15.648C21.1894 15.752 21.4814 15.9 21.7214 16.092C21.9694 16.276 22.1614 16.5 22.2974 16.764C22.4334 17.028 22.5014 17.316 22.5014 17.628ZM26.1016 24.156C25.7816 24.156 25.4656 24.124 25.1536 24.06C24.8496 23.996 24.5736 23.912 24.3256 23.808C24.0856 23.696 23.8896 23.564 23.7376 23.412C23.5936 23.26 23.5216 23.096 23.5216 22.92V21.876C23.5216 21.844 23.5256 21.812 23.5336 21.78C23.5496 21.756 23.5696 21.732 23.5936 21.708C23.6256 21.684 23.6656 21.672 23.7136 21.672C23.7776 21.672 23.8296 21.692 23.8696 21.732C23.9096 21.764 23.9456 21.812 23.9776 21.876C24.0096 21.94 24.0416 22.016 24.0736 22.104C24.1056 22.184 24.1376 22.276 24.1696 22.38C24.2416 22.564 24.3416 22.732 24.4696 22.884C24.5976 23.036 24.7416 23.164 24.9016 23.268C25.0696 23.364 25.2456 23.444 25.4296 23.508C25.6216 23.564 25.8056 23.592 25.9816 23.592C26.4056 23.592 26.7576 23.484 27.0376 23.268C27.3176 23.052 27.5256 22.784 27.6616 22.464C27.8056 22.136 27.8776 21.784 27.8776 21.408C27.8856 21.024 27.8256 20.672 27.6976 20.352C27.5696 20.024 27.3776 19.752 27.1216 19.536C26.8656 19.32 26.5496 19.212 26.1736 19.212C25.8296 19.212 25.5496 19.248 25.3336 19.32C25.1256 19.392 24.9456 19.464 24.7936 19.536C24.6336 19.616 24.5256 19.668 24.4696 19.692C24.4136 19.716 24.3496 19.728 24.2776 19.728H24.0496C24.0176 19.728 23.9856 19.724 23.9536 19.716C23.9376 19.7 23.9176 19.68 23.8936 19.656C23.8776 19.624 23.8736 19.588 23.8816 19.548L23.9656 15.912C23.9656 15.864 23.9776 15.828 24.0016 15.804C24.0256 15.772 24.0496 15.752 24.0736 15.744C24.1056 15.728 24.1416 15.72 24.1816 15.72H28.5256C28.5736 15.72 28.6096 15.732 28.6336 15.756C28.6576 15.772 28.6776 15.792 28.6936 15.816C28.7016 15.848 28.7056 15.884 28.7056 15.924V16.704C28.7056 16.736 28.7016 16.768 28.6936 16.8C28.6776 16.824 28.6576 16.848 28.6336 16.872C28.6096 16.896 28.5736 16.908 28.5256 16.908H24.5896L24.5416 19.116C24.7816 18.98 25.0536 18.864 25.3576 18.768C25.6696 18.664 25.9976 18.612 26.3416 18.612C26.9816 18.612 27.5176 18.748 27.9496 19.02C28.3816 19.292 28.7056 19.636 28.9216 20.052C29.1376 20.46 29.2416 20.904 29.2336 21.384C29.2256 21.864 29.1016 22.312 28.8616 22.728C28.6296 23.136 28.2816 23.476 27.8176 23.748C27.3616 24.02 26.7896 24.156 26.1016 24.156Z" fill="#0F2A1D"/>
            <circle cx="19" cy="19" r="17.5" stroke="#0F2A1D" stroke-width="3"/>
            </svg>

              </div>
              <p>925<br>Silver</p></div>
          
          
        </div>
           <div class="pincode-check mt-3">
          <input type="text" id="pincodeInput" class="pincode-input form-control w-50 d-inline-block" placeholder="Enter Pincode">
          <button id="checkPincodeBtn" class="check-btn btn btn-primary ms-2">Check</button>
          <div id="pincodeResult" class="mt-2"></div>
        </div>




        <div class="gift-wrap">
          <input type="checkbox" id="gift">
          <label for="gift">add a Gift Wrap (+₹50 for gift wrap)</label>
        </div>
        <div class="action-buttons">
            @if($product->current_stock > 0)
    {{-- <form action="{{ route('checkout.single', ['product_id' => $product->id]) }}" method="GET">
    <input type="hidden" name="product_qty" value="1">
  
     <a href="{{ route('checkout.single', $product->id) }}" class="w-100">
                                  <button type="submit" class="buy-btn">Buy now</button>
                            </a>
            </form> --}}
                
                {{-- <form id="purchaseButtons-{{ $product->id }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_qty" value="1">
                    
                    <button type="submit" class="cart-btn add-to-cart">Add to Cart</button>
                </form> --}}


                 <!-- Buy Now Form -->
        <form action="{{ route('checkout.single', ['product_id' => $product->id]) }}" method="GET">
            <input type="hidden" name="product_qty" value="1">
            <a href="{{ route('checkout.single', $product->id) }}" class="w-100">
                <button type="submit" class="buy-btn">Buy now</button>
            </a>
        </form>
       <!-- Add to Cart Form for Main Product -->
        <form class="add-to-cart-form" data-product-id="{{ $product->id }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="product_qty" value="1">
            <input type="hidden" name="variant_id" id="selectedVariant-{{ $product->id }}" 
                   value="{{ $product->product_type == 'variant' ? $variants->first()->id ?? '' : '0' }}">
            <input type="hidden" name="size" id="selectedSize-{{ $product->id }}" 
                   value="{{ $product->product_type == 'variant' ? $variants->first()->size ?? '' : 'Free Size' }}">
            <button type="submit" class="cart-btn add-to-cart">Add to Cart</button>
        </form>


            @else
         {{-- OUT OF STOCK — Show Prebook --}}
                 <div class="mt-4 text-center" style="cursor:pointer;">
                    <!-- Out of Stock Text (aligned left) -->
                    <div class="text-danger font-semibold mb-2 text-left d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <span>Out of Stock</span>
                    </div>
                
                    <!-- Prebook Button (centered) -->
                    <button type="submit" target="_blank" id="openPrebookModal" class="btn btn-warning">
                        <i class="fas fa-box-open"></i> Prebook on WhatsApp
                    </button>
                </div>


    @endif
    <div id="prebookModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Pre-Book Product</h3>
            <button id="closePrebookModal" class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <p>This item is currently out of stock. You can pre-book it now and we’ll notify you when it's available.</p>
            @auth
            <form action="{{ route('prebook.store', $product->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="prebookQuantity">Quantity</label>
                    <input type="number" id="prebookQuantity" name="quantity" min="1" value="1" required class="modal-input">
                </div>
                <div class="mb-3">
                    <label for="prebookNote">Note (Optional)</label>
                    <textarea id="prebookNote" name="note" rows="3" class="modal-input" placeholder="Any message or request..."></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100">Confirm Pre-Booking</button>
            </form>
            @else
            <p class="text-danger">You must <a href="{{ route('login') }}">login</a> to pre-book this product.</p>
            @endauth
        </div>
    </div>
</div>
   
       

        </div>

      </div>

      <!-- Extra Details Section -->
      <div class="extra-details">
        <div class="detail-box">
          <h2>Product Details</h2>
          <ul>
            <li>925 Hallmarked Pure Silver Jewellery</li>
            <li>{{$product->productDescription1}}</li>
            <li>Diamond Zirconia (A++ Quality)</li>
            {{-- <li>Ring Diameter: 1.72 cm</li> --}}
               @php
            $sizes = json_decode($product->multiple_sizes);
        @endphp
        @if (!empty($sizes) && !in_array('universal', $sizes))
            <li>Ring Sizes: Indian – 

        {{-- Now loop through the PHP array --}}

        @if (is_array($sizes))
            @foreach ($sizes as $size)
                {{ $size }},
            @endforeach
        @endif
            </li>
            @endif
            {{-- <li>Fixed Size: Free Size</li> --}}
            <li>Comes with Vedaro luxury box & authenticity card</li>
            @php
              $category = App\Models\Category::find($product->category)->first();
            @endphp
            <li>Category – 
              {{ $category->name }} 
            </li>
            <li>Net Qty – 1 unit</li>
          </ul>
        </div>
        <div class="detail-box">
          <h2>Shipping Details</h2>
          <ul>
            <li>Free express shipping</li>
            <li>Replacement on damaged product</li>
            <li>2nd Floor, Amba Tower, Near Chirawa Court, Chirawa, Rajasthan – 333026</li>
          </ul>
        </div>
      </div>

     <!-- Similar Products Section -->
        @php
            $similarProducts = App\Models\Product::where('category', $product->category)
                ->where('id', '!=', $product->id)
                ->limit(4)
                ->get();
        @endphp
        
        <div class="similar-products-wrapper">
            <div class="similar-products-right">
                <h2>Similar Products</h2>
                <div class="product-grid">
                    @foreach($similarProducts as $simProduct)
                        @php
                            // ✅ Fetch variants if it's a variant-type product
                            $variants = $simProduct->product_type == 'variant'
                                ? App\Models\ProductVariant::where('product_id', $simProduct->id)->get()
                                : collect();
        
                            $firstVariant = $variants->first();
                        @endphp
        
                        <div class="product-card">
                            <a href="{{ route('product.details', $simProduct->productName) }}">
                                <div class="product-card-img">
                                    <img src="{{ asset('storage/products/' . $simProduct->image1) }}" alt="{{ $simProduct->productName }}">
                                </div>
                            </a>
                            <h3>{{ $simProduct->productName }}</h3>
        
                            <div>
                                @if($simProduct->product_type != 'variant')
                                    {{-- ✅ Normal product pricing --}}
                                    <span class="price">₹{{ $simProduct->discountPrice }}</span>
                                    @if($simProduct->discountPercentage != 0)
                                        <span class="old-price"><s>₹{{ $simProduct->price }}</s></span>
                                    @endif
                                @else
                                    {{-- ✅ Variant product pricing --}}
                                    @if($firstVariant)
                                        <span class="price" data-variant-id="{{ $firstVariant->id }}">
                                            ₹{{ $firstVariant->discount_price }}
                                        </span>
        
                                        @if($simProduct->discountPercentage != 0)
                                            <span class="old-price"><s>₹{{ $firstVariant->price }}</s></span>
                                        @endif
                                    @endif
                                @endif
                            </div>
        
                            <form id="purchaseButtons-{{ $simProduct->id }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $simProduct->id }}">
                                <input type="hidden" name="product_qty" value="1">
                                <button type="submit" class="cart-btn add-to-cart">Add to Cart</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


      <!-- Customer Reviews Section -->
       
<section class="reviews-section" id="reviews-section">
    <div class="reviews-container">
        <div class="reviews-header">
            <h2>Customer Reviews</h2>
            @php
                $averageRating = $reviews->avg('rating');
            @endphp
            <div class="stars">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= floor($averageRating))
                        <span class="star filled">&#9733;</span>
                    @elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) > 0)
                        <span class="star half">&#9733;</span>
                    @else
                        <span class="star">&#9733;</span>
                    @endif
                @endfor
            </div>
            <!--<a href="#review-form-section" class="write-review-btn save-btns">Write Review</a>-->
            
            <!-- Write Review Button -->
<a href="javascript:void(0)" 
   class="write-review-btn save-btns" 
   data-bs-toggle="modal" 
   data-bs-target="#reviewModal">
   ✍ Write Review
</a>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content glass-modal">
      
      <!-- Modal Header -->
      <div class="modal-header border-0">
        <h5 class="modal-title text-white">Rate and Review Product</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form class="review-form" method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : '' }}">
          
          <!-- Rating -->
          <div class="review-form-group mb-3">
            <label class="review-label text-white">Your Rating:</label>
            <div class="star-rating">
              <input type="radio" id="5-stars" name="rating" value="5" /><label for="5-stars" class="star">&#9733;</label>
              <input type="radio" id="4-stars" name="rating" value="4" /><label for="4-stars" class="star">&#9733;</label>
              <input type="radio" id="3-stars" name="rating" value="3" /><label for="3-stars" class="star">&#9733;</label>
              <input type="radio" id="2-stars" name="rating" value="2" /><label for="2-stars" class="star">&#9733;</label>
              <input type="radio" id="1-star" name="rating" value="1" /><label for="1-star" class="star">&#9733;</label>
            </div>
          </div>

          <!-- Title -->
          <div class="review-form-group mb-3">
            <label for="review_title" class="review-label text-white">Title:</label>
            <input type="text" id="review_title" name="review_title" class="form-control glass-input" placeholder="Write your title here...">
          </div>

          <!-- Review -->
          <div class="review-form-group mb-3">
            <label for="review" class="review-label text-white">Your Review:</label>
            <textarea id="review" name="review" class="form-control glass-input" placeholder="Write your review here..." required></textarea>
          </div>

          <!-- Name -->
          <div class="review-form-group mb-3">
            <label for="name" class="review-label text-white">Your Name:</label>
            <input type="text" id="name" name="name" class="form-control glass-input" 
                   value="{{ auth()->check() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : '' }}">
          </div>

          <!-- Image -->
          <div class="review-form-group mb-3">
            <label for="image" class="review-label text-white">Upload Image:</label>
            <input type="file" id="image" name="image" class="form-control glass-input">
          </div>

          <!-- Submit -->
          <div class="text-end">
            <button type="submit" class="btn btn-light px-4 py-2 rounded-pill">Submit Review</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<style>
    
    /* Glass effect for modal */
.glass-modal {
  background: rgba(15, 42, 29, 0.65); /* #0f2a1d with opacity */
  backdrop-filter: blur(12px) saturate(150%);
  -webkit-backdrop-filter: blur(12px) saturate(150%);
  border-radius: 20px;
  border: 1px solid rgba(255, 255, 255, 0.15);
  color: #fff;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
}

/* Glass inputs */
.glass-input {
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: #fff;
}

.glass-input::placeholder {
  color: rgba(255, 255, 255, 0.6);
}

.glass-input:focus {
  background: rgba(255, 255, 255, 0.12);
  border-color: rgba(255, 255, 255, 0.4);
  color: #fff;
  box-shadow: none;
}

/* Stars */
.star {
  font-size: 1.8rem;
  color: rgba(255, 255, 255, 0.5);
  cursor: pointer;
  transition: color 0.3s ease;
}

.star:hover,
.star:hover ~ .star,
input[type="radio"]:checked ~ label.star {
  color: #ffd700; /* Gold */
}
#reviewModal{
        backdrop-filter: blur(2px);
}

</style>



        </div>
        <div class="reviews-slider">
            <button class="review-nav prev">&lt;</button>
            <div class="slider-content">
                @foreach($reviews as $review)
                    <div class="review-card">
                        <h4>{{ $review->name ?: ($review->user->first_name ?? '') . ' ' . ($review->user->last_name ?? '') }}</h4>
                        <p class="date">{{ $review->created_at->format('M d, Y') }}</p>
                        <div class="stars">
                            @for ($i = 1; $i <= $review->rating; $i++)
                                <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">&#9733;</span>
                            @endfor
                        </div>
                        <p>{{ $review->review }}</p>
                    </div>
                @endforeach
            </div>
            <button class="review-nav next">&gt;</button>
        </div>
    </div>
    
           <div class="orderWhatsApp" onclick="openWhatsApp()">
              <div class="wIcon"><i class="fa-brands fa-whatsapp"></i></div>
              <div class="wText">Order with WhatsApp</div>
        </div>
        
        <script>
        function openWhatsApp() {
          // Your WhatsApp number (with country code, no spaces or + sign)
          const phoneNumber = "919005008004"; // change this to your business number
        
          // Prefilled message (URL encoded)
          const message = encodeURIComponent(
            "Hello, I have visited Vedaro website and I want to shop a product."
          );
        
          // WhatsApp API URL
          const url = `https://wa.me/${phoneNumber}?text=${message}`;
        
          // Open in new tab
          window.open(url, "_blank");
        }

        </script>
        
        
</section>
    </div>
    



  </div>
@endsection

<!-- jQuery CDN -->
  {{-- handle add to cart --}}
{{-- <script>
    // 🛡️ CSRF token setup for all AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 🛒 Handle Add to Cart on all forms starting with purchaseButtons-
    $(document).on('submit', 'form[id^="purchaseButtons-"]', function(e) {
        e.preventDefault();

        let form = $(this);
        let button = form.find('.add-to-cart'); // Target the button inside the form
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

                // Change the button text and make it a bit more visually distinct
                button.text('Added');
                button.addClass('btn-success').removeClass('btn-primary').prop('disabled', true);

                // 🔄 Update cart count if shown on page
                updateCartCount();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: xhr.responseJSON?.message ?? 'Something went wrong!',
                });
            }
        });
    });

    // 🔁 Update the cart count
    function updateCartCount() {
        $.ajax({
            url: "{{ route('cart.count') }}",
            type: "GET",
            success: function(data) {
                $('#cart-count').text(data.count); // Update cart icon/count
            }
        });
    }
</script> --}}


{{-- Rating slides --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliderContent = document.querySelector('.slider-content');
        const reviewCards = document.querySelectorAll('.review-card');
        const prevButton = document.querySelector('.review-nav.prev');
        const nextButton = document.querySelector('.review-nav.next');

        let currentIndex = 0;

        // Initially show the first review card if there are reviews
        if (reviewCards.length > 0) {
            reviewCards[currentIndex].classList.add('active');
            prevButton.style.display = 'block';
            nextButton.style.display = 'block';
        } else {
            prevButton.style.display = 'none';
            nextButton.style.display = 'none';
        }

        function showCurrentReview() {
            reviewCards.forEach((card, index) => {
                if (index === currentIndex) {
                    card.classList.add('active');
                } else {
                    card.classList.remove('active');
                }
            });
        }

        nextButton.addEventListener('click', function() {
            currentIndex++;
            if (currentIndex >= reviewCards.length) {
                currentIndex = 0; 
            }
            showCurrentReview();
        });

        prevButton.addEventListener('click', function() {
            currentIndex--;
            if (currentIndex < 0) {
                currentIndex = reviewCards.length - 1;
            }
            showCurrentReview();
        });
    });
</script>

<script>
   document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('main-product-image');
    const thumbnails = document.querySelectorAll('.thumbnail-image');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // Get the image path from the data-image attribute
            const newImagePath = this.getAttribute('data-image');
            
            // Update the main image's src attribute
            mainImage.src = newImagePath;
        });
    });
    });
</script>


<!--Prebooking Order Script-->
   <script>
    document.addEventListener('DOMContentLoaded', function () {
        const openBtn = document.getElementById('openPrebookModal');
        const modal = document.getElementById('prebookModal');
        const closeBtn = document.getElementById('closePrebookModal');
        
        if (!modal) {
            console.warn("Modal not found.");
            return;
        }
        
        const openModal = () => {
            modal.classList.add('visible');
            document.body.style.overflow = 'hidden'; // Prevent body scrolling
        };
        
        const closeModal = () => {
            modal.classList.remove('visible');
            document.body.style.overflow = ''; // Re-enable body scrolling
        };
        
        if (openBtn) {
            openBtn.addEventListener('click', function (e) {
                e.preventDefault();
                openModal();
            });
        }
        
        if (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                closeModal();
            });
        }
        
        window.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeModal();
            }
        });
        
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('visible')) {
                closeModal();
            }
        });
    });
</script>
  

{{-- size select script --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.size-btn');
        const priceStockDiv = document.getElementById('variant-price-stock');

        buttons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                buttons.forEach(b => b.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Get data attributes
                const price = this.getAttribute('data-price');
                const discount = this.getAttribute('data-discount');
                const stock = this.getAttribute('data-stock');

                // Update price & stock
                priceStockDiv.innerHTML = `
                    <div>
                        <span class="price">₹${discount}</span>
                        <span class="old-price">₹${price}</span>
                    </div>
                    <div class="stock">Hurry up! Only ${stock} item(s) in stock.</div>
                `;
            });
        });
    });
</script> --}}

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// 🛡️ CSRF token setup for all AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// 🛒 Handle Add to Cart on all forms with class 'add-to-cart-form'
$(document).on('submit', '.add-to-cart-form', function(e) {
    e.preventDefault();

    let form = $(this);
    let button = form.find('.add-to-cart');
    let formData = form.serialize();
    let productId = form.data('product-id');

    // Show loading state
    button.prop('disabled', true).text('Adding...');

    $.ajax({
        type: "POST",
        url: "{{ route('cart.add') }}",
        data: formData,
        success: function(response) {
            // Reset button state
            button.prop('disabled', false).text('Add to Cart');
            
            Swal.fire({
                icon: 'success',
                title: 'Added!',
                text: response.message || 'Product added to cart.',
                timer: 1500,
                showConfirmButton: false
            });

            // Update cart count
            updateCartCount();
        },
        error: function(xhr) {
            // Reset button state on error
            button.prop('disabled', false).text('Add to Cart');
            
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: xhr.responseJSON?.message || 'Something went wrong!',
            });
        }
    });
});

// 🔁 Update the cart count
function updateCartCount() {
    $.ajax({
        url: "{{ route('cart.count') }}",
        type: "GET",
        success: function(data) {
            $('#cart-count').text(data.count); // Update cart icon/count
        }
    });
}

// Size selection functionality
// document.addEventListener('DOMContentLoaded', function() {
//     const buttons = document.querySelectorAll('.size-btn');
//     const priceStockDiv = document.getElementById('variant-price-stock');

//     buttons.forEach(btn => {
//         btn.addEventListener('click', function() {
//             // Remove active class
//             buttons.forEach(b => b.classList.remove('active'));
//             this.classList.add('active');

//             // Update price & stock
//             const price = this.dataset.price;
//             const discount = this.dataset.discount;
//             const stock = this.dataset.stock;
//             const size = this.dataset.size;
//             const variantId = this.dataset.id;

//             priceStockDiv.innerHTML = `
//                 <div>
//                     <span class="price">₹${discount}</span>
//                     <span class="old-price">₹${price}</span>
//                 </div>
//                 <div class="stock">Hurry up! Only ${stock} item(s) in stock.</div>
//             `;

//             // Update hidden inputs
//             const hiddenVariantInput = document.getElementById('selectedVariant-{{ $product->id }}');
//             const hiddenSizeInput = document.getElementById('selectedSize-{{ $product->id }}');
            
//             if (hiddenVariantInput) hiddenVariantInput.value = variantId;
//             if (hiddenSizeInput) hiddenSizeInput.value = size;
//         });
//     });

//     // Set default values
//     if (buttons.length > 0) {
//         const hiddenVariantInput = document.getElementById('selectedVariant-{{ $product->id }}');
//         const hiddenSizeInput = document.getElementById('selectedSize-{{ $product->id }}');
        
//         if (hiddenVariantInput) hiddenVariantInput.value = buttons[0].dataset.id;
//         if (hiddenSizeInput) hiddenSizeInput.value = buttons[0].dataset.size;
//     }
// });

document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.size-btn');
    const priceStockDiv = document.getElementById('variant-price-stock');

    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class
            buttons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Get data attributes
            const price = this.dataset.price;
            const discount = this.dataset.discount;
            const stock = this.dataset.stock;
            const size = this.dataset.size;
            const variantId = this.dataset.id;

            // ✅ Logic: if discount == price → show only one price
            let priceHtml = '';
            if (discount && discount !== price) {
                priceHtml = `
                    <span class="price">₹${discount}</span>
                    <span class="old-price">₹${price}</span>
                `;
            } else {
                priceHtml = `
                    <span class="price">₹${price}</span>
                `;
            }

            // Update HTML
            priceStockDiv.innerHTML = `
                <div>${priceHtml}</div>
                <div class="stock">Hurry up! Only ${stock} item(s) in stock.</div>
            `;

            // Update hidden inputs
            const hiddenVariantInput = document.getElementById('selectedVariant-{{ $product->id }}');
            const hiddenSizeInput = document.getElementById('selectedSize-{{ $product->id }}');
            
            if (hiddenVariantInput) hiddenVariantInput.value = variantId;
            if (hiddenSizeInput) hiddenSizeInput.value = size;
        });
    });

    // Set default values
    if (buttons.length > 0) {
        const hiddenVariantInput = document.getElementById('selectedVariant-{{ $product->id }}');
        const hiddenSizeInput = document.getElementById('selectedSize-{{ $product->id }}');
        
        if (hiddenVariantInput) hiddenVariantInput.value = buttons[0].dataset.id;
        if (hiddenSizeInput) hiddenSizeInput.value = buttons[0].dataset.size;

        // ✅ Trigger first button click manually (to load price initially)
        buttons[0].click();
    }
});

// Your other existing JavaScript functions (image gallery, reviews slider, etc.)
</script>

<!-- checking pincode available delivery or not -->
<script>
document.getElementById('checkPincodeBtn').addEventListener('click', function() {
    const pincode = document.getElementById('pincodeInput').value.trim();
    const resultBox = document.getElementById('pincodeResult');

    if (!pincode || pincode.length !== 6 || isNaN(pincode)) {
        resultBox.innerHTML = `<span class="text-danger">Please enter a valid 6-digit pincode.</span>`;
        console.warn("Invalid pincode entered:", pincode);
        return;
    }

    resultBox.innerHTML = `<span class="text-muted">Checking availability...</span>`;
    console.log("Checking pincode:", pincode);

    fetch(`/check-pincode/${pincode}`)
        .then(response => {
            console.log("Raw response:", response);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("API Response JSON:", data);

            if (data.available) {
                resultBox.innerHTML = `<span class="text-success"><i class="fas fa-check-circle"></i> Delivery available for this pincode ✅</span>`;
            } else {
                resultBox.innerHTML = `<span class="text-danger"><i class="fas fa-times-circle"></i> Delivery not available for this pincode ❌</span>`;
            }
        })
        .catch(error => {
            console.error("Error while checking pincode:", error);
            resultBox.innerHTML = `<span class="text-danger">Error checking pincode. Please try again later.</span>`;
        });
});
</script>
