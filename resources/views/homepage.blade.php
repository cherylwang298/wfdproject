<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayGo - Atmospheric Travel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="bg-background text-on-background antialiased">

@include('partials.navbar', ['currentPage' => 'home'])

<header class="relative pt-32 pb-48 px-6 md:px-16 overflow-hidden flex flex-col items-center justify-center min-h-[860px]">
    <div class="absolute inset-0 z-0">
        <img alt="Beautiful coastal scenery" class="w-full h-full object-cover opacity-90" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1440">
        <div class="absolute inset-0 bg-gradient-to-b from-white/40 via-transparent to-background/90"></div>
    </div>
    
    <div class="relative z-10 w-full max-w-7xl mx-auto flex flex-col items-center text-center mt-12 md:mt-20">
        <h1 class="text-on-surface max-w-4xl drop-shadow-sm mb-6 text-4xl md:text-6xl font-extrabold tracking-tight">Your Journey, Beautifully Simplified</h1>
        <p class="text-body-lg text-on-surface-variant max-w-2xl mb-12 text-lg">Discover curated stays, effortless flights, and unforgettable experiences — all in one seamless platform.</p>
        
        <form id="homeSearchForm" method="GET" action="#" class="glass-card w-full max-w-5xl rounded-2xl p-2 flex flex-col md:flex-row items-center gap-2 relative z-20 shadow-xl">
            <div class="flex-1 flex items-center h-16 px-6 rounded-xl hover:bg-white/50 transition-colors w-full relative">
                <span class="material-symbols-outlined text-outline mr-3">location_on</span>
                <div class="flex flex-col text-left flex-1">
                    <label class="text-xs font-semibold text-on-surface">Location</label>
                    <input name="location" id="homeLocation" class="bg-transparent border-none p-0 text-sm text-on-surface-variant placeholder-outline-variant w-full outline-none focus:ring-0" placeholder="Where to?" type="text">
                </div>
                <div class="hidden md:block absolute right-0 top-4 bottom-4 w-px bg-outline-variant/30"></div>
            </div>
            <div class="flex-1 flex items-center h-16 px-6 rounded-xl hover:bg-white/50 transition-colors w-full relative">
                <span class="material-symbols-outlined text-outline mr-3">calendar_month</span>
                <div class="flex flex-col text-left flex-1">
                    <label class="text-xs font-semibold text-on-surface">Check-in</label>
                    <input type="date" name="checkin" id="homeCheckin" class="bg-transparent border-none p-0 text-sm text-on-surface-variant w-full outline-none focus:ring-0">
                </div>
                <div class="hidden md:block absolute right-0 top-4 bottom-4 w-px bg-outline-variant/30"></div>
            </div>
            <div class="flex-1 flex items-center h-16 px-6 rounded-xl hover:bg-white/50 transition-colors w-full relative">
                <span class="material-symbols-outlined text-outline mr-3">calendar_month</span>
                <div class="flex flex-col text-left flex-1">
                    <label class="text-xs font-semibold text-on-surface">Check-out</label>
                    <input type="date" name="checkout" id="homeCheckout" class="bg-transparent border-none p-0 text-sm text-on-surface-variant w-full outline-none focus:ring-0">
                </div>
            </div>
            <div class="flex-1 flex items-center h-16 px-6 rounded-xl hover:bg-white/50 transition-colors w-full">
                <span class="material-symbols-outlined text-outline mr-3">group</span>
                <div class="flex flex-col text-left flex-1">
                    <label class="text-xs font-semibold text-on-surface">Guests</label>
                    <input type="number" name="guests" id="homeGuests" class="bg-transparent border-none p-0 text-sm text-on-surface-variant w-full outline-none focus:ring-0" min="1" value="2">
                </div>
            </div>
            <button type="submit" class="h-16 w-full md:w-16 flex items-center justify-center bg-gradient-to-r from-primary to-secondary-container rounded-xl text-on-primary hover:scale-105 transition-transform duration-300 shadow-lg shrink-0 mt-2 md:mt-0">
                <span class="material-symbols-outlined font-semibold">search</span>
            </button>
        </form>
    </div>
</header>

<main class="relative z-20 bg-background -mt-16 rounded-t-3xl px-6 md:px-16 py-16 md:py-24 max-w-[1440px] mx-auto shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
    
    <section class="max-w-7xl mx-auto mb-16">
        <div class="flex items-center gap-3 overflow-x-auto hide-scrollbar pb-4" id="category-filters">
            <button onclick="filterProperties('all')" data-filter="all" class="filter-btn flex items-center gap-2 px-6 py-3 rounded-xl bg-primary-container text-on-primary-container text-sm font-semibold shrink-0 shadow-sm transition-all hover:scale-105">
                <span class="material-symbols-outlined text-[20px]">travel_explore</span>All
            </button>
            <button onclick="filterProperties('hotel')" data-filter="hotel" class="filter-btn flex items-center gap-2 px-6 py-3 rounded-xl bg-surface-container hover:bg-surface-variant text-on-surface text-sm font-semibold shrink-0 transition-colors border border-outline-variant/20">
                <span class="material-symbols-outlined text-[20px]">hotel</span>Hotels
            </button>
            <button onclick="filterProperties('villa')" data-filter="villa" class="filter-btn flex items-center gap-2 px-6 py-3 rounded-xl bg-surface-container hover:bg-surface-variant text-on-surface text-sm font-semibold shrink-0 transition-colors border border-outline-variant/20">
                <span class="material-symbols-outlined text-[20px]">villa</span>Villas
            </button>
            
            <div class="ml-auto flex items-center gap-2 shrink-0">
                <select id="price-sort" onchange="sortProperties(this.value)" class="bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm font-semibold text-on-surface focus:outline-none focus:border-primary cursor-pointer">
                    <option value="">Sort by</option>
                    <option value="price-asc">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                    <option value="rating">Top Rated</option>
                </select>
            </div>
        </div>
        <p class="text-xs text-on-surface-variant mt-2" id="filter-label">Showing all properties</p>
    </section>

    {{-- SECtion 2: CURATED ACCOMMODATIONS --}}
    <section class="max-w-7xl mx-auto mb-24">
        {{-- SINKRONISASI JUDUL & PENAMBAHAN TOMBOL VIEW ALL ACCOMMODATIONS --}}
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Curated for You</h2>
                <p class="text-sm text-gray-500">Exceptional stays with atmospheric views.</p>
            </div>
            {{-- Tombol View All mengarah langsung ke halaman akomodasi --}}
            <a href="/accommodations" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors flex items-center gap-1 group">
                View all accommodations 
                <span class="material-symbols-outlined text-[18px] transform group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>

        @php
            $dummyImages = [
                'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600&q=80', // Luxury infinity pool
                'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=600&q=80', // Tropical resort view
                'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&q=80', // Modern villa poolside
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80', // Boutique hotel facade
                'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?w=600&q=80', // Beachfront villa terrace
                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=600&q=80', // High-end luxury estate
                'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=600&q=80', // Cozy minimalist cabin/room
                'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=600&q=80'  // Atmospheric bedroom suite
            ];
        @endphp
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="properties-grid">
            @foreach ($featuredProperties as $h)
                @php
                    $assignedImage = $dummyImages[$loop->index % 8];
                @endphp

                <a href="{{ route('properties.detail', $h['id']) }}" 
                    class="property-card group cursor-pointer relative overflow-hidden rounded-3xl block hover:shadow-2xl transition-shadow duration-300"
                    data-type="{{ $h['type'] }}" data-price="{{ $h['cheapest_price'] }}" data-rating="{{ $h['rating'] }}">
                    
                    <div class="relative h-64 overflow-hidden">
                        <img alt="{{ $h['name'] }}" 
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                            src="{{ $assignedImage }}"
                            onerror="this.src='https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600'">
                        
                        <button onclick="event.preventDefault(); toggleFav(this)" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/70 backdrop-blur-sm flex items-center justify-center hover:bg-white transition-colors border border-white/30">
                            <span class="material-symbols-outlined text-[18px] text-gray-700 fav-icon">favorite_border</span>
                        </button>
                        
                        @if (!empty($h['badge']))
                            {{-- PENYESUAIAN CLASS CUSTOM: text-xs font-semibold --}}
                            <span class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-sm">{{ $h['badge'] }}</span>
                        @endif
                    </div>
                    
                    <div class="p-5 bg-white">
                        <div class="flex justify-between items-start mb-1">
                            {{-- PENYESUAIAN CLASS CUSTOM: text-lg font-bold text-gray-800 --}}
                            <h3 class="text-lg font-bold text-gray-800 leading-tight group-hover:text-blue-600 transition-colors">{{ $h['name'] }}</h3>
                            {{-- PENYESUAIAN CLASS CUSTOM: text-xs font-bold --}}
                            <span class="flex items-center gap-0.5 text-gray-700 text-xs font-bold shrink-0 ml-2">
                                <span class="material-symbols-outlined text-[14px] text-yellow-500 icon-fill">star</span>{{ number_format($h['rating'], 1) }}
                            </span>
                        </div>
                        
                        {{-- PENYESUAIAN CLASS CUSTOM: text-xs text-gray-400 --}}
                        <p class="text-xs text-gray-400 font-medium flex items-center gap-1 mb-4">
                            <span class="material-symbols-outlined text-[14px] text-gray-400">location_on</span>{{ $h['city'] }}
                        </p>
                        
                        <div class="flex items-center justify-between pt-1">
                            {{-- PENYESUAIAN CLASS CUSTOM: text-xs font-bold bg-gray-100 --}}
                            <span class="text-xs font-bold text-gray-500 capitalize bg-gray-100 px-3 py-1 rounded-full border border-gray-200/40">{{ $h['type'] }}</span>
                            {{-- PENYESUAIAN CLASS CUSTOM: text-lg font-extrabold text-gray-800 --}}
                            <p class="text-lg font-extrabold text-gray-800">
                                @if($h['cheapest_price'] > 0)
                                    Rp {{ number_format($h['cheapest_price'], 0, ',', '.') }}
                                @else
                                    N/A
                                @endif
                                <span class="text-xs font-medium text-gray-400">/night</span>
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- promos --}}
    <section class="max-w-7xl mx-auto mb-24">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-on-surface mb-2">Hot Deals for You 🔥</h2>
            <p class="text-sm text-on-surface-variant">Save more on selected stays and exclusive promotions.</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($promos as $promo)
                @php
                    $isPercent = ($promo['discount_type'] ?? 'percentage') === 'percentage';
                    $value = $promo['discount_value'] ?? 0;
                    $code = $promo['code'] ?? '-';
                    $expired = isset($promo['expired_at']) ? \Carbon\Carbon::parse($promo['expired_at'])->format('d M Y') : '-';
                @endphp
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 to-cyan-500 text-white shadow-lg p-6 group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-125 transition-transform"></div>
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div>
                            <div class="text-xs font-semibold opacity-75 mb-1">Valid until {{ $expired }}</div>
                            <h3 class="text-3xl font-black tracking-tight">
                                {{ $value }}{{ $isPercent ? '%' : ' IDR' }} <span class="text-sm font-bold opacity-90">OFF</span>
                            </h3>
                            <p class="mt-2 text-lg font-bold tracking-wide uppercase">{{ $code }}</p>
                        </div>
                        <div class="mt-6 flex items-center justify-between">
                            <button onclick="navigator.clipboard.writeText(@js($code)); this.innerText='✓ Copied!'" 
                                    class="bg-white/20 hover:bg-white/30 text-xs font-mono px-4 py-2 rounded-xl border border-white/20 transition-colors backdrop-blur-sm">
                                {{ $code }}
                            </button>
                            <span class="text-xs opacity-75">Click to copy code</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-on-surface-variant bg-surface-container rounded-3xl">
                    <p class="font-medium">No deals available at the moment.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="max-w-[1440px] mx-auto mb-24">
        <div class="flex justify-between items-end mb-8">
            <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Popular Flights</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Top destinations for your next adventure.</p>
            </div>
            <a href="{{ route('flights') }}" class="font-label-md text-label-md text-primary hover:text-blue-950 transition-colors hidden md:flex items-center gap-1">
            View all flights <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($featuredRoutes as $r)
            <a href="#" class="bg-surface-container p-6 hover:bg-surface-container-high transition-all cursor-pointer group rounded-3xl hover:shadow-md hover:-translate-y-1 duration-300 block">
            <div class="flex items-center justify-between mb-4">
                {{-- Menampilkan Kode Bandara Asal dan Tujuan dari API --}}
                <span class="font-headline-md text-headline-md text-on-surface text-xl font-bold">{{ $r['origin'] }}</span>
                <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">flight_takeoff</span>
                <span class="font-headline-md text-headline-md text-on-surface text-xl font-bold">{{ $r['destination'] }}</span>
            </div>
            
            {{-- Menampilkan Tipe Kelas Penerbangan --}}
            <p class="text-sm text-on-surface-variant mb-6 capitalize">{{ $r['class'] ?? 'Economy Class' }}</p>
            
            <div class="flex items-center justify-between pt-4 border-t border-outline-variant/20">
                <span class="font-label-sm text-label-sm text-on-surface-variant text-xs">one-way from</span>
                {{-- Menampilkan Harga Rupiah Dinamis --}}
                <span class="font-label-md text-label-md text-primary font-bold">
                    Rp {{ number_format($r['price'], 0, ',', '.') }}
                </span>
            </div>
            </a>
            @endforeach
        </div>
        </section>
</main>

<script>
let allCards = [];
let currentFilter = 'all';
let currentSort = '';

document.addEventListener('DOMContentLoaded', function () {
    allCards = Array.from(document.querySelectorAll('.property-card'));
    renderCards();
    
    // Set default dates
    const today = new Date();
    const nextWeek = new Date(today);
    nextWeek.setDate(today.getDate() + 7);
    
    document.getElementById('homeCheckin').value = today.toISOString().split('T')[0];
    document.getElementById('homeCheckout').value = nextWeek.toISOString().split('T')[0];

    allCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault(); // Tahan redirect instan link asli bawaan Blade

            // 1. Ambil nilai terupdate dari elemen input form pencarian homepage
            const checkinValue = document.getElementById('homeCheckin').value;
            const checkoutValue = document.getElementById('homeCheckout').value;
            const guestsValue = document.getElementById('homeGuests').value;

            // 2. Ambil URL dasar (e.g., http://127.0.0.1:8000/properties/{id})
            const baseUrl = this.getAttribute('href');

            // 3. Gabungkan menjadi satu kesatuan URL Query String yang valid
            const finalUrl = `${baseUrl}?checkin=${checkinValue}&checkout=${checkoutValue}&guests=${guestsValue}`;

            // 4. Alihkan halaman user dengan URL lengkap layaknya hasil search page
            window.location.href = finalUrl;
        });
    });
});

function filterProperties(type) {
    currentFilter = type;
    document.querySelectorAll('.filter-btn').forEach(btn => {
        const isActive = btn.dataset.filter === type;
        btn.classList.toggle('bg-primary-container', isActive);
        btn.classList.toggle('text-on-primary-container', isActive);
        btn.classList.toggle('bg-surface-container', !isActive);
        btn.classList.toggle('text-on-surface', !isActive);
    });
    renderCards();
}

function sortProperties(value) {
    currentSort = value;
    renderCards();
}

function renderCards() {
    const grid = document.getElementById('properties-grid');
    const noResults = document.getElementById('no-results');
    const label = document.getElementById('filter-label');

    let visible = allCards.filter(card => currentFilter === 'all' || card.dataset.type === currentFilter);

    if (currentSort === 'price-asc') {
        visible.sort((a,b) => +a.dataset.price - +b.dataset.price);
    } else if (currentSort === 'price-desc') {
        visible.sort((a,b) => +b.dataset.price - +a.dataset.price);
    }

    allCards.forEach(c => { c.style.display = 'none'; });
    visible.forEach(c => { c.style.display = ''; grid.appendChild(c); });

    noResults.classList.toggle('hidden', visible.length > 0);
    label.textContent = `Showing ${visible.length} properties`;
}

function toggleFav(btn) {
    const icon = btn.querySelector('.fav-icon');
    const isFaved = icon.textContent.trim() === 'favorite';
    icon.textContent = isFaved ? 'favorite_border' : 'favorite';
    icon.classList.toggle('text-red-500', !isFaved);
}
</script>
</body>
</html>