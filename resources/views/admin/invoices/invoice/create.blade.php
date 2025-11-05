@extends('layouts.admin_lay')

@section('content')

<style>
    /* Global minimalist style */
    body {
        background-color: #f8f9fa;
    }
    .form-control, .form-select {
        font-size: 0.8rem !important;
        padding: 0.3rem 0.6rem !important;
        border: 1px solid #dee2e6;
        border-radius: 0 !important;
        box-shadow: none !important;
    }
    .form-label, .table th, .table td, .h6, .card-title {
        font-size: 0.8rem !important;
        font-weight: 500;
        margin-bottom: 0.25rem !important;
        text-transform: uppercase;
        letter-spacing: 0.05rem;
    }
    .table th, .table td {
        padding: 0.5rem !important;
    }
    .table thead th {
        border-bottom: 1px solid #dee2e6;
    }
    .table-sm th, .table-sm td {
        padding: 0.3rem !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
    }
    .card-body, .p-3 {
        padding: 0 !important;
    }
    .bg-light {
        background-color: #f1f3f5 !important;
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
    .border-bottom {
        border-bottom: 1px solid #dee2e6 !important;
        padding-bottom: 1rem !important;
        margin-bottom: 1rem !important;
    }
    .alert {
        font-size: 0.8rem !important;
    }
</style>

<div class="row justify-content-center p-4">
    <div class="col-12 col-xl-12">
        <h4 class="mb-3 text-secondary">New Invoice</h4>

        <!-- Display server-side errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Please correct the following issues:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf

            {{-- Customer & Invoice Details --}}
            <div class="p-3 mb-4 border-bottom">
                <h6 class="h6 mb-2 text-uppercase text-secondary">Invoice Details</h6>
                <div class="row row-cols-1 row-cols-md-2 g-3">
                    <div class="col">
                        <label for="customer_name" class="form-label form-label-sm fw-bold text-muted">Customer Name*</label>
                        <select name="customer_name" id="customer_name" class="form-control form-control-sm" required>
                            <option value="" disabled {{ old('customer_name') ? '' : 'selected' }}>Select or type a customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ is_object($customer) ? $customer->name : $customer }}"
                                    {{ old('customer_name') == (is_object($customer) ? $customer->name : $customer) ? 'selected' : '' }}>
                                    {{ is_object($customer) ? $customer->name : $customer }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select or add a customer.
                        </div>
                    </div>
                     <div class="col">
                        <label for="order_number" class="form-label form-label-sm fw-bold text-muted">Order Number*</label>
                        <input type="number" name="order_number" id="order_number" class="form-control form-control-sm" value="{{ old('order_number') }}" placeholder="Enter customer phone number">
                        <div class="invalid-feedback">
                            Please enter a phone number.
                        </div>
                    </div>
                    <div class="col">
                        <label for="invoice_date" class="form-label form-label-sm fw-bold text-muted">Invoice Date*</label>
                        <input type="date" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" class="form-control form-control-sm" required>
                        <div class="invalid-feedback">
                            Please select an invoice date.
                        </div>
                    </div>
                    <div class="col">
                        <label for="paid_amount" class="form-label form-label-sm fw-bold text-muted">Paid Amount (₹)*</label>
                        <input type="number" name="paid_amount" id="paid_amount" step="0.01" min="0" value="{{ old('paid_amount', 0) }}" class="form-control form-control-sm" required>
                        <div class="invalid-feedback">
                            Please enter a valid paid amount.
                        </div>
                    </div>
                    <div class="col">
                        <label for="customer_email" class="form-label form-label-sm fw-bold text-muted">Customer Email</label>
                        <input type="email" name="customer_email" id="customer_email" class="form-control form-control-sm" value="{{ old('customer_email') }}" placeholder="Enter customer email">
                        <div class="invalid-feedback">
                            Please enter a valid email address.
                        </div>
                    </div>
                    <div class="col">
                        <label for="customer_phone" class="form-label form-label-sm fw-bold text-muted">Customer Phone</label>
                        <input type="tel" name="customer_phone" id="customer_phone" class="form-control form-control-sm" value="{{ old('customer_phone') }}" placeholder="Enter customer phone number">
                        <div class="invalid-feedback">
                            Please enter a phone number.
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col">
                                <label for="customer_address" class="form-label form-label-sm fw-bold text-muted">Customer Address</label>
                                <textarea name="customer_address" id="customer_address" rows="2" class="form-control form-control-sm" placeholder="Enter street and locality">{{ old('customer_address') }}</textarea>
                            </div>
                            <div class="col">
                                <div class="mb-2">
                                    <label for="customer_gstin" class="form-label form-label-sm fw-bold text-muted">Customer GSTIN</label>
                                    <input type="text" name="customer_gstin" id="customer_gstin" class="form-control form-control-sm" value="{{ old('customer_gstin') }}" placeholder="Enter customer GSTIN">
                                </div>
                                <div class="row row-cols-md-2 g-2">
                                    <div class="col">
                                        <label for="city" class="form-label form-label-sm fw-bold text-muted">City</label>
                                        <input type="text" name="city" id="city" class="form-control form-control-sm" value="{{ old('city') }}" placeholder="City">
                                    </div>
                                    <div class="col">
                                        <label for="pincode" class="form-label form-label-sm fw-bold text-muted">Pincode</label>
                                        <input type="text" name="pincode" id="pincode" class="form-control form-control-sm" value="{{ old('pincode') }}" placeholder="Pincode">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label for="invoice_number" class="form-label form-label-sm fw-bold text-muted">Invoice#*</label>
                        <input type="text" id="invoice_number" value="{{ $nextNumber }}" name="invoice_number" class="form-control form-control-sm" readonly>
                    </div>
                </div>
            </div>
            <div class="p-3 mb-4 border-bottom">
    <h6 class="h6 mb-2 text-uppercase text-secondary">Barcode Scanner</h6>
    <div class="row">
        <div class="col-md-6">
            <label for="barcode" class="form-label form-label-sm fw-bold text-muted">Scan Barcode</label>
            <input type="text" name="barcode" id="barcode" class="form-control form-control-sm" 
                   placeholder="Scan or enter barcode" autocomplete="off">
                   <!-- Add this after the barcode scanner section -->
<input type="hidden" name="scanned_barcodes" id="scanned_barcodes" value="">
            <div class="form-text">Enter barcode to automatically add products</div>
        </div>
    </div>
</div>



            <hr>

            {{-- Item Details Table --}}
            <div class="p-3 mb-4 border-bottom">
                <h6 class="h6 mb-2 text-uppercase text-secondary">Item Details</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-hover align-middle mb-0" id="items-table">
                        <thead class="fw-normal">
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Size</th>
                                <th scope="col">Category</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Discount (%)</th>
                                <th scope="col">Tax Group</th>
                                <th scope="col">HSN</th>
                                <th scope="col">Rate (₹)</th>
                                <th scope="col">CGST (₹)</th>
                                <th scope="col">SGST (₹)</th>
                                <th scope="col">Amount (₹)</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <button type="button" id="add-row" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-plus-circle me-1"></i>Add New Row
                    </button>
                </div>
            </div>

            {{-- Summary Totals --}}
            <div class="bg-light p-3 mb-4 rounded-3">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Sub Total</span>
                            <span id="subtotal" class="fw-bold small">₹0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Total Discount</span>
                            <span id="total-discount" class="fw-bold small text-success">₹0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Total CGST</span>
                            <span id="total-cgst" class="fw-bold small">₹0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Total SGST</span>
                            <span id="total-sgst" class="fw-bold small">₹0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Grand Total</span>
                            <span id="grand-total" class="fw-bold small">₹0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="d-flex justify-content-end pt-3">
                <button type="button" class="btn btn-sm btn-outline-secondary me-2">
                    Cancel
                </button>
                <button type="submit" name="action" value="send" class="btn btn-sm btn-primary">
                    Save and Send
                </button>
            </div>
        </form>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowCount = document.querySelectorAll('#items-table tbody tr').length;
        let scannedBarcodes = [];
        const taxGroups = @json($tax_groups->keyBy('id'));

        console.log('✅ Invoice Script Initialized');
        console.log('📊 Tax Groups loaded:', Object.keys(taxGroups).length);

        // Initialize Select2 for customer dropdown
        $('#customer_name').select2({
            tags: true,
            placeholder: "Select or type a customer",
            allowClear: true,
        });

        /**
         * Generic Select2 initializer for every .item-select
         */
        function initItemSelect2() {
            $('.item-select').select2({
                width: '100%',
                minimumResultsForSearch: 10
            });
        }

    
        /**
         * Bind change event for .item-select dropdown in every row - FIXED TAX GROUP SELECTION
         */
                function bindItemSelectChange() {
                    $('#items-table').off('change', '.item-select').on('change', '.item-select', function() {
                        const row = $(this).closest('tr');
                        const selectedOption = $(this).find('option:selected');
                        const productId = selectedOption.val();

                        console.log('🔄 Product selected:', {
                            productId: productId,
                            productName: selectedOption.text(),
                            productType: selectedOption.data('product-type'),
                            taxGroup: selectedOption.data('tax-group')
                        });

                        if (selectedOption.length && productId !== '') {
                            const categoryName = selectedOption.data('category-name') || 'No Category';
                            const hsn = selectedOption.data('hsn') || '';
                            const rate = selectedOption.data('rate') || '0';
                            const discountPercentage = selectedOption.data('discount') || '0';
                            const taxGroupId = selectedOption.data('tax-group') || '';
                            const productType = selectedOption.data('product-type') || 'simple';

                            row.find('.category-field').val(categoryName);
                            row.find('.hsn-field').val(hsn);
                            row.find('.rate').val(parseFloat(rate).toFixed(2));
                            row.find('.discount').val(parseFloat(discountPercentage).toFixed(2));

                            // Set tax group if available - FIXED
                            if (taxGroupId) {
                                console.log('🏷️ Setting tax group:', taxGroupId);
                                const taxSelect = row.find('.tax-group-select');
                                
                                // Convert to number and find matching option
                                const taxValue = Number(taxGroupId);
                                const taxOption = taxSelect.find(`option[value="${taxValue}"]`);
                                
                                if (taxOption.length > 0) {
                                    taxSelect.val(taxValue).trigger('change');
                                    console.log('✅ Tax group set successfully:', taxValue);
                                } else {
                                    console.log('❌ Tax group not found in dropdown:', taxValue);
                                    console.log('Available tax groups:', taxSelect.find('option').map(function() {
                                        return { value: $(this).val(), text: $(this).text() };
                                    }).get());
                                }
                            } else {
                                console.log('⚠️ No tax group data found for product');
                            }

                            // Handle product type for size dropdown
                            if (productType === 'variant') {
                                console.log('🔧 Variant product detected, loading variants...');
                                fetchProductVariants(productId, row);
                            } else {
                                // Simple product - hide size dropdown, show placeholder
                                console.log('🔧 Simple product detected');
                                row.find('.size-select').hide();
                                row.find('.size-placeholder').show().text('-');
                                // Set the rate for simple product
                                row.find('.rate').val(parseFloat(rate).toFixed(2));
                            }
                        } else {
                            row.find('.category-field').val('');
                            row.find('.hsn-field').val('');
                            row.find('.rate').val('');
                            row.find('.discount').val('0');
                            // Reset size dropdown
                            row.find('.size-select').hide();
                            row.find('.size-placeholder').show().text('-');
                        }
                        calculateRowAmount(row[0]);
                        calculateTotals();
                    });
                }

    
        
        /**
         * Fetch product variants and populate size dropdown - FIXED FOR YOUR API RESPONSE
         */
        function fetchProductVariants(productId, row) {
            console.log('🔄 Fetching variants for product:', productId);
            
            // Show loading state
            const sizeSelect = row.find('.size-select');
            const sizePlaceholder = row.find('.size-placeholder');
            
            sizeSelect.show().empty().append('<option value="">Loading sizes...</option>');
            sizePlaceholder.hide();

            fetch(`/admin/products/${productId}/variants`)
                .then(response => {
                    console.log('📡 API Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('📦 Full API response:', data);
                    console.log('📊 Variants array:', data.variants);
                    console.log('📊 Variants count:', data.variants ? data.variants.length : 0);
                    
                    // FIX: Check for 'variants' array instead of 'data'
                    if (data.variants && data.variants.length > 0) {
                        // Product has variants
                        console.log('📦 Found variants:', data.variants.length);
                        
                        let sizeOptions = '<option value="">Select Size</option>';
                        
                        data.variants.forEach(variant => {
                            console.log('📋 Processing variant:', variant);
                            const price = variant.discount_price || variant.price;
                            sizeOptions += `<option value="${variant.size}" data-price="${price}">
                                ${variant.size} - ₹${price}
                            </option>`;
                        });
                        
                        sizeSelect.html(sizeOptions);
                        
                        // Auto-select first variant if only one exists
                        if (data.variants.length === 1) {
                            const firstVariant = data.variants[0];
                            const firstPrice = firstVariant.discount_price || firstVariant.price;
                            console.log('⚡ Auto-selecting single variant:', firstVariant.size);
                            sizeSelect.val(firstVariant.size).trigger('change');
                            row.find('.rate').val(firstPrice);
                        } else if (data.variants.length > 1) {
                            // For multiple variants, set rate to first variant's price by default
                            const firstVariant = data.variants[0];
                            const firstPrice = firstVariant.discount_price || firstVariant.price;
                            row.find('.rate').val(firstPrice);
                        }
                    } else {
                        // Product has no variants
                        console.log('❌ No variants found in response');
                        console.log('🔍 Response details:', {
                            hasVariants: !!data.variants,
                            variantsLength: data.variants ? data.variants.length : 0
                        });
                        sizeSelect.hide();
                        sizePlaceholder.show().text('-');
                    }
                })
                .catch(error => {
                    console.error('❌ Error fetching variants:', error);
                    sizeSelect.hide();
                    sizePlaceholder.show().text('-');
                });
        }

        /**
         * Bind change for size dropdown
         */
        function bindSizeSelectChange() {
            $('#items-table').off('change', '.size-select').on('change', '.size-select', function() {
                const row = $(this).closest('tr');
                const selectedOption = $(this).find('option:selected');
                
                if (selectedOption.length && selectedOption.val() !== '') {
                    const price = selectedOption.data('price') || '0';
                    console.log('📏 Size selected:', selectedOption.val(), 'Price:', price);
                    row.find('.rate').val(parseFloat(price).toFixed(2));
                } else {
                    // If no size selected, use the base product price
                    const basePrice = row.find('.item-select option:selected').data('rate') || '0';
                    row.find('.rate').val(parseFloat(basePrice).toFixed(2));
                }
                
                calculateRowAmount(row[0]);
                calculateTotals();
            });
        }

        /**
         * Bind change for .tax-group-select in every row
         */
        function bindTaxGroupChange() {
            $('#items-table').off('change', '.tax-group-select').on('change', '.tax-group-select', function() {
                calculateRowAmount($(this).closest('tr')[0]);
                calculateTotals();
            });
        }

        /**
         * Input event for quantity/rate/discount fields
         */
        function bindQtyRateDiscountInput() {
            $('#items-table').off('input', '.quantity, .rate, .discount').on('input', '.quantity, .rate, .discount', function() {
                calculateRowAmount($(this).closest('tr')[0]);
                calculateTotals();
            });
        }

        /**
         * Remove row event
         */
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                const row = e.target.closest('tr');
                const itemSelect = row.querySelector('.item-select');
                
                // If this row was added via barcode, remove it from scanned barcodes
                if (itemSelect && itemSelect.dataset.barcode) {
                    const barcode = itemSelect.dataset.barcode;
                    scannedBarcodes = scannedBarcodes.filter(b => b !== barcode);
                    document.getElementById('scanned_barcodes').value = scannedBarcodes.join(',');
                }
                
                if (document.querySelectorAll('#items-table tbody tr').length > 1) {
                    row.remove();
                    calculateTotals();
                } else {
                    alert('You must have at least one item in the invoice.');
                }
            }
        });

        /**
         * Add new row logic - UPDATED WITH PROPER SIZE HANDLING
         */
        document.getElementById('add-row').addEventListener('click', function() {
            const tbody = document.querySelector('#items-table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <select name="items[${rowCount}][item_id]" class="form-select form-select-sm item-select" required>
                        <option value="" selected disabled>Select item</option>
                        @foreach($items as $item)
                            <option
                                value="{{ $item->id }}"
                                {{ $categories = App\Models\Category::find($item->category) }}
                                data-category-name="{{ $categories->name }}"
                                data-hsn="{{ $item->hsn_code ?? '' }}"
                                data-rate="{{ $item->discountPrice ?? $item->price ?? '0' }}"
                                data-discount="{{ $item->discountPercentage ?? '0' }}"
                                data-tax-group="{{ $item->tax_rate ?? '' }}"
                                data-product-type="{{ $item->product_type ?? 'simple' }}">
                                {{ $item->productName }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select an item.</div>
                </td>
                <td>
                    <select name="items[${rowCount}][size]" class="form-select form-select-sm size-select" style="display: none;">
                        <option value="">-</option>
                    </select>
                    <span class="size-placeholder">-</span>
                </td>
                <td>
                    <input type="text" name="items[${rowCount}][category]" class="form-control form-control-sm category-field" readonly>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][quantity]" value="1" min="1" class="form-control form-control-sm quantity" required>
                    <div class="invalid-feedback">Please enter a valid quantity.</div>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][discount]" step="0.01" value="0" min="0" max="100" class="form-control form-control-sm discount">
                </td>
                <td>
                    <select class="form-select form-select-sm tax-group-select" name="items[${rowCount}][tax_group_id]" required>
                        <option value="" disabled selected>-- Select Tax Group --</option>
                        @foreach ($tax_groups as $group)
                            @if ($group->taxes->isNotEmpty())
                                <option value="{{ $group->id }}" data-rates="{{ $group->taxes->pluck('rate')->implode(',') }}">
                                    {{ $group->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a tax group.</div>
                </td>
                <td>
                    <input type="text" name="items[${rowCount}][hsn]" class="form-control form-control-sm hsn-field">
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][rate]" step="0.01" class="form-control form-control-sm rate" required>
                    <div class="invalid-feedback">Please enter a valid rate.</div>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][cgst]" step="0.01" class="form-control form-control-sm cgst-field" readonly>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][sgst]" step="0.01" class="form-control form-control-sm sgst-field" readonly>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][amount]" class="form-control form-control-sm bg-light amount-field" readonly>
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-row">Remove</button>
                </td>
            `;
            tbody.appendChild(newRow);
            
            // Initialize Select2 for new row
            initItemSelect2();
            
            // Attach event handlers to the new row
            attachEventHandlersToRow(newRow);
            
            rowCount++;
            calculateTotals();
            
            console.log('✅ New row added, total rows:', rowCount);
        });

        
            /**
         * Attach event handlers to a specific row - FIXED SYNTAX ERROR
         */
        function attachEventHandlersToRow(row) {
            const $row = $(row);
            
            // Product selection handler
            $row.find('.item-select').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const productId = selectedOption.val();
                const productType = selectedOption.data('product-type') || 'simple';

                console.log('🔄 Manual product selection in new row:', {
                    productId: productId,
                    productType: productType
                });

                if (productType === 'variant') {
                    console.log('🔧 Variant product detected in new row, loading variants...');
                    fetchProductVariants(productId, $row);
                } else {
                    // Simple product
                    console.log('🔧 Simple product detected in new row');
                    $row.find('.size-select').hide();
                    $row.find('.size-placeholder').show().text('-');
                    
                    // Set the rate for simple product
                    const rate = selectedOption.data('rate') || '0';
                    $row.find('.rate').val(parseFloat(rate).toFixed(2));
                    
                    calculateRowAmount(row);
                    calculateTotals();
                }
            });

            // Size selection handler
            $row.find('.size-select').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                if (selectedOption.length && selectedOption.val() !== '') {
                    const price = selectedOption.data('price') || '0';
                    console.log('📏 Size selected in new row:', selectedOption.val(), 'Price:', price);
                    $row.find('.rate').val(parseFloat(price).toFixed(2));
                }
                calculateRowAmount(row);
                calculateTotals();
            });

            // Other input handlers
            $row.find('.quantity, .rate, .discount').on('input', function() {
                calculateRowAmount(row);
                calculateTotals();
            });

            $row.find('.tax-group-select').on('change', function() {
                calculateRowAmount(row);
                calculateTotals();
            });
        }

        // Barcode scanner functionality - UPDATED: NO MODAL, DIRECT SIZE DROPDOWN
        const barcodeInput = document.querySelector('input[name="barcode"]');
        let barcodeTimeout;

        barcodeInput.addEventListener('input', function(e) {
            clearTimeout(barcodeTimeout);

            barcodeTimeout = setTimeout(() => {
                const barcode = e.target.value.trim();
                if (barcode.length > 0) {
                    console.log('🔍 Barcode scanned:', barcode);
                    processBarcode(barcode);
                }
            }, 500);
        });

    
    async function processBarcode(barcode) {
        try {
            console.log('🔍 Starting barcode processing for:', barcode);
            
            // Check if barcode was already scanned
            if (scannedBarcodes.includes(barcode)) {
                alert('This barcode has already been scanned');
                barcodeInput.value = '';
                return;
            }

            const response = await fetch(`/admin/products/by-barcode/${barcode}`);
            console.log('📡 Barcode API Response status:', response.status);
            
            const result = await response.json();
            console.log('📦 Barcode API Full response:', result);
            
            // FIX: Check different possible response structures
            if (result.success || result.product) {
                // Add to scanned barcodes array
                scannedBarcodes.push(barcode);
                document.getElementById('scanned_barcodes').value = scannedBarcodes.join(',');
                
                console.log('✅ Product found via barcode:', {
                    productName: result.product?.productName,
                    productType: result.product?.product_type,
                    isVariant: result.is_variant,
                    variantsCount: result.product_variants?.length
                });
                
                // Handle different response structures
                const product = result.product || result;
                const isVariant = result.is_variant || (product.product_type === 'variant');
                const variants = result.product_variants || result.variants;
                
                // REMOVED MODAL: Directly add product with size dropdown for variants
                if (isVariant && variants && variants.length > 0) {
                    console.log('🔧 Variant product via barcode, adding with size dropdown');
                    addProductToInvoice(product, null, barcode, variants);
                } else {
                    // Simple product - add directly
                    console.log('🔧 Simple product via barcode');
                    addProductToInvoice(product, null, barcode);
                }
                barcodeInput.value = '';
            } else {
                console.log('❌ Product not found in barcode response');
                alert('Product not found for this barcode');
            }
        } catch (error) {
            console.error('❌ Error in barcode processing:', error);
            console.error('Error details:', {
                name: error.name,
                message: error.message,
                stack: error.stack
            });
            alert('Error processing barcode: ' + error.message);
        }
        }

        function addProductToInvoice(product, variant = null, barcode = null, variantsData = null) {
            const existingRow = findProductRow(product.id, variant ? variant.id : null);

            if (existingRow) {
                // If product already exists → increase quantity
                const quantityInput = existingRow.querySelector('.quantity');
                const currentQty = parseInt(quantityInput.value) || 0;
                quantityInput.value = currentQty + 1;
                calculateRowAmount(existingRow);
                calculateTotals();
            } else {
                const tbody = document.querySelector('#items-table tbody');
                const newRow = document.createElement('tr');
                const rowIndex = document.querySelectorAll('#items-table tbody tr').length;

                // Determine price and discount
                let price = product.discountPrice || product.price || 0;
                let discountPercentage = product.discountPercentage || 0;
                let sizeValue = '-';
                let showSizeDropdown = false;
                let variants = variantsData;

                if (variant) {
                    price = variant.discount_price || variant.price;
                    sizeValue = variant.size;
                    // Calculate discount percentage for variant
                    if (variant.discount_price && variant.price) {
                        discountPercentage = ((variant.price - variant.discount_price) / variant.price * 100).toFixed(2);
                    }
                }

                // Check if product has variants to show dropdown
                if (product.product_type === 'variant' && !variant) {
                    showSizeDropdown = true;
                    sizeValue = '';
                    
                    // If variants data is provided (from barcode scan), use it
                    if (variants && variants.length > 0) {
                        console.log('📦 Using provided variants data for barcode product');
                    }
                }

                // Create row
                newRow.innerHTML = `
                    <td>
                        <select name="items[${rowIndex}][item_id]" class="form-select form-select-sm item-select" required
                                data-barcode="${barcode || ''}">
                            <option value="${product.id}" selected 
                                    data-category-name="${product.category || 'No Category'}"
                                    data-hsn="${product.hsn_code || ''}"
                                    data-rate="${price}"
                                    data-discount="${discountPercentage}"
                                    data-tax-group="${product.tax_group_id || product.tax_rate || ''}"
                                    data-product-type="${product.product_type || 'simple'}">
                                ${product.productName}
                            </option>
                        </select>
                    </td>
                    <td>
                        <select name="items[${rowIndex}][size]" class="form-select form-select-sm size-select" 
                                style="${showSizeDropdown ? '' : 'display: none;'}">
                            <option value="${sizeValue}" selected>${sizeValue}</option>
                        </select>
                        <span class="size-placeholder" style="${showSizeDropdown ? 'display: none;' : ''}">${sizeValue}</span>
                    </td>
                    <td>
                        <input type="text" name="items[${rowIndex}][category]" 
                            value="${product.category.name || 'No Category'}" 
                            class="form-control form-control-sm category-field" readonly>
                    </td>
                    <td>
                        <input type="number" name="items[${rowIndex}][quantity]" value="1" min="1" 
                            class="form-control form-control-sm quantity" required>
                    </td>
                    <td>
                        <input type="number" name="items[${rowIndex}][discount]" step="0.01" 
                            value="${discountPercentage}" min="0" max="100" 
                            class="form-control form-control-sm discount">
                    </td>
                    <td>
                        <select class="form-select form-select-sm tax-group-select" name="items[${rowIndex}][tax_group_id]" required>
                            <option value="" disabled>-- Select Tax Group --</option>
                            @foreach ($tax_groups as $group)
                                @if ($group->taxes->isNotEmpty())
                                    <option value="{{ $group->id }}" data-rates="{{ $group->taxes->pluck('rate')->implode(',') }}">
                                        {{ $group->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="items[${rowIndex}][hsn]" 
                            value="${product.hsn_code || ''}" 
                            class="form-control form-control-sm hsn-field">
                    </td>
                    <td>
                        <input type="number" name="items[${rowIndex}][rate]" step="0.01" 
                            value="${price}" 
                            class="form-control form-control-sm rate" required>
                    </td>
                    <td>
                        <input type="number" name="items[${rowIndex}][cgst]" step="0.01" 
                            class="form-control form-control-sm cgst-field" readonly>
                    </td>
                    <td>
                        <input type="number" name="items[${rowIndex}][sgst]" step="0.01" 
                            class="form-control form-control-sm sgst-field" readonly>
                    </td>
                    <td>
                        <input type="number" name="items[${rowIndex}][amount]" 
                            class="form-control form-control-sm bg-light amount-field" readonly>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-row">Remove</button>
                    </td>
                `;

                tbody.appendChild(newRow);

                // Initialize Select2
                if (window.$ && $.fn.select2) {
                    $('.item-select').last().select2({
                        width: '100%',
                        minimumResultsForSearch: 10
                    });
                }

                // Set tax group automatically based on product data
                const taxSelect = newRow.querySelector('.tax-group-select');
                if (taxSelect && (product.tax_group_id || product.tax_rate)) {
                    const taxValue = product.tax_group_id || product.tax_rate;
                    setTimeout(() => {
                        // Find and select the matching tax group
                        const options = taxSelect.options;
                        for (let i = 0; i < options.length; i++) {
                            if (options[i].value == taxValue) {
                                taxSelect.value = taxValue;
                                break;
                            }
                        }
                        taxSelect.dispatchEvent(new Event('change', { bubbles: true }));
                    }, 100);
                }

                // If product has variants and no specific variant was selected, load variants
                if (product.product_type === 'variant' && !variant) {
                    setTimeout(() => {
                        if (variants && variants.length > 0) {
                            // Use provided variants data from barcode scan
                            populateSizeDropdownFromData($(newRow), variants);
                        } else {
                            // Fetch variants from API for manually added products
                            fetchProductVariants(product.id, $(newRow));
                        }
                    }, 200);
                }

                // Add event listeners
                attachEventHandlersToRow(newRow);

                const removeBtn = newRow.querySelector('.remove-row');
                removeBtn.addEventListener('click', () => {
                    if (barcode) {
                        scannedBarcodes = scannedBarcodes.filter(b => b !== barcode);
                        document.getElementById('scanned_barcodes').value = scannedBarcodes.join(',');
                    }
                    newRow.remove();
                    calculateTotals();
                });

                // Initial calculation
                setTimeout(() => {
                    calculateRowAmount(newRow);
                    calculateTotals();
                }, 200);
            }
        }

    
            /**
         * Populate size dropdown with provided variants data - UPDATED
         */
        function populateSizeDropdownFromData(row, variants) {
            console.log('📦 Populating size dropdown from provided data:', variants.length);
            const sizeSelect = row.find('.size-select');
            const sizePlaceholder = row.find('.size-placeholder');
            
            sizeSelect.show();
            sizePlaceholder.hide();
            
            let sizeOptions = '<option value="">Select Size</option>';
            
            variants.forEach(variant => {
                const price = variant.discount_price || variant.price;
                sizeOptions += `<option value="${variant.size}" data-price="${price}">
                    ${variant.size} - ₹${price}
                </option>`;
            });
            
            sizeSelect.html(sizeOptions);
            
            // Auto-select first variant if only one exists
            if (variants.length === 1) {
                const firstVariant = variants[0];
                const firstPrice = firstVariant.discount_price || firstVariant.price;
                console.log('⚡ Auto-selecting single variant:', firstVariant.size);
                sizeSelect.val(firstVariant.size).trigger('change');
                row.find('.rate').val(firstPrice);
            } else if (variants.length > 1) {
                // For multiple variants, set rate to first variant's price by default
                const firstVariant = variants[0];
                const firstPrice = firstVariant.discount_price || firstVariant.price;
                row.find('.rate').val(firstPrice);
            }
            
            calculateRowAmount(row[0]);
            calculateTotals();
        }

        function findProductRow(productId, variantId = null) {
            const rows = document.querySelectorAll('#items-table tbody tr');
            for (let row of rows) {
                const select = row.querySelector('.item-select');
                const sizeSelect = row.querySelector('.size-select');
                if (select && select.value == productId) {
                    if (variantId) {
                        // For variants, check if size matches
                        if (sizeSelect && sizeSelect.value == variantId) {
                            return row;
                        }
                    } else {
                        // For simple products
                        return row;
                    }
                }
            }
            return null;
        }

        /**
         * Calculates row amount for taxes and sets values in fields
         */
        function calculateRowAmount(row) {
            const $row = $(row);
            const quantity = parseFloat($row.find('.quantity').val()) || 1;
            const rate = parseFloat($row.find('.rate').val()) || 0;
            const discountPercentage = parseFloat($row.find('.discount').val()) || 0;

            const amountBeforeDiscount = quantity * rate;
            const discountAmount = amountBeforeDiscount * (discountPercentage / 100);
            const amountAfterDiscount = amountBeforeDiscount - discountAmount;

            const taxSelect = $row.find('.tax-group-select');
            const selectedOption = taxSelect.find('option:selected');
            let taxRates = [];

            if (selectedOption.length && selectedOption.data('rates')) {
                taxRates = String(selectedOption.data('rates')).split(',').map(Number);
            }

            let cgstAmount = 0, sgstAmount = 0;
            if (taxRates.length >= 2) {
                cgstAmount = amountAfterDiscount * (taxRates[0] / 100);
                sgstAmount = amountAfterDiscount * (taxRates[1] / 100);
            } else if (taxRates.length === 1) {
                // Split single tax rate equally between CGST and SGST
                const singleRate = taxRates[0] / 2;
                cgstAmount = amountAfterDiscount * (singleRate / 100);
                sgstAmount = amountAfterDiscount * (singleRate / 100);
            }

            const finalAmount = amountAfterDiscount + cgstAmount + sgstAmount;

            $row.find('.cgst-field').val(cgstAmount.toFixed(2));
            $row.find('.sgst-field').val(sgstAmount.toFixed(2));
            $row.find('.amount-field').val(finalAmount.toFixed(2));
        }

        /**
         * Calculate and fill overall totals
         */
        function calculateTotals() {
            let subtotal = 0;
            let totalDiscount = 0;
            let totalCgst = 0;
            let totalSgst = 0;

            $('#items-table tbody tr').each(function() {
                const $row = $(this);
                const quantity = parseFloat($row.find('.quantity').val()) || 0;
                const rate = parseFloat($row.find('.rate').val()) || 0;
                const discountPercentage = parseFloat($row.find('.discount').val()) || 0;

                const amountBeforeDiscount = quantity * rate;
                const discountAmount = amountBeforeDiscount * (discountPercentage / 100);
                const amountAfterDiscount = amountBeforeDiscount - discountAmount;

                subtotal += amountAfterDiscount;
                totalDiscount += discountAmount;
                totalCgst += parseFloat($row.find('.cgst-field').val()) || 0;
                totalSgst += parseFloat($row.find('.sgst-field').val()) || 0;
            });

            const grandTotal = subtotal + totalCgst + totalSgst;

            document.getElementById('subtotal').textContent = '₹' + subtotal.toFixed(2);
            document.getElementById('total-discount').textContent = '₹' + totalDiscount.toFixed(2);
            document.getElementById('total-cgst').textContent = '₹' + totalCgst.toFixed(2);
            document.getElementById('total-sgst').textContent = '₹' + totalSgst.toFixed(2);
            document.getElementById('grand-total').textContent = '₹' + grandTotal.toFixed(2);
        }

        // FINAL: Initialize on page ready
        $(function() {
            initItemSelect2();
            bindItemSelectChange();
            bindSizeSelectChange();
            bindTaxGroupChange();
            bindQtyRateDiscountInput();
            calculateTotals();

            // Bootstrap validation
            (function() {
                'use strict';
                const forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();
        });

        // Debug function
        window.debugInvoice = function() {
            console.log('=== INVOICE DEBUG INFO ===');
            console.log('Total Rows:', document.querySelectorAll('#items-table tbody tr').length);
            console.log('Scanned Barcodes:', scannedBarcodes);
            console.log('Tax Groups:', Object.keys(taxGroups).length);
            
            $('#items-table tbody tr').each(function(index) {
                const row = $(this);
                console.log(`Row ${index + 1}:`, {
                    product: row.find('.item-select').val(),
                    productType: row.find('.item-select option:selected').data('product-type'),
                    size: row.find('.size-select').val(),
                    sizeVisible: row.find('.size-select').is(':visible'),
                    rate: row.find('.rate').val()
                });
            });
        };
    });
</script>

@endsection
