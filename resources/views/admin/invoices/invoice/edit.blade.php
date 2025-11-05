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
        <h4 class="mb-3 text-secondary">Edit Invoice</h4>

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

        <form action="{{ route('invoice.update', $invoice->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            {{-- Customer & Invoice Details --}}
            <div class="p-3 mb-4 border-bottom">
                <h6 class="h6 mb-2 text-uppercase text-secondary">Invoice Details</h6>
                <div class="row row-cols-1 row-cols-md-2 g-3">
                    <div class="col">
                        <label for="customer_name" class="form-label form-label-sm fw-bold text-muted">Customer Name*</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" value="{{ old('customer_name', $invoice->customer_name) }}" placeholder="Enter customer name" required readonly>
                        <div class="invalid-feedback">
                            Please select or add a customer.
                        </div>
                    </div>
                    <div class="col">
                        <label for="order_number" class="form-label form-label-sm fw-bold text-muted">Order Number*</label>
                        <input type="number" name="order_number" id="order_number" class="form-control form-control-sm" value="{{ old('order_number', $invoice->order_number) }}" placeholder="Enter order number" required readonly>
                        <div class="invalid-feedback">
                            Please enter an order number.
                        </div>
                    </div>
                    <div class="col">
                        <label for="invoice_date" class="form-label form-label-sm fw-bold text-muted">Invoice Date*</label>
                        <input type="date" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d')) }}" class="form-control form-control-sm" required readonly>
                        <div class="invalid-feedback">
                            Please select an invoice date.
                        </div>
                    </div>
                    <div class="col">
                        <label for="paid_amount" class="form-label form-label-sm fw-bold text-muted">Paid Amount (₹)*</label>
                        <input type="number" name="paid_amount" id="paid_amount" step="0.01" min="0" value="{{ old('paid_amount', $invoice->paid_amount) }}" class="form-control form-control-sm" required>
                        <div class="invalid-feedback">
                            Please enter a valid paid amount.
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col-md-12">
                                <label for="customer_address" class="form-label form-label-sm fw-bold text-muted">Customer Address</label>
                                <textarea readonly name="customer_address" id="customer_address" rows="2" class="form-control form-control-sm" placeholder="Enter street and locality">{{ old('customer_address', $invoice->customer_address) }}</textarea>
                            </div>
                            <div class="">
                                <div class="mb-2">
                                    <label for="customer_gstin" class="form-label form-label-sm fw-bold text-muted">Customer GSTIN</label>
                                    <input type="text" readonly name="customer_gstin" id="customer_gstin" class="form-control form-control-sm" value="{{ old('customer_gstin', $invoice->customer_gstin) }}" placeholder="Enter customer GSTIN">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label for="invoice_number" class="form-label form-label-sm fw-bold text-muted">Invoice#*</label>
                        <input type="text" id="invoice_number" value="{{ $invoice->invoice_number }}" name="invoice_number" class="form-control form-control-sm" readonly>
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
                                <th scope="col">IGST (₹)</th>
                                <th scope="col">Amount (₹)</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $index => $item)
                            <tr>
                                <td>
                                    <select name="items[{{ $index }}][item_id]" class="form-select form-select-sm item-select" required>
                                        <option value="" disabled>Select item</option>
                                        @foreach($items as $product)
                                            <option value="{{ $product->id }}"
                                                data-category-id="{{ $product->category_id }}"
                                                data-category-name="{{ $product->category}}"
                                                data-hsn="{{ $product->hsn ?? '' }}"
                                                data-rate="{{ $product->rate ?? '0' }}"
                                                {{ $item->item_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->productName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an item.
                                    </div>
                                </td>
                                <td>
                                    <input type="hidden" name="items[{{ $index }}][category_id]" class="category-id-field" value="{{ $item->category_id }}">
                                    <input type="text" class="form-control form-control-sm category-name-field" value="{{ $item->category }}" readonly>
                                </td>
                                <td>
                                    <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm quantity" required>
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
                                                <option value="{{ $group->id }}"
                                                    data-cgst-rate="{{ $group->taxes->where('tax_id', $group->taxes->where('type', 'CGST')->first()->tax_id ?? 0)->first()->rate ?? 0 }}"
                                                    data-igst-rate="{{ $group->taxes->where('tax_id', $group->taxes->where('type', 'IGST')->first()->tax_id ?? 0)->first()->rate ?? 0 }}"
                                                    {{ $item->tax_group_id == $group->id ? 'selected' : '' }}>
                                                    {{ $group->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a tax group.
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="items[{{ $index }}][hsn]" value="{{ $item->hsn }}" class="form-control form-control-sm hsn-field">
                                </td>
                                <td>
                                    <input type="number" name="items[{{ $index }}][rate]" step="0.01" value="{{ $item->rate }}" class="form-control form-control-sm rate" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid rate.
                                    </div>
                                </td>
                                <td>
                                    <input type="number" name="items[{{ $index }}][cgst]" step="0.01" value="{{ $item->cgst ?? 0 }}" class="form-control form-control-sm cgst-field" readonly>
                                </td>
                                <td>
                                    <input type="number" name="items[{{ $index }}][igst]" step="0.01" value="{{ $item->igst ?? 0 }}" class="form-control form-control-sm igst-field" readonly>
                                </td>
                                <td>
                                    <input type="number" name="items[{{ $index }}][amount]" value="{{ $item->amount }}" class="form-control form-control-sm bg-light amount-field" readonly>
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
                            <span class="text-muted small">Total IGST</span>
                            <span id="total-igst" class="fw-bold small">₹0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Grand Total</span>
                            <span id="grand-total" class="fw-bold small">₹0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end pt-3">
    <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-outline-secondary me-2">Cancel</a>
    <button type="submit" class="btn btn-sm btn-primary">Update Invoice</button>
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



{{-- update the taxes Like IGST and SGST on fields  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // A single function to calculate and update a row's totals
        function updateRowAndTotals(row) {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const rate = parseFloat(row.querySelector('.rate').value) || 0;
            const discountPercentage = parseFloat(row.querySelector('.discount').value) || 0;

            const amountBeforeDiscount = quantity * rate;
            const discountAmount = amountBeforeDiscount * (discountPercentage / 100);
            const amountAfterDiscount = amountBeforeDiscount - discountAmount;

            const taxSelect = row.querySelector('.tax-group-select');
            const selectedOption = taxSelect ? taxSelect.options[taxSelect.selectedIndex] : null;

            let cgstRate = 0;
            let igstRate = 0;
            if (selectedOption) {
                cgstRate = parseFloat(selectedOption.getAttribute('data-cgst-rate')) || 0;
                igstRate = parseFloat(selectedOption.getAttribute('data-igst-rate')) || 0;
            }

            let cgstAmount = 0;
            let igstAmount = 0;

            // Apply either IGST or CGST/SGST based on the rates available
            if (igstRate > 0) {
                igstAmount = amountAfterDiscount * (igstRate / 100);
                cgstAmount = amountAfterDiscount * (cgstRate / 100);
            } else {
                igstAmount = 0;
                cgstAmount = 0;
            }

            const finalAmount = amountAfterDiscount + cgstAmount + igstAmount;

            // Update row fields
            row.querySelector('.cgst-field').value = cgstAmount.toFixed(2);
            row.querySelector('.igst-field').value = igstAmount.toFixed(2);
            row.querySelector('.amount-field').value = finalAmount.toFixed(2);

            // Trigger grand totals recalculation
            calculateGrandTotals();
        }

        // A separate function to handle grand total calculations
        function calculateGrandTotals() {
            let subtotal = 0;
            let totalDiscount = 0;
            let totalCgst = 0;
            let totalIgst = 0;

            document.querySelectorAll('#items-table tbody tr').forEach(row => {
                const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                const rate = parseFloat(row.querySelector('.rate').value) || 0;
                const discountPercentage = parseFloat(row.querySelector('.discount').value) || 0;
                const amountBeforeDiscount = quantity * rate;
                const discountAmount = amountBeforeDiscount * (discountPercentage / 100);
                const amountAfterDiscount = amountBeforeDiscount - discountAmount;
                const cgst = parseFloat(row.querySelector('.cgst-field').value) || 0;
                const igst = parseFloat(row.querySelector('.igst-field').value) || 0;

                subtotal += amountAfterDiscount;
                totalDiscount += discountAmount;
                totalCgst += cgst;
                totalIgst += igst;
            });

            const grandTotal = subtotal + totalCgst + totalIgst;

            // Update display elements
            document.getElementById('subtotal').textContent = '₹' + subtotal.toFixed(2);
            document.getElementById('total-discount').textContent = '₹' + totalDiscount.toFixed(2);
            document.getElementById('total-cgst').textContent = '₹' + totalCgst.toFixed(2);
            document.getElementById('total-igst').textContent = '₹' + totalIgst.toFixed(2);
            document.getElementById('grand-total').textContent = '₹' + grandTotal.toFixed(2);
        }

        // Add event listeners to trigger recalculation
        document.addEventListener('change', function(e) {
            const row = e.target.closest('tr');
            if (row) {
                if (e.target.classList.contains('tax-group-select')) {
                    updateRowAndTotals(row);
                }
            }
        });

        document.addEventListener('input', function(e) {
            const row = e.target.closest('tr');
            if (row) {
                if (e.target.classList.contains('quantity') || e.target.classList.contains('rate') || e.target.classList.contains('discount')) {
                    updateRowAndTotals(row);
                }
            }
        });

        // Initial calculation on page load
        document.querySelectorAll('#items-table tbody tr').forEach(row => {
            updateRowAndTotals(row);
        });
    });
</script>



{{-- script for add a new line  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowCount = {{ count($invoice->items) }};

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
                            <option value="{{ $product->id }}"
                                data-category-id="{{ $product->category_id }}"
                                data-category-name="{{ $product->category}}"
                                data-hsn="{{ $product->hsn ?? '' }}"
                                data-rate="{{ $product->rate ?? '0' }}">
                                {{ $product->productName }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Please select an item.
                    </div>
                </td>
                <td>
                    <input type="hidden" name="items[${rowCount}][category_id]" class="category-id-field" value="">
                    <input type="text" class="form-control form-control-sm category-name-field" value="" readonly>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][quantity]" value="1" min="1" class="form-control form-control-sm quantity" required>
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
                                <option value="{{ $group->id }}"
                                    data-cgst-rate="{{ $group->taxes->where('tax_id', $group->taxes->where('type', 'CGST')->first()->tax_id ?? 0)->first()->rate ?? 0 }}"
                                    data-igst-rate="{{ $group->taxes->where('tax_id', $group->taxes->where('type', 'IGST')->first()->tax_id ?? 0)->first()->rate ?? 0 }}">
                                    {{ $group->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Please select a tax group.
                    </div>
                </td>
                <td>
                    <input type="text" name="items[${rowCount}][hsn]" class="form-control form-control-sm hsn-field">
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][rate]" step="0.01" class="form-control form-control-sm rate" required>
                    <div class="invalid-feedback">
                        Please enter a valid rate.
                    </div>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][cgst]" step="0.01" class="form-control form-control-sm cgst-field" readonly>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][igst]" step="0.01" class="form-control form-control-sm igst-field" readonly>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][amount]" class="form-control form-control-sm bg-light amount-field" readonly>
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
                    alert('You must have at least one item in the invoice.');
                }
            }
        });

        // Event delegation for item selection change
        $(document).on('change', '.item-select', function() {
            const row = $(this).closest('tr');
            const selectedOption = $(this).find('option:selected');

            if (selectedOption.length && selectedOption.val() !== '') {
                const categoryId = selectedOption.data('category-id') || '';
                const categoryName = selectedOption.data('category-name') || '';
                const hsn = selectedOption.data('hsn') || '';
                const rate = selectedOption.data('rate') || '0';

                row.find('.category-id-field').val(categoryId);
                row.find('.category-name-field').val(categoryName);
                row.find('.hsn-field').val(hsn);
                row.find('.rate').val(parseFloat(rate).toFixed(2));

                calculateRowAmount(row[0]);
                calculateTotals();
            } else {
                row.find('.category-id-field').val('');
                row.find('.category-name-field').val('');
                row.find('.hsn-field').val('');
                row.find('.rate').val('');
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
                const row = e.target.closest('tr');
                const selectedOption = e.target.options[e.target.selectedIndex];
                if (selectedOption) {
                    let cgstRate = parseFloat(selectedOption.getAttribute('data-cgst-rate')) || 0;
                    let igstRate = parseFloat(selectedOption.getAttribute('data-igst-rate')) || 0;
                    let quantity = parseFloat(row.querySelector('.quantity').value) || 1;
                    let rate = parseFloat(row.querySelector('.rate').value) || 0;
                    let discountPercentage = parseFloat(row.querySelector('.discount').value) || 0;

                    const amountBeforeDiscount = quantity * rate;
                    const discountAmount = amountBeforeDiscount * (discountPercentage / 100);
                    const amountAfterDiscount = amountBeforeDiscount - discountAmount;

                    let cgstAmount = amountAfterDiscount * (cgstRate / 100);
                    let igstAmount = amountAfterDiscount * (igstRate / 100);
                    const finalAmount = amountAfterDiscount + cgstAmount + igstAmount;

                    row.querySelector('.cgst-field').value = cgstAmount.toFixed(2);
                    row.querySelector('.igst-field').value = igstAmount.toFixed(2);
                    row.querySelector('.amount-field').value = finalAmount.toFixed(2);

                    calculateTotals();
                }
            }
        });

        // Function to calculate row amount including taxes
        function calculateRowAmount(row) {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 1;
            const rate = parseFloat(row.querySelector('.rate').value) || 0;
            const discountPercentage = parseFloat(row.querySelector('.discount').value) || 0;

            const amountBeforeDiscount = quantity * rate;
            const discountAmount = amountBeforeDiscount * (discountPercentage / 100);
            const amountAfterDiscount = amountBeforeDiscount - discountAmount;

            const taxSelect = row.querySelector('.tax-group-select');
            const selectedOption = taxSelect.options[taxSelect.selectedIndex];
            let cgstRate = 0;
            let igstRate = 0;

            if (selectedOption) {
                cgstRate = parseFloat(selectedOption.getAttribute('data-cgst-rate')) || 0;
                igstRate = parseFloat(selectedOption.getAttribute('data-igst-rate')) || 0;
            }

            const cgstAmount = amountAfterDiscount * (cgstRate / 100);
            const igstAmount = amountAfterDiscount * (igstRate / 100);

            const finalAmount = amountAfterDiscount + cgstAmount + igstAmount;

            row.querySelector('.cgst-field').value = cgstAmount.toFixed(2);
            row.querySelector('.igst-field').value = igstAmount.toFixed(2);
            row.querySelector('.amount-field').value = finalAmount.toFixed(2);
        }

        // Function to calculate all totals
        function calculateTotals() {
            let subtotal = 0;
            let totalDiscount = 0;
            let totalCgst = 0;
            let totalIgst = 0;
            let grandTotal = 0;

            document.querySelectorAll('#items-table tbody tr').forEach(row => {
                const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                const rate = parseFloat(row.querySelector('.rate').value) || 0;
                const discountPercentage = parseFloat(row.querySelector('.discount').value) || 0;

                const amountBeforeDiscount = quantity * rate;
                const discountAmount = amountBeforeDiscount * (discountPercentage / 100);
                const amountAfterDiscount = amountBeforeDiscount - discountAmount;

                subtotal += amountAfterDiscount;
                totalDiscount += discountAmount;

                const cgst = parseFloat(row.querySelector('.cgst-field').value);
                const igst = parseFloat(row.querySelector('.igst-field').value);

                totalCgst += cgst;
                totalIgst += igst;
            });

            grandTotal = subtotal + totalCgst + totalIgst;

            document.getElementById('subtotal').textContent = '₹' + subtotal.toFixed(2);
            document.getElementById('total-discount').textContent = '₹' + totalDiscount.toFixed(2);
            document.getElementById('total-cgst').textContent = '₹' + totalCgst.toFixed(2);
            document.getElementById('total-igst').textContent = '₹' + totalIgst.toFixed(2);
            document.getElementById('grand-total').textContent = '₹' + grandTotal.toFixed(2);
        }

        // Initial calculation
        calculateTotals();
    });
</script>

@endsection
