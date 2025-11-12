@extends('layouts.admin_lay')

@section('content')
<div class="container-fluid">
    <div class="header-breadcrumb">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0 page-title">QR Codes for {{ $product->productName }}</h1>
            <a href="{{ url()->previous() }}" class="d-none d-sm-inline-block btn btn-sm back-btn shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Products
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">Generated QR Codes</h6>
                    <span class="badge bg-light text-dark">Total: {{ $qrCodes->count() }}</span>
                </div>
                <div class="card-body">
                    @if($qrCodes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>QR Code</th>
                                    <th>RFID</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($qrCodes as $index => $qrCode)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $qrCode->qr_code }}</td>
                                    <td>{{ $qrCode->rfid ?? 'N/A' }}</td>
                                    <td>{{ $qrCode->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info view-qr" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#qrModal"
                                                data-qr="{{ $qrCode->qr_code }}">
                                            <i class="fas fa-qrcode"></i> View QR
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4 empty-state">
                        <i class="fas fa-qrcode fa-3x mb-3"></i>
                        <h5 class="text-gray-500">No QR Codes Generated Yet</h5>
                        <p>Generate QR codes for this product to see them listed here.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qrLoader" class="spinner-border text-primary" role="status" style="display:none;">
                    <span class="sr-only">Loading...</span>
                </div>
                <div id="qrCodeContainer"></div>
                <p id="qrCodeText" class="font-weight-bold text-monospace mt-3"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="downloadQR">Download</button>
              <button class="btn btn-warning" id="printbtn">
    <i class="fas fa-print"></i> Print
</button>
            </div>  
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f8f9fc;
        font-family: 'Nunito', sans-serif;
    }
    .header-breadcrumb {
        background: #4e73df;
        color: white;
        padding: 15px 0;
        margin: -20px 0 25px 0;
        border-radius: 0 0 10px 10px;
    }
    .page-title {
        font-weight: 700;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }
    .back-btn {
        background: #2e59d9;
        border: none;
        border-radius: 5px;
        padding: 8px 15px;
    }
    .back-btn:hover {
        background: #1c44b3;
    }
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .card-header {
        background: linear-gradient(90deg, #4e73df 0%, #5a8cff 100%);
        color: white;
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    .table th {
        border-top: none;
        font-weight: 600;
        color: #4e73df;
    }
    .badge { 
        font-size: 0.85rem; 
    }
    .view-qr { 
        transition: all 0.3s; 
    }
    .view-qr:hover { 
        transform: scale(1.05); 
    }
    #qrCodeContainer {
        display: flex;
        justify-content: center;
        margin: 15px 0;
    }
    #qrCodeContainer svg {
        border: 1px solid #e3e6f0;
        border-radius: 5px;
        padding: 10px;
        background: white;
        max-width: 100%;
    }
    .modal-content {
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .modal-header {
        background: #4e73df;
        color: white;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .modal-footer {
        border-top: 1px solid #e3e6f0;
    }
    .empty-state {
        padding: 40px 0;
        color: #858796;
    }
    .empty-state i {
        font-size: 5rem;
        margin-bottom: 20px;
        opacity: 0.3;
    }
</style>


<style>
    #printbtn {
        background-color: #ff9800;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 16px;
        font-weight: 600;
    }
    
    #printbtn:hover {
        background-color: #f57c00;
    }
    
    @media print {
        button {
            display: none !important;
        }
       

    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable({
            pageLength: 10,
            ordering: true,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });

        // Handle QR code modal display
        $('.view-qr').on('click', function() {
            const qrData = $(this).data('qr');
            $('#qrCodeText').text(qrData);
            
            // Clear previous QR code
            $('#qrCodeContainer').empty();
            
            // Show loading spinner
            $('#qrLoader').show();
            
            // Make AJAX call to generate QR code
            $.ajax({
                url: "{{ route('generate_view') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    qr_code_data: qrData
                },
                success: function(response) {
                    $('#qrLoader').hide();
                    if (response.qr_code_image) {
                        // Directly insert the SVG content
                        $('#qrCodeContainer').html(atob(response.qr_code_image.split(',')[1]));
                        
                        // Set up download functionality
                        $('#downloadQR').off('click').on('click', function() {
                            const svgContent = $('#qrCodeContainer').html();
                            const blob = new Blob([svgContent], { type: 'image/svg+xml' });
                            const url = URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = 'qrcode_' + qrData + '.svg';
                            document.body.appendChild(a);
                            a.click();
                            document.body.removeChild(a);
                            URL.revokeObjectURL(url);
                        });
                    } else {
                        console.error("No QR code image in response:", response);
                        // Fallback to simple SVG if API fails
                        const svg = generateQRCode(qrData);
                        $('#qrCodeContainer').html(svg);
                        
                        // Set up download functionality for fallback
                        $('#downloadQR').off('click').on('click', function() {
                            downloadQRCode(svg, qrData);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    $('#qrLoader').hide();
                    console.error("Error generating QR code:", error, xhr.responseText);
                    // Fallback to simple SVG if API fails
                    const svg = generateQRCode(qrData);
                    $('#qrCodeContainer').html(svg);
                    
                    // Set up download functionality for fallback
                    $('#downloadQR').off('click').on('click', function() {
                        downloadQRCode(svg, qrData);
                    });
                }
            });
        });

        // Simple QR code generator using SVG (fallback)
        function generateQRCode(data) {
            // This is a simplified representation - in a real app, use a QR code library
            const size = 200;
            return `
                <svg width="${size}" height="${size}" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0" y="0" width="200" height="200" fill="white" />
                    <rect x="20" y="20" width="40" height="40" fill="black" />
                    <rect x="80" y="20" width="20" height="20" fill="black" />
                    <rect x="140" y="20" width="40" height="40" fill="black" />
                    
                    <rect x="20" y="80" width="20" height="20" fill="black" />
                    <rect x="60" y="80" width="40" height="40" fill="black" />
                    <rect x="120" y="80" width="20" height="20" fill="black" />
                    
                    <rect x="20" y="140" width="40" height="40" fill="black" />
                    <rect x="80" y="140" width="20" height="20" fill="black" />
                    <rect x="140" y="140" width="40" height="40" fill="black" />
                    
                    <text x="100" y="190" text-anchor="middle" font-size="10" fill="#333">${data}</text>
                </svg>
            `;
        }

        // Download QR code as SVG
        function downloadQRCode(svgContent, fileName) {
            const blob = new Blob([svgContent], { type: 'image/svg+xml' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `qrcode_${fileName}.svg`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    });
</script>

{{-- script for print QR Code --}}
{{-- // script for print QR Code --}}
<script>
document.getElementById('printbtn').addEventListener('click', function () {
    const qrCodeContent = document.getElementById('qrCodeContainer').innerHTML;
    const qrCodeText = document.getElementById('qrCodeText').textContent;
        const productName = @json($product->productName);


    const printWindow = window.open('', '_blank');

    const printHTML = `
        <!DOCTYPE html>
        <html>
        <head>
        <title>QR ${qrCodeText}</title>
        <style>
            @page {
                size: 85mm 85mm;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
                width: 85mm;
                height: 85mm;
                position: relative; /* ✅ allows absolute positioning inside */
                background: #fff;
                font-family: Arial, sans-serif;
            }

            .label {
                width: 85mm;
                height: 15mm;
                position: relative;
              /*  border: 1px solid #000;  optional for testing */
                box-sizing: border-box;
            }
                .text{
                    position: absolute;
                    left: 12mm;
                    top: 50%;
                    transform: translateY(-50%);
                    font-size: 8px;
                }

            /* ✅ Place QR exactly at the right end */
            .qr {
                position: absolute;
                right: 25mm;  /* adjust to 0mm if you want it touching the edge */
                top: 50%;
                transform: translateY(-30%);
                width: 14mm;
                height: 14mm;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .vedaro{
                position: absolute;
                right:3mm;
                bottom: 12mm;
                font-size: 8px;
                font-weight: bold;
            }
              
                .qr-image{
                margin-right:2mm;
                
                }
                

            .qr svg {
                width: 7mm !important;
                height: 7mm !important;
            }

            @media print {
                body {
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
            }
        </style>
        </head>
        <body>
            <div class="label">
               <div class="qr">
                <div class="qr-image">${qrCodeContent}</div>
                <div>

                <div class="vedaro">VEDARO</div>
                <div class="text">${productName}</div>


                </div>
                </div>
            </div>
        </body>
        </html>
    `;

    printWindow.document.write(printHTML);
    printWindow.document.close();

    printWindow.onload = () => {
        setTimeout(() => {
            printWindow.print();
            setTimeout(() => printWindow.close(), 500);
        }, 200);
    };
});
</script>


@endpush

                    {{--  <div class="text">${qrCodeText}</div>
                <div class="qr">${qrCodeContent}</div> --}}



