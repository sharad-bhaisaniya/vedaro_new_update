@extends('layouts.admin_lay')

@section('content')
<!-- Add CSRF token meta tag -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row justify-content-center p-4">
    <div class="col-12 col-xl-12">
        <h4 class="mb-3 text-secondary">Update Purchase</h4>
        <form id="invoiceInventoryForm" action="{{ route('purchase.update', $purchase->id) }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
            @csrf
            <!-- Add this hidden section in your main form for file inputs -->
<div id="itemFileInputs" style="display: none;">
    <!-- This will be populated dynamically with file inputs for each item -->
</div>

            <!-- Vendor Details Section -->
            <div class="p-3 mb-4 border-bottom">
                <h6 class="h6 mb-2 text-uppercase text-secondary">Vendor Details</h6>
                <div class="row row-cols-md-2 g-2">
                    <div class="col">
                        <label for="invoiceNumber" class="form-label form-label-sm">Invoice Number (bill number) *</label>
                        <input type="text" class="form-control form-control-sm" id="invoiceNumber" name="invoiceNumber" value="{{ $purchase->invoice_number }}" required>
                        <div class="invalid-feedback">Please provide an invoice number.</div>
                    </div>
                
                    <div class="col">
                    <label for="invoiceDate" class="form-label form-label-sm">Invoice Date *</label>

                    <input 
                    type="date" 
                    class="form-control form-control-sm" 
                    id="invoiceDate" 
                    name="invoiceDate" 
                    value="{{ old('invoiceDate', \Carbon\Carbon::parse($purchase->invoice_date ?? now())->format('Y-m-d')) }}" 
                    required
                >
                </div>

                </div>
                <div class="row row-cols-md-2 g-2 mt-2">
                    <div class="col">
                        <label for="vendorSelect" class="form-label form-label-sm">Vendor Name *</label>
                        <select class="form-select form-select-sm" id="vendorSelect" name="vendorName" required>
                            <option value="">-- Select Vendor --</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}"
                                        data-gstin="{{ $vendor->gst_no }}"
                                        data-address="{{ $vendor->address }}"
                                        {{ $vendor->id == $purchase->vendor_id ? 'selected' : '' }}>
                                    {{ $vendor->display_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a vendor.</div>
                    </div>
                    <div class="col">
                        <label for="vendorGSTIN" class="form-label form-label-sm">Vendor GSTIN/UIN</label>
                        <input type="text" class="form-control form-control-sm bg-light" id="vendorGSTIN" name="vendorGSTIN" readonly value="{{ $purchase->vendor->gst_no ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Product Items Section -->
            <div class="p-3 mb-4 border-bottom">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="h6 mb-0 text-uppercase text-secondary">Product Items</h6>
                    <button type="button" id="addItemBtn" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i>Add New Item
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-hover align-middle" id="items-table">
                        <thead>
                            <tr class="text-uppercase fw-normal">
                                <th scope="col" class="text-start">#</th>
                                <th scope="col" class="text-start">Product Name</th>
                                <th scope="col" class="text-start">Qty</th>
                                <th scope="col" class="text-start">Price</th>
                                <th scope="col" class="text-start">Total (Incl. Tax)</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="itemTableBody">
                            @if($purchase->items->count() > 0)
                                @foreach($purchase->items as $index => $item)
                                <tr data-index="{{ $index }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₹{{ number_format($item->unit_price, 2) }}</td>
                                    <td>₹{{ number_format($item->total_incl_tax, 2) }}</td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-primary edit-item" data-index="{{ $index }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-item" data-index="{{ $index }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr class="placeholder-row">
                                    <td colspan="6" class="text-center py-5 text-muted">No items found. Click "Add New Item" to begin.</td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="5" class="text-end">Grand Total (Incl. Tax):</td>
                                <td id="grandTotalDisplay" class="text-primary fs-5">₹{{ number_format($purchase->grand_total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end pt-4 border-top">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-save me-1"></i>Update Purchase & Update Inventory
                </button>
            </div>
            <div id="messageBox" class="alert d-none mt-4 text-center" role="alert"></div>
        </form>
    </div>
</div>

<!-- Item Details Modal -->
<div class="modal fade" id="itemDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemDetailsModalLabel">Edit Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="itemDetailsForm" enctype="multipart/form-data">
                    <input type="hidden" id="modalItemId">
                    <input type="hidden" id="modalProductId">
                    
                    <!-- Purchase Section -->
                    <h6 class="h6 mb-3 text-uppercase text-secondary">Purchase Section</h6>
                    <div class="row row-cols-md-5 g-2 mb-3">
                 
                        @php
                            use App\Models\PurchaseProductName;
                            $productNames = PurchaseProductName::orderBy('name')->get();
                        @endphp

                        <div class="col">
                            <label for="modalProductName" class="form-label form-label-sm">Purchase Product Name *</label>
                            <select class="form-select form-select-sm" id="modalProductName" name="productName" required>
                                <option value="">-- Select Product Name --</option>
                                @foreach($productNames as $product)
                                    <option 
                                        value="{{ $product->name }}"
                                        {{ old('productName', $purchase->product_name ?? '') == $product->name ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label for="modalItemCode" class="form-label form-label-sm">Purchase Item Code</label>
                            <input type="text" class="form-control form-control-sm" id="modalItemCode" name="itemCode">
                        </div>
                        <div class="col">
                            <label for="modalQuantity" class="form-label form-label-sm">Quantity *</label>
                            <input type="number" class="form-control form-control-sm calculate-field" id="modalQuantity" name="quantity" value="1" min="1" required>
                        </div>
                        <div class="col">
                            <label for="modalUnitPrice" class="form-label form-label-sm">Purchase Price *</label>
                            <input type="number" class="form-control form-control-sm calculate-field" id="modalUnitPrice" name="unitPrice" step="0.01" required>
                        </div>
                        <div class="col">
                            <label for="modalDiscount" class="form-label form-label-sm">Discount %</label>
                            <input type="number" class="form-control form-control-sm calculate-field" id="modalDiscount" name="discountPercentage" step="0.01">
                        </div>
                        <div class="col">
                            <label for="modalTaxGroup" class="form-label form-label-sm">Tax Group*</label>
                            <select class="form-select form-select-sm calculate-field" id="modalTaxGroup" name="tax_group_id" required>
                                <option value="" disabled selected>-- Select Tax Group --</option>
                                @foreach ($tax_groups as $group)
                                    @if ($group->taxes->isNotEmpty())
                                        <option value="{{ $group->id }}"
                                            data-rates="{{ $group->taxes->pluck('rate')->implode(',') }}">
                                            {{ $group->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="modalNetPrice" class="form-label form-label-sm">Net Purchase Price (after discount)</label>
                            <input type="number" class="form-control form-control-sm bg-light" id="modalNetPrice" name="netPrice" step="0.01" readonly>
                        </div>
                        <div class="col">
                            <label for="modalTaxAmount" class="form-label form-label-sm">Tax Amount</label>
                            <input type="number" class="form-control form-control-sm bg-light" id="modalTaxAmount" name="lineTaxAmount" step="0.01" readonly>
                        </div>
                        <div class="col">
                            <label for="modalTotalInclTax" class="form-label form-label-sm">Line Total (Incl. Tax)</label>
                            <input type="number" class="form-control form-control-sm bg-light" id="modalTotalInclTax" name="lineTotalInclTax" step="0.01" readonly>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Selling Section -->
                    <h6 class="h6 mb-3 text-uppercase text-secondary mt-4">Selling Section</h6>
                    <div class="row row-cols-md-5 g-2 mb-3">
                        <div class="col">
                            <label for="modalSellName" class="form-label form-label-sm">Product Name (sell) *</label>
                            <input type="text" class="form-control form-control-sm" id="modalSellName" name="sellName">
                        </div>
                        <div class="col">
                            <label for="modalCategory" class="form-label form-label-sm">Category *</label>
                            <select id="modalCategory" name="category" class="form-select form-select-sm" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                     
                        @php
                            use App\Models\Brand;
                            use App\Models\HsnCode;

                            $brands = Brand::orderBy('name')->get();
                            $hsnCodes = HsnCode::orderBy('code')->get();
                        @endphp
                                                
                        {{-- Brand / Manufacturer --}}
                        <div class="col">
                            <label for="modalBrand" class="form-label form-label-sm">Brand / Manufacturer</label>
                            <select class="form-select form-select-sm" id="modalBrand" name="brand">
                                <option value="">-- Select Brand --</option>
                                @foreach($brands as $brand)
                                    <option 
                                        value="{{ $brand->name }}" 
                                        {{ old('brand', $purchase->brand ?? '') == $brand->name ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col" hidden>
                            <label for="modalBarcode" class="form-label form-label-sm">Barcode</label>
                            <input type="text" class="form-control form-control-sm" id="modalBarcode" name="barcode">
                        </div>
                        <div class="col" hidden>
                            <label for="modalTotalStock" class="form-label form-label-sm">RFID</label>
                            <input type="number" class="form-control form-control-sm" id="modalTotalStock" name="stock">
                        </div>
                        {{-- <div class="col">
                            <label for="modalHSN" class="form-label form-label-sm">HSN Code</label>
                            <input type="text" class="form-control form-control-sm" id="modalHSN" name="hsnCode">
                        </div> --}}
                        {{-- HSN Code --}}
                        <div class="col">
                            <label for="modalHSN" class="form-label form-label-sm">HSN Code</label>
                            <select class="form-select form-select-sm" id="modalHSN" name="hsnCode">
                                <option value="">-- Select HSN --</option>
                                @foreach($hsnCodes as $hsn)
                                    <option 
                                        value="{{ $hsn->code }}"
                                        {{ old('hsnCode', $purchase->hsn_code ?? '') == $hsn->code ? 'selected' : '' }}>
                                        {{ $hsn->code }} - {{ $hsn->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Inventory Management Section -->
                    <div class="inventory-section">
                        <hr>
                        <h6 class="h6 mb-3 text-uppercase text-secondary mt-4">Inventory Management</h6>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="toggleVariantsCheckbox" name="useVariants" value="1">
                            <label class="form-check-label form-label-sm" for="toggleVariantsCheckbox">
                                Use Product Variants (Size,Weight, etc.)
                            </label>
                        </div>
                        
                        <!-- Product Variants Section -->
                        <div id="productVariantsSection" style="display: none;">
                            <h6 class="h6 mb-3 text-uppercase text-secondary mt-4">Product Variants</h6>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="text-muted small mb-0">Define variations (e.g., size, weight) and their specific stock/price.</p>
                                        <button type="button" id="addVariantBtn" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-plus me-1"></i> Add Variant Row
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered align-middle" id="variantsTable">
                                            <thead>
                                                <tr class="table-light">
                                                    <th style="width: 25%;">Name (e.g., Size/Weight)</th>
                                                    <th style="width: 15%;">Weight (gram)</th>
                                                    <th style="width: 20%;">Price</th>
                                                    <th style="width: 20%;">Discount Price</th>
                                                    <th style="width: 10%;">Stock Qty</th>
                                                    <th style="width: 10%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="variantsTableBody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Base Price and Sell Price Fields -->
                        <div class="row row-cols-md-5 g-2 mb-3">
                            <div class="col" id="basePrice">
                                <label for="modalMRP" class="form-label form-label-sm">Base Price (per item)</label>
                                <input type="number" class="form-control form-control-sm" id="modalMRP" name="mrpPerUnit" step="0.01">
                            </div>
                            <div class="col">
                                <label for="modalSellDiscount" class="form-label form-label-sm">Sell Discount %</label>
                                <input type="number" class="form-control form-control-sm" value="0" id="modalSellDiscount" name="sellDiscountPercentage">
                            </div>
                            <div class="col">
                                <label for="modalSellTaxGroup" class="form-label form-label-sm">Selling Tax Group*</label>
                                <select class="form-select form-select-sm calculate-field" id="modalSellTaxGroup" name="sell_tax_group_id" required>
                                    <option value="" disabled selected>-- Select Tax Group --</option>
                                    @foreach ($tax_groups as $group)
                                        @if ($group->taxes->isNotEmpty())
                                            <option value="{{ $group->id }}"
                                                data-rates="{{ $group->taxes->pluck('rate')->implode(',') }}">
                                                {{ $group->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="col" id="sellPrice">
                                <label for="modalSellPrice" class="form-label form-label-sm">Sell Price</label>
                                <input type="number" class="form-control form-control-sm" id="modalSellPrice" name="sellPrice" step="0.01" readonly>
                            </div>
                            <div class="col">
                                <label for="modalShippingFee" class="form-label form-label-sm">Shipping Fee *</label>
                                <input type="number" class="form-control form-control-sm" id="modalShippingFee" name="shippingFee">
                            </div>
                            <div class="col" id="weightFieldContainer">
                                <label for="modalWeight" class="form-label form-label-sm">Weight *</label>
                                <input type="number" class="form-control form-control-sm" id="modalWeight" name="weight">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Images Section -->
                    <hr>
                    <h6 class="h6 mb-3 text-uppercase text-secondary mt-4">Product Images</h6>
                  

                    <div class="row row-cols-md-3 g-2 mb-3">
                        <div class="col">
                            <label for="modalImage1" class="form-label form-label-sm">Image 1</label>
                            <input type="file" class="form-control form-control-sm" id="modalImage1" name="image1" accept="image/*">
                            <div id="currentImage1Preview" class="mt-2"></div>
                        </div>
                        <div class="col">
                            <label for="modalImage2" class="form-label form-label-sm">Image 2</label>
                            <input type="file" class="form-control form-control-sm" id="modalImage2" name="image2" accept="image/*">
                            <div id="currentImage2Preview" class="mt-2"></div>
                        </div>
                        <div class="col">
                            <label for="modalImage3" class="form-label form-label-sm">Image 3</label>
                            <input type="file" class="form-control form-control-sm" id="modalImage3" name="image3" accept="image/*">
                            <div id="currentImage3Preview" class="mt-2"></div>
                        </div>
                    </div>

                    
                    <!-- Descriptions Section -->
                    <hr>
                    <h6 class="h6 mb-3 text-uppercase text-secondary mt-4">Descriptions</h6>
                    <div class="row row-cols-md-2 g-2 mb-3">
                        <div class="col">
                            <label for="modalDesc1" class="form-label form-label-sm">Description 1 *</label>
                            <textarea class="form-control form-control-sm" id="modalDesc1" name="productDescription1" rows="3"></textarea>
                        </div>
                        <div class="col">
                            <label for="modalDesc2" class="form-label form-label-sm">Description 2</label>
                            <textarea class="form-control form-control-sm" id="modalDesc2" name="productDescription2" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <!-- Product Settings Section -->
                    <hr>
                    <h6 class="h6 mb-3 text-uppercase text-secondary mt-4">Product Setting Section</h6>
               
                      

                        <div class="col">
                        <div class="form-check pt-4">
                            <input class="form-check-input" type="checkbox" id="addTimer" name="addTimer" value="1">
                            <label class="form-check-label form-label-sm" for="addTimer">Enable Sale Timer</label>
                        </div>
                        <div class="form-group mt-3" id="timerDurationFields" style="display: none;">
                            <label for="timerDatetime" class="form-label form-label-sm">Sale End Date and Time</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="timerDatetime" name="timerDatetime">
                            <input type="hidden" id="timerDays" name="timerDays">
                            <input type="hidden" id="timerHours" name="timerHours">
                            <input type="hidden" id="timerMinutes" name="timerMinutes">
                            <input type="hidden" id="timerSeconds" name="timerSeconds">
                        </div>
                    </div>  

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary" id="saveModalChangesBtn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<!-- Custom CSS -->
<style>
    /* Your existing CSS styles remain the same */
    .form-control,
    .form-select,
    .btn {
        font-size: 0.8rem !important;
        padding: 0.3rem 0.6rem !important;
        border-radius: 0 !important;
    }

    .form-control, .form-select {
        border: 1px solid #dee2e6;
        box-shadow: none !important;
    }

    .form-label,
    .table th,
    .table td {
        font-size: 0.8rem !important;
        font-weight: 500;
        margin-bottom: 0.25rem !important;
    }

    .table th, .table td {
        padding: 0.5rem !important;
        border: none;
    }

    .table-borderless th,
    .table-borderless td {
        border: none !important;
    }

    .section-header {
        border-bottom: 1px solid #e0e6ed;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    .btn {
        font-size: 0.8rem !important;
        padding: 0.3rem 0.75rem !important;
        border-radius: 0 !important;
    }

    .btn-outline-primary {
        border: 1px solid #0d6efd;
        color: #0d6efd;
    }

    .modal-content {
        border-radius: 0;
        border: none;
    }
    .modal-dialog.modal-xl {
        max-width: calc(100% - 250px) !important;
        margin-left: 250px;
    }
    .modal-header, .modal-footer {
        border-color: #e0e6ed;
    }
    .modal-footer {
        padding-top: 1rem;
    }
    .size-stock-row{
        width: 490px;
    }
    .inventory-section{
        width: 100%;
    }
</style>


@endsection

<style>
    /* Custom CSS for Purchase Update Form */
        .form-control,
        .form-select,
        .btn {
            font-size: 0.8rem !important;
            padding: 0.3rem 0.6rem !important;
            border-radius: 0 !important;
        }

        .form-control, .form-select {
            border: 1px solid #dee2e6;
            box-shadow: none !important;
        }

        .form-label,
        .table th,
        .table td {
            font-size: 0.8rem !important;
            font-weight: 500;
            margin-bottom: 0.25rem !important;
        }

        .table th, .table td {
            padding: 0.5rem !important;
            border: none;
        }

        .table-borderless th,
        .table-borderless td {
            border: none !important;
        }

        .section-header {
            border-bottom: 1px solid #e0e6ed;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .btn {
            font-size: 0.8rem !important;
            padding: 0.3rem 0.75rem !important;
            border-radius: 0 !important;
        }

        .btn-outline-primary {
            border: 1px solid #0d6efd;
            color: #0d6efd;
        }

        .modal-content {
            border-radius: 0;
            border: none;
        }

        .modal-dialog.modal-xl {
            max-width: calc(100% - 250px) !important;
            margin-left: 250px;
        }

        .modal-header, .modal-footer {
            border-color: #e0e6ed;
        }

        .modal-footer {
            padding-top: 1rem;
        }

        .size-stock-row{
            width: 490px;
        }

        .inventory-section{
            width: 100%;
        }

        /* Variant table styling */
        #variantsTable th {
            background-color: #f8f9fa;
        }

        #variantsTable td {
            vertical-align: middle;
        }

        .variant-input {
            font-size: 0.75rem !important;
        }

        .remove-variant-btn {
            font-size: 0.7rem !important;
            padding: 0.15rem 0.4rem !important;
        }
</style>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- GLOBAL DATA (from Blade) ---
        let items = @json(
            $purchase->items->map(function($item) {
                $itemData = $item->toArray();

                if ($item->product) {
                    $product = $item->product;
                    $itemData['product_data'] = $product->toArray();

                    // safe category name
                    $category = \App\Models\Category::find($product->category);
                    $itemData['product_data']['category_name'] = $category ? $category->name : null;

                    // If backend sent tax_rate accidentally in this field, we will normalize in JS later.
                    $itemData['product_data']['tax_group_id'] = $product->tax_group_id ?? $product->tax_rate ?? null;
                    // keep tax_rate explicitly if available
                    $itemData['product_data']['tax_rate'] = $product->tax_rate ?? null;

                    // Variants
                    $variants = \App\Models\ProductVariant::where('product_id', $product->id)->get();
                    if ($product->product_type === 'variant' && $variants->count() > 0) {
                        $itemData['product_data']['variants'] = $variants->map(function($variant) {
                            return $variant->toArray();
                        })->toArray();
                        $itemData['product_data']['has_variants'] = true;
                    } else {
                        $itemData['product_data']['has_variants'] = false;
                        $itemData['product_data']['variants'] = [];
                    }
                }

                return $itemData;
            })
        );

        // Normalize in-memory items: ensure numeric fields are numbers or null (no empty strings)
        function normalizeItemsInMemory() {
            items = items.map(it => {
                const copy = JSON.parse(JSON.stringify(it || {}));

                // Convert some top-level fields
                ['quantity','unit_price','discount_percentage','total_incl_tax','lineTaxAmount','netPrice'].forEach(k => {
                    if (copy[k] === '' || copy[k] === undefined) copy[k] = null;
                    else if (typeof copy[k] === 'string' && copy[k] !== null) {
                        const n = Number(copy[k]);
                        copy[k] = isNaN(n) ? copy[k] : n;
                    }
                });

                // Normalize product_data
                if (!copy.product_data) copy.product_data = {};
                const pd = copy.product_data;
                ['tax_group_id','tax_rate','mrp','price','shipping_fee','weight','current_stock','discountPercentage','discountPrice'].forEach(k => {
                    if (pd[k] === '' || pd[k] === undefined) pd[k] = null;
                    else if (typeof pd[k] === 'string' && pd[k] !== null) {
                        const n = Number(pd[k]);
                        pd[k] = isNaN(n) ? pd[k] : n;
                    }
                });

                // Timer: empty => null
                if (!pd.timer_end_at) pd.timer_end_at = null;

                return copy;
            });
        }
        normalizeItemsInMemory();

        console.log('Loaded items (normalized):', items);

        let currentEditingIndex = -1;
        let variantIndex = 0;

        // --- HIDDEN FIELD FOR ITEMS DATA (safe JSON) ---
        function createHiddenItemsField() {
            const existingField = document.getElementById('itemsData');
            if (existingField) existingField.remove();

            // build a cleaned deep-copy of items to avoid sending empty strings
            const safeItems = items.map(it => {
                const copy = JSON.parse(JSON.stringify(it || {}));

                // top-level numeric fields -> number or null
                ['quantity','unit_price','discount_percentage','total_incl_tax','lineTaxAmount','netPrice'].forEach(k => {
                    if (copy[k] === '' || copy[k] === undefined) copy[k] = null;
                    else if (typeof copy[k] === 'string') {
                        const n = Number(copy[k]);
                        copy[k] = isNaN(n) ? copy[k] : n;
                    }
                });

                if (!copy.product_data) copy.product_data = {};
                const pd = copy.product_data;

                ['tax_group_id','tax_rate','mrp','price','shipping_fee','weight','current_stock','discountPercentage','discountPrice'].forEach(k => {
                    if (pd[k] === '' || pd[k] === undefined) pd[k] = null;
                    else if (typeof pd[k] === 'string') {
                        const n = Number(pd[k]);
                        pd[k] = isNaN(n) ? pd[k] : n;
                    }
                });

                if (!pd.timer_end_at) pd.timer_end_at = null;

                return copy;
            });

            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = 'items';
            hiddenField.id = 'itemsData';
            hiddenField.value = JSON.stringify(safeItems);

            document.getElementById('invoiceInventoryForm').appendChild(hiddenField);
            // for debugging you can uncomment:
            // console.log('Hidden field updated (safe items):', safeItems);
        }

        // --- Utility to read tax_rate from a select option (modalSellTaxGroup) ---
        function getTaxRateFromSellGroup() {
            const el = document.getElementById('modalSellTaxGroup');
            if (!el) return 0;
            const opt = el.options[el.selectedIndex];
            const rate = opt ? opt.getAttribute('data-rate') || opt.getAttribute('data-rate') : null;
            return rate ? parseFloat(rate) : 0;
        }

        // --- VARIANT MANAGEMENT (unchanged, kept for brevity) ---
        function addVariantRow(size = '', weight = '', price = '', discount_price = '', stock = '') {
            const tableBody = document.getElementById('variantsTableBody');
            if (!tableBody) return;

            const newRow = document.createElement('tr');
            newRow.dataset.index = variantIndex;
            newRow.innerHTML = `
                <td><input type="text" name="variants[${variantIndex}][size]" class="form-control form-control-sm variant-input variant-size" placeholder="e.g., 12,14/16" value="${escapeHtml(size)}"></td>
                <td><input type="number" step="0.01" name="variants[${variantIndex}][weight]" class="form-control form-control-sm variant-input variant-weight" placeholder="0.00" value="${escapeHtml(weight)}"></td>
                <td><input type="number" step="0.01" name="variants[${variantIndex}][price]" class="form-control form-control-sm variant-input variant-price" placeholder="0.00" value="${escapeHtml(price)}"></td>
                <td><input type="number" step="0.01" name="variants[${variantIndex}][discount_price]" class="form-control form-control-sm variant-input variant-discount-price" disabled placeholder="0.00" value="${escapeHtml(discount_price)}"></td>
                <td><input type="number" name="variants[${variantIndex}][stock]" class="form-control form-control-sm variant-input variant-stock" min="0" placeholder="0" value="${escapeHtml(stock)}"></td>
                <td><button type="button" class="btn btn-sm btn-outline-danger remove-variant-btn">X</button></td>
            `;

            tableBody.appendChild(newRow);

            // listeners
            const priceInput = newRow.querySelector('.variant-price');
            priceInput.addEventListener('input', function() {
                const price = parseFloat(this.value) || 0;
                const discountPercentage = parseFloat(document.getElementById('modalSellDiscount')?.value) || 0;
                const discountPrice = price - (price * discountPercentage / 100);
                newRow.querySelector('.variant-discount-price').value = discountPrice.toFixed(2);
            });

            newRow.querySelector('.variant-stock').addEventListener('input', calculateVariantTotals);
            newRow.querySelector('.remove-variant-btn').addEventListener('click', function(e) {
                e.target.closest('tr').remove();
                updateVariantIndexes();
                calculateVariantTotals();
            });

            variantIndex++;
            calculateVariantTotals();
        }

        function updateVariantIndexes() {
            const variantRows = document.querySelectorAll('#variantsTableBody tr');
            variantRows.forEach((row, index) => {
                row.dataset.index = index;
                row.querySelectorAll('.variant-input').forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        const newName = name.replace(/variants\[\d+\]/, `variants[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });
            });
            variantIndex = variantRows.length;
        }

        function calculateVariantTotals() {
            let totalVariantStock = 0;
            document.querySelectorAll('#variantsTableBody .variant-stock').forEach(input => {
                const stock = parseInt(input.value) || 0;
                totalVariantStock += stock;
            });

            const summary = document.getElementById('variantSummary');
            if (summary) summary.textContent = `Total Variant Stock: ${totalVariantStock} units`;

            const totalStockInput = document.getElementById('modalTotalStock');
            if (totalStockInput) totalStockInput.value = totalVariantStock;
        }

        function getVariantDataFromModal() {
            const variants = [];
            document.querySelectorAll('#variantsTableBody tr').forEach(row => {
                const size = row.querySelector('.variant-size')?.value || '';
                const weight = parseFloat(row.querySelector('.variant-weight')?.value) || 0;
                const price = parseFloat(row.querySelector('.variant-price')?.value) || 0;
                const discount_price = parseFloat(row.querySelector('.variant-discount-price')?.value) || 0;
                const stock = parseInt(row.querySelector('.variant-stock')?.value) || 0;

                if (size || weight > 0 || price > 0 || discount_price > 0 || stock > 0) {
                    variants.push({
                        size: size,
                        weight: weight,
                        price: price,
                        discount_price: discount_price,
                        stock: stock
                    });
                }
            });
            return variants;
        }

        function resetVariants() {
            const tableBody = document.getElementById('variantsTableBody');
            if (tableBody) tableBody.innerHTML = '';
            variantIndex = 0;
        }

        function populateVariantsInModal(variants) {
            const tableBody = document.getElementById('variantsTableBody');
            if (!tableBody) return;
            tableBody.innerHTML = '';
            variantIndex = 0;

            if (variants && variants.length > 0) {
                variants.forEach(variant => {
                    addVariantRow(
                        variant.size || '',
                        variant.weight || '',
                        variant.price || '',
                        variant.discount_price || '',
                        variant.stock || ''
                    );
                });
            }
            calculateVariantTotals();
        }

        // --- VARIANT AUTO-DETECTION ---
        function checkAndAutoEnableVariants(productId) {
            if (!productId) return false;
            const itemWithProduct = items.find(item => item.product_id == productId);
            if (itemWithProduct && itemWithProduct.product_data && itemWithProduct.product_data.product_type === 'variant') {
                const toggle = document.getElementById('toggleVariantsCheckbox');
                if (toggle) toggle.checked = true;
                toggleVariantsSection();

                if (itemWithProduct.product_data.variants && itemWithProduct.product_data.variants.length > 0) {
                    populateVariantsInModal(itemWithProduct.product_data.variants);
                }
                return true;
            }
            return false;
        }

        function toggleVariantsSection() {
            const variantsSection = document.getElementById('productVariantsSection');
            const basePriceSection = document.getElementById('basePrice');
            const sellPriceSection = document.getElementById('sellPrice');
            const weightFieldContainer = document.getElementById('weightFieldContainer');
            const toggleCheckbox = document.getElementById('toggleVariantsCheckbox');

            if (!toggleCheckbox) return;
            const isChecked = toggleCheckbox.checked;

            if (variantsSection) variantsSection.style.display = isChecked ? 'block' : 'none';
            if (basePriceSection) basePriceSection.style.display = isChecked ? 'none' : 'block';
            if (sellPriceSection) sellPriceSection.style.display = isChecked ? 'none' : 'block';
            if (weightFieldContainer) weightFieldContainer.style.display = isChecked ? 'none' : 'block';

            if (!isChecked) {
                resetVariants();
            }
        }

        document.getElementById('toggleVariantsCheckbox')?.addEventListener('change', toggleVariantsSection);
        document.getElementById('addVariantBtn')?.addEventListener('click', function() {
            addVariantRow();
        });

        // --- SELL PRICE CALCULATION ---
        const basePriceInput = document.getElementById("modalMRP");
        const discountInput = document.getElementById("modalSellDiscount");
        const sellPriceInput = document.getElementById("modalSellPrice");

        function calculateSellPrice() {
            const basePrice = parseFloat(basePriceInput?.value) || 0;
            const discount = parseFloat(discountInput?.value) || 0;

            if (basePrice > 0) {
                const discountAmount = (basePrice * discount) / 100;
                const sellPrice = basePrice - discountAmount;
                if (sellPriceInput) sellPriceInput.value = sellPrice.toFixed(2);

                document.querySelectorAll('#variantsTableBody .variant-price').forEach(input => {
                    const variantPrice = parseFloat(input.value) || 0;
                    const variantDiscountPrice = variantPrice - (variantPrice * discount / 100);
                    const row = input.closest('tr');
                    row.querySelector('.variant-discount-price').value = variantDiscountPrice.toFixed(2);
                });
            } else {
                if (sellPriceInput) sellPriceInput.value = "";
            }
        }

        if (basePriceInput && discountInput) {
            basePriceInput.addEventListener("input", calculateSellPrice);
            discountInput.addEventListener("input", calculateSellPrice);
        }

        // --- TIMER LOGIC (unchanged) ---
        const addTimerCheckbox = document.getElementById("addTimer");
        const timerDatetime = document.getElementById("timerDatetime");
        const timerFields = document.getElementById("timerDurationFields");

        if (addTimerCheckbox) {
            addTimerCheckbox.addEventListener("change", toggleTimerFields);
        }

        if (timerDatetime) {
            timerDatetime.addEventListener('change', function() {
                const endTime = new Date(this.value);
                const now = new Date();
                if (endTime > now) {
                    calculateTimerDuration(endTime);
                } else {
                    alert("Please select a future date and time.");
                    this.value = "";
                }
            });
        }

        function toggleTimerFields() {
            if (timerFields && addTimerCheckbox) {
                timerFields.style.display = addTimerCheckbox.checked ? 'block' : 'none';
            }
        }

        function calculateTimerDuration(endTime) {
            const now = new Date();
            const diff = endTime - now;
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            document.getElementById('timerDays').value = days;
            document.getElementById('timerHours').value = hours;
            document.getElementById('timerMinutes').value = minutes;
            document.getElementById('timerSeconds').value = seconds;
        }

        // --- VENDOR GSTIN auto-fill (unchanged) ---
        const vendorSelect = document.getElementById('vendorSelect');
        if (vendorSelect) {
            vendorSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const vendorGSTIN = document.getElementById('vendorGSTIN');
                if (vendorGSTIN) {
                    vendorGSTIN.value = selectedOption.getAttribute('data-gstin') || '';
                }
            });
        }

  
        // --- ITEM TOTALS CALCULATION (Fix: Only use modalTaxGroup for Purchase Tax) ---
        function calculateItemTotals() {
            const quantity = parseFloat(document.getElementById('modalQuantity')?.value) || 0;
            const unitPrice = parseFloat(document.getElementById('modalUnitPrice')?.value) || 0;
            const discountPercentage = parseFloat(document.getElementById('modalDiscount')?.value) || 0;
            const netPrice = unitPrice * (1 - (discountPercentage / 100));
            const netAmount = netPrice * quantity;
            const netPriceInput = document.getElementById('modalNetPrice');
            if (netPriceInput) netPriceInput.value = netPrice.toFixed(2);

            // ✅ FIX: Calculation MUST only use the PURCHASE Tax Group (modalTaxGroup)
            let totalTaxRate = 0;
            const taxGroupSelect = document.getElementById('modalTaxGroup'); // This is the Purchase Tax Group

            if (taxGroupSelect && taxGroupSelect.value) {
                const selectedOption = taxGroupSelect.options[taxGroupSelect.selectedIndex];
                // data-rates attribute से दरों को पढ़ें
                const taxRates = selectedOption ? selectedOption.getAttribute('data-rates') : null;
                
                // सभी दरों को जोड़कर कुल दर (rate) प्राप्त करें
                totalTaxRate = taxRates ? taxRates.split(',').reduce((sum, r) => sum + parseFloat(r), 0) : 0;
            }

            const taxAmount = (netAmount * totalTaxRate) / 100;
            const totalInclTax = netAmount + taxAmount;

            const taxAmountInput = document.getElementById('modalTaxAmount');
            const totalInclTaxInput = document.getElementById('modalTotalInclTax');
            if (taxAmountInput) taxAmountInput.value = taxAmount.toFixed(2);
            if (totalInclTaxInput) totalInclTaxInput.value = totalInclTax.toFixed(2);
        }

        document.querySelectorAll('.calculate-field').forEach(field => {
            field.addEventListener('input', calculateItemTotals);
        });

            // --- MODAL: open / populate ---
            function openModalForEdit(index) {
                currentEditingIndex = index;
                const item = items[index];
                if (!item) return;

                // *** IMPORTANT CHANGE: Removed document.getElementById('itemDetailsForm').reset(); ***
                // We must manually clear and set fields to preserve file input values.
                
                // Manual cleanup (optional, but good practice if form is not reset)
                document.getElementById('itemDetailsForm').querySelectorAll('input:not([type="hidden"]), select, textarea').forEach(el => {
                    if (el.type !== 'file' && el.type !== 'checkbox') {
                        el.value = '';
                    }
                });
                
                // Set fields
                safeSetValue('modalItemId', item.id || '');
                safeSetValue('modalProductId', item.product_id || '');
                safeSetValue('modalProductName', item.product_name || '');
                safeSetValue('modalItemCode', item.item_code || '');
                safeSetValue('modalQuantity', item.quantity ?? 1);
                safeSetValue('modalUnitPrice', item.unit_price ?? 0);
                safeSetValue('modalDiscount', item.discount_percentage ?? 0);

                safeSetValue('modalTaxGroup', item.tax_group_id ?? '');
                safeSetValue('modalSellTaxGroup', item.product_data?.tax_group_id ?? '');

                safeSetValue('modalSellName', item.product_data?.productName ?? '');
                safeSetValue('modalCategory', item.product_data?.category_name ?? '');
                safeSetValue('modalBrand', item.product_data?.brand ?? '');
                safeSetValue('modalBarcode', item.product_data?.barcode ?? '');
                safeSetValue('modalTotalStock', item.product_data?.current_stock ?? '');
                safeSetValue('modalHSN', item.product_data?.hsn_code ?? '');
                
                const isVariantProduct = item.product_data?.product_type === 'variant';
                safeSetValue('modalMRP', isVariantProduct ? '' : (item.product_data?.mrp ?? ''));
                safeSetValue('modalSellDiscount', item.product_data?.discountPercentage ?? 0);
                safeSetValue('modalSellPrice', isVariantProduct ? '' : (item.product_data?.discountPrice ?? ''));
                safeSetValue('modalShippingFee', item.product_data?.shipping_fee ?? '');
                safeSetValue('modalWeight', isVariantProduct ? '' : (item.product_data?.weight ?? ''));
                
                safeSetValue('modalDesc1', item.product_data?.productDescription1 ?? '');
                safeSetValue('modalDesc2', item.product_data?.productDescription2 ?? '');

                if (document.getElementById('availability')) {
                    document.getElementById('availability').value = item.product_data?.availability ? '1' : '0';
                }
                if (document.getElementById('on_sell')) {
                    document.getElementById('on_sell').value = item.product_data?.on_sell ? '1' : '0';
                }

                // **FIXED IMAGE PREVIEW LOGIC**
                const baseUrl = "{{ asset('storage/products') }}/";
                ['1','2','3'].forEach(num => {
                    const imgKey = `image${num}`;
                    const fileInput = document.getElementById(`modalImage${num}`);
                    const previewDiv = document.getElementById(`currentImage${num}Preview`);

                    if (previewDiv) {
                        previewDiv.innerHTML = ''; // Clear previous preview

                        // 1. Check if a NEW file is currently selected in the input (persists because we skipped form.reset())
                        if (fileInput && fileInput.files.length > 0) {
                            const url = URL.createObjectURL(fileInput.files[0]);
                            previewDiv.innerHTML = `
                                <img src="${url}" alt="New Image ${num}" class="img-thumbnail" width="80" height="80" style="object-fit: cover;">
                                <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeImage('${imgKey}', true)">Remove</button>
                            `;
                        } else {
                            // 2. Otherwise, check for a PREVIOUSLY SAVED path from the DB
                            const imagePath = item.product_data?.[imgKey];
                            
                            // Check if it's a valid saved path (not null/removed, not a temporary flag)
                            if (imagePath && typeof imagePath === 'string' && !imagePath.startsWith('item_images') && imagePath.includes('.')) {
                                const imgSrc = baseUrl + imagePath;
                                previewDiv.innerHTML = `
                                    <img src="${imgSrc}" alt="Saved Image ${num}" class="img-thumbnail" width="80" height="80" style="object-fit: cover;">
                                    <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeImage('${imgKey}')">Remove</button>
                                `;
                            } else if (removedImages[imgKey]) {
                                // 3. Image was marked for removal
                                previewDiv.innerHTML = `
                                    <span class="text-danger">Image marked for removal.</span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="restoreImage('${imgKey}')">Undo</button>
                                `;
                            }
                        }
                    }
                });
                // **END FIXED IMAGE PREVIEW LOGIC**


                // VARIANTS POPULATION LOGIC (as previously fixed)
                const toggle = document.getElementById('toggleVariantsCheckbox');
                const variants = item.product_data?.variants || [];
                const hasVariantsEnabled = item.product_data?.product_type === 'variant' || variants.length > 0;
                
                if (toggle) toggle.checked = hasVariantsEnabled;
                
                toggleVariantsSection(); 
                
                if (variants.length > 0) {
                    populateVariantsInModal(variants);
                } else {
                    resetVariants();
                }

                // Timer prefill (kept as is)
                if (item.product_data?.add_timer && item.product_data?.timer_end_at) {
                    const addTimerEl = document.getElementById('addTimer');
                    if (addTimerEl) addTimerEl.checked = true;
                    toggleTimerFields();

                    let dt = new Date(item.product_data.timer_end_at);
                    let local = new Date(dt.getTime() - dt.getTimezoneOffset() * 60000).toISOString().slice(0,16);
                    const timerInput = document.getElementById('timerDatetime');
                    if (timerInput) timerInput.value = local;
                    calculateTimerDuration(new Date(item.product_data.timer_end_at));
                } else {
                    const addTimerEl = document.getElementById('addTimer');
                    if (addTimerEl) addTimerEl.checked = false;
                    toggleTimerFields();
                    const timerInput = document.getElementById('timerDatetime');
                    if (timerInput) timerInput.value = '';
                }

                calculateItemTotals();
                calculateSellPrice();

                const modal = new bootstrap.Modal(document.getElementById('itemDetailsModal'));
                modal.show();
            }

    
    // --- Save changes (with type normalization and tax_rate capture) ---
            let removedImages = {};
            
            window.removeImage = function(imageKey, isNewFile = false) {
                removedImages[imageKey] = true;
                const fileInput = document.getElementById(`modalImage${imageKey.slice(-1)}`);
                const previewDiv = document.getElementById(`currentImage${imageKey.slice(-1)}Preview`);

                // Clear the file input in case a user selected a new file
                if (fileInput) fileInput.value = '';
                
                if (previewDiv) {
                    previewDiv.innerHTML = `
                        <span class="text-danger">Image marked for removal.</span>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="restoreImage('${imageKey}')">Undo</button>
                    `;
                }
            };

            window.restoreImage = function(imageKey) {
                delete removedImages[imageKey];
                
                const fileInput = document.getElementById(`modalImage${imageKey.slice(-1)}`);
                const previewDiv = document.getElementById(`currentImage${imageKey.slice(-1)}Preview`);
                
                if (!previewDiv) return;

                // Check if there is a file already selected in the input (from user not submitting yet)
                if (fileInput && fileInput.files.length > 0) {
                    // If the user had a NEW file selected, just restore the NEW file preview
                    const url = URL.createObjectURL(fileInput.files[0]);
                    previewDiv.innerHTML = `
                        <img src="${url}" alt="New Image" class="img-thumbnail" width="80" height="80" style="object-fit: cover;">
                        <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeImage('${imageKey}', true)">Remove</button>
                    `;
                } else {
                    // Otherwise, restore the PREVIOUSLY SAVED image preview from the in-memory item
                    const item = items[currentEditingIndex];
                    const imagePath = item?.product_data?.[imageKey];
                    const baseUrl = "{{ asset('storage/products') }}/";

                    if (imagePath && typeof imagePath === 'string' && !imagePath.startsWith('item_images') && imagePath.includes('.')) {
                        const imgSrc = baseUrl + imagePath;
                        previewDiv.innerHTML = `
                            <img src="${imgSrc}" alt="Saved Image" class="img-thumbnail" width="80" height="80" style="object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeImage('${imageKey}')">Remove</button>
                        `;
                    } else {
                        // No saved image, just clear the preview placeholder
                        previewDiv.innerHTML = '';
                    }
                }
            };

            // --- FILE INPUT PREVIEWS (Must be inside the script block) ---
            ['1','2','3'].forEach(num => {
                const fileInput = document.getElementById(`modalImage${num}`);
                const previewDiv = document.getElementById(`currentImage${num}Preview`);
                if (fileInput && previewDiv) {
                    fileInput.addEventListener('change', function(e) {
                        delete removedImages[`image${num}`]; // If a new file is selected, undo removal flag
                        previewDiv.innerHTML = '';
                        const file = this.files && this.files[0];
                        if (file) {
                            const url = URL.createObjectURL(file);
                            previewDiv.innerHTML = `
                                <img src="${url}" alt="Selected ${num}" class="img-thumbnail" width="80" height="80" style="object-fit: cover;">
                                <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeImage('image${num}', true)">Remove</button>
                            `;
                            const img = previewDiv.querySelector('img');
                            img.addEventListener('load', () => URL.revokeObjectURL(url));
                        }
                    });
            }
        });



        // --- Save changes (FIXED VERSION) ---
        function saveModalChanges() {
                        const formEl = document.getElementById('itemDetailsForm');
                if (!formEl) return;
                
                // Basic validation
                const productName = document.getElementById('modalProductName').value;
                const quantity = document.getElementById('modalQuantity').value;
                const unitPrice = document.getElementById('modalUnitPrice').value;
                
                if (!productName || !quantity || !unitPrice) {
                    alert('Please fill in all required fields: Product Name, Quantity, and Unit Price.');
                    return;
                }

                const useVariants = document.getElementById('toggleVariantsCheckbox').checked;
                const productSellGroupEl = document.getElementById('modalSellTaxGroup');
                const selectedSellGroupRate = getTaxRateFromSellGroup();

                // Create form data with proper type conversion
                const formData = {
                    id: document.getElementById('modalItemId').value || null,
                    product_id: document.getElementById('modalProductId').value || null,
                    product_name: document.getElementById('modalProductName').value || '',
                    item_code: document.getElementById('modalItemCode').value || '',
                    quantity: quantity !== '' ? parseFloat(quantity) : null,
                    unit_price: unitPrice !== '' ? parseFloat(unitPrice) : null,
                    discount_percentage: document.getElementById('modalDiscount').value !== '' ? parseFloat(document.getElementById('modalDiscount').value) : 0,
                    tax_group_id: document.getElementById('modalTaxGroup').value || null,

                    product_data: {
                        product_type: useVariants ? 'variant' : 'simple',
                        tax_group_id: productSellGroupEl && productSellGroupEl.value ? parseInt(productSellGroupEl.value) : null,
                        tax_rate: selectedSellGroupRate,
                        productName: document.getElementById('modalSellName').value || '',
                        category_name: document.getElementById('modalCategory').value || '',
                        brand: document.getElementById('modalBrand').value || '',
                        barcode: document.getElementById('modalBarcode').value || '',
                        current_stock: document.getElementById('modalTotalStock').value !== '' ? parseInt(document.getElementById('modalTotalStock').value) : null,
                        hsn_code: document.getElementById('modalHSN').value || '',
                        
                        mrp: useVariants ? null : (document.getElementById('modalMRP').value !== '' ? parseFloat(document.getElementById('modalMRP').value) : null),
                        discountPercentage: document.getElementById('modalSellDiscount').value !== '' ? parseFloat(document.getElementById('modalSellDiscount').value) : 0,
                        discountPrice: useVariants ? null : (document.getElementById('modalSellPrice').value !== '' ? parseFloat(document.getElementById('modalSellPrice').value) : null),
                        shipping_fee: document.getElementById('modalShippingFee').value !== '' ? parseFloat(document.getElementById('modalShippingFee').value) : 0,
                        weight: useVariants ? null : (document.getElementById('modalWeight').value !== '' ? parseFloat(document.getElementById('modalWeight').value) : null),
                        
                        productDescription1: document.getElementById('modalDesc1').value || '',
                        productDescription2: document.getElementById('modalDesc2').value || '',
                        availability: document.getElementById('availability') ? document.getElementById('availability').value : '0',
                        on_sell: document.getElementById('on_sell') ? document.getElementById('on_sell').value : '0',
                        add_timer: document.getElementById('addTimer').checked ? 1 : 0,
                        timer_end_at: document.getElementById('timerDatetime').value || null
                    }
                };
                
                formData.product_data.variants = getVariantDataFromModal();

                // Calculate totals
                const calcQuantity = parseFloat(formData.quantity) || 0;
                const calcUnitPrice = parseFloat(formData.unit_price) || 0;
                const calcDiscountPercentage = parseFloat(formData.discount_percentage) || 0;
                const netPrice = calcUnitPrice * (1 - (calcDiscountPercentage / 100));
                const netAmount = netPrice * calcQuantity;

                let purchaseTaxRate = 0;
                const taxGroupSelect = document.getElementById('modalTaxGroup');
                
                if (taxGroupSelect && taxGroupSelect.value) {
                    const selectedOption = taxGroupSelect.options[taxGroupSelect.selectedIndex];
                    const taxRates = selectedOption ? selectedOption.getAttribute('data-rates') : null;
                    purchaseTaxRate = taxRates ? taxRates.split(',').reduce((sum, rate) => sum + parseFloat(rate), 0) : 0;
                }

                const taxAmount = (netAmount * purchaseTaxRate) / 100;
                const totalInclTax = netAmount + taxAmount;

                formData.total_incl_tax = totalInclTax;
                formData.lineTaxAmount = taxAmount;
                formData.netPrice = netPrice;
                
                // **FIXED IMAGE HANDLING - Create file inputs for upload**
                const fileInputsContainer = document.getElementById('itemFileInputs');
                
                if (currentEditingIndex >= 0) {
                    const existingProductData = items[currentEditingIndex].product_data;
                    ['image1','image2','image3'].forEach(imgKey => {
                        const modalFileInput = document.getElementById(`modalImage${imgKey.slice(-1)}`);
                        const fileInputId = `item_${currentEditingIndex}_${imgKey}`;
                        
                        // Remove existing file input for this item/image
                        const existingInput = document.getElementById(fileInputId);
                        if (existingInput) {
                            existingInput.remove();
                        }
                        
                        // 1. If the user clicked the 'Remove' button
                        if (removedImages[imgKey]) {
                            formData.product_data[imgKey] = 'REMOVED'; // Special marker for removal
                        } 
                        // 2. If a new file is selected in modal
                        else if (modalFileInput.files.length > 0) {
                            // Create a new file input in the main form
                            const newFileInput = document.createElement('input');
                            newFileInput.type = 'file';
                            newFileInput.name = `item_files[${currentEditingIndex}][${imgKey}]`;
                            newFileInput.id = fileInputId;
                            newFileInput.style.display = 'none';
                            
                            // Create a DataTransfer to set the file
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(modalFileInput.files[0]);
                            newFileInput.files = dataTransfer.files;
                            
                            fileInputsContainer.appendChild(newFileInput);
                            formData.product_data[imgKey] = 'UPLOAD'; // Marker for new upload
                        } 
                        // 3. Otherwise, retain the existing path
                        else {
                            formData.product_data[imgKey] = existingProductData?.[imgKey] || null;
                        }
                    });
                } else {
                    // For a new item
                    const newIndex = items.length;
                    ['image1','image2','image3'].forEach(imgKey => {
                        const modalFileInput = document.getElementById(`modalImage${imgKey.slice(-1)}`);
                        const fileInputId = `item_${newIndex}_${imgKey}`;
                        
                        if (modalFileInput.files.length > 0) {
                            // Create a new file input in the main form
                            const newFileInput = document.createElement('input');
                            newFileInput.type = 'file';
                            newFileInput.name = `item_files[${newIndex}][${imgKey}]`;
                            newFileInput.id = fileInputId;
                            newFileInput.style.display = 'none';
                            
                            // Create a DataTransfer to set the file
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(modalFileInput.files[0]);
                            newFileInput.files = dataTransfer.files;
                            
                            fileInputsContainer.appendChild(newFileInput);
                            formData.product_data[imgKey] = 'UPLOAD';
                        } else {
                            formData.product_data[imgKey] = null;
                        }
                    });
    }
            
            // Clear the removal tracking array after processing
            removedImages = {};

            // Merge into items or add new
            if (currentEditingIndex >= 0) {
                items[currentEditingIndex] = {
                    ...items[currentEditingIndex],
                    ...formData,
                    product_data: {
                        ...items[currentEditingIndex].product_data,
                        ...formData.product_data
                    }
                };
            } else {
                items.push(formData);
            }

            updateItemsTable();
            createHiddenItemsField();

            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('itemDetailsModal'));
            if (modalInstance) modalInstance.hide();
        }

        // --- UPDATED HIDDEN FIELD CREATION ---
        function createHiddenItemsField() {
            const existingField = document.getElementById('itemsData');
            if (existingField) existingField.remove();

            // Convert items array to JSON string
            const safeItems = JSON.stringify(items);

            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = 'items'; // This will be a JSON string
            hiddenField.id = 'itemsData';
            hiddenField.value = safeItems;

            document.getElementById('invoiceInventoryForm').appendChild(hiddenField);
            console.log('Hidden field updated with JSON string');
        }

        // --- UPDATED FORM SUBMIT HANDLER ---
        document.getElementById('invoiceInventoryForm').addEventListener('submit', function(e) {
            // Ensure hidden field is created with JSON string
            createHiddenItemsField();

            if (items.length === 0) {
                e.preventDefault();
                alert('Please add at least one item before submitting.');
                return;
            }

            // Log for debugging
            console.log('Submitting form with items:', items);
            console.log('Items data type:', typeof document.getElementById('itemsData').value);
        });
        // --- UPDATE ITEMS TABLE ---
        function updateItemsTable() {
            const tableBody = document.getElementById('itemTableBody');
            if (!tableBody) return;

            tableBody.innerHTML = '';

            if (items.length === 0) {
                tableBody.innerHTML = '<tr class="placeholder-row"><td colspan="6" class="text-center py-5 text-muted">No items found. Click \"Add New Item\" to begin.</td></tr>';
                return;
            }

            let grandTotal = 0;

            items.forEach((item, index) => {
                const row = document.createElement('tr');
                row.dataset.index = index;

                // Use calculated total_incl_tax if available, otherwise calculate (no tax)
                let totalInclTax;
                if (item.total_incl_tax) {
                    totalInclTax = parseFloat(item.total_incl_tax);
                } else {
                    const quantity = parseFloat(item.quantity) || 0;
                    const unitPrice = parseFloat(item.unit_price) || 0;
                    const discountPercentage = parseFloat(item.discount_percentage) || 0;
                    const netAmount = (unitPrice * (1 - (discountPercentage / 100))) * quantity;
                    totalInclTax = netAmount;
                }

                grandTotal += totalInclTax;

                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${escapeHtml(item.product_name || 'N/A')}</td>
                    <td>${item.quantity || 0}</td>
                    <td>₹${parseFloat(item.unit_price || 0).toFixed(2)}</td>
                    <td>₹${totalInclTax.toFixed(2)}</td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-primary edit-item" data-index="${index}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-item" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;

                tableBody.appendChild(row);
            });

            const grandEl = document.getElementById('grandTotalDisplay');
            if (grandEl) grandEl.textContent = `₹${grandTotal.toFixed(2)}`;

            attachTableEventListeners();
        }

        function attachTableEventListeners() {
            document.querySelectorAll('.edit-item').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    openModalForEdit(index);
                });
            });

            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    if (confirm('Are you sure you want to remove this item?')) {
                        items.splice(index, 1);
                        updateItemsTable();
                        createHiddenItemsField();
                    }
                });
            });
        }

        // --- FORM SUBMIT HANDLER ---
        document.getElementById('invoiceInventoryForm').addEventListener('submit', function(e) {
            createHiddenItemsField();

            if (items.length === 0) {
                e.preventDefault();
                alert('Please add at least one item before submitting.');
                return;
            }

            // Final debug log (can remove in production)
            // console.log('Final items data sent to server:', document.getElementById('itemsData').value);
        });

        // --- UI Helpers ---
        function safeSetValue(id, value) {
            const el = document.getElementById(id);
            if (!el) return;
            if (el.tagName === 'INPUT' || el.tagName === 'SELECT' || el.tagName === 'TEXTAREA') {
                el.value = (value === null || value === undefined) ? '' : value;
            } else {
                el.textContent = value;
            }
        }

        function escapeHtml(str) {
            if (str === null || str === undefined) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        // --- FILE INPUT PREVIEWS (unchanged) ---
        ['1','2','3'].forEach(num => {
            const fileInput = document.getElementById(`modalImage${num}`);
            const previewDiv = document.getElementById(`currentImage${num}Preview`);
            if (fileInput && previewDiv) {
                fileInput.addEventListener('change', function(e) {
                    previewDiv.innerHTML = '';
                    const file = this.files && this.files[0];
                    if (file) {
                        const url = URL.createObjectURL(file);
                        previewDiv.innerHTML = `<img src="${url}" alt="Selected ${num}" class="img-thumbnail" width="80">`;
                        const img = previewDiv.querySelector('img');
                        img.addEventListener('load', () => URL.revokeObjectURL(url));
                    }
                });
            }
        });

        // --- EVENT LISTENERS ---
   
        document.getElementById('addItemBtn')?.addEventListener('click', function() {
            currentEditingIndex = -1;
            const form = document.getElementById('itemDetailsForm');
            if (form) {
                // Keep form.reset() here for NEW items only
                form.reset(); 
            }
            // Manually clear all image previews
            ['1','2','3'].forEach(num => {
                const previewDiv = document.getElementById(`currentImage${num}Preview`);
                if (previewDiv) previewDiv.innerHTML = '';
            });
            removedImages = {}; // Clear any pending removals
            
            const toggle = document.getElementById('toggleVariantsCheckbox');
            if (toggle) toggle.checked = false;
            toggleVariantsSection();
            resetVariants();
            calculateItemTotals();
            calculateSellPrice();

            const modal = new bootstrap.Modal(document.getElementById('itemDetailsModal'));
            modal.show();
        });

        document.getElementById('saveModalChangesBtn')?.addEventListener('click', saveModalChanges);

        // --- Initialize on load ---
        updateItemsTable();
        createHiddenItemsField();
        console.log('Script initialized successfully (normalized)');

    });
</script>


<script>
    function openEditModal(itemIndex) {
        let item = items[itemIndex];
        let product = item.product_data;

        // Fill basic fields
        document.querySelector('#product_name').value = product.name ?? '';
        document.querySelector('#unit_price').value = product.unit_price ?? '';
        if (document.querySelector('#category_select')) {
            document.querySelector('#category_select').value = product.category_id ?? '';
        }
        if (document.querySelector('#tax_group_select')) {
            document.querySelector('#tax_group_select').value = product.tax_group_id ?? '';
        }

        // 🔹 Handle variants
        const tableBody = document.getElementById('variantsTableBody');
        if (tableBody) {
            tableBody.innerHTML = ''; // clear old rows

            if (product.product_type === 'variant' && product.variants && product.variants.length > 0) {
                product.variants.forEach(variant => {
                    addVariantRow(
                        variant.size ?? '',
                        variant.weight ?? '',
                        variant.price ?? '',
                        variant.discount_price ?? '',
                        variant.stock ?? ''
                    );
                });
            }
        }

        // Recalculate discount prices on modal open
        applySellDiscountToVariants();

        // Show modal
        $('#purchaseModal').modal('show');
    }

    // 🔹 Apply discount % to all variant rows
    function applySellDiscountToVariants() {
        const discountField = document.getElementById('modalSellDiscount');
        if (!discountField) return;
        const discountPercentage = parseFloat(discountField.value) || 0;
        const rows = document.querySelectorAll('#variantsTableBody tr');

        rows.forEach(row => {
            const priceInput = row.querySelector('.variant-price');
            const discountInput = row.querySelector('.variant-discount-price');
            if (priceInput && discountInput) {
                const price = parseFloat(priceInput.value) || 0;
                const discountPrice = price - (price * discountPercentage / 100);
                discountInput.value = discountPrice.toFixed(2);
            }
        });
    }

    // 🔹 Recalculate whenever Sell Discount % changes
    document.addEventListener('DOMContentLoaded', function() {
        const discountField = document.getElementById('modalSellDiscount');
        if (discountField) {
            discountField.addEventListener('input', applySellDiscountToVariants);
            discountField.addEventListener('change', applySellDiscountToVariants);
        }
    });
</script>


