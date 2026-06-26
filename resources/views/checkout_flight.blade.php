<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Flight - StayGo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="bg-background text-on-background antialiased flex flex-col min-h-screen">

@include('partials.navbar', ['currentPage' => 'flights'])

<main class="pt-28 pb-24 px-6 md:px-16 max-w-7xl mx-auto w-full flex-grow">
    <h1 class="text-3xl md:text-4xl font-extrabold text-on-surface mb-10 tracking-tight">Complete your flight booking</h1>

    <form id="checkoutFlightForm">
        @csrf
        <input type="hidden" name="outbound_id" value="{{ $outboundFlight['id'] }}">
        <input type="hidden" name="outbound_price" value="{{ $outboundFlight['price'] }}">
        @if ($inboundFlight)
            <input type="hidden" name="inbound_id" value="{{ $inboundFlight['id'] }}">
            <input type="hidden" name="inbound_price" value="{{ $inboundFlight['price'] }}">
        @endif
        <input type="hidden" name="payment_method" id="paymentMethodInput" value="card">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 flex flex-col gap-8">
                
                <div class="bg-white border border-gray-200 p-6 md:p-8 rounded-2xl shadow-sm">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600">contact_mail</span> Contact Information
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2">First Name</label>
                            <input type="text" 
                                name="contact_first_name"
                                value="{{ Auth::user()->first_name ?? '' }}" 
                                placeholder="First Name" 
                                class="w-full h-14 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm font-medium focus:outline-none focus:border-blue-600 focus:bg-white transition-all" 
                                required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2">Last Name</label>
                            <input type="text" 
                                name="contact_last_name"
                                value="{{ Auth::user()->last_name ?? '' }}" 
                                placeholder="Last Name" 
                                class="w-full h-14 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm font-medium focus:outline-none focus:border-blue-600 focus:bg-white transition-all" 
                                required>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 mb-2">Email Address</label>
                            <input type="email" 
                                name="contact_email"
                                value="{{ Auth::user()->email ?? '' }}" 
                                placeholder="Email Address" 
                                class="w-full h-14 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm font-medium focus:outline-none focus:border-blue-600 focus:bg-white transition-all" 
                                required>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 mb-2">Phone Number</label>
                            <input type="tel" 
                                name="contact_phone"
                                value="{{ Auth::user()->phone_number ?? '' }}" 
                                placeholder="Phone Number" 
                                class="w-full h-14 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm font-medium focus:outline-none focus:border-blue-600 focus:bg-white transition-all" 
                                required>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 p-6 md:p-8 rounded-2xl shadow-sm">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600">groups</span> Passenger Details
                    </h2>
                    
                    <div class="flex flex-col gap-6">
                        @for ($i = 0; $i < $totalPassengers; $i++)
                            @php $isAdult = $i < $adults; @endphp
                            <div class="p-5 bg-gray-50 border border-gray-100 rounded-2xl flex flex-col gap-4">
                                <h3 class="text-sm font-bold text-blue-600 uppercase tracking-wider">
                                    Passenger {{ $i + 1 }} {{ $isAdult ? '(Adult)' : '(Child)' }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input type="text" name="passengers[{{ $i }}][name]" placeholder="Full Name (matching Passport/ID)" class="w-full h-12 bg-white border border-gray-200 rounded-xl px-4 text-xs font-semibold focus:outline-none focus:border-blue-600 transition-all" required>
                                    <input type="text" name="passengers[{{ $i }}][phone]" placeholder="Phone Number" class="w-full h-12 bg-white border border-gray-200 rounded-xl px-4 text-xs font-semibold focus:outline-none focus:border-blue-600 transition-all" required>
                                    <input type="text" name="passengers[{{ $i }}][nik]" placeholder="NIK (Indonesian Resident ID - 16 Digits)" class="w-full h-12 bg-white border border-gray-200 rounded-xl px-4 text-xs font-semibold focus:outline-none focus:border-blue-600 transition-all" maxlength="16">
                                    <input type="text" name="passengers[{{ $i }}][passport]" placeholder="Passport Number (International Flights)" class="w-full h-12 bg-white border border-gray-200 rounded-xl px-4 text-xs font-semibold focus:outline-none focus:border-blue-600 transition-all">
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="bg-white border border-gray-200 p-6 md:p-8 rounded-2xl shadow-sm">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600">payments</span> Payment Method
                    </h2>
                    
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
                    
                    {{-- Container dinamis untuk merender sub-form input pembayaran --}}
                    <div id="paymentDetails" class="mt-6"></div>
                </div>

                {{-- PROMO CODE PANEL FOR FLIGHT --}}
                <div class="bg-white border border-gray-200 p-6 md:p-8 rounded-2xl shadow-sm w-full">
                    <h2 class="text-xl font-bold mb-6 text-gray-800">Promo Code</h2>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="text" name="promo_code" id="promoCode" placeholder="Enter your promo code" 
                            class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500 text-sm">
                        <button type="button" id="applyPromoBtn" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition text-sm">
                            Apply
                        </button>
                    </div>
                    <p id="promoMessage" class="text-sm mt-3 text-gray-500">
                        Have a promo code? Enter it above and click <strong>Apply</strong>.
                    </p>
                </div>

                {{-- Hidden trackers untuk menyimpan state nominal final --}}
                <input type="hidden" id="promoId" name="promo_id" value="">
                <input type="hidden" id="totalPriceInput" name="total_price" value="{{ $grandTotal }}">
            </div>

            

            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-xl sticky top-28 flex flex-col gap-6">
                    <h3 class="text-lg font-bold text-gray-800">Booking Flight Summary</h3>
                    
                    <div class="flex gap-4 pb-5 border-b border-gray-100 items-start">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-blue-600 text-2xl">flight</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 capitalize">{{ $outboundFlight['airline'] }}</h4>
                            <p class="text-xs font-semibold text-gray-500 mt-0.5">
                                {{ $outboundFlight['from'] }} → {{ $outboundFlight['to'] }}
                                @if($inboundFlight) / {{ $inboundFlight['from'] }} → {{ $inboundFlight['to'] }} @endif
                            </p>
                            <p class="text-[11px] font-medium text-gray-400 mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">airline_seat_recline_extra</span>
                                <span>{{ $totalPassengers }} Passenger(s) · Economy</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-between text-gray-500">
                        <span>Tickets Cost Base</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-gray-500">
                        <span>Vat Service Tax & Government Fees (12%)</span>
                        <span>Rp {{ number_format($taxes, 0, ',', '.') }}</span>
                    </div>

                    {{-- BARIS BARU: Row Diskon Promo Penerbangan --}}
                    <div id="promoDiscountRow" class="hidden justify-between text-green-600 text-sm font-medium">
                        <span>Promo Discount</span>
                        <span id="promoDiscountText"></span>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <span class="text-sm font-bold text-gray-800">Grand Total Invoice</span>
                        {{-- Tambahkan id "totalPriceText" dan data-total awal --}}
                        <span id="totalPriceText" data-total="{{ $grandTotal }}" class="text-2xl font-extrabold text-blue-600">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <button type="submit" id="confirmBookingBtn" class="w-full text-center font-bold text-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 py-4 rounded-xl shadow-md transform active:scale-95 transition-all">
                        Confirm Purchase & Book Now
                    </button>
                </div>
            </div>
        </div>
    </form>
</main>

@include('partials.footer')

<script>
const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
const paymentDetails = document.getElementById('paymentDetails');

// Fungsi merender form detail pembayaran secara dinamis sesuai pilihan radio button
function renderPayment(method){
    if(method === "Credit Card"){
        paymentDetails.innerHTML = `
            <div class="border rounded-2xl p-5 bg-gray-50 space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Card Number</label>
                    <input type="text" name="card_number" maxlength="19" placeholder="1234 5678 9012 3456" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Card Holder Name</label>
                    <input type="text" name="card_name" placeholder="John Doe" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Expiry</label>
                        <input type="text" name="expiry" placeholder="MM/YY" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">CVV</label>
                        <input type="password" maxlength="3" name="cvv" placeholder="123" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm">
                    </div>
                </div>
            </div>`;
    } else if(method === "E-Wallet"){
        paymentDetails.innerHTML = `
            <div class="border rounded-2xl p-6 bg-gray-50 text-center">
                <p class="font-semibold mb-4">Scan QR Code below</p>
                <div class="flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 296 296" class="bg-white p-2 rounded-xl shadow-sm">
                        <path d="M32,236v-28h56v56H32V236L32,236z M80,236v-20H40v40h40V236L80,236z M48,236v-12h24v24H48V236L48,236z M104,260v-4h-8v-16h8v-24h8v-8H96v-8H64v-8h8v-8H56v16h-8v-8H32v-8h16v-16h-8v8h-8v-16h16v8h8v8h8v-8h8v8h16v-8h-8v-8H56v-8h24v-8H56v-8h-8v8H32v-24h8v8h48v-8h-8v-8H64v8h-8v-8H40V96h16v16h8v-8h16v-8h8v8h-8v8h8v8h8v-16h8v-8h-8V72h16v8h8v8h-8v8h8v48h-16v-8h-8v8h-8v8h-8v8h8v8h8v8h16v-8h-8v-8h-8v-8h16v16h8v-16h8v16h8v-24h8v-8h8v8h-8v8h8v8h24v-8h-8v-8h-8v-16h-8v-8h8v-8h8v-8h-8v-8h-8v16h-8v-8h-8v8h-8v-8h8v-8h-8V72h-8v-8h8v8h8V40h8v16h16v-8h-8V32h16v8h-8v8h16v-8h8v-8h16v24h-16v-8h-8v16h8v24h8v-8h8v40h16v-8h-8V96h16v24h16v-8h-8V96h8v16h8v-8h16v16h-8v-8h-8v8h-8v24h8v8h-8v8h-16v8h-8v8h-16v-8h-8v-8h-8v16h8v8h24v8h16v-8h-8v-8h8v-8h8v8h8v8h8v-16h-8v-8h16v24h-8v16h8v16h-8v24h8v8h-24v16h-24v-8h16v-8h-16v-16h-8v16h-8v8h8v8h-16v-24h-8v16h-8v-8h-8v-32h8v24h8v-24h8v-16h-8v-8h-8v-8h8v-8h-8v-8h-8v32h8v8h-16v16h-8v16h8v8h-8v8h16v8h-16v-8h-8v-8h-8v16h-32V260L104,260z M128,248v-8h8v-24h-16v8h8v8h-16v8h-8v8h8v8h16V248L128,248z M240,240v-8h8v-16h8v-8h-8v-24h-8v24h8v8h-8v8h-8v24h8V240L240,240z M200,236v-4h-8v8h8V236L200,236z M152,220v-4h-8v8h8V220L152,220z M224,212v-12h-24v24h24V212L224,212z M208,212v-4h8v8h-8V212L208,212z M144,204v-4h16v-8h-16v-8h-8v8h8v8h-16v-8h-8v8h-8v-8h-8v-8h-8v-8h-8v8h-8v8h8v-8h8v8h8v8h8v8h32V204L144,204z M120,180v-4h-8v8h8V180L120,180z M160,176v-8h-16v8h8v8h8V176L160,176z M208,164v-4h-8v8h8V164L208,164z M224,156v-4h8v-24h-8v8h-8v8h-8v-8h-16v-8h-8v-8h8V96h-8v-8h-8v-8h-8v8h-8V64h8v8h8v-8h-8v-8h-8v8h-8v24h8v8h8v-8h8v24h-8v8h-8v8h8v16h8v-8h16v8h8v8h16v8h8V156L224,156z M216,148v-4h8v8h-8V148L216,148z M88,140v-4h8v-8h-8v8h-8v8h8V140L88,140z M112,124v-4h-8v8h8V124L112,124z M112,84v-4h-8v8h8V84L112,84z M144,80v-8h-8v16h8V80L144,80z M192,44v-4h-8v8h8V44L192,44z M256,260v-4h8v8h-8V260L256,260z M256,144v-8h-8v-8h8v8h8v16h-8V144L256,144z M32,60V32h56v56H32V60L32,60zM80,60V40H40v40h40V60L80,60z M48,60V48h24v24H48V60L48,60z M208,60V32h56v56h-56V60L208,60z M256,60V40h-40v40h40V60L256,60zM224,60V48h24v24h-24V60L224,60z M96,60v-4h8v8h-8V60L96,60z M112,52v-4h-8V32h8v8h8v-8h8v8h-8v16h-8V52L112,52z"/>
                    </svg>
                </div>
                <p class="mt-4 text-xs text-gray-500">Supports Dana, OVO, GoPay, ShopeePay and Mobile Banking.</p>
            </div>`;
    } else {
        paymentDetails.innerHTML = `
            <div class="border rounded-2xl p-5 bg-gray-50">
                <label class="block font-medium mb-3 text-sm">Choose Bank</label>
                <select name="bank_name" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm">
                    <option>BCA</option>
                    <option>Mandiri</option>
                    <option>BNI</option>
                    <option>BRI</option>
                    <option>CIMB Niaga</option>
                </select>
                <p class="text-xs text-gray-500 mt-3">A Virtual Account number will be sent to your email after you complete your booking.</p>
            </div>`;
    }
}

paymentRadios.forEach(radio => {
    radio.addEventListener("change", function() {
        renderPayment(this.value);
    });
});
renderPayment(document.querySelector('input[name="payment_method"]:checked').value);

// AJAX APPLY PROMO CODE LOGIC
document.getElementById("applyPromoBtn").addEventListener("click", function() {
    fetch("{{ route('promo.apply') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({
            promo_code: document.getElementById("promoCode").value,
            total: document.getElementById("totalPriceText").dataset.total
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            document.getElementById("promoId").value = data.promo_id;
            document.getElementById("totalPriceText").innerHTML = "Rp " + Number(data.new_total).toLocaleString('id-ID');
            document.getElementById("totalPriceInput").value = data.new_total;
            
            const promoRow = document.getElementById("promoDiscountRow");
            promoRow.classList.remove("hidden");
            promoRow.classList.add("flex");
            document.getElementById("promoDiscountText").innerHTML = "- Rp " + Number(data.discount).toLocaleString('id-ID');

            Swal.fire({
                icon: 'success',
                title: 'Promo Applied!',
                text: data.message,
                confirmButtonColor: '#2563eb'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: data.message,
                confirmButtonColor: '#2563eb'
            });
        }
    });
});

document.getElementById('checkoutFlightForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('confirmBookingBtn');
    submitBtn.disabled = true;
    submitBtn.innerText = 'Processing your transaction...';

    fetch("{{ route('checkout.flight.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            window.location.href = "/my-bookings#flights";
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Transaction Failed',
                text: data.message,
                confirmButtonColor: '#2563eb'
            });
            submitBtn.disabled = false;
            submitBtn.innerText = 'Confirm Purchase & Book Now';
        }
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Network Error',
            text: 'Terjadi kendala jaringan internet server.',
            confirmButtonColor: '#2563eb'
        });
        submitBtn.disabled = false;
        submitBtn.innerText = 'Confirm Purchase & Book Now';
    });
});
</script>
</body>
</html>