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
                    <div class="flex gap-3 mb-6">
                        <button type="button" onclick="togglePaymentTab('card')" id="tabBtn-card" class="flex-1 py-3.5 rounded-xl border-2 border-blue-600 bg-blue-50/50 text-blue-600 font-bold text-sm transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">credit_card</span> Credit Card
                        </button>
                        <button type="button" onclick="togglePaymentTab('bank')" id="tabBtn-bank" class="flex-1 py-3.5 rounded-xl border-2 border-gray-200 text-gray-500 hover:bg-gray-50 font-bold text-sm transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">account_balance</span> Bank Transfer
                        </button>
                    </div>
                    
                    <div id="payContent-card" class="grid grid-cols-1 sm:grid-cols-2 gap-4 transition-all">
                        <input type="text" placeholder="Card Number" class="w-full h-14 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm sm:col-span-2 focus:outline-none focus:border-blue-600 transition-all">
                        <input type="text" placeholder="Expiry (MM/YY)" class="w-full h-14 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:border-blue-600 transition-all">
                        <input type="text" placeholder="CVV" class="w-full h-14 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:border-blue-600 transition-all">
                    </div>

                    <div id="payContent-bank" class="hidden p-6 bg-gray-50 border border-gray-100 rounded-xl text-center">
                        <p class="text-sm font-medium text-gray-600">You will receive virtual account payment bank credentials directly via your registered mail address inbox.</p>
                    </div>
                </div>
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

                    <div class="flex justify-between items-baseline">
                        <span class="text-sm font-bold text-gray-800">Grand Total Invoice</span>
                        <span class="text-2xl font-extrabold text-blue-600">
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
    // Penanganan tab metode pembayaran kartu kredit vs transfer bank
    function togglePaymentTab(type) {
        document.getElementById('paymentMethodInput').value = type;
        
        const cardBtn = document.getElementById('tabBtn-card');
        const bankBtn = document.getElementById('tabBtn-bank');
        const cardBox = document.getElementById('payContent-card');
        const bankBox = document.getElementById('payContent-bank');

        if(type === 'card') {
            cardBtn.className = 'flex-1 py-3.5 rounded-xl border-2 border-blue-600 bg-blue-50/50 text-blue-600 font-bold text-sm transition-all flex items-center justify-center gap-2';
            bankBtn.className = 'flex-1 py-3.5 rounded-xl border-2 border-gray-200 text-gray-500 hover:bg-gray-50 font-bold text-sm transition-all flex items-center justify-center gap-2';
            cardBox.classList.remove('hidden');
            bankBox.classList.add('hidden');
        } else {
            bankBtn.className = 'flex-1 py-3.5 rounded-xl border-2 border-blue-600 bg-blue-50/50 text-blue-600 font-bold text-sm transition-all flex items-center justify-center gap-2';
            cardBtn.className = 'flex-1 py-3.5 rounded-xl border-2 border-gray-200 text-gray-500 hover:bg-gray-50 font-bold text-sm transition-all flex items-center justify-center gap-2';
            bankBox.classList.remove('hidden');
            cardBox.classList.add('hidden');
        }
    }

    // Mengirimkan form checkout via AJAX Fetch POST ke Controller
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
                // Berhasil, arahkan langsung ke halaman struk invoice tanda terima
                window.location.href = data.redirect_url;
            } else {
                alert('Gagal memproses transaksi: ' + data.message);
                submitBtn.disabled = false;
                submitBtn.innerText = 'Confirm Purchase & Book Now';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kendala jaringan internet server.');
            submitBtn.disabled = false;
            submitBtn.innerText = 'Confirm Purchase & Book Now';
        });
    });
</script>
</body>
</html>