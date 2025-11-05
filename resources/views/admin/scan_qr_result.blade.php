@extends('layouts.admin_lay')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Scan QR Code</h1>

        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">QR Code Scanner</h6>
                    </div>
                    <div class="card-body">
                        <div id="reader" style="width: 100%;"></div>
                        <div class="alert mt-3" id="status-message" style="display:none;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Scan Result</h6>
                    </div>
                    <div class="card-body" id="result-card-body">
                        <div id="product-details" style="display:none;">
                            <img id="product-image" src="" alt="Product Image" style="max-width: 100%; height: auto; border-radius: 5px;">
                            <h5 class="mt-3">Product: <span id="product-name"></span></h5>
                            <p><strong>QR Code:</strong> <span id="qr-code"></span></p>
                            <p><strong>RFID:</strong> <span id="rfid"></span></p>
                        </div>
                        <div id="no-result" class="text-center text-muted">
                            Scan a QR code to see the product details here.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const readerEl = document.getElementById('reader');
        const statusMessageEl = document.getElementById('status-message');
        const productDetailsEl = document.getElementById('product-details');
        const productNameEl = document.getElementById('product-name');
        const qrCodeEl = document.getElementById('qr-code');
        const rfidEl = document.getElementById('rfid');
        const productImageEl = document.getElementById('product-image');
        const noResultEl = document.getElementById('no-result');

        let isProcessing = false;

        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) {
                return;
            }

            isProcessing = true;
            const qrCode = decodedText.trim();
            
            // Show a loading message
            statusMessageEl.style.display = 'block';
            statusMessageEl.className = 'alert mt-3 alert-info';
            statusMessageEl.textContent = 'Looking up product...';
            noResultEl.style.display = 'none';
            productDetailsEl.style.display = 'none';

            // Post data to the server
            fetch('{{ route('lookup_identifier') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    qr_code: qrCode
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusMessageEl.className = 'alert mt-3 alert-success';
                    statusMessageEl.textContent = data.message;
                    
                    productNameEl.textContent = data.data.product_name;
                    qrCodeEl.textContent = data.data.qr_code;
                    rfidEl.textContent = data.data.rfid || 'N/A';
                    productImageEl.src = data.data.image;
                    
                    productDetailsEl.style.display = 'block';

                } else {
                    statusMessageEl.className = 'alert mt-3 alert-danger';
                    statusMessageEl.textContent = data.message;
                    noResultEl.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                statusMessageEl.className = 'alert mt-3 alert-danger';
                statusMessageEl.textContent = 'An unexpected error occurred. Please try again.';
                noResultEl.style.display = 'block';
            })
            .finally(() => {
                isProcessing = false;
            });
        }

        const html5QrCode = new Html5Qrcode("reader");

        // Start the camera
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            onScanSuccess,
            (errorMessage) => {}
        ).catch((err) => {
            statusMessageEl.style.display = 'block';
            statusMessageEl.className = 'alert mt-3 alert-danger';
            statusMessageEl.textContent = 'Error starting camera: ' + err;
        });
    });
</script>
@endpush