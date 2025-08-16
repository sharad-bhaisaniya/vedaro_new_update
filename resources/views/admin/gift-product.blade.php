@extends('layouts.admin_lay')
@section('title', 'Gift-Product')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/admin/gift.css') }}">

<div class="container mt-1">
    <div class="row justify-content-end">
        <div class="col-lg-12 col-md-10 col-sm-12">
            <h2 class="text-center mb-4"><i class="fas fa-gift"></i> Add Gift Product</h2>
            <div class="form-container">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any()))
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

                    <div class="form-section">
                        <h4>Basic Information</h4>
                        <div class="inside-form">


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
                    </div>
                    </div>

                    <div class="form-section">
                        <h4>Descriptions</h4>
                                 <div class="inside-form">
                        <div class="form-group">
                            <label for="productDescription1">Product Description</label>
                            <textarea class="form-control" id="productDescription1" name="productDescription1" rows="4" placeholder="Enter product description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="productDescription2">Product Description 2</label>
                            <textarea class="form-control" id="productDescription2" name="productDescription2" rows="4" placeholder="Enter additional description"></textarea>
                        </div>
                    </div>
                               </div>

                    <div class="form-section">
                        <h4>Images</h4>
                             <div class="inside-form">
                        <div class="form-group">
                            <label for="productImage1" class="product-image">Product Image 1 (Required)</label>
                            <input type="file" class="form-control-file" id="productImage1" name="productImage1" accept="image/*" required>
                            <div class="image-preview mt-2">
                                <img id="imagePreview1" src="#" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: contain;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productImage2"  class="product-image">Product Image 2</label>
                            <input type="file" class="form-control-file" id="productImage2" name="productImage2" accept="image/*">
                            <div class="image-preview mt-2">
                                <img id="imagePreview2" src="#" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: contain;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productImage3"  class="product-image">Product Image 3</label>
                            <input type="file" class="form-control-file" id="productImage3" name="productImage3" accept="image/*">
                            <div class="image-preview mt-2">
                                <img id="imagePreview3" src="#" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="form-section">
                        <h4>Gift Settings</h4>
                             <div class="inside-form">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Active (Available as gift)</label>
                        </div>
                        <div class="form-group">
                            <label for="valid_from">Valid From</label>
                            <input type="datetime-local" class="form-control" id="valid_from" name="valid_from">
                        </div>
                        <div class="form-group">
                            <label for="valid_to">Valid To</label>
                            <input type="datetime-local" class="form-control" id="valid_to" name="valid_to">
                        </div>
                        <div class="form-group">
                            <label for="stock_quantity">Stock Quantity</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" value="0" required>
                        </div>
                        <div class="form-group">
                            <label for="minimum_cart_amount">Minimum Cart Amount (₹)</label>
                            <input type="number" class="form-control" id="minimum_cart_amount" name="minimum_cart_amount" step="0.01" min="0" value="0" required>
                        </div>
                    </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Add Gift Product</button>
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
