<div class="sidebar" id="sidebarMenu" aria-hidden="true" role="dialog" aria-label="Main Menu">
    <h4>
        <span>Menu</span>
        <button class="close-btn" id="closeSidebar" aria-label="Close menu">&times;</button>
    </h4>

    <!-- Static links -->
    <a href="/limited_edition">
        <i class="fa-solid fa-gem"></i> Limited edition
    </a>
    <a href="/gift">
        <i class="fa-solid fa-gift"></i> Gifting
    </a>

    <!-- Dynamic category links -->
@foreach($categories as $cat)
    @if($cat->showOnHome)
        <a href="{{ route('product.show', ['id' => $cat->id]) }}">
            @if(Str::startsWith($cat->icon, '<svg'))
                <div style="width: 18px; height: 18px; display: inline-block; vertical-align: middle;">
                    {!! $cat->icon !!}
                </div>
            @else
                <img src="{{ asset('storage/' . $cat->icon) }}" width="18" alt="{{ $cat->name }}">
            @endif
            {{ $cat->name }}
        </a>
    @endif
@endforeach


    <!-- Extra static links -->
    <a href="/newEvent">
        <i class="fa-regular fa-calendar"></i> Events
    </a>
  
</div>
