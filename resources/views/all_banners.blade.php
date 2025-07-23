@extends('layouts.admin_lay')

@section('content')
<div class="container">
    <h2 class="mb-4">All Banners</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($banners as $banner)
            <div class="col-md-6 mb-4">
                <div class="card border {{ $banner->is_active ? 'border-success' : '' }}">
                    <div class="card-header d-flex justify-content-between">
                        <strong>{{ $banner->title }}</strong>
                        @if(!$banner->is_active)
                            <form action="{{ route('banners.activate', $banner->id) }}" method="POST">
                                
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-success">Set Active</button>
                            </form>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                         {{-- Delete Icon --}}
        <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" title="Delete Banner">
                <i class="bi bi-trash-fill"></i> {{-- Bootstrap icon --}}
            </button>
        </form>
                    </div>
                    <div class="card-body text-center">

                     @if($banner->type === 'image')
            <img src="{{ asset('public/storage/products/' . $banner->file_path) }}" alt="Banner" class="img-fluid"  style="max-height: 300px; object-fit: cover;">
                @elseif($banner->type === 'video')
                    <video controls class="w-100" style="max-height: 300px; object-fit: cover;">
                        <source src="{{ asset('public/storage/products/' . $banner->file_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif


                    </div>
                </div>
            </div>
        @empty
            <p>No banners available.</p>
        @endforelse
    </div>
</div>
@endsection
