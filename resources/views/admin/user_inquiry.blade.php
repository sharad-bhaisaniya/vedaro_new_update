{{-- resources/views/admin/inquiries/index.blade.php --}}

@extends('layouts.admin_lay') {{-- Assuming you have a layout file --}}

@section('content')
<div class="container mt-1">
    <div class="row justify-content-center"> {{-- Changed to justify-content-center for better centering --}}
        <div class="col-lg-12 col-md-10 col-sm-12">

            <h2 class="mt-4 mb-4">User Inquiries</h2>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark"> {{-- Added table-dark for better styling --}}
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Received At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inquiries as $inquiry)
                            <tr>
                                <td>{{ $loop->iteration }}</td> {{-- Loop iteration for row numbering --}}
                                <td>{{ $inquiry->name }}</td>
                                <td>{{ $inquiry->email }}</td>
                                <td>{{ $inquiry->phone }}</td>
                                <td>{{ $inquiry->subject ?? 'N/A' }}</td> {{-- Display N/A if subject is null --}}
                                <td>{{ Str::limit($inquiry->message, 100) }}</td> {{-- Limit message length for table --}}
                                <td>{{ $inquiry->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No user inquiries found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection