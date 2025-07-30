@extends('layouts.admin_lay')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">All Banners</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $imageBanners = $banners->where('type', 'image')->values();
        $videoBanners = $banners->where('type', 'video')->values();
    @endphp

    {{-- Image Banners --}}
    @if($imageBanners->count())
    <h5 class="mt-4">🖼 Image Banners</h5>
    <div class="table-responsive">
        <table class="table table-bordered align-middle table-hover small">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Title</th>
                    <th>Preview</th>
                    <th>Status</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($imageBanners as $index => $banner)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $banner->title }}</td>
                    <td>
                        <img src="{{ asset('public/storage/products/' . $banner->file_path) }}"
                             class="img-thumbnail"
                             style="max-height: 80px; width: auto;" alt="Banner">
                    </td>
                    <td>
                        @if($banner->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="d-flex gap-2">
                        @if(!$banner->is_active)
                        <form action="{{ route('banners.activate', $banner->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-outline-success">Activate</button>
                        </form>
                        @endif
                        <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Delete this banner?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Video Banners --}}
    @if($videoBanners->count())
    <h5 class="mt-5">🎥 Video Banners</h5>
    <div class="table-responsive">
        <table class="table table-bordered align-middle table-hover small">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Title</th>
                    <th>Preview</th>
                    <th>Status</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($videoBanners as $index => $banner)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $banner->title }}</td>
                    <td>
                        <video controls style="height: 80px; max-width: 150px;" class="rounded shadow-sm">
                            <source src="{{ asset('public/storage/products/' . $banner->file_path) }}" type="video/mp4">
                            Not supported
                        </video>
                    </td>
                    <td>
                        @if($banner->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="d-flex gap-2">
                        @if(!$banner->is_active)
                        <form action="{{ route('banners.activate', $banner->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-outline-success">Activate</button>
                        </form>
                        @endif
                        <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Delete this banner?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
