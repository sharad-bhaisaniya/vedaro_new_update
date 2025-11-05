@extends('layouts.admin_lay')

@section('content')
<!-- Add CSRF token meta tag -->
<meta name="csrf-token" content="{{ csrf_token() }}">

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

<div class="row justify-content-center p-4">
    <div class="col-12 col-xl-12">
        <h4 class="mb-3 text-secondary">Record New Purchase</h4>
        <form id="invoiceInventoryForm" action="{{ route('purchases.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
            @csrf
            <!-- Your form content remains the same -->
            <div class="p-3 mb-4 border-bottom">
                <h6 class="h6 mb-2 text-uppercase text-secondary">Vendor Details</h6>
                <div class="row row-cols-md-2 g-2">
                    <div class="col">
                        <label for="invoiceNumber" class="form-label form-label-sm">Invoice Number (bill number) *</label>
                        <input type="text" class="form-control form-control-sm" id="invoiceNumber" name="invoiceNumber" required>
                        <div class="invalid-feedback">Please provide an invoice number.</div>
                    </div>
                    <div class="col">
                        <label for="invoiceDate" class="form-label form-label-sm">Invoice Date *</label>
                        <input type="date" class="form-control form-control-sm" id="invoiceDate" name="invoiceDate" required>
                        <div class="invalid-feedback">Please select an invoice date.</div>
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
                                        data-address="{{ $vendor->address }}">
                                    {{ $vendor->display_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a vendor.</div>
                    </div>
                    <div class="col">
                        <label for="vendorGSTIN" class="form-label form-label-sm">Vendor GSTIN/UIN</label>
                        <input type="text" class="form-control form-control-sm bg-light" id="vendorGSTIN" name="vendorGSTIN" readonly>
                    </div>
                </div>
            </div>

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
                            <tr class="placeholder-row">
                                <td colspan="6" class="text-center py-5 text-muted">Click "Add New Item" to begin.</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="5" class="text-end">Grand Total (Incl. Tax):</td>
                                <td id="grandTotalDisplay" class="text-primary fs-5">₹0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="text-end pt-4 border-top">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-save me-1"></i>Save Purchase & Update Inventory
                </button>
            </div>
            <div id="messageBox" class="alert d-none mt-4 text-center" role="alert"></div>
        </form>
    </div>
</div>

<!-- Modal content remains the same -->
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
                                        <option value="{{ $product->name }}">{{ $product->name }}</option>
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
                        {{-- Brand Dropdown --}}
                        <div class="mb-3">
                            <label for="modalBrand" class="form-label">Select Brand</label>
                            <select id="modalBrand" class="form-select" required>
                                <option value="">-- Select Brand --</option>
                                @foreach(\App\Models\Brand::all() as $brand)
                                    <option value="{{ $brand->name }}">{{ $brand->name }}</option>
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
                         {{-- HSN Dropdown --}}
                        <div class="mb-3">
                            <label for="modalHSN" class="form-label">Select HSN</label>
                            <select id="modalHSN" class="form-select" required>
                                <option value="">-- Select HSN --</option>
                                @foreach(\App\Models\HsnCode::all() as $hsn)
                                    <option value="{{ $hsn->code }}">{{ $hsn->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col inventory-section">
                            
                    <hr>
                    <h6 class="h6 mb-3 text-uppercase text-secondary mt-4">Inventory Management</h6>
                    
                              <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="toggleVariantsCheckbox" name="useVariants" value="1">
                        <label class="form-check-label form-label-sm" for="toggleVariantsCheckbox">
                            Use Product Variants (Size,Weight, etc.)
                        </label>
                    </div>                                
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
                                                <th style="width: 15%;">Weight (grams)</th>
                                                <th style="width: 20%;">Price</th>
                                                <th style="width: 20%;">Discount Price</th>  <th style="width: 10%;">Stock Qty</th>
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
                        </div>                    
                        <div class="col" id="basePrice">
                            <label for="modalMRP" class="form-label form-label-sm">Base Price (per item)</label>
                            <input type="number" class="form-control form-control-sm" id="modalMRP" name="mrpPerUnit" step="0.01">
                        </div>
                        <div class="col" >
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
                            <label for="modalWeight" class="form-label form-label-sm">Weight (grams)</label>
                            <input type="number" class="form-control form-control-sm" id="modalWeight" name="weight">
                        </div>
                    </div>                 
                                
                  {{--  <div id="productVariantsSection" style="display: none;">
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
                                                <th style="width: 25%;">Size (e.g., Size)</th>
                                                <th style="width: 15%;">Weight (kg)</th>
                                                <th style="width: 20%;">Price</th>
                                                <th style="width: 20%;">Discount Price</th>  <th style="width: 10%;">Stock Qty</th>
                                                <th style="width: 10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="variantsTableBody">
                                            </tbody>
                                    </table>
                                </div>
                                </div>
                        </div>
                    </div> --}}
                    <hr>
                    <hr>
                    <h6 class="h6 mb-3 text-uppercase text-secondary mt-4">Product Images</h6>
                    <div class="row row-cols-md-3 g-2 mb-3">
                        <div class="col">
                            <label for="modalImage1" class="form-label form-label-sm">Image 1</label>
                            <input type="file" class="form-control form-control-sm" id="modalImage1" name="image1" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        </div>
                        <div class="col">
                            <label for="modalImage2" class="form-label form-label-sm">Image 2</label>
                            <input type="file" class="form-control form-control-sm" id="modalImage2" name="image2" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        </div>
                        <div class="col">
                            <label for="modalImage3" class="form-label form-label-sm">Image 3</label>
                            <input type="file" class="form-control form-control-sm" id="modalImage3" name="image3" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        </div>
                    </div>
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
                    <hr>
                    <h6 class="h6 mb-3 text-uppercase text-secondary mt-4">Product Setting Section</h6>
                    <div class="row row-cols-md-1 g-2 mb-3">
                    
                        {{--<div class="col">
                            <label for="on_sell" class="form-label form-label-sm">Product Status</label>
                            <select class="form-select form-select-sm" id="on_sell" name="on_sell">
                                <option value="1" selected>On Sale</option>
                                <option value="0">Not On Sale</option>
                            </select>
                        </div>
                        --}}
                        <div class="col">
                            <div class="form-check pt-4">
                                <input class="form-check-input" type="checkbox" id="addTimer" name="addTimer" value="1">
                                <label class="form-check-label form-label-sm" for="addTimer">Enable Sale Timer</label>
                            </div>
                            <div class="form-group mt-3" id="timerDurationFields" style="display: none;">
                                <label for="timerDatetime" class="form-label form-label-sm">Sale End Date and Time</label>
                                <input type="datetime-local" class="form-control form-control-sm" id="timerDatetime" name="timerDatetime" required>
                                <input type="hidden" id="timerDays" name="timerDays" required>
                                <input type="hidden" id="timerHours" name="timerHours" required>
                                <input type="hidden" id="timerMinutes" name="timerMinutes" required>
                                <input type="hidden" id="timerSeconds" name="timerSeconds" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" id="saveModalChangesBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

{{-- main script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- GLOBAL DATA ---
        let items = [];
        let currentEditingIndex = -1;
        let variantIndex = 0;

        // --- VARIANT MANAGEMENT FUNCTIONS ---
        function addVariantRow(size = '', weight = '', price = '', discount_price = '', stock = '') {
            const tableBody = document.getElementById('variantsTableBody');
            if (!tableBody) return;

            const newRow = document.createElement('tr');
            newRow.dataset.index = variantIndex;
            // Modified innerHTML to include the new Discount Price column
            newRow.innerHTML = `
                <td><input type="number" name="variants[${variantIndex}][size]" class="form-control form-control-sm variant-input variant-size" placeholder="e.g., 12,14/16" value="${size}"></td>
                <td><input type="number" step="0.01" name="variants[${variantIndex}][weight]" class="form-control form-control-sm variant-input variant-weight" placeholder="0.00" value="${weight}"></td>
                <td><input type="number" step="0.01" name="variants[${variantIndex}][price]" class="form-control form-control-sm variant-input variant-price" placeholder="0.00" value="${price}"></td>
                <td><input type="number" step="0.01" name="variants[${variantIndex}][discount_price]" class="form-control form-control-sm variant-input variant-discount-price"disabled placeholder="0.00" value="${discount_price}"></td>
                <td><input type="number" name="variants[${variantIndex}][stock]" class="form-control form-control-sm variant-input variant-stock" min="0" placeholder="0" value="${stock}"></td>
                <td><button type="button" class="btn btn-sm btn-outline-danger remove-variant-btn">X</button></td>
                <hr>
            `;

            tableBody.appendChild(newRow);

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
            if (summary) {
                summary.textContent = `Total Variant Stock: ${totalVariantStock} units`;
            }

            const totalStockInput = document.getElementById('modalTotalStock');
            if (totalStockInput) {
                totalStockInput.value = totalVariantStock;
            }
            
            calculateItemTotals();
        }

        function getVariantDataFromModal() {
            const variants = [];
            document.querySelectorAll('#variantsTableBody tr').forEach(row => {
                const size = row.querySelector('.variant-size')?.value || '';
                const weight = row.querySelector('.variant-weight')?.value || '';
                const price = parseFloat(row.querySelector('.variant-price')?.value) || 0;
                const discount_price = parseFloat(row.querySelector('.variant-discount-price')?.value) || 0; // NEW FIELD
                const stock = parseInt(row.querySelector('.variant-stock')?.value) || 0;

                if (size || weight || price > 0 || discount_price > 0 || stock > 0) {
                    variants.push({
                        size: size,
                        weight: weight,
                        price: price,
                        discount_price: discount_price, // Save new field
                        stock: stock
                    });
                }
            });
            return variants;
        }
        


        function resetVariants() {
            const tableBody = document.getElementById('variantsTableBody');
            if(tableBody) tableBody.innerHTML = '';
            variantIndex = 0;
            addVariantRow(); // Add one empty row by default
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
                        variant.discount_price || '', // Populate new field
                        variant.stock || ''
                    );
                });
            } else {
                addVariantRow(); // Add one empty row by default
            }
            calculateVariantTotals();
        }

        // --- Add Variant Button Event Listener ---
        document.getElementById('addVariantBtn')?.addEventListener('click', function() {
            addVariantRow(); // Add empty variant row
        });

        // --- Sell Price Calculation ---
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
            } else {
                if (sellPriceInput) sellPriceInput.value = "";
            }
        }

        if (basePriceInput && discountInput) {
            basePriceInput.addEventListener("input", calculateSellPrice);
            discountInput.addEventListener("input", calculateSellPrice);
        }

        // --- CORE APPLICATION LOGIC ---
        const addTimerCheckbox = document.getElementById("addTimer");
        const timerDatetime = document.getElementById("timerDatetime");
        const timerFields = document.getElementById("timerDurationFields");
        
        if (addTimerCheckbox) {
            addTimerCheckbox.addEventListener("change", toggleTimerFields);
        }
        
        if (timerDatetime) {
            timerDatetime.addEventListener("change", function() {
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

        function calculateItemTotals() {
            const quantity = parseFloat(document.getElementById('modalQuantity')?.value) || 0;
            const unitPrice = parseFloat(document.getElementById('modalUnitPrice')?.value) || 0;
            const discountPercentage = parseFloat(document.getElementById('modalDiscount')?.value) || 0;
            const netPrice = unitPrice * (1 - (discountPercentage / 100));
            const netAmount = netPrice * quantity;
            document.getElementById('modalNetPrice').value = netPrice.toFixed(2);

            let totalTaxRate = 0;
            const taxGroupSelect = document.getElementById('modalTaxGroup');
            if (taxGroupSelect && taxGroupSelect.value) {
                const selectedOption = taxGroupSelect.options[taxGroupSelect.selectedIndex];
                const taxRates = selectedOption.getAttribute('data-rates');
                totalTaxRate = taxRates ? taxRates.split(',').reduce((sum, rate) => sum + parseFloat(rate), 0) : 0;
            }

            const taxAmount = netAmount * (totalTaxRate / 100);
            document.getElementById('modalTaxAmount').value = taxAmount.toFixed(2);
            const totalInclTax = netAmount + taxAmount;
            document.getElementById('modalTotalInclTax').value = totalInclTax.toFixed(2);
        }

        const calculateFields = document.querySelectorAll('.calculate-field');
        calculateFields.forEach(field => {
            field.addEventListener('input', calculateItemTotals);
            field.addEventListener('change', calculateItemTotals);
        });
        
        document.getElementById('modalQuantity')?.addEventListener('input', calculateVariantTotals);

        // --- DATA EXTRACTION AND POPULATION ---
        function getItemDataFromModal() {
            const variants = getVariantDataFromModal();
            let finalStock = parseInt(document.getElementById('modalTotalStock')?.value) || 0;

            return {
                productName: document.getElementById('modalProductName')?.value || '',
                itemCode: document.getElementById('modalItemCode')?.value || '',
                quantity: parseFloat(document.getElementById('modalQuantity')?.value) || 1,
                unitPrice: parseFloat(document.getElementById('modalUnitPrice')?.value) || 0,
                discountPercentage: parseFloat(document.getElementById('modalDiscount')?.value) || 0,
                tax_group_id: document.getElementById('modalTaxGroup')?.value || '',
                netPrice: parseFloat(document.getElementById('modalNetPrice')?.value) || 0,
                taxAmount: parseFloat(document.getElementById('modalTaxAmount')?.value) || 0,
                totalInclTax: parseFloat(document.getElementById('modalTotalInclTax')?.value) || 0,
                sellName: document.getElementById('modalSellName')?.value || '',
                category: document.getElementById('modalCategory')?.value || '',
                brand: document.getElementById('modalBrand')?.value || '',
                barcode: document.getElementById('modalBarcode')?.value || '',
                stock: finalStock,
                hsnCode: document.getElementById('modalHSN')?.value || '',
                mrpPerUnit: parseFloat(document.getElementById('modalMRP')?.value) || 0,
                sellDiscountPercentage: parseFloat(document.getElementById('modalSellDiscount')?.value) || 0,
                sell_tax_group_id: document.getElementById('modalSellTaxGroup')?.value || '',
                sellPrice: parseFloat(document.getElementById('modalSellPrice')?.value) || 0,
                shippingFee: parseFloat(document.getElementById('modalShippingFee')?.value) || 0,
                weight: document.getElementById('modalWeight')?.value || '',
                variants: variants,
                productDescription1: document.getElementById('modalDesc1')?.value || '',
                productDescription2: document.getElementById('modalDesc2')?.value || '',
                availability: document.getElementById('availability')?.value || '1',
                on_sell: document.getElementById('on_sell')?.value || '1',
                addTimer: document.getElementById('addTimer')?.checked ? 1 : 0,
                timerDatetime: document.getElementById('timerDatetime')?.value || '',
                timerDays: document.getElementById('timerDays')?.value || 0,
                timerHours: document.getElementById('timerHours')?.value || 0,
                timerMinutes: document.getElementById('timerMinutes')?.value || 0,
                timerSeconds: document.getElementById('timerSeconds')?.value || 0,
                image1: document.getElementById('modalImage1')?.files[0] || null,
                image2: document.getElementById('modalImage2')?.files[0] || null,
                image3: document.getElementById('modalImage3')?.files[0] || null
            };
        }

        function populateModalWithItemData(itemData) {
            const fields = {
                'modalProductName': itemData.productName || '',
                'modalItemCode': itemData.itemCode || '',
                'modalQuantity': itemData.quantity || 1,
                'modalUnitPrice': itemData.unitPrice || 0,
                'modalDiscount': itemData.discountPercentage || 0,
                'modalTaxGroup': itemData.tax_group_id || '',
                'modalSellName': itemData.sellName || '',
                'modalCategory': itemData.category || '',
                'modalBrand': itemData.brand || '',
                'modalBarcode': itemData.barcode || '',
                'modalTotalStock': itemData.stock || 0,
                'modalHSN': itemData.hsnCode || '',
                'modalMRP': itemData.mrpPerUnit || 0,
                'modalSellDiscount': itemData.sellDiscountPercentage || '',
                'modalSellTaxGroup': itemData.sell_tax_group_id || '',
                'modalSellPrice': itemData.sellPrice || 0,
                'modalShippingFee': itemData.shippingFee || '',
                'weight': itemData.weight || '',
                'modalDesc1': itemData.productDescription1 || '',
                'modalDesc2': itemData.productDescription2 || '',
                'availability': itemData.availability || '1',
                'on_sell': itemData.on_sell || '1',
                'timerDatetime': itemData.timerDatetime || ''
            };

            Object.keys(fields).forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.value = fields[fieldId];
                }
            });

            ['modalImage1', 'modalImage2', 'modalImage3'].forEach(id => {
                const input = document.getElementById(id);
                if (input) input.value = '';
            });

            const addTimerCheckbox = document.getElementById('addTimer');
            if (addTimerCheckbox) {
                addTimerCheckbox.checked = itemData.addTimer == 1;
                toggleTimerFields();
            }

            populateVariantsInModal(itemData.variants);
            
            setTimeout(() => {
                calculateItemTotals();
                calculateSellPrice();
            }, 100);
        }

        function resetModalForm() {
            const form = document.getElementById('itemDetailsForm');
            if (form) {
                form.reset();
            }
            ['modalImage1', 'modalImage2', 'modalImage3'].forEach(id => {
                const input = document.getElementById(id);
                if (input) input.value = '';
            });
            
            resetVariants();
            toggleTimerFields();
            calculateItemTotals();
            calculateSellPrice();
        }

        function validateItemForm() {
            const requiredFields = ['modalProductName', 'modalQuantity', 'modalUnitPrice', 'modalTaxGroup', 'modalSellName', 'modalCategory', 'modalSellTaxGroup'];
            let isValid = true;
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field && !field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else if (field) {
                    field.classList.remove('is-invalid');
                }
            });
            return isValid;
        }

        // --- ITEM TABLE MANAGEMENT ---
        function addItemToTable(itemData, index) {
            const placeholderRow = document.querySelector('.placeholder-row');
            if (placeholderRow) {
                placeholderRow.remove();
            }
            const tbody = document.getElementById('itemTableBody');
            if (!tbody) return;
            const newRow = document.createElement('tr');
            newRow.dataset.index = index;
            newRow.innerHTML = `
                <td>${index + 1}</td>
                <td>${itemData.productName}</td>
                <td>${itemData.quantity}</td>
                <td>₹${itemData.unitPrice.toFixed(2)}</td>
                <td>₹${itemData.totalInclTax.toFixed(2)}</td>
                <td class="text-end">
                    <button type="button" class="btn btn-sm btn-outline-primary edit-item">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(newRow);
            
            newRow.querySelector('.edit-item').addEventListener('click', function() {
                currentEditingIndex = index;
                populateModalWithItemData(items[index]);
                new bootstrap.Modal(document.getElementById('itemDetailsModal')).show();
            });
            
            newRow.querySelector('.remove-item').addEventListener('click', function() {
                if (confirm('Are you sure you want to remove this item?')) {
                    items.splice(index, 1);
                    refreshTable();
                    updateGrandTotal();
                }
            });
        }
        
        function updateItemInTable(itemData, index) {
            const row = document.querySelector(`#itemTableBody tr[data-index="${index}"]`);
            if (row && row.cells) {
                row.cells[1].textContent = itemData.productName;
                row.cells[2].textContent = itemData.quantity;
                row.cells[3].textContent = `₹${itemData.unitPrice.toFixed(2)}`;
                row.cells[4].textContent = `₹${itemData.totalInclTax.toFixed(2)}`;
            }
        }
        
        function refreshTable() {
            const tbody = document.getElementById('itemTableBody');
            if (!tbody) return;
            tbody.innerHTML = '';
            if (items.length === 0) {
                tbody.innerHTML = `
                    <tr class="placeholder-row">
                        <td colspan="6" class="text-center py-5 text-muted">Click "Add New Item" to begin.</td>
                    </tr>
                `;
                return;
            }
            items.forEach((item, index) => {
                addItemToTable(item, index);
            });
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            items.forEach(item => {
                grandTotal += item.totalInclTax || 0;
            });
            const grandTotalDisplay = document.getElementById('grandTotalDisplay');
            if (grandTotalDisplay) {
                grandTotalDisplay.textContent = `₹${grandTotal.toFixed(2)}`;
            }
        }

        // --- FORM SUBMISSION HANDLING ---
        function prepareFormData() {
            const formData = new FormData(document.getElementById('invoiceInventoryForm'));
            
            // Add items array to formData
            items.forEach((item, index) => {
                // Add all item properties
                Object.keys(item).forEach(key => {
                    if (key !== 'image1' && key !== 'image2' && key !== 'image3') {
                        if (key === 'variants' && Array.isArray(item[key])) {
                            // Handle variants array
                            item[key].forEach((variant, variantIndex) => {
                                Object.keys(variant).forEach(variantKey => {
                                    formData.append(`items[${index}][variants][${variantIndex}][${variantKey}]`, variant[variantKey]);
                                });
                            });
                        } else {
                            formData.append(`items[${index}][${key}]`, item[key]);
                        }
                    }
                });
                
                // Add image files if they exist
                if (item.image1 instanceof File) {
                    formData.append(`items[${index}][image1]`, item.image1);
                }
                if (item.image2 instanceof File) {
                    formData.append(`items[${index}][image2]`, item.image2);
                }
                if (item.image3 instanceof File) {
                    formData.append(`items[${index}][image3]`, item.image3);
                }
            });

            return formData;
        }

        // --- MAIN BUTTON HANDLERS ---
        const addItemBtn = document.getElementById('addItemBtn');
        if (addItemBtn) {
            addItemBtn.addEventListener('click', function() {
                currentEditingIndex = -1;
                resetModalForm();
                new bootstrap.Modal(document.getElementById('itemDetailsModal')).show();
            });
        }

        const saveModalChangesBtn = document.getElementById('saveModalChangesBtn');
        if (saveModalChangesBtn) {
            saveModalChangesBtn.addEventListener('click', function() {
                if (validateItemForm()) {
                    const itemData = getItemDataFromModal();

                    if (currentEditingIndex === -1) {
                        items.push(itemData);
                        addItemToTable(itemData, items.length - 1);
                    } else {
                        items[currentEditingIndex] = itemData;
                        updateItemInTable(itemData, currentEditingIndex);
                    }
                    
                    updateGrandTotal();

                    const modal = bootstrap.Modal.getInstance(document.getElementById('itemDetailsModal'));
                    if (modal) {
                        modal.hide();
                    }
                }
            });
        }
        
        // Handle main form submission - FIXED VERSION
        document.getElementById('invoiceInventoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (items.length === 0) {
                alert('Please add at least one item before submitting.');
                return;
            }

            const formData = prepareFormData();
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saving...';
            submitBtn.disabled = true;

            // Get CSRF token safely
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                            document.querySelector('input[name="_token"]')?.value;

            if (!csrfToken) {
                alert('CSRF token not found. Please refresh the page and try again.');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                return;
            }

            // Debug: Log the form data
            console.log('Submitting form data:', formData);
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Response text:', text);
                        throw new Error('Network response was not ok: ' + response.status);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                if (data.success) {
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        alert('Purchase saved successfully!');
                        // Optionally reset the form
                        items = [];
                        refreshTable();
                        updateGrandTotal();
                        document.getElementById('invoiceInventoryForm').reset();
                    }
                } else {
                    alert('Error: ' + (data.message || 'Unknown error occurred'));
                    console.error('Validation errors:', data.errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the purchase: ' + error.message);
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        const itemDetailsModal = document.getElementById('itemDetailsModal');
        if (itemDetailsModal) {
            itemDetailsModal.addEventListener('show.bs.modal', function () {
                if (currentEditingIndex === -1) {
                    resetModalForm();
                } else {
                    calculateVariantTotals();
                }
            });
            
            itemDetailsModal.addEventListener('hidden.bs.modal', function () {
                // Reset validation styles when modal closes
                const invalidFields = document.querySelectorAll('.is-invalid');
                invalidFields.forEach(field => {
                    field.classList.remove('is-invalid');
                });
            });
        }

        // Initialize the variants table with one empty row
        function initializeVariantsTable() {
            resetVariants();
        }

        // Initial calls
        initializeVariantsTable();
        refreshTable();
        updateGrandTotal();
        calculateItemTotals();
        calculateVariantTotals();
        calculateSellPrice();
    });
</script>

{{-- toggle functionality on click Product Varient --}}
<script>
    // --- VARIANT SECTION TOGGLE LOGIC ---
    const toggleVariantsCheckbox = document.getElementById('toggleVariantsCheckbox');
    const productVariantsSection = document.getElementById('productVariantsSection');

    
    // --- WEIGHT FIELD TOGGLE LOGIC ---
    const toggleWeightCheckbox = document.getElementById('toggleWeightCheckbox');
    const weightFieldContainer = document.getElementById('weightFieldContainer');
    
    function toggleVariantsSection() {
        if (toggleVariantsCheckbox && productVariantsSection) {
            if (toggleVariantsCheckbox.checked) {
                productVariantsSection.style.display = 'block';
                 weightFieldContainer.style.display = 'none';
                  document.getElementById('modalWeight').required = false; 
                  document.getElementById('basePrice').style.display = 'none'; 
                  document.getElementById('sellPrice').style.display = 'none'; 
                  document.getElementById('modalMRP').required = false; 
                  document.getElementById('modalMRP').value = 0; 
                  document.getElementById('modalSellPrice').required = false; 
                  document.getElementById('modalSellPrice').value = 0; 
                // Clear the value if hidden
                document.getElementById('modalWeight').value = ''; 
            } else {
                productVariantsSection.style.display = 'none';
                 weightFieldContainer.style.display = 'block';
                 document.getElementById('basePrice').style.display = 'block'; 
                  document.getElementById('sellPrice').style.display = 'block'; 
                  document.getElementById('modalWeight').required = true; 
                   document.getElementById('modalMRP').required = true; 
                  document.getElementById('modalSellPrice').required = true; 
            }
        }
    }

    if (toggleVariantsCheckbox) {
        toggleVariantsCheckbox.addEventListener('change', toggleVariantsSection);
    }
    

 
    toggleVariantsSection(); 
</script>

{{-- implement discount on discount price  --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sellDiscountInput = document.getElementById('modalSellDiscount');

        // Listen for changes in the sell discount
        sellDiscountInput.addEventListener('input', function () {
            const discountPercent = parseFloat(this.value) || 0;

            // Loop through each variant row
            document.querySelectorAll('.variant-price').forEach(function (priceInput) {
                const discountPriceInput = priceInput.closest('tr').querySelector('.variant-discount-price');
                const price = parseFloat(priceInput.value) || 0;

                // Calculate discount price
                const discountPrice = price - (price * discountPercent / 100);

                // Update the discount price input
                discountPriceInput.value = discountPrice.toFixed(2);
            });
        });

        // Optional: if variant prices change, recalc discount
        document.querySelectorAll('.variant-price').forEach(function (priceInput) {
            priceInput.addEventListener('input', function () {
                const discountPercent = parseFloat(sellDiscountInput.value) || 0;
                const discountPriceInput = this.closest('tr').querySelector('.variant-discount-price');
                const price = parseFloat(this.value) || 0;
                const discountPrice = price - (price * discountPercent / 100);
                discountPriceInput.value = discountPrice.toFixed(2);
            });
        });
    });
</script>

{{-- variant stock mangement by quantity  --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const quantityInput = document.getElementById("modalQuantity");

        function enforceStockLimits() {
            const maxQuantity = parseInt(quantityInput.value) || 0;
            let totalAssigned = 0;

            document.querySelectorAll(".variant-stock").forEach(stockInput => {
                let stock = parseInt(stockInput.value) || 0;
                let remaining = maxQuantity - totalAssigned;

                // Cap the stock at the remaining available
                if (stock > remaining) {
                    stock = remaining;
                    stockInput.value = stock; // update input live
                }

                totalAssigned += stock;
            });
        }

        // 🔹 Enforce when quantity changes
        quantityInput.addEventListener("input", enforceStockLimits);

        // 🔹 Enforce live when typing in stock fields
        document.addEventListener("input", function (e) {
            if (e.target.classList.contains("variant-stock")) {
                enforceStockLimits();
            }
        });
    });
</script>



@endsection