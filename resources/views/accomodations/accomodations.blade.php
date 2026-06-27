@extends('layouts.user')

@section('style')
<style>
    .guest-counter {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .guest-counter button {
        width: 32px;
        height: 32px;
        border-radius: 9999px;
        background: #f0f3ff;
        border: none;
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
    }

    .guest-counter span {
        min-width: 30px;
        text-align: center;
        font-size: 18px;
        font-weight: 600;
    }

    .glass-panel {
        background: rgba(255, 255, 255, .6);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, .6);
        box-shadow: 0 20px 60px rgba(0, 0, 0, .08);
    }

    .glass-input {
        background: rgba(255, 255, 255, .55);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, .5);
    }

    .gradient-button {
        background: linear-gradient(135deg, #0062ff, #00c8e8);
        color: white;
        transition: .25s;
    }

    .gradient-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(0, 98, 255, .3);
    }

    input[type="date"] {
        position: relative;
        min-height: 24px;
    }

    .icon-fill {
        font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24 !important;
    }
</style>
@endsection

@section('content')

@php
$currentPage = 'hotel';
@endphp
@include('partials.navbar')

{{-- CONTAINER FILTER & SEARCH UTAMA --}}
<div class="max-w-7xl mx-auto px-6 pt-28 pb-20">

    {{-- SEARCH BAR TETAP MUNCUL DI ATAS --}}
    <div class="glass-panel rounded-3xl p-4 sm:p-6 md:p-8 mb-12">
        <form id="searchForm" action="{{ route('accomodations.search') }}" method="GET">
            <div class="grid grid-cols-1 lg:grid-cols-11 gap-4 items-end">

                {{-- LOCATION --}}
                <div class="lg:col-span-3 relative w-full">
                    <div class="glass-input rounded-2xl h-16 flex items-center px-5 w-full">
                        <div class="w-full">
                            <label class="text-xs font-bold text-gray-500 block">Location</label>
                            <input
                                type="text"
                                id="citySearch"
                                placeholder="Search city..."
                                autocomplete="off"
                                value="{{ request('city', $city ?? '') }}"
                                class="w-full bg-transparent border-0 outline-none font-semibold mt-1 p-0 focus:ring-0 text-sm sm:text-base">
                            <input
                                type="hidden"
                                name="city"
                                id="selectedCity"
                                value="{{ request('city', $city ?? '') }}"
                                required>
                        </div>
                    </div>

                    <div id="cityDropdown" class="hidden absolute left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl max-h-64 overflow-y-auto z-50 border border-gray-100">
                        @if(isset($cities))
                        @foreach($cities as $c)
                        <div class="city-option px-5 py-3 cursor-pointer hover:bg-blue-50 text-sm sm:text-base transition-colors" data-city="{{ $c }}">
                            {{ $c }}
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

                {{-- CHECKIN --}}
                <div class="lg:col-span-3 w-full">
                    <div class="glass-input rounded-2xl h-16 flex items-center px-5 w-full">
                        <div class="w-full">
                            <label class="text-xs font-bold text-gray-500 block">Check-in</label>
                            <input
                                type="date"
                                name="checkin"
                                required
                                min="{{ date('Y-m-d') }}"
                                value="{{ request('checkin', $checkin ?? date('Y-m-d')) }}"
                                class="w-full bg-transparent border-0 outline-none font-semibold mt-1 p-0 pr-2 focus:ring-0 text-sm sm:text-base">
                        </div>
                    </div>
                </div>

                {{-- CHECKOUT --}}
                <div class="lg:col-span-3 w-full">
                    <div class="glass-input rounded-2xl h-16 flex items-center px-5 w-full">
                        <div class="w-full">
                            <label class="text-xs font-bold text-gray-500 block">Check-out</label>
                            <input
                                type="date"
                                name="checkout"
                                required
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                value="{{ request('checkout', $checkout ?? date('Y-m-d', strtotime('+1 day'))) }}"
                                class="w-full bg-transparent border-0 outline-none font-semibold mt-1 p-0 pr-2 focus:ring-0 text-sm sm:text-base">
                        </div>
                    </div>
                </div>

                {{-- GUESTS --}}
                <div class="lg:col-span-2 w-full">
                    <div class="glass-input rounded-2xl h-16 flex items-center px-5 w-full">
                        <div class="w-full">
                            <label class="text-xs font-bold text-gray-500 block">Guests</label>
                            <div class="guest-counter justify-between lg:justify-center mt-1">
                                <button type="button" id="minus" class="select-none">-</button>
                                <span id="guestCount" class="select-none">{{ request('guests', $guests ?? 1) }}</span>
                                <button type="button" id="plus" class="select-none">+</button>
                                <input
                                    type="hidden"
                                    id="guestInput"
                                    name="guests"
                                    value="{{ request('guests', $guests ?? 1) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TRACK FILTER INPUTS --}}
            <input type="hidden" name="sort" id="sortInput" value="{{ request('sort', 'default') }}">
            <input type="hidden" name="type_filter" id="typeFilterInput" value="{{ request('type_filter', 'all') }}">

            <div class="mt-6 flex justify-center">
                <button id="searchBtn" type="submit" class="gradient-button w-full sm:w-auto sm:min-w-[200px] rounded-xl px-8 py-3 flex items-center justify-center gap-2 font-semibold shadow-md">
                    <span class="material-symbols-outlined text-xl">search</span> Search Again
                </button>
            </div>
        </form>
    </div>

    {{-- BARIS FILTER TYPE & SORTING CONTROL --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10 pb-6 border-b border-gray-100">

        {{-- FILTER TIPE AKOMODASI (ALL, HOTEL, VILLA) --}}
        <div class="flex items-center gap-2 bg-gray-100 p-1.5 rounded-2xl w-full md:w-auto overflow-x-auto hide-scrollbar">

            {{-- Tombol ALL --}}
            <button type="button" onclick="filterType('all')" class="flex items-center gap-2 px-5 py-2 rounded-xl text-sm font-bold transition-all shrink-0 {{ request('type_filter', 'all') === 'all' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="material-symbols-outlined text-[20px]">travel_explore</span>
                All Properties
            </button>

            {{-- Tombol HOTELS --}}
            <button type="button" onclick="filterType('hotel')" class="flex items-center gap-2 px-5 py-2 rounded-xl text-sm font-bold transition-all shrink-0 {{ request('type_filter') === 'hotel' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="material-symbols-outlined text-[20px]">hotel</span>
                Hotels
            </button>

            {{-- Tombol VILLAS --}}
            <button type="button" onclick="filterType('villa')" class="flex items-center gap-2 px-5 py-2 rounded-xl text-sm font-bold transition-all shrink-0 {{ request('type_filter') === 'villa' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="material-symbols-outlined text-[20px]">villa</span>
                Villas
            </button>
        </div>

        {{-- DROPDOWN SORT BY (RATING & PRICE) --}}
        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
            @php $cnt = count($properties); $word = ($cnt == 1) ? 'stay' : 'stays'; @endphp
            <p class="text-sm font-medium text-gray-400 mr-2 hidden lg:block">{{ $cnt }} {{ $word }} found</p>

            <div class="flex items-center gap-2 w-full md:w-auto">
                <label for="sortSelector" class="text-xs font-bold text-gray-400 uppercase tracking-wider shrink-0">Sort By:</label>
                <select id="sortSelector" onchange="applySorting(this.value)" class="bg-white border border-gray-200 text-sm font-bold text-gray-700 rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 w-full md:w-48 shadow-sm">
                    <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Recommended</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Highest Rating ⭐</option>
                </select>
            </div>
        </div>
    </div>

    {{-- HASIL GRID PRODUK --}}
    @if(count($properties))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($properties as $property)

        @php
        // Menyediakan 10 pilihan foto dummy akomodasi yang aesthetic dan bervariasi
        $dummyImages = [
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&auto=format&fit=crop&q=80', // Luxury Hotel
        'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600&auto=format&fit=crop&q=80', // Resort Pool
        'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=600&auto=format&fit=crop&q=80', // Modern Bedroom
        'https://images.unsplash.com/photo-1540518614846-7eded433c457?w=600&auto=format&fit=crop&q=80', // Villa Room
        'https://images.unsplash.com/photo-1568495248636-6432b97bd949?w=600&auto=format&fit=crop&q=80', // Boutique Hotel
        'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=600&auto=format&fit=crop&q=80', // Luxury Resort
        'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&auto=format&fit=crop&q=80', // Tropical Villa
        'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=600&auto=format&fit=crop&q=80', // Minimalist Hotel
        'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=600&auto=format&fit=crop&q=80', // Pool Villa
        'https://images.unsplash.com/photo-1529290130-4ca3753253ae?w=600&auto=format&fit=crop&q=80' // Grand Lobby
        ];

        // Tentukan gambar dummy unik berdasarkan indeks perulangan saat ini (modulus 10)
        $assignedDummy = $dummyImages[$loop->index % 10];
        @endphp

        <a href="{{ route('property.detail', ['id' => $property['id'], 'checkin' => $checkin ?? request('checkin'), 'checkout' => $checkout ?? request('checkout'), 'guests' => $guests ?? request('guests')]) }}"
            class="group bg-white rounded-3xl overflow-hidden shadow hover:shadow-xl transition duration-300 flex flex-col justify-between">

            <div>
                {{-- Image --}}
                <div class="aspect-[4/3] overflow-hidden bg-gray-200 relative">
                    @if(!empty($property['image']))
                    {{-- Jika ada gambar asli dari database/storage --}}
                    <img src="{{ asset('storage/'.$property['image']['path']) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="{{ $property['name'] }}">
                    @else
                    {{-- FALLBACK KUNCI: Pasang gambar dummy unik yang sudah dialokasikan di atas --}}
                    <img src="{{ $assignedDummy }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="{{ $property['name'] }}">
                    @endif

                    {{-- Badge Tipe Properti --}}
                    <span class="absolute bottom-3 left-3 bg-black/50 text-white text-[10px] font-bold uppercase px-2.5 py-1 rounded-md backdrop-blur-sm">
                        {{ $property['type'] ?? 'Hotel' }}
                    </span>
                </div>

                <div class="p-5">
                    <div class="flex justify-between items-start gap-2">
                        <h2 class="font-bold text-lg leading-tight line-clamp-1">{{ $property['name'] }}</h2>
                        <span class="text-yellow-500 font-bold shrink-0 flex items-center text-sm gap-0.5">
                            {{-- <span class="material-symbols-outlined text-sm icon-fill">star</span>{{ number_format($property['rating'] ?? 4.8, 1) }} --}}
                            @if($property['review_count'] > 0)
                            <span class="text-yellow-500 font-bold shrink-0 flex items-center text-sm gap-0.5">
                                <span class="material-symbols-outlined text-sm icon-fill">star</span>
                                {{ number_format($property['avg_rating'], 1) }}
                                <span class="text-xs text-gray-400">
                                    ({{ $property['review_count'] }})
                                </span>
                            </span>
                            @else
                            <span class="text-xs text-gray-400 font-medium">
                                No reviews
                            </span>
                            @endif
                        </span>
                    </div>
                    <p class="text-gray-400 text-xs font-semibold flex items-center gap-0.5 mt-1">
                        <span class="material-symbols-outlined text-sm">location_on</span>{{ $property['city'] }}
                    </p>
                    <p class="text-gray-500 text-xs mt-3 line-clamp-2 leading-relaxed">{{ $property['description'] }}</p>
                </div>
            </div>

            <div class="p-5 pt-0 mt-auto">
                <div class="pt-4 border-t border-gray-50 flex justify-between items-end">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Starting from</p>
                        <p class="text-lg font-bold text-blue-600">
                            Rp {{ number_format($property['min_price'], 0, ',', '.') }}
                            <span class="text-xs font-medium text-gray-400">/night</span>
                        </p>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-3xl shadow p-16 text-center border border-dashed border-gray-100">
        <div class="text-6xl mb-4">🏨</div>
        <h2 class="text-2xl font-bold text-gray-800">No accommodations found</h2>
        <p class="text-gray-400 mt-2 text-sm max-w-sm mx-auto">Try selecting another filter category or change your search dates.</p>
        <a href="{{ route('accomodations.open') }}" class="inline-block mt-6 px-6 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition">
            Reset Search Criteria
        </a>
    </div>
    @endif
</div>
@endsection

@section('script')
<script>
    let guests = parseInt("{{ request('guests', $guests ?? 1) }}");
    const count = document.getElementById('guestCount');
    const input = document.getElementById('guestInput');

    document.getElementById('plus').onclick = function(e) {
        e.preventDefault();
        if (guests < 10) {
            guests++;
            count.innerHTML = guests;
            input.value = guests;
        }
    }
    document.getElementById('minus').onclick = function(e) {
        e.preventDefault();
        if (guests > 1) {
            guests--;
            count.innerHTML = guests;
            input.value = guests;
        }
    }

    const cityInput = document.getElementById('citySearch');
    const cityHidden = document.getElementById('selectedCity');
    const dropdown = document.getElementById('cityDropdown');
    const options = document.querySelectorAll('.city-option');

    if (cityInput) {
        cityInput.addEventListener('focus', () => dropdown.classList.remove('hidden'));
        cityInput.addEventListener('keyup', function() {
            const keyword = this.value.toLowerCase();
            dropdown.classList.remove('hidden');
            options.forEach(option => {
                const city = option.dataset.city.toLowerCase();
                option.style.display = city.includes(keyword) ? 'block' : 'none';
            });
        });
    }
    options.forEach(option => {
        option.addEventListener('click', function() {
            cityInput.value = this.dataset.city;
            cityHidden.value = this.dataset.city;
            dropdown.classList.add('hidden');
        });
    });
    document.addEventListener('click', function(e) {
        if (cityInput && !cityInput.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    const checkin = document.querySelector('[name="checkin"]');
    const checkout = document.querySelector('[name="checkout"]');
    if (checkin) {
        checkin.addEventListener('change', function() {
            checkout.min = this.value;
            if (checkout.value < this.value) {
                checkout.value = "";
            }
        });
    }

    // Fungsi Trigger Submit Filter Tipe Properti
    function filterType(typeValue) {
        document.getElementById('typeFilterInput').value = typeValue;
        document.getElementById('searchForm').submit();
    }

    // Fungsi Trigger Submit Dropdown Sorting
    function applySorting(sortValue) {
        document.getElementById('sortInput').value = sortValue;
        document.getElementById('searchForm').submit();
    }
</script>
@endsection