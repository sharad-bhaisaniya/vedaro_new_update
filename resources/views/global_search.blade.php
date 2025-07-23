@extends('layouts.main')

@section('title', 'Global Search')


<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --accent-color: #4cc9f0;
        --light-bg: #f8f9fa;
        --dark-text: #2b2d42;
        --light-text: #8d99ae;
    }
    
    body {
        background-color: var(--light-bg);
        color: var(--dark-text);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    
    .search-hero {
        min-height: 60vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, rgba(67,97,238,0.1) 0%, rgba(76,201,240,0.05) 100%);
        position: relative;
        overflow: hidden;
    }
    
    .search-hero::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(76,201,240,0.08) 0%, rgba(76,201,240,0) 70%);
        z-index: 0;
    }
    
    .search-container {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .search-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        background: linear-gradient(to right, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .search-subtitle {
        font-size: 1.1rem;
        color: var(--light-text);
        margin-bottom: 2rem;
        max-width: 600px;
    }
    
    .search-input-container {
        position: relative;
        box-shadow: 0 10px 25px rgba(67,97,238,0.15);
        border-radius: 50px;
        overflow: hidden;
    }
    
    .search-input {
        padding: 1.25rem 1.5rem;
        font-size: 1.1rem;
        border: none;
        width: 100%;
        padding-right: 140px;
    }
    
    .search-input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(67,97,238,0.2);
    }
    
    .search-button {
        position: absolute;
        right: 5px;
        top: 5px;
        bottom: 5px;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0 1.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .search-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(67,97,238,0.3);
    }
    
    .search-categories {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }
    
    .search-category {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 50px;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        color: var(--light-text);
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .search-category:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    /* Results section */
    .results-section {
        padding: 3rem 0;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .results-count {
        font-size: 0.9rem;
        color: var(--light-text);
    }
    
    .results-filters {
        display: flex;
        gap: 0.75rem;
    }
    
    .filter-button {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        color: var(--light-text);
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .filter-button.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    .filter-button:hover {
        border-color: var(--primary-color);
    }
    
    .results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .result-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .result-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .result-image {
        height: 160px;
        background-size: cover;
        background-position: center;
    }
    
    .result-content {
        padding: 1.5rem;
    }
    
    .result-type {
        display: inline-block;
        background: rgba(67,97,238,0.1);
        color: var(--primary-color);
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    
    .result-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark-text);
    }
    
    .result-description {
        font-size: 0.9rem;
        color: var(--light-text);
        margin-bottom: 1rem;
        line-height: 1.5;
    }
    
    .result-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        color: var(--light-text);
    }
    
    .result-author {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .author-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-size: cover;
    }
    
    /* No results state */
    .no-results {
        text-align: center;
        padding: 4rem 0;
    }
    
    .no-results-icon {
        font-size: 3rem;
        color: var(--light-text);
        margin-bottom: 1rem;
    }
    
    .no-results-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .no-results-text {
        color: var(--light-text);
        margin-bottom: 1.5rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .search-title {
            font-size: 2rem;
        }
        
        .search-container {
            padding: 1.5rem;
        }
        
        .results-grid {
            grid-template-columns: 1fr;
        }
    }
</style>


@section('content')
<!-- Hero Search Section -->
<section class="search-hero" >
    <div class="container"style="margin-top:150px">
        <div class="search-container">
            <h1 class="search-title text-center">Discover Everything You Need</h1>
            <p class="search-subtitle text-center">
                Search across products, articles, users, and more. Find exactly what you're looking for with our powerful global search.
            </p>
            
            <div class="search-input-container">
                <form action="" method="GET">
                    <input 
                        type="text" 
                        class="search-input" 
                        placeholder="Try 'summer collection', 'tech news', or 'john doe'..."
                        name="query"
                        value="{{ request('query') }}"
                        autocomplete="off"
                    >
                    <button type="submit" class="search-button">
                        <i class="bi bi-search me-2"></i> Search
                    </button>
                </form>
            </div>
            
            <div class="search-categories">
                <div class="search-category">Products</div>
                <div class="search-category">Articles</div>
                <div class="search-category">Users</div>
                <div class="search-category">Categories</div>
                <div class="search-category">Collections</div>
            </div>
        </div>
    </div>
</section>

<!-- Results Section -->
@if(isset($searchResults) && request('query'))
<section class="results-section">
    <div class="container">
        <div class="results-header">
            <div class="results-count">
                About {{ count($searchResults) }} results for "<strong>{{ request('query') }}</strong>"
            </div>
            <div class="results-filters">
                <div class="filter-button active">All</div>
                <div class="filter-button">Products</div>
                <div class="filter-button">Articles</div>
                <div class="filter-button">Users</div>
            </div>
        </div>
        
        @if(count($searchResults) > 0)
        <div class="results-grid">
            <!-- Static Data Results -->
            <div class="result-card">
                <div class="result-image" style="background-image: url('https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60')"></div>
                <div class="result-content">
                    <span class="result-type">Product</span>
                    <h3 class="result-title">Premium Running Shoes</h3>
                    <p class="result-description">High-performance running shoes with advanced cushioning technology for maximum comfort during your workouts.</p>
                    <div class="result-meta">
                        <span>$129.99</span>
                        <span class="result-stock">In Stock</span>
                    </div>
                </div>
            </div>
            
            <div class="result-card">
                <div class="result-image" style="background-image: url('https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60')"></div>
                <div class="result-content">
                    <span class="result-type">Article</span>
                    <h3 class="result-title">10 Tips for Better Sleep</h3>
                    <p class="result-description">Discover science-backed methods to improve your sleep quality and wake up refreshed every morning.</p>
                    <div class="result-meta">
                        <div class="result-author">
                            <div class="author-avatar" style="background-image: url('https://randomuser.me/api/portraits/women/44.jpg')"></div>
                            <span>Dr. Sarah Johnson</span>
                        </div>
                        <span>5 min read</span>
                    </div>
                </div>
            </div>
            
            <div class="result-card">
                <div class="result-image" style="background-image: url('https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60')"></div>
                <div class="result-content">
                    <span class="result-type">User</span>
                    <h3 class="result-title">Alex Morgan</h3>
                    <p class="result-description">Senior Product Designer with 8 years of experience in UI/UX design. Specializes in mobile applications.</p>
                    <div class="result-meta">
                        <span>San Francisco, CA</span>
                        <span>245 Followers</span>
                    </div>
                </div>
            </div>
            
            <div class="result-card">
                <div class="result-image" style="background-image: url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60')"></div>
                <div class="result-content">
                    <span class="result-type">Product</span>
                    <h3 class="result-title">Modern Leather Sofa</h3>
                    <p class="result-description">Handcrafted genuine leather sofa with premium cushioning. Perfect for your living room.</p>
                    <div class="result-meta">
                        <span>$899.99</span>
                        <span class="result-stock">Only 3 left</span>
                    </div>
                </div>
            </div>
            
            <div class="result-card">
                <div class="result-image" style="background-image: url('https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60')"></div>
                <div class="result-content">
                    <span class="result-type">Article</span>
                    <h3 class="result-title">The Future of Remote Work</h3>
                    <p class="result-description">How companies are adapting to the new normal of distributed teams and what it means for the future of work.</p>
                    <div class="result-meta">
                        <div class="result-author">
                            <div class="author-avatar" style="background-image: url('https://randomuser.me/api/portraits/men/32.jpg')"></div>
                            <span>Michael Chen</span>
                        </div>
                        <span>8 min read</span>
                    </div>
                </div>
            </div>
            
            <div class="result-card">
                <div class="result-image" style="background-image: url('https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60')"></div>
                <div class="result-content">
                    <span class="result-type">User</span>
                    <h3 class="result-title">Jessica Williams</h3>
                    <p class="result-description">Marketing Director at TechCorp. Passionate about brand strategy and digital marketing trends.</p>
                    <div class="result-meta">
                        <span>New York, NY</span>
                        <span>1.2k Followers</span>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="no-results">
            <div class="no-results-icon">
                <i class="bi bi-search"></i>
            </div>
            <h3 class="no-results-title">No results found</h3>
            <p class="no-results-text">
                We couldn't find any matches for "{{ request('query') }}". Try different keywords or check your spelling.
            </p>
            <button class="btn btn-primary">Back to Home</button>
        </div>
        @endif
    </div>
</section>
@elseif(request('query') && !isset($searchResults))
<!-- Empty search state -->
<section class="results-section">
    <div class="container">
        <div class="no-results">
            <div class="no-results-icon">
                <i class="bi bi-search"></i>
            </div>
            <h3 class="no-results-title">Ready to search</h3>
            <p class="no-results-text">
                Enter a search term above to discover products, articles, users, and more from our platform.
            </p>
        </div>
    </div>
</section>
@endif
@endsection

@section('scripts')
<script>
    // Add interactivity to category filters
    document.querySelectorAll('.search-category').forEach(category => {
        category.addEventListener('click', function() {
            // In a real implementation, this would filter the search
            document.querySelector('.search-input').value = this.textContent;
            document.querySelector('form').submit();
        });
    });
    
    // Add interactivity to filter buttons
    document.querySelectorAll('.filter-button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.filter-button').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            
            // In a real implementation, this would filter the results
        });
    });
</script>
@endsection