@extends('layouts.admin_lay')
@section('title', 'Dashboard')
@section('content')
<style>
	.image-preview{
	width: 200px;
	height: 200px;
	border: 1px solid #ccc;
	overflow: hidden;
	position: relative;
	cursor: pointer;
	}
	.product_form{
	display: flex;
	flex-wrap: wrap;
	gap: 30px;
	}
	.container {
	width: 100% !important;
	}
.edit_product_form {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
}
</style>
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
        <input type="number" class="form-control" id="discountPercentage" name="discountPercentage" value="{{ old('discountPercentage', $product->discountPercentage) }}" required>
    </div>

    <div class="form-group">
        <label for="discountPrice">Discount Price</label>
        <input type="number" class="form-control" id="discountPrice" name="discountPrice" step="0.01" value="{{ old('discountPrice', $product->discountPrice) }}" readonly>
    </div>

    <div class="form-group">
        <label for="size">Size (cms or inches)</label>
        <input type="text" class="form-control" id="size" name="size" value="{{ old('size', $product->size) }}" required>
    </div>

    <div class="form-group">
        <label for="weight">Weight in (grams)</label>
        <input type="text" class="form-control" id="weight" name="weight" value="{{ old('weight', $product->weight) }}" required>
    </div>

    <div class="form-group">
        <label for="productDescription1">Product Description 1</label>
        <textarea class="form-control" id="productDescription1" name="productDescription1" rows="4" required>{{ old('productDescription1', $product->productDescription1) }}</textarea>
    </div>

    <div class="form-group">
        <label for="productDescription2">Product Description 2</label>
        <textarea class="form-control" id="productDescription2" name="productDescription2" rows="4" required>{{ old('productDescription2', $product->productDescription2) }}</textarea>
    </div>

    <div class="form-group">
        <label for="productImage1">Product Image 1</label>
        <input type="file" class="form-control-file" id="productImage1" name="productImage1" accept="image/*">
        @if($product->productImage1)
            <img src="{{ asset('storage/' . $product->productImage1) }}" alt="Image Preview" style="width: 100px; height: 100px;">
        @endif
    </div>

    <div class="form-group">
        <label for="productImage2">Product Image 2</label>
        <input type="file" class="form-control-file" id="productImage2" name="productImage2" accept="image/*">
        @if($product->productImage2)
            <img src="{{ asset('storage/' . $product->productImage2) }}" alt="Image Preview" style="width: 100px; height: 100px;">
        @endif
    </div>

    <div class="form-group">
        <label for="productImage3">Product Image 3</label>
        <input type="file" class="form-control-file" id="productImage3" name="productImage3" accept="image/*">
        @if($product->productImage3)
            <img src="{{ asset('storage/' . $product->productImage3) }}" alt="Image Preview" style="width: 100px; height: 100px;">
        @endif
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <select name="category" id="category" class="form-control" required>
            <option value="" disabled>Select a category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @if($category->id == $product->category_id) selected @endif>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="availability">Availability</label>
        <select class="form-control" id="availability" name="availability" required>
            <option value="1" @if($product->availability == 1) selected @endif>Available</option>
            <option value="0" @if($product->availability == 0) selected @endif>Not Available</option>
        </select>
    </div>

    <div class="form-group">
        <label for="on_sell">On Sell</label>
        <select class="form-control" id="on_sell" name="on_sell" required>
            <option value="1" @if($product->on_sell == 1) selected @endif>On Sale</option>
            <option value="0" @if($product->on_sell == 0) selected @endif>Not On Sale</option>
        </select>
    </div>

    <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
    </div>

    <div class="form-group">
        <label for="shipping_fee">Shipping Fee</label>
        <input type="number" class="form-control" id="shipping_fee" name="shipping_fee" value="{{ old('shipping_fee', $product->shipping_fee) }}" required>
    </div>

    <div class="form-group">
        <label for="coupon_code">Coupon Code</label>
        <input type="text" class="form-control" id="coupon_code" name="coupon_code" value="{{ old('coupon_code', $product->coupon_code) }}">
    </div>

    <button type="submit" class="btn btn-primary">Update Product</button>
</form>

			</div>
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
	    // Preview Image 1
	    $('#productImage1').on('change', function() {
	        var reader = new FileReader();
	        reader.onload = function(e) {
	            $('#imagePreview1').attr('src', e.target.result).show();
	        };
	        reader.readAsDataURL(this.files[0]);
	    });
	    
	    // Preview Image 2
	    $('#productImage2').on('change', function() {
	        var reader = new FileReader();
	        reader.onload = function(e) {
	            $('#imagePreview2').attr('src', e.target.result).show();
	        };
	        reader.readAsDataURL(this.files[0]);
	    });
	
	    // Preview Image 3
	    $('#productImage3').on('change', function() {
	        var reader = new FileReader();
	        reader.onload = function(e) {
	            $('#imagePreview3').attr('src', e.target.result).show();
	        };
	        reader.readAsDataURL(this.files[0]);
	    });
	});
	// --------------------------COUPON---------------------------
	
	$(document).ready(function(){
	    $('#generateCoupon').click(function(){
	        var couponCode = 'COUPON-' + Math.random().toString(36).substring(2, 8).toUpperCase();
	        
	        $('#coupon_code').val(couponCode);
	    });
	});
	// --------------------------------------discountPercentage----------------------------
	$(document).ready(function() {
	    $('#price, #discountPercentage').on('input', function() {
	        var price = parseFloat($('#price').val());
	        var discountPercentage = parseFloat($('#discountPercentage').val());
	
	        if (!isNaN(price) && !isNaN(discountPercentage)) {
	            var discountAmount = (price * discountPercentage) / 100;
	            var discountPrice = price - discountAmount;
	
	            $('#discountPrice').val(discountPrice.toFixed(2));  // Rounded to 2 decimal places
	        } else {
	            $('#discountPrice').val('');
	        }
	    });
	});
</script>
@endsection