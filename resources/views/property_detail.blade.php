<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hotel['name'] }} - StayGo</title>

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

@include('partials.navbar', ['currentPage' => 'hotel'])

<div class="pt-20">
    <div class="relative h-[60vh] min-h-[400px] max-h-[600px] overflow-hidden">
        <img alt="{{ $hotel['name'] }}" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1200"
             onerror="this.src='https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1200'">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        
        <a href="{{ route('homepage') }}" class="absolute top-6 left-6 glass-card w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform shadow-md">
            <span class="material-symbols-outlined text-neutral-800 font-bold">arrow_back</span>
        </a>
        
        <button onclick="toggleFav(this, '{{ $hotel['id'] }}')" class="absolute top-6 right-6 glass-card w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform shadow-md">
            <span class="material-symbols-outlined fav-icon text-neutral-800">favorite_border</span>
        </button>
        
        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
            <div class="max-w-7xl mx-auto">
                @if (!empty($hotel['badge']))
                    <span class="bg-secondary text-on-secondary text-xs font-semibold px-3 py-1 rounded-full mb-3 inline-block shadow-sm">{{ $hotel['badge'] }}</span>
                @endif
                <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight drop-shadow-md mb-2">{{ $hotel['name'] }}</h1>
                <p class="text-sm md:text-base text-gray-200 flex items-center gap-2 drop-shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">location_on</span>{{ $hotel['city'] }}
                    <span class="flex items-center gap-1 ml-4"><span class="material-symbols-outlined text-[16px] text-yellow-400 icon-fill">star</span>{{ number_format($hotel['rating'] ?? 4.5, 1) }} Rating</span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 md:px-16 mb-8">
    <div class="flex gap-3 overflow-x-auto hide-scrollbar py-4">
        @php
            $thumbImgs = [
                'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=300',
                'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=300',
                'https://images.unsplash.com/photo-1540518614846-7eded433c457?w=300',
                'https://images.unsplash.com/photo-1568495248636-6432b97bd949?w=300',
                'https://images.unsplash.com/photo-1551918120-9739cb430c6d?w=300',
            ];
        @endphp
        @foreach ($thumbImgs as $i => $img)
        <div class="w-32 h-24 rounded-xl overflow-hidden shrink-0 {{ $i === 0 ? 'ring-2 ring-blue-600' : '' }} cursor-pointer hover:opacity-90 transition-opacity shadow-sm">
            <img src="{{ $img }}" alt="Gallery view" class="w-full h-full object-cover">
        </div>
        @endforeach
        <div class="w-32 h-24 rounded-xl overflow-hidden shrink-0 bg-gray-100 flex items-center justify-center cursor-pointer hover:bg-gray-200 transition-colors border border-gray-200/50">
            <span class="text-xs font-semibold text-gray-600 text-center px-2">+12 More Photos</span>
        </div>
    </div>
</div>

<main class="max-w-7xl mx-auto px-6 md:px-16 pb-24">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 flex flex-col gap-10">
            <div>
                <h2 class="text-2xl font-bold text-on-surface mb-4">About this property</h2>
                <div class="flex items-center gap-4 flex-wrap mb-6">
                    <span class="text-xs font-semibold text-gray-700 capitalize bg-gray-100 px-3 py-1 rounded-full border border-gray-200">{{ $hotel['type'] }}</span>
                    <span class="flex items-center gap-1 text-xs font-medium text-gray-600"><span class="material-symbols-outlined text-[16px]">bed</span>3 Bedrooms</span>
                    <span class="flex items-center gap-1 text-xs font-medium text-gray-600"><span class="material-symbols-outlined text-[16px]">bathtub</span>2 Bathrooms</span>
                    <span class="flex items-center gap-1 text-xs font-medium text-gray-600"><span class="material-symbols-outlined text-[16px]">group</span>Up to 6 Guests</span>
                </div>
                <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                    {{ $hotel['description'] }} Experience unparalleled luxury at {{ $hotel['name'] }} in {{ $hotel['city'] }}. This stunning property seamlessly blends contemporary design with the natural beauty of its surroundings. Floor-to-ceiling windows flood every room with natural light.
                </p>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-on-surface mb-6">Amenities</h2>
                @php
                    $amenities = [
                        ['icon'=>'pool','label'=>'Infinity Pool'],
                        ['icon'=>'wifi','label'=>'High-Speed WiFi'],
                        ['icon'=>'ac_unit','label'=>'Air Conditioning'],
                        ['icon'=>'local_parking','label'=>'Free Parking'],
                        ['icon'=>'fitness_center','label'=>'Gym Layout'],
                        ['icon'=>'spa','label'=>'Spa Services'],
                    ];
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($amenities as $a)
                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="material-symbols-outlined text-blue-600 text-[22px]">{{ $a['icon'] }}</span>
                        <span class="text-sm font-medium text-gray-800">{{ $a['label'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-on-surface mb-4">Location</h2>
                <div class="w-full h-56 bg-gray-50 border border-gray-200/60 rounded-2xl overflow-hidden flex items-center justify-center relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-500/5"></div>
                    <div class="relative z-10 flex flex-col items-center gap-2">
                        <span class="material-symbols-outlined text-[48px] text-blue-600">location_on</span>
                        <p class="text-sm font-bold text-gray-800 px-6 text-center">{{ $hotel['address'] ?? $hotel['city'] }}</p>
                        <a href="https://maps.google.com" target="_blank" class="text-blue-600 text-xs font-semibold hover:underline">View on Google Maps</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-200/80 p-6 rounded-2xl shadow-xl sticky top-28 flex flex-col gap-6">
                <div class="flex items-baseline justify-between">
                    <div>
                        <span class="text-xs text-gray-500 block font-medium">Starting from</span>
                        <div class="text-3xl font-extrabold text-blue-600">
                            Rp {{ number_format($hotel['cheapest_price'] ?? $hotel['price'], 0, ',', '.') }}
                        </div>
                        <span class="text-xs text-gray-500">/night</span>
                    </div>
                    <div class="flex items-center gap-1 bg-yellow-50 border border-yellow-200 px-2 py-1 rounded-lg">
                        <span class="material-symbols-outlined text-yellow-500 text-[18px] icon-fill">star</span>
                        <span class="text-sm font-bold text-gray-800">{{ number_format($hotel['rating'] ?? 4.5, 1) }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 flex flex-col">
                        <span class="text-xs font-bold text-gray-500 mb-1">Check-in</span>
                        <input type="date" id="checkin" min="{{ date('Y-m-d') }}" class="bg-transparent border-none p-0 text-sm font-semibold text-gray-800 focus:ring-0 outline-none w-full">
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 flex flex-col">
                        <span class="text-xs font-bold text-gray-500 mb-1">Check-out</span>
                        <input type="date" id="checkout" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="bg-transparent border-none p-0 text-sm font-semibold text-gray-800 focus:ring-0 outline-none w-full">
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-gray-400 text-[20px]">group</span>
                        <span class="text-xs font-bold text-gray-500">Guests</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <button type="button" id="guestMinus" class="w-8 h-8 rounded-full bg-white border border-gray-300 hover:bg-gray-100 flex items-center justify-center text-md font-bold text-gray-700 shadow-sm">-</button>
                        <span id="guestCount" class="w-4 text-center font-bold text-sm text-gray-800">1</span>
                        <button type="button" id="guestPlus" class="w-8 h-8 rounded-full bg-white border border-gray-300 hover:bg-gray-100 flex items-center justify-center text-md font-bold text-gray-700 shadow-sm">+</button>
                    </div>
                </div>

                <div class="flex flex-col gap-2 pt-2">
                    <a href="#" class="block w-full text-center font-bold text-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 py-4 rounded-xl shadow-md transform active:scale-95 transition-all">
                        Reserve Now
                    </a>
                    <button onclick="toggleFav(this, '{{ $hotel['id'] }}')" class="flex items-center justify-center w-full border-2 border-blue-600 text-blue-600 font-bold text-sm py-4 rounded-xl hover:bg-blue-50 transition-colors">
                        <span class="material-symbols-outlined text-[18px] align-middle mr-1 fav-icon-bottom">favorite_border</span>Save to Favourites
                    </button>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
// Logika Favorit Client-side LocalStorage
function toggleFav(btn, hotelId) {
    let favs = JSON.parse(localStorage.getItem('staygo_favs') || '[]');
    const isFaved = favs.includes(hotelId.toString());
    
    if (isFaved) {
        favs = favs.filter(f => f != hotelId.toString());
    } else {
        favs.push(hotelId.toString());
    }
    localStorage.setItem('staygo_favs', JSON.stringify(favs));
    location.reload(); // Refresh untuk menyinkronkan status ikon top & bottom
}

document.addEventListener('DOMContentLoaded', function() {
    const favs = JSON.parse(localStorage.getItem('staygo_favs') || '[]');
    const hotelId = '{{ $hotel['id'] }}';
    if (favs.includes(hotelId.toString())) {
        document.querySelectorAll('.fav-icon, .fav-icon-bottom').forEach(icon => {
            icon.textContent = 'favorite';
            icon.classList.add('text-red-500');
        });
    }

    // Sinkronisasi Pembatasan Tanggal Check-in & Check-out
    const ci = document.getElementById('checkin');
    const co = document.getElementById('checkout');
    if (ci && co) {
        ci.addEventListener('change', function() {
            co.min = this.value;
            if (co.value && co.value <= this.value) co.value = '';
        });
    }

    // Penghitung Counter Tamu
    let count = 1;
    const countSpan = document.getElementById('guestCount');
    document.getElementById('guestMinus').addEventListener('click', () => { if(count > 1) { count--; countSpan.innerText = count; } });
    document.getElementById('guestPlus').addEventListener('click', () => { if(count < 10) { count++; countSpan.innerText = count; } });
});
</script>
</body>
</html>