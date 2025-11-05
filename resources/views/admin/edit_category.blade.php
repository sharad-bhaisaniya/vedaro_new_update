@extends('layouts.admin_lay')
@section('title', 'Edit Category')
@section('content')

<div class="container-fluid py-4">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Edit Category</h5>
                        <a href="{{ route('admin.manage_categories') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Categories
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update_category', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                            value="{{ old('name', $category->name) }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" 
                                                rows="3">{{ old('description', $category->description) }}</textarea>
                                </div>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="showOnHome" 
                                            name="showOnHome" value="1" {{ $category->showOnHome ? 'checked' : '' }}>
                                    <label class="form-check-label" for="showOnHome">Show on Homepage</label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                {{-- Card for Category Images --}}
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Category Images</h6>
                                        
                                        <div class="mb-3">
                                            <label for="image">Category Image</label>
                                            @if($category->image)
                                                <div class="text-center mb-2">
                                                    <img src="{{ asset('storage/' . $category->image) }}" class="img-thumbnail" style="max-height: 150px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="removeImage" name="remove_image" value="1">
                                                        <label class="form-check-label" for="removeImage">Remove</label>
                                                    </div>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                            <div class="form-text">Recommended size: 800x800px</div>
                                        </div>

                                        <div class="mb-3">
    <label for="icon">Category Icon</label>
    @if($category->icon)
        <div class="mb-2">
            @if(Str::startsWith($category->icon, '<svg'))
                <div class="icon-preview-svg" style="max-height: 100px; display: inline-block;">
                    {!! $category->icon !!}
                </div>
                <div class="mt-2">
                    Current icon is an SVG string.
                </div>
            @else
                <img src="{{ asset('storage/' . $category->icon) }}" class="img-thumbnail" style="max-height: 100px;">
                <div class="mt-2">
                    Current icon is an image file.
                </div>
            @endif
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="removeIcon" name="remove_icon" value="1">
                <label class="form-check-label" for="removeIcon">Remove Current Icon</label>
            </div>
        </div>
    @endif

    <div class="mt-3">
        <label for="icon_file" class="form-label">Upload New Icon (Image File)</label>
        <input type="file" class="form-control" id="icon_file" name="icon_file" accept="image/*">
        <div class="form-text">e.g., JPEG, PNG, or GIF.</div>
    </div>

    <div class="mt-3">
        <label for="icon_svg" class="form-label">Paste New Icon (SVG Code)</label>
        <textarea class="form-control" id="icon_svg" name="icon_svg" rows="5" placeholder="<svg>...</svg>"></textarea>
        <div class="form-text">Paste the full SVG code here.</div>
    </div>
</div>

                                        <div class="mb-3">
                                            <label for="banner_image">Category Banner Image</label>
                                            @if($category->banner_image)
                                                <div class="text-center mb-2">
                                                    <img src="{{ asset('storage/' . $category->banner_image) }}" class="img-thumbnail" style="max-height: 150px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="removeBannerImage" name="remove_banner_image" value="1">
                                                        <label class="form-check-label" for="removeBannerImage">Remove</label>
                                                    </div>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" id="banner_image" name="banner_image" accept="image/*">
                                            <div class="form-text">Recommended size: 1200x400px</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <button type="reset" class="btn btn-light me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- No changes to your original JavaScript for image preview --}}
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxHeight = '200px';
                preview.appendChild(img);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>

@endsection