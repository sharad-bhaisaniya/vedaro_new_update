@extends('layouts.admin_lay')

@section('title', 'Pre-Bookings')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container mt-4">
    <h2 class="mb-4">All Pre-Bookings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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
                    <tr id="booking-row-{{ $booking->id }}">
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
                            <button type="button" onclick="sendWhatsAppReminder({{ $booking->id }})" 
                                    class="btn btn-sm btn-success mb-1">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No pre-bookings found.</p>
    @endif
</div>

<script>
function sendWhatsAppReminder(bookingId) {
    // Use absolute URL with admin prefix
    const url = `${window.location.origin}/admin/pre-bookings/${bookingId}/send-whatsapp`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        alert(data.message);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to send reminder: ' + (error.message || 'Unknown error'));
    });
}</script>
@endsection