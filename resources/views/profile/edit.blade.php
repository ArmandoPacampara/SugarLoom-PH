@extends('layouts.app')

@section('title', 'My Account | SugarLoom PH')

@section('styles')
    <style>
        :root {
            --pink-nav:    #e06b87;
            --pink-pale:   #ffd7e1;
            --text-body:   #4a3d45;
            --dark:        #1a1018;
            --white:       #ffffff;
        }
        
        body { background: #fdf2f8; color: #111827; }
        
        /* Page Layout Styles */
        .container { max-width: 1000px; margin: 40px auto; padding: 0 24px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        
        .card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
        h1 { font-size: 28px; margin-bottom: 24px; }
        h3 { margin-top: 0; color: var(--text-body); border-bottom: 1px solid #f3eff1; padding-bottom: 10px; margin-bottom: 20px;}
        
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 14px; font-weight: bold; color: var(--text-body); margin-bottom: 6px; }
        input[type="text"], input[type="email"], select { width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 10px; box-sizing: border-box; background: white; }
        
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23e06b87'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px !important;
            cursor: pointer;
        }
        
        input:focus, select:focus { outline: none; border-color: var(--pink-nav); box-shadow: 0 0 0 3px var(--pink-pale); }
        
        .btn-primary { background: #fb7185; color: white; border: none; padding: 10px 20px; border-radius: 999px; font-weight: bold; cursor: pointer; transition: opacity 0.2s; }
        .btn-primary:hover { opacity: 0.9; }
        .btn-logout { background: #f3eff1; color: var(--text-body); border: none; padding: 10px 20px; border-radius: 999px; font-weight: bold; cursor: pointer; margin-top: 12px; transition: opacity 0.2s; }
        .btn-logout:hover { opacity: 0.85; }
        .alert-success { background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: bold; }
        .points-card { background: #fff7ed; border: 1px solid #fed7aa; color: #9a3412; border-radius: 16px; padding: 16px; margin-bottom: 18px; }
        .points-card strong { display: block; color: #7c2d12; font-size: 26px; line-height: 1; margin-top: 6px; }
        
        /* Order History Styles */
        .order-item { border: 1px solid #f3eff1; border-radius: 12px; padding: 16px; margin-bottom: 12px; }
        .order-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;}
        .order-id { font-weight: bold; color: var(--dark); }
        .order-price { font-weight: bold; color: var(--pink-nav); }
        .order-desc { font-size: 14px; color: gray; margin: 0; }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: bold; }
        .green { background: #dcfce7; color: #16a34a; }
        .blue { background: #dbeafe; color: #2563eb; }
        .yellow { background: #fef9c3; color: #ca8a04; }
        .red { background: #fee2e2; color: #dc2626; }

        .rating-badge { 
            display: inline-block; 
            background: #fde68a; 
            color: #92400e; 
            padding: 4px 10px; 
            border-radius: 999px; 
            font-size: 11px; 
            font-weight: bold;
        }
        
        .btn-rate {
            background: #fb7185;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        
        .btn-rate:hover { opacity: 0.9; }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }
        
        .modal.active { display: flex; align-items: center; justify-content: center; }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 20px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .modal-header {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header h3 { margin: 0; color: #1a1018; }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }
        
        .close-modal:hover { color: #333; }
        
        .rating-input {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: center;
        }
        
        .star-btn {
            background: none;
            border: none;
            font-size: 36px;
            cursor: pointer;
            color: #e5e7eb; /* Default empty star color */
            transition: transform 0.2s, color 0.2s;
        }
        
        .star-btn:hover { transform: scale(1.2); }
        
        .star-btn.active { color: #fbbf24; /* Filled yellow star color */ }
        
        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .modal-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-family: inherit;
            resize: none; /* This makes the textbox fixed */
            height: 120px; /* Fixed height so it doesn't shrink */
            box-sizing: border-box;
        }
        
        .modal-form textarea:focus {
            outline: none;
            border-color: #fb7185;
            box-shadow: 0 0 0 3px #fde68a;
        }
        
        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        
        .btn-submit {
            background: #fb7185;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 999px;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        
        .btn-submit:hover { opacity: 0.9; }
        
        .btn-cancel {
            background: #f3eff1;
            color: #4a3d45;
            border: none;
            padding: 10px 20px;
            border-radius: 999px;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        
        .btn-cancel:hover { opacity: 0.85; }
    </style>
@endsection

@section('content')
<div class="container">
    <h1>My Account</h1>

    @if (session('status') === 'profile-updated')
        <div class="alert-success">Your profile has been updated successfully!</div>
    @endif

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div @class(['grid-2' => $user->isCustomer()])>
        <div class="card">
            <h3>Profile Details</h3>
            
            @if($user->isCustomer())
                <div class="points-card">
                    Reward Points Balance
                    <strong>{{ number_format($user->reward_points) }}</strong>
                </div>
            @endif
            
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                @if($user->isCustomer())
                    <div class="form-group">
                        <label for="phone">Mobile Number</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="shipping_address">Shipping Address</label>
                        <input id="shipping_address" type="text" name="shipping_address" value="{{ old('shipping_address', $user->shipping_address) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <select id="city" name="city" required>
                            <option value="">Select a Metro Manila city</option>
                            @foreach($metroManilaCities as $metroCity)
                                <option value="{{ $metroCity }}" @selected(old('city', $user->city) === $metroCity)>{{ $metroCity }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="postal_code">Postal Code</label>
                        <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" required>
                    </div>
                @endif

                <button type="submit" class="btn-primary" style="margin-top: 10px;">Save Changes</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

        @if($user->isCustomer())
            <div class="card">
                <h3>Recent Purchases</h3>

                @forelse($orders as $order)
                    <div class="order-item">
                        <div class="order-header">
                            <span class="order-id">{{ $order->order_number }}</span>
                            <span @class([
                                'badge',
                                'green' => $order->status === \App\Models\Order::STATUS_DELIVERED,
                                'blue' => $order->status === \App\Models\Order::STATUS_PREPARING || $order->status === \App\Models\Order::STATUS_OUT_FOR_DELIVERY,
                                'yellow' => $order->status === \App\Models\Order::STATUS_PENDING,
                                'red' => $order->status === \App\Models\Order::STATUS_CANCELLED,
                            ])>{{ $order->status_label }}</span>
                        </div>
                        <div class="order-header">
                            <p class="order-desc">{{ $order->items_summary }}</p>
                            <span class="order-price">PHP {{ number_format($order->total, 2) }}</span>
                        </div>
                        <p class="order-desc" style="font-size: 12px; margin-top: 8px;">Placed on {{ $order->placed_at?->format('F j, Y') }}</p>
                        
                        <div style="display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap; align-items: center;">
                            <a href="{{ route('track-order', ['tracking_number' => $order->order_number]) }}" style="font-size: 12px; color: #fb7185; text-decoration: none;">Track this order</a>
                            
                            @if($order->status === \App\Models\Order::STATUS_DELIVERED)
                                @if($order->rating)
                                    <span class="rating-badge">
                                        ★ {{ $order->rating }}/5 - Rated
                                    </span>
                                    @if($order->review_reward_points_awarded)
                                        <span class="rating-badge">+{{ $order->review_reward_points }} pts</span>
                                    @endif
                                @else
                                    <button type="button" class="btn-rate" data-order-id="{{ $order->id }}">Rate Order</button>
                                @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="order-desc">No orders yet.</p>
                @endforelse
            </div>
        @endif
    </div>
</div>

<div id="ratingModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Rate Your Order</h3>
            <button type="button" class="close-modal" onclick="closeRatingModal()">×</button>
        </div>
        
        <form id="ratingForm" class="modal-form" method="POST">
            @csrf
            <input type="hidden" id="orderIdInput" name="order_id">
            
            <div>
                <label style="display: block; margin-bottom: 10px; font-weight: bold; color: #1a1018; text-align: center;">How would you rate your order?</label>
                <div class="rating-input">
                    <button type="button" class="star-btn" data-rating="1" onclick="setRating(1)">★</button>
                    <button type="button" class="star-btn" data-rating="2" onclick="setRating(2)">★</button>
                    <button type="button" class="star-btn" data-rating="3" onclick="setRating(3)">★</button>
                    <button type="button" class="star-btn" data-rating="4" onclick="setRating(4)">★</button>
                    <button type="button" class="star-btn" data-rating="5" onclick="setRating(5)">★</button>
                </div>
                <input type="hidden" id="ratingValue" name="rating" value="0">
            </div>
            
            <div>
                <label for="reviewComment" style="display: block; margin-bottom: 6px; font-weight: bold; color: #1a1018;">Share your experience (optional)</label>
                <textarea id="reviewComment" name="review_comment" placeholder="Tell us what you think about your order..."></textarea>
            </div>
            
            <div class="modal-buttons">
                <button type="button" class="btn-cancel" onclick="closeRatingModal()">Cancel</button>
                <button type="submit" class="btn-submit">Submit Rating</button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentOrderId = null;

    // Handle rate button clicks
    document.querySelectorAll('.btn-rate').forEach(btn => {
        btn.addEventListener('click', function() {
            openRatingModal(this.dataset.orderId);
        });
    });

    function openRatingModal(orderId) {
        currentOrderId = orderId;
        document.getElementById('ratingValue').value = 0;
        document.getElementById('reviewComment').value = '';
        document.querySelectorAll('.star-btn').forEach(btn => btn.classList.remove('active'));
        
        const form = document.getElementById('ratingForm');
        form.action = `/orders/${orderId}/rating`;
        
        document.getElementById('ratingModal').classList.add('active');
    }

    function closeRatingModal() {
        document.getElementById('ratingModal').classList.remove('active');
        currentOrderId = null;
    }

    function setRating(stars) {
        document.getElementById('ratingValue').value = stars;
        document.querySelectorAll('.star-btn').forEach((btn, index) => {
            if (index < stars) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    // Close modal when clicking outside
    document.getElementById('ratingModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeRatingModal();
        }
    });
</script>
@endsection