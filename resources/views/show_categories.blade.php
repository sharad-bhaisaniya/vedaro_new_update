@extends('layouts.main')

@section('content')
<style>
    @media (min-width: 768px) and (max-width: 1063px) {
  .col {
      width: 29%!important;
      margin-inline: auto;
  }
</style>
<div class="container-fluid" style="margin-block:150px;">
    <div class="row">
        <!-- Sidebar -->
        <!--<aside class="col-md-3">-->
        <!--    <div class="p-3 border rounded bg-light">-->
        <!--        <h5 class="mb-4 text-uppercase text-center" style="font-weight: bold; color: #b08d57;">Jewellery Categories</h5>-->
        <!--        <ul class="list-group list-group-flush">-->
        <!--            <li class="list-group-item d-flex justify-content-between align-items-center">-->
        <!--                <a href="{{ route('categories_page') }}" class="text-decoration-none text-dark">All Categories</a>-->
                        <!--<span class="badge bg-warning text-dark rounded-pill">New</span>-->
        <!--            </li>-->
        <!--            @foreach($categories as $cat)-->
        <!--                <li class="list-group-item d-flex justify-content-between align-items-center">-->
        <!--                    <a href="{{ route('categories_page', ['category' => $cat->id]) }}" class="text-decoration-none text-dark">-->
        <!--                        {{ $cat->name }}-->
        <!--                    </a>-->
        <!--                    <span class="badge bg-warning text-dark rounded-pill">New</span>-->
        <!--                </li>-->
        <!--            @endforeach-->
        <!--        </ul>-->
        <!--    </div>-->
        <!--</aside>-->

        <!-- Main Content -->
        <main class="col-md-12">
            <h4 class="mb-4 text-uppercase" style="color: #b08d57; font-weight: bold;">
                @if(request('category'))
                    {{ $currentCategoryName ?? 'Selected Category' }} Products
                @else
                    All Jewellery Category
                @endif
            </h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-4">
                @forelse($categories as $category)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm position-relative">
                        <img src="{{ asset('public/storage/products/' . $category->image) }}" class="img-front" alt="{{ $category->name }}" style="height: 220px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title text-uppercase" style="color: #b08d57;">{{ $category->name }}</h6>
                            <p class="small text-secondary">{{ $category->productName }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a  href="{{ route('product.show', ['id' => $category->id]) }}" class="btn btn-outline-warning w-100 text-uppercase">View Products</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted">No products found in this category.</p>
                </div>
                @endforelse
            </div>
        </main>
    </div>
</div>
@endsection



