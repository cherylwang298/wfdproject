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
</style>
@endsection

@section('content')

@include('dummy_pages.partials.navbar')

<header class="pt-32 pb-20 px-5 md:px-12 bg-gradient-to-b from-slate-100 to-white">

    <div class="max-w-6xl mx-auto">

        <h1 class="text-5xl font-extrabold text-center mb-10">
            Find your perfect stay
        </h1>

        <div class="glass-panel rounded-3xl p-8">

            <form action="{{ route('accomodations.search') }}" method="GET">

                <div class="grid grid-cols-1 md:grid-cols-11 gap-4 items-end">

      {{-- LOCATION --}}
<div class="md:col-span-3 relative">

    <div class="glass-input rounded-2xl h-16 flex items-center px-5">

        <div class="w-full">

            <label class="text-xs font-bold text-gray-500">
                Location
            </label>

            <input
                type="text"
                id="citySearch"
                placeholder="Search city..."
                autocomplete="off"
                class="w-full bg-transparent border-0 outline-none font-semibold mt-1">

            <input
                type="hidden"
                name="city"
                id="selectedCity"
                required>

        </div>

    </div>

    <div
        id="cityDropdown"
        class="hidden absolute left-0 right-0 mt-2 bg-white rounded-2xl shadow-xl max-h-64 overflow-y-auto z-50">

        @foreach($cities as $city)
            <div
                class="city-option px-5 py-3 cursor-pointer hover:bg-blue-50"
                data-city="{{ $city }}">
                {{ $city }}
            </div>
        @endforeach

    </div>

</div>

                    {{-- CHECKIN --}}
                    <div class="md:col-span-3">
                        <div class="glass-input rounded-2xl h-16 flex items-center px-5">

                            <div class="w-full">
                                <label class="text-xs font-bold text-gray-500">
                                    Check-in
                                </label>

                                <input
                                    type="date"
                                    name="checkin"
                                    required
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full bg-transparent border-0 outline-none font-semibold mt-1">
                                    
                            </div>

                        </div>
                    </div>

                    {{-- CHECKOUT --}}
                    <div class="md:col-span-3">

                        <div class="glass-input rounded-2xl h-16 flex items-center px-5">

                            <div class="w-full">

                                <label class="text-xs font-bold text-gray-500">
                                    Check-out
                                </label>

                                <input
                                    type="date"
                                    name="checkout"
                                    required
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full bg-transparent border-0 outline-none font-semibold mt-1">

                            </div>

                        </div>

                    </div>

                    {{-- GUESTS --}}
                    <div class="md:col-span-2">

                        <div class="glass-input rounded-2xl h-16 flex items-center px-5">

                            <div class="w-full">

                                <label class="text-xs font-bold text-gray-500">
                                    Guests
                                </label>

                                <div class="guest-counter justify-center mt-1">

                                    <button type="button" id="minus">
                                        -
                                    </button>

                                    <span id="guestCount">
                                        1
                                    </span>

                                    <button type="button" id="plus">
                                        +
                                    </button>

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

                <div class="mt-10 flex justify-center">

                    <button
                        class="gradient-button rounded-xl px-8 py-3 flex items-center gap-2 font-semibold">

                        <span class="material-symbols-outlined">
                            search
                        </span>

                        Search

                    </button>

                </div>

            </form>

        </div>

    </div>

</header>

@endsection

@section('script')

<script>

let guests = 1;

const count = document.getElementById('guestCount');

const input = document.getElementById('guestInput');

document.getElementById('plus').onclick = function(){

    if(guests < 10){

        guests++;

        count.innerHTML = guests;

        input.value = guests;

    }

}

document.getElementById('minus').onclick = function(){

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

