<?php
$pageTitle = 'StayGo - Search Flights';
$currentPage = 'flights';
require '_data.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?>
<style>
  .counter-btn { width: 32px; height: 32px; border-radius: 50%; background: #f0f3ff; border: none; cursor: pointer; font-size: 20px; display: inline-flex; align-items: center; justify-content: center; }
  .counter-btn:hover { background: #dce1ff; }
  .flight-card.selected { border: 2px solid #004ce2; background: rgba(220,225,255,0.4); }
  .step-indicator { display:flex; align-items:center; gap:8px; margin-bottom:24px; }
  .step-dot { width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; }
  .step-dot.active { background:#004ce2; color:#fff; }
  .step-dot.done { background:#00d2ff; color:#fff; }
  .step-dot.inactive { background:#e7eeff; color:#737687; }
  .step-line { flex:1; height:2px; background:#e7eeff; }
  .step-line.done { background:#00d2ff; }
</style>
</head>
<body class="bg-background text-on-background font-body-md antialiased min-h-screen flex flex-col">

<?php require '_nav.php'; ?>

<header class="relative pt-32 pb-16 px-margin-mobile md:px-margin-desktop bg-surface-container-low overflow-hidden">
  <div class="absolute inset-0 z-0 opacity-50 mix-blend-multiply" style="background: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCNZEX1ONltNelU02u7Tgb74cJh438KatQ3PGAIwM12s__gNFbuOEU3cTxcolhwp73gr1cijeJJnGeJWgYU6orb8bvvRcPkJK51phpjaB_aoI9awgHyf26Yi4KR2DD27tnFh5Mgb7FqYc8kADwNe2xKe2CH16a_M32KOLpugMuCv1bdXhcBi4FjrOpUvxMPpwGRSL-rYM2Vsz-vZbm6uVNyaCiPBDVVtV6jB3eX9uTPdo1VmqNwwcOP1WXf4ZO5cSXEVxVPFQYZRUI') center/cover no-repeat;"></div>
  <div class="absolute inset-0 z-0 bg-gradient-to-b from-surface/80 to-background"></div>
  <div class="max-w-container-max mx-auto relative z-10">
    <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-8 text-center md:text-left">Where to next?</h1>
    <div class="glass-panel rounded-2xl p-6 md:p-8">
      <!-- Search Form -->
      <form id="flightSearchForm">
        <!-- Trip type toggle -->
        <div class="flex flex-wrap gap-3 mb-6">
          <label class="trip-type-label flex items-center gap-2 cursor-pointer bg-primary-fixed text-on-primary-fixed px-4 py-2 rounded-full font-label-md">
            <input type="radio" name="trip_type" value="round" class="hidden" checked> <span class="material-symbols-outlined text-[18px]">check_circle</span> Round trip
          </label>
          <label class="trip-type-label flex items-center gap-2 cursor-pointer text-on-surface-variant hover:bg-surface-container-high px-4 py-2 rounded-full font-label-md">
            <input type="radio" name="trip_type" value="oneway" class="hidden"> <span class="material-symbols-outlined text-[18px]">circle</span> One way
          </label>
        </div>

        <!-- Search inputs -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
          <div class="md:col-span-3">
            <div class="glass-input rounded-xl h-16 flex items-center px-4">
              <span class="material-symbols-outlined text-outline mr-3">flight_takeoff</span>
              <div class="flex flex-col flex-grow">
                <span class="font-label-sm text-label-sm text-tertiary">From</span>
                <select id="originSelect" name="origin" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-on-surface font-semibold outline-none w-full"></select>
              </div>
            </div>
          </div>
          <div class="md:col-span-3">
            <div class="glass-input rounded-xl h-16 flex items-center px-4">
              <span class="material-symbols-outlined text-outline mr-3">flight_land</span>
              <div class="flex flex-col flex-grow">
                <span class="font-label-sm text-label-sm text-tertiary">To</span>
                <select id="destSelect" name="destination" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-on-surface font-semibold outline-none w-full"></select>
              </div>
            </div>
          </div>
          <div class="md:col-span-4">
            <div class="glass-input rounded-xl h-16 flex items-center overflow-hidden">
              <div class="flex-1 flex items-center px-4 border-r border-outline-variant/30">
                <span class="material-symbols-outlined text-outline mr-3">calendar_month</span>
                <div class="flex flex-col flex-grow">
                  <span class="font-label-sm text-label-sm text-tertiary">Departure</span>
                  <input type="date" id="departureDate" name="departDate" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-on-surface font-semibold outline-none w-full">
                </div>
              </div>
              <div class="flex-1 flex items-center px-4" id="returnContainer">
                <div class="flex flex-col flex-grow">
                  <span class="font-label-sm text-label-sm text-tertiary">Return</span>
                  <input type="date" id="returnDate" name="returnDate" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-on-surface font-semibold outline-none w-full">
                </div>
              </div>
            </div>
          </div>
          <div class="md:col-span-2 h-16">
            <button type="submit" id="searchFlightsBtn" class="gradient-button w-full h-full rounded-xl font-label-md text-[18px] flex items-center justify-center gap-2">
              <span class="material-symbols-outlined">search</span><span id="searchBtnText">Search</span>
            </button>
          </div>
        </div>

        <!-- Passenger counters (inline) -->
        <div class="flex gap-6 mt-6 pt-4 border-t border-outline-variant/20">
          <div class="flex items-center gap-3">
            <span class="font-label-md">Adults</span>
            <button type="button" class="counter-btn" id="adultMinus">-</button>
            <span id="adultCount" class="min-w-[30px] text-center font-semibold">1</span>
            <button type="button" class="counter-btn" id="adultPlus">+</button>
          </div>
          <div class="flex items-center gap-3">
            <span class="font-label-md">Children</span>
            <button type="button" class="counter-btn" id="childMinus">-</button>
            <span id="childCount" class="min-w-[30px] text-center font-semibold">0</span>
            <button type="button" class="counter-btn" id="childPlus">+</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</header>

<!-- Main Content with Sidebar -->
<main class="flex-grow max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12 w-full">
  <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
    <!-- Sidebar Filters -->
    <aside class="md:col-span-3">
      <div class="glass-panel p-6 sticky top-28 rounded-2xl">
        <div class="flex justify-between items-center mb-6">
          <h2 class="font-headline-md text-[20px]">Airlines</h2>
          <button id="resetFiltersBtn" class="text-primary text-sm hover:underline">Reset all</button>
        </div>
        <div id="airlineFilters" class="space-y-2 max-h-64 overflow-y-auto"></div>
      </div>
    </aside>

    <!-- Flight Results -->
    <div class="md:col-span-9">
      <!-- Round-trip step indicator (hidden by default) -->
      <div id="stepIndicator" class="hidden step-indicator mb-6">
        <div class="step-dot active" id="step1dot">1</div>
        <div class="step-line" id="stepLine"></div>
        <div class="step-dot inactive" id="step2dot">2</div>
        <span id="stepLabel" class="ml-2 font-label-md text-on-surface-variant">Select departure flight</span>
      </div>

      <div id="flightResults" class="flex flex-col gap-6">
        <div class="text-center py-16 text-on-surface-variant">
          <span class="material-symbols-outlined text-5xl block mb-4">flight_search</span>
          Use the search form above to find flights.
        </div>
      </div>

      <!-- Selected outbound summary (shown when picking return) -->
      <div id="selectedOutboundSummary" class="hidden glass-panel rounded-2xl p-4 mb-6 border-2 border-primary/30 flex items-center gap-4 mt-6">
        <span class="material-symbols-outlined text-primary text-3xl">flight_takeoff</span>
        <div>
          <div class="font-label-md text-primary">Departure selected</div>
          <div id="outboundSummaryText" class="font-body-md text-on-surface"></div>
        </div>
        <button id="changeOutboundBtn" class="ml-auto text-sm text-primary hover:underline font-label-md">Change</button>
      </div>

      <!-- Return flight results (shown after outbound selected in round trip) -->
      <div id="returnFlightSection" class="hidden">
        <h3 class="font-headline-md mb-4 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">flight_land</span> Select Return Flight
        </h3>
        <div id="inboundResults" class="flex flex-col gap-4"></div>
      </div>
    </div>
  </div>
</main>

<?php require '_footer.php'; ?>

<script>
function escapeHtml(str) {
  if (!str) return '';
  return String(str).replace(/[&<>]/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;'}[m]));
}

const cities = [
  { code: "CGK", name: "Jakarta" }, { code: "DPS", name: "Bali" }, { code: "SIN", name: "Singapore" },
  { code: "KUL", name: "Kuala Lumpur" }, { code: "BKK", name: "Bangkok" }, { code: "HND", name: "Tokyo" },
  { code: "NRT", name: "Tokyo Narita" }, { code: "ICN", name: "Seoul" }, { code: "LHR", name: "London" },
  { code: "DXB", name: "Dubai" }, { code: "SYD", name: "Sydney" }, { code: "LAX", name: "Los Angeles" }
];
const uniqueCities = [];
const seen = new Set();
for (const city of cities) {
  if (!seen.has(city.code)) { seen.add(city.code); uniqueCities.push(city); }
}
uniqueCities.sort((a,b) => a.name.localeCompare(b.name));

const originSelect = document.getElementById('originSelect');
const destSelect = document.getElementById('destSelect');
uniqueCities.forEach(c => {
  [originSelect, destSelect].forEach(sel => {
    const opt = document.createElement('option');
    opt.value = c.code;
    opt.textContent = `${c.name} (${c.code})`;
    sel.appendChild(opt);
  });
});
originSelect.value = 'CGK';
destSelect.value = 'HND';

// Trip type UI
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
      label.classList.add('bg-primary-fixed', 'text-on-primary-fixed');
      label.classList.remove('text-on-surface-variant', 'hover:bg-surface-container-high');
      iconSpan.textContent = 'check_circle';
    } else {
      label.classList.remove('bg-primary-fixed', 'text-on-primary-fixed');
      label.classList.add('text-on-surface-variant', 'hover:bg-surface-container-high');
      iconSpan.textContent = 'circle';
    }
  });
  if (isRoundTrip()) {
    returnContainer.style.display = 'block';
    document.getElementById('returnDate').setAttribute('required', 'required');
  } else {
    returnContainer.style.display = 'none';
    document.getElementById('returnDate').removeAttribute('required');
  }
}
tripRadios.forEach(radio => radio.addEventListener('change', updateTripUI));
updateTripUI();

// Dates
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

// Passenger counters
let adults = 1, children = 0;
function updateCounters() {
  document.getElementById('adultCount').innerText = adults;
  document.getElementById('childCount').innerText = children;
}
document.getElementById('adultPlus').addEventListener('click', () => { adults++; updateCounters(); });
document.getElementById('adultMinus').addEventListener('click', () => { if (adults > 1) adults--; updateCounters(); });
document.getElementById('childPlus').addEventListener('click', () => { children++; updateCounters(); });
document.getElementById('childMinus').addEventListener('click', () => { if (children > 0) children--; updateCounters(); });
updateCounters();

// Flight data
const flightsData = <?= json_encode($flights) ?>;

// Airline filters
const airlineSet = new Set();
flightsData.forEach(f => airlineSet.add(f.airline));
const airlineFiltersDiv = document.getElementById('airlineFilters');
airlineSet.forEach(airline => {
  const label = document.createElement('label');
  label.className = 'flex items-center gap-3 cursor-pointer py-1';
  label.innerHTML = `<input type="checkbox" class="airline-filter w-4 h-4" value="${escapeHtml(airline)}" checked> <span class="font-body-md">${escapeHtml(airline)}</span>`;
  airlineFiltersDiv.appendChild(label);
});

function getSelectedAirlines() {
  return Array.from(document.querySelectorAll('.airline-filter:checked')).map(cb => cb.value);
}

// State
let selectedOutbound = null;
let selectedInbound = null;
let currentOutboundFlights = [];
let currentInboundFlights = [];
let hasSearched = false;

// Step indicator
function updateStepIndicator() {
  const stepInd = document.getElementById('stepIndicator');
  if (!isRoundTrip() || !hasSearched) { stepInd.classList.add('hidden'); return; }
  stepInd.classList.remove('hidden');
  const step1 = document.getElementById('step1dot');
  const step2 = document.getElementById('step2dot');
  const line = document.getElementById('stepLine');
  const label = document.getElementById('stepLabel');
  if (!selectedOutbound) {
    step1.className = 'step-dot active'; step2.className = 'step-dot inactive';
    line.className = 'step-line'; label.textContent = 'Step 1: Select departure flight';
  } else {
    step1.className = 'step-dot done'; step2.className = 'step-dot active';
    line.className = 'step-line done'; label.textContent = 'Step 2: Select return flight';
  }
}

// Build synthetic return flights from outbound data (swap from/to)
function buildReturnFlights(origin, dest) {
  // First look for real reverse routes
  const real = flightsData.filter(f => f.from === dest && f.to === origin);
  if (real.length > 0) return real;
  // Synthesize from outbound flights (same route, swap origin/dest)
  const outbound = flightsData.filter(f => f.from === origin && f.to === dest);
  return outbound.map(f => ({
    ...f,
    id: f.id + 1000, // virtual id
    from: f.to,
    to: f.from,
    from_city: f.to_city,
    to_city: f.from_city,
    dep: f.arr,
    arr: f.dep,
    badge: f.badge,
    _virtual: true
  }));
}

function renderFlightCard(f, type, isSelected) {
  const badgeHtml = f.badge ? `<span class="bg-secondary text-on-secondary px-2 py-0.5 rounded-full text-xs ml-2">${escapeHtml(f.badge)}</span>` : '';
  const stopsHtml = f.stops === 0 ? '<span class="text-xs text-secondary font-semibold">Nonstop</span>' : `<span class="text-xs text-on-surface-variant">1 stop · ${escapeHtml(f.stop_code||'')}</span>`;
  const selectedClass = isSelected ? 'selected' : '';
  return `
    <div class="flight-card glass-panel p-5 rounded-2xl hover:shadow-lg transition cursor-pointer ${selectedClass}" data-id="${f.id}" data-type="${type}">
      <div class="flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center gap-3 min-w-[140px]">
          <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-xl">flight</span>
          </div>
          <div>
            <div class="font-semibold text-sm">${escapeHtml(f.airline)} ${badgeHtml}</div>
            <div class="text-xs text-on-surface-variant">${escapeHtml(f.code)} · ${escapeHtml(f.class)}</div>
          </div>
        </div>
        <div class="flex items-center gap-4 flex-1 justify-center">
          <div class="text-center">
            <div class="font-headline-md text-xl font-bold">${escapeHtml(f.dep)}</div>
            <div class="text-sm font-semibold">${escapeHtml(f.from)}</div>
          </div>
          <div class="flex flex-col items-center gap-1 px-2">
            <div class="text-xs text-on-surface-variant">${escapeHtml(f.duration)}</div>
            <div class="flex items-center gap-1"><div class="w-12 h-px bg-outline-variant"></div><span class="material-symbols-outlined text-sm rotate-90">flight</span><div class="w-12 h-px bg-outline-variant"></div></div>
            ${stopsHtml}
          </div>
          <div class="text-center">
            <div class="font-headline-md text-xl font-bold">${escapeHtml(f.arr)}</div>
            <div class="text-sm font-semibold">${escapeHtml(f.to)}</div>
          </div>
        </div>
        <div class="flex items-center gap-4">
          <div class="text-right">
            <div class="text-2xl font-bold text-primary">$${f.price}</div>
            <div class="text-xs text-on-surface-variant">per person</div>
          </div>
          <button class="select-flight-btn ${isSelected ? 'bg-secondary-container text-on-surface' : 'bg-primary text-on-primary'} px-5 py-2 rounded-full font-label-md whitespace-nowrap" data-id="${f.id}" data-type="${type}">
            ${isSelected ? 'Selected ✓' : 'Select'}
          </button>
        </div>
      </div>
    </div>
  `;
}

function doSearch() {
  const origin = originSelect.value;
  const dest = destSelect.value;
  if (!origin || !dest) { alert('Please select origin and destination.'); return; }
  if (origin === dest) { alert('Origin and destination cannot be the same.'); return; }

  // Reset state
  selectedOutbound = null;
  selectedInbound = null;
  hasSearched = true;

  // Remove proceed button
  const pb = document.getElementById('proceedToCheckout');
  if (pb) pb.remove();

  // Filter by airlines
  const selectedAirlines = getSelectedAirlines();
  currentOutboundFlights = flightsData.filter(f => f.from === origin && f.to === dest && selectedAirlines.includes(f.airline));

  if (isRoundTrip()) {
    currentInboundFlights = buildReturnFlights(origin, dest).filter(f => selectedAirlines.includes(f.airline));
  } else {
    currentInboundFlights = [];
  }

  renderOutboundSection();
  updateStepIndicator();

  // Hide return section until outbound selected
  document.getElementById('returnFlightSection').classList.add('hidden');
  document.getElementById('selectedOutboundSummary').classList.add('hidden');
}

function renderOutboundSection() {
  const container = document.getElementById('flightResults');
  if (currentOutboundFlights.length === 0) {
    container.innerHTML = `
      <div class="text-center py-16 text-on-surface-variant">
        <span class="material-symbols-outlined text-5xl block mb-4">search_off</span>
        No flights found for this route. Try a different origin or destination.
      </div>`;
    return;
  }
  const title = isRoundTrip()
    ? '<h3 class="font-headline-md mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-primary">flight_takeoff</span> Select Departure Flight</h3>'
    : `<h3 class="font-headline-md mb-4">${currentOutboundFlights.length} flight(s) found</h3>`;
  container.innerHTML = title + currentOutboundFlights.map(f => renderFlightCard(f, 'outbound', selectedOutbound && selectedOutbound.id === f.id)).join('');
  attachSelectHandlers();
}

function renderInboundSection() {
  const section = document.getElementById('returnFlightSection');
  const container = document.getElementById('inboundResults');
  if (currentInboundFlights.length === 0) {
    container.innerHTML = '<div class="text-center py-8 text-on-surface-variant">No return flights available for this route.</div>';
  } else {
    container.innerHTML = currentInboundFlights.map(f => renderFlightCard(f, 'inbound', selectedInbound && selectedInbound.id === f.id)).join('');
  }
  section.classList.remove('hidden');
  attachSelectHandlers();
}

function attachSelectHandlers() {
  document.querySelectorAll('.select-flight-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      handleFlightSelect(parseInt(this.dataset.id), this.dataset.type);
    });
  });
  document.querySelectorAll('.flight-card').forEach(card => {
    card.addEventListener('click', function() {
      handleFlightSelect(parseInt(this.dataset.id), this.dataset.type);
    });
  });
}

function handleFlightSelect(flightId, flightType) {
  if (flightType === 'outbound') {
    // Find in outbound list
    let flight = flightsData.find(f => f.id === flightId);
    if (!flight) flight = currentOutboundFlights.find(f => f.id === flightId);
    if (!flight) return;
    selectedOutbound = flight;

    if (isRoundTrip()) {
      // Show outbound summary
      const summary = document.getElementById('selectedOutboundSummary');
      document.getElementById('outboundSummaryText').textContent =
        `${flight.airline} ${flight.code} · ${flight.from_city} → ${flight.to_city} · ${flight.dep} – ${flight.arr} · $${flight.price}`;
      summary.classList.remove('hidden');
      // Re-render outbound to show selected state
      renderOutboundSection();
      // Show return section
      renderInboundSection();
      updateStepIndicator();
    } else {
      showProceedButton();
    }
  } else {
    // inbound
    let flight = currentInboundFlights.find(f => f.id === flightId);
    if (!flight) return;
    selectedInbound = flight;
    // Re-render inbound
    const container = document.getElementById('inboundResults');
    container.innerHTML = currentInboundFlights.map(f => renderFlightCard(f, 'inbound', f.id === flightId)).join('');
    attachSelectHandlers();
    updateStepIndicator();
    showProceedButton();
  }
}

function showProceedButton() {
  const roundTrip = isRoundTrip();
  if ((!roundTrip && selectedOutbound) || (roundTrip && selectedOutbound && selectedInbound)) {
    let proceedBtn = document.getElementById('proceedToCheckout');
    if (!proceedBtn) {
      proceedBtn = document.createElement('div');
      proceedBtn.id = 'proceedToCheckout';
      proceedBtn.className = 'fixed bottom-8 right-8 z-50';
      document.body.appendChild(proceedBtn);
    }
    const total = selectedOutbound.price + (roundTrip && selectedInbound ? selectedInbound.price : 0);
    const flightCount = roundTrip ? 2 : 1;
    proceedBtn.innerHTML = `
      <button onclick="goToCheckout()" class="gradient-button px-8 py-4 rounded-full font-bold shadow-xl text-lg flex items-center gap-3">
        <span class="material-symbols-outlined">shopping_cart</span>
        Checkout · $${total} · ${flightCount} flight${flightCount>1?'s':''}
      </button>`;
  }
}

function goToCheckout() {
  const roundTrip = isRoundTrip();
  const params = new URLSearchParams();
  params.set('type', 'flight');
  params.set('outbound', selectedOutbound.id);
  if (roundTrip && selectedInbound) {
    // If virtual inbound (synthesized), use outbound id as fallback for receipt
    params.set('inbound', selectedInbound._virtual ? selectedOutbound.id : selectedInbound.id);
  }
  params.set('adults', adults);
  params.set('children', children);
  params.set('departDate', departureInput.value);
  if (roundTrip) params.set('returnDate', returnInput.value);
  window.location.href = `checkout.php?${params.toString()}`;
}

// Change outbound button
document.getElementById('changeOutboundBtn').addEventListener('click', () => {
  selectedOutbound = null;
  selectedInbound = null;
  document.getElementById('selectedOutboundSummary').classList.add('hidden');
  document.getElementById('returnFlightSection').classList.add('hidden');
  const pb = document.getElementById('proceedToCheckout');
  if (pb) pb.remove();
  renderOutboundSection();
  updateStepIndicator();
});

// Search form submit
document.getElementById('flightSearchForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = document.getElementById('searchFlightsBtn');
  const btnText = document.getElementById('searchBtnText');
  btn.disabled = true;
  btnText.textContent = 'Searching...';
  setTimeout(() => {
    doSearch();
    btn.disabled = false;
    btnText.textContent = 'Search';
  }, 400);
});

// Airline filters
document.getElementById('resetFiltersBtn').addEventListener('click', () => {
  document.querySelectorAll('.airline-filter').forEach(cb => cb.checked = true);
  if (hasSearched) doSearch();
});
document.querySelectorAll('.airline-filter').forEach(el => el.addEventListener('change', () => { if (hasSearched) doSearch(); }));
</script>
</body>
</html>