
<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: #f8b4b4;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 50px;
        background: #d95b7a;
        color: white;
    }

    .nav-links a {
        margin: 0 12px;
        color: white;
        text-decoration: none;
        font-weight: 500;
    }
</style>

<nav class="navbar">
    <div class="logo">SugarLoom PH</div>

    <div class="nav-links">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ route('catalog') }}">Catalog</a>
        <a href="{{ route('track-order') }}">Track Order</a>
    </div>

    <div class="nav-links">
        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:white;cursor:pointer;">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</nav>