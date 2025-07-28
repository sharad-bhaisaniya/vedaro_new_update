@extends('layouts.admin_lay')
@section('title', 'Edit Product')
@section('content')
<style>
	.image-preview{
	width: 200px;
	height: 200px;
	border: 1px solid #ccc;
	overflow: hidden;
	position: relative;
	cursor: pointer;
	display: block; /* Ensures it takes up space even if hidden */
	margin-top: 10px; /* Spacing below input */
	}
	/* Ensure image is contained within the preview div */
	.image-preview img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	.product_form, .edit_product_form { /* Combined styles for consistency */
	display: flex;
	flex-wrap: wrap;
	gap: 30px; /* Reduced gap slightly for more compact form */
	}
	.container {
	width: 100% !important;
	}
	.row {
	/*margin-left: 142px !important;*/
	/*width: 97% !important;*/
	}
</style>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif

<div class="container mt-1">
	<div class="row justify-content-end">
		<div class="col-lg-12 col-md-10 col-sm-12">
			<h2 class="text-center mb-4">Edit Product</h2>
			<div class="form-container">
				@if(session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
				@endif
				@if($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
                <form class="edit_product_form" action="{{ route('admin.update_product', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Use PUT method for updates --}}

                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName" value="{{ old('productName', $product->productName) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="discountPercentage">Discount Percentage</label>
                        <input type="number" class="form-control" id="discountPercentage" name="discountPercentage" placeholder="Enter discount %" value="{{ old('discountPercentage', $product->discountPercentage) }}">
                    </div>
                    <div class="form-group">
                        <label for="discountPrice">Discount Price</label>
                        <input type="number" class="form-control" id="discountPrice" name="discountPrice" step="0.01" placeholder="Enter discount price (optional)" value="{{ old('discountPrice', $product->discountPrice) }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="size">Size (cms or inches)</label>
                        <input type="text" class="form-control" id="size" name="size" placeholder="(H x W x L) " value="{{ old('size', $product->size) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Multiple Sizes</label>
                        <div id="multiple-sizes-wrapper">
                            @php
                                // Assuming multiple_sizes is stored as JSON or an array. Adjust if it's a string needing json_decode.
                                $multipleSizes = is_string($product->multiple_sizes) ? json_decode($product->multiple_sizes, true) : ($product->multiple_sizes ?? []);
                            @endphp
                            @forelse($multipleSizes as $multiSize)
                                <input type="text" name="multiple_sizes[]" class="form-control mb-2" placeholder="Size e.g. 12x12x6" value="{{ old('multiple_sizes.' . $loop->index, $multiSize) }}">
                            @empty
                                <input type="text" name="multiple_sizes[]" class="form-control mb-2" placeholder="Size e.g. 12x12x6">
                            @endforelse
                        </div>
                        <button type="button" class="btn btn-sm btn-success mt-1" onclick="addSize()">Add Another Size</button>
                    </div>
                    
                    <div class="form-group">
                        <label for="weight">Default Weight in (grams)</label>
                        <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight" value="{{ old('weight', $product->weight) }}" >
                    </div>
                    
                    <div class="form-group mb-3">
                        <label>Multiple Weights in (grams)</label>
                        <div id="weights-wrapper">
                            @php
                                // Assuming multiple_weights is stored as JSON or an array.
                                $multipleWeights = is_string($product->multiple_weights) ? json_decode($product->multiple_weights, true) : ($product->multiple_weights ?? []);
                            @endphp
                            @forelse($multipleWeights as $multiWeight)
                                <div class="input-group mb-2">
                                    <input type="text" name="multiple_weights[]" class="form-control" placeholder="e.g. 100g" value="{{ old('multiple_weights.' . $loop->index, $multiWeight) }}" >
                                    <button type="button" class="btn btn-danger remove-weight">-</button>
                                </div>
                            @empty
                                <div class="input-group mb-2">
                                    <input type="text" name="multiple_weights[]" class="form-control" placeholder="e.g. 100g" >
                                    <button type="button" class="btn btn-success add-weight">+</button>
                                </div>
                            @endforelse
                        </div>
                        @if(empty($multipleWeights)) {{-- Only show add button if no weights are pre-populated --}}
                            <button type="button" class="btn btn-success add-weight">+</button>
                        @endif
                    </div>

                    <div style="width:100%" class="form-group">
                        <label for="productDescription1">Product Description</label>
                        <textarea class="form-control" id="productDescription1" name="productDescription1" rows="4" placeholder="Enter product description" required>{{ old('productDescription1', $product->productDescription1) }}</textarea>
                    </div>
                    <div style="width:100%" class="form-group">
                        <label for="productDescription2">Product Description 2</label>
                        <textarea class="form-control" id="productDescription2" name="productDescription2" rows="4" placeholder="Enter product description" required>{{ old('productDescription2', $product->productDescription2) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="productImage1">Product Image 1</label>
                        <input type="file" class="form-control-file" id="productImage1" name="productImage1" accept="image/*">
                        <img id="imagePreview1" class="image-preview" src="{{ $product->productImage1 ? asset('storage/' . $product->productImage1) : '#' }}" alt="Image Preview" style="display: {{ $product->productImage1 ? 'block' : 'none' }};">
                    </div>
                    <div class="form-group">
                        <label for="productImage2">Product Image 2</label>
                        <input type="file" class="form-control-file" id="productImage2" name="productImage2" accept="image/*">
                        <img id="imagePreview2" class="image-preview" src="{{ $product->productImage2 ? asset('storage/' . $product->productImage2) : '#' }}" alt="Image Preview" style="display: {{ $product->productImage2 ? 'block' : 'none' }};">
                    </div>
                    <div class="form-group">
                        <label for="productImage3">Product Image 3</label>
                        <input type="file" class="form-control-file" id="productImage3" name="productImage3" accept="image/*">
                        <img id="imagePreview3" class="image-preview" src="{{ $product->productImage3 ? asset('storage/' . $product->productImage3) : '#' }}" alt="Image Preview" style="display: {{ $product->productImage3 ? 'block' : 'none' }};">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="" disabled>Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ ($category->id == old('category', $product->category_id)) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="availability">Add in Featured</label>
                        <select class="form-control" id="availability" name="availability">
                            <option value="0" {{ (old('availability', $product->availability) == 0) ? 'selected' : '' }}>Not Featured</option>
                            <option value="1" {{ (old('availability', $product->availability) == 1) ? 'selected' : '' }}>Featured</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="on_sell">On Sell</label>
                        <select class="form-control" id="on_sell" name="on_sell">
                            <option value="1" {{ (old('on_sell', $product->on_sell) == 1) ? 'selected' : '' }}>On Sale</option>
                            <option value="0" {{ (old('on_sell', $product->on_sell) == 0) ? 'selected' : '' }}>Not On Sale</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" placeholder="Enter stock quantity" value="{{ old('stock', $product->stock) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="shipping_fee">Shipping Fee</label>
                        <input type="number" class="form-control" id="shipping_fee" name="shipping_fee" placeholder="Enter shipping_fee" value="{{ old('shipping_fee', $product->shipping_fee) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="coupon_code">Coupon Code</label>
                        <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Enter coupon_code" value="{{ old('coupon_code', $product->coupon_code) }}">
                        <button type="button" id="generateCoupon" class="btn btn-info mt-2">Generate Coupon Code</button>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="addTimer" name="addTimer" value="1" {{ old('addTimer', $product->addTimer) == 1 ? 'checked' : '' }}>
                        <label for="addTimer">Add Timer</label>
                    </div>
                    
                    <div id="timerDurationFields" style="display: {{ old('addTimer', $product->addTimer) == 1 ? 'block' : 'none' }}; width:100%;">
                        <div class="form-group">
                            <label for="timerDatetime">Sale End Date and Time</label>
                            {{-- Convert existing timer timestamp to datetime-local format if available --}}
                            <input type="datetime-local" class="form-control" id="timerDatetime" name="timerDatetime" value="{{ old('timerDatetime', $product->timerDatetime ? \Carbon\Carbon::parse($product->timerDatetime)->format('Y-m-d\TH:i') : '') }}">
                        </div>
                        {{-- Hidden fields for timer duration will be updated by JS --}}
                        <input type="hidden" id="timerDays" name="timerDays" value="{{ old('timerDays', $product->timerDays ?? 0) }}">
                        <input type="hidden" id="timerHours" name="timerHours" value="{{ old('timerHours', $product->timerHours ?? 0) }}">
                        <input type="hidden" id="timerMinutes" name="timerMinutes" value="{{ old('timerMinutes', $product->timerMinutes ?? 0) }}">
                        <input type="hidden" id="timerSeconds" name="timerSeconds" value="{{ old('timerSeconds', $product->timerSeconds ?? 0) }}">
                    </div>
                    <div style="width:100%;">
                        <button type="submit" class="btn btn-primary btn-block">Update Product</button>
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> {{-- Ensure jQuery is loaded --}}
<script>
    $(document).ready(function() {
        // Function to set up image preview for a given input and preview element
        function setupImagePreview(inputFileId, imagePreviewId) {
            $('#' + inputFileId).on('change', function() {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + imagePreviewId).attr('src', e.target.result).show();
                };
                reader.readAsDataURL(this.files[0]);
            });
        }

        // Setup previews for all image inputs
        setupImagePreview('productImage1', 'imagePreview1');
        setupImagePreview('productImage2', 'imagePreview2');
        setupImagePreview('productImage3', 'imagePreview3');

        // Initial calculation of discount price on page load
        calculateDiscountPrice();
        $('#price, #discountPercentage').on('input', calculateDiscountPrice);

        function calculateDiscountPrice() {
            var price = parseFloat($('#price').val());
            var discountPercentage = parseFloat($('#discountPercentage').val());

            if (!isNaN(price) && !isNaN(discountPercentage)) {
                var discountAmount = (price * discountPercentage) / 100;
                var discountPrice = price - discountAmount;
                $('#discountPrice').val(discountPrice.toFixed(2));
            } else {
                $('#discountPrice').val('');
            }
        }

        // --------------------------COUPON---------------------------
        $('#generateCoupon').click(function() {
            var couponCode = 'COUPON-' + Math.random().toString(36).substring(2, 8).toUpperCase();
            $('#coupon_code').val(couponCode);
        });

        // --------------------------------------TIMER----------------------------
        // Initial state for timer fields based on existing product data
        if ($('#addTimer').is(':checked')) {
            $('#timerDurationFields').show();
            // Calculate initial timer duration if a timerDatetime is set
            if ($('#timerDatetime').val()) {
                calculateTimerDuration();
            }
        }

        $('#addTimer').on('change', function() {
            if ($(this).is(':checked')) {
                $('#timerDurationFields').slideDown();
            } else {
                $('#timerDurationFields').slideUp();
                $('#timerDatetime').val('');
                $('#timerDays').val(0);
                $('#timerHours').val(0);
                $('#timerMinutes').val(0);
                $('#timerSeconds').val(0);
            }
        });

        $('#timerDatetime').on('change', calculateTimerDuration);

        function calculateTimerDuration() {
            var selectedDatetime = new Date($('#timerDatetime').val());
            var now = new Date();

            if (selectedDatetime > now) {
                var diff = selectedDatetime.getTime() - now.getTime(); // Difference in milliseconds

                var seconds = Math.floor(diff / 1000);
                var minutes = Math.floor(seconds / 60);
                var hours = Math.floor(minutes / 60);
                var days = Math.floor(hours / 24);

                seconds %= 60;
                minutes %= 60;
                hours %= 24;

                $('#timerDays').val(days);
                $('#timerHours').val(hours);
                $('#timerMinutes').val(minutes);
                $('#timerSeconds').val(seconds);
            } else {
                // If selected date/time is in the past, clear values
                $('#timerDays').val(0);
                $('#timerHours').val(0);
                $('#timerMinutes').val(0);
                $('#timerSeconds').val(0);
            }
        }
    });

    // --------------------------------------MULTIPLE WEIGHTS----------------------------
    document.addEventListener('DOMContentLoaded', function () {
        // Add button event listener
        document.querySelector('.add-weight').addEventListener('click', function () {
            const wrapper = document.getElementById('weights-wrapper');
            const newInput = document.createElement('div');
            newInput.classList.add('input-group', 'mb-2');
            newInput.innerHTML = `
                <input type="text" name="multiple_weights[]" class="form-control" placeholder="e.g. 250g" required>
                <button type="button" class="btn btn-danger remove-weight">-</button>`;
            wrapper.appendChild(newInput);
        });
        
        // Remove button event listener (delegated)
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-weight')) {
                // Ensure at least one weight input remains
                const wrapper = document.getElementById('weights-wrapper');
                if (wrapper.children.length > 1) { // Check if there's more than one input group
                    e.target.parentElement.remove();
                } else {
                    alert('You must have at least one weight.');
                }
            }
        });
    });

    // --------------------------------------MULTIPLE SIZES----------------------------
    function addSize() {
        const wrapper = document.getElementById('multiple-sizes-wrapper');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'multiple_sizes[]';
        input.className = 'form-control mb-2';
        input.placeholder = 'Size e.g. 12x12x6';
        wrapper.appendChild(input);
    }
</script>
@endsection