@extends('layouts.admin_lay')

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Banner</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Banner Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Type</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="typeImage" value="image" checked>
                <label class="form-check-label" for="typeImage">Image</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="typeVideo" value="video">
                <label class="form-check-label" for="typeVideo">Video</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Upload File (Image or Video)</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Banner</button>
    </form>
</div>
@endsection
