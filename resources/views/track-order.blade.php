@extends('layouts.app')

@section('title', 'Track Order | SugarLoom PH')

@section('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --pink-deep:   #d8547b; 
            --pink-light:  #f8bac9;
            --pink-pale:   #ffd7e1;
        }

        /* ── ANIMATIONS ── */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }
        .cart-shake { animation: shake 0.4s ease-in-out; }

        body { background: #fdf2f8; color: #111827; }

        /* Page Layout Styles */
        .container { 
            min-height: calc(100vh - 70px - 140px); /* 70px navbar, approx 140px footer */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card { 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 8px 25px rgba(216, 84, 123, 0.1); 
            text-align: center;
            transition: transform 0.3s;
            width: 100%;
            max-width: 600px;
        }
        .card:hover { transform: translateY(-5px); }
        
        h1 { font-size: 28px; margin-top: 0; color: var(--pink-deep); margin-bottom: 10px; }
        p.subtitle { color: gray; margin-bottom: 30px; font-size: 15px; }

        .search-form { display: flex; gap: 10px; justify-content: center; margin-bottom: 20px; }
        input[type="text"] { width: 65%; padding: 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 16px; transition: border-color 0.2s; }
        input:focus { outline: none; border-color: var(--pink-nav); }
        
        .btn-primary { 
            background: #fb7185; 
            color: white; 
            border: none; 
            padding: 0 24px; 
            border-radius: 10px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: all 0.3s; 
            font-size: 16px; 
        }
        .btn-primary:hover { opacity: 0.9; transform: scale(1.05); box-shadow: 0 5px 15px rgba(251, 113, 133, 0.3); }

        hr { border: none; border-top: 1px solid #f3eff1; margin: 30px 0; }

        /* Timeline Styles */
        .tracking-result { text-align: left; }
        .tracking-result h3 { margin-top: 0; margin-bottom: 24px; color: var(--dark); }
        
        .timeline { display: flex; flex-direction: column; gap: 24px; position: relative; }
        .timeline::before {
            content: ''; position: absolute; left: 11px; top: 10px; bottom: 10px; width: 2px; background: #e5e7eb; z-index: 0;
        }

        .timeline-step { 
            display: flex; 
            align-items: flex-start; 
            gap: 20px; 
            position: relative; 
            z-index: 1; 
            opacity: 0.3; 
            transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            transform: translateX(-10px);
        }
        .timeline-step.active { opacity: 1; transform: translateX(0); }
        
        .dot { 
            width: 24px; 
            height: 24px; 
            border-radius: 50%; 
            background: white; 
            border: 3px solid #e5e7eb; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            box-sizing: border-box; 
            transition: all 0.3s;
        }
        .timeline-step.active .dot { border-color: var(--pink-nav); background: var(--pink-pale); }
        
        .info { display: flex; flex-direction: column; padding-top: 2px; }
        .info strong { font-size: 16px; color: var(--dark); }
        .info .time { font-size: 13px; color: gray; margin-top: 4px; }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="card" data-aos="zoom-in">
        <h1>Track Your Order</h1>
        <p class="subtitle">Enter your order ID below to check the current delivery status.</p>

        <!-- Tracking Input Form -->
        <form class="search-form" method="GET" action="{{ route('track-order') }}" data-aos="fade-up" data-aos-delay="200">
            <input type="text" name="tracking_number" value="{{ request('tracking_number') }}" placeholder="e.g. SL-123456-PH" required>
            <button type="submit" class="btn-primary">Track</button>
        </form>

        <!-- Progress Display (Only shows if a tracking number is submitted) -->
        @if(request('tracking_number'))
            <hr>
            <div class="tracking-result">
                <h3 data-aos="fade-right">Status for: <span style="color: var(--pink-nav);">{{ request('tracking_number') }}</span></h3>
                
                <div class="timeline">
                    <!-- Step 1 -->
                    <div class="timeline-step active" data-aos="fade-left" data-aos-delay="300">
                        <div class="dot"></div>
                        <div class="info">
                            <strong>Order Confirmed</strong>
                            <span class="time">Payment verified. We've received your order!</span>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="timeline-step active" data-aos="fade-left" data-aos-delay="400">
                        <div class="dot"></div>
                        <div class="info">
                            <strong>Preparing Sweets</strong>
                            <span class="time">Our bakers are currently preparing your items.</span>
                        </div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="timeline-step" data-aos="fade-left" data-aos-delay="500">
                        <div class="dot"></div>
                        <div class="info">
                            <strong>Out for Delivery</strong>
                            <span class="time">Pending rider pickup.</span>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="timeline-step" data-aos="fade-left" data-aos-delay="600">
                        <div class="dot"></div>
                        <div class="info">
                            <strong>Delivered</strong>
                            <span class="time">Pending.</span>
                        </div>
                    </div>
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
