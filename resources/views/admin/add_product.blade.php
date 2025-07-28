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
			<h2 class="text-center mb-4">Add Product</h2>
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
        <form class="product_form" action="{{ route('admin.add_product') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="productName">Product Name</label>
						<input type="text" class="form-control" id="productName" name="productName" placeholder="Enter product name" required>
					</div>
					<div class="form-group">
						<label for="price">Price</label>
						<input type="number" class="form-control" id="price" name="price" step="0.01" placeholder="Enter product price" required>
					</div>
					<div class="form-group">
						<label for="discountPercentage">Discount Percentage</label>
						<input type="number" class="form-control" id="discountPercentage" name="discountPercentage" placeholder="Enter discount %" value="0">
					</div>
					<div class="form-group">
						<label for="discountPrice">Discount Price</label>
						<input type="number" class="form-control" id="discountPrice" name="discountPrice" step="0.01" placeholder="Enter discount price (optional)" readonly>
					</div>
					<div class="form-group">
						<label for="size">Size (cms or inches)</label>
						<input type="text" class="form-control" id="size" name="size" placeholder="(H x W x L) " required>
					</div>
					<div class="form-group">
          <label>Multiple Sizes</label>
          <div id="multiple-sizes-wrapper">
            <input type="text" name="multiple_sizes[]" class="form-control mb-2" placeholder="Size e.g. 12x12x6">
          </div>
          <button type="button" class="btn btn-sm btn-success mt-1" onclick="addSize()">Add Another Size</button>
        </div>
         
        
					<div class="form-group">
						<label for="weight">Default Weight in (grams)</label>
						<input type="text" class="form-control" id="weight" name="weight" placeholder="Weight" required>
					</div>
					
					          <div class="form-group mb-3">
            <label>Multiple Weights in (grams)</label>
            <div id="weights-wrapper">
              <div class="input-group mb-2">
                <input type="text" name="multiple_weights[]" class="form-control" placeholder="e.g. 100g" >
                <button type="button" class="btn btn-success add-weight">+</button>
              </div>
            </div>
          </div>

					<div style="width:100%" class="form-group">
						<label for="productDescription1">Product Description</label>
						<textarea class="form-control" id="productDescription1" name="productDescription1" rows="4" placeholder="Enter product description" required></textarea>
					</div>
					<div style="width:100%" class="form-group">
						<label for="productDescription2">Product Description 2</label>
						<textarea class="form-control" id="productDescription2" name="productDescription2" rows="4" placeholder="Enter product description" required></textarea>
					</div>
					<div class="form-group">
						<label for="productImage">Product Image 1</label>
						<input type="file" class="form-control-file" id="productImage1" name="productImage1" accept="image/*">
						<img id="imagePreview1" class="image-preview" src="#" alt="Image Preview" style="display:none;">
					</div>
					<div class="form-group">
						<label for="productImage">Product Image 2</label>
						<input type="file" class="form-control-file" id="productImage2" name="productImage2" accept="image/*">
						<img id="imagePreview2" class="image-preview" src="#" alt="Image Preview" style="display:none;">
					</div>
					<div class="form-group">
						<label for="productImage">Product Image 3</label>
						<input type="file" class="form-control-file" id="productImage3" name="productImage3" accept="image/*">
						<img id="imagePreview3" class="image-preview" src="#" alt="Image Preview" style="display:none;">
					</div>
					<div class="form-group">
						<label for="category">Category</label>
						<select name="category" id="category" class="form-control" required>
							<option value="" disabled selected>Select a category</option>
							@foreach ($categories as $category)
								<option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="availability">Add in Featured</label>
						<select class="form-control" id="availability" name="availability">
						  <option value="0">Not Featured</option>
							<option value="1" selected>Featured</option>
							
						</select>
					</div>
					<div class="form-group">
						<label for="on_sell">On Sell</label>
						<select class="form-control" id="on_sell" name="on_sell">
							<option value="1" selected>On Sale</option>
							<option value="0">Not On Sale</option>
						</select>
					</div>
					<div class="form-group">
						<label for="stock">Stock</label>
						<input type="number" class="form-control" id="stock" name="stock" placeholder="Enter stock quantity" required>
					</div>
					<div class="form-group">
						<label for="shipping_fee">Shipping Fee</label>
						<input type="number" class="form-control" id="shipping_fee" name="shipping_fee" placeholder="Enter shipping_fee" required>
					</div>
					<div class="form-group">
						<label for="coupon_code">Coupon Code</label>
						<input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Enter coupon_code" required>
						<button type="button" id="generateCoupon" class="btn btn-info mt-2">Generate Coupon Code</button>
					</div>
					<div class="form-group">
            <input type="checkbox" id="addTimer" name="addTimer" value="1">
            <label for="addTimer">Add Timer</label>
          </div>
           
          <div id="timerDurationFields" style="display: none; width:100%;">
                        <div class="form-group">
                            <label for="timerDatetime">Sale End Date and Time</label>
                            <input type="datetime-local" class="form-control" id="timerDatetime" name="timerDatetime">
                        </div>
                        <input type="hidden" id="timerDays" name="timerDays">
                        <input type="hidden" id="timerHours" name="timerHours">
                        <input type="hidden" id="timerMinutes" name="timerMinutes">
                        <input type="hidden" id="timerSeconds" name="timerSeconds">
          </div>
					<div style="width:100%;">
						<button type="submit" class="btn btn-primary btn-block">Add Product</button>
					</div>
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
	
	      $('#discountPrice').val(discountPrice.toFixed(2)); // Rounded to 2 decimal places
	    } else {
	      $('#discountPrice').val('');
	    }
	  });
	   
	    $('#addTimer').on('change', function() {
            if ($(this).is(':checked')) {
                $('#timerDurationFields').slideDown(); // Show with a sliding animation
            } else {
                $('#timerDurationFields').slideUp();    // Hide with a sliding animation
                // Optionally clear the input fields when unchecked
                $('#timerDatetime').val('');
                $('#timerDays').val('');
                $('#timerHours').val('');
                $('#timerMinutes').val('');
                $('#timerSeconds').val('');
            }
        });

        // Calculate timer duration on datetime input change
        $('#timerDatetime').on('change', function() {
            var selectedDatetime = new Date($(this).val());
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
        });
	});
</script>
<script>
          document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.add-weight').addEventListener('click', function () {
              const wrapper = document.getElementById('weights-wrapper');
              const newInput = document.createElement('div');
              newInput.classList.add('input-group', 'mb-2');
              newInput.innerHTML = `
                <input type="text" name="multiple_weights[]" class="form-control" placeholder="e.g. 250g" required>
                <button type="button" class="btn btn-danger remove-weight">-</button>
                 `;
              wrapper.appendChild(newInput);
            });
         
            document.addEventListener('click', function (e) {
              if (e.target.classList.contains('remove-weight')) {
                e.target.parentElement.remove();
              }
            });
          });
        </script>
<script>
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