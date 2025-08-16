@extends('layouts.admin_lay')
@section('title', 'Edit Product')
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
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.25rem;
    min-width: 295px;
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
    max-width: 300px;
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
    max-width: 120px;
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
    width: 100%;
    min-width: 200px;
    max-width: 300px;
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
        max-width: 100%;
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
        width: 150px;
        min-width: 150px;
        flex: 0 0 auto;
    }

    /* Stock inputs */
    .inventory-section .stock-input {
        width: 100px;
        min-width: 100px;
        flex: 0 0 auto;
    }

    /* Weight inputs */
    .inventory-section .weight-input,
    .inventory-section .additional-weight-input {
        width: 200px;
        min-width: 200px;
        flex: 0 0 auto;
    }

    /* Total stock input */
    .inventory-section .total-stock-input {
        width: 200px;
        max-width: 200px;
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
            width: 100%;
            max-width: 100%;
            min-width: auto;
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
    min-width: 120px;
    max-width: 150px;
}

.inventory-section .size-stock-row .form-control.size-stock {
    min-width: 80px;
    max-width: 100px;
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
    max-width: 200px;
}

.inventory-section .total-stock-input {
    max-width: 200px;
    background-color: #f8f9fa;
    cursor: not-allowed;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .inventory-section .size-stock-row {
        flex-wrap: wrap;
    }
    
    .inventory-section .size-stock-row .form-control {
        max-width: 100%;
        min-width: 100%;
    }
    
    .inventory-section .size-stock-row .btn-sm {
        width: 100%;
    }
    
    .inventory-section .weight-input,
    .inventory-section .additional-weight-input,
    .inventory-section .total-stock-input {
        max-width: 100%;
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
            <i class="bi bi-pencil-square text-primary me-2"></i>
            Edit Product
        </h2>
    </div>
    <div>
        <a href="{{ route('admin.manage_product') }}" class="btn btn-outline-secondary">
            <i class="bi bi-box-seam me-2"></i>
            Manage Products
        </a>
    </div>
</div>

        <form action="{{ route('admin.update_product', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="form-section">
                <div class="form-section-title">Basic Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="productName">Product Name *</label>
                        <input type="text" class="form-control" id="productName" name="productName"
                               placeholder="Enter product name" value="{{ old('productName', $product->productName) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Category *</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="" disabled>Select a category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}" {{ (old('category', $product->category) == $category['id']) ? 'selected' : '' }}>
                                {{ $category['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Base Price *</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01"
                               placeholder="Enter product price" value="{{ old('price', $product->price) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="discountPercentage">Discount Percentage</label>
                        <input type="number" class="form-control" id="discountPercentage" name="discountPercentage"
                               placeholder="Enter discount %" value="{{ old('discountPercentage', $product->discountPercentage) }}">
                    </div>

                    <div class="form-group">
                        <label for="discountPrice">Discounted Price</label>
                        <input type="number" class="form-control" id="discountPrice" name="discountPrice" step="0.01"
                               placeholder="Calculated automatically" value="{{ old('discountPrice', $product->discountPrice) }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="shipping_fee">Shipping Fee *</label>
                        <input type="number" class="form-control" id="shipping_fee" name="shipping_fee"
                               placeholder="Enter shipping fee" value="{{ old('shipping_fee', $product->shipping_fee) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="coupon_code">Coupon Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="coupon_code" name="coupon_code"
                                   placeholder="Enter coupon code" value="{{ old('coupon_code', $product->coupon_code) }}">
                            <button type="button" id="generateCoupon" class="btn btn-info">Generate</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Section -->
            <div class="form-section inventory-section">
                <div class="form-section-title">Inventory Management</div>

                <div class="form-group mb-3">
                    <label>
                        <input type="checkbox" id="enableSizesCheckbox" onchange="toggleSizesSection()" 
                            {{ !empty(json_decode($product->multiple_sizes)) ? 'checked' : '' }}> 
                        Enable Sizes
                    </label>
                </div>

                <div class="form-grid">
                    <!-- Product Sizes & Stock (toggleable) -->
                    <div class="form-group" id="sizesSection" style="{{ !empty(json_decode($product->multiple_sizes)) ? 'display: block;' : 'display: none;' }}">
                        <label>Product Sizes & Stock</label>
                        <div id="multiple-sizes-wrapper">
                            @php
                                $sizes = json_decode($product->multiple_sizes) ?: [];
                                $sizeStocks = json_decode($product->size_stock) ?: [];
                            @endphp
                            
                            @if(count($sizes) > 0)
                                @foreach($sizes as $index => $size)
                                    <div class="size-stock-row d-flex gap-2">
                                        <input type="text" name="multiple_sizes[]" class="form-control" 
                                               placeholder="Size (Optional)" value="{{ $size }}">
                                        <input type="number" name="size_stocks[]" class="form-control size-stock" 
                                               placeholder="Stock" min="0" value="{{ $sizeStocks->$size ?? 0 }}">
                                        @if($index === 0)
                                            <button type="button" class="btn btn-success btn-sm size-btn" onclick="addSize()">+</button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeSize(this)">−</button>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="size-stock-row d-flex gap-2">
                                    <input type="text" name="multiple_sizes[]" class="form-control" placeholder="Size (Optional)">
                                    <input type="number" name="size_stocks[]" class="form-control size-stock" placeholder="Stock" min="0">
                                    <button type="button" class="btn btn-success btn-sm size-btn" onclick="addSize()">+</button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Default Weight -->
                    <div class="form-group">
                        <label for="weight">Default Weight (grams) *</label>
                        <input type="text" class="form-control weight-input" id="weight" name="weight"
                               placeholder="Weight in grams" value="{{ old('weight', $product->weight) * 1000 }}" required>
                    </div>

                    <!-- Additional Weights -->
                    <div class="form-group">
                        <label>Additional Weights (grams)</label>
                        <div id="weights-wrapper">
                            @php
                                $weights = json_decode($product->multiple_weights) ?: [''];
                            @endphp
                            
                            @foreach($weights as $index => $weight)
                                <div class="size-stock-row d-flex gap-2">
                                    <input type="text" name="multiple_weights[]" class="form-control additional-weight-input" 
                                           placeholder="e.g., 250g" value="{{ $weight  * 1000  }}">
                                    @if($index === 0)
                                        <button type="button" class="btn btn-success btn-sm weight-btn add-weight">+</button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm remove-weight">−</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Total Stock -->
                    <div class="form-group">
                        <label for="currentStock">Total Stock</label>
                        <input type="number" class="form-control total-stock-input" id="currentStock" name="stock"
                               placeholder="Calculated automatically" value="{{ old('stock', $product->current_stock) }}">
                    </div>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="form-section">
                <div class="form-section-title">Product Details</div>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="productDescription1">Description 1 *</label>
                        <textarea class="form-control" id="productDescription1" name="productDescription1" rows="4"
                                  placeholder="Enter main product description" required>{{ old('productDescription1', $product->productDescription1) }}</textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="productDescription2">Description 2</label>
                        <textarea class="form-control" id="productDescription2" name="productDescription2" rows="4"
                                  placeholder="Enter additional product description">{{ old('productDescription2', $product->productDescription2) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="form-section">
                <div class="form-section-title">Product Images</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="productImage1">Main Image</label>
                        <input type="file" class="form-control-file" id="productImage1" name="productImage1" accept="image/*">
                        <div class="image-preview-container">
                            <div class="image-preview" id="imagePreviewContainer1">
                                @if($product->image1)
                                    <img id="imagePreview1" src="{{ asset('storage/' . $product->image1) }}" alt="Current Image">
                                @else
                                    <img id="imagePreview1" alt="Image Preview" style="display: none;">
                                    <div class="placeholder">No image selected</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productImage2">Secondary Image</label>
                        <input type="file" class="form-control-file" id="productImage2" name="productImage2" accept="image/*">
                        <div class="image-preview-container">
                            <div class="image-preview" id="imagePreviewContainer2">
                                @if($product->image2)
                                    <img id="imagePreview2" src="{{ asset('storage/' . $product->image2) }}" alt="Current Image">
                                @else
                                    <img id="imagePreview2" alt="Image Preview" style="display: none;">
                                    <div class="placeholder">No image selected</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productImage3">Additional Image</label>
                        <input type="file" class="form-control-file" id="productImage3" name="productImage3" accept="image/*">
                        <div class="image-preview-container">
                            <div class="image-preview" id="imagePreviewContainer3">
                                @if($product->image3)
                                    <img id="imagePreview3" src="{{ asset('storage/' . $product->image3) }}" alt="Current Image">
                                @else
                                    <img id="imagePreview3" alt="Image Preview" style="display: none;">
                                    <div class="placeholder">No image selected</div>
                                @endif
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
                            <option value="0" {{ old('availability', $product->availability) == 0 ? 'selected' : '' }}>Not Featured</option>
                            <option value="1" {{ old('availability', $product->availability) == 1 ? 'selected' : '' }}>Featured</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="on_sell">Product Status</label>
                        <select class="form-control" id="on_sell" name="on_sell">
                            <option value="1" {{ old('on_sell', $product->on_sell) == 1 ? 'selected' : '' }}>On Sale</option>
                            <option value="0" {{ old('on_sell', $product->on_sell) == 0 ? 'selected' : '' }}>Not On Sale</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="addTimer" name="addTimer" value="1" {{ $product->add_timer ? 'checked' : '' }}>
                            <label for="addTimer">Enable Sale Timer</label>
                        </div>
                    </div>

                    <div class="form-group full-width" id="timerDurationFields" style="{{ $product->add_timer ? 'display: block;' : 'display: none;' }}">
                        <label for="timerDatetime">Sale End Date and Time</label>
                        @php
                            $timerEnd = $product->timer_end_at ? \Carbon\Carbon::parse($product->timer_end_at) : null;
                            $timerValue = $timerEnd ? $timerEnd->format('Y-m-d\TH:i') : '';
                        @endphp
                        <input type="datetime-local" class="form-control" id="timerDatetime" name="timerDatetime" value="{{ $timerValue }}">
                        <input type="hidden" id="timerDays" name="timerDays" value="{{ $product->timer_days ?? 0 }}">
                        <input type="hidden" id="timerHours" name="timerHours" value="{{ $product->timer_hours ?? 0 }}">
                        <input type="hidden" id="timerMinutes" name="timerMinutes" value="{{ $product->timer_minutes ?? 0 }}">
                        <input type="hidden" id="timerSeconds" name="timerSeconds" value="{{ $product->timer_seconds ?? 0 }}">
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-group full-width text-right mt-4">
                <button type="reset" class="btn btn-secondary mr-2">Reset</button>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>
</div>

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
                <div class="size-stock-row d-flex gap-2">
                    <input type="text" name="multiple_weights[]" class="form-control" placeholder="e.g., 500g">
                    <button type="button" class="btn btn-danger btn-sm remove-weight">−</button>
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
            $('#currentStock').val(total);
        }

        // Stock Input Listener
        $(document).on('input', '.size-stock', updateTotalStock);
        
        // Initialize discount price calculation
        $('#price').trigger('input');
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
    updateTotalStock();
}

// Initialize sizes section based on existing data
document.addEventListener('DOMContentLoaded', function() {
    const sizes = @json(json_decode($product->multiple_sizes));
    if (sizes && sizes.length > 0) {
        document.getElementById('enableSizesCheckbox').checked = true;
        document.getElementById('sizesSection').style.display = 'block';
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--swan sweet message-->
@if(Session::has('swal'))
    <script>
        swal({
            icon: "{{ session('swal')['icon'] }}",
            title: "{{ session('swal')['title'] }}",
            text: "{{ session('swal')['text'] }}",
            showConfirmButton: {{ session('swal')['showConfirmButton'] ?? 'true' }},
            timer: {{ session('swal')['timer'] ?? 'null' }}
        });
    </script>
@endif



@endsection