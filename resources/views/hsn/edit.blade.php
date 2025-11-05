@extends('layouts.admin_lay')
@section('content')
<div class="container mt-4">
    <h4>Edit HSN Code</h4>
    <form action="{{ route('hsn.update', $hsn) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>HSN Code</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $hsn->code) }}" required>
            @error('code') <small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $hsn->description) }}</textarea>
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('hsn.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
