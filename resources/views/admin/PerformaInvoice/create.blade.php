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
        <h4 class="mb-3 text-secondary">New Performa Invoice</h4>

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

        <form action="{{ route('performa_invoices.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf

            {{-- Customer & Performa Invoice Details --}}
            <div class="p-3 mb-4 border-bottom">
                <h6 class="h6 mb-2 text-uppercase text-secondary">Performa Invoice Details</h6>
                <div class="row row-cols-1 row-cols-md-2 g-3">
                   
                    
                        <div class="col">
                            <label for="customer_name" class="form-label form-label-sm fw-bold text-muted">Customer Name*</label>
                            <select name="customer_name" id="customer_name" class="form-control form-control-sm" required>
                                <option value="" disabled selected>Select customer</option>
                                @if(old('offline_online', 'online') == 'online')
                                    {{-- Online Customers from Users table --}}
                                    @foreach($users as $user)
                                        <option value="{{ $user->first_name . ' ' . $user->last_name }}"
                                            {{ old('customer_name') == $user->first_name . ' ' . $user->last_name ? 'selected' : '' }}
                                            data-email="{{ $user->email }}"
                                            data-phone="{{ $user->phone ?? '' }}"
                                            data-address="{{ $user->address ?? '' }}">
                                            {{ $user->first_name }} {{ $user->last_name }} (Online)
                                        </option>
                                    @endforeach
                                @else
                                    {{-- Offline Customers --}}
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->name }}"
                                            {{ old('customer_name') == $customer->name ? 'selected' : '' }}
                                            data-email="{{ $customer->email ?? '' }}"
                                            data-phone="{{ $customer->phone ?? '' }}"
                                            data-address="{{ $customer->address ?? '' }}">
                                            {{ $customer->name }} (Offline)
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                Please select a customer.
                            </div>
                        </div>
                        <div class="col">
                            <label for="offline_online" class="form-label form-label-sm fw-bold text-muted">Invoice Type*</label>
                            <select name="offline_online" id="offline_online" class="form-control form-control-sm" required>
                                <option value="offline" {{ old('offline_online', 'offline') == 'offline' ? 'selected' : '' }}>Offline</option>
                             {{--   <option value="online" {{ old('offline_online', 'offline') == 'online' ? 'selected' : '' }}>Online</option> --}}
                            </select>
                        </div>


                    
                    
                    
                    
                    <div class="col">
                        <label for="order_number" class="form-label form-label-sm fw-bold text-muted">Order Number</label>
                        <input type="text" name="order_number" id="order_number" class="form-control form-control-sm" value="{{ old('order_number') }}" placeholder="Enter order number">
                    </div>
                    <div class="col">
                        <label for="performa_date" class="form-label form-label-sm fw-bold text-muted">Performa Date*</label>
                        <input type="date" name="performa_date" id="performa_date" value="{{ old('performa_date', date('Y-m-d')) }}" class="form-control form-control-sm" required>
                        <div class="invalid-feedback">
                            Please select a performa date.
                        </div>
                    </div>
                    <div class="col">
                        <label for="paid_amount" class="form-label form-label-sm fw-bold text-muted">Advance Amount (₹)</label>
                        <input type="number" name="paid_amount" id="paid_amount" step="0.01" min="0" value="{{ old('paid_amount', 0) }}" class="form-control form-control-sm">
                        <div class="invalid-feedback">
                            Please enter a valid advance amount.
                        </div>
                    </div>
                    <div class="col">
                        <label for="customer_email" class="form-label form-label-sm fw-bold text-muted">Customer Email</label>
                        <input type="email" name="customer_email" id="customer_email" class="form-control form-control-sm" value="{{ old('customer_email') }}" placeholder="Enter customer email">
                    </div>
                    <div class="col">
                        <label for="customer_phone" class="form-label form-label-sm fw-bold text-muted">Customer Phone</label>
                        <input type="tel" name="customer_phone" id="customer_phone" class="form-control form-control-sm" value="{{ old('customer_phone') }}" placeholder="Enter customer phone number">
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
                        <label for="performa_number" class="form-label form-label-sm fw-bold text-muted">Performa Invoice#*</label>
                        <input type="text" id="performa_number" value="{{ $nextPerformaNumber }}" name="performa_number" class="form-control form-control-sm" readonly>
                    </div>
                </div>
            </div>

            {{-- Barcode Scanner --}}
            <div class="p-3 mb-4 border-bottom">
                <h6 class="h6 mb-2 text-uppercase text-secondary">Barcode Scanner</h6>
                <div class="row">
                    <div class="col-md-6">
                        <label for="barcode" class="form-label form-label-sm fw-bold text-muted">Scan Barcode</label>
                        <input type="text" name="barcode" id="barcode" class="form-control form-control-sm" 
                               placeholder="Scan or enter barcode" autocomplete="off">
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
                            {{-- Rows will be added dynamically --}}
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
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Advance Paid</span>
                            <span id="paid-amount-display" class="fw-bold small text-primary">₹0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 border-top pt-2">
                            <span class="text-muted small">Due Amount</span>
                            <span id="due-amount" class="fw-bold small text-danger">₹0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="d-flex justify-content-end pt-3">
                <button type="button" class="btn btn-sm btn-outline-secondary me-2" onclick="window.history.back()">
                    Cancel
                </button>
                <button type="submit" name="action" value="save" class="btn btn-sm btn-primary">
                    Save Performa Invoice
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



{{-- working for direct select product with size --}}


<script>
$(document).ready(function() {
    console.log('=== PERFORMANCE INVOICE SCRIPT INITIALIZED ===');
    
    // Initialize variables
    let rowCount = 0;
    const taxGroups = @json($tax_groups->keyBy('id'));
    let scannedBarcodes = [];
    
    console.log('✅ Script initialized');
    console.log('📊 Tax Groups loaded:', Object.keys(taxGroups).length);
    console.log('🛒 Products available:', @json($items->count()));

    // Customer data arrays
    const onlineCustomers = [
        @foreach($users as $user)
        {
            name: "{{ $user->first_name . ' ' . $user->last_name }}",
            email: "{{ $user->email }}",
            phone: "{{ $user->phone ?? '' }}",
            address: "{{ $user->address ?? '' }}"
        },
        @endforeach
    ];

    const offlineCustomers = [
        @foreach($customers as $customer)
        {
            name: "{{ $customer->name }}",
            email: "{{ $customer->email ?? '' }}",
            phone: "{{ $customer->phone ?? '' }}",
            address: "{{ $customer->address ?? '' }}"
        },
        @endforeach
    ];

    // Initialize Select2
    $('#customer_name').select2();
    $('#offline_online').select2({
        minimumResultsForSearch: -1
    });

    // Initialize customer dropdown based on default type
    updateCustomerDropdown($('#offline_online').val());

    // Customer type change handler
    $('#offline_online').on('change', function() {
        console.log('🔄 Invoice type changed to:', $(this).val());
        updateCustomerDropdown($(this).val());
    });

    // Customer selection handler
    $('#customer_name').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        console.log('👤 Customer selected:', selectedOption.val());
        $('#customer_email').val(selectedOption.data('email') || '');
        $('#customer_phone').val(selectedOption.data('phone') || '');
        $('#customer_address').val(selectedOption.data('address') || '');
    });

    // Add new row
    $('#add-row').on('click', function() {
        console.log('➕ Add row button clicked');
        addNewRow();
    });

    // Barcode scanner functionality - FIXED VERSION
    $('#barcode').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            const barcode = $(this).val().trim();
            
            if (barcode) {
                console.log('=========================================');
                console.log('🚀 BARCODE SCAN PROCESS STARTED');
                console.log('🔍 Barcode:', barcode);
                console.log('=========================================');
                
                handleBarcodeScan(barcode);
                $(this).val('');
            } else {
                console.log('❌ Barcode field is empty');
                showAlert('Please enter a barcode', 'warning');
            }
        }
    });

    // Paid amount change handler
    $('#paid_amount').on('input', function() {
        calculateTotals();
    });

    // Initialize first row
    // console.log('📝 Initializing first row...');
    // addNewRow();

    // Function to update customer dropdown based on type
    function updateCustomerDropdown(type) {
        console.log('🔄 Updating customer dropdown for type:', type);
        const customerSelect = $('#customer_name');
        customerSelect.empty().append('<option value="" disabled selected>Select customer</option>');
        
        const customers = type === 'online' ? onlineCustomers : offlineCustomers;
        const typeLabel = type === 'online' ? ' (Online)' : ' (Offline)';
        
        customers.forEach(customer => {
            customerSelect.append(
                `<option value="${customer.name}" 
                        data-email="${customer.email}" 
                        data-phone="${customer.phone}" 
                        data-address="${customer.address}">
                    ${customer.name}${typeLabel}
                </option>`
            );
        });
        
        console.log(`✅ Added ${customers.length} ${type} customers`);
        customerSelect.trigger('change');
    }

    // Function to add new row
    function addNewRow() {
        rowCount++;
        const rowId = `row-${rowCount}`;
        
        console.log('📦 Creating new row:', rowId);
        
        const newRow = `
            <tr id="${rowId}">
                <td>
                    <select name="items[${rowCount}][item_id]" class="form-control form-control-sm product-select" required>
                        <option value="">Select Product</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" 
                                    data-product-type="{{ $item->product_type }}"
                                    data-price="{{ $item->discountPrice ?? $item->price }}"
                                    data-hsn="{{ $item->hsn_code }}"
                                    {{ $categories = App\Models\Category::find($item->category) }}
                                    data-category="{{ $categories->name}}"
                                    data-tax-group="{{ $item->tax_rate }}">
                                {{ $item->productName }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="items[${rowCount}][size]" class="form-control form-control-sm size-select" style="display: none;">
                        <option value="">Select Size</option>
                    </select>
                    <span class="size-placeholder">-</span>
                </td>
                <td>
                    <input type="text" name="items[${rowCount}][category]" class="form-control form-control-sm category-field" readonly>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][quantity]" class="form-control form-control-sm quantity" value="1" min="1" step="1" required>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][discount]" class="form-control form-control-sm discount" value="0" min="0" max="100" step="0.01">
                </td>
                <td>
                    <select name="items[${rowCount}][tax_group_id]" class="form-control form-control-sm tax-group-select">
                        <option value="">Select Tax Group</option>
                        @foreach($tax_groups as $tax_group)
                            <option value="{{ $tax_group->id }}">{{ $tax_group->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="items[${rowCount}][hsn]" class="form-control form-control-sm hsn-field" readonly>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][rate]" class="form-control form-control-sm rate" value="0" min="0" step="0.01" required>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][cgst_amount]" class="form-control form-control-sm cgst-amount" value="0" readonly>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][sgst_amount]" class="form-control form-control-sm sgst-amount" value="0" readonly>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][amount]" class="form-control form-control-sm amount" value="0" readonly>
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-row">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        `;
        
        $('#items-table tbody').append(newRow);
        
        // Initialize Select2 for new row
        $(`#${rowId} .product-select`).select2();
        $(`#${rowId} .tax-group-select`).select2();
        
        // Attach event handlers
        attachRowEventHandlers(rowId);
        
        return rowId;
    }

    // Function to attach event handlers to row elements
    function attachRowEventHandlers(rowId) {
        const row = $(`#${rowId}`);
        
        // Product selection handler
        row.find('.product-select').on('change', function() {
            const productId = $(this).val();
            const selectedOption = $(this).find('option:selected');
            const productType = selectedOption.data('product-type');
            const price = parseFloat(selectedOption.data('price')) || 0;
            const hsn = selectedOption.data('hsn') || '';
            const category = selectedOption.data('category') || 'No Category';
            const taxGroup = selectedOption.data('tax-group') || '';
            
            console.log('🔄 Product selected in row', rowId, ':', {
                productId: productId,
                productName: selectedOption.text(),
                productType: productType,
                price: price,
                hsn: hsn,
                category: category,
                taxGroup: taxGroup
            });
            
            // Set basic fields
            row.find('.hsn-field').val(hsn);
            row.find('.category-field').val(category);
            if (taxGroup) {
                row.find('.tax-group-select').val(Number(taxGroup)).trigger('change');
            }
            
            // Handle product type
            if (productType === 'variant') {
                console.log('🔧 Variant product detected, loading variants for product ID:', productId);
                loadProductVariants(productId, row);
            } else {
                // Simple product - hide size dropdown, show placeholder
                console.log('🔧 Simple product detected, setting price:', price);
                row.find('.size-select').hide().val('');
                row.find('.size-placeholder').show().text('-');
                row.find('.rate').val(price);
                calculateRowTotal(row);
            }
        });
        
        // Size selection handler (for variant products)
        row.find('.size-select').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const price = parseFloat(selectedOption.data('price')) || 0;
            console.log('📏 Size selected in row', rowId, ':', $(this).val(), 'Price:', price);
            row.find('.rate').val(price);
            calculateRowTotal(row);
        });
        
        // Quantity, rate, discount, tax group change handlers
        row.find('.quantity, .rate, .discount').on('input', function() {
            calculateRowTotal(row);
        });
        
        row.find('.tax-group-select').on('change', function() {
            calculateRowTotal(row);
        });
        
        // Remove row handler
        row.find('.remove-row').on('click', function() {
            console.log('🗑️ Remove row clicked:', rowId);
            row.remove();
            calculateTotals();
        });
    }

    // Function to load product variants
    function loadProductVariants(productId, row) {
        console.log('🔄 Loading variants for product ID:', productId);
        
        // Show loading in size dropdown
        const sizeSelect = row.find('.size-select');
        sizeSelect.show().empty().append('<option value="">Loading sizes...</option>');
        row.find('.size-placeholder').hide();
        
        // Make AJAX call to get variants
        const variantUrl = '{{ route("products.variants", ["product" => ":productId"]) }}'.replace(':productId', productId);
        
        $.ajax({
            url: variantUrl,
            type: 'GET',
            success: function(response) {
                console.log('✅ Variants AJAX success for product', productId);
                sizeSelect.empty().append('<option value="">Select Size</option>');
                
                if (response.variants && response.variants.length > 0) {
                    console.log('📦 Found', response.variants.length, 'variants');
                    response.variants.forEach(function(variant) {
                        const price = variant.discount_price || variant.price;
                        sizeSelect.append(
                            `<option value="${variant.size}" data-price="${price}">
                                ${variant.size} - ₹${price}
                            </option>`
                        );
                    });
                    
                    // Auto-select first variant if only one exists
                    if (response.variants.length === 1) {
                        const firstVariant = response.variants[0];
                        const firstPrice = firstVariant.discount_price || firstVariant.price;
                        console.log('⚡ Auto-selecting single variant:', firstVariant.size, 'Price:', firstPrice);
                        sizeSelect.val(firstVariant.size).trigger('change');
                        row.find('.rate').val(firstPrice);
                    }
                } else {
                    console.log('❌ No variants found for product', productId);
                    sizeSelect.append('<option value="">No variants found</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error('❌ Error loading variants for product', productId);
                sizeSelect.empty().append('<option value="">Error loading sizes</option>');
            }
        });
    }

    // Function to handle barcode scanning - FIXED VERSION
    function handleBarcodeScan(barcode) {
        // Step 1: Check if barcode was already scanned
        if (scannedBarcodes.includes(barcode)) {
            console.log('❌ Barcode already scanned:', barcode);
            alert('❌ Barcode already scanned:', barcode)
            showAlert('This barcode has already been scanned!', 'warning');
            return;
        }
        
        // Step 2: Show loading state
        $('#barcode').prop('disabled', true).attr('placeholder', 'Searching for product...');
        console.log('⏳ Barcode field disabled for loading');
        
        // Step 3: Make AJAX call to find product by barcode - USING YOUR EXISTING ROUTE
        const barcodeUrl = '{{ route("products.find-by-barcode", ["barcode" => ":barcode"]) }}'.replace(':barcode', encodeURIComponent(barcode));
        console.log('🌐 Making AJAX request to:', barcodeUrl);
        
        $.ajax({
            url: barcodeUrl,
            type: 'GET',
            dataType: 'json',
            timeout: 15000,
            success: function(response) {
                console.log('✅ BARCODE AJAX SUCCESS');
                console.log('📦 Full response:', response);
                
                // Reset barcode field
                $('#barcode').prop('disabled', false).attr('placeholder', 'Scan or enter barcode');
                
              
                
                const product = response;
                
                // Step 4: Add to scanned barcodes
                scannedBarcodes.push(barcode);
                $('#scanned_barcodes').val(scannedBarcodes.join(','));
                console.log('📋 Added to scanned barcodes. Total:', scannedBarcodes.length);
                
                // Step 5: Add new row
                console.log('📝 Creating new row for scanned product...');
                const newRowId = addNewRow();
                const newRow = $(`#${newRowId}`);
                
                // Step 6: Find and select the product in the dropdown
                const productSelect = newRow.find('.product-select');
                const productOption = productSelect.find('option[value="' + product.id + '"]');
                
                if (productOption.length === 0) {
                    console.log('❌ Product ID not found in dropdown options');
                    showAlert('Product not found in dropdown. Please check if the product is available.', 'error');
                    return;
                }
                
                console.log('🎯 Selecting product in dropdown...');
                productSelect.val(product.id).trigger('change');
                
                console.log('📋 Product Details:', {
                    id: product.id,
                    name: product.productName,
                    type: product.product_type,
                    price: product.price,
                    discountPrice: product.discountPrice,
                    variantsCount: product.variants ? product.variants.length : 0
                });
                
                // Set basic fields
                newRow.find('.hsn-field').val(product.hsn || product.hsn_code || '');
                newRow.find('.category-field').val(product.category_name || product.category || 'No Category');
                
                // if (product.tax_group_id) {
                //     newRow.find('.tax-group-select').val(product.tax_group_id).trigger('change');
                // }

                // FIX: Use tax_rate instead of tax_group_id and convert to number
                    if (product.tax_group_id) {
                        const taxGroupId = Number(product.tax_group_id);
                        console.log('🏷️ Setting tax group from tax_rate:', product.tax_group_id, '->', taxGroupId);
                        newRow.find('.tax-group-select').val(taxGroupId).trigger('change');
                    } else {
                        console.log('⚠️ No tax_rate found in product data');
                    }
                
                // Handle product type
                if (product.product_type === 'variant') {
                    console.log('🔧 Variant product detected');
                    
                    if (product.variants && product.variants.length > 0) {
                        console.log('📦 Variants available in response, populating...');
                        populateVariantsFromResponse(newRow, product.variants);
                    }
                } else {
                    console.log('🔧 Simple product detected');
                    const price = product.discountPrice || product.price;
                    console.log('💰 Setting rate for simple product:', price);
                    newRow.find('.rate').val(price);
                    newRow.find('.size-select').hide();
                    newRow.find('.size-placeholder').show().text('-');
                    calculateRowTotal(newRow);
                }
                
                console.log('✅ Product data population completed');
                calculateTotals();
                
                console.log('=========================================');
                console.log('🎉 BARCODE SCAN COMPLETED SUCCESSFULLY');
                console.log('=========================================');
                
                // Show success message
                showAlert('Product "' + product.productName + '" added successfully!', 'success');
                
            },
            error: function(xhr, status, error) {
                console.error('❌ BARCODE AJAX ERROR');
                
                $('#barcode').prop('disabled', false).attr('placeholder', 'Scan or enter barcode');
                
                let errorMessage = 'Error scanning barcode: ';
                
                if (xhr.status === 404) {
                    errorMessage = 'Product not found for barcode: ' + barcode;
                    console.log('❌ Product not found in database');
                    showAlert(errorMessage, 'error');
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again.';
                    console.log('❌ Server error occurred');
                    showAlert(errorMessage, 'error');
                } else if (status === 'timeout') {
                    errorMessage = 'Request timeout. Please check your connection.';
                    console.log('❌ Request timed out');
                    showAlert(errorMessage, 'warning');
                } else {
                    errorMessage += error;
                    showAlert(errorMessage, 'error');
                }
            }
        });
    }

    // Function to populate variants from barcode response
    function populateVariantsFromResponse(row, variants) {
        console.log('🔄 Populating variants from response...');
        const sizeSelect = row.find('.size-select');
        
        sizeSelect.show().empty().append('<option value="">Select Size</option>');
        
        variants.forEach(function(variant) {
            const price = variant.discount_price || variant.price;
            console.log('📋 Adding variant:', variant.size, 'Price:', price);
            sizeSelect.append(
                `<option value="${variant.size}" data-price="${price}">
                    ${variant.size} - ₹${price}
                </option>`
            );
        });
        
        // Auto-select first variant if only one exists
        if (variants.length === 1) {
            const firstVariant = variants[0];
            const firstPrice = firstVariant.discount_price || firstVariant.price;
            console.log('⚡ Auto-selecting single variant:', firstVariant.size, 'Price:', firstPrice);
            sizeSelect.val(firstVariant.size).trigger('change');
            row.find('.rate').val(firstPrice);
        }
        
        calculateRowTotal(row);
    }

    // Function to calculate row total
    function calculateRowTotal(row) {
        const quantity = parseFloat(row.find('.quantity').val()) || 0;
        const rate = parseFloat(row.find('.rate').val()) || 0;
        const discount = parseFloat(row.find('.discount').val()) || 0;
        const taxGroupId = row.find('.tax-group-select').val();
        
        // Calculate amount before discount and tax
        const amountBeforeDiscount = quantity * rate;
        const discountAmount = amountBeforeDiscount * (discount / 100);
        const taxableAmount = amountBeforeDiscount - discountAmount;
        
        // Calculate taxes
        let cgstAmount = 0;
        let sgstAmount = 0;
        
        if (taxGroupId && taxGroups[taxGroupId]) {
            const taxGroup = taxGroups[taxGroupId];
            const taxRates = taxGroup.taxes.map(tax => tax.rate);
            
            console.log('🏷️ Tax rates for calculation:', taxRates);
            
            if (taxRates.length >= 2) {
                cgstAmount = taxableAmount * (taxRates[0] / 100);
                sgstAmount = taxableAmount * (taxRates[1] / 100);
            } else if (taxRates.length === 1) {
                cgstAmount = taxableAmount * (taxRates[0] / 200);
                sgstAmount = taxableAmount * (taxRates[0] / 200);
            }
        }
        
        const finalAmount = taxableAmount + cgstAmount + sgstAmount;
        
        console.log('📊 Row calculation results:', {
            taxableAmount: taxableAmount,
            cgstAmount: cgstAmount,
            sgstAmount: sgstAmount,
            finalAmount: finalAmount
        });
        
        // Update row fields
        row.find('.cgst-amount').val(cgstAmount.toFixed(2));
        row.find('.sgst-amount').val(sgstAmount.toFixed(2));
        row.find('.amount').val(finalAmount.toFixed(2));
        
        calculateTotals();
    }

    // Function to calculate all totals
    function calculateTotals() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalCgst = 0;
        let totalSgst = 0;
        let totalAmount = 0;
        
        console.log('🧮 Calculating grand totals...');
        
        $('#items-table tbody tr').each(function(index) {
            const quantity = parseFloat($(this).find('.quantity').val()) || 0;
            const rate = parseFloat($(this).find('.rate').val()) || 0;
            const discount = parseFloat($(this).find('.discount').val()) || 0;
            const amount = parseFloat($(this).find('.amount').val()) || 0;
            const cgst = parseFloat($(this).find('.cgst-amount').val()) || 0;
            const sgst = parseFloat($(this).find('.sgst-amount').val()) || 0;
            
            const amountBeforeDiscount = quantity * rate;
            const discountAmount = amountBeforeDiscount * (discount / 100);
            
            subtotal += amountBeforeDiscount;
            totalDiscount += discountAmount;
            totalCgst += cgst;
            totalSgst += sgst;
            totalAmount += amount;
        });
        
        const paidAmount = parseFloat($('#paid_amount').val()) || 0;
        const dueAmount = Math.max(0, totalAmount - paidAmount);
        
        console.log('💰 Final totals:', {
            subtotal: subtotal,
            totalDiscount: totalDiscount,
            totalCgst: totalCgst,
            totalSgst: totalSgst,
            totalAmount: totalAmount,
            paidAmount: paidAmount,
            dueAmount: dueAmount
        });
        
        // Update display
        $('#subtotal').text('₹' + subtotal.toFixed(2));
        $('#total-discount').text('₹' + totalDiscount.toFixed(2));
        $('#total-cgst').text('₹' + totalCgst.toFixed(2));
        $('#total-sgst').text('₹' + totalSgst.toFixed(2));
        $('#grand-total').text('₹' + totalAmount.toFixed(2));
        $('#paid-amount-display').text('₹' + paidAmount.toFixed(2));
        $('#due-amount').text('₹' + dueAmount.toFixed(2));
    }

    // Function to show alert messages
    function showAlert(message, type = 'info') {
        const alertTypes = {
            'success': { class: 'alert-success', icon: '✅' },
            'error': { class: 'alert-danger', icon: '❌' },
            'warning': { class: 'alert-warning', icon: '⚠️' },
            'info': { class: 'alert-info', icon: 'ℹ️' }
        };
        
        const alertConfig = alertTypes[type] || alertTypes.info;
        
        // Create alert element
        const alertHtml = `
            <div class="alert ${alertConfig.class} alert-dismissible fade show" role="alert">
                <strong>${alertConfig.icon}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Add alert before the form
        $('form').before(alertHtml);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            $('.alert').alert('close');
        }, 5000);
    }

    // Form validation
    $('form').on('submit', function(e) {
        console.log('📤 Form submission attempted');
        let valid = true;
        let errorMessages = [];
        
        // Check if at least one item is added
        if ($('#items-table tbody tr').length === 0) {
            errorMessages.push('Please add at least one item to the invoice.');
            valid = false;
        }
        
        // Validate each row
        $('#items-table tbody tr').each(function(index) {
            const productId = $(this).find('.product-select').val();
            const quantity = $(this).find('.quantity').val();
            const rate = $(this).find('.rate').val();
            
            console.log('✅ Validating row', index + 1, ':', {
                productId: productId,
                quantity: quantity,
                rate: rate
            });
            
            if (!productId || !quantity || parseFloat(quantity) <= 0 || !rate || parseFloat(rate) <= 0) {
                errorMessages.push(`Please fill all required fields in row ${index + 1}.`);
                valid = false;
            }
        });
        
        if (!valid) {
            e.preventDefault();
            console.log('❌ Form validation failed:', errorMessages);
            alert('Please fix the following errors:\n\n' + errorMessages.join('\n'));
        } else {
            console.log('✅ Form validation passed, submitting...');
        }
    });

    // Debug functions
    window.debugState = function() {
        console.log('=== DEBUG STATE ===');
        console.log('📊 Current row count:', rowCount);
        console.log('🔍 Scanned barcodes:', scannedBarcodes);
        console.log('🏷️ Tax groups available:', Object.keys(taxGroups).length);
        
        $('#items-table tbody tr').each(function(index) {
            const row = $(this);
            console.log(`📋 Row ${index + 1}:`, {
                product: row.find('.product-select').val(),
                productText: row.find('.product-select option:selected').text(),
                size: row.find('.size-select').val(),
                quantity: row.find('.quantity').val(),
                rate: row.find('.rate').val(),
                amount: row.find('.amount').val()
            });
        });
    };

    // Test barcode scan function
    window.testBarcode = function(barcode) {
        console.log('🧪 TEST BARCODE SCAN');
        handleBarcodeScan(barcode || 'TEST123');
    };

    console.log('✅ Barcode scanning script fully loaded and ready');
    console.log('💡 Use debugState() in console to check current state');
    console.log('💡 Use testBarcode("YOUR_BARCODE") to test specific barcodes');
});
</script>
@endsection