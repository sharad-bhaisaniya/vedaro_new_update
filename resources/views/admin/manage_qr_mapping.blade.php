@extends('layouts.admin_lay')



@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Manage QR/RFID Mapping</h1>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Total Quantity</th>
                                <th>Mapped Items</th>
                                <th>Mapping Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->productName }}</td>
                                    <td>{{ $product->total_stock }}</td>
                                    <td>{{ $product->identifiers_count }}</td>
                                    <td>
                                        @if ($product->total_stock === $product->identifiers_count && $product->total_stock > 0)
                                            <span class="badge badge-success">Mapped</span>
                                        @elseif ($product->identifiers_count > 0)
                                            <span class="badge badge-warning">Partial</span>
                                        @else
                                            <span class="badge badge-danger">Not Mapped</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('map_product_qr', $product->id) }}" class="btn btn-primary btn-sm">Map Identifiers</a>
                                        <a href="{{ route('products.qrcodes', $product->id) }}" class="btn btn-info btn-sm">
    <i class="fas fa-qrcode"></i> View QR Codes
</a>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection