<!DOCTYPE html>
<html>
<head>
    <title>Our Story</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

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