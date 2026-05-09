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
    background: var(--cream);
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
    min-height: 340px;
    margin-bottom: 5rem;
    box-shadow: var(--shadow-pink);
    animation: fadeUp 0.8s 0.1s ease both;
}

.top-pick-content {
    flex: 1.2;
    padding: 4rem;
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
    margin-bottom: 1.2rem;
    letter-spacing: 0.12em;
}

.top-pick-content h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.8rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.1;
    margin-bottom: 0.9rem;
}

.top-pick-content p {
    font-size: 0.95rem;
    color: var(--body);
    line-height: 1.75;
    max-width: 360px;
    margin-bottom: 2rem;
    font-weight: 300;
}

.top-pick-actions {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.top-pick-price {
    font-size: 1.6rem;
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
    padding: 0.85rem 2rem;
    font-size: 0.95rem;
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
    background: white;
    border-radius: var(--radius-card);
    padding: 1rem;
    border: 1px solid var(--border);
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

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
    .catalog-page { padding: 3rem 2rem 5rem; }
    .catalog-grid { grid-template-columns: 1fr 1fr; }
    .page-header { flex-direction: column; }
    .bakers-choice { min-width: 100%; }
}

@media (max-width: 768px) {
    .top-pick-card { flex-direction: column; }
    .top-pick-img-wrap { min-height: 240px; }
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
            <button class="btn-quick-add" data-id="{{ $bakersChoice->id }}">Quick Add</button>
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
                <button class="btn-cart" data-id="{{ $topPick->id }}">🛒 Add to Cart</button>
            </div>
        </div>
        <div class="top-pick-img-wrap">
            <img class="top-pick-img" src="{{ $topPick->image ? asset($topPick->image) : asset('images/placeholder-cookie.png') }}" alt="{{ $topPick->name }}">
        </div>
    </section>
    @endif

    <section class="products-section">
        <div class="products-section-header" data-aos="fade-up">
            <h2>✨ Recommended for You</h2>
        </div>

        <div class="filter-bar" data-aos="fade-up">
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all" onclick="filterProducts(this, 'all')">All Flavors</button>
                <button class="filter-tab" data-filter="sweet" onclick="filterProducts(this, 'sweet')">Sweet</button>
                <button class="filter-tab" data-filter="savory" onclick="filterProducts(this, 'savory')">Savory</button>
                <button class="filter-tab" data-filter="nutty" onclick="filterProducts(this, 'nutty')">Nutty</button>
            </div>
            <span class="sort-label">✎ Sorted by Popularity</span>
        </div>

        <div class="catalog-grid" id="productsGrid">
            @isset($products)
            @foreach($products as $product)
            <div class="catalog-card" data-category="{{ $product->category }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="catalog-img-wrap">
                    <img src="{{ $product->image ? asset($product->image) : asset('images/placeholder-cookie.png') }}" alt="{{ $product->name }}">
                    <span class="catalog-price-badge">₱{{ number_format($product->price, 0) }}</span>
                </div>
                <div class="catalog-card-body">
                    <div class="catalog-name-row">
                        <span class="catalog-name">{{ $product->name }}</span>
                        @if($product->rating)
                        <span class="catalog-rating">★ {{ number_format($product->rating, 1) }}</span>
                        @endif
                    </div>
                    <p class="catalog-desc">{{ $product->description }}</p>
                    <button class="btn-add-catalog" data-id="{{ $product->id }}">+ Add to Cart</button>
                </div>
            </div>
            @endforeach
            @endisset
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    once: true,
    duration: 800,
    easing: 'ease-out-cubic'
});

function filterProducts(btn, filter) {
    // Update active tab
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    // Filter cards with a small animation
    const cards = document.querySelectorAll('.catalog-card');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            const match = filter === 'all' || card.dataset.category === filter;
            card.style.display = match ? '' : 'none';
            if (match) {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                }, 50);
            }
        }, 300);
    });
}

document.querySelectorAll('[data-id]').forEach(button => {
    button.addEventListener('click', () => addToCart(button.dataset.id));
});
</script>
@endsection
