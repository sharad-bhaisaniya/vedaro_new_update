@extends('layouts.admin_lay')
@section('content')
<div class="container mt-4">
    <h4>Add New Brand</h4>
    <form action="{{ route('brands.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Brand Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <button class="btn btn-success">Save</button>
        <a href="{{ route('brands.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
