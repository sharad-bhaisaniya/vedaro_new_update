@extends('layouts.admin_lay')

@section('content')
<style>
    .invoice-container {
        max-width: 845px;
        margin: 0 auto;
        background-color: white;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 30px;
    }
    .invoice-container .main-header{
        border-bottom: 2px solid #e9ecef;
    }
    .header-bill {
        text-align: left;
        margin-bottom: 30px;
    }
    .header-info-section{
        text-align: end;
    }
    .header-span{
        color: gray;
        font-size: 15px;
        font-weight: 600;
    }
    .company-name {
        font-size: 28px;
        font-weight: bold;
        color: #d4af37;
        margin-bottom: 10px;
    }
    .company-details {
        line-height: 1.6;
        color: #6c757d;
    }
    .invoice-title {
        font-size: 22px;
        font-weight: bold;
        margin: 12px 0 15px;
        color: #343a40;
    }
    .invoice-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 25px;
        flex-wrap: wrap;
        border-bottom: 2px solid #eff2f4;
        padding:10px 5px;
    }
    .info-section {
        flex: 1;
        min-width: 250px;
        margin-bottom: 15px;
    }
    .info-label {
        font-weight: bold;
        margin-bottom: 5px;
        color: #495057;
    }
    .due-amount {
        padding: 15px;
        border-radius: 5px;
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        color: #dc3545;
    }
    .paid-amount {
        padding: 15px;
        border-radius: 5px;
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        color: #18a234;
    }
    .show-amounts{
        background-color: #f8f9fa;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    th {
        background-color: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
    }
    td {
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
    }
    .totals {
        margin-left: auto;
        width: 300px;
        margin-top: 20px;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
    }
    .grand-total {
        font-weight: bold;
        font-size: 18px;
        border-top: 2px solid #dee2e6;
        padding-top: 10px;
        margin-top: 5px;
    }
    .terms {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #dee2e6;
    }
    .terms-title {
        font-weight: bold;
        margin-bottom: 10px;
        color: #495057;
    }
    .terms-list {
        padding-left: 20px;
        color: #6c757d;
    }
    .terms-list li {
        margin-bottom: 8px;
    }
    .footer {
        text-align: center;
        margin-top: 30px;
        color: #6c757d;
        font-style: italic;
    }
    .gstin {
        font-weight: bold;
        color: #495057;
        margin-top: 5px;
    }
    .performa-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        font-size: 80px;
        color: rgba(0, 0, 0, 0.1);
        font-weight: bold;
        z-index: 1;
        pointer-events: none;
    }
    .invoice-content {
        position: relative;
        z-index: 2;
    }
    @media print {
        body {
            background-color: white;
            padding: 0;
        }
        .invoice-container {
            box-shadow: none;
            padding: 0;
        }
        .no-print {
            display: none;
        }
        .sidebar,
        .sidebar-menu,
        aside {
            display: none !important;
        }
        #sidebar {
            display: none !important;
        }
        .main-content, .content, .container-fluid, .container {
            margin-left: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }
        body {
            padding: 0 !important;
        }
    }
    .button-container {
        text-align: center;
        margin-bottom: 20px;
    }
    button {
        background-color: #d4af37;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        margin: 0 10px;
        transition: background-color 0.3s;
    }
    button:hover {
        background-color: #b8941f;
    }
</style>

<div class="button-container no-print">
    <button onclick="window.print()">Print Performa Invoice</button>
</div>

<div class="invoice-container" id="invoiceArea">
    <div class="performa-watermark">PROFORMA</div>
    <div class="invoice-content">
        <div class="d-flex main-header align-items-baseline">
            <div class="header-bill">
                <div class="company-name">Vedaro Jewellery</div>
                <div class="company-details">
                    Indore, Madhya Pradesh - 462026<br>
                    India<br>
                    Phone: 8817440858<br>
                    Email: info@vedaro.in<br>
                    Website: www.vedaro.in
                </div>
                <!--<div class="gstin">GSTIN: {{ $performaInvoice->admin_gstin ?? 'N/A' }}</div>-->
                @if(!empty($performaInvoice->admin_gstin))
                    <div class="gstin">GSTIN: {{ $performaInvoice->admin_gstin }}</div>
                @endif
            </div>

            <div class="header-info-section info-section">
                <img src="https://vedaro.in/public/assets/images/VEDARO_logo.png" alt="Company Logo" style="width: 90px;">
                <div class="invoice-title">PROFORMA INVOICE</div>

                <div class="info-label">Proforma Invoice #: <span class="header-span">{{ $performaInvoice->performa_number }}</span> </div>

                <div class="info-label">Proforma Invoice Date: <span class="header-span"> {{ $performaInvoice->performa_date }}</span> </div>
                <div class="info-label">Order Number: <span class="header-span"> {{ $performaInvoice->order_number ?? 'N/A' }}</span> </div>
                <!--<div class="info-label">Customer ID #: <span class="header-span">{{ $performaInvoice->user_id }}</span> </div>-->
            </div>
        </div>

        <div class="invoice-info mt-4">
            <div class="info-section d-flex justify-content-between">
                <div>
                    <div class="info-label">Bill To</div>
                    <div>
                        {{ $performaInvoice->customer_name }}<br>
                        {{ $performaInvoice->customer_address ?? 'N/A' }}
                        <div class="gstin">GSTIN: {{ $performaInvoice->customer_gstin ?? 'N/A' }}</div>
                    </div>
                </div>
                <div>
                    <div class="info-label">Order Number</div>
                    <div>{{ $performaInvoice->order_number ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between show-amounts">
            <div class="paid-amount">
                Advance Amount: ₹ {{ number_format($performaInvoice->paid_amount ?? 0, 2) }}
            </div>
            <div class="due-amount">
                Balance Amount: ₹ {{ number_format($performaInvoice->due_amount ?? 0, 2) }}
            </div>
        </div>

        @php
            // Check if any item has a discount greater than 0
            $hasDiscount = false;
            foreach ($performaInvoice->items as $item) {
                if ($item->discount > 0) {
                    $hasDiscount = true;
                    break;
                }
            }
        @endphp

        <div class="table-responsive mb-4">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Qty</th>
                        <th>Rate</th>

                        @if($hasDiscount)
                            <th>Discount</th>
                        @endif

                        <th>Tax</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($performaInvoice->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->item_name }}</td>
                           <td>
                                    @php
                                        $categoryName = $item->category;
                                        
                                        // If category is numeric, it's likely an ID
                                        if (is_numeric($item->category)) {
                                            $category = App\Models\Category::find($item->category);
                                            $categoryName = $category->name ?? $item->category;
                                        }
                                        // If it's already a string, use it directly
                                        else {
                                            $categoryName = $item->category;
                                        }
                                    @endphp
                                    {{ $categoryName ?? 'N/A' }}
                                </td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹ {{ number_format($item->rate, 2) }}</td>

                            @if($hasDiscount)
                                <td>₹ {{ number_format($item->discount, 2) }}</td>
                            @endif

                           <td>
                                @php
                                    $taxIds = is_string($item->taxes) ? json_decode($item->taxes, true) : $item->taxes;
                                    $taxes = !empty($taxIds) && is_array($taxIds) ? \App\Models\Tax::whereIn('id', $taxIds)->get() : collect();
                                @endphp
                                
                                @forelse($taxes as $tax)
                                    <span>{{ $tax->name }} ({{ $tax->rate }}%)</span><br>
                                @empty
                                    0.00
                                @endforelse
                            </td>
                            <td>₹ {{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @php
            $subTotal = 0;
            $taxTotal = 0;
            foreach ($performaInvoice->items as $item) {
                $subTotal += $item->amount;
                $taxIds = is_string($item->taxes) ? json_decode($item->taxes, true) : $item->taxes;
                if (!is_array($taxIds)) $taxIds = [];
                $taxes = \App\Models\Tax::whereIn('id', $taxIds)->get();
                foreach ($taxes as $tax) {
                    $taxTotal += ($item->amount * $tax->rate) / 100;
                }
            }
            $grandTotal = $subTotal + $taxTotal;
        @endphp

        <div class="totals">
            <div class="total-row">
                <div>Sub Total</div>
                <div>₹ {{ number_format($subTotal, 2) }}</div>
            </div>
            <div class="total-row">
                <div>Tax</div>
                <div>₹ {{ number_format($taxTotal, 2) }}</div>
            </div>
            <div class="total-row grand-total">
                <div>Grand Total</div>
                <div>₹ {{ number_format($performaInvoice->total, 2) }}</div>
            </div>
        </div>

        <div class="terms">
            <div class="terms-title">Proforma Invoice Terms & Conditions</div>
            <ul class="terms-list">
                <li>This is a PROFORMA INVOICE and not a demand for payment.</li>
                <li>This invoice is valid for 30 days from the date of issue.</li>
                <li>Goods will be dispatched only after receipt of full/advance payment as agreed.</li>
                <li>Prices are subject to change without prior notice.</li>
                <li>Taxes will be applicable as per prevailing laws at the time of final invoice.</li>
                <li>Final tax invoice will be issued upon receipt of payment.</li>
            </ul>
        </div>

        <div class="footer">
            This is a proforma invoice. No payment should be made against this invoice unless converted to a tax invoice.
        </div>
    </div>
</div>

<script>
    function printInvoice() {
        let printContents = document.getElementById("invoiceArea").innerHTML;
        let originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection