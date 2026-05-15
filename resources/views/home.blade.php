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
            background: linear-gradient(135deg, rgba(254, 244, 246, 0.9) 0%, rgba(241, 169, 191, 0.4) 80%);
            border-radius: 50% 0 0 50%;
            z-index: 1;
            backdrop-filter: blur(10px);
        }

        .hero-text {
            width: 50%;           
            max-width: 750px;
            position: relative;
            z-index: 3;
            margin-left: 3.5rem;
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
        .best-sellers { background: transparent; position: relative; }


        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }


        .product-card {
            border: 1px solid rgba(244, 233, 236, 0.6);
            border-radius: var(--radius-card);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
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

        .btn-add:disabled {
            background: #f3eff1;
            color: #a0a0a0;
            border-color: #e0d0d5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-add:disabled:hover {
            background: #f3eff1;
            color: #a0a0a0;
            transform: none;
        }

        .stock-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.4rem 0.8rem;
            border-radius: 999px;
            margin-bottom: 0.8rem;
        }

        .stock-badge.in-stock {
            background: #dcfce7;
            color: #16a34a;
        }

        .stock-badge.out-of-stock {
            background: #fee2e2;
            color: #dc2626;
        }
        .quiz-section { background: transparent; padding: 4rem; }

        .quiz-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-radius: 28px;
            overflow: hidden;
            min-height: 300px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(8px);
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
            background: rgba(250, 230, 235, 0.6);
            backdrop-filter: blur(5px);
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

        .quiz-modal {
            position: fixed;
            inset: 0;
            z-index: 10001;
            display: grid;
            place-items: center;
            padding: 1.5rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.24s ease;
        }

        .quiz-modal.is-open {
            opacity: 1;
            pointer-events: auto;
        }

        .quiz-modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(43, 27, 36, 0.52);
            backdrop-filter: blur(6px);
        }

        .quiz-dialog {
            position: relative;
            width: min(720px, 100%);
            background: white;
            border-radius: 22px;
            padding: 2rem;
            box-shadow: 0 26px 80px rgba(43, 27, 36, 0.28);
            transform: translateY(18px) scale(0.98);
            transition: transform 0.24s ease;
        }

        .quiz-modal.is-open .quiz-dialog { transform: translateY(0) scale(1); }

        .quiz-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 50%;
            background: #fff2f5;
            color: var(--text-dark);
            font-size: 1.4rem;
            cursor: pointer;
        }

        .quiz-progress {
            height: 8px;
            border-radius: 999px;
            background: #f8dce4;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .quiz-progress span {
            display: block;
            height: 100%;
            width: 0;
            border-radius: inherit;
            background: var(--pink-btn);
            transition: width 0.25s ease;
        }

        .quiz-step-label {
            color: var(--pink-btn);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.5rem;
        }

        .quiz-question {
            font-size: 1.8rem;
            line-height: 1.2;
            margin-bottom: 1.25rem;
        }

        .quiz-options {
            display: grid;
            gap: 0.8rem;
        }

        .quiz-option {
            width: 100%;
            border: 1px solid #f0e1e5;
            border-radius: 14px;
            background: #fffafb;
            color: var(--text-dark);
            padding: 1rem 1.1rem;
            text-align: left;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.18s ease, border-color 0.18s ease, background 0.18s ease;
        }

        .quiz-option:hover {
            transform: translateY(-2px);
            border-color: var(--pink-btn);
            background: #fff3f6;
        }

        .quiz-result {
            display: none;
            gap: 1.2rem;
            align-items: center;
        }

        .quiz-result.is-visible {
            display: grid;
            grid-template-columns: 160px 1fr;
        }

        .quiz-result img {
            width: 160px;
            height: 160px;
            border-radius: 16px;
            object-fit: cover;
            background: #fdf1f4;
        }

        .quiz-result h3 {
            font-size: 1.7rem;
            margin-bottom: 0.6rem;
        }

        .quiz-result p {
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .quiz-result-actions {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
        }

        .quiz-result-actions .btn {
            width: auto;
            padding: 0.75rem 1.2rem;
        }


        /* ── TESTIMONIALS ── */
        .testimonials { background: transparent; }


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
            border: 1px solid rgba(244, 233, 236, 0.6);
            border-radius: var(--radius-card);
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
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
            .quiz-result.is-visible { grid-template-columns: 1fr; }
            .quiz-result img { width: 100%; height: 220px; }
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
                @if($product->isOutOfStock())
                    <div class="stock-badge out-of-stock">Out of Stock</div>
                    <button class="btn-add" disabled>Out of Stock</button>
                @else
                    <div class="stock-badge in-stock">In Stock ({{ $product->stock_quantity }})</div>
                    <button
                        class="btn-add"
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
        @endforeach
    </div>
</section>

<section class="quiz-section">
    <div class="quiz-card" data-aos="flip-up" data-aos-duration="1000">
        <img class="quiz-img" src="{{ asset('images/baking.png') }}" alt="Baking ingredients">
        <div class="quiz-content">
            <h2>Can't decide on a flavor?</h2>
            <p>Our flavor artisan can help you find your perfect match based on your taste profile. Whether you like it salty-sweet or intensely dark.</p>
            <button class="btn-quiz" id="openQuiz" type="button">
                <span>✦</span> Take the Quiz
            </button>
        </div>
    </div>
</section>

<div class="quiz-modal" id="quizModal" aria-hidden="true">
    <div class="quiz-modal-overlay" data-quiz-close></div>
    <div class="quiz-dialog" role="dialog" aria-modal="true" aria-labelledby="quizQuestion">
        <button type="button" class="quiz-close" data-quiz-close aria-label="Close quiz">&times;</button>
        <div class="quiz-progress" aria-label="Quiz progress"><span id="quizProgress"></span></div>
        <div id="quizQuestionWrap">
            <div class="quiz-step-label" id="quizStepLabel"></div>
            <h2 class="quiz-question" id="quizQuestion"></h2>
            <div class="quiz-options" id="quizOptions"></div>
        </div>
        <div class="quiz-result" id="quizResult">
            <img id="quizResultImage" src="" alt="">
            <div>
                <div class="quiz-step-label">Your match</div>
                <h3 id="quizResultName"></h3>
                <p id="quizResultText"></p>
                <div class="quiz-result-actions">
                    <button type="button" class="btn btn-primary" id="quizResultDetails">View Details</button>
                    <button type="button" class="btn btn-white" id="quizRestart">Retake Quiz</button>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="section testimonials">
    <div class="section-header" data-aos="fade-up">
        <h2>What Our Loomers Say</h2>
        <div class="divider"></div>
    </div>

    <div class="reviews-grid">
        @forelse($testimonials->concat($orderRatings ?? []) as $review)
        <div class="review-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
            <div class="review-quote">"</div>
            <div class="stars">
                @if(isset($review->stars) && $review->stars)
                    @for($i = 0; $i < 5; $i++)
                        @if($i < $review->stars)★@else☆@endif
                    @endfor
                @else
                    @for($i = 0; $i < 5; $i++)
                        @if($i < ($review->rating ?? 0))★@else☆@endif
                    @endfor
                @endif
            </div>
            <p class="review-text">{{ $review->content ?? $review->review_comment ?? 'Wonderful experience with the order!' }}</p>
            <div class="reviewer">
                <div class="reviewer-avatar">
                    @if(isset($review->avatar) && $review->avatar)
                        <img src="{{ asset('storage/' . $review->avatar) }}" alt="{{ $review->name ?? $review->customer_name }}">
                    @else
                        {{ strtoupper(substr($review->name ?? $review->customer_name ?? 'A', 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="reviewer-name">{{ $review->name ?? $review->customer_name }}</div>
                    <div class="reviewer-role">{{ $review->label ?? 'Verified Buyer' }}</div>
                </div>
            </div>
        </div>
        @empty
        @endforelse
    </div>
</section>

@include('partials.product-modal')
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        duration: 800,
        easing: 'ease-out-cubic'
    });

    const quizProducts = @json($quizProductRecommendations);

    const quizQuestions = [
        {
            text: 'What kind of treat are you craving right now?',
            options: [
                { label: 'Chocolatey and rich', category: 'sweet' },
                { label: 'Salty-sweet and cozy', category: 'savory' },
                { label: 'Something special for sharing', category: 'specialty' }
            ]
        },
        {
            text: 'Pick your ideal flavor mood.',
            options: [
                { label: 'Classic comfort', category: 'sweet' },
                { label: 'Bold and indulgent', category: 'specialty' },
                { label: 'Light with a drink on the side', category: 'beverage' }
            ]
        },
        {
            text: 'How adventurous is your sweet tooth today?',
            options: [
                { label: 'Keep it familiar', category: 'sweet' },
                { label: 'Surprise me a little', category: 'specialty' },
                { label: 'I want a savory twist', category: 'savory' }
            ]
        }
    ];

    const quizModal = document.getElementById('quizModal');
    const quizQuestionWrap = document.getElementById('quizQuestionWrap');
    const quizProgress = document.getElementById('quizProgress');
    const quizStepLabel = document.getElementById('quizStepLabel');
    const quizQuestion = document.getElementById('quizQuestion');
    const quizOptions = document.getElementById('quizOptions');
    const quizResult = document.getElementById('quizResult');
    const quizResultImage = document.getElementById('quizResultImage');
    const quizResultName = document.getElementById('quizResultName');
    const quizResultText = document.getElementById('quizResultText');
    const quizResultDetails = document.getElementById('quizResultDetails');
    let quizIndex = 0;
    let quizScores = {};

    function openQuiz() {
        quizIndex = 0;
        quizScores = {};
        quizResult.classList.remove('is-visible');
        quizQuestionWrap.style.display = 'block';
        quizModal.classList.add('is-open');
        quizModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        renderQuizQuestion();
    }

    function closeQuiz() {
        quizModal.classList.remove('is-open');
        quizModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }

    function renderQuizQuestion() {
        const current = quizQuestions[quizIndex];
        quizProgress.style.width = `${(quizIndex / quizQuestions.length) * 100}%`;
        quizStepLabel.textContent = `Question ${quizIndex + 1} of ${quizQuestions.length}`;
        quizQuestion.textContent = current.text;
        quizOptions.innerHTML = '';

        current.options.forEach(function(option) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'quiz-option';
            button.textContent = option.label;
            button.addEventListener('click', function() {
                quizScores[option.category] = (quizScores[option.category] || 0) + 1;
                quizIndex += 1;

                if (quizIndex >= quizQuestions.length) {
                    showQuizResult();
                } else {
                    renderQuizQuestion();
                }
            });
            quizOptions.appendChild(button);
        });
    }

    function showQuizResult() {
        const winningCategory = Object.keys(quizScores).sort(function(a, b) {
            return quizScores[b] - quizScores[a];
        })[0] || 'sweet';
        const recommendation = quizProducts.find(function(product) {
            return product.category === winningCategory && product.stock > 0;
        }) || quizProducts.find(function(product) {
            return product.stock > 0;
        }) || quizProducts[0];

        quizProgress.style.width = '100%';
        quizQuestionWrap.style.display = 'none';
        quizResult.classList.add('is-visible');

        if (!recommendation) {
            quizResultName.textContent = 'Catalog List';
            quizResultText.textContent = 'Your best match is waiting in the catalog.';
            quizResultImage.src = '{{ asset('images/cookies.png') }}';
            quizResultDetails.textContent = 'View Catalog';
            quizResultDetails.onclick = function() {
                window.location.href = '{{ route('catalog') }}';
            };
            return;
        }

        quizResultImage.src = recommendation.image;
        quizResultImage.alt = recommendation.name;
        quizResultName.textContent = recommendation.name;
        quizResultText.textContent = recommendation.description;
        quizResultDetails.textContent = 'View Details';
        Object.assign(quizResultDetails.dataset, {
            productId: recommendation.id,
            productName: recommendation.name,
            productDescription: recommendation.description,
            productPrice: recommendation.price,
            productImage: recommendation.image,
            productStock: recommendation.stock,
            productCategory: recommendation.category
        });
        quizResultDetails.onclick = function() {
            closeQuiz();
            if (typeof window.openProductModal === 'function') {
                window.openProductModal(quizResultDetails);
            }
        };
    }

    document.getElementById('openQuiz').addEventListener('click', openQuiz);
    document.getElementById('quizRestart').addEventListener('click', openQuiz);
    document.querySelectorAll('[data-quiz-close]').forEach(function(element) {
        element.addEventListener('click', closeQuiz);
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && quizModal.classList.contains('is-open')) {
            closeQuiz();
        }
    });
</script>
@endsection
