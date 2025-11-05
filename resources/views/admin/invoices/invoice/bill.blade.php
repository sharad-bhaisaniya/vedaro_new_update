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
        /* margin: 20px 0; */
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        color: #dc3545;
    }
    .paid-amount {

        padding: 15px;
        border-radius: 5px;
        /* margin: 20px 0; */
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
<style>
@media print {
    .sidebar,
    .sidebar-menu,
    aside {
        display: none !important;
    }
    /* If your layout uses #sidebar as an ID */
    #sidebar {
        display: none !important;
    }
    /* Optional: make invoice full width when printing */
    .main-content, .content, .container-fluid, .container {
        margin-left: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
    }
    body {
        padding: 0 !important;
    }
}
</style>


<div class="button-container no-print">
    <button onclick="window.print()">Print Invoice</button>
    {{-- <a href="{{ route('invoices.download', $invoice->id) }}">
        <button>Download as PDF</button>
    </a> --}}
</div>

<div class="invoice-container" id="invoiceArea">
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
        <div class="gstin">GSTIN: {{ $invoice->admin_gstin }}</div>
    </div>

        <div class="header-info-section info-section">
              <img src="https://vedaro.in/public/assets/images/VEDARO_logo.png"alt="Company Logo" style="width: 90px;">
                <div class="invoice-title">TAX INVOICE</div>

            <div class="info-label">Invoice #: <span class="header-span">{{ $invoice->invoice_number }}</span> </div>

            <div class="info-label" >Invoice Date: <span class="header-span"> {{ $invoice->invoice_date }}</span> </div>
            <div class="info-label">Customer ID #: <span class="header-span">{{ $invoice->user_id }}</span> </div>
        </div>
    </div>



    <div class="invoice-info mt-4">


        <div class="info-section d-flex justify-content-between">

            <div>

                <div class="info-label" >Bill To</div>
                <div>
                    {{ $invoice->customer_name }}<br>
                    {{ $invoice->customer_address ?? 'N/A' }}
                    <div class="gstin">GSTIN: {{ $invoice->customer_gstin ?? 'N/A' }}</div>
                </div>
            </div>
            <div>

                <div class="info-label">Order Number</div>
                <div>{{ $invoice->order_number ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between show-amounts">

        <div class="paid-amount ">
        Paid Amount: ₹ {{ number_format($invoice->paid_amount, 2) }}
    </div>

        <div class="due-amount">
        Due Amount: ₹ {{ number_format($invoice->due_amount, 2) }}
    </div>
    </div>


     @php
        // Check if any item has a discount greater than 0
        $hasDiscount = false;
        foreach ($invoice->items as $item) {
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
                @foreach ($invoice->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>
                            <?php
                            $category = App\Models\Category::where('id',$item->category)->first();
                            ?>
                            {{ $category->name }}
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹ {{ number_format($item->rate, 2) }}</td>

                        @if($hasDiscount)
                            <td>₹ {{ number_format($item->discount, 2) }}</td>
                        @endif

                        <td>
                            @forelse($item->tax_details as $tax)
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

    <!-- Rest of your invoice content -->




    @php
        $subTotal = 0;
        $taxTotal = 0;
        foreach ($invoice->items as $item) {
            $subTotal += $item->amount;
            $taxIds = is_string($item->taxes) ? json_decode($item->taxes, true) : $item->taxes;
            if (!is_array($taxIds)) $taxIds = [];
            $taxes = \App\Models\Tax::whereIn('id', $taxIds)->get();
            foreach ($taxes as $tax) {
                $taxTotal += ($item->amount * $tax->rate) / 100;
            }
        }
        $grandTotal = $subTotal;
    @endphp

    <div class="totals">
        <div class="total-row">
            <div>Sub Total</div>
            <div>₹ {{ number_format($grandTotal, 2) }}</div>
        </div>
        <div class="total-row">
            <div>Tax</div>
            <div>₹ {{ number_format($taxTotal, 2) }}</div>
        </div>
        <div class="total-row grand-total">
            <div>Grand Total</div>
            <div>₹ {{ number_format($invoice->total, 2) }}</div>
        </div>
    </div>

    <div class="terms">
        <div class="terms-title">Terms & Conditions</div>
        <ul class="terms-list">
            <li>All invoices are due and payable in advance or on due date.</li>
            <li>The invoice reflects the agreed services as per contract.</li>
            <li>Additional services will be charged separately.</li>
            <li>Full advance payment required for social media management.</li>
            <li>Development services require 40% advance payment.</li>
        </ul>
    </div>

    <div class="footer">
        Thank you for choosing Vedaro Jewellery. We appreciate your business!
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
