@extends('layouts.admin_lay')
@section('title', 'Dashboard')
@section('content')

<style>
    .category-table img {
        width: 50px;
        height: auto;
        border-radius: 6px;
        object-fit: cover;
    }

    .table-actions .btn {
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 0.3rem 0.6rem;
    }
    .switch {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 24px;
}
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
.slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}
.slider:before {
    position: absolute;
    content: "";
    height: 18px; width: 18px;
    left: 3px; bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}
input:checked + .slider {
    background-color: #4CAF50;
}
input:checked + .slider:before {
    transform: translateX(22px);
}
.slider.round {
    border-radius: 24px;
}
.slider.round:before {
    border-radius: 50%;
}

</style>

<div class="container-fluid px-4 mt-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header  text-white d-flex justify-content-between align-items-center"style="background:rgb(88 149 239 / 66%)">
            <h5 class="mb-0">   <i class="fas fa-cogs"></i> Manage Categories</h5>
            <a href="{{route('admin.categories')}}" class="btn btn-sm btn-light">
                ➕ Add Category
            </a>
        </div>
        <div class="card-body">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Categories Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover category-table align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">📛 Name</th>
                            <th scope="col">📝 Description</th>
                            <th scope="col">🖼️ Image</th>
                           <th scope="col">🏠 Show on Home</th> {{-- ✅ new column --}}
                           <th scope="col">🔘 Status</th> {{-- ✅ new column --}}
                            <th scope="col">⚙️ Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    <br>
                                    <span class="badge {{ $category->active ? 'bg-success' : 'bg-secondary' }} status-badge">
                                        {{ $category->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($category->description, 60) }}</td>
                                <td>
                                    @if($category->image)
                                        <img src="{{ asset('public/storage/products/' . $category->image) }}" alt="{{ $category->name }}">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                               <td>
                                    <label class="switch">
                                        <input type="checkbox"
                                               class="toggle-show-home"
                                               data-url="{{ route('admin.toggle_show_on_home', $category->id) }}"
                                               {{ $category->showOnHome ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="table-actions">
                                    <!--<a href="{{ route('admin.edit_category', $category->id) }}" class="btn btn-sm btn-outline-warning">-->
                                    <!--    ✏️ Edit-->
                                    <!--</a>-->

                                    <form action="{{ route('admin.delete_category', $category->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            🗑️ Delete
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.toggle_category', $category->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $category->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}">
                                            {{ $category->active ? '🔒 Deactivate' : '✅ Activate' }}
                                        </button>
                                    </form>
                                </td>
                                
                                  <td>
                        <div class="d-flex gap-2">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.edit_category', $category->id) }}" 
                               class="btn btn-sm btn-outline-primary" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <!-- Toggle Status Button -->
                           {{-- <form action="{{ route('admin.toggle_category', $category->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-sm {{ $category->active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                        title="{{ $category->active ? 'Deactivate' : 'Activate' }}">
                                    <i class="fas {{ $category->active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                </button>
                            </form>
                            --}}
                            
                            <!-- Delete Button -->
                            <form action="{{ route('admin.delete_category', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-outline-danger" 
                                        title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-show-home').forEach(function (toggle) {
        toggle.addEventListener('change', function () {
            let url = this.dataset.url;
            let isChecked = this.checked;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert('Failed to update Show on Home status');
                    toggle.checked = !isChecked; // revert if failed
                }
            })
            .catch(() => {
                alert('Error updating status');
                toggle.checked = !isChecked; // revert on error
            });
        });
    });
});
</script>



@endsection
