@extends('layouts.app')

@section('title', 'Catalog – SugarLoom PH')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
:root {
    --pink:        #d8547b;
    --pink-pale:   #ffd7e1;
    --pink-light:  #fbeaf0;
    --dark:        #1a0f14;
    --muted:       #7a5060;
    --body:        #5a3545;
    --white:       #ffffff;
    --cream:       #fff6f8;
    --border:      #fae8ee;
    --radius-pill: 999px;
    --radius-card: 22px;
    --shadow-card: 0 4px 20px rgba(216,84,123,0.08);
    --shadow-pink: 0 12px 30px rgba(216,84,123,0.2);
}

/* ── ANIMATIONS ── */
@keyframes fadeUp {
    from { opacity:0; transform:translateY(24px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes float {
    0%,100% { transform:translateY(0); }
    50%     { transform:translateY(-8px); }
}
@keyframes shimmer {
    0%   { background-position: -200% center; }
    100% { background-position:  200% center; }
}

/* ── PAGE ── */
.catalog-page {
    padding: 4rem 4rem 6rem;
    max-width: 1400px;
    margin: 0 auto;
    background: transparent;
}

/* ── PAGE HEADER ── */
.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 2rem;
    margin-bottom: 4rem;
    animation: fadeUp 0.7s ease both;
}

.page-header-left h1 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    font-size: 3.2rem;
    color: var(--dark);
    line-height: 1.05;
    letter-spacing: -0.03em;
}

.page-header-left h1 em {
    color: var(--pink);
    font-style: italic;
}

.page-header-left p {
    font-size: 0.95rem;
    color: var(--muted);
    margin-top: 0.9rem;
    max-width: 400px;
    line-height: 1.75;
    font-weight: 300;
}

/* ── BAKER'S CHOICE ── */
.bakers-choice {
    background: var(--pink);
    border-radius: 24px;
    padding: 1.8rem 2rem;
    color: white;
    min-width: 340px;
    animation: float 4s ease-in-out infinite;
    box-shadow: var(--shadow-pink);
}

.bakers-choice-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.4rem;
}

.bakers-choice h3 {
    font-size: 1rem;
    font-weight: 700;
    color: white;
    max-width: 180px;
    line-height: 1.3;
}

.bakers-price {
    font-size: 1.25rem;
    font-weight: 800;
    color: white;
}

.bakers-choice p {
    font-size: 0.82rem;
    opacity: 0.88;
    margin-bottom: 1.3rem;
    line-height: 1.6;
    color: white;
}

.btn-quick-add {
    width: 100%;
    padding: 0.8rem;
    border-radius: var(--radius-pill);
    border: 2px solid rgba(255,255,255,0.5);
    background: white;
    color: var(--pink);
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    font-family: 'Poppins', sans-serif;
    letter-spacing: 0.01em;
}

.btn-quick-add:hover {
    background: rgba(255,255,255,0.9);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
}

/* ── TOP PICK ── */
.top-pick-card {
    display: flex;
    border-radius: 32px;
    overflow: hidden;
    height: 380px; /* Reduced fixed height */
    margin-bottom: 5rem;
    box-shadow: var(--shadow-pink);
    animation: fadeUp 0.8s 0.1s ease both;
}

.top-pick-content {
    flex: 1.2;
    padding: 3rem; /* Reduced padding */
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: var(--pink-pale);
}

.top-pick-badge {
    background: rgba(216,84,123,0.14);
    color: #b03060;
    border-radius: var(--radius-pill);
    padding: 0.35rem 0.9rem;
    font-size: 0.65rem;
    font-weight: 800;
    text-transform: uppercase;
    width: fit-content;
    margin-bottom: 0.8rem; /* Reduced margin */
    letter-spacing: 0.12em;
}

.top-pick-content h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.4rem; /* Reduced font size */
    font-weight: 700;
    color: var(--dark);
    line-height: 1.1;
    margin-bottom: 0.7rem; /* Reduced margin */
}

.top-pick-content p {
    font-size: 0.9rem; /* Reduced font size */
    color: var(--body);
    line-height: 1.6; /* Reduced line-height */
    max-width: 400px;
    margin-bottom: 1.5rem; /* Reduced margin */
    font-weight: 300;
}

.top-pick-actions {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.top-pick-price {
    font-size: 1.4rem; /* Reduced font size */
    font-weight: 800;
    color: var(--dark);
}

.btn-cart {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--pink);
    color: white;
    border: none;
    border-radius: var(--radius-pill);
    padding: 0.7rem 1.8rem; /* Reduced padding */
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 8px 20px rgba(216,84,123,0.3);
    font-family: 'Poppins', sans-serif;
}

.btn-cart:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 28px rgba(216,84,123,0.4);
}

.top-pick-img-wrap {
    flex: 1;
    overflow: hidden;
    background: var(--pink-pale);
}

.top-pick-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.6s ease;
}

.top-pick-card:hover .top-pick-img {
    transform: scale(1.05);
}

/* ── SECTION HEADER ── */
.products-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.products-section-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.9rem;
    font-weight: 700;
    color: var(--dark);
    letter-spacing: -0.02em;
}

.catalog-search {
    display: flex;
    background: white;
    border-radius: var(--radius-pill);
    padding: 0.3rem 0.5rem 0.3rem 1.2rem;
    border: 1px solid var(--border);
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    width: 320px;
}

.catalog-search input {
    border: none;
    background: transparent;
    padding: 0.5rem 0;
    font-size: 0.85rem;
    flex-grow: 1;
    color: var(--dark);
    font-family: 'Poppins', sans-serif;
}

.catalog-search input:focus {
    outline: none;
}

.catalog-search button {
    background: transparent;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    font-size: 1rem;
    transition: transform 0.2s;
}

.catalog-search button:hover {
    transform: scale(1.15);
}

/* ── FILTER BAR ── */
.filter-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--pink);
    border-radius: var(--radius-pill);
    padding: 0.5rem;
    margin-bottom: 3rem;
    box-shadow: 0 6px 20px rgba(216,84,123,0.2);
}

.filter-tabs { display: flex; gap: 0.4rem; }

.filter-tab {
    border: none;
    border-radius: var(--radius-pill);
    padding: 0.55rem 1.3rem;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    background: transparent;
    color: rgba(255,255,255,0.85);
    font-family: 'Poppins', sans-serif;
    transition: all 0.25s;
    text-decoration: none;
    display: inline-block;
}

.filter-tab.active {
    background: white;
    color: var(--pink);
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.filter-tab:not(.active):hover {
    background: rgba(255,255,255,0.15);
    color: white;
}

.sort-label {
    font-size: 0.72rem;
    color: rgba(255,255,255,0.85);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding-right: 1.2rem;
}

/* ── CATALOG GRID ── */
.catalog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.catalog-card {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    border-radius: var(--radius-card);
    padding: 1rem;
    border: 1px solid rgba(250, 232, 238, 0.6);
    box-shadow: var(--shadow-card);
    transition: transform 0.35s cubic-bezier(0.165,0.84,0.44,1),
                box-shadow 0.35s ease,
                border-color 0.35s ease;
    animation: fadeUp 0.6s ease both;
}

.catalog-card:hover {
    transform: translateY(-8px) scale(1.015);
    box-shadow: 0 20px 40px rgba(216,84,123,0.14);
    border-color: var(--pink-pale);
}

.catalog-img-wrap {
    position: relative;
    height: 240px;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1.2rem;
    background: var(--pink-light);
}

.catalog-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.55s ease;
}

.catalog-card:hover .catalog-img-wrap img {
    transform: scale(1.08);
}

.catalog-price-badge {
    position: absolute;
    top: 12px; right: 12px;
    background: white;
    border-radius: var(--radius-pill);
    padding: 0.3rem 0.7rem;
    font-size: 0.78rem;
    font-weight: 800;
    color: var(--dark);
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.catalog-card-body { padding: 0 0.2rem; }

.catalog-name-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.4rem;
}

.catalog-name {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--dark);
}

.catalog-rating {
    font-size: 0.8rem;
    font-weight: 700;
    color: #f4a623;
}

.catalog-desc {
    font-size: 0.8rem;
    color: var(--muted);
    line-height: 1.6;
    margin-bottom: 1.3rem;
    height: 40px;
    overflow: hidden;
    font-weight: 300;
}

.btn-add-catalog {
    width: 100%;
    padding: 0.75rem;
    border-radius: var(--radius-pill);
    border: 1.5px solid var(--border);
    background: white;
    color: var(--dark);
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s;
    font-family: 'Poppins', sans-serif;
}

.btn-add-catalog:hover {
    background: var(--pink);
    color: white;
    border-color: var(--pink);
    transform: scale(1.02);
    box-shadow: 0 6px 16px rgba(216,84,123,0.25);
}

.btn-add-catalog:hover {
    background: var(--pink);
    color: white;
    border-color: var(--pink);
    transform: scale(1.02);
    box-shadow: 0 6px 16px rgba(216,84,123,0.25);
}

.btn-add-catalog:disabled {
    background: #f3eff1;
    color: #a0a0a0;
    border-color: #e0d0d5;
    cursor: not-allowed;
    transform: none;
}

.btn-add-catalog:disabled:hover {
    background: #f3eff1;
    color: #a0a0a0;
    transform: none;
}

.btn-cart:disabled,
.btn-quick-add:disabled {
    background: #ddd !important;
    color: #999 !important;
    cursor: not-allowed;
}

.stock-badge {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.4rem 0.8rem;
    border-radius: var(--radius-pill);
    margin-bottom: 0.6rem;
}

.stock-badge.in-stock {
    background: #dcfce7;
    color: #16a34a;
}

.stock-badge.out-of-stock {
    background: #fee2e2;
    color: #dc2626;
}

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
    .catalog-page { padding: 3rem 2rem 5rem; }
    .catalog-grid { grid-template-columns: 1fr 1fr; }
    .page-header { flex-direction: column; }
    .bakers-choice { min-width: 100%; }
}

@media (max-width: 768px) {
    .top-pick-card { flex-direction: column; height: auto; }
    .top-pick-img-wrap { min-height: 240px; height: auto; }
    .top-pick-content { padding: 2.5rem 2rem; }
    .catalog-grid { grid-template-columns: 1fr; }
    .filter-bar { border-radius: 20px; flex-direction: column; padding: 1rem; gap: 0.8rem; }
    .filter-tabs { flex-wrap: wrap; justify-content: center; }
    .sort-label { padding-right: 0; }
    .page-header-left h1 { font-size: 2.4rem; }
}
    </style>
@endsection

@section('content')
<div class="catalog-page">
    <div class="page-header">
        <div class="page-header-left" data-aos="fade-right">
            <h1>Artisanal Confections</h1>
            <p>Hand-crafted batches, premium ingredients, and a touch of sweetness delivered from our oven to your home.</p>
        </div>

        @if($bakersChoice)
        <div class="bakers-choice" data-aos="fade-left">
            <div class="bakers-choice-top">
                <h3>Baker's Choice: {{ $bakersChoice->name }}</h3>
                <div class="bakers-price">₱{{ number_format($bakersChoice->price, 0) }}</div>
            </div>
            <p>{{ $bakersChoice->short_description ?? $bakersChoice->description }}</p>
            @if($bakersChoice->isOutOfStock())
                <button class="btn-quick-add" disabled>Out of Stock</button>
            @else
                <button
                    class="btn-quick-add"
                    data-product-modal
                    data-product-id="{{ $bakersChoice->id }}"
                    data-product-name="{{ $bakersChoice->name }}"
                    data-product-description="{{ $bakersChoice->description }}"
                    data-product-price="{{ $bakersChoice->price }}"
                    data-product-image="{{ $bakersChoice->image ? asset($bakersChoice->image) : asset('images/placeholder-cookie.png') }}"
                    data-product-stock="{{ $bakersChoice->stock_quantity }}"
                    data-product-category="{{ $bakersChoice->category }}"
                >View Details</button>
            @endif
        </div>
        @endif
    </div>

    @if($topPick)
    <section class="top-pick-card" data-aos="fade-up" data-aos-duration="1000">
        <div class="top-pick-content">
            <span class="top-pick-badge">Top Pick</span>
            <h2>{{ $topPick->name }}</h2>
            <p>{{ $topPick->description }}</p>
            <div class="top-pick-actions">
                <span class="top-pick-price">₱{{ number_format($topPick->price, 0) }}</span>
                @if($topPick->isOutOfStock())
                    <button class="btn-cart" disabled>Out of Stock</button>
                @else
                    <button
                        class="btn-cart"
                        data-product-modal
                        data-product-id="{{ $topPick->id }}"
                        data-product-name="{{ $topPick->name }}"
                        data-product-description="{{ $topPick->description }}"
                        data-product-price="{{ $topPick->price }}"
                        data-product-image="{{ $topPick->image ? asset($topPick->image) : asset('images/placeholder-cookie.png') }}"
                        data-product-stock="{{ $topPick->stock_quantity }}"
                        data-product-category="{{ $topPick->category }}"
                    >View Details</button>
                @endif
            </div>
        </div>
        <div class="top-pick-img-wrap">
            <img class="top-pick-img" src="{{ $topPick->image ? asset($topPick->image) : asset('images/placeholder-cookie.png') }}" alt="{{ $topPick->name }}">
        </div>
    </section>
    @endif

    <section class="products-section">
        <div class="products-section-header" data-aos="fade-up">
            <h2>Catalog List</h2>
            <form action="{{ route('catalog') }}" method="GET" class="catalog-search">
                <input type="hidden" name="category" value="{{ $category }}">
                <input type="text" name="search" placeholder="Search for treats..." value="{{ $search }}">
                <button type="submit">🔍</button>
            </form>
        </div>

        <div class="filter-bar" data-aos="fade-up">
            <div class="filter-tabs">
                <a href="{{ route('catalog', ['category' => 'all']) }}" class="filter-tab {{ $category === 'all' ? 'active' : '' }}">All Flavors</a>
                <a href="{{ route('catalog', ['category' => 'sweet']) }}" class="filter-tab {{ $category === 'sweet' ? 'active' : '' }}">Sweet</a>
                <a href="{{ route('catalog', ['category' => 'savory']) }}" class="filter-tab {{ $category === 'savory' ? 'active' : '' }}">Savory</a>
                <a href="{{ route('catalog', ['category' => 'specialty']) }}" class="filter-tab {{ $category === 'specialty' ? 'active' : '' }}">Specialty</a>
            </div>
            <span class="sort-label">✎ Sorted by Rating</span>
        </div>

        <div class="catalog-grid" id="productsGrid">
            @include('partials.product-list')
        </div>

        <template id="skeletonTemplate">
            <x-skeleton-card count="6" />
        </template>
    </section>
</div>

@include('partials.product-modal')
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        once: true,
        duration: 800,
        easing: 'ease-out-cubic'
    });

    const productsGrid = document.getElementById('productsGrid');
    const filterTabs = document.querySelectorAll('.filter-tab');
    const searchForm = document.querySelector('.catalog-search');
    const skeletonTemplate = document.getElementById('skeletonTemplate');

    const updateProducts = async (url) => {
        // Show skeleton loaders
        productsGrid.innerHTML = skeletonTemplate.innerHTML;
        productsGrid.style.opacity = '1';
        
        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const html = await response.text();
            
            // Add a small delay for smoother transition if it's too fast
            setTimeout(() => {
                productsGrid.innerHTML = html;
                AOS.refreshHard();
                attachCartListeners();
            }, 300);
            
        } catch (error) {
            console.error('Error fetching products:', error);
            productsGrid.style.opacity = '1';
        }
    };

    const attachCartListeners = () => {
        document.querySelectorAll('.btn-add-catalog[data-id], .btn-quick-add[data-id], .btn-cart[data-id]').forEach(button => {
            if (!button.disabled) {
                // Remove existing listeners to avoid duplicates if any
                const newButton = button.cloneNode(true);
                button.parentNode.replaceChild(newButton, button);
                newButton.addEventListener('click', () => {
                    if (typeof window.addToCart === 'function') {
                        window.addToCart(newButton.dataset.id);
                    } else {
                        console.error('addToCart function not found');
                    }
                });
            }
        });
    };

    filterTabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            const url = new URL(tab.href);
            
            // Update active state
            filterTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            
            // Update URL in search form if needed
            const category = url.searchParams.get('category');
            searchForm.querySelector('input[name="category"]').value = category;

            updateProducts(url);
            
            // Update browser URL without refresh
            window.history.pushState({}, '', url);
        });
    });

    searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(searchForm);
        const params = new URLSearchParams(formData);
        const url = `${searchForm.action}?${params.toString()}`;
        
        updateProducts(url);
        window.history.pushState({}, '', url);
    });

    // Initial attachment
    attachCartListeners();
});
</script>
@endsection
