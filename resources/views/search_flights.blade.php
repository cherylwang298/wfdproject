<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayGo - Search Flights</title>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .flight-card.selected {
            border: 2px solid #2563eb;
            background: rgba(239, 246, 255, 0.8);
        }
    </style>
</head>
<body class="bg-background text-on-background antialiased min-h-screen flex flex-col">

<!-- Include Navbar Component -->
@include('partials.navbar', ['currentPage' => 'flights'])

<header class="relative pt-32 pb-16 px-6 md:px-16 bg-gray-50 overflow-hidden">
    <div class="absolute inset-0 z-0 opacity-20 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=1200');"></div>
    <div class="absolute inset-0 z-0 bg-gradient-to-b from-transparent to-background"></div>
    
    <div class="max-w-7xl mx-auto relative z-10">
        <h1 class="text-3xl md:text-5xl font-extrabold text-on-surface mb-8 text-center md:text-left">Where to next?</h1>
        <div class="glass-panel rounded-2xl p-6 md:p-8 shadow-xl border border-white/40">
            <form id="flightSearchForm">
                <!-- Trip type toggle -->
                <div class="flex flex-wrap gap-3 mb-6">
                    <label class="trip-type-label flex items-center gap-2 cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-sm transition-all duration-300">
                        <input type="radio" name="trip_type" value="round" class="hidden" checked> 
                        <span class="material-symbols-outlined text-[18px]">check_circle</span> Round trip
                    </label>
                    <label class="trip-type-label flex items-center gap-2 cursor-pointer text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300">
                        <input type="radio" name="trip_type" value="oneway" class="hidden"> 
                        <span class="material-symbols-outlined text-[18px]">circle</span> One way
                    </label>
                </div>

                <!-- Search inputs -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div class="md:col-span-3">
                        <div class="bg-white border border-gray-200 focus-within:border-blue-600 rounded-xl h-16 flex items-center px-4 transition-colors">
                            <span class="material-symbols-outlined text-gray-400 mr-3">flight_takeoff</span>
                            <div class="flex flex-col flex-grow">
                                <span class="text-xs font-bold text-gray-500">From</span>
                                <select id="originSelect" name="origin" class="bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800 outline-none w-full cursor-pointer"></select>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-3">
                        <div class="bg-white border border-gray-200 focus-within:border-blue-600 rounded-xl h-16 flex items-center px-4 transition-colors">
                            <span class="material-symbols-outlined text-gray-400 mr-3">flight_land</span>
                            <div class="flex flex-col flex-grow">
                                <span class="text-xs font-bold text-gray-500">To</span>
                                <select id="destSelect" name="destination" class="bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800 outline-none w-full cursor-pointer"></select>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-4">
                        <div class="bg-white border border-gray-200 rounded-xl h-16 flex items-center overflow-hidden">
                            <div class="flex-1 flex items-center px-4 border-r border-gray-100">
                                <span class="material-symbols-outlined text-gray-400 mr-3">calendar_month</span>
                                <div class="flex flex-col flex-grow">
                                    <span class="text-xs font-bold text-gray-500">Departure</span>
                                    <input type="date" id="departureDate" name="departDate" class="bg-transparent border-none p-0 text-xs font-bold text-gray-800 outline-none w-full">
                                </div>
                            </div>
                            <div class="flex-1 flex items-center px-4" id="returnContainer">
                                <div class="flex flex-col flex-grow">
                                    <span class="text-xs font-bold text-gray-500">Return</span>
                                    <input type="date" id="returnDate" name="returnDate" class="bg-transparent border-none p-0 text-xs font-bold text-gray-800 outline-none w-full">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2 h-16">
                        <button type="submit" id="searchFlightsBtn" class="w-full h-full text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-xl font-bold shadow-lg transform active:scale-95 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">search</span><span id="searchBtnText">Search</span>
                        </button>
                    </div>
                </div>

                <!-- Passenger counters -->
                <div class="flex gap-6 mt-6 pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold text-gray-700">Adults</span>
                        <button type="button" class="w-8 h-8 rounded-full border border-gray-200 bg-gray-50 hover:bg-gray-100 font-bold text-gray-700 flex items-center justify-center text-lg shadow-sm" id="adultMinus">-</button>
                        <span id="adultCount" class="min-w-[20px] text-center font-bold text-sm">1</span>
                        <button type="button" class="w-8 h-8 rounded-full border border-gray-200 bg-gray-50 hover:bg-gray-100 font-bold text-gray-700 flex items-center justify-center text-lg shadow-sm" id="adultPlus">+</button>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold text-gray-700">Children</span>
                        <button type="button" class="w-8 h-8 rounded-full border border-gray-200 bg-gray-50 hover:bg-gray-100 font-bold text-gray-700 flex items-center justify-center text-lg shadow-sm" id="childMinus">-</button>
                        <span id="childCount" class="min-w-[20px] text-center font-bold text-sm">0</span>
                        <button type="button" class="w-8 h-8 rounded-full border border-gray-200 bg-gray-50 hover:bg-gray-100 font-bold text-gray-700 flex items-center justify-center text-lg shadow-sm" id="childPlus">+</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</header>

<main class="flex-grow max-w-7xl w-full mx-auto px-6 md:px-16 py-12">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        <!-- Sidebar Filters -->
        <aside class="md:col-span-3">
            <div class="bg-white border border-gray-200 p-6 sticky top-28 rounded-2xl shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-md font-bold text-gray-800">Airlines</h2>
                    <button id="resetFiltersBtn" class="text-blue-600 text-xs font-semibold hover:underline">Reset all</button>
                </div>
                <div id="airlineFilters" class="space-y-2 max-h-64 overflow-y-auto hide-scrollbar"></div>
            </div>
        </aside>

        <!-- Flight Results -->
        <div class="md:col-span-9">
            <!-- Step Indicator -->
            <div id="stepIndicator" class="hidden flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm" id="step1dot">1</div>
                <div class="flex-1 h-0.5 bg-gray-200" id="stepLine"></div>
                <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center font-bold text-sm" id="step2dot">2</div>
                <span id="stepLabel" class="ml-2 text-sm font-semibold text-gray-600">Select departure flight</span>
            </div>

            {{-- KUNCI BARU: BARIS FILTER SORTING PENERBANGAN --}}
            <div id="sortBarSection" class="hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Flight Options Available</p>
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <label for="flightSortSelector" class="text-xs font-bold text-gray-400 uppercase tracking-wider shrink-0">Sort By:</label>
                    <select id="flightSortSelector" onchange="applyFlightSorting(this.value)" class="bg-white border border-gray-200 text-sm font-bold text-gray-700 rounded-xl px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 w-full sm:w-48 shadow-sm">
                        <option value="default">Recommended</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="duration_asc">Shortest Duration ⚡</option>
                    </select>
                </div>
            </div>

            <div id="flightResults" class="flex flex-col gap-4">
                <div class="text-center py-16 text-gray-500 bg-white border border-dashed border-gray-200 rounded-2xl">
                    <span class="material-symbols-outlined text-5xl block mb-4 text-gray-400">flight_search</span>
                    Use the search form above to find flights.
                </div>
            </div>

            <!-- Selected Outbound Summary -->
            <div id="selectedOutboundSummary" class="hidden bg-blue-50 border-2 border-blue-200 rounded-2xl p-5 mb-6 flex items-center gap-4 mt-6 shadow-sm">
                <span class="material-symbols-outlined text-blue-600 text-3xl">flight_takeoff</span>
                <div>
                    <div class="text-sm font-bold text-blue-600">Departure selected</div>
                    <div id="outboundSummaryText" class="text-sm text-gray-800 mt-0.5 font-medium"></div>
                </div>
                <button id="changeOutboundBtn" class="ml-auto text-xs text-blue-600 font-bold hover:underline">Change</button>
            </div>

            <!-- Return flight results -->
            <div id="returnFlightSection" class="hidden">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600">flight_land</span> Select Return Flight
                </h3>
                <div id="inboundResults" class="flex flex-col gap-4"></div>
            </div>
        </div>
    </div>
</main>

<script>
function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;'}[m]));
}

// 1. AMBIL DATA CITIES DINAMIS DARI API FLIGHTS VIA CONTROLLER
const availableCities = @json($cities);

const originSelect = document.getElementById('originSelect');
const destSelect = document.getElementById('destSelect');

// Render opsi dropdown bandara asal & tujuan berdasarkan rute yang tersedia di database API
availableCities.forEach(cityCode => {
    [originSelect, destSelect].forEach(sel => {
        const opt = document.createElement('option');
        opt.value = cityCode;
        opt.textContent = cityCode; // Menampilkan kode bandara dinamis (e.g., SUB, CGK, IAH)
        sel.appendChild(opt);
    });
});

// Set default value jika datanya tersedia di database
if(availableCities.length > 1) {
    originSelect.value = availableCities[0];
    destSelect.value = availableCities[1] ?? availableCities[0];
}

// Trip type UI toggle logic
const tripRadios = document.querySelectorAll('input[name="trip_type"]');
const returnContainer = document.getElementById('returnContainer');
const tripLabels = document.querySelectorAll('.trip-type-label');

function isRoundTrip() {
    return document.querySelector('input[name="trip_type"]:checked').value === 'round';
}

function updateTripUI() {
    tripLabels.forEach(label => {
        const radio = label.querySelector('input');
        const iconSpan = label.querySelector('.material-symbols-outlined');
        if (radio.checked) {
            label.className = 'trip-type-label flex items-center gap-2 cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-sm';
            iconSpan.textContent = 'check_circle';
        } else {
            label.className = 'trip-type-label flex items-center gap-2 cursor-pointer text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-semibold';
            iconSpan.textContent = 'circle';
        }
    });
    returnContainer.style.display = isRoundTrip() ? 'block' : 'none';
}
tripRadios.forEach(radio => radio.addEventListener('change', updateTripUI));

// Dates & Counter state logic
let adults = 1, children = 0;
const departureInput = document.getElementById('departureDate');
const returnInput = document.getElementById('returnDate');

const today = new Date();
const yyyymmdd = d => d.toISOString().split('T')[0];
departureInput.value = yyyymmdd(today);
departureInput.min = yyyymmdd(today);
returnInput.value = yyyymmdd(new Date(today.getTime() + 7 * 86400000));
returnInput.min = yyyymmdd(new Date(today.getTime() + 86400000));

departureInput.addEventListener('change', function() {
    returnInput.min = this.value;
    if (returnInput.value && returnInput.value <= this.value) returnInput.value = '';
});

document.getElementById('adultPlus').addEventListener('click', () => { adults++; document.getElementById('adultCount').innerText = adults; });
document.getElementById('adultMinus').addEventListener('click', () => { if (adults > 1) { adults--; document.getElementById('adultCount').innerText = adults; } });
document.getElementById('childPlus').addEventListener('click', () => { children++; document.getElementById('childCount').innerText = children; });
document.getElementById('childMinus').addEventListener('click', () => { if (children > 0) { children--; document.getElementById('childCount').innerText = children; } });

// Ambil data semua flights dari Laravel Controller
const flightsData = @json($flights);

// 2. AMBIL DATA AIRLINES DINAMIS HASIL SEEDING API VIA CONTROLLER
const operatingAirlines = @json($operatingAirlines);
const airlineFiltersDiv = document.getElementById('airlineFilters');

// Render checklist filter maskapai secara dinamis di sidebar
operatingAirlines.forEach(airline => {
    const label = document.createElement('label');
    label.className = 'flex items-center gap-3 cursor-pointer py-1';
    label.innerHTML = `<input type="checkbox" class="airline-filter w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" value="${escapeHtml(airline)}" checked> <span class="text-sm font-medium text-gray-700">${escapeHtml(airline)}</span>`;
    airlineFiltersDiv.appendChild(label);
});

// --- TARUH FUNGSI INI TEPAT DI ATAS RENDERFLIGHTCARD ---
function buildReturnFlights(origin, dest) {
    // Cari penerbangan rute balik asli dari database API
    const realReverse = flightsData.filter(f => f.from === dest && f.to === origin);
    if (realReverse.length > 0) return realReverse;

    // Jika rute balik kosong di database, buat rute balik tiruan secara otomatis dari data outbound (swap lokasi)
    const outbound = flightsData.filter(f => f.from === origin && f.to === dest);
    return outbound.map(f => ({
        ...f,
        id: f.id + '_return', // berikan id unik pembeda
        from: f.to,
        to: f.from,
        from_city: f.to_city,
        to_city: f.from_city,
        dep: f.arr,
        arr: f.dep,
        badge: f.badge
    }));
}

function renderFlightCard(f, type, isSelected) {
    // const badgeHtml = f.badge ? `<span class="bg-green-100 text-green-800 border border-green-200 px-2 py-0.5 rounded-full text-xs font-semibold ml-2">${escapeHtml(f.badge)}</span>` : '';
    const selectedClass = isSelected ? 'selected' : '';
    return `
        <div class="flight-card bg-white border border-gray-200 p-5 rounded-2xl hover:shadow-md transition cursor-pointer flex items-center justify-between gap-6 ${selectedClass}" data-id="${f.id}" data-type="${type}">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center"><span class="material-symbols-outlined text-blue-600">flight</span></div>
                <div>
                    <div class="font-bold text-sm text-gray-800">${escapeHtml(f.airline)}</div>
                    <div class="text-xs text-gray-500 font-medium mt-0.5">${escapeHtml(f.code)} · <span class="capitalize">${escapeHtml(f.class)}</span></div>
                </div>
            </div>
            <div class="flex items-center gap-6 flex-1 justify-center">
                <div class="text-center">
                    <div class="text-xl font-extrabold text-gray-800">${escapeHtml(f.dep)}</div>
                    <div class="text-xs text-gray-500 font-bold mt-0.5">${escapeHtml(f.from)}</div>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-[11px] font-bold text-gray-400">${escapeHtml(f.duration)}</span>
                    <div class="flex items-center gap-1 my-1"><div class="w-8 h-px bg-gray-200"></div><span class="material-symbols-outlined text-sm rotate-90 text-gray-400">flight</span><div class="w-8 h-px bg-gray-200"></div></div>
                    <span class="text-[10px] text-green-600 font-bold">Nonstop</span>
                </div>
                <div class="text-center">
                    <div class="text-xl font-extrabold text-gray-800">${escapeHtml(f.arr)}</div>
                    <div class="text-xs text-gray-500 font-bold mt-0.5">${escapeHtml(f.to)}</div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <div class="text-xl font-extrabold text-blue-600">Rp ${f.price.toLocaleString('id-ID')}</div>
                    <div class="text-[10px] font-medium text-gray-400">per person</div>
                </div>
                <button class="px-5 py-2 rounded-full text-xs font-bold ${isSelected ? 'bg-gray-100 text-gray-700' : 'bg-blue-600 text-white hover:bg-blue-700'}">
                    ${isSelected ? 'Selected ✓' : 'Select'}
                </button>
            </div>
        </div>
    `;
}

// Variabel bantuan global untuk mencatat metode sort pilihan user saat ini
let currentSortMethod = 'default';

// Fungsi pemicu saat user mengganti pilihan di dropdown Sort By
function applyFlightSorting(sortValue) {
    currentSortMethod = sortValue;
    
    // Urutkan array Outbound
    sortFlightArray(currentOutboundFlights);
    // Urutkan array Inbound (jika round trip)
    sortFlightArray(currentInboundFlights);
    
    // Render ulang datanya ke layar secara real-time
    renderOutboundSection();
    if (isRoundTrip() && selectedOutbound) {
        const container = document.getElementById('inboundResults');
        container.innerHTML = currentInboundFlights.map(f => renderFlightCard(f, 'inbound', selectedInbound && selectedInbound.id === f.id)).join('');
        attachSelectHandlers();
    }
}

// Fungsi internal untuk mengolah sorting array
function sortFlightArray(arr) {
    if (!arr || arr.length === 0) return;

    if (currentSortMethod === 'price_asc') {
        arr.sort((a, b) => a.price - b.price);
    } else if (currentSortMethod === 'price_desc') {
        arr.sort((a, b) => b.price - a.price);
    } else if (currentSortMethod === 'duration_asc') {
        // Mengubah string durasi seperti "2h 30m" menjadi total menit agar bisa dibandingkan
        const toMinutes = str => {
            const h = str.match(/(\d+)h/);
            const m = str.match(/(\d+)m/);
            return (h ? parseInt(h[1]) * 60 : 0) + (m ? parseInt(m[1]) : 0);
        };
        arr.sort((a, b) => toMinutes(a.duration) - toMinutes(b.duration));
    } else {
        // Default / Recommended: Kembalikan urutan berdasarkan ID asli dari database API
        arr.sort((a, b) => String(a.id).localeCompare(String(b.id)));
    }
}

function doSearch() {
    const origin = originSelect.value;
    const dest = destSelect.value;
    const targetDate = departureInput.value; // 1. Ambil nilai tanggal format YYYY-MM-DD dari input form

    if (!origin || !dest) { alert('Please select origin and destination.'); return; }
    if (origin === dest) { alert('Origin and destination cannot be the same.'); return; }
    if (!targetDate) { alert('Please select a departure date.'); return; } // Validasi jika tanggal kosong

    // Reset state
    selectedOutbound = null;
    selectedInbound = null;
    hasSearched = true;

    document.getElementById('sortBarSection').classList.remove('hidden');
    document.getElementById('flightSortSelector').value = 'default';
    currentSortMethod = 'default';

    // Remove proceed button jika ada sisa pencarian sebelumnya
    const pb = document.getElementById('proceedToCheckout');
    if (pb) pb.remove();

    // Filter berdasarkan maskapai yang dicentang
    const selectedAirlines = getSelectedAirlines();

    // 2. TAMBAHKAN FILTER TANGGAL DI SINI
    currentOutboundFlights = flightsData.filter(f => {
        // Cocokkan rute & maskapai
        const matchRoute = f.from === origin && f.to === dest && selectedAirlines.includes(f.airline);
        
        // Karena format departure_time dari API adalah "YYYY-MM-DD HH:MM:SS", kita ambil 10 karakter pertama saja (YYYY-MM-DD)
        const flightDate = f.departure_time ? f.departure_time.substring(0, 10) : '';
        
        return matchRoute && (flightDate === targetDate);
    });

    // 3. JIKA ROUND TRIP, TAMBAHKAN JUGA FILTER TANGGAL KEPULANGAN
    if (isRoundTrip()) {
        const targetReturnDate = returnInput.value;
        
        currentInboundFlights = buildReturnFlights(origin, dest).filter(f => {
        const matchRoute = selectedAirlines.includes(f.airline);
        
        // Lakukan hal yang sama untuk tanggal pulang
        const returnFlightDate = f.departure_time ? f.departure_time.substring(0, 10) : '';
        
        return matchRoute && (returnFlightDate === targetReturnDate);
        });
    } else {
        currentInboundFlights = [];
    }

    renderOutboundSection();
    updateStepIndicator();

    // Sembunyikan section return sampai flight berangkat dipilih
    document.getElementById('returnFlightSection').classList.add('hidden');
    document.getElementById('selectedOutboundSummary').classList.add('hidden');
}

function getSelectedAirlines() {
    return Array.from(document.querySelectorAll('.airline-filter:checked')).map(cb => cb.value);
}

function renderOutboundSection() {
    const container = document.getElementById('flightResults');
    if (currentOutboundFlights.length === 0) {
        container.innerHTML = `<div class="text-center py-12 text-gray-500 bg-white border border-gray-200 rounded-2xl">No flights found.</div>`;
        return;
    }
    const title = `<h3 class="text-md font-bold text-gray-800 mb-3 flex items-center gap-1"><span class="material-symbols-outlined text-blue-600">flight_takeoff</span> Outbound Flights</h3>`;
    container.innerHTML = title + currentOutboundFlights.map(f => renderFlightCard(f, 'outbound', selectedOutbound && selectedOutbound.id === f.id)).join('');
    attachSelectHandlers();
}

function attachSelectHandlers() {
    document.querySelectorAll('.flight-card').forEach(card => {
        card.addEventListener('click', function() {
            handleFlightSelect(this.dataset.id, this.dataset.type);
        });
    });
}

function handleFlightSelect(flightId, flightType) {
    if (flightType === 'outbound') {
        selectedOutbound = currentOutboundFlights.find(f => f.id == flightId);
        if (isRoundTrip()) {
            document.getElementById('outboundSummaryText').textContent = `${selectedOutbound.airline} · ${selectedOutbound.from} → ${selectedOutbound.to} · Rp ${selectedOutbound.price.toLocaleString('id-ID')}`;
            document.getElementById('selectedOutboundSummary').classList.remove('hidden');
            
            // Render Inbound Results
            const container = document.getElementById('inboundResults');
            document.getElementById('returnFlightSection').classList.remove('hidden');
            container.innerHTML = currentInboundFlights.map(f => renderFlightCard(f, 'inbound', selectedInbound && selectedInbound.id === f.id)).join('');
            attachSelectHandlers();
        } else {
            showFloatingCheckout();
        }
    } else {
        selectedInbound = currentInboundFlights.find(f => f.id == flightId);
        const container = document.getElementById('inboundResults');
        container.innerHTML = currentInboundFlights.map(f => renderFlightCard(f, 'inbound', f.id == flightId)).join('');
        attachSelectHandlers();
        showFloatingCheckout();
    }
}

function showFloatingCheckout() {
    let btn = document.getElementById('proceedToCheckout');
    if (!btn) {
        btn = document.createElement('div');
        btn.id = 'proceedToCheckout';
        btn.className = 'fixed bottom-8 right-8 z-50';
        document.body.appendChild(btn);
    }
    const total = selectedOutbound.price + (isRoundTrip() && selectedInbound ? selectedInbound.price : 0);
    btn.innerHTML = `
        <button onclick="goToCheckout()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-6 py-4 rounded-full shadow-2xl transform active:scale-95 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined">shopping_cart</span> Checkout · Rp ${total.toLocaleString('id-ID')}
        </button>
    `;
}

function goToCheckout() {
    // 1. Ambil jumlah pax dari state counter input di form
    const adultsCount = document.getElementById('adultCount').innerText;
    const childrenCount = document.getElementById('childCount').innerText;

    // 2. Susun parameter URL query string
    let url = `/checkout/flight?outbound=${selectedOutbound.id}&adults=${adultsCount}&children=${childrenCount}`;
    
    // 3. Jika user memilih tiket round-trip (pulang-pergi)
    if (isRoundTrip() && selectedInbound) {
        // Jika tiket inbound menggunakan ID virtual tiruan, kembalikan ke ID outbound sebagai fallback transaksi
        const inboundId = selectedInbound._virtual ? selectedOutbound.id : selectedInbound.id;
        url += `&inbound=${inboundId}`;
    }

    // 4. Redirect navigasi langsung ke halaman checkout flight murni Laravel
    window.location.href = url;
}

document.getElementById('flightSearchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    doSearch();
});

// Pemicu Pencarian Otomatis Berdasarkan Parameter Kiriman URL dari Homepage
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const urlOrigin = urlParams.get('origin');
    const urlDest = urlParams.get('destination');

    if (urlOrigin && urlDest) {
        // 1. Set nilai elemen select bandara asal & tujuan sesuai parameter
        if (document.getElementById('originSelect') && document.getElementById('destSelect')) {
            document.getElementById('originSelect').value = urlOrigin;
            document.getElementById('destSelect').value = urlDest;
            
            // 2. Jalankan fungsi pencarian otomatis secara instan
            typeof doSearch === "function" && doSearch();
        }
    }
});
</script>
</body>
</html>