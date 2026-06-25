<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties</title>

    <!-- Tailwind CDN (kalau belum pakai build) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">

@include('dummy_pages.partials.navbar')

<!-- HEADER -->
<section class="max-w-6xl mx-auto px-6 pt-16 pb-10 text-center">
    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">
        Discover Your Next Stay
    </h1>
    <p class="text-slate-500 mt-3">
        Find hotels, villas, and amazing places to stay around the world
    </p>
</section>

<!-- FEATURED GRID -->
<section class="max-w-6xl mx-auto px-6 pb-20">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">All Property</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($featured as $p)

        <!-- CARD -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition">

            <!-- TOP BADGE AREA -->
            <div class="h-44 bg-slate-200 flex items-center justify-center">
                <span class="text-slate-400 text-sm">Image Placeholder</span>
            </div>

            <!-- CONTENT -->
            <div class="p-5 space-y-2">

                <h3 class="text-lg font-bold">
                    {{ $p['name'] }}
                </h3>

                <div class="text-sm text-slate-500">
                    {{ $p['type'] }} • {{ $p['city'] }}
                </div>

                <p class="text-sm text-slate-600 line-clamp-2">
                    {{ $p['description'] }}
                </p>

                <div class="pt-3 flex items-center justify-between">
                    <span class="text-xs px-3 py-1 bg-slate-100 rounded-full">
                        {{ $p['address'] }}
                    </span>

                    <button class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                        View
                    </button>
                </div>

            </div>
        </div>

        @empty
        <div class="col-span-3 text-center text-slate-400">
            No Property found
        </div>
        @endforelse

    </div>
</section>

<!-- HOT DEALS -->
<section class="max-w-6xl mx-auto px-6 pb-20">

    <div class="flex items-end justify-between mb-6">
        <div>
            <span class="text-blue-600 text-xs font-bold uppercase tracking-wider">
                Limited Offer
            </span>
            <h2 class="text-2xl md:text-3xl font-extrabold">
                Hot Deals for You 🔥
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Save more on selected stays and special promotions
            </p>
        </div>

        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-800">
            View all →
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @forelse($promos ?? [] as $p)

        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-400 text-white shadow-lg hover:shadow-2xl transition">

            <!-- glow circle -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>

            <div class="p-6 relative z-10">

                <div class="text-xs font-semibold opacity-80">
                    Until {{ $p['valid_until'] ?? '-' }}
                </div>

                <h3 class="text-2xl font-extrabold mt-1">
                    {{ $p['discount_value'] ?? 0 }}
                    {{ ($p['discount_type'] ?? '') === 'percent' ? '%' : 'IDR' }}
                    <span class="text-sm font-bold opacity-80">OFF</span>
                </h3>

                <p class="mt-2 font-semibold">
                    {{ $p['title'] ?? 'Special Deal' }}
                </p>

                <div class="mt-4 flex items-center justify-between">

                    <button
                        onclick="navigator.clipboard.writeText('{{ $p['code'] ?? '' }}'); this.innerText='Copied!'"
                        class="bg-white/20 hover:bg-white/30 text-xs font-mono px-3 py-1.5 rounded-lg border border-white/30 transition">
                        {{ $p['code'] ?? 'CODE' }}
                    </button>

                    <span class="text-xs opacity-80">
                        Use code
                    </span>

                </div>

            </div>
        </div>

        @empty

        <div class="col-span-3 text-center text-slate-400 py-10">
            No deals available right now
        </div>

        @endforelse

    </div>
</section>

<!-- WHY STAYGO -->
<section class="bg-white py-20">

    <div class="max-w-6xl mx-auto px-6 text-center mb-12">
        <span class="text-blue-600 text-xs font-bold uppercase tracking-wider">
            Why Choose Us
        </span>
        <h2 class="text-3xl md:text-4xl font-extrabold mt-2">
            Why StayGo?
        </h2>
        <p class="text-slate-500 mt-2">
            We make your travel experience easier, faster, and more enjoyable
        </p>
    </div>

    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- ITEM 1 -->
        <div class="text-center p-6 rounded-2xl hover:shadow-lg transition">
            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-blue-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600">verified</span>
            </div>
            <h3 class="font-bold text-lg">Verified Properties</h3>
            <p class="text-sm text-slate-500 mt-2">
                Every stay is verified to ensure safety, comfort, and quality.
            </p>
        </div>

        <!-- ITEM 2 -->
        <div class="text-center p-6 rounded-2xl hover:shadow-lg transition">
            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-blue-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600">payments</span>
            </div>
            <h3 class="font-bold text-lg">Best Price Guarantee</h3>
            <p class="text-sm text-slate-500 mt-2">
                We ensure you always get the best deal available.
            </p>
        </div>

        <!-- ITEM 3 -->
        <div class="text-center p-6 rounded-2xl hover:shadow-lg transition">
            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-blue-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600">support_agent</span>
            </div>
            <h3 class="font-bold text-lg">24/7 Support</h3>
            <p class="text-sm text-slate-500 mt-2">
                Our team is ready to help you anytime, anywhere.
            </p>
        </div>

    </div>
</section>

<!-- FOOTER -->
<footer class="bg-slate-900 text-slate-300 pt-16 pb-8">

    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">

        <!-- BRAND -->
        <div>
            <h2 class="text-white text-xl font-extrabold">
                Stay<span class="text-blue-400">Go</span>
            </h2>
            <p class="text-sm text-slate-400 mt-3">
                Discover hotels, villas, and stays with the best experience and price guarantee.
            </p>
        </div>

        <!-- LINKS -->
        <div>
            <h3 class="text-white font-bold mb-3">Explore</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-white">Hotels</a></li>
                <li><a href="#" class="hover:text-white">Villas</a></li>
                <li><a href="#" class="hover:text-white">Flights</a></li>
                <li><a href="#" class="hover:text-white">Promos</a></li>
            </ul>
        </div>

        <!-- SUPPORT -->
        <div>
            <h3 class="text-white font-bold mb-3">Support</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-white">Help Center</a></li>
                <li><a href="#" class="hover:text-white">Contact Us</a></li>
                <li><a href="#" class="hover:text-white">Terms</a></li>
                <li><a href="#" class="hover:text-white">Privacy</a></li>
            </ul>
        </div>

        <!-- SOCIAL -->
        <div>
            <h3 class="text-white font-bold mb-3">Follow Us</h3>
            <div class="flex gap-3">
                <a href="#" class="w-10 h-10 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">public</span>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">mail</span>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">chat</span>
                </a>
            </div>
        </div>

    </div>

    <!-- BOTTOM -->
    <div class="max-w-6xl mx-auto px-6 mt-10 pt-6 border-t border-slate-800 text-sm text-slate-500 flex flex-col md:flex-row justify-between gap-3">
        <p>© {{ date('Y') }} StayGo. All rights reserved.</p>
    </div>

</footer>

</body>
</html>