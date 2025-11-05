@extends('layouts.admin_lay')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Map QR/RFID for {{ $product->productName }}</h1>

    <div class="row">
        {{-- Product Details --}}
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Product Details</h6>
                </div>
                <div class="card-body">
                    <h5>{{ $product->productName }}</h5>
                    <p>Total Quantity: <strong><span id="total-quantity">{{ $totalQuantity }}</span></strong></p>
                    <p>Mapped Quantity: <strong><span id="mapped-count">{{ $mappedCount }}</span></strong></p>
                    <p>Remaining: <strong><span id="remaining-count">{{ $totalQuantity - $mappedCount }}</span></strong></p>
                </div>
            </div>
        </div>

        {{-- QR Generate --}}
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Generate QR Codes</h6>
                </div>
                <div class="card-body text-center">
                    {{-- Button to trigger server-side QR generation --}}
                   
                    @if($totalQuantity > $mappedCount)
                        <button id="generate-qr-server" class="btn btn-primary">Generate Remaining QR Codes</button>
                    @else
                        <div class="alert alert-success">
                            All QR codes for this product have been generated.
                        </div>
                    @endif
                    <div id="qr-generation-result" class="mt-3"></div>
                </div>
            </div>
        </div>

        {{-- Scanner --}}
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">QR/RFID Scanner</h6>
                </div>
                <div class="card-body">
                    @if ($totalQuantity > $mappedCount)
                        <div id="reader" style="width: 100%;"></div>
                        <div id="result" class="text-center mt-3" style="font-weight: bold;"></div>
                    @else
                        <div class="alert alert-success">
                            All items for this product have been mapped.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mappedCountEl = document.getElementById('mapped-count');
        const totalQuantityEl = document.getElementById('total-quantity');
        const remainingCountEl = document.getElementById('remaining-count');
        const resultEl = document.getElementById('result');
        const readerEl = document.getElementById('reader');
        const qrGenerationResult = document.getElementById('qr-generation-result');
        const totalQuantity = parseInt(totalQuantityEl.textContent);
        let mappedCount = parseInt(mappedCountEl.textContent);
        let isProcessing = false;

        // ✅ QR Generation Logic
        const generateBtn = document.getElementById('generate-qr-server');
        if (generateBtn) {
            generateBtn.addEventListener('click', () => {
                // Show loading state
                generateBtn.disabled = true;
                generateBtn.textContent = 'Generating...';
                
                // Fetch the QR codes from the backend
                fetch('{{ route("generate_qr", $product->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Network response was not ok');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update counts
                        mappedCount = data.mapped_count;
                        mappedCountEl.textContent = mappedCount;
                        remainingCountEl.textContent = totalQuantity - mappedCount;
                        
                        // Show success message
                        qrGenerationResult.innerHTML = `
                            <div class="alert alert-success">
                                ${data.message}
                            </div>
                        `;
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        
                        // If all QR codes are generated, hide the button
                        if (mappedCount >= totalQuantity) {
                            generateBtn.style.display = 'none';
                            qrGenerationResult.innerHTML += `
                                <div class="alert alert-info mt-2">
                                    All QR codes have been generated for this product.
                                </div>
                            `;
                        }
                    } else {
                        qrGenerationResult.innerHTML = `
                            <div class="alert alert-danger">
                                ${data.message}
                            </div>
                        `;
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const errorMsg = error.message || 'Failed to generate QR codes. Please try again.';
                    qrGenerationResult.innerHTML = `
                        <div class="alert alert-danger">
                            ${errorMsg}
                        </div>
                    `;
                    Swal.fire('Error', errorMsg, 'error');
                })
                .finally(() => {
                    generateBtn.disabled = false;
                    generateBtn.textContent = 'Generate Remaining QR Codes';
                });
            });
        }

        // ✅ QR Scanner Logic
        if (mappedCount < totalQuantity && readerEl) {
            function onScanSuccess(decodedText) {
                if (isProcessing) return;
                isProcessing = true;

                const qrCode = decodedText.trim();
                resultEl.textContent = `Scanned: ${qrCode}`;

                Swal.fire({
                    title: 'Mapping...',
                    text: 'Please wait, scanning in progress.',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                fetch('{{ route('store_identifier', $product->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ qr_code: qrCode })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Network response was not ok');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        mappedCount = data.mapped_count;
                        mappedCountEl.textContent = mappedCount;
                        remainingCountEl.textContent = totalQuantity - mappedCount;
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500
                        });
                        if (mappedCount >= totalQuantity) {
                            if (html5QrCode && html5QrCode.isScanning) {
                                html5QrCode.stop().then(() => {
                                    readerEl.innerHTML = '<div class="alert alert-success">All items mapped.</div>';
                                }).catch(err => console.error('Failed to stop scanner:', err));
                            }
                        }
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', error.message || 'An error occurred while mapping the QR code.', 'error');
                })
                .finally(() => {
                    // Re-enable scanning after a short delay
                    setTimeout(() => { isProcessing = false; }, 2000);
                });
            }

            let html5QrCode;
            try {
                html5QrCode = new Html5Qrcode("reader");
                html5QrCode.start(
                    { facingMode: "environment" },
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    onScanSuccess,
                    () => {}
                ).catch(err => {
                    console.error('Failed to start QR scanner:', err);
                    readerEl.innerHTML = '<div class="alert alert-warning">Could not start camera. Please check permissions.</div>';
                });
            } catch (error) {
                console.error('Error initializing QR scanner:', error);
                readerEl.innerHTML = '<div class="alert alert-warning">QR scanner not supported in this browser.</div>';
            }
        }
    });
</script>
@endpush