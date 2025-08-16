@extends('layouts.admin_lay')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">
            <i class="fas fa-calendar-check text-success"></i> Completed Bookings
        </h1>
       
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th><i class="fas fa-user mr-1"></i> Customer</th>
                            <th><i class="fas fa-envelope mr-1"></i> Email</th>
                            <th><i class="fas fa-phone mr-1"></i> Phone</th>
                            <th><i class="fas fa-map-marker-alt mr-1"></i> Location</th>
                            <th><i class="fas fa-calendar-day mr-1"></i> Booked On</th>
                            <th><i class="fas fa-rupee-sign mr-1"></i> Amount</th>
                            <th><i class="fas fa-file-invoice mr-1"></i> Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $booking->first_name }} {{ $booking->last_name }}</strong>
                            </td>
                            <td>{{ $booking->email }}</td>
                            <td>{{ $booking->phone }}</td>
                            <td>
                                {{ $booking->city }}, {{ $booking->state }}<br>
                                <small class="text-muted">{{ $booking->country }}</small>
                            </td>
                            <td>
                                {{ $booking->created_at->format('d M Y') }}<br>
                                <small class="text-muted">{{ $booking->created_at->format('h:i A') }}</small>
                            </td>
                            <td>₹51.00</td>
                            <td>
                                @if($booking->payment_status == 'paid')
                                <span class="badge badge-success text-success">
                                    <i class="fas fa-check-circle"></i> Paid
                                </span>
                                @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-times-circle"></i> Pending
                                </span>
                                @endif
                            </td>
                            <td>
                                <a href="" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!--<button class="btn btn-sm btn-outline-danger delete-booking" data-id="{{ $booking->id }}">-->
                                <!--    <i class="fas fa-trash-alt"></i>-->
                                <!--</button>-->
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No completed bookings found</h5>
                                    
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($bookings->hasPages())
    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.delete-booking').click(function() {
        const bookingId = $(this).data('id');
        if (confirm('Are you sure you want to delete this booking?')) {
            $.ajax({
                url: `/admin/bookings/${bookingId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr) {
                    alert('Error deleting booking');
                }
            });
        }
    });
});
</script>
@endsection