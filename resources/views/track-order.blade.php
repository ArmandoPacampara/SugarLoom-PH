@extends('layouts.app')

@section('title', 'Track Your Treats | SugarLoom PH')

@section('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .track-container {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .track-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 28px;
            padding: 48px 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(216, 84, 123, 0.1);
            text-align: center;
        }

        .track-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .track-header p {
            font-size: 0.95rem;
            color: var(--text-accent);
            margin-bottom: 32px;
        }

        .search-form {
            display: flex;
            gap: 12px;
            margin-bottom: 32px;
        }

        .search-form input {
            flex: 1;
            padding: 14px 20px;
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(216, 84, 123, 0.2);
            border-radius: 999px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            color: var(--text-dark);
            transition: all 0.3s;
        }

        .search-form input:focus {
            outline: none;
            background: white;
            border-color: var(--pink-btn);
            box-shadow: 0 0 0 4px rgba(216, 84, 123, 0.1);
        }

        .btn-track {
            padding: 14px 32px;
            background: var(--pink-btn);
            color: white;
            border: none;
            border-radius: 999px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(216, 84, 123, 0.3);
        }

        .btn-track:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(216, 84, 123, 0.4);
        }

        .tracking-result {
            text-align: left;
            margin-top: 32px;
            padding-top: 32px;
            border-top: 1px solid rgba(216, 84, 123, 0.1);
        }

        .order-summary {
            background: rgba(216, 84, 123, 0.05);
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 32px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .summary-row:last-child { margin-bottom: 0; }
        .summary-row span { color: var(--text-body); }
        .summary-row strong { color: var(--text-dark); font-weight: 700; }

        .timeline {
            position: relative;
            padding-left: 32px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: rgba(216, 84, 123, 0.1);
        }

        .timeline-step {
            position: relative;
            margin-bottom: 24px;
            opacity: 0.4;
            transition: all 0.5s;
        }

        .timeline-step.active {
            opacity: 1;
        }

        .timeline-step::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 4px;
            width: 12px;
            height: 12px;
            background: white;
            border: 3px solid rgba(216, 84, 123, 0.2);
            border-radius: 50%;
            z-index: 1;
            transition: all 0.3s;
        }

        .timeline-step.active::before {
            background: var(--pink-btn);
            border-color: white;
            box-shadow: 0 0 0 4px rgba(216, 84, 123, 0.1);
            transform: scale(1.2);
        }

        .step-content strong {
            display: block;
            font-size: 0.95rem;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .step-content span {
            font-size: 0.85rem;
            color: var(--text-body);
        }

        .alert-notice {
            background: rgba(22, 101, 34, 0.1);
            color: #166534;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.9rem;
        }

        .alert-error {
            background: rgba(185, 28, 28, 0.1);
            color: #b91c1c;
            padding: 14px;
            border-radius: 12px;
            margin-top: 24px;
            font-size: 0.9rem;
        }

        @media (max-width: 480px) {
            .track-card { padding: 40px 24px; }
            .search-form { flex-direction: column; }
            .btn-track { width: 100%; }
        }
    </style>
@endsection

@section('content')
<div class="track-container">
    <div class="track-card" data-aos="zoom-in">
        <div class="track-header">
            <h1>Track Your Treats</h1>
            <p>Enter your order number to see where your sweet dreams are</p>
        </div>

        @if (session('status'))
            <div class="alert-notice">{{ session('status') }}</div>
        @endif

        <form class="search-form" method="GET" action="{{ route('track-order') }}">
            <input type="text" name="tracking_number" value="{{ $trackingNumber }}" placeholder="SL-20260506-XXXXX" required autofocus>
            <button type="submit" class="btn-track">Track Now</button>
        </form>

        @if($trackingNumber && ! $order)
            <div class="alert-error">
                We couldn't find any order with that number. Please double-check and try again! 🍪
            </div>
        @endif

        @if($order)
            <div class="tracking-result" data-aos="fade-up">
                <div class="order-summary">
                    <div class="summary-row">
                        <span>Order Number</span>
                        <strong>{{ $order->order_number }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>Sweet Items</span>
                        <strong>{{ $order->items_summary }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>Total Paid</span>
                        <strong>PHP {{ number_format($order->total, 2) }}</strong>
                    </div>
                    @if($order->lalamove_tracking_number)
                        <div class="summary-row">
                            <span>Courier Tracking</span>
                            <strong>{{ $order->lalamove_tracking_number }}</strong>
                        </div>
                    @endif
                </div>

                <div class="timeline">
                    @php
                        $statusKeys = array_keys($steps);
                        $currentIndex = array_search($order->status, $statusKeys, true);
                        $currentIndex = $currentIndex === false ? 0 : $currentIndex;
                    @endphp

                    @foreach($steps as $status => $step)
                        <div class="timeline-step {{ $loop->index <= $currentIndex ? 'active' : '' }}" 
                             data-aos="fade-left" 
                             data-aos-delay="{{ 100 * $loop->index }}">
                            <div class="step-content">
                                <strong>{{ $step['label'] }}</strong>
                                <span>{{ $loop->index <= $currentIndex ? $step['description'] : 'We\'re getting ready for this step!' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
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
</script>
@endsection
