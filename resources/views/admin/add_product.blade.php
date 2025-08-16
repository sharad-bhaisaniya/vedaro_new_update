@extends('layouts.admin_lay')
@section('title', 'Add Product')
@section('content')
<style>


    .size-stock-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.5rem;
        align-items: center;
    }

    .size-stock-row input {
        flex: 1;
            width: 200px;

    }

    .size-stock-row .btn {
        width: 40px;
    }

    .alert {
        position: relative;
        padding: 1rem 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.35rem;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .checkbox-group input[type="checkbox"] {
        width: auto;
    }

    .checkbox-group label {
        margin-bottom: 0;
    }
</style>
<style>
    /* Product Form Styles */
:root {
    --primary-color: #4e73df;
    --secondary-color: #f8f9fc;
    --accent-color: #2e59d9;
    --text-color: #5a5c69;
    --border-color: #d1d3e2;
    --success-color: #1cc88a;
    --danger-color: #e74a3b;
    --warning-color: #f6c23e;
}

.product-form-container {
    background-color: white;
    border-radius: 0.35rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    padding: 2rem;
    margin-bottom: 2rem;
}

.form-section {
    margin-bottom: 1rem;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
    border-radius: 0.35rem;
    background-color: var(--secondary-color);
}

.form-section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--border-color);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 12px;
}

.form-group {
    margin-bottom: 0.25rem;
    width: 100%;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-color);
}

.form-control {
    display: block;
    width: 100%;
    min-width: 180px;
    /*max-width: 300px;*/
    padding: 0.75rem 1rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #6e707e;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #d1d3e2;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    color: #6e707e;
    background-color: #fff;
    border-color: #bac8f3;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.image-preview-container {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 1rem;
}
#productDescription1, #productDescription2{
    width: 100% !important;
    min-width: auto !important;
    max-width: 100%;
}
.image-preview {
    width: 150px;
    height: 150px;
    border: 1px dashed var(--border-color);
    border-radius: 0.35rem;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fc;
}

.image-preview img {
    max-width: 100%;
    max-height: 100%;
    display: none;
}

.image-preview .placeholder {
    color: var(--text-color);
    font-size: 0.875rem;
    text-align: center;
    padding: 0.5rem;
}

.btn {
    display: inline-block;
    font-weight: 400;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    background-color: var(--primary-color);
    border: 1px solid var(--primary-color);
    padding: 0.75rem 1rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.35rem;
    transition: all 0.15s ease-in-out;
}

.btn:hover {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
    color: #fff;
}

.btn-outline-secondary {
    color: #6c757d;
    border-color: #6c757d;
    background-color: transparent;
}

.btn-outline-secondary:hover {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-success {
    background-color: var(--success-color);
    border-color: var(--success-color);
}

.btn-danger {
    background-color: var(--danger-color);
    border-color: var(--danger-color);
}

.btn-info {
    background-color: #36b9cc;
    border-color: #36b9cc;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}

.size-stock-row {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    align-items: center;
}

.size-stock-row .form-control {
    /*max-width: 120px;*/
    flex: 1;
}

.size-stock-row .btn {
    width: 40px;
}

.alert {
    position: relative;
    padding: 1rem 1rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.35rem;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.full-width {
    grid-column: 1 / -1;
}

.checkbox-group {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.checkbox-group input[type="checkbox"] {
    width: auto;
}

.checkbox-group label {
    margin-bottom: 0;
}

.form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.form-header h2 {
    margin: 0;
    font-size: 1.5rem;
}

.form-header .btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.input-group {
    display: flex;
    /*width: 100%;*/
    /*min-width: 200px;*/
    /*max-width: 300px;*/
}

.input-group .form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-control,
    .input-group {
        /*max-width: 100%;*/
    }
}

    /* Inventory Section Specific Styles */
    .inventory-section .size-stock-row {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    /* Size inputs */
    .inventory-section .size-input {
        /*width: 150px;*/
        /*min-width: 150px;*/
        flex: 0 0 auto;
    }

    /* Stock inputs */
    .inventory-section .stock-input {
        /*width: 100px;*/
        /*min-width: 100px;*/
        flex: 0 0 auto;
    }

    /* Weight inputs */
    .inventory-section .weight-input,
    .inventory-section .additional-weight-input {
        /*width: 200px;*/
        /*min-width: 200px;*/
        flex: 0 0 auto;
    }

    /* Total stock input */
    .inventory-section .total-stock-input {
        /*width: 200px;*/
        /*max-width: 200px;*/
        background-color: #f8f9fc;
    }

    /* Buttons */
    .inventory-section .size-btn,
    .inventory-section .weight-btn {
        width: 40px;
        flex: 0 0 auto;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .inventory-section .size-input,
        .inventory-section .stock-input,
        .inventory-section .weight-input,
        .inventory-section .additional-weight-input,
        .inventory-section .total-stock-input {
            /*width: 100%;*/
            /*max-width: 100%;*/
            /*min-width: auto;*/
        }
    }
</style>
 <style>
                /* Inventory Section Styles */
.inventory-section {
    position: relative;
}

/* Toggle Checkbox Styling */
.inventory-section .form-group.mb-3 label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    user-select: none;
}

.inventory-section .form-group.mb-3 input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

/* Size Input Rows */
.inventory-section .size-stock-row {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    align-items: center;
    flex-wrap: nowrap;
}

/* Input Field Sizing */
.inventory-section .size-stock-row .form-control {
    flex: 1;
    /*min-width: 120px;*/
    /*max-width: 150px;*/
}

.inventory-section .size-stock-row .form-control.size-stock {
    /*min-width: 80px;*/
    /*max-width: 100px;*/
}

/* Button Styling */
.inventory-section .size-stock-row .btn-sm {
    width: 36px;
    min-width: 36px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

/* Weight Inputs */
.inventory-section .weight-input,
.inventory-section .additional-weight-input {
    /*max-width: 200px;*/
}

.inventory-section .total-stock-input {
    /*max-width: 200px;*/
    background-color: #f8f9fa;
    cursor: not-allowed;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .inventory-section .size-stock-row {
        flex-wrap: wrap;
    }
    
    .inventory-section .size-stock-row .form-control {
        /*max-width: 100%;*/
        /*min-width: 100%;*/
    }
    
    .inventory-section .size-stock-row .btn-sm {
        /*width: 100%;*/
    }
    
    .inventory-section .weight-input,
    .inventory-section .additional-weight-input,
    .inventory-section .total-stock-input {
        /*max-width: 100%;*/
    }
}

/* Animation for toggle */
#sizesSection {
    transition: all 0.3s ease;
    overflow: hidden;
}

/* Error state styling */
.inventory-section .is-invalid {
    border-color: #e74a3b;
}

.inventory-section .invalid-feedback {
    color: #e74a3b;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
            </style>

<div class=" ">
    {{-- Laravel validation errors --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>There were some issues:</strong>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Custom controller error --}}
    @if (session('error'))
    <div class="alert alert-danger">
        <strong>Error:</strong> {{ session('error') }}
    </div>
    @endif

    {{-- Success message --}}
    @if (session('success'))
    <div class="alert alert-success">
        <strong>Success:</strong> {{ session('success') }}
    </div>
    @endif
    
    

    <div class="product-form-container">
       <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">
            <i class="bi bi-plus-circle-fill text-primary me-2"></i>
            Add New Product
        </h2>
    </div>
    <div>
        <a href="manage-products" class="btn btn-outline-secondary">
            <i class="bi bi-box-seam me-2"></i>
            Manage Products
        </a>
    </div>
</div>

        <form action="{{ route('admin.add_product') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Basic Information Section -->
            <div class="form-section">
                <div class="form-section-title">Basic Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="productName">Product Name *</label>
                        <input type="text" class="form-control" id="productName" name="productName"
                               placeholder="Enter product name" value="{{ old('productName') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Category *</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="" disabled selected>Select a category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}" {{ old('category') == $category['id'] ? 'selected' : '' }}>
                                {{ $category['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Base Price *</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01"
                               placeholder="Enter product price" value="{{ old('price') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="discountPercentage">Discount Percentage</label>
                        <input type="number" class="form-control" id="discountPercentage" name="discountPercentage"
                               placeholder="Enter discount %" value="{{ old('discountPercentage', 0) }}">
                    </div>

                    <div class="form-group">
                        <label for="discountPrice">Discounted Price</label>
                        <input type="number" class="form-control" id="discountPrice" name="discountPrice" step="0.01"
                               placeholder="Calculated automatically" readonly>
                    </div>

                    <div class="form-group">
                        <label for="shipping_fee">Shipping Fee *</label>
                        <input type="number" class="form-control" id="shipping_fee" name="shipping_fee"
                               placeholder="Enter shipping fee" value="{{ old('shipping_fee') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="coupon_code">Coupon Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="coupon_code" name="coupon_code"
                                   placeholder="Enter coupon code" value="{{ old('coupon_code') }}">
                            <button type="button" id="generateCoupon" class="btn btn-info">Generate</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Section -->
        {{--    <div class="form-section inventory-section">
                <div class="form-section-title">Inventory Management</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Product Sizes & Stock</label>
                        <div id="multiple-sizes-wrapper">
                            <div class="size-stock-row">
                                <input type="text" name="multiple_sizes[]" class="form-control" placeholder="Size (Optional)">
                                <input type="number" name="size_stocks[]" class="form-control size-stock" placeholder="Stock" min="0">
                                <button type="button" class="btn btn-success btn-sm size-btn" onclick="addSize()">+</button>
                             </div>
                           
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label for="weight">Default Weight (grams) *</label>
                        <input type="text" class="form-control weight-input" id="weight" name="weight"
                               placeholder="Weight in grams" value="{{ old('weight') }}" required>
                    </div>
            
                    <div class="form-group">
                        <label>Additional Weights (grams)</label>
                        <div id="weights-wrapper">
                            <div class="size-stock-row">
                                <input type="text" name="multiple_weights[]" class="form-control additional-weight-input" placeholder="e.g., 250g">
                                <button type="button" class="btn btn-success btn-sm weight-btn add-weight">+</button>
                            </div>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label for="currentStock">Total Stock</label>
                        <input type="number" class="form-control total-stock-input" id="currentStock" name="stock"
                               placeholder="Calculated automatically" readonly>
                    </div>
                </div>
            </div>--}}
           
            <!-- Inventory Section -->
<div class="form-section inventory-section">
    <div class="form-section-title">Inventory Management</div>

    <div class="form-group mb-3">
        <label>
            <input type="checkbox" id="enableSizesCheckbox" onchange="toggleSizesSection()"> Enable Sizes
        </label>
    </div>
    <!-- Product Sizes & Stock (toggleable) -->
        <div class="form-group" id="sizesSection" style="display: none;">
            <label>Product Sizes & Stock</label>
            <div id="multiple-sizes-wrapper">
                <div class="size-stock-row d-flex gap-2">
                    <input type="text" name="multiple_sizes[]" class="form-control" placeholder="Size (Optional)">
                    <input type="number" name="size_stocks[]" class="form-control size-stock" placeholder="Stock" min="0">
                    <button type="button" class="btn btn-success btn-sm size-btn" onclick="addSize()">+</button>
                </div>
            </div>
        </div>
    <div class="form-grid">
    

        <!-- Default Weight -->
        <div class="form-group">
            <label for="weight">Default Weight (grams) *</label>
            <input type="text" class="form-control weight-input" id="weight" name="weight"
                   placeholder="Weight in grams" value="{{ old('weight') }}" required>
        </div>

        <!-- Additional Weights -->
        <div class="form-group">
            <label>Additional Weights (grams)</label>
            <div id="weights-wrapper">
                <div class="size-stock-row d-flex gap-2">
                    <input type="text" name="multiple_weights[]" class="form-control additional-weight-input" placeholder="e.g., 250g">
                    <button type="button" class="btn btn-success btn-sm weight-btn add-weight">+</button>
                </div>
            </div>
        </div>

        <!-- Total Stock -->
        <div class="form-group">
            <label for="currentStock">Total Stock</label>
          <input type="number" class="form-control total-stock-input" id="currentStock" name="stock"
       placeholder="Calculated automatically">

        </div>
    </div>
</div>





            <!-- Product Details Section -->
            <div class="form-section">
                <div class="form-section-title">Product Details</div>
                <div class="form-grid" style="grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));">
                    <div class="form-group" style="width:100%;">
                        <label for="productDescription1">Description 1 *</label>
                        <textarea class="form-control" id="productDescription1" name="productDescription1" rows="4"
                                  placeholder="Enter main product description" required>{{ old('productDescription1') }}</textarea>
                    </div>

                    <div class="form-group" style="width:100%;">
                        <label for="productDescription2">Description 2</label>
                        <textarea class="form-control" id="productDescription2" name="productDescription2" rows="4"
                                  placeholder="Enter additional product description">{{ old('productDescription2') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="form-section">
                <div class="form-section-title">Product Images</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="productImage1">Main Image *</label>
                        <input type="file" class="form-control-file" id="productImage1" name="productImage1" accept="image/*" required>
                        <div class="image-preview-container">
                            <div class="image-preview" id="imagePreviewContainer1">
                                <img id="imagePreview1" alt="Image Preview">
                                <div class="placeholder">Main image preview</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productImage2">Secondary Image</label>
                        <input type="file" class="form-control-file" id="productImage2" name="productImage2" accept="image/*">
                        <div class="image-preview-container">
                            <div class="image-preview" id="imagePreviewContainer2">
                                <img id="imagePreview2" alt="Image Preview">
                                <div class="placeholder">Secondary image preview</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productImage3">Additional Image</label>
                        <input type="file" class="form-control-file" id="productImage3" name="productImage3" accept="image/*">
                        <div class="image-preview-container">
                            <div class="image-preview" id="imagePreviewContainer3">
                                <img id="imagePreview3" alt="Image Preview">
                                <div class="placeholder">Additional image preview</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="form-section">
                <div class="form-section-title">Product Settings</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="availability">Featured Product</label>
                        <select class="form-control" id="availability" name="availability">
                            <option value="0">Not Featured</option>
                            <option value="1" selected>Featured</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="on_sell">Product Status</label>
                        <select class="form-control" id="on_sell" name="on_sell">
                            <option value="1" selected>On Sale</option>
                            <option value="0">Not On Sale</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="addTimer" name="addTimer" value="1">
                            <label for="addTimer">Enable Sale Timer</label>
                        </div>
                    </div>

                        <div class="form-group full-width" id="timerDurationFields" style="display: none;">
                            <label for="timerDatetime">Sale End Date and Time</label>
                            <input type="datetime-local" class="form-control" id="timerDatetime" name="timerDatetime" required>
                            
                            <input type="hidden" id="timerDays" name="timerDays" required>
                            <input type="hidden" id="timerHours" name="timerHours" required>
                            <input type="hidden" id="timerMinutes" name="timerMinutes" required>
                            <input type="hidden" id="timerSeconds" name="timerSeconds" required>
                        </div>

                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-group full-width text-right mt-4">
                <button type="reset" class="btn btn-secondary mr-2">Reset</button>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function () {
    function setMinDateTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        const localDatetime = `${year}-${month}-${day}T${hours}:${minutes}`;
        $('#timerDatetime').attr('min', localDatetime);
    }

    // Call it once on load
    setMinDateTime();

    // Re-apply min when user focuses the field
    $('#timerDatetime').on('focus', function () {
        setMinDateTime();
    });

    // Optional: prevent manual input of invalid datetime
    $('#timerDatetime').on('change', function () {
        const selected = new Date($(this).val());
        const now = new Date();

        if (selected < now) {
            alert("You cannot select a past date and time.");
            $(this).val('');
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        // Image Preview Functionality
        function setupImagePreview(inputId, previewId, containerId) {
            $(inputId).on('change', function() {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(previewId).attr('src', e.target.result).show();
                    $(containerId + ' .placeholder').hide();
                };
                if (this.files[0]) {
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        setupImagePreview('#productImage1', '#imagePreview1', '#imagePreviewContainer1');
        setupImagePreview('#productImage2', '#imagePreview2', '#imagePreviewContainer2');
        setupImagePreview('#productImage3', '#imagePreview3', '#imagePreviewContainer3');

        // Coupon Code Generation
        $('#generateCoupon').click(function() {
            var couponCode = 'DISC-' + Math.random().toString(36).substring(2, 8).toUpperCase();
            $('#coupon_code').val(couponCode);
        });

        // Discount Price Calculation
        $('#price, #discountPercentage').on('input', function() {
            var price = parseFloat($('#price').val());
            var discountPercentage = parseFloat($('#discountPercentage').val());

            if (!isNaN(price) && !isNaN(discountPercentage)) {
                var discountAmount = (price * discountPercentage) / 100;
                var discountPrice = price - discountAmount;
                $('#discountPrice').val(discountPrice.toFixed(2));
            } else {
                $('#discountPrice').val('');
            }
        });

        // Timer Toggle
        $('#addTimer').on('change', function() {
            if ($(this).is(':checked')) {
                $('#timerDurationFields').slideDown();
            } else {
                $('#timerDurationFields').slideUp();
                $('#timerDatetime').val('');
                $('#timerDays').val('');
                $('#timerHours').val('');
                $('#timerMinutes').val('');
                $('#timerSeconds').val('');
            }
        });

        // Timer Calculation
        $('#timerDatetime').on('change', function() {
            var selectedDatetime = new Date($(this).val());
            var now = new Date();

            if (selectedDatetime > now) {
                var diff = selectedDatetime.getTime() - now.getTime();

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
                $('#timerDays').val(0);
                $('#timerHours').val(0);
                $('#timerMinutes').val(0);
                $('#timerSeconds').val(0);
            }
        });

        // Add Weight Field
        $(document).on('click', '.add-weight', function() {
            const wrapper = $('#weights-wrapper');
            const newRow = $(`
                <div class="size-stock-row">
                    <input type="text" name="multiple_weights[]" class="form-control" placeholder="e.g., 500g">
                    <button type="button" class="btn btn-danger btn-sm remove-weight">-</button>
                </div>
            `);
            wrapper.append(newRow);
        });

        // Remove Weight Field
        $(document).on('click', '.remove-weight', function() {
            $(this).parent().remove();
            updateTotalStock();
        });

        // Update Total Stock Calculation
        function updateTotalStock() {
            const stockInputs = $('.size-stock');
            let total = 0;
            stockInputs.each(function() {
                const val = parseInt($(this).val()) || 0;
                total += val;
            });
            $('#totalStock').val(total);
            $('#currentStock').val(total);
        }

        // Add Size Field
        window.addSize = function() {
            const wrapper = $('#multiple-sizes-wrapper');
            const newRow = $(`
                <div class="size-stock-row">
                    <input type="text" name="multiple_sizes[]" class="form-control" placeholder="Size (e.g., 12x12x6)">
                    <input type="number" name="size_stocks[]" class="form-control size-stock" placeholder="Stock" min="0">
                    <button type="button" class="btn btn-danger btn-sm remove-size">-</button>
                </div>
            `);
            wrapper.append(newRow);
        }

        // Remove Size Field
        $(document).on('click', '.remove-size', function() {
            $(this).parent().remove();
            updateTotalStock();
        });

        // Stock Input Listener
        $(document).on('input', '.size-stock', updateTotalStock);
    });
</script>
<!--Inventory Script-->
<script>
function toggleSizesSection() {
    const checkbox = document.getElementById('enableSizesCheckbox');
    const sizesSection = document.getElementById('sizesSection');
    if (checkbox.checked) {
        sizesSection.style.display = 'block';
    } else {
        sizesSection.style.display = 'none';
        // Optional: clear size inputs when disabled
        document.querySelectorAll('input[name="multiple_sizes[]"], input[name="size_stocks[]"]').forEach(el => el.value = '');
    }
}

function addSize() {
    const wrapper = document.getElementById('multiple-sizes-wrapper');
    const newRow = document.createElement('div');
    newRow.classList.add('size-stock-row', 'd-flex', 'gap-2', 'mt-2');
    newRow.innerHTML = `
        <input type="text" name="multiple_sizes[]" class="form-control" placeholder="Size (Optional)">
        <input type="number" name="size_stocks[]" class="form-control size-stock" placeholder="Stock" min="0">
        <button type="button" class="btn btn-danger btn-sm" onclick="removeSize(this)">−</button>
    `;
    wrapper.appendChild(newRow);
}

function removeSize(btn) {
    btn.closest('.size-stock-row').remove();
}
</script>
@if(session('swal'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swalData = @json(session('swal'));
        Swal.fire({
            icon: swalData.icon,
            title: swalData.title,
            text: swalData.text,
            timer: swalData.timer ?? null,
            showConfirmButton: swalData.showConfirmButton ?? true,
            timerProgressBar: true,
            toast: swalData.toast ?? false,
            position: swalData.position ?? 'center',
            background: swalData.background || (swalData.icon === 'error' ? '#f8d7da' : '#d1e7dd'),
            iconColor: swalData.iconColor || (swalData.icon === 'error' ? '#dc3545' : '#0f5132')
        });
    });
</script>
@endif
@endsection
