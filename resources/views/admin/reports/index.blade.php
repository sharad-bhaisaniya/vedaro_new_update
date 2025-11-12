@extends('layouts.admin_lay')

@section('title', 'Sales, Purchase & Inventory Reports Dashboard')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            transition: var(--transition);
        }

        .reports-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .report-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            margin-bottom: 20px;
            transition: var(--transition);
            border-left: 5px solid var(--primary);
        }

        .report-card.sales { border-left-color: #00b894; } /* Green for Sales */
        .report-card.purchase { border-left-color: var(--primary); } /* Blue for Purchase */
        .report-card.inventory { border-left-color: #ff9f43; } /* Orange for Inventory */

        .kpi-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .kpi-title {
            font-size: 1.1rem;
            color: var(--gray);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .kpi-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .chart-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            margin-bottom: 30px;
        }

        .chart-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .chart-half {
            flex: 1;
            min-width: 45%;
            height: 350px; /* Fixed height for charts */
            margin-bottom: 20px;
        }
        
        /* New Style for Tables (to override the fixed height for charts) */
        .table-half {
             min-width: 45%;
             flex: 1;
        }
        .table-half .chart-container {
            height: auto; /* Allow tables to take natural height */
            min-height: 350px; /* Keep minimum height for visual balance */
        }


        .table-responsive {
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .table th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
        }
        .table-sales th {
            background-color: #00b894; /* Sales color */
        }
        .table-purchase th {
            background-color: var(--primary); /* Purchase color */
        }

        /* Date Filter Styles */
        .date-filter-form {
            display: flex;
            gap: 15px;
            align-items: flex-end;
            background-color: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            border-left: 5px solid var(--info);
        }
        .date-filter-form label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
            display: block;
        }
        .date-filter-form input[type="date"] {
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            transition: border-color 0.3s;
            width: 100%;
        }
        .date-filter-form button {
            background-color: var(--info);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            height: 42px;
            min-width: 120px;
            cursor: pointer;
        }
        .date-filter-form button:hover {
            background-color: var(--secondary);
        }

        .card-group-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 15px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }
        .btn-sm.active {
                background-color: #00b894 !important;
                color: #fff !important;
            }
            .table-half .chart-container {
                border-radius: 10px;
            }
            .table-half table th, .table-half table td {
                white-space: nowrap;
            }
            .chart-container::-webkit-scrollbar {
                width: 6px;
            }
            .chart-container::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 10px;
            }


    </style>

    <div class="main-content">
        <div class="reports-header">
            <h1>Comprehensive Reports Dashboard</h1>
        </div>

        {{-- Date Filter Form --}}
        <form method="GET" action="{{ route('reports.index') }}" class="date-filter-form">
            <div style="flex-grow: 1; max-width: 250px;">
                <label for="from_date"><i class="fas fa-calendar-alt"></i> From Date</label>
                <input type="date" id="from_date" name="from_date" value="{{ $fromDate ?? '' }}" required>
            </div>
            <div style="flex-grow: 1; max-width: 250px;">
                <label for="to_date"><i class="fas fa-calendar-alt"></i> To Date</label>
                <input type="date" id="to_date" name="to_date" value="{{ $toDate ?? '' }}" required>
            </div>
            <div>
                <button type="submit">Filter Reports</button>
            </div>
        </form>

        {{-- Sales & Purchase KPIs --}}
        <h2 class="card-group-title" style="color: #00b894;">Sales (Sell) Metrics</h2>
        <div class="kpi-container">
            <div class="report-card sales">
                <div class="kpi-title"><i class="fas fa-chart-line fa-fw mr-2"></i> Total Revenue</div>
                <div class="kpi-value">₹{{ $totalRevenue }}</div>
                <small class="text-success">Combined Online Orders & Offline Invoices</small>
            </div>
            <div class="report-card sales">
                <div class="kpi-title"><i class="fas fa-receipt fa-fw mr-2"></i> Total Sales Count</div>
                <div class="kpi-value">{{ $salesCount }}</div>
                <small class="text-success">Total number of sales transactions</small>
            </div>
            <div class="report-card sales">
                <div class="kpi-title"><i class="fas fa-dollar-sign fa-fw mr-2"></i> Avg. Sale Value</div>
                <div class="kpi-value">₹{{ $averageSaleValue }}</div>
                <small class="text-success">Revenue / Sales Count</small>
            </div>
        </div>

        <h2 class="card-group-title" style="color: var(--primary);">Purchase (Buy) Metrics</h2>
        <div class="kpi-container">
             <div class="report-card purchase">
                <div class="kpi-title"><i class="fas fa-shopping-cart fa-fw mr-2"></i> Total Spend</div>
                <div class="kpi-value">₹{{ $totalSpend }}</div>
                <small class="text-primary">Total amount spent on purchases</small>
            </div>
            <div class="report-card purchase">
                <div class="kpi-title"><i class="fas fa-truck-loading fa-fw mr-2"></i> Purchase Count</div>
                <div class="kpi-value">{{ $purchaseCount }}</div>
                <small class="text-primary">Total number of purchase transactions</small>
            </div>
             <div class="report-card purchase">
                <div class="kpi-title"><i class="fas fa-money-bill-wave fa-fw mr-2"></i> Avg. Purchase Value</div>
                <div class="kpi-value">₹{{ $averagePurchaseValue }}</div>
                <small class="text-primary">Spend / Purchase Count</small>
            </div>
        </div>

        {{-- Inventory KPIs --}}
        <h2 class="card-group-title" style="color: #ff9f43;">Inventory Stock</h2>
        <div class="kpi-container">
             <div class="report-card inventory">
                <div class="kpi-title"><i class="fas fa-warehouse fa-fw mr-2"></i> Total Items In Stock</div>
                <div class="kpi-value">{{ $totalCurrentStock }}</div>
                <small style="color: #ff9f43;">Sum of all product stocks</small>
            </div>
             <div class="report-card inventory">
                <div class="kpi-title"><i class="fas fa-cubes fa-fw mr-2"></i> Products With Stock</div>
                <div class="kpi-value">{{ $productsInStock }}</div>
                <small style="color: #ff9f43;">Number of unique products available</small>
            </div>
        </div>

        {{-- PROFIT & LOSS SECTION --}}
{{-- <div class="mt-2 mb-2 card shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.3rem; color: #0984e3;">
            <i class="fas fa-chart-line me-2"></i> Profit & Loss Summary
        </h3>
    </div>

    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="p-3 border rounded bg-light">
                <h5 class="text-muted mb-1">Total Revenue</h5>
                <h3 class="text-success">₹{{ $totalRevenue }}</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="p-3 border rounded bg-light">
                <h5 class="text-muted mb-1">Total Spend</h5>
                <h3 class="text-danger">₹{{ $totalSpend }}</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="p-3 border rounded {{ $isProfit ? 'bg-success bg-opacity-25' : 'bg-danger bg-opacity-25' }}">
                <h5 class="text-muted mb-1">{{ $isProfit ? 'Net Profit' : 'Net Loss' }}</h5>
                <h3 class="{{ $isProfit ? 'text-success' : 'text-danger' }}">
                    ₹{{ $profitLossAmount }}
                </h3>
                <span class="fw-bold {{ $isProfit ? 'text-success' : 'text-danger' }}">
                    {{ $profitLossPercentage }}%
                </span>
            </div>
        </div>
    </div>
</div> --}}
{{-- FILTER & CHART SECTION --}}
<div class="card shadow-sm p-4 mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.3rem; color: #0984e3;">
            <i class="fas fa-chart-bar me-2"></i> Purchase vs Sales Chart
        </h3>

        <form action="{{ route('reports.index') }}" method="GET" class="d-flex align-items-center gap-2">
            <div>
                <label for="from_date" class="form-label mb-0 small text-muted">From:</label>
                <input type="month" id="from_date" name="from_date"
                       value="{{ \Carbon\Carbon::parse($fromDate)->format('Y-m') }}"
                       class="form-control form-control-sm">
            </div>
            <div>
                <label for="to_date" class="form-label mb-0 small text-muted">To:</label>
                <input type="month" id="to_date" name="to_date"
                       value="{{ \Carbon\Carbon::parse($toDate)->format('Y-m') }}"
                       class="form-control form-control-sm">
            </div>
            <button type="submit" class="btn btn-primary btn-sm mt-3">
                <i class="bi bi-filter"></i> Filter
            </button>
        </form>
    </div>

    <div>
        <canvas id="purchaseSalesChart" height="100"></canvas>
    </div>
</div>



        {{-- Charts (50/50 Layout) --}}
        <h2 class="card-group-title">Monthly Comparison</h2>
        <div class="chart-row">
            <div class="chart-half chart-container">
                <h3 style="font-size: 1.2rem; margin-bottom: 15px; color: var(--primary);">Monthly Purchase Trend (₹)</h3>
                <canvas id="purchaseChart"></canvas>
            </div>
            <div class="chart-half chart-container">
                <h3 style="font-size: 1.2rem; margin-bottom: 15px; color: #00b894;">Monthly Sales Trend (₹)</h3>
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        
   {{-- SALES & PURCHASE RECENT TABLES (50/50 Layout) --}}
<h2 class="card-group-title" style="margin-top: 30px;">Recent Activity Overview (Last 5)</h2>
<div class="chart-row d-flex gap-3 flex-wrap">

    {{-- Recent Sales Table (50%) --}}
    <div class="table-half flex-fill">
        <div class="chart-container card p-3 shadow-sm" style="height: 520px; overflow: hidden; display: flex; flex-direction: column;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 style="font-size: 1.2rem; color: #00b894; display: flex; align-items: center;">
                    <i class="fas fa-handshake fa-fw me-2"></i> Sales Details
                </h3>
                <div>
                    <button id="btnOffline" class="btn btn-sm btn-outline-primary active">Offline</button>
                    <button id="btnOnline" class="btn btn-sm btn-outline-success">Online</button>
                </div>
            </div>

            {{-- Filter Controls --}}
            <div class="d-flex gap-2 mb-3 flex-wrap">
                <input type="date" id="filterStart" class="form-control form-control-sm" style="max-width: 150px;">
                <input type="date" id="filterEnd" class="form-control form-control-sm" style="max-width: 150px;">
                <input type="number" id="filterMinAmount" class="form-control form-control-sm" placeholder="Min ₹" style="max-width: 100px;">
                <input type="number" id="filterMaxAmount" class="form-control form-control-sm" placeholder="Max ₹" style="max-width: 100px;">
                <button id="btnApplyFilter" class="btn btn-sm btn-info text-white"><i class="fas fa-filter"></i></button>
                <button id="btnClearFilter" class="btn btn-sm btn-secondary"><i class="fas fa-undo"></i></button>
            </div>

            {{-- Tables --}}
            <div style="flex: 1; overflow-y: auto;">
                <div id="offlineTable">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="table-sales">
                                    <th>Invoice ID</th>
                                    <th>Customer</th>
                                    <th>Total (₹)</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $invoice)
                                    <tr>
                                        <td>#{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->customer_name ?? 'N/A' }}</td>
                                        <td>{{ number_format($invoice->total, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4">No offline invoices found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="onlineTable" style="display:none;">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="table-sales">
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total (₹)</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>#{{ $order->order_number ?? $order->id }}</td>
                                        <td>{{ $order->customer_name ?? 'N/A' }}</td>
                                        <td>{{ number_format($order->amount, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4">No online orders found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Purchase Table (50%) --}}
    <div class="table-half flex-fill">
        <div class="chart-container card p-3 shadow-sm" style="height: 520px; overflow: hidden; display: flex; flex-direction: column;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 style="font-size: 1.2rem; color: var(--primary); display: flex; align-items: center;">
                    <i class="fas fa-box-open fa-fw me-2"></i> Purchase / Receipts
                </h3>
                <div>
                     <a href="{{ route('reports.purchases.export') }}" class="btn btn-success">
                        <i class="bi bi-download"></i> Download CSV
                    </a>
                    <button id="btnPurchaseFilter" class="btn btn-sm btn-outline-info">Filter</button>
                    <button id="btnPurchaseClear" class="btn btn-sm btn-outline-secondary">Clear</button>
                </div>
            </div>

            {{-- Purchase Filter Controls --}}
            <div id="purchaseFilterPanel" class="d-flex gap-2 mb-3 flex-wrap" style="display: none;">
                <input type="date" id="purchaseStart" class="form-control form-control-sm" style="max-width: 150px;">
                <input type="date" id="purchaseEnd" class="form-control form-control-sm" style="max-width: 150px;">
                <input type="number" id="purchaseMin" class="form-control form-control-sm" placeholder="Min ₹" style="max-width: 100px;">
                <input type="number" id="purchaseMax" class="form-control form-control-sm" placeholder="Max ₹" style="max-width: 100px;">
            </div>

            {{-- Purchase Table --}}
            <div style="flex: 1; overflow-y: auto;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="table-purchase">
                                <th>Receipt ID</th>
                                <th>Supplier</th>
                                <th>Spend (₹)</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allPurchases as $purchase)
                                <tr>
                                    <td>#{{ $purchase->invoice_number }}</td>
                                    <td>{{ $purchase->vendor->display_name }}</td>
                                    <td>{{ number_format($purchase->grand_total, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($purchase->invoice_date)->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">No recent purchases found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




     {{-- ================== LOW INVENTORY STOCK SECTION ================== --}}
    <div class="chart-container mt-4">
        <h2 style="font-size: 1.4rem; font-weight:600; margin-bottom: 20px;">
            <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
            Current Low Inventory Stock (Below 5 Units)
        </h2>
    
        @php
            use App\Models\Product;
            use App\Models\ProductVariant;
    
            // Use paginate instead of get()
            $products = Product::orderBy('current_stock', 'asc')->paginate(10);
            $lowStockFound = false;
        @endphp
    
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-danger">
                    <tr>
                        <th>Product Name</th>
                        <th>Type</th>
                        <th>Variant Size / ID</th>
                        <th>Current Stock</th>
                        <th>Total Stock</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        @if ($product->product_type === 'variant')
                            @php
                                $variants = ProductVariant::where('product_id', $product->id)->get();
                            @endphp
    
                            @foreach ($variants as $variant)
                                @if ($variant->stock < 5)
                                    @php
                                        $lowStockFound = true;
                                        $status = $variant->stock > 5
                                            ? 'Good'
                                            : ($variant->stock > 0 ? 'Low' : 'Out of Stock');
                                        $statusColor = $variant->stock > 5
                                            ? 'green'
                                            : ($variant->stock > 0 ? 'orange' : 'red');
                                    @endphp
                                    <tr>
                                        <td>{{ $product->productName }}</td>
                                        <td><span class="badge bg-info">Variant</span></td>
                                        <td>
                                            Size: <strong>{{ $variant->size ?? 'N/A' }}</strong><br>
                                            <!--ID: <small class="text-muted">{{ $variant->id }}</small>-->
                                        </td>
                                        <td>{{ $variant->stock }}</td>
                                        <td>{{ $product->total_stock ?? '—' }}</td>
                                        <td>₹{{ number_format($variant->discount_price ?? $variant->price, 2) }}</td>
                                        <td style="color: {{ $statusColor }}; font-weight: 600;">{{ $status }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            @if ($product->current_stock < 5)
                                @php
                                    $lowStockFound = true;
                                    $status = $product->current_stock > 5
                                        ? 'Good'
                                        : ($product->current_stock > 0 ? 'Low' : 'Out of Stock');
                                    $statusColor = $product->current_stock > 5
                                        ? 'green'
                                        : ($product->current_stock > 0 ? 'orange' : 'red');
                                @endphp
                                <tr>
                                    <td>{{ $product->productName }}</td>
                                    <td><span class="badge bg-secondary">Simple</span></td>
                                    <td>—</td>
                                    <td>{{ $product->current_stock }}</td>
                                    <td>{{ $product->total_stock }}</td>
                                    <td>₹{{ number_format($product->price, 2) }}</td>
                                    <td style="color: {{ $statusColor }}; font-weight: 600;">{{ $status }}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
    
                    @if(!$lowStockFound)
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No low-stock products or variants found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    
        {{-- ✅ Pagination Links --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
{{-- ================== END LOW INVENTORY STOCK SECTION ================== --}}

        
    </div>

    <script>
        // Data passed from PHP Controller
        const chartLabels = <?php echo json_encode($chartLabels); ?>;
        const purchaseData = <?php echo json_encode($purchaseData); ?>;
        const salesData = <?php echo json_encode($salesData); ?>;

        // --- Purchase Chart (50%) ---
        const purchaseCtx = document.getElementById('purchaseChart').getContext('2d');
        const purchaseChart = new Chart(purchaseCtx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Total Purchase Spend (₹)',
                    data: purchaseData,
                    backgroundColor: 'rgba(67, 97, 238, 0.5)',
                    borderColor: 'var(--primary)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Total Spend (Buy)',
                        color: 'var(--primary)'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (₹)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // --- Sales Chart (50%) ---
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Total Sales Revenue (₹)',
                    data: salesData,
                    backgroundColor: 'rgba(0, 184, 148, 0.8)', // Green for Sales
                    borderColor: '#00b894',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Total Revenue (Sell)',
                        color: '#00b894'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (₹)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

    </script>
    <script>
        
// --- Toggle Online / Offline ---
document.getElementById('btnOffline').addEventListener('click', () => {
    document.getElementById('offlineTable').style.display = 'block';
    document.getElementById('onlineTable').style.display = 'none';
    document.getElementById('btnOffline').classList.add('active');
    document.getElementById('btnOnline').classList.remove('active');
});

document.getElementById('btnOnline').addEventListener('click', () => {
    document.getElementById('offlineTable').style.display = 'none';
    document.getElementById('onlineTable').style.display = 'block';
    document.getElementById('btnOnline').classList.add('active');
    document.getElementById('btnOffline').classList.remove('active');
});

// --- Filter Function for Sales ---
function applyTableFilter(tableId) {
    const start = new Date(document.getElementById('filterStart').value || 0);
    const end = new Date(document.getElementById('filterEnd').value || '9999-12-31');
    const minAmt = parseFloat(document.getElementById('filterMinAmount').value) || 0;
    const maxAmt = parseFloat(document.getElementById('filterMaxAmount').value) || Number.MAX_VALUE;

    const rows = document.querySelectorAll(`${tableId} tbody tr`);
    rows.forEach(row => {
        const dateText = row.cells[3]?.innerText || '';
        const amountText = row.cells[2]?.innerText.replace(/,/g, '').replace('₹', '');
        const amount = parseFloat(amountText) || 0;
        const rowDate = new Date(dateText);

        if (rowDate >= start && rowDate <= end && amount >= minAmt && amount <= maxAmt) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

document.getElementById('btnApplyFilter').addEventListener('click', () => {
    const activeTable = document.getElementById('offlineTable').style.display === 'none' ? '#onlineTable' : '#offlineTable';
    applyTableFilter(activeTable);
});

document.getElementById('btnClearFilter').addEventListener('click', () => {
    ['filterStart','filterEnd','filterMinAmount','filterMaxAmount'].forEach(id => document.getElementById(id).value = '');
    document.querySelectorAll('#offlineTable tbody tr, #onlineTable tbody tr').forEach(r => r.style.display = '');
});

// --- Purchase Filter Toggle & Apply ---
document.getElementById('btnPurchaseFilter').addEventListener('click', () => {
    const panel = document.getElementById('purchaseFilterPanel');
    panel.style.display = panel.style.display === 'none' ? 'flex' : 'none';
});

document.getElementById('btnPurchaseClear').addEventListener('click', () => {
    ['purchaseStart','purchaseEnd','purchaseMin','purchaseMax'].forEach(id => document.getElementById(id).value = '');
    document.querySelectorAll('.table-purchase ~ tbody tr').forEach(r => r.style.display = '');
});

function filterPurchases() {
    const start = new Date(document.getElementById('purchaseStart').value || 0);
    const end = new Date(document.getElementById('purchaseEnd').value || '9999-12-31');
    const minAmt = parseFloat(document.getElementById('purchaseMin').value) || 0;
    const maxAmt = parseFloat(document.getElementById('purchaseMax').value) || Number.MAX_VALUE;

    const rows = document.querySelectorAll('.table-purchase ~ tbody tr');
    rows.forEach(row => {
        const dateText = row.cells[3]?.innerText || '';
        const amountText = row.cells[2]?.innerText.replace(/,/g, '').replace('₹', '');
        const amount = parseFloat(amountText) || 0;
        const rowDate = new Date(dateText);

        row.style.display = (rowDate >= start && rowDate <= end && amount >= minAmt && amount <= maxAmt) ? '' : 'none';
    });
}

// Trigger filter on input change
['purchaseStart','purchaseEnd','purchaseMin','purchaseMax'].forEach(id => {
    document.getElementById(id).addEventListener('change', filterPurchases);
});

        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('purchaseSalesChart').getContext('2d');

        const chartLabels = @json($chartLabels);
        const purchaseData = @json($purchaseData);
        const salesData = @json($salesData);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Total Purchase (₹)',
                        data: purchaseData,
                        borderColor: '#0984e3',
                        backgroundColor: 'rgba(9, 132, 227, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Total Sales (₹)',
                        data: salesData,
                        borderColor: '#00b894',
                        backgroundColor: 'rgba(0, 184, 148, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                stacked: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { size: 13 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `${context.dataset.label}: ₹${context.formattedValue}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (₹)',
                            color: '#555',
                            font: { weight: 'bold' }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month',
                            color: '#555',
                            font: { weight: 'bold' }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection