@extends('layouts.user')

@section('content')

@php
$currentPage = 'hotel';
@endphp

@include('partials.navbar')

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
    .icon-fill { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
</style>

{{-- Wrapper Background Halaman --}}
<div class="bg-gray-50/50 min-h-screen pt-24 pb-12">

    {{-- HERO IMAGE & COVER --}}
    <div class="relative h-[40vh] md:h-[50vh] min-h-[300px] max-h-[500px] overflow-hidden mx-4 md:mx-8 md:rounded-3xl shadow-lg">
        @if($property['image'])
            <img src="{{ asset('storage/'.$property['image']['path']) }}" alt="{{ $property['name'] }}" class="w-full h-full object-cover">
        @else
            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1200" alt="{{ $property['name'] }}" class="w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
        
        <a href="javascript:history.back()" class="absolute top-6 left-6 glass-card w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform shadow-md">
            <span class="material-symbols-outlined text-neutral-800 font-bold">arrow_back</span>
        </a>
        
        <button onclick="toggleFav(this, '{{ $property['id'] }}')" class="absolute top-6 right-6 glass-card w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform shadow-md">
            <span class="material-symbols-outlined fav-icon text-neutral-800">favorite_border</span>
        </button>
        
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10 text-white">
            <div class="max-w-7xl mx-auto">
                <span class="bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3 inline-block shadow-sm">Property Detail</span>
                <h1 class="text-2xl md:text-5xl font-extrabold tracking-tight drop-shadow-md mb-2">{{ $property['name'] }}</h1>
                <p class="text-xs md:text-sm text-gray-200 flex items-center gap-2 drop-shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">location_on</span>{{ $property['city'] }}
                    {{-- <span class="flex items-center gap-1 ml-4"><span class="material-symbols-outlined text-[16px] text-yellow-400 icon-fill">star</span> 4.8 Rating</span> --}}
                    <span class="flex items-center gap-1 ml-4">
    <span class="material-symbols-outlined text-[16px] text-yellow-400 icon-fill">
        star
    </span>

    @if($property['review_count'])
        {{ number_format($property['avg_rating'],1) }}
        ({{ $property['review_count'] }} reviews)
    @else
        No reviews yet
    @endif
</span>
                </p>
            </div>
        </div>
    </div>

    {{-- GALLERY THUMBNAILS --}}
    <div class="max-w-7xl mx-auto px-6 md:px-16 mt-4">
        <div class="flex gap-3 overflow-x-auto hide-scrollbar py-2">
            @php
                $thumbImgs = [
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=300',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=300',
                    'https://images.unsplash.com/photo-1540518614846-7eded433c457?w=300',
                    'https://images.unsplash.com/photo-1568495248636-6432b97bd949?w=300',
                ];
            @endphp
            @foreach ($thumbImgs as $i => $img)
            <div class="w-24 h-16 md:w-32 md:h-22 rounded-xl overflow-hidden shrink-0 cursor-pointer hover:opacity-90 transition-opacity shadow-sm">
                <img src="{{ $img }}" alt="Gallery view" class="w-full h-full object-cover">
            </div>
            @endforeach
            {{-- <div class="w-24 h-16 md:w-32 md:h-22 rounded-xl overflow-hidden shrink-0 bg-white flex items-center justify-center cursor-pointer hover:bg-gray-50 transition-colors border border-gray-200/60 shadow-sm">
                <span class="text-xs font-bold text-gray-600 text-center px-2">+6 Photos</span>
            </div> --}}
        </div>
    </div>

    {{-- MAIN CONTENT GRID --}}
    <main class="max-w-7xl mx-auto px-6 md:px-16 mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

            {{-- LEFT COLUMN: INFO & UNITS --}}
            <div class="lg:col-span-2 flex flex-col gap-10">
                {{-- ABOUT --}}
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-sm">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">About this property</h2>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                        {{ $property['description'] }}
                    </p>
                    <div class="text-xs sm:text-sm text-gray-400 mt-4 pt-4 border-t border-gray-50 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm text-gray-400">map</span> {{ $property['address'] }}
                    </div>
                </div>

                {{-- AMENITIES --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Property Amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <span class="material-symbols-outlined text-blue-600 text-[22px]">wifi</span>
                            <span class="text-sm font-medium text-gray-800">Free WiFi</span>
                        </div>
                        <div class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <span class="material-symbols-outlined text-blue-600 text-[22px]">ac_unit</span>
                            <span class="text-sm font-medium text-gray-800">AC</span>
                        </div>
                        <div class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <span class="material-symbols-outlined text-blue-600 text-[22px]">local_parking</span>
                            <span class="text-sm font-medium text-gray-800">Parking Area</span>
                        </div>
                    </div>
                </div>

                <div>

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-2xl font-bold text-gray-900">
            Guest Reviews
        </h2>

        @if($property['review_count'])
            <div class="flex items-center gap-2">

                <span class="material-symbols-outlined text-yellow-500 icon-fill">
                    star
                </span>

                <span class="font-bold">
                    {{ number_format($property['avg_rating'],1) }}
                </span>

                <span class="text-gray-400">
                    ({{ $property['review_count'] }} reviews)
                </span>

            </div>
        @endif
    </div>

    @forelse($reviews as $review)

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-4">

            <div class="flex justify-between items-start">

                <div>

                    <div class="font-bold text-gray-900">
                        {{ $review->user->username }}
                    </div>

                    <div class="text-xs text-gray-400">
                        {{ $review->created_at->format('d M Y') }}
                    </div>

                </div>

                <div class="flex items-center gap-1 text-yellow-500">

                    @for($i=1;$i<=5;$i++)
                        @if($i <= round($review->rating))
                            <span class="material-symbols-outlined icon-fill">
                                star
                            </span>
                        @else
                            <span class="material-symbols-outlined">
                                star
                            </span>
                        @endif
                    @endfor

                </div>

            </div>

            @if($review->comment)

                <p class="mt-4 text-gray-600 leading-relaxed">
                    {{ $review->comment }}
                </p>

            @endif

        </div>

    @empty

        <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center">

            <span class="material-symbols-outlined text-6xl text-gray-300 mb-3">
                reviews
            </span>

            <h3 class="text-lg font-bold text-gray-800">
                No reviews yet
            </h3>

            <p class="text-sm text-gray-400 mt-2">
                Be the first guest to leave a review for this property.
            </p>

        </div>

    @endforelse

</div>

                {{-- AVAILABLE UNITS --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Available Units</h2>

                    @if($units->count())
                        <div class="space-y-4">
                            @foreach($units as $unit)
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row overflow-hidden transition-all hover:shadow-md">
                                    
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
                                            @isset($unit['description'])
                                                <p class="mt-3 text-xs md:text-sm text-gray-500 leading-relaxed line-clamp-2">
                                                    {{ $unit['description'] }}
                                                </p>
                                            @endisset
                                        </div>

                                        <div class="flex items-center justify-between gap-3 pt-4 border-t border-gray-50">
                                            <div>
                                                <span class="text-xl font-extrabold text-blue-600 block">
                                                    Rp{{ number_format($unit['price'], 0, ',', '.') }}
                                                </span>
                                                <span class="text-[10px] uppercase tracking-wider font-bold text-gray-400 block -mt-1">
                                                    per night
                                                </span>
                                            </div>

                                            @if(auth()->check())
                                                <a href="{{ route('booking.open', ['id' => $unit['id'], 'checkin' => $checkin ?? '', 'checkout' => $checkout ?? '', 'guests' => $guests ?? 1]) }}"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white text-center px-5 py-2.5 rounded-xl font-bold text-xs md:text-sm transition-colors shadow-sm">
                                                    Book Unit
                                                </a>
                                            @else
                                                <a href="{{ route('login') }}"
                                                    class="bg-gray-900 hover:bg-gray-800 text-white text-center px-5 py-2.5 rounded-xl font-bold text-xs md:text-sm transition-colors shadow-sm">
                                                    Login to Book
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-2xl p-10 text-center border border-dashed border-gray-200">
                            <span class="material-symbols-outlined text-4xl text-gray-300 block mb-2">bed</span>
                            <h3 class="text-base font-bold text-gray-800">No Units Available</h3>
                            <p class="text-xs text-gray-400 mt-1 max-w-xs mx-auto">
                                This property currently has no available units for your criteria.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-1 lg:sticky lg:top-28">
                <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-xl flex flex-col gap-6">
                    <div class="flex items-baseline justify-between">
                        <div>
                            <span class="text-xs text-gray-400 block font-bold uppercase tracking-wider">Starting from</span>
                            <div class="text-2xl font-extrabold text-blue-600">
                                Rp{{ number_format($units->min('price') ?? 0, 0, ',', '.') }}
                            </div>
                            <span class="text-xs text-gray-400">/night</span>
                        </div>
                        <div class="flex items-center gap-1 bg-yellow-50 border border-yellow-100 px-2.5 py-1 rounded-xl shadow-sm">
                            <span class="material-symbols-outlined text-yellow-500 text-[18px] icon-fill">star</span>
                            {{-- <span class="text-sm font-bold text-gray-800">4.8</span> --}}
                            @if($property['review_count'])
    <span class="text-sm font-bold text-gray-800">
        {{ number_format($property['avg_rating'],1) }}
    </span>
@else
    <span class="text-xs text-gray-500">
        No reviews
    </span>
@endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex flex-col">
                            <span class="text-[10px] font-extrabold text-gray-400 uppercase mb-1">Check-in</span>
                            <input type="date" id="checkin" value="{{ $checkin ?? date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="bg-transparent border-none p-0 text-xs md:text-sm font-bold text-gray-800 focus:ring-0 outline-none w-full">
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex flex-col">
                            <span class="text-[10px] font-extrabold text-gray-400 uppercase mb-1">Check-out</span>
                            <input type="date" id="checkout" value="{{ $checkout ?? date('Y-m-d', strtotime('+1 day')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="bg-transparent border-none p-0 text-xs md:text-sm font-bold text-gray-800 focus:ring-0 outline-none w-full">
                        </div>
                    </div>


                    <div class="flex flex-col gap-2 pt-2">
   
                        <button onclick="toggleFav(this, '{{ $property['id'] }}')" class="flex items-center justify-center w-full border border-gray-200 text-gray-700 font-bold text-xs py-3.5 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[18px] align-middle mr-1.5 fav-icon-bottom">favorite_border</span> Save to Favourites
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </main>

</div>

<script>
function scrollToUnits() {
    const target = document.querySelector('.space-y-4');
    if(target) {
        window.scrollTo({
            top: target.offsetTop - 120,
            behavior: 'smooth'
        });
    }
}

async function toggleFav(btn, propertyId) {

    try {

        const response = await fetch("{{ route('favorites.toggle') }}", {

            method: "POST",

            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },

            body: JSON.stringify({
                property_id: propertyId
            })

        });

        if(response.status == 401){
            window.location.href = "{{ route('login') }}";
            return;
        }

        const data = await response.json();

        if(data.status == "added"){
            document.querySelectorAll('.fav-icon,.fav-icon-bottom').forEach(icon=>{
                icon.textContent="favorite";
                icon.classList.add("text-red-500","icon-fill");
            });
        }

        if(data.status == "removed"){
            document.querySelectorAll('.fav-icon,.fav-icon-bottom').forEach(icon=>{
                icon.textContent="favorite_border";
                icon.classList.remove("text-red-500","icon-fill");
            });
        }

    } catch(err){
        console.log(err);
    }

}


</script>

<script>

const isFavorite = @json($isFavorite);

document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".fav-icon,.fav-icon-bottom").forEach(icon=>{

        if(isFavorite){
            icon.textContent="favorite";
            icon.classList.add("text-red-500","icon-fill");
        }

    });

});

</script>
@endsection