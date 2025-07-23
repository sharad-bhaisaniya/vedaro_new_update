@extends('layouts.admin_lay')

@section('content')
<div class="container">
    <h2>Edit Banner</h2>
    
    
    
       @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

    <form action="{{ route('limited-banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ $banner->title }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $banner->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Current Image</label><br>
            <img src="{{ Storage::url($banner->image) }}" width="150"><br><br>
            <label>Change Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
