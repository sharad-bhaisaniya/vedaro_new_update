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
        <h4 class="mb-3 text-secondary">Edit Performa Invoice</h4>

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

        <form action="{{ route('performa_invoices.update', $performaInvoice->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            {{-- Customer & Performa Invoice Details --}}
            <div class="p-3 mb-4 border-bottom">
                <h6 class="h6 mb-2 text-uppercase text-secondary">Performa Invoice Details</h6>
                <div class="row row-cols-1 row-cols-md-2 g-3">
                    <div class="col">
                        <label for="customer_name" class="form-label form-label-sm fw-bold text-muted">Customer Name*</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" value="{{ old('customer_name', $performaInvoice->customer_name) }}" placeholder="Enter customer name" required>
                        <div class="invalid-feedback">
                            Please enter a customer name.
                        </div>
                    </div>
                    <div class="col">
                        <label for="order_number" class="form-label form-label-sm fw-bold text-muted">Order Number</label>
                        <input type="text" name="order_number" id="order_number" class="form-control form-control-sm" value="{{ old('order_number', $performaInvoice->order_number) }}" placeholder="Enter order number">
                    </div>
                    <div class="col">
                        <label for="performa_date" class="form-label form-label-sm fw-bold text-muted">Performa Date*</label>
                        <input type="date" name="performa_date" id="performa_date" value="{{ old('performa_date', \Carbon\Carbon::parse($performaInvoice->performa_date)->format('Y-m-d')) }}" class="form-control form-control-sm" required>
                        <div class="invalid-feedback">
                            Please select a performa date.
                        </div>
                    </div>
                    <div class="col">
                        <label for="paid_amount" class="form-label form-label-sm fw-bold text-muted">Paid Amount (₹)*</label>
                        <input type="number" name="paid_amount" id="paid_amount" step="0.01" min="0" value="{{ old('paid_amount', $performaInvoice->paid_amount) }}" class="form-control form-control-sm" required>
                        <div class="invalid-feedback">
                            Please enter a valid paid amount.
                        </div>
                    </div>
                    <div class="col">
                        <label for="offline_online" class="form-label form-label-sm fw-bold text-muted">Invoice Type*</label>
                        <select name="offline_online" id="offline_online" class="form-control form-control-sm" required>
                            <option value="online" {{ old('offline_online', $performaInvoice->offline_online) == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="offline" {{ old('offline_online', $performaInvoice->offline_online) == 'offline' ? 'selected' : '' }}>Offline</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="admin_gstin" class="form-label form-label-sm fw-bold text-muted">Admin GSTIN</label>
                        <input type="text" name="admin_gstin" id="admin_gstin" class="form-control form-control-sm" value="{{ old('admin_gstin', $performaInvoice->admin_gstin) }}" placeholder="Enter admin GSTIN">
                    </div>
                    <div class="col-12">
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col">
                                <label for="customer_address" class="form-label form-label-sm fw-bold text-muted">Customer Address</label>
                                <textarea name="customer_address" id="customer_address" rows="2" class="form-control form-control-sm" placeholder="Enter street and locality">{{ old('customer_address', $performaInvoice->customer_address) }}</textarea>
                            </div>
                            <div class="col">
                                <div class="mb-2">
                                    <label for="customer_gstin" class="form-label form-label-sm fw-bold text-muted">Customer GSTIN</label>
                                    <input type="text" name="customer_gstin" id="customer_gstin" class="form-control form-control-sm" value="{{ old('customer_gstin', $performaInvoice->customer_gstin) }}" placeholder="Enter customer GSTIN">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label for="performa_number" class="form-label form-label-sm fw-bold text-muted">Performa Invoice#*</label>
                        <input type="text" id="performa_number" value="{{ old('performa_number', $performaInvoice->performa_number) }}" name="performa_number" class="form-control form-control-sm" readonly>
                    </div>
                </div>
            </div>

            {{-- Item Details Table --}}
          <div class="p-3 mb-4 border-bottom">
    <h6 class="h6 mb-2 text-uppercase text-secondary">Item Details</h6>
    <div class="table-responsive">
        <table class="table table-sm table-borderless table-hover align-middle mb-0" id="items-table">
            <thead class="fw-normal">
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Category</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Discount (%)</th>
                    <th scope="col">Tax Group</th>
                    <th scope="col">HSN</th>
                    <th scope="col">Rate (₹)</th>
                    <th scope="col">CGST (₹)</th>
                    <th scope="col">SGST (₹)</th>
                    <th scope="col">ITC Eligible</th>
                    <th scope="col">Amount (₹)</th>
                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($performaInvoice->items as $index => $item)
                <tr>
                    <td>
                        <select name="items[{{ $index }}][item_id]" class="form-select form-select-sm item-select" required>
                            <option value="" disabled>Select item</option>
                            @foreach($items as $product)
                                @php
                                    // Get category name safely
                                    $categoryName = 'No Category';
                                    if ($product->category) {
                                        if (is_object($product->category)) {
                                            $categoryName = $product->category->name;
                                        } else {
                                            // If it's an ID, try to find the category
                                            $categoryModel = \App\Models\Category::find($product->category);
                                            $categoryName = $categoryModel ? $categoryModel->name : 'No Category';
                                        }
                                    }
                                @endphp
                                <option value="{{ $product->id }}"
                                    data-category-name="{{ $categoryName }}"
                                    data-hsn="{{ $product->hsn ?? '8418' }}"
                                    data-rate="{{ $product->rate ?? '0' }}"
                                    data-tax-group="{{ $product->tax_group_id ?? '' }}"
                                    {{ $item->item_name == $product->productName ? 'selected' : '' }}>
                                    {{ $product->productName }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select an item.
                        </div>
                    </td>
                    <td>
                        <input type="text" name="items[{{ $index }}][category]" class="form-control form-control-sm category-field" value="{{ $item->category }}" readonly>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" min="0.01" step="0.01" class="form-control form-control-sm quantity" required>
                        <div class="invalid-feedback">
                            Please enter a valid quantity.
                        </div>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $index }}][discount]" step="0.01" value="{{ $item->discount }}" min="0" max="100" class="form-control form-control-sm discount">
                    </td>
                    <td>
                        <select class="form-select form-select-sm tax-group-select" name="items[{{ $index }}][tax_group_id]" required>
                            <option value="" disabled>-- Select Tax Group --</option>
                            @foreach ($tax_groups as $group)
                                @if ($group->taxes->isNotEmpty())
                                    @php
                                        $totalRate = $group->taxes->sum('rate');
                                        $cgstRate = $group->taxes->where('type', 'cgst')->first()->rate ?? $totalRate/2;
                                        $sgstRate = $group->taxes->where('type', 'sgst')->first()->rate ?? $totalRate/2;
                                    @endphp
                                    <option value="{{ $group->id }}" 
                                        data-cgst-rate="{{ $cgstRate }}"
                                        data-sgst-rate="{{ $sgstRate }}"
                                        data-total-rate="{{ $totalRate }}"
                                        {{ $item->tax_group_id == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }} ({{ $totalRate }}%)
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="items[{{ $index }}][hsn]" value="{{ $item->hsn ?? '8418' }}" class="form-control form-control-sm hsn-field" required>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $index }}][rate]" step="0.01" value="{{ $item->rate }}" min="0" class="form-control form-control-sm rate" required>
                        <div class="invalid-feedback">
                            Please enter a valid rate.
                        </div>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $index }}][cgst_amount]" step="0.01" value="{{ $item->cgst_amount ?? 0 }}" class="form-control form-control-sm cgst-field" readonly>
                        <input type="hidden" name="items[{{ $index }}][cgst_rate]" value="{{ $item->cgst_rate ?? 0 }}" class="cgst-rate">
                    </td>
                    <td>
                        <input type="number" name="items[{{ $index }}][sgst_amount]" step="0.01" value="{{ $item->sgst_amount ?? 0 }}" class="form-control form-control-sm sgst-field" readonly>
                        <input type="hidden" name="items[{{ $index }}][sgst_rate]" value="{{ $item->sgst_rate ?? 0 }}" class="sgst-rate">
                    </td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input itc-eligible" type="checkbox" name="items[{{ $index }}][eligible_for_itc]" value="1" {{ $item->eligible_for_itc ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $index }}][amount]" value="{{ $item->amount }}" class="form-control form-control-sm bg-light amount-field" readonly>
                        <input type="hidden" name="items[{{ $index }}][taxable_amount]" value="{{ $item->taxable_amount ?? 0 }}" class="taxable-amount">
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-row">Remove</button>
                    </td>
                </tr>
                @endforeach
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

            <div class="d-flex justify-content-end pt-3">
                <a href="{{ route('performa_invoices.index') }}" class="btn btn-sm btn-outline-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-sm btn-primary">Update Performa Invoice</button>
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
    let rowCount = {{ count($performaInvoice->items) }};

    // Initialize Select2 for existing item selects
    $('.item-select').select2({
        width: '100%',
        minimumResultsForSearch: 10
    });

    // Add new row
    document.getElementById('add-row').addEventListener('click', function() {
        const tbody = document.querySelector('#items-table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select name="items[${rowCount}][item_id]" class="form-select form-select-sm item-select" required>
                    <option value="" disabled selected>Select item</option>
                    @foreach($items as $product)
                        @php
                            $categoryName = 'No Category';
                            if ($product->category) {
                                if (is_object($product->category)) {
                                    $categoryName = $product->category->name;
                                } else {
                                    $categoryModel = \App\Models\Category::find($product->category);
                                    $categoryName = $categoryModel ? $categoryModel->name : 'No Category';
                                }
                            }
                        @endphp
                        <option value="{{ $product->id }}"
                            data-category-name="{{ $categoryName }}"
                            data-hsn="{{ $product->hsn ?? '8418' }}"
                            data-rate="{{ $product->rate ?? '0' }}"
                            data-tax-group="{{ $product->tax_group_id ?? '' }}">
                            {{ $product->productName }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Please select an item.
                </div>
            </td>
            <td>
                <input type="text" name="items[${rowCount}][category]" class="form-control form-control-sm category-field" readonly>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][quantity]" value="1" min="0.01" step="0.01" class="form-control form-control-sm quantity" required>
                <div class="invalid-feedback">
                    Please enter a valid quantity.
                </div>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][discount]" step="0.01" value="0" min="0" max="100" class="form-control form-control-sm discount">
            </td>
            <td>
                <select class="form-select form-select-sm tax-group-select" name="items[${rowCount}][tax_group_id]" required>
                    <option value="" disabled selected>-- Select Tax Group --</option>
                    @foreach ($tax_groups as $group)
                        @if ($group->taxes->isNotEmpty())
                            @php
                                $totalRate = $group->taxes->sum('rate');
                                $cgstRate = $group->taxes->where('type', 'cgst')->first()->rate ?? $totalRate/2;
                                $sgstRate = $group->taxes->where('type', 'sgst')->first()->rate ?? $totalRate/2;
                            @endphp
                            <option value="{{ $group->id }}" 
                                data-cgst-rate="{{ $cgstRate }}"
                                data-sgst-rate="{{ $sgstRate }}"
                                data-total-rate="{{ $totalRate }}">
                                {{ $group->name }} ({{ $totalRate }}%)
                            </option>
                        @endif
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" name="items[${rowCount}][hsn]" class="form-control form-control-sm hsn-field" value="8418" required>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][rate]" step="0.01" value="0" min="0" class="form-control form-control-sm rate" required>
                <div class="invalid-feedback">
                    Please enter a valid rate.
                </div>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][cgst_amount]" step="0.01" value="0" class="form-control form-control-sm cgst-field" readonly>
                <input type="hidden" name="items[${rowCount}][cgst_rate]" value="0" class="cgst-rate">
            </td>
            <td>
                <input type="number" name="items[${rowCount}][sgst_amount]" step="0.01" value="0" class="form-control form-control-sm sgst-field" readonly>
                <input type="hidden" name="items[${rowCount}][sgst_rate]" value="0" class="sgst-rate">
            </td>
            <td>
                <div class="form-check">
                    <input class="form-check-input itc-eligible" type="checkbox" name="items[${rowCount}][eligible_for_itc]" value="1" checked>
                </div>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][amount]" value="0" class="form-control form-control-sm bg-light amount-field" readonly>
                <input type="hidden" name="items[${rowCount}][taxable_amount]" value="0" class="taxable-amount">
            </td>
            <td class="text-end">
                <button type="button" class="btn btn-sm btn-outline-danger remove-row">Remove</button>
            </td>
        `;
        tbody.appendChild(newRow);

        // Initialize Select2 for the new row
        $(newRow).find('.item-select').select2({
            width: '100%',
            minimumResultsForSearch: 10
        });

        rowCount++;
        calculateTotals();
    });

    // Remove row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            const row = e.target.closest('tr');
            if (document.querySelectorAll('#items-table tbody tr').length > 1) {
                row.remove();
                calculateTotals();
            } else {
                alert('You must have at least one item in the performa invoice.');
            }
        }
    });

    // Event delegation for item selection change
    $(document).on('change', '.item-select', function() {
        const row = $(this).closest('tr');
        const selectedOption = $(this).find('option:selected');

        if (selectedOption.length && selectedOption.val() !== '') {
            const categoryName = selectedOption.data('category-name') || '';
            const hsn = selectedOption.data('hsn') || '8418';
            const rate = selectedOption.data('rate') || '0';
            const taxGroupId = selectedOption.data('tax-group') || '';

            row.find('.category-field').val(categoryName);
            row.find('.hsn-field').val(hsn);
            row.find('.rate').val(parseFloat(rate).toFixed(2));

            // Set tax group if available
            if (taxGroupId) {
                row.find('.tax-group-select').val(taxGroupId).trigger('change');
            }

            calculateRowAmount(row[0]);
            calculateTotals();
        } else {
            row.find('.category-field').val('');
            row.find('.hsn-field').val('8418');
            row.find('.rate').val('0');
            calculateRowAmount(row[0]);
            calculateTotals();
        }
    });

    // Calculate amount when quantity, rate, discount, or tax group changes
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity') ||
            e.target.classList.contains('rate') ||
            e.target.classList.contains('discount')) {
            calculateRowAmount(e.target.closest('tr'));
            calculateTotals();
        }
    });

    // Handle tax group selection change
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('tax-group-select')) {
            calculateRowAmount(e.target.closest('tr'));
            calculateTotals();
        }
    });

    // Handle paid amount change
    document.getElementById('paid_amount').addEventListener('input', calculateTotals);

    // Function to calculate row amount including taxes
    function calculateRowAmount(row) {
        const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
        const rate = parseFloat(row.querySelector('.rate').value) || 0;
        const discountPercentage = parseFloat(row.querySelector('.discount').value) || 0;

        // Calculate taxable amount (after discount)
        const amountBeforeDiscount = quantity * rate;
        const discountAmount = amountBeforeDiscount * (discountPercentage / 100);
        const taxableAmount = amountBeforeDiscount - discountAmount;

        // Get tax rates from selected tax group
        const taxSelect = row.querySelector('.tax-group-select');
        const selectedOption = taxSelect ? taxSelect.options[taxSelect.selectedIndex] : null;
        
        let cgstRate = 0;
        let sgstRate = 0;

        if (selectedOption && selectedOption.dataset.cgstRate && selectedOption.dataset.sgstRate) {
            cgstRate = parseFloat(selectedOption.dataset.cgstRate) || 0;
            sgstRate = parseFloat(selectedOption.dataset.sgstRate) || 0;
        }

        // Calculate tax amounts
        const cgstAmount = taxableAmount * (cgstRate / 100);
        const sgstAmount = taxableAmount * (sgstRate / 100);
        const totalAmount = taxableAmount + cgstAmount + sgstAmount;

        // Update all fields
        row.querySelector('.taxable-amount').value = taxableAmount.toFixed(2);
        row.querySelector('.cgst-field').value = cgstAmount.toFixed(2);
        row.querySelector('.sgst-field').value = sgstAmount.toFixed(2);
        row.querySelector('.amount-field').value = totalAmount.toFixed(2);
        row.querySelector('.cgst-rate').value = cgstRate.toFixed(2);
        row.querySelector('.sgst-rate').value = sgstRate.toFixed(2);
    }

    // Function to calculate all totals
    function calculateTotals() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalCgst = 0;
        let totalSgst = 0;
        let totalTaxable = 0;

        document.querySelectorAll('#items-table tbody tr').forEach(row => {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const rate = parseFloat(row.querySelector('.rate').value) || 0;
            const discountPercentage = parseFloat(row.querySelector('.discount').value) || 0;

            const amountBeforeDiscount = quantity * rate;
            const discountAmount = amountBeforeDiscount * (discountPercentage / 100);
            const taxableAmount = amountBeforeDiscount - discountAmount;

            subtotal += amountBeforeDiscount;
            totalDiscount += discountAmount;
            totalTaxable += taxableAmount;

            const cgstAmount = parseFloat(row.querySelector('.cgst-field').value) || 0;
            const sgstAmount = parseFloat(row.querySelector('.sgst-field').value) || 0;

            totalCgst += cgstAmount;
            totalSgst += sgstAmount;
        });

        const grandTotal = totalTaxable + totalCgst + totalSgst;
        const paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;
        const dueAmount = Math.max(0, grandTotal - paidAmount);

        // Update display elements
        if (document.getElementById('subtotal')) {
            document.getElementById('subtotal').textContent = '₹' + subtotal.toFixed(2);
        }
        if (document.getElementById('total-discount')) {
            document.getElementById('total-discount').textContent = '₹' + totalDiscount.toFixed(2);
        }
        if (document.getElementById('total-cgst')) {
            document.getElementById('total-cgst').textContent = '₹' + totalCgst.toFixed(2);
        }
        if (document.getElementById('total-sgst')) {
            document.getElementById('total-sgst').textContent = '₹' + totalSgst.toFixed(2);
        }
        if (document.getElementById('grand-total')) {
            document.getElementById('grand-total').textContent = '₹' + grandTotal.toFixed(2);
        }
        if (document.getElementById('paid-amount-display')) {
            document.getElementById('paid-amount-display').textContent = '₹' + paidAmount.toFixed(2);
        }
        if (document.getElementById('due-amount')) {
            document.getElementById('due-amount').textContent = '₹' + dueAmount.toFixed(2);
        }

        // Update hidden fields if they exist
        const taxableAmountInput = document.getElementById('taxable_amount');
        const totalCgstInput = document.getElementById('total_cgst');
        const totalSgstInput = document.getElementById('total_sgst');
        
        if (taxableAmountInput) taxableAmountInput.value = totalTaxable.toFixed(2);
        if (totalCgstInput) totalCgstInput.value = totalCgst.toFixed(2);
        if (totalSgstInput) totalSgstInput.value = totalSgst.toFixed(2);
    }

    // Initialize calculations for existing rows on page load
    document.querySelectorAll('#items-table tbody tr').forEach(row => {
        calculateRowAmount(row);
    });
    calculateTotals();
});
</script>

@endsection