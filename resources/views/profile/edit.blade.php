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
        input[type="text"], input[type="email"] { width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 10px; box-sizing: border-box; }
        input:focus { outline: none; border-color: var(--pink-nav); box-shadow: 0 0 0 3px var(--pink-pale); }
        
        .btn-primary { background: #fb7185; color: white; border: none; padding: 10px 20px; border-radius: 999px; font-weight: bold; cursor: pointer; transition: opacity 0.2s; }
        .btn-primary:hover { opacity: 0.9; }
        .btn-logout { background: #f3eff1; color: var(--text-body); border: none; padding: 10px 20px; border-radius: 999px; font-weight: bold; cursor: pointer; margin-top: 12px; transition: opacity 0.2s; }
        .btn-logout:hover { opacity: 0.85; }
        .alert-success { background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: bold; }
        
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

        .cart-count {
            position: absolute;
            top: -9px;
            right: -7px;
            color: white;
            font-size: 0.72rem;
            font-weight: 800;
            line-height: 1;
            text-shadow: 0 1px 2px rgba(43, 27, 36, 0.45);
        }

        .cart-count.is-empty { display: none; }
    </style>
@endsection

@section('content')
<div class="container">
    <h1>My Account</h1>

    <!-- Success Message if Profile is Updated -->
    @if (session('status') === 'profile-updated')
        <div class="alert-success">Your profile has been updated successfully!</div>
    @endif

    <div class="grid-2">
        <!-- Account Details Form -->
        <div class="card">
            <h3>Profile Details</h3>
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
                    <input id="city" type="text" name="city" value="{{ old('city', $user->city) }}" required>
                </div>

                <div class="form-group">
                    <label for="postal_code">Postal Code</label>
                    <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" required>
                </div>

                <button type="submit" class="btn-primary" style="margin-top: 10px;">Save Changes</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

        <!-- Order History (Visual Layout) -->
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
                    <p class="order-desc" style="font-size: 12px; margin-top: 6px;">
                        <a href="{{ route('track-order', ['tracking_number' => $order->order_number]) }}">Track this order</a>
                    </p>
                </div>
            @empty
                <p class="order-desc">No orders yet.</p>
            @endforelse
</div>
    </div>
</div>
@endsection

