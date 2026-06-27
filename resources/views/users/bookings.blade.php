@extends('layouts.user')

@section('content')

@php
$currentPage = 'hotel';
@endphp

@include('partials.navbar')

<div class="max-w-7xl mx-auto px-6 pt-28 pb-20">
    <h1 class="text-4xl font-bold mb-10">Review & Book Your Accommodation</h1>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">
        {{ session('success') }}
    </div>
@endif


@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
        <strong>Error:</strong> {{ session('error') }}
    </div>
@endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
     
        <div class="lg:col-span-2 space-y-8">
            <form id = "bookingForm" action="{{ route('booking.store') }}" method="POST" class="space-y-8">
                @csrf

                @if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-4">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

                <input type="hidden" name="unit_id" value="{{ $unit['id'] }}">
                <input type="hidden" name="check_in" value="{{ $checkin }}">
                <input type="hidden" name="check_out" value="{{ $checkout }}">
               
                <input id="promoId" type="hidden" name="promo_id" value="{{ $promoId ?? '' }}">

              
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Contact Details</h2>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-gray-600 font-medium mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $fullname ?? '') }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror" required>
                            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" 
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror" required>
                                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone_number ?? '') }}" 
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500 @error('phone') border-red-500 @enderror" placeholder="e.g. 08123456789" required>
                                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

               
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Payment Method</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="border border-gray-200 rounded-2xl p-4 flex items-center cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="payment_method" value="Bank Transfer" class="w-4 h-4 text-blue-600" checked>
                            <span class="ml-3 font-medium text-gray-700">Bank Transfer</span>
                        </label>
                        
                        <label class="border border-gray-200 rounded-2xl p-4 flex items-center cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="payment_method" value="E-Wallet" class="w-4 h-4 text-blue-600">
                            <span class="ml-3 font-medium text-gray-700">E-Wallet (Dana/OVO)</span>
                        </label>

                        <label class="border border-gray-200 rounded-2xl p-4 flex items-center cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="payment_method" value="Credit Card" class="w-4 h-4 text-blue-600">
                            <span class="ml-3 font-medium text-gray-700">Credit Card</span>
                        </label>
                    </div>
                    @error('payment_method') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div id="paymentDetails" class="mt-6"></div>

                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">
        Promo Code
    </h2>

    <div class="flex flex-col sm:flex-row gap-3">
        <input
            type="text"
            name="promo_code"
            id="promoCode"
            placeholder="Enter your promo code"
            class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500">

        <button
            type="button"
            id="applyPromoBtn"
            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition">
            Apply
        </button>
    </div>

    <p id="promoMessage" class="text-sm mt-3 text-gray-500">
        Have a promo code? Enter it above and click <strong>Apply</strong>.
    </p>
</div>

                     <input
    type="hidden"
    id="totalPriceInput"
    name="total_price"
    value="{{ $totalPrice }}">

{{-- @php

@endphp --}}
 {{-- <input type="hidden" name="total_price" value="{{ $totalPrice }}"> --}}

              
                <button id="bookNowBtn" type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-blue-200 transition duration-200">
                    Book Now
                </button>
            </form>
        </div>

        {{-- RINGKASAN BOOKING & HARGA TOTAL --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 sticky top-28">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Price Details</h2>
                
                {{-- Info Gambar & Nama --}}
                <div class="flex gap-4 pb-6 border-b border-gray-100">
                    <div class="w-24 h-20 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                        @if($unit['image'])
                            {{-- Jika ada gambar asli dari database storage --}}
                            <img src="{{ asset('storage/'.$unit['image']['path']) }}" class="w-full h-full object-cover" alt="{{ $unit['name'] }}">
                        @else
                            {{-- FALLBACK: Gambar dummy interior kamar hotel/resort mewah --}}
                            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=300&q=80" class="w-full h-full object-cover" alt="{{ $unit['name'] }}">
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 leading-tight">{{ $unit['name'] }}</h3>
                        <p class="text-sm text-gray-500 mt-1">📍 {{ $property['name'] ?? 'Property' }}, {{ $property['city'] ?? '' }}</p>
                    </div>
                </div>

                {{-- Detail Durasi Singgah --}}
                <div class="py-4 border-b border-gray-100 text-sm space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Check-in:</span>
                        <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($checkin)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Check-out:</span>
                        <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($checkout)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Duration:</span>
                        <span class="font-semibold text-gray-800">{{ $nights }} Night(s)</span>
                    </div>
                </div>

                {{-- Rincian Penghitungan Harga --}}
                <div class="pt-4 space-y-3">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Rp{{ number_format($unit['price'], 2) }} x {{ $nights }} night</span>
                        <span>Rp{{ number_format($unit['price'] * $nights, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Tax and Service Fee (11%):</span>
                        <span class="text-gray-600 font-medium">Rp {{ number_format(($unit['price'] * $nights) * 0.11, 0, ',', '.') }}</span>
                    </div>

                    <div id="promoDiscountRow" class="hidden justify-between text-green-600">
    <span>Promo Discount</span>
    <span id="promoDiscountText"></span>
</div>

                    @php
                        $totalPriceandtx = ($unit['price'] * $nights) + (($unit['price'] * $nights) * 0.11);
                    @endphp


                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <span class="text-base font-bold text-gray-800">Total Price</span>
  

<span
    id="totalPriceText"
    data-total="{{ $totalPrice }}"
    class="text-2xl font-bold text-blue-600">

    Rp{{ number_format($totalPrice,0,',','.') }}

</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script>

const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
const paymentDetails = document.getElementById('paymentDetails');

function renderPayment(method){

    if(method === "Credit Card"){

        paymentDetails.innerHTML = `
            <div class="border rounded-2xl p-5 bg-gray-50 space-y-4">

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Card Number
                    </label>

                    <input
                        type="text"
                        name="card_number"
                        maxlength="19"
                        placeholder="1234 5678 9012 3456"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Card Holder Name
                    </label>

                    <input
                        type="text"
                        name="card_name"
                        placeholder="John Doe"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Expiry
                        </label>

                        <input
                            type="text"
                            name="expiry"
                            placeholder="MM/YY"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            CVV
                        </label>

                        <input
                            type="password"
                            maxlength="3"
                            name="cvv"
                            placeholder="123"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3">
                    </div>

                </div>

            </div>
        `;

    }

    else if(method === "E-Wallet"){

        paymentDetails.innerHTML = `

            <div class="border rounded-2xl p-6 bg-gray-50">

    <p class="font-semibold text-center mb-4">
        Scan QR Code below
    </p>

    <div class="flex justify-center items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="296" height="296">
	<path d="M32,236v-28h56v56H32V236L32,236z M80,236v-20H40v40h40V236L80,236z M48,236v-12h24v24H48V236L48,236z M104,260v-4h-8v-16h8v-24h8v-8H96v-8H64v-8h8v-8H56v16h-8v-8H32v-8h16v-16h-8v8h-8v-16h16v8h8v8h8v-8h8v8h16v-8h-8v-8H56v-8h24v-8H56v-8h-8v8H32v-24h8v8h48v-8h-8v-8H64v8h-8v-8H40V96h16v16h8v-8h16v-8h8v8h-8v8h8v8h8v-16h8v-8h-8V72h16v8h8v8h-8v8h8v48h-16v-8h-8v8h-8v8h-8v8h8v8h8v8h16v-8h-8v-8h-8v-8h16v16h8v-16h8v16h8v-24h8v-8h8v8h-8v8h8v8h24v-8h-8v-8h-8v-16h-8v-8h8v-8h8v-8h-8v-8h-8v16h-8v-8h-8v8h-8v-8h8v-8h-8V72h-8v-8h8v8h8V40h8v16h16v-8h-8V32h16v8h-8v8h16v-8h8v-8h16v24h-16v-8h-8v16h8v24h8v-8h8v40h16v-8h-8V96h16v24h16v-8h-8V96h8v16h8v-8h16v16h-8v-8h-8v8h-8v24h8v8h-8v8h-16v8h-8v8h-16v-8h-8v-8h-8v16h8v8h24v8h16v-8h-8v-8h8v-8h8v8h8v8h8v-16h-8v-8h16v24h-8v16h8v16h-8v24h8v8h-24v16h-24v-8h16v-8h-16v-16h-8v16h-8v8h8v8h-16v-24h-8v16h-8v-8h-8v-32h8v24h8v-24h8v-16h-8v-8h-8v-8h8v-8h-8v-8h-8v32h8v8h-16v16h-8v16h8v8h-8v8h16v8h-16v-8h-8v-8h-8v16h-32V260L104,260z M128,248v-8h8v-24h-16v8h8v8h-16v8h-8v8h8v8h16V248L128,248z M240,240v-8h8v-16h8v-8h-8v-24h-8v24h8v8h-8v8h-8v24h8V240L240,240z M200,236v-4h-8v8h8V236L200,236z M152,220v-4h-8v8h8V220L152,220z M224,212v-12h-24v24h24V212L224,212z M208,212v-4h8v8h-8V212L208,212z M144,204v-4h16v-8h-16v-8h-8v8h8v8h-16v-8h-8v8h-8v-8h-8v-8h-8v-8h-8v8h-8v8h8v-8h8v8h8v8h8v8h32V204L144,204z M120,180v-4h-8v8h8V180L120,180z M160,176v-8h-16v8h8v8h8V176L160,176z M208,164v-4h-8v8h8V164L208,164z M224,156v-4h8v-24h-8v8h-8v8h-8v-8h-16v-8h-8v-8h8V96h-8v-8h-8v-8h-8v8h-8V64h8v8h8v-8h-8v-8h-8v8h-8v24h8v8h8v-8h8v24h-8v8h-8v8h8v16h8v-8h16v8h8v8h16v8h8V156L224,156z M216,148v-4h8v8h-8V148L216,148z M88,140v-4h8v-8h-8v8h-8v8h8V140L88,140z M112,124v-4h-8v8h8V124L112,124z M112,84v-4h-8v8h8V84L112,84z M144,80v-8h-8v16h8V80L144,80z M192,44v-4h-8v8h8V44L192,44z M256,260v-4h8v8h-8V260L256,260z M256,144v-8h-8v-8h8v8h8v16h-8V144L256,144z M32,60V32h56v56H32V60L32,60zM80,60V40H40v40h40V60L80,60z M48,60V48h24v24H48V60L48,60z M208,60V32h56v56h-56V60L208,60z M256,60V40h-40v40h40V60L256,60zM224,60V48h24v24h-24V60L224,60z M96,60v-4h8v8h-8V60L96,60z M112,52v-4h-8V32h8v8h8v-8h8v8h-8v16h-8V52L112,52z"/>
</svg>

    </div>

    <p class="mt-4 text-center text-sm text-gray-500">
        Supports Dana, OVO, GoPay, ShopeePay and Mobile Banking.
    </p>

</div>

        `;

    }

    else{

        paymentDetails.innerHTML = `

            <div class="border rounded-2xl p-5 bg-gray-50">

                <label class="block font-medium mb-3">
                    Choose Bank
                </label>

                <select
                    name="bank_name"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3">

                    <option>BCA</option>
                    <option>Mandiri</option>
                    <option>BNI</option>
                    <option>BRI</option>
                    <option>CIMB Niaga</option>

                </select>

                <p class="text-sm text-gray-500 mt-3">
                  A Virtual Account number will be sent to your email after you complete your booking.
                </p>

            </div>

        `;

    }

}

paymentRadios.forEach(radio=>{

    radio.addEventListener("change",function(){

        renderPayment(this.value);

    });

});

renderPayment(document.querySelector('input[name="payment_method"]:checked').value);

</script>


<script>

const bookingForm = document.getElementById("bookingForm");

bookingForm.addEventListener("submit", function(e){

    e.preventDefault();

    Swal.fire({
        title: "Confirm Booking?",
        text: "Please make sure all booking details are correct before continuing.",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, Book Now",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#2563eb",
        cancelButtonColor: "#6b7280",
        reverseButtons: true
    }).then((result) => {

        if(result.isConfirmed){

            Swal.fire({
                title: "Processing Booking...",
                text: "Please wait a moment.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            bookingForm.submit();
        }

    });

});


</script>

<script>
const btn = document.getElementById("applyPromoBtn");

btn.addEventListener("click", function(){

    fetch("{{ route('promo.apply') }}",{

        method:"POST",

        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":"{{ csrf_token() }}"
        },

        body:JSON.stringify({

            promo_code:document.getElementById("promoCode").value,

            total:document.getElementById("totalPriceText").dataset.total

        })

    })

    .then(res=>res.json())

    .then(data=>{

        if(data.success){

            document.getElementById("promoId").value = data.promo_id;

            document.getElementById("totalPriceText").innerHTML =
                "Rp"+Number(data.new_total).toLocaleString('id-ID');

            document.getElementById("totalPriceInput").value = data.new_total;

            document.getElementById("promoDiscountRow").classList.remove("hidden");

document.getElementById("promoDiscountRow").classList.add("flex");

document.getElementById("promoDiscountText").innerHTML =
    "- Rp" + Number(data.discount).toLocaleString('id-ID');


            Swal.fire({
                icon:'success',
                title:'Promo Applied!',
                text:data.message
            });

        }else{

            Swal.fire({
                icon:'error',
                title:'Oops',
                text:data.message
            });

        }

    });

});


</script>
@endsection