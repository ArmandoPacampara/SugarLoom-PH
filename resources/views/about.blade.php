<!DOCTYPE html>
<html>
<head>
    <title>Our Story</title>
    <script src="https://cdn.tailwindcss.com"></script> 
</head>
<body>

<nav class="sticky top-0 z-50 flex h-[70px] items-center justify-between bg-[#e06b87] px-8 md:px-16">
    <a href="{{ route('home') }}" class="text-[1.1rem] font-black tracking-normal text-white no-underline">SugarLoom PH</a>
    <div class="absolute left-1/2 hidden -translate-x-1/2 gap-10 md:flex">
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-normal text-white no-underline transition hover:opacity-80">Admin</a>
            @else
                <a href="{{ route('catalog') }}" class="text-sm font-normal text-white no-underline transition hover:opacity-80">Catalog</a>
                <a href="{{ route('track-order') }}" class="text-sm font-normal text-white no-underline transition hover:opacity-80">Track Order</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="bg-transparent border-0 p-0 text-sm font-normal text-white transition hover:opacity-80">Logout</button>
            </form>
        @else
            <a href="{{ route('catalog') }}" class="text-sm font-normal text-white no-underline transition hover:opacity-80">Catalog</a>
            <a href="{{ route('track-order') }}" class="text-sm font-normal text-white no-underline transition hover:opacity-80">Track Order</a>
            <a href="{{ route('login') }}" class="text-sm font-normal text-white no-underline transition hover:opacity-80">Login</a>
        @endauth
    </div>
    <div class="flex gap-3">
        <a href="{{ route('cart.index') }}" class="grid h-[38px] w-[38px] place-items-center rounded-full border border-white/50 text-[#1a1018] transition hover:bg-white/20" aria-label="Cart">
            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
        </a>
        <a href="{{ route('login') }}" class="grid h-[38px] w-[38px] place-items-center rounded-full border border-white/50 text-[#1a1018] transition hover:bg-white/20" aria-label="Login" title="Login">
            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        </a>
    </div>
</nav>

<div class="bg-[#f6efef] text-gray-800">

    <!-- HERO -->
    <section class="max-w-7xl mx-auto px-6 py-16 flex flex-col md:flex-row items-center gap-10">
        
        <div class="flex-1">
            <p class="text-sm tracking-wide text-gray-500 mb-4">EST. PASIG CITY</p>

            <h1 class="text-5xl font-bold leading-tight">
                Our Story — <br>
                Where <span class="text-rose-400">Sweet</span><br>
                <span class="text-rose-400">Dreams</span> are<br>
                Woven
            </h1>

            <p class="mt-6 text-gray-600 max-w-md">
                From a humble home kitchen to a digital curator of artisanal delights,
                every crumb tells a story of passion and patience.
            </p>

            <button class="mt-6 bg-rose-400 text-white px-6 py-3 rounded-full shadow-md">
                Read Our Journey
            </button>
        </div>

        <div class="flex-1 relative">
            <div class="bg-orange-400 rounded-3xl p-6">
                <!-- IMAGE: public/images/cookies4.jpeg -->
                <img src="{{ asset('images/cookies4.jpeg') }}" class="mx-auto">
            </div>

            <div class="absolute bottom-0 left-0 bg-white p-4 rounded-xl shadow-md text-sm">
                "We don’t just bake; we curate moments of pure joy."
            </div>
        </div>
    </section>


    <!-- STORY -->
    <section class="text-center max-w-4xl mx-auto px-6 py-16">
        <h2 class="text-2xl font-semibold mb-6">The Confectionery Curator</h2>

        <p class="text-gray-600 mb-4">
            What started in 2024 in a small home kitchen in <b>Pasig City</b>
            has blossomed into a curated digital experience.
        </p>

        <p class="text-gray-600">
            SugarLoom PH isn't just a bakery; it is a vision of Editorial Artisanship.
        </p>
    </section>


    <!-- IMAGE + CARD -->
    <section class="max-w-6xl mx-auto px-6 py-10 grid md:grid-cols-2 gap-8">
        <div class="rounded-2xl overflow-hidden shadow">
            <!-- IMAGE: public/images/cookies2.jpeg -->
            <img src="{{ asset('images/cookies2.jpeg') }}" class="w-full h-full object-cover">
        </div>

        <div class="bg-rose-300 rounded-2xl p-10 flex items-center justify-center text-center">
            <div>
                <div class="text-3xl mb-4">✨</div>
                <h3 class="text-xl font-semibold">Modern Legacy</h3>
                <p class="text-sm mt-2">
                    Blending traditional recipes with digital-first convenience.
                </p>
            </div>
        </div>
    </section>


    <!-- PROCESS -->
    <section class="text-center py-16">
        <h2 class="text-2xl font-semibold">Our Craft, Your Joy</h2>
        <p class="text-gray-500 mb-10">The meticulous steps behind every creation.</p>

        <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 px-6 items-stretch">

            <!-- CARD 1 -->
            <div class="flex flex-col h-full">
                <img src="{{ asset('images/cookies1.jpeg') }}" 
                     class="w-full h-64 object-cover rounded-2xl mb-4">

                <h4 class="font-semibold">Small Batch Baking</h4>
                <p class="text-sm text-gray-600 mt-2">
                    Each order is baked in limited quantities.
                </p>
            </div>

            <!-- CARD 2 -->
            <div class="flex flex-col h-full">
                <img src="{{ asset('images/ingredients.jpeg') }}" 
                     class="w-full h-64 object-cover rounded-2xl mb-4">

                <h4 class="font-semibold">Premium Ingredients</h4>
                <p class="text-sm text-gray-600 mt-2">
                    Only the finest elements for our loom.
                </p>
            </div>

            <!-- CARD 3 -->
            <div class="flex flex-col h-full">
                <img src="{{ asset('images/cookies5.jpeg') }}" 
                     class="w-full h-64 object-cover rounded-2xl mb-4">

                <h4 class="font-semibold">Hand-Crafted with Love</h4>
                <p class="text-sm text-gray-600 mt-2">
                    Every decoration is applied by hand.
                </p>
            </div>

        </div>
    </section>


    <!-- TEAM -->
    <section class="max-w-5xl mx-auto px-6 py-16">
        <h2 class="text-2xl font-semibold mb-10">The Artisans</h2>

        <div class="grid md:grid-cols-2 gap-8">

            <div class="bg-white p-6 rounded-xl shadow flex gap-4 items-center">
                <!-- IMAGE: public/images/neon.jpeg -->
                <img src="{{ asset('images/neon.jpeg') }}" class="w-20 h-20 rounded-full">
                <div>
                    <h4 class="font-semibold">Neon Austria</h4>
                    <p class="text-sm text-gray-500">Founder & Manager</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow flex gap-4 items-center">
                <!-- IMAGE: public/images/shandy.jpeg -->
                <img src="{{ asset('images/shandy.jpeg') }}" class="w-20 h-20 rounded-full">
                <div>
                    <h4 class="font-semibold">Shandy Shanine C. Del Rosario</h4>
                    <p class="text-sm text-gray-500">Head Pastry Artist</p>
                </div>
            </div>

        </div>
    </section>


    <!-- CTA -->
    <section class="text-center py-16">
        <h2 class="text-3xl font-semibold mb-4">Ready to taste the dream?</h2>
        <p class="text-gray-600 mb-6">
            Browse our curated collection of artisanal treats.
        </p>

        <button class="bg-rose-400 text-white px-8 py-3 rounded-full shadow-md">
            Experience the Magic
        </button>
    </section>


    <!-- FOOTER -->
    <footer class="text-center text-sm text-gray-500 py-10">
        SugarLoom PH © 2024
    </footer>

</div>

</body>
</html>
