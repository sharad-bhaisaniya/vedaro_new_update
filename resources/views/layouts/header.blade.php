 <style>
    .suggestions-box {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #0f2a1d;
        border: 1px solid #ddd;
        z-index: 1000;
        display: none;
        max-height: 250px;
        overflow-y: auto;
    }

    .suggestions-box .item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px;
        cursor: pointer;
    }

    .suggestions-box .item img {
        width: 35px;
        height: 35px;
        object-fit: cover;
        border-radius: 4px;
    }

    .suggestions-box .item:hover {
        background: gray;
    }
</style>
 
 <header class="headerContainer main-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid d-flex align-items-center">

                <!-- Desktop Navbar -->
                <div class="d-none d-lg-flex w-100 justify-content-between align-items-center mt-2 navbar-desktop">
                    <!-- Logo -->
                    <h6 class="header__heading mobile-header-logo d-flex align-items-center m-0">
                        <a href="/" class="header__heading-link navbar-brand text-decoration-none">
                            <div class="logo header__logo-wrapper">
								<img src="{{ asset('assets/images/Primary.png') }}" alt="logo">
							</div>

                        </a>
                    </h6>

                    <!-- Search Bar (desktop) -->           
                <div class="search-bar position-relative">
                    <i class="fa fa-search search-icon"></i>
                    <input type="text" id="global-search-input" placeholder="Search Ring, Bracelet, Pendant....." autocomplete="off" />
                    <div id="search-suggestions" class="suggestions-box"></div>
                </div>



                    <!-- Icons -->
                    <div class="header-icons d-flex align-items-center gap-3">
                       <a href="/cart" class="cart-link position-relative">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span id="cart_counter" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                        </a>
                        <a href="/favorite"><i class="fa-regular fa-heart" aria-hidden="true"></i></a>
                        <a href="/profile"><i class="fa-regular fa-user" aria-hidden="true"></i></a>
                    </div>
                </div>

                <!-- Mobile Navbar (top row) -->
                <div class="d-lg-none w-100 d-flex justify-content-between align-items-center navbar-mobile">
                    <!-- hamburger left -->
                    

                    <!-- centered logo -->
                    <h6 class="header__heading mobile-header-logo m-0" style="text-align:center; flex:1;">
						<div></div>
                        <a href="/" class="header__heading-link navbar-brand text-decoration-none"
                            style="color:var(--accent); text-decoration:none;">
                            <div class="logo header__logo-wrapper" style="justify-content:center;">
                                <!--<img src="{{ asset('assets/images/VEDARO_logo.png') }}" alt="logo">-->
                                	<img src="{{ asset('assets/images/Primary.png') }}" alt="logo">
                            </div>
                        </a>
						<div class="header-icons d-flex align-items-center gap-3"
							style="justify-content:flex-end;">
						 <a href="/profile"><i class="fa-regular fa-user" aria-hidden="true"></i></a>
                    </h6>
				</div>
                </div>

				
            </div>
        </nav>
		
        <!-- Mobile Search row (below top row) -->
       <!-- Mobile Search row -->
<div class="mobile-search-row d-lg-none d-flex justify-content-between align-items-center">
    <i class="fa-solid fa-bars" id="menuToggle" style="font-size:20px; cursor:pointer; margin-right: 20px;"></i>

    <div class="search-bar position-relative">
        <i class="fa fa-search search-icon" aria-hidden="true"></i>
        <input type="text" id="mobile-search-input" placeholder="Search by category" autocomplete="off" />
        <div id="mobile-search-suggestions" class="suggestions-box"></div>
    </div>

    <div class="header-icons">
        <a href="/cart" class="header__heading-link navbar-brand text-decoration-none">
            
        <i class="fa-solid fa-bag-shopping position-relative">
            <span id="cart_counter_2" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
        </i>
        <i class="fa-regular fa-heart" aria-hidden="true"></i>
        </a>
    </div>
</div>

	
			
        <!-- NAVIGATION CATEGORIES (Desktop Only) -->
        <div class="categories">
            <a href="/limited_edition"><i class="fa-solid fa-gem"></i> Limited edition</a>
                        <a href="/gift"><i class="fa-solid fa-gift"></i> Gifting</a>
		@foreach($categories as $cat)
            @if($cat->showOnHome)
                <a href="{{ route('product.show', ['id' => $cat->id]) }}">
                    @if(Str::startsWith($cat->icon, '<svg'))
                        <div>
                            {!! $cat->icon !!}
                        </div>
                    @else
                        <img src="{{ asset('storage/' . $cat->icon) }}" width="18px" alt="{{ $cat->name }}">
                    @endif
                    {{ $cat->name }}
                </a>
            @endif
        @endforeach

            <a href="/newEvent"><i class="fa-solid fa-bezier-curve"></i> Events</a>

            <!-- <a href="#"><i class="fa-solid fa-link"></i> Bracelets</a>
            <a href="#"><i class="fa-solid fa-star"></i> Pendants</a>
            <a href="#"><i class="fa-solid fa-necklace"></i> Necklaces</a>
            <a href="#"><i class="fa-solid fa-ear-listen"></i> Earrings</a> -->
        </div>
    </header>

{{-- for direct search on enter --}}
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const desktopInput = document.getElementById('global-search-input');
    const mobileInput = document.getElementById('mobile-search-input');
    const desktopBox = document.getElementById('search-suggestions');
    const mobileBox = document.getElementById('mobile-search-suggestions');

    function showSuggestions(results, box) {
        box.innerHTML = "";
        if (results.length === 0) {
            box.style.display = "none";
            return;
        }
        results.forEach(item => {
            const div = document.createElement("div");
            div.classList.add("item");
            div.textContent = `${item.type}: ${item.name}`;
            div.addEventListener("click", () => window.location.href = item.url);
            box.appendChild(div);
        });
        box.style.display = "block";
    }

    function handleSearch(input, box) {
        const query = input.value.trim().toLowerCase();
        if (query.length > 2) {
            const filtered = [
                ...allProducts.filter(p => p.name.toLowerCase().includes(query)),
                ...allCategories.filter(c => c.name.toLowerCase().includes(query))
            ];
            showSuggestions(filtered, box);
        } else {
            box.style.display = "none";
        }
    }

    desktopInput.addEventListener('keyup', () => handleSearch(desktopInput, desktopBox));
    mobileInput.addEventListener('keyup', () => handleSearch(mobileInput, mobileBox));

    // Hide suggestions on outside click
    document.addEventListener('click', (e) => {
        [desktopBox, mobileBox].forEach(box => {
            if (!box.contains(e.target) && e.target !== desktopInput && e.target !== mobileInput) {
                box.style.display = "none";
            }
        });
    });
});

</script>


{{-- For suggestion all the products and categories --}}
@php
    use App\Models\Product;
    use App\Models\Category;

    $allProducts = Product::select('id','productName')->get()->map(function($p) {
        return [
            'type' => 'Product',
            'name' => $p->productName,
            'url'  => route('product.details', ['productName' => $p->productName]),
        ];
    });

    $allCategories = Category::select('id','name')->get()->map(function($c) {
        return [
            'type' => 'Category',
            'name' => $c->name,
            'url'  => route('product.show', ['id' => $c->id]),
        ];
    });
@endphp

<script>
    // Ab safe JSON milega
    const allProducts = @json($allProducts);
    const allCategories = @json($allCategories);

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('global-search-input');
        const suggestionsBox = document.getElementById('search-suggestions');

        function showSuggestions(results) {
            suggestionsBox.innerHTML = "";
            if (results.length === 0) {
                suggestionsBox.style.display = "none";
                return;
            }

            results.forEach(item => {
                const div = document.createElement("div");
                div.classList.add("item");
                div.textContent = `${item.type}: ${item.name}`;
                div.addEventListener("click", () => {
                    window.location.href = item.url;
                });
                suggestionsBox.appendChild(div);
            });

            suggestionsBox.style.display = "block";
        }

        searchInput.addEventListener("keyup", function () {
            const query = this.value.trim().toLowerCase();
            if (query.length > 2) {
                let filtered = [];

                allProducts.forEach(p => {
                    if (p.name.toLowerCase().includes(query)) {
                        filtered.push(p);
                    }
                });

                allCategories.forEach(c => {
                    if (c.name.toLowerCase().includes(query)) {
                        filtered.push(c);
                    }
                });

                showSuggestions(filtered);
            } else {
                suggestionsBox.style.display = "none";
            }
        });

        document.addEventListener("click", function (e) {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = "none";
            }
        });
    });
</script>

