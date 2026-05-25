@extends('layouts.app')

@section('title', 'User Management | SugarLoom PH')

@section('styles')
    <style>
        body { background: #fdf2f8; color: #111827; }
        .container { max-width: 1200px; margin: auto; padding: 24px 24px 80px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        h1 { font-size: 24px; margin: 0; font-weight: 600; }
        .btn { padding: 10px 20px; border-radius: 999px; border: none; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.2s; font-size: 14px; }
        .btn-primary { background: #fb7185; color: white; box-shadow: 0 4px 12px rgba(251, 113, 133, 0.2); }
        .alert { background: #dcfce7; color: #166534; padding: 12px 24px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; }
        .error-alert { background: #fee2e2; color: #b91c1c; padding: 12px 24px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; }
        .tabs { display: flex; background: white; border-radius: 12px; padding: 4px; margin-bottom: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .tab { flex: 1; padding: 12px 24px; border-radius: 8px; text-align: center; text-decoration: none; color: #6b7280; font-weight: 500; transition: all 0.2s; }
        .tab.active { background: #fb7185; color: white; box-shadow: 0 2px 8px rgba(251, 113, 133, 0.3); }
        .grid { display: grid; gap: 16px; grid-template-columns: repeat(3, 1fr); margin-bottom: 20px; }
        .stat { background: rgba(255, 255, 255, 0.8); border-radius: 14px; padding: 16px 18px; border: 1px solid rgba(255, 255, 255, 0.4); box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
        .stat-label { color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: 700; }
        .stat-value { color: #be123c; font-size: 26px; font-weight: 800; margin-top: 6px; }
        .card { background: rgba(255, 255, 255, 0.8); border-radius: 20px; padding: 24px; border: 1px solid rgba(255, 255, 255, 0.4); box-shadow: 0 8px 20px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px 16px; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase; border-bottom: 2px solid #f3f4f6; }
        td { padding: 16px; border-bottom: 1px solid #f3f4f6; vertical-align: top; font-size: 14px; }
        .name { font-weight: 700; color: #111827; }
        .muted { color: #6b7280; font-size: 13px; line-height: 1.5; }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .badge-admin { background: #fee2e2; color: #b91c1c; }
        .badge-customer { background: #dcfce7; color: #166534; }
        .actions { display: flex; gap: 8px; align-items: center; }
        .action-link, .action-btn { border: 0; border-radius: 8px; font-size: 12px; font-weight: 600; padding: 8px 10px; text-decoration: none; cursor: pointer; }
        .action-link { background: #f3f4f6; color: #374151; }
        .action-btn { background: #fee2e2; color: #b91c1c; }
        @media (max-width: 900px) { .card { overflow-x: auto; } table { min-width: 800px; } .grid { grid-template-columns: 1fr; } }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="header">
        <h1>User Management</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Add User</a>
    </div>

    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="error-alert">{{ $errors->first() }}</div>
    @endif

    <div class="tabs">
        <a href="{{ route('admin.dashboard') }}" class="tab">Dashboard</a>
        <a href="{{ route('admin.inventory') }}" class="tab">Inventory</a>
        <a href="{{ route('admin.orders') }}" class="tab">Orders</a>
        <a href="{{ route('admin.user_index') }}" class="tab active">Users</a>
    </div>

    <div class="grid">
        <div class="stat">
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ number_format($userSummary['total']) }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">Admin Accounts</div>
            <div class="stat-value">{{ number_format($userSummary['admins']) }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">Customer Accounts</div>
            <div class="stat-value">{{ number_format($userSummary['customers']) }}</div>
        </div>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Reward Points</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="name">{{ $user->name }}</div>
                        </td>
                        <td class="muted">{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-customer' }}">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td class="muted">{{ $user->phone ?: 'N/A' }}</td>
                        <td class="muted">
                            {{ $user->shipping_address ?: 'N/A' }}
                            @if($user->city)
                                , {{ $user->city }}
                            @endif
                            @if($user->postal_code)
                                {{ $user->postal_code }}
                            @endif
                        </td>
                        <td class="name">{{ number_format((int) $user->reward_points) }}</td>
                        <td class="muted">{{ optional($user->created_at)->format('M d, Y h:i A') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.users.edit', $user) }}" class="action-link">Edit</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Remove this user account?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn">Remove</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 48px; color: #6b7280;">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 24px;">
        {{ $users->links('partials.simple-pagination') }}
    </div>
</div>
@endsection
