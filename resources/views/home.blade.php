@extends('layouts.app')

@section('title', 'SugarLoom PH – Where Sweet Dreams Are Woven')

@section('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --pink-bg-base:#f6ccd6;
        }

        /* ── ANIMATIONS ── */
        @keyframes float {
            0% { transform: translateY(-50%) translateX(0px); }
            50% { transform: translateY(-52%) translateX(10px); }
            100% { transform: translateY(-50%) translateX(0px); }
        }

        @keyframes pulse-soft {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }

        .cart-shake { animation: shake 0.4s ease-in-out; }

        /* ── HERO ── */
        .hero {
            background-color: var(--pink-bg-base);
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            padding: 0 4rem;
            position: relative;
            overflow: hidden;
        }

        /* The distinct curved shape behind the cookies */
        .hero::before {
            content: '';
            position: absolute;
            top: -10%;
            right: -10%;
            width: 65vw;
            height: 120vh;
            background: linear-gradient(135deg, #fef4f6 0%, #f1a9bf 80%);
            border-radius: 50% 0 0 50%;
            z-index: 1;
        }

        .hero-text {
            width: 50%;           
            max-width: 750px;
            position: relative;
            z-index: 3;
            margin-top: -2rem;
        }

        .hero-text h1 {
            font-size: clamp(3.5rem, 6vw, 5.5rem);
            line-height: 0.95; 
            font-weight: 900;
            margin-bottom: 1.5rem;
            letter-spacing: -0.04em;
        }

        .hero-text h1 .accent {
            color: var(--text-accent);
            display: block;
        }

        .hero-text p {
            font-size: 0.95rem;
            font-weight: 300;
            line-height: 1.8;
            max-width: 440px;
            margin-bottom: 2.5rem;
        }

        .hero-buttons { display: flex; gap: 1.25rem; flex-wrap: wrap; }

        .btn {
            border-radius: 999px;
            padding: 0.85rem 2.2rem;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            border: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            display: inline-block;
        }
       
        .btn:hover { transform: translateY(-4px) scale(1.02); }
       
        .btn-primary {
            background: var(--pink-btn);
            color: white;
            box-shadow: 0 8px 24px rgba(206, 90, 122, 0.3);
        }
        .btn-primary:hover {
            box-shadow: 0 12px 30px rgba(206, 90, 122, 0.45);
        }
       
        .btn-white {
            background: var(--white);
            color: var(--text-body);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }
        .btn-white:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .hero-image {
            position: absolute;
            right: -5%;            
            top: 50%;
            transform: translateY(-50%);
            width: 55%;            
            max-width: 850px;      
            z-index: 2;
            display: flex;
            justify-content: flex-end;
            animation: float 6s ease-in-out infinite;
        }
       
        .hero-image img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: contain;
            filter: drop-shadow(0 20px 50px rgba(0,0,0,0.15));
            transform: scale(1.1); 
        }

        /* ── SECTION COMMONS ── */
        .section { padding: 5rem 4rem; }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 3rem;
        }

        .section-header h2 { font-size: 2.5rem; font-weight: 800; }
        .section-header p { font-size: 1rem; color: var(--text-body); margin-top: 0.5rem; font-weight: 300; }

        .view-all {
            font-size: 0.95rem;
            color: var(--pink-btn);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            white-space: nowrap;
            transition: gap 0.2s, transform 0.2s;
        }
        .view-all:hover { gap: 0.55rem; transform: translateX(5px); }


        /* ── BEST SELLERS ── */
        .best-sellers { background: var(--white); position: relative; }


        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }


        .product-card {
            border: 1px solid #f4e9ec;
            border-radius: var(--radius-card);
            overflow: hidden;
            background: var(--white);
            box-shadow: var(--shadow-card);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
       
        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(201,75,118,0.2);
            border-color: var(--pink-bg-base);
        }


        .product-card-img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            display: block;
            background: #fdf1f4;
            transition: transform 0.6s;
        }
        .product-card:hover .product-card-img {
            transform: scale(1.1);
        }


        .product-card-body { padding: 1.5rem; }


        .product-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }
       
        .product-card-top h3 { font-size: 1.25rem; font-weight: 700; line-height: 1.2; }
        .product-price { font-weight: 700; font-size: 1.1rem; color: var(--pink-btn); }


        .product-desc { font-size: 0.9rem; font-weight: 300; line-height: 1.6; margin-bottom: 1.5rem; }


        .btn-add {
            width: 100%;
            padding: 0.8rem;
            border-radius: 999px;
            border: 1.5px solid #f0e1e5;
            background: white;
            color: var(--text-dark);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }
       
        .btn-add:hover {
            background: var(--pink-btn);
            color: white;
            border-color: var(--pink-btn);
            transform: scale(1.05);
        }


        /* ── FLAVOR QUIZ CTA ── */
        .quiz-section { background: var(--cream); padding: 4rem; }


        .quiz-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-radius: 28px;
            overflow: hidden;
            min-height: 300px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        .quiz-card:hover { transform: scale(1.01); }


    .quiz-img-wrap {
        flex: 1; 
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3.5rem 3.5rem 3.5rem 0; 
    }

    .quiz-img {
        width: 100%; 
        height: 100%;
        max-height: 330px; 
        object-fit: cover; 
        object-position: center;
        border-radius: 16px; 
        box-shadow: 0 8px 24px rgba(0,0,0,0.12); 
    }

        .quiz-content {
            background: #fae6eb;
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 1.25rem;
        }
       
        .quiz-content h2 { font-size: 2.2rem; font-weight: 800; line-height: 1.2; }
        .quiz-content p { font-size: 1rem; font-weight: 300; line-height: 1.7; }


        .btn-quiz {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--pink-btn);
            color: white;
            border: none;
            border-radius: 999px;
            padding: 0.9rem 1.8rem;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            width: fit-content;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 20px rgba(209, 91, 123, 0.25);
            font-family: 'Poppins', sans-serif;
        }
        .btn-quiz:hover { 
            transform: translateY(-4px) scale(1.05); 
            box-shadow: 0 12px 25px rgba(209, 91, 123, 0.4);
        }
        .btn-quiz span { display: inline-block; animation: pulse-soft 2s infinite; }


        /* ── TESTIMONIALS ── */
        .testimonials { background: var(--white); }


        .testimonials .section-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 3.5rem;
        }


        .divider {
            width: 60px; height: 4px;
            background: var(--pink-btn);
            border-radius: 2px;
            margin: 1rem auto 0;
            transition: width 0.6s cubic-bezier(0.65, 0, 0.35, 1);
        }
        .testimonials:hover .divider { width: 120px; }


        .reviews-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }


        .review-card {
            padding: 2.25rem;
            border: 1px solid #f4e9ec;
            border-radius: var(--radius-card);
            background: var(--cream);
            transition: all 0.3s;
        }
        .review-card:hover { 
            transform: scale(1.03); 
            background: var(--white);
            box-shadow: 0 15px 30px rgba(201,75,118,0.1);
        }


        .review-quote {
            font-size: 3.5rem;
            color: #f09ab0;
            line-height: 0.8;
            font-weight: 900;
            margin-bottom: 0.5rem;
        }


        .stars { color: #f4a623; font-size: 1rem; letter-spacing: 2px; margin-bottom: 1rem; }


        .review-text { font-size: 0.95rem; font-weight: 300; line-height: 1.7; margin-bottom: 1.5rem; }


        .reviewer { display: flex; align-items: center; gap: 1rem; }


        .reviewer-avatar {
            width: 44px; height: 44px;
            border-radius: 50%;
            background: #f09ab0;
            display: grid;
            place-items: center;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
            overflow: hidden;
            transition: transform 0.3s;
        }
        .review-card:hover .reviewer-avatar { transform: rotate(10deg) scale(1.1); }
        .reviewer-avatar img { width: 100%; height: 100%; object-fit: cover; }


        .reviewer-name { font-size: 0.95rem; font-weight: 700; color: var(--text-dark); }
        .reviewer-role { font-size: 0.8rem; font-weight: 500; color: var(--pink-btn); text-transform: uppercase; letter-spacing: 0.05em; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .hero-text h1 { font-size: 3.5rem; }
            .hero-image { width: 50%; }
        }

        @media (max-width: 900px) {
            .section { padding: 4rem 2rem; }
            .hero { padding: 4rem 2rem; flex-direction: column; align-items: flex-start; }
            .hero::before { width: 100vw; height: 100vw; top: 20%; right: 0; border-radius: 50%; }
            .hero-text { width: 100%; max-width: 100%; margin-bottom: 3rem; }
            .hero-image { position: relative; width: 100%; transform: none; display: flex; justify-content: center; animation: float-mobile 6s infinite; }
            @keyframes float-mobile {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-15px); }
            }
            .hero-image img { width: 80%; }
            .products-grid, .reviews-grid { grid-template-columns: 1fr 1fr; }
            .quiz-card { grid-template-columns: 1fr; }
            .quiz-img { height: 260px; }
            footer { padding: 3rem 2rem; }
        }

        @media (max-width: 600px) {
            .products-grid, .reviews-grid { grid-template-columns: 1fr; }
            .hero-text h1 { font-size: 3rem; }
            .hero-buttons { flex-direction: column; width: 100%; }
            .btn { text-align: center; width: 100%; }
        }
    </style>
@endsection

@section('content')
<section class="hero">
    <div class="hero-text" data-aos="fade-right" data-aos-duration="1000">
        <h1>
            Where sweet<br>
            dreams are<br>
            <span class="accent">woven!</span>
        </h1>
        <p>Indulge in our small-batch, handcrafted cookies baked daily with premium ingredients and a touch of artisanal magic.</p>
        <div class="hero-buttons">
            <a href="{{ route('catalog') }}" class="btn btn-primary">Shop Now</a>
            <a href="{{ route('about') }}" class="btn btn-white">Our Story</a>
        </div>
    </div>
    <div class="hero-image" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200">
        <img src="{{ asset('images/cookies.png') }}" alt="Freshly baked cookies scattered">
    </div>
</section>

<section class="section best-sellers">
    <div class="section-header" data-aos="fade-up">
        <div>
            <h2>Best Sellers</h2>
            <p>The flavors that captured everyone's hearts.</p>
        </div>
        <a href="{{ route('catalog') }}" class="view-all">View All Catalog →</a>
    </div>

    <div class="products-grid">
        @foreach($bestSellers as $product)
        <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <img
                class="product-card-img"
                src="{{ $product->image ? asset($product->image) : asset('images/placeholder-cookie.png') }}"
                alt="{{ $product->name }}"
            >
            <div class="product-card-body">
                <div class="product-card-top">
                    <h3>{{ $product->name }}</h3>
                    <span class="product-price">₱{{ number_format($product->price, 0) }}</span>
                </div>
                <p class="product-desc">{{ $product->description }}</p>
                <button class="btn-add" data-product-id="{{ $product->id }}">Add to Box</button>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section class="quiz-section">
    <div class="quiz-card" data-aos="flip-up" data-aos-duration="1000">
        <img class="quiz-img" src="{{ asset('images/baking.png') }}" alt="Baking ingredients">
        <div class="quiz-content">
            <h2>Can't decide on a flavor?</h2>
            <p>Our flavor artisan can help you find your perfect match based on your taste profile. Whether you like it salty-sweet or intensely dark.</p>
            <button class="btn-quiz">
                <span>✦</span> Take the Flavor Quiz
            </button>
        </div>
    </div>
</section>

<section class="section testimonials">
    <div class="section-header" data-aos="fade-up">
        <h2>What Our Loomers Say</h2>
        <div class="divider"></div>
    </div>

    <div class="reviews-grid">
        @foreach($testimonials as $review)
        <div class="review-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
            <div class="review-quote">"</div>
            <div class="stars">★★★★★</div>
            <p class="review-text">{{ $review->content }}</p>
            <div class="reviewer">
                <div class="reviewer-avatar">
                    @if($review->avatar)
                        <img src="{{ asset('storage/' . $review->avatar) }}" alt="{{ $review->name }}">
                    @else
                        {{ strtoupper(substr($review->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="reviewer-name">{{ $review->name }}</div>
                    <div class="reviewer-role">{{ $review->label }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        duration: 800,
        easing: 'ease-out-cubic'
    });

    // Use data attributes instead of inline onclick to avoid Blade/JS conflicts
    document.querySelectorAll('.btn-add[data-product-id]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            addToCart(this.dataset.productId);
        });
    });

    function addToCart(productId) {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            updateCartCount(data.count || 0);
            showToast(data.message || 'Added to box! 🍪');
            
            // Animation for cart
            const cartAction = document.getElementById('cartAction');
            if (cartAction) {
                cartAction.classList.add('cart-shake');
                setTimeout(() => cartAction.classList.remove('cart-shake'), 400);
            }
        })
        .catch(function() {
            showToast('Something went wrong. Please try again.');
        });
    }
</script>
@endsection
