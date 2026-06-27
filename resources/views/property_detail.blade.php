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
        .icon-fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24 !important;
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
                    <span class="flex items-center gap-1 ml-4"><span class="material-symbols-outlined text-[16px] text-yellow-400 icon-fill">star</span>{{ number_format($hotel['avg_rating'] ?? 0, 1) }} Rating</span>
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
        {{-- <div class="w-32 h-24 rounded-xl overflow-hidden shrink-0 bg-gray-100 flex items-center justify-center cursor-pointer hover:bg-gray-200 transition-colors border border-gray-200/50">
            <span class="text-xs font-semibold text-gray-600 text-center px-2">+12 More Photos</span>
        </div> --}}
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

            <div class="mt-10">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold">
                Guest Reviews
            </h2>

            <div class="flex items-center gap-2 mt-2">

                <span class="material-symbols-outlined text-yellow-500 icon-fill">
                    star
                </span>

                <span class="font-bold text-lg">
    {{ number_format($hotel['avg_rating'] ?? 0, 1) }}
</span>

<span class="text-gray-500">
    ({{ $hotel['review_count'] ?? 0 }} Reviews)
</span>

            </div>

        </div>
    </div>

    @forelse($reviews as $review)

        <div class="bg-white rounded-2xl border border-gray-200 p-6 mb-4 shadow-sm">

            <div class="flex justify-between">

                <div>

                    <h4 class="font-bold">
                        {{ $review->user->name }}
                    </h4>

                    <p class="text-gray-400 text-sm">
                        {{ $review->created_at->format('d M Y') }}
                    </p>

                </div>

                <div class="flex items-center">

                    @for($i=1;$i<=5;$i++)
                        <span class="material-symbols-outlined text-yellow-500 {{ $i <= $review->rating ? 'icon-fill' : '' }}">
                            star
                        </span>
                    @endfor

                </div>

            </div>

            <p class="text-gray-600 mt-4">
                {{ $review->comment }}
            </p>

        </div>

    @empty

        <div class="bg-gray-50 rounded-2xl p-10 text-center border border-dashed">

            <span class="material-symbols-outlined text-5xl text-gray-300">
                reviews
            </span>

            <p class="mt-4 text-gray-500">
                No reviews yet.
            </p>

        </div>

    @endforelse

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

            {{-- SISIPKAN DAFTAR UNIT KAMAR DI SINI --}}
            <div class="mt-10">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Available Units</h2>

                @if(isset($units) && $units->count())
                    <div class="space-y-4">
                        @foreach($units as $unit)
                            {{-- Tambahkan ID unik pada container unit untuk efek visual selection via JS --}}
                            <div id="unit-card-{{ $unit['id'] }}" class="unit-card bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row overflow-hidden transition-all hover:shadow-md">
                                
                                {{-- UNIT IMAGE --}}
                                <div class="w-full md:w-60 h-44 md:h-auto bg-gray-100 shrink-0 relative">
                                    @if($unit['image'])
                                        <img src="{{ asset('storage/'.$unit['image']['path']) }}" class="w-full h-full object-cover md:absolute md:inset-0">
                                    @else
                                        <div class="w-full h-full md:absolute md:inset-0 flex items-center justify-center text-gray-400 text-xs bg-gray-100">
                                            No Image Available
                                        </div>
                                    @endif
                                </div>

                                {{-- UNIT DETAILS --}}
                                <div class="flex-1 p-5 md:p-6 flex flex-col justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $unit['name'] }}</h3>
                                        <div class="flex items-center gap-1 text-xs font-semibold text-gray-600 bg-gray-50 px-2.5 py-1 rounded-md w-max border border-gray-100">
                                            <span class="material-symbols-outlined text-sm text-gray-500">group</span> Capacity: {{ $unit['capacity'] }} Guests
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between gap-3 pt-4 border-t border-gray-50">
                                        <div>
                                            <span class="text-xl font-extrabold text-blue-600 block">
                                                Rp {{ number_format($unit['price'], 0, ',', '.') }}
                                            </span>
                                            <span class="text-[10px] uppercase tracking-wider font-bold text-gray-400 block -mt-1">
                                                per night
                                            </span>
                                        </div>

                                        {{-- UBAH JADI BUTTON SELECT SINGLE --}}
                                        <button type="button" 
                                                onclick="selectUnit('{{ $unit['id'] }}', '{{ $unit['capacity'] }}')" 
                                                id="select-btn-{{ $unit['id'] }}"
                                                class="select-unit-btn bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-2.5 rounded-xl font-bold text-xs md:text-sm transition-colors shadow-sm">
                                            Select
                                        </button>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-2xl p-10 text-center border border-dashed border-gray-200">
                        <span class="material-symbols-outlined text-4xl text-gray-300 block mb-2">bed</span>
                        <h3 class="text-base font-bold text-gray-800">No Units Available</h3>
                    </div>
                @endif
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
                        <span class="text-sm font-bold text-gray-800">{{ number_format($hotel['avg_rating'] ?? 0, 1) }}</span>
                    </div>
                </div>

                {{-- Ubah form action menggunakan ID kosong karena jalurnya akan diatur dinamis lewat JavaScript submit --}}
                <form id="bookingPanelForm" action="#" method="GET" onsubmit="handleFormSubmit(event)" class="flex flex-col gap-6 m-0 p-0">
                    
                    {{-- KUNCI UTAMA: Input tersembunyi untuk mencatat ID Unit pilihan user --}}
                    <input type="hidden" id="selected_unit_id" name="unit_id" value="">

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex flex-col">
                            <span class="text-[10px] font-extrabold text-gray-400 uppercase mb-1">Check-in</span>
                            <input type="date" id="checkin" name="checkin" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="bg-transparent border-none p-0 text-xs md:text-sm font-bold text-gray-800 focus:ring-0 outline-none w-full" required>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex flex-col">
                            <span class="text-[10px] font-extrabold text-gray-400 uppercase mb-1">Check-out</span>
                            <input type="date" id="checkout" name="checkout" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ date('Y-m-d', strtotime('+1 day')) }}" class="bg-transparent border-none p-0 text-xs md:text-sm font-bold text-gray-800 focus:ring-0 outline-none w-full" required>
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-400 text-[20px]">group</span>
                            <span class="text-xs font-bold text-gray-500">Guests</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" id="guestMinus" class="w-8 h-8 rounded-full bg-white border border-gray-200 hover:bg-gray-50 flex items-center justify-center font-bold text-gray-700 shadow-sm transition-all select-none">-</button>
                            <span id="guestCount" class="w-4 text-center font-extrabold text-sm text-gray-800 select-none">1</span>
                            <button type="button" id="guestPlus" class="w-8 h-8 rounded-full bg-white border border-gray-200 hover:bg-gray-50 flex items-center justify-center font-bold text-gray-700 shadow-sm transition-all select-none">+</button>
                            <input type="hidden" id="guestInput" name="guests" value="1">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 pt-2">
                        @if(auth()->check())
                            <button type="submit" class="block w-full text-center font-bold text-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 py-4 rounded-xl shadow-md transform active:scale-95 transition-all">
                                Reserve Now
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center font-bold text-sm text-white bg-gray-950 hover:bg-gray-800 py-4 rounded-xl shadow-md transition-all">
                                Login to Reserve
                            </a>
                        @endif
                        
                        <button type="button" onclick="toggleFav(this, '{{ $hotel['id'] }}')" class="flex items-center justify-center w-full border border-gray-200 text-gray-700 font-bold text-xs py-3.5 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[18px] align-middle mr-1.5 fav-icon-bottom">favorite_border</span> Save to Favourites
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</main>

<script>
let count = 1;
let currentMaxCapacity = 10;

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
    location.reload();
}

// 1. Fungsi eksklusif untuk memilih salah satu unit saja
function selectUnit(unitId, capacity) {
    document.querySelectorAll('.select-unit-btn').forEach(btn => {
        btn.className = "select-unit-btn bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-2.5 rounded-xl font-bold text-xs md:text-sm transition-colors shadow-sm";
        btn.innerText = "Select";
    });
    document.querySelectorAll('.unit-card').forEach(card => {
        card.classList.remove('border-blue-600', 'ring-2', 'ring-blue-600/20', 'bg-blue-50/20');
    });

    const activeBtn = document.getElementById(`select-btn-${unitId}`);
    activeBtn.className = "select-unit-btn bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold text-xs md:text-sm transition-colors shadow-sm";
    activeBtn.innerText = "Selected ✓";

    const activeCard = document.getElementById(`unit-card-${unitId}`);
    activeCard.classList.add('border-blue-600', 'ring-2', 'ring-blue-600/20', 'bg-blue-50/20');

    document.getElementById('selected_unit_id').value = unitId;

    currentMaxCapacity = parseInt(capacity) || 10;
    
    const countSpan = document.getElementById('guestCount');
    const guestInput = document.getElementById('guestInput');

    if (count > currentMaxCapacity) {
        count = currentMaxCapacity; 
        countSpan.innerText = count;
        guestInput.value = count;
    }

    checkPlusButtonState(count);
}

function checkPlusButtonState(currentCount) {
    const plusBtn = document.getElementById('guestPlus');
    if (currentCount >= currentMaxCapacity) {
        plusBtn.disabled = true;
        plusBtn.classList.add('opacity-40', 'cursor-not-allowed', 'bg-gray-100');
    } else {
        plusBtn.disabled = false;
        plusBtn.classList.remove('opacity-40', 'cursor-not-allowed', 'bg-gray-100');
    }
}

// 2. Fungsi validasi saat menekan tombol "Reserve Now"
function handleFormSubmit(e) {
    e.preventDefault();

    const unitId = document.getElementById('selected_unit_id').value;
    
    if (!unitId) {
        alert('Please select an available unit room first before continuing your reservation.');
        return;
    }

    const checkin = document.getElementById('checkin').value;
    const checkout = document.getElementById('checkout').value;
    const guests = document.getElementById('guestInput').value;

    window.location.href = `/booking/${unitId}?checkin=${checkin}&checkout=${checkout}&guests=${guests}`;
}

// 3. Fungsi AJAX untuk Toggle Favorit
async function toggleFav(btn, propertyId) {
    try {
        const response = await fetch("{{ route('favorites.toggle') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({ property_id: propertyId })
        });

        if(response.status == 401){
            window.location.href = "{{ route('login') }}";
            return;
        }

        const data = await response.json();

        if(data.status == "added"){
            document.querySelectorAll('.fav-icon,.fav-icon-bottom').forEach(icon => {
                icon.textContent = "favorite";
                icon.classList.add("text-red-500", "icon-fill");
            });
        }

        if(data.status == "removed"){
            document.querySelectorAll('.fav-icon,.fav-icon-bottom').forEach(icon => {
                icon.textContent = "favorite_border";
                icon.classList.remove("text-red-500", "icon-fill");
            });
        }
    } catch(err){
        console.log("Error toggling favorite:", err);
    }
}

// Set status awal keaktifan ikon merah
const isFavorite = @json($isFavorite ?? false);
document.addEventListener("DOMContentLoaded", () => {
    if(isFavorite) {
        document.querySelectorAll(".fav-icon,.fav-icon-bottom").forEach(icon => {
            icon.textContent = "favorite";
            icon.classList.add("text-red-500", "icon-fill");
        });
    }
});

// Listener Inisialisasi DOM Utama
document.addEventListener('DOMContentLoaded', function() {
    const favs = JSON.parse(localStorage.getItem('staygo_favs') || '[]');
    const hotelId = '{{ $hotel['id'] }}';
    if (favs.includes(hotelId.toString())) {
        document.querySelectorAll('.fav-icon, .fav-icon-bottom').forEach(icon => {
            icon.textContent = 'favorite';
            icon.classList.add('text-red-500');
        });
    }

    // Sinkronisasi Pembatasan Tanggal Check-in & Check-out (KODE BERSIH TANPA DUPLIKAT)
    const ci = document.getElementById('checkin');
    const co = document.getElementById('checkout');
    if (ci && co) {
        ci.addEventListener('change', function() {
            co.min = this.value;
            if (co.value && co.value <= this.value) co.value = '';
        });
    }

    // Ambil nilai awal tamu dari Blade
    count = parseInt(document.getElementById('guestCount').innerText) || 1;
    
    const countSpan = document.getElementById('guestCount');
    const guestInput = document.getElementById('guestInput');
    const plusBtn = document.getElementById('guestPlus');
    const minusBtn = document.getElementById('guestMinus');

    // LISTENER TOMBOL MINUS
    minusBtn.addEventListener('click', () => {
        if (count > 1) { 
            count--; 
            countSpan.innerText = count;
            guestInput.value = count;

            checkPlusButtonState(count);
        } 
    });
    
    // LISTENER TOMBOL PLUS
    plusBtn.addEventListener('click', () => { 
        if (count < currentMaxCapacity) { 
            count++; 
            countSpan.innerText = count;
            guestInput.value = count;
            
            checkPlusButtonState(count);
        } 
    });
});
</script>
</body>
</html>