@extends('layouts.app')

@section('title', 'Our Story – SugarLoom PH')

@section('styles')
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<style>
    :root {
        --pink-nav:    #e06b87;
        --pink-bg-base:#f6ccd6;
        --pink-btn:    #ce5a7a;
        --text-dark:   #2b1b24;
        --text-accent: #835372;
        --text-body:   #665560;
        --cream:       #fdf6f0;
        --white:       #ffffff;
    }

    h1, h2, h3, h4 { font-family: 'Playfair Display', serif; }
    p, span, button, a { font-family: 'DM Sans', sans-serif; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .float-anim { animation: float 4s ease-in-out infinite; }

    .about-page {
        padding: 3rem 4rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    @media (max-width: 1024px) {
        .about-page { padding: 2rem; }
    }
</style>
@endsection

@section('content')
<div class="about-page">

    <!-- HERO SECTION -->
    <section class="relative min-h-[85vh] flex items-center mb-16 overflow-hidden rounded-[50px] bg-gradient-to-br from-[#fffcfc] to-[#fef2f4] border border-pink-100/50 shadow-sm" data-aos="zoom-out" data-aos-duration="1200">
        
        {{-- Abstract Decorative Background --}}
        <div class="absolute top-0 right-0 w-2/3 h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-[600px] h-[600px] bg-pink-100/40 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute top-1/2 -right-40 w-[400px] h-[400px] bg-rose-100/30 rounded-full blur-2xl opacity-50"></div>
        </div>

        <div class="relative z-10 w-full flex flex-col lg:flex-row items-center gap-16 px-12 lg:px-20 py-16">
            
            {{-- Text Side --}}
            <div class="flex-1 text-center lg:text-left" data-aos="fade-right" data-aos-delay="200">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 border border-pink-100 rounded-full shadow-sm mb-8">
                    <span class="flex h-2 w-2 rounded-full bg-rose-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-rose-500">Established 2024 • Pasig City</span>
                </div>

                <h1 class="text-6xl xl:text-7xl font-black text-[#2b1b24] leading-[0.95] tracking-tighter mb-8 italic">
                    Our Story —<br>
                    <span class="text-[#ce5a7a] not-italic">Where Sweet</span><br>
                    <span class="relative inline-block">
                        Dreams
                        <svg class="absolute -bottom-2 left-0 w-full h-3 text-pink-200/60" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q 25 0, 50 5 T 100 5" stroke="currentColor" stroke-width="4" fill="transparent" />
                        </svg>
                    </span>
                    are Woven
                </h1>

                <p class="text-lg text-[#665560] font-light leading-relaxed max-w-lg mb-10 mx-auto lg:mx-0">
                    From a humble home kitchen to a digital curator of artisanal delights, 
                    every crumb tells a story of passion, patience, and the pursuit of the perfect bake.
                </p>

                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('catalog') }}" class="px-10 py-4 bg-[#ce5a7a] text-white rounded-full font-bold shadow-xl shadow-rose-200 hover:bg-[#b34a66] transition-all hover:scale-105 active:scale-95 text-lg">
                        Shop the Loom
                    </a>
                    <button class="px-10 py-4 bg-white text-[#ce5a7a] border-2 border-pink-100 rounded-full font-bold hover:bg-pink-50 transition-all hover:border-[#ce5a7a] text-lg">
                        Read Journey
                    </button>
                </div>

                {{-- Key Highlights --}}
                <div class="mt-12 flex items-center justify-center lg:justify-start gap-8 border-t border-pink-100/50 pt-10">
                    <div>
                        <span class="block text-3xl font-black text-[#2b1b24]">100%</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-[#835372]">Small Batch</span>
                    </div>
                    <div class="w-px h-10 bg-pink-100"></div>
                    <div>
                        <span class="block text-3xl font-black text-[#2b1b24]">Premium</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-[#835372]">Ingredients</span>
                    </div>
                </div>
            </div>

            {{-- Image Side --}}
            <div class="flex-1 relative" data-aos="zoom-in" data-aos-delay="400">
                <div class="relative z-10 rounded-[60px] overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-700 aspect-[4/5] max-w-[500px] mx-auto group">
                    <img src="{{ asset('images/cookies4.jpeg') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#2b1b24]/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>

                {{-- Floating Experience Card --}}
                <div class="absolute -bottom-6 -left-6 lg:-left-12 z-20 bg-white p-6 rounded-[30px] shadow-2xl border border-pink-50 max-w-[280px] float-anim" style="animation-duration: 5s">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-pink-100 border-2 border-white flex items-center justify-center text-xs">👨‍🍳</div>
                            <div class="w-8 h-8 rounded-full bg-rose-100 border-2 border-white flex items-center justify-center text-xs">✨</div>
                        </div>
                        <span class="text-[10px] font-black uppercase text-[#ce5a7a] tracking-tighter">Artisanal Choice</span>
                    </div>
                    <p class="text-xs text-[#665560] leading-relaxed font-medium">
                        "We don’t just bake; we curate moments of pure joy for your soul."
                    </p>
                </div>

                {{-- Decorative Circle Badge --}}
                <div class="absolute -top-6 -right-6 z-20 w-32 h-32 bg-[#2b1b24] text-white rounded-full flex flex-col items-center justify-center border-4 border-white shadow-xl rotate-12 float-anim" style="animation-delay: 1s">
                    <span class="text-2xl font-bold">#1</span>
                    <span class="text-[8px] font-bold uppercase tracking-[0.3em] text-pink-200">Local Bakery</span>
                </div>
            </div>

        </div>
    </section>


    <!-- STORY -->
    <section class="text-center max-w-4xl mx-auto py-24" data-aos="fade-up">
        <h2 class="text-4xl font-extrabold mb-8 text-[var(--text-dark)] tracking-tight">The Confectionery Curator</h2>

        <p class="text-xl text-[var(--text-body)] mb-6 leading-relaxed font-light">
            What started in 2024 in a small home kitchen in <b class="font-bold text-[var(--text-dark)]">Pasig City</b>
            has blossomed into a curated digital experience.
        </p>

        <p class="text-xl text-[var(--text-body)] leading-relaxed font-light">
            SugarLoom PH isn't just a bakery; it is a vision of Editorial Artisanship.
        </p>
    </section>


    <!-- IMAGE + CARD -->
    <section class="grid md:grid-cols-2 gap-12 overflow-hidden py-12">
        <div class="rounded-[32px] overflow-hidden shadow-2xl h-[400px]" data-aos="fade-right">
            <img src="{{ asset('images/cookies2.jpeg') }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-1000">
        </div>

        <div class="bg-[var(--pink-btn)] rounded-[32px] p-16 flex items-center justify-center text-center shadow-2xl" data-aos="fade-left">
            <div>
                <div class="text-5xl mb-6">✨</div>
                <h3 class="text-3xl font-extrabold text-white mb-4">Modern Legacy</h3>
                <p class="text-lg text-pink-50 font-light leading-relaxed">
                    Blending traditional recipes with digital-first convenience. We believe in the timeless art of baking, reimagined for the modern palate.
                </p>
            </div>
        </div>
    </section>


    <!-- PROCESS -->
    <section class="text-center py-24">
        <h2 class="text-5xl font-extrabold mb-4 text-[var(--text-dark)] tracking-tight" data-aos="fade-up">Our Craft, Your Joy</h2>
        <p class="text-xl text-[var(--text-body)] mb-16 font-light" data-aos="fade-up" data-aos-delay="100">The meticulous steps behind every creation.</p>

        <div class="grid md:grid-cols-3 gap-12 items-stretch">

            <div class="flex flex-col h-full group" data-aos="fade-up" data-aos-delay="200">
                <div class="overflow-hidden rounded-[32px] mb-8 shadow-lg">
                    <img src="{{ asset('images/cookies1.jpeg') }}"
                         class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <h4 class="text-2xl font-bold text-[var(--text-dark)] mb-3">Small Batch Baking</h4>
                <p class="text-md text-[var(--text-body)] leading-relaxed font-light">
                    Each order is baked in limited quantities to ensure the highest quality and freshness in every bite.
                </p>
            </div>

            <div class="flex flex-col h-full group" data-aos="fade-up" data-aos-delay="300">
                <div class="overflow-hidden rounded-[32px] mb-8 shadow-lg">
                    <img src="{{ asset('images/ingredients.jpeg') }}"
                         class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <h4 class="text-2xl font-bold text-[var(--text-dark)] mb-3">Premium Ingredients</h4>
                <p class="text-md text-[var(--text-body)] leading-relaxed font-light">
                    Only the finest elements for our loom. We source high-quality chocolate, butter, and local flavors.
                </p>
            </div>

            <div class="flex flex-col h-full group" data-aos="fade-up" data-aos-delay="400">
                <div class="overflow-hidden rounded-[32px] mb-8 shadow-lg">
                    <img src="{{ asset('images/cookies5.jpeg') }}"
                         class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <h4 class="text-2xl font-bold text-[var(--text-dark)] mb-3">Hand-Crafted with Love</h4>
                <p class="text-md text-[var(--text-body)] leading-relaxed font-light">
                    Every decoration is applied by hand, ensuring that no two treats are exactly alike.
                </p>
            </div>

        </div>
    </section>


    <!-- TEAM -->
    <section class="py-24 bg-white/50 rounded-[60px] mb-24 px-12">
        <h2 class="text-4xl font-extrabold mb-16 text-center text-[var(--text-dark)] tracking-tight" data-aos="fade-up">The Artisans</h2>

        <div class="grid md:grid-cols-2 gap-12">

            <div class="bg-white p-8 rounded-3xl shadow-xl flex gap-8 items-center hover:shadow-2xl transition-all hover:-translate-y-2 border border-pink-50" data-aos="fade-right" data-aos-delay="100">
                <img src="{{ asset('images/neon.jpeg') }}" class="w-28 h-28 rounded-2xl object-cover shadow-md">
                <div>
                    <h4 class="text-2xl font-bold text-[var(--text-dark)]">Neon Austria</h4>
                    <p class="text-md text-[var(--pink-btn)] font-semibold uppercase tracking-wider mt-1">Founder & Manager</p>
                    <p class="text-sm text-[var(--text-body)] mt-2 font-light">Visionary behind SugarLoom's digital presence.</p>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-xl flex gap-8 items-center hover:shadow-2xl transition-all hover:-translate-y-2 border border-pink-50" data-aos="fade-left" data-aos-delay="200">
                <img src="{{ asset('images/shandy.jpeg') }}" class="w-28 h-28 rounded-2xl object-cover shadow-md">
                <div>
                    <h4 class="text-2xl font-bold text-[var(--text-dark)]">Shandy Shanine C. Del Rosario</h4>
                    <p class="text-md text-[var(--pink-btn)] font-semibold uppercase tracking-wider mt-1">Head Pastry Artist</p>
                    <p class="text-sm text-[var(--text-body)] mt-2 font-light">The master weaver of our artisanal flavors.</p>
                </div>
            </div>

        </div>
    </section>


    <!-- CTA -->
    <section class="text-center py-24 bg-[var(--pink-btn)] rounded-[60px] px-16 shadow-2xl" data-aos="zoom-in">
        <h2 class="text-5xl font-extrabold mb-6 text-white tracking-tight">Ready to taste the dream?</h2>
        <p class="text-xl text-pink-50 mb-10 font-light">
            Browse our curated collection of artisanal treats.
        </p>
        <a href="{{ route('catalog') }}" class="inline-block bg-white text-[var(--pink-btn)] px-12 py-5 rounded-full shadow-2xl hover:bg-[var(--cream)] transition-all hover:scale-105 font-bold text-xl">
            Experience the Magic
        </a>
    </section>

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