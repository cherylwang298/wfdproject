@extends('layouts.user')

@section('style')
<style>
.guest-counter{
    display:flex;
    align-items:center;
    gap:12px;
}
.guest-counter button{
    width:32px;
    height:32px;
    border-radius:9999px;
    background:#f0f3ff;
    border:none;
    cursor:pointer;
    font-size:20px;
    font-weight:bold;
}
.guest-counter span{
    min-width:30px;
    text-align:center;
    font-size:18px;
    font-weight:600;
}

.glass-panel{
    background:rgba(255,255,255,.6);
    backdrop-filter:blur(24px);
    border:1px solid rgba(255,255,255,.6);
    box-shadow:0 20px 60px rgba(0,0,0,.08);
}

.glass-input{
    background:rgba(255,255,255,.55);
    backdrop-filter:blur(14px);
    border:1px solid rgba(255,255,255,.5);
}

.gradient-button{
    background:linear-gradient(135deg,#0062ff,#00c8e8);
    color:white;
    transition:.25s;
}

.gradient-button:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 28px rgba(0,98,255,.3);
}

/* Memperbaiki alignment datepicker bawaan HP */
input[type="date"] {
    position: relative;
    min-height: 24px;
}
</style>
@endsection

@section('content')

@php
    $currentPage = 'hotel';
@endphp

@include('partials.navbar')

<header class="pt-24 pb-12 md:pt-32 md:pb-20 px-4 sm:px-6 md:px-12 bg-gradient-to-b from-slate-100 to-white">

    <div class="max-w-6xl mx-auto">

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-center mb-6 md:mb-10 tracking-tight">
            Find your perfect stay
        </h1>

        <div class="glass-panel rounded-3xl p-4 sm:p-6 md:p-8">

            <form action="{{ route('accomodations.search') }}" method="GET">

                <div class="grid grid-cols-1 lg:grid-cols-11 gap-4 items-end">

                    {{-- LOCATION --}}
                    <div class="lg:col-span-3 relative w-full">
                        <div class="glass-input rounded-2xl h-16 flex items-center px-5 w-full">
                            <div class="w-full">
                                <label class="text-xs font-bold text-gray-500 block">
                                    Location
                                </label>
                                <input
                                    type="text"
                                    id="citySearch"
                                    placeholder="Search city..."
                                    autocomplete="off"
                                    class="w-full bg-transparent border-0 outline-none font-semibold mt-1 p-0 focus:ring-0 text-sm sm:text-base">
                                <input
                                    type="hidden"
                                    name="city"
                                    id="selectedCity"
                                    required>
                            </div>
                        </div>

                        <div
                            id="cityDropdown"
                            class="hidden absolute left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl max-h-64 overflow-y-auto z-50 border border-gray-100">
                            @foreach($cities as $city)
                                <div
                                    class="city-option px-5 py-3 cursor-pointer hover:bg-blue-50 text-sm sm:text-base transition-colors"
                                    data-city="{{ $city }}">
                                    {{ $city }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- CHECKIN --}}
                    <div class="lg:col-span-3 w-full">
                        <div class="glass-input rounded-2xl h-16 flex items-center px-5 w-full">
                            <div class="w-full">
                                <label class="text-xs font-bold text-gray-500 block">
                                    Check-in
                                </label>
                                <input
                                    type="date"
                                    name="checkin"
                                    required
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full bg-transparent border-0 outline-none font-semibold mt-1 p-0 pr-2 focus:ring-0 text-sm sm:text-base">
                            </div>
                        </div>
                    </div>

                    {{-- CHECKOUT --}}
                    <div class="lg:col-span-3 w-full">
                        <div class="glass-input rounded-2xl h-16 flex items-center px-5 w-full">
                            <div class="w-full">
                                <label class="text-xs font-bold text-gray-500 block">
                                    Check-out
                                </label>
                                <input
                                    type="date"
                                    name="checkout"
                                    required
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full bg-transparent border-0 outline-none font-semibold mt-1 p-0 pr-2 focus:ring-0 text-sm sm:text-base">
                            </div>
                        </div>
                    </div>

                    {{-- GUESTS --}}
                    <div class="lg:col-span-2 w-full">
                        <div class="glass-input rounded-2xl h-16 flex items-center px-5 w-full">
                            <div class="w-full">
                                <label class="text-xs font-bold text-gray-500 block">
                                    Guests
                                </label>
                                <div class="guest-counter justify-between lg:justify-center mt-1">
                                    <button type="button" id="minus" class="select-none">-</button>
                                    <span id="guestCount" class="select-none">1</span>
                                    <button type="button" id="plus" class="select-none">+</button>
                                    <input
                                        type="hidden"
                                        id="guestInput"
                                        name="guests"
                                        value="1">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- SEARCH BUTTON --}}
                <div class="mt-6 md:mt-8 lg:mt-10 flex justify-center">
                    <button
                        type="submit"
                        class="gradient-button w-full sm:w-auto sm:min-w-[200px] rounded-xl px-8 py-3.5 flex items-center justify-center gap-2 font-semibold text-base shadow-md">
                        <span class="material-symbols-outlined text-xl">
                            search
                        </span>
                        Search
                    </button>
                </div>

            </form>

        </div>

    </div>

</header>

@include('partials.footer')


@endsection

@section('script')
<script>
let guests = 1;
const count = document.getElementById('guestCount');
const input = document.getElementById('guestInput');

document.getElementById('plus').onclick = function(e){
    e.preventDefault();
    if(guests < 10){
        guests++;
        count.innerHTML = guests;
        input.value = guests;
    }
}

document.getElementById('minus').onclick = function(e){
    e.preventDefault();
    if(guests > 1){
        guests--;
        count.innerHTML = guests;
        input.value = guests;
    }
}

const cityInput = document.getElementById('citySearch');
const cityHidden = document.getElementById('selectedCity');
const dropdown = document.getElementById('cityDropdown');
const options = document.querySelectorAll('.city-option');

cityInput.addEventListener('focus', () => {
    dropdown.classList.remove('hidden');
});

cityInput.addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    dropdown.classList.remove('hidden');
    options.forEach(option => {
        const city = option.dataset.city.toLowerCase();
        if(city.includes(keyword)){
            option.style.display = 'block';
        }else{
            option.style.display = 'none';
        }
    });
});

options.forEach(option => {
    option.addEventListener('click', function(){
        cityInput.value = this.dataset.city;
        cityHidden.value = this.dataset.city;
        dropdown.classList.add('hidden');
    });
});

document.addEventListener('click', function(e){
    if(!cityInput.contains(e.target) && !dropdown.contains(e.target)){
        dropdown.classList.add('hidden');
    }
});

const checkin = document.querySelector('[name="checkin"]');
const checkout = document.querySelector('[name="checkout"]');

checkin.addEventListener('change', function(){
    checkout.min = this.value;
    if(checkout.value < this.value){
        checkout.value = "";
    }
});


</script>




@endsection 

