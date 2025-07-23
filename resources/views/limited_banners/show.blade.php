@extends('layouts.admin_lay')

@section('content')
<div class="container">
    
       @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif


    <h2>{{ $banner->title }}</h2>
    <!--<img src="{{ Storage::url($banner->image) }}" width="300" class="mb-3">-->
    <img src="{{ Storage::url($banner->image) }}" alt="Banner Image">

    <p>{{ $banner->description }}</p>
    <a href="{{ route('limited-banners.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
