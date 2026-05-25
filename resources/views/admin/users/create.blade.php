@extends('layouts.app')

@section('title', 'Add User | SugarLoom PH')

@section('styles')
    <style>
        body { background: #fdf2f8; color: #111827; }
        .container { max-width: 860px; margin: auto; padding: 24px 24px 80px; }
        .card { background: rgba(255, 255, 255, 0.9); border-radius: 20px; padding: 24px; border: 1px solid rgba(255, 255, 255, 0.4); box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        h1 { margin: 0; font-size: 24px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .full { grid-column: 1 / -1; }
        label { display: block; margin-bottom: 6px; color: #374151; font-size: 13px; font-weight: 600; }
        input, select { width: 100%; border: 1px solid #e5e7eb; border-radius: 10px; padding: 10px 12px; font-size: 14px; background: white; }
        input:focus, select:focus { outline: none; border-color: #fb7185; box-shadow: 0 0 0 3px rgba(251, 113, 133, 0.1); }
        .actions { margin-top: 18px; display: flex; gap: 10px; }
        .btn { padding: 10px 16px; border-radius: 10px; border: 0; font-weight: 600; text-decoration: none; cursor: pointer; }
        .btn-primary { background: #fb7185; color: white; }
        .btn-light { background: #f3f4f6; color: #374151; }
        .error-alert { background: #fee2e2; color: #b91c1c; padding: 12px 14px; border-radius: 12px; margin-bottom: 16px; font-size: 14px; }
        @media (max-width: 760px) { .grid { grid-template-columns: 1fr; } }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="header">
        <h1>Add User</h1>
        <a href="{{ route('admin.users') }}" class="btn btn-light">Back to Users</a>
    </div>

    @if ($errors->any())
        <div class="error-alert">{{ $errors->first() }}</div>
    @endif

    <div class="card">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="grid">
                <div class="full">
                    <label for="name">Name</label>
                    <input id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="customer" @selected(old('role', 'customer') === 'customer')>Customer</option>
                        <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                    </select>
                </div>
                <div>
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" value="{{ old('phone') }}">
                </div>
                <div>
                    <label for="reward_points">Reward Points</label>
                    <input id="reward_points" type="number" min="0" name="reward_points" value="{{ old('reward_points', 0) }}">
                </div>
                <div class="full">
                    <label for="shipping_address">Shipping Address</label>
                    <input id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}">
                </div>
                <div>
                    <label for="city">City</label>
                    <select id="city" name="city">
                        <option value="">Select City</option>
                        @foreach(config('sugarloom.metro_manila_cities', []) as $city)
                            <option value="{{ $city }}" @selected(old('city') === $city)>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="postal_code">Postal Code</label>
                    <input id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
                </div>
                <div class="full">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Create User</button>
                <a href="{{ route('admin.users') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
