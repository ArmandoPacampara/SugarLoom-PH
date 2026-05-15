@extends('layouts.app')

@php
    $fallbackImages = [
        'red velvet' => 'images/Red Velvet Cookie.png',
        'chocolate chip' => 'images/cookies.png',
        'brownies' => 'images/Brownies.png',
        's\'mores' => 'images/S\'mores Cookie.png',
        'gourmet s\'mores' => 'images/smores.jpg',
        'mocha' => 'images/Mocha Cookie.png',
        'strawberry' => 'images/Strawberry Cookie.png',
        'matcha' => 'images/Matcha Cookie.png',
    ];

    $imageFor = function ($item) use ($fallbackImages) {
        if (! empty($item['image']) && file_exists(public_path($item['image']))) {
            return asset($item['image']);
        }

        $key = strtolower($item['name'] ?? '');

        return asset($fallbackImages[$key] ?? 'images/cookies1.jpeg');
    };
@endphp

@section('title', 'Rewards | SugarLoom PH')

@section('styles')
    <style>
        .page {
            padding: 3rem 4rem 5rem;
            max-width: 1180px;
            margin: 0 auto;
            position: relative;
        }

        .back-link-wrapper {
            position: absolute;
            left: -120px;
            top: 0;
            display: flex;
            align-items: center;
        }

        .back-link {
            margin-top: 45px;
            margin-left: 80px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 14px 18px;
            border-radius: 14px;
            background: #fdf2f8;
            color: #000000;
            text-decoration: none;
            font-weight: 700;
            border: 1px solid #f3e8ff;
            white-space: nowrap;
        }

        @media (max-width: 1280px) {
            .back-link-wrapper {
                position: static;
                margin-bottom: 1rem;
            }
        }

        .rewards-hero {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .rewards-hero-left {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-width: 680px;
        }

        .rewards-title-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .rewards-header {
            margin: 0;
        }

        .rewards-header h1 {
            font-size: 2.4rem;
            margin: 0;
        }

        .rewards-hero-left p {
            margin: 0;
            max-width: 620px;
            color: #52525b;
            line-height: 1.75;
        }

        .reward-balance {
            padding: 1.75rem 1.75rem 1.85rem;
            border-radius: 24px;
            background: #fff7ed;
            border: 1px solid #ffedd5;
            width: min(100%, 360px);
            display: grid;
            gap: 0.8rem;
            color: #9a3412;
            box-shadow: 0 10px 30px rgba(255, 133, 94, 0.08);
        }

        .reward-balance strong {
            display: block;
            font-size: 2.4rem;
            line-height: 1;
            color: #7c2d12;
        }

        .reward-balance p {
            margin: 0;
            color: #7c2d12;
            line-height: 1.6;
        }

        .reward-balance .reward-detail {
            color: #92400e;
            font-weight: 600;
        }

        .reward-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.5rem;
        }

        .reward-card {
            display: grid;
            grid-template-rows: auto 1fr auto;
            gap: 1rem;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #f3f4f6;
            background: white;
            box-shadow: 0 12px 40px rgba(15, 23, 42, 0.05);
        }

        .reward-card img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
        }

        .reward-content {
            padding: 1.4rem 1.6rem 1.6rem;
            display: grid;
            gap: 0.8rem;
        }

        .reward-content h2 {
            margin: 0;
            font-size: 1.15rem;
        }

        .reward-content p {
            margin: 0;
            color: #52525b;
            line-height: 1.7;
        }

        .reward-meta {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .reward-actions {
            display: grid;
            gap: 0.75rem;
        }

        .btn-primary,
        .btn-disabled {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 12px 18px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: #fb7185;
            color: white;
            border: 1px solid transparent;
        }

        .btn-disabled {
            color: #9ca3af;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            cursor: not-allowed;
        }

        @media (max-width: 960px) {
            .rewards-hero {
                flex-direction: column;
            }

            .reward-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 680px) {
            .page { padding: 2rem 1.25rem 4rem; }
            .reward-grid { grid-template-columns: 1fr; }
        }
    </style>
@endsection

@section('content')
<main class="page">
    <div class="back-link-wrapper">
        <a href="{{ route('cart.index') }}" class="back-link">← Back </a>
    </div>

    <div class="rewards-hero">
        <div class="rewards-hero-left">
            <div class="rewards-title-row">
                <h1>Rewards</h1>
            </div>
            <p>Use your SugarLoom points to unlock free reward products, or keep building your balance for the next redemption.</p>
        </div>

        <div class="reward-balance">
            <strong>{{ number_format($rewardPointBalance) }} points</strong>
            <p>Your available reward balance.</p>
            @auth
                @if($rewardPointBalance >= $productRewardPointCost)
                    <p>You can redeem a reward product today at checkout.</p>
                @else
                    <p>Earn {{ number_format($productRewardPointCost - $rewardPointBalance) }} more points to redeem your first item.</p>
                @endif
            @else
                <p><a href="{{ route('login') }}" class="btn-primary">Log in to redeem rewards</a></p>
            @endauth
        </div>
    </div>

    <div class="reward-grid">
        @forelse($rewardProducts as $rewardProduct)
            <article class="reward-card">
                <img src="{{ $imageFor($rewardProduct->toArray()) }}" alt="{{ $rewardProduct->name }}">
                <div class="reward-content">
                    <h2>{{ $rewardProduct->name }}</h2>
                    <p>{{ $rewardProduct->short_description ?: $rewardProduct->description }}</p>
                    <div class="reward-meta">{{ number_format($productRewardPointCost) }} points · {{ $rewardProduct->stock_quantity }} in stock</div>
                </div>
                <div class="reward-actions">
                    @auth
                        @if($rewardPointBalance >= $productRewardPointCost)
                            <a href="{{ route('cart.index') }}" class="btn-primary">Choose at Checkout</a>
                        @else
                            <span class="btn-disabled">Need {{ number_format($productRewardPointCost - $rewardPointBalance) }} more points</span>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">Log in to Redeem</a>
                    @endauth
                </div>
            </article>
        @empty
            <div class="reward-card" style="grid-column: 1 / -1; text-align: center; padding: 2rem;">
                <h2>No rewards available right now</h2>
                <p>Check back later when we have reward products ready to redeem.</p>
            </div>
        @endforelse
    </div>
</main>
@endsection
