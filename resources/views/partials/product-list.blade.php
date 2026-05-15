@forelse($products as $product)
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
        @if($product->isOutOfStock())
            <div class="stock-badge out-of-stock">Out of Stock</div>
            <button class="btn-add-catalog" disabled>Out of Stock</button>
        @else
            <div class="stock-badge in-stock">In Stock ({{ $product->stock_quantity }})</div>
            <button
                class="btn-add-catalog"
                data-product-modal
                data-product-id="{{ $product->id }}"
                data-product-name="{{ $product->name }}"
                data-product-description="{{ $product->description }}"
                data-product-price="{{ $product->price }}"
                data-product-image="{{ $product->image ? asset($product->image) : asset('images/placeholder-cookie.png') }}"
                data-product-stock="{{ $product->stock_quantity }}"
                data-product-category="{{ $product->category }}"
            >View Details</button>
        @endif
    </div>
</div>
@empty
<div style="grid-column: span 3; text-align: center; padding: 60px 0; color: var(--muted);">
    <div style="font-size: 64px; margin-bottom: 20px;">🍪</div>
    <h3 style="font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--dark);">No Treats Found</h3>
    <p style="margin-top: 10px;">We couldn't find any treats matching "{{ $search ?? 'your criteria' }}".</p>
    <a href="{{ route('catalog') }}" style="display: inline-block; margin-top: 20px; color: var(--pink); font-weight: 700; text-decoration: none;">View All Flavors</a>
</div>
@endforelse
