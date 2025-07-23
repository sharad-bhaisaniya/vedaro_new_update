@extends('layouts.admin_lay')

@section('title', 'Pre-Bookings')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Pre-Bookings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($preBookings->count())
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Note</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($preBookings as $index => $booking)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($booking->user)
                                {{ $booking->user->first_name }} {{ $booking->user->last_name }}
                            @else
                                Deleted User
                            @endif
                        </td>
                        <td>{{ $booking->user->email }} </td>
                        <td>{{ $booking->user->phone }} </td>
                        <td>{{ $booking->product->productName ?? 'Deleted Product' }}</td>
                        <td>{{ $booking->quantity }}</td>
                        <td>{{ $booking->note }}</td>
                        <td>{{ $booking->created_at->format('d M Y, h:i A') }}</td>
                        <td>
                            <a href="https://wa.me/{{ $booking->user->phone }}" target="_blank" class="btn btn-sm btn-success mb-1">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                        
                           
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No pre-bookings found.</p>
    @endif
</div>
@endsection
