@extends('layouts.admin_lay')
@section('title', 'Gift-Product')
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

</style>
<div class="container mt-1">
	<div class="row justify-content-end">
		<div class="col-lg-12 col-md-10 col-sm-12">
			<h2 class="text-center mb-4">Add Gift Product</h2>
			<div class="form-container">
<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Error Message -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form class="product_form" action="{{ route('admin.gift-product') }}" method="POST" enctype="multipart/form-data">
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
        <label for="size">Size (cms or inches)</label>
        <input type="text" class="form-control" id="size" name="size" placeholder="(H x W x L)" required>
    </div>
    <div class="form-group">
        <label for="weight">Weight in (grams)</label>
        <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight" required>
    </div>
    <div class="form-group">
        <label for="productDescription1">Product Description</label>
        <textarea class="form-control" id="productDescription1" name="productDescription1" rows="4" placeholder="Enter product description" required></textarea>
    </div>
    <div class="form-group">
        <label for="productDescription2">Product Description 2</label>
        <textarea class="form-control" id="productDescription2" name="productDescription2" rows="4" placeholder="Enter product description" required></textarea>
    </div>
    <div class="form-group">
        <label for="productImage1">Product Image 1</label>
        <input type="file" class="form-control-file" id="productImage1" name="productImage1" accept="image/*">
    </div>
    <div class="form-group">
        <label for="productImage2">Product Image 2</label>
        <input type="file" class="form-control-file" id="productImage2" name="productImage2" accept="image/*">
    </div>
    <div class="form-group">
        <label for="productImage3">Product Image 3</label>
        <input type="file" class="form-control-file" id="productImage3" name="productImage3" accept="image/*">
    </div>
    <div>
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

</script>
@endsection