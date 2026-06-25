<?php
$pageTitle = 'StayGo - Atmospheric Travel';
$currentPage = 'home';
require '_data.php';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?></head>
<body class="bg-background text-on-background font-body-md text-body-md antialiased">

<?php require '_nav.php'; ?>

<!-- Hero Section -->
<header class="relative pt-32 pb-48 px-margin-mobile md:px-margin-desktop overflow-hidden flex flex-col items-center justify-center min-h-[860px]">
  <div class="absolute inset-0 z-0">
    <img alt="Beautiful coastal scenery" class="w-full h-full object-cover opacity-90" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC4tekUTNBPk47cEGJ2z4pEau-p3EJUvR0HQyQSWeQz1v_Hvkm1WZgeGwOtOmoaaXNTaYZ873SzVPJa4E29SAAkTxht3bNiWlHHDUhJ971bVM-_AVXp4154XVbxzzTvU-ldS_nkDJqdTsyEiEGlMMC7MYQsmX6NizbC9PvIyI0BZO1rEooCYLYMMFWpVP1xFeVbm-99cxGtwhXIVoE7v7MObRIQjEvA9ot3a5ZRUTh5YWVT__YATxfpX6yxG70_lKjjnpvJCECL3mc">
    <div class="absolute inset-0 bg-gradient-to-b from-white/40 via-transparent to-background/90"></div>
  </div>
  <div class="relative z-10 w-full max-w-container-max mx-auto flex flex-col items-center text-center mt-12 md:mt-20">
    <h1 class="font-display text-display text-on-surface max-w-4xl drop-shadow-sm mb-6 text-4xl md:text-6xl">Your Journey, Beautifully Simplified</h1>
    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mb-12">Discover curated stays, effortless flights, and unforgettable experiences — all in one seamless platform.</p>
    <!-- Search Bar (functioning like accommodations) -->
    <form id="homeSearchForm" method="GET" action="accommodations.php" class="glass-card w-full max-w-5xl rounded-2xl p-2 flex flex-col md:flex-row items-center gap-2 relative z-20">
      <div class="flex-1 flex items-center h-16 px-6 rounded-xl hover:bg-white/50 transition-colors w-full relative">
        <span class="material-symbols-outlined text-outline mr-3">location_on</span>
        <div class="flex flex-col text-left flex-1">
          <label class="font-label-sm text-label-sm text-on-surface">Location</label>
          <input name="location" id="homeLocation" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-body-md text-on-surface-variant placeholder-outline-variant w-full outline-none" placeholder="Where to?" type="text">
        </div>
        <div class="hidden md:block absolute right-0 top-4 bottom-4 w-px bg-outline-variant/30"></div>
      </div>
      <div class="flex-1 flex items-center h-16 px-6 rounded-xl hover:bg-white/50 transition-colors w-full relative">
        <span class="material-symbols-outlined text-outline mr-3">calendar_month</span>
        <div class="flex flex-col text-left flex-1">
          <label class="font-label-sm text-label-sm text-on-surface">Check-in</label>
          <input type="date" name="checkin" id="homeCheckin" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-body-md text-on-surface-variant w-full outline-none">
        </div>
        <div class="hidden md:block absolute right-0 top-4 bottom-4 w-px bg-outline-variant/30"></div>
      </div>
      <div class="flex-1 flex items-center h-16 px-6 rounded-xl hover:bg-white/50 transition-colors w-full relative">
        <span class="material-symbols-outlined text-outline mr-3">calendar_month</span>
        <div class="flex flex-col text-left flex-1">
          <label class="font-label-sm text-label-sm text-on-surface">Check-out</label>
          <input type="date" name="checkout" id="homeCheckout" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-body-md text-on-surface-variant w-full outline-none">
        </div>
      </div>
      <div class="flex-1 flex items-center h-16 px-6 rounded-xl hover:bg-white/50 transition-colors w-full">
        <span class="material-symbols-outlined text-outline mr-3">group</span>
        <div class="flex flex-col text-left flex-1">
          <label class="font-label-sm text-label-sm text-on-surface">Guests</label>
          <input type="number" name="guests" id="homeGuests" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-body-md text-on-surface-variant w-full outline-none" min="1" value="2">
        </div>
      </div>
      <button type="submit" class="h-16 w-full md:w-16 flex items-center justify-center bg-gradient-to-r from-primary to-secondary-container rounded-xl text-on-primary hover:scale-105 transition-transform duration-300 shadow-lg shrink-0 mt-2 md:mt-0">
        <span class="material-symbols-outlined font-semibold">search</span>
      </button>
    </form>
  </div>
</header>

<!-- Main Content -->
<main class="relative z-20 bg-background -mt-16 rounded-t-3xl px-margin-mobile md:px-margin-desktop py-16 md:py-24 max-w-[1440px] mx-auto shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
  <!-- Filters / Categories -->
  <section class="max-w-container-max mx-auto mb-16">
    <div class="flex items-center gap-3 overflow-x-auto hide-scrollbar pb-4" id="category-filters">
      <button onclick="filterProperties('all')" data-filter="all"
        class="filter-btn flex items-center gap-2 px-6 py-3 rounded-xl bg-primary-container text-on-primary-container font-label-md text-label-md shrink-0 shadow-sm transition-all hover:scale-105">
        <span class="material-symbols-outlined text-[20px]">travel_explore</span>All
      </button>
      <button onclick="filterProperties('hotel')" data-filter="hotel"
        class="filter-btn flex items-center gap-2 px-6 py-3 rounded-xl bg-surface-container hover:bg-surface-variant text-on-surface font-label-md text-label-md shrink-0 transition-colors border border-outline-variant/20">
        <span class="material-symbols-outlined text-[20px]">hotel</span>Hotels
      </button>
      <button onclick="filterProperties('villa')" data-filter="villa"
        class="filter-btn flex items-center gap-2 px-6 py-3 rounded-xl bg-surface-container hover:bg-surface-variant text-on-surface font-label-md text-label-md shrink-0 transition-colors border border-outline-variant/20">
        <span class="material-symbols-outlined text-[20px]">villa</span>Villas
      </button>
      <button onclick="filterProperties('apartment')" data-filter="apartment"
        class="filter-btn flex items-center gap-2 px-6 py-3 rounded-xl bg-surface-container hover:bg-surface-variant text-on-surface font-label-md text-label-md shrink-0 transition-colors border border-outline-variant/20">
        <span class="material-symbols-outlined text-[20px]">apartment</span>Apartments
      </button>
      <button onclick="filterProperties('cabin')" data-filter="cabin"
        class="filter-btn flex items-center gap-2 px-6 py-3 rounded-xl bg-surface-container hover:bg-surface-variant text-on-surface font-label-md text-label-md shrink-0 transition-colors border border-outline-variant/20">
        <span class="material-symbols-outlined text-[20px]">cabin</span>Cabins
      </button>
      <!-- Price Sort -->
      <div class="ml-auto flex items-center gap-2 shrink-0">
        <select id="price-sort" onchange="sortProperties(this.value)" class="bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 font-label-md text-label-md text-on-surface focus:outline-none focus:border-primary cursor-pointer">
          <option value="">Sort by</option>
          <option value="price-asc">Price: Low to High</option>
          <option value="price-desc">Price: High to Low</option>
          <option value="rating">Top Rated</option>
        </select>
      </div>
    </div>
    <!-- Active filter label -->
    <p class="font-label-sm text-label-sm text-on-surface-variant mt-2" id="filter-label">Showing all properties</p>
  </section>

  <!-- Properties Grid -->
  <section class="max-w-container-max mx-auto mb-24">
    <div class="flex justify-between items-end mb-8">
      <div>
        <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Curated for You</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">Exceptional stays with atmospheric views.</p>
      </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-gutter" id="properties-grid">
      <?php foreach ($hotels as $h): ?>
      <a href="hotel_detail.php?id=<?= $h['id'] ?>" 
         class="property-card group cursor-pointer relative overflow-hidden rounded-3xl block hover:shadow-2xl transition-shadow duration-300"
         data-type="<?= $h['type'] ?>" data-price="<?= $h['price'] ?>" data-rating="<?= $h['rating'] ?>">
        <div class="relative h-64 overflow-hidden">
          <img alt="<?= htmlspecialchars($h['name']) ?>" 
               class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
               src="<?= $h['img'] ?>"
               onerror="this.src='https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600'">
          <!-- Favourite button -->
          <button onclick="event.preventDefault(); toggleFav(this)" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/70 backdrop-blur-sm flex items-center justify-center hover:bg-white transition-colors border border-white/30">
            <span class="material-symbols-outlined text-[18px] text-on-surface-variant fav-icon">favorite_border</span>
          </button>
          <?php if ($h['badge']): ?>
          <span class="absolute top-4 left-4 bg-secondary text-on-secondary px-3 py-1 rounded-full font-label-sm text-label-sm"><?= $h['badge'] ?></span>
          <?php endif; ?>
        </div>
        <div class="p-5 bg-surface-container-lowest">
          <div class="flex justify-between items-start mb-1">
            <h3 class="font-headline-md text-on-surface text-[18px] leading-tight"><?= htmlspecialchars($h['name']) ?></h3>
            <span class="flex items-center gap-0.5 text-on-surface font-label-sm text-label-sm shrink-0 ml-2">
              <span class="material-symbols-outlined text-[14px] text-secondary icon-fill">star</span><?= $h['rating'] ?>
            </span>
          </div>
          <p class="font-body-md text-on-surface-variant text-[14px] flex items-center gap-1 mb-3">
            <span class="material-symbols-outlined text-[14px]">location_on</span><?= htmlspecialchars($h['location']) ?>
          </p>
          <div class="flex items-center justify-between">
            <span class="font-label-sm text-label-sm text-on-surface-variant capitalize bg-surface-container px-3 py-1 rounded-full"><?= $h['type'] ?></span>
            <p class="font-headline-md text-on-surface text-[18px]">$<?= $h['price'] ?><span class="font-body-md text-on-surface-variant text-[13px]">/night</span></p>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <!-- No results message -->
    <div id="no-results" class="hidden text-center py-16">
      <span class="material-symbols-outlined text-[64px] text-outline-variant mb-4 block">search_off</span>
      <p class="font-headline-md text-on-surface-variant">No properties match this filter</p>
    </div>
  </section>

  <!-- Promo Banner -->
  <section class="max-w-container-max mx-auto mb-24">
    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-primary to-secondary-container p-8 md:p-16 flex flex-col md:flex-row items-center justify-between gap-8">
      <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
      <div class="relative z-10 max-w-2xl text-on-primary">
        <h2 class="font-headline-lg text-headline-lg mb-4">Escape to Paradise</h2>
        <p class="font-body-lg text-body-lg mb-8 opacity-90">Book your next tropical getaway and get up to 30% off on selected luxury villas. Limited time offer.</p>
        <a href="promo.php" class="inline-block bg-surface text-primary font-label-md text-label-md px-8 py-4 rounded-xl hover:scale-105 hover:shadow-lg transition-all duration-300">
          Claim Offer
        </a>
      </div>
      <div class="relative z-10 w-full md:w-1/3 aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl">
        <img alt="Tropical Beach" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBpwbd7SeVilSRS1DG8MX3ELmWqy71OwA8FW67LAiyj-PknjvcwSh19YNBYNgKWOBNOV2cUHwXNL3A8ca9BL3BaVW4UydQXisOHfgv7YCDXORCIkv1s19o5US7hiZHLcXQt1ydhD0EcW-Jf4aWhq8bosoXKUFTRZg62uc31Gbh_XXK9CHMc-lI23Znd5w9BSje57ePD6y6sQ_M7-_JciPoMxUyErCDiByGwgGFMEQJYtSIXKKWkwEtfHlPRnP4WlG5EywgtmsSVHnk">
      </div>
    </div>
  </section>

  <!-- Popular Flights -->
  <section class="max-w-container-max mx-auto mb-24">
    <div class="flex justify-between items-end mb-8">
      <div>
        <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Popular Flights</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">Top destinations for your next adventure.</p>
      </div>
      <a href="search_flights.php" class="font-label-md text-label-md text-primary hover:text-secondary-container transition-colors hidden md:flex items-center gap-1">
        View all flights <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
      </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
      <?php
      $featuredRoutes = [
        ['from'=>'JFK','to'=>'CDG','label'=>'New York to Paris','price'=>450],
        ['from'=>'LHR','to'=>'NRT','label'=>'London to Tokyo','price'=>720],
        ['from'=>'SYD','to'=>'DPS','label'=>'Sydney to Bali','price'=>290],
        ['from'=>'LAX','to'=>'HNL','label'=>'Los Angeles to Honolulu','price'=>199],
      ];
      foreach ($featuredRoutes as $r):
      ?>
      <a href="search_flights.php" class="bg-surface-container p-6 hover:bg-surface-container-high transition-all cursor-pointer group rounded-3xl hover:shadow-md hover:-translate-y-1 duration-300 block">
        <div class="flex items-center justify-between mb-4">
          <span class="font-headline-md text-headline-md text-on-surface"><?= $r['from'] ?></span>
          <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">flight_takeoff</span>
          <span class="font-headline-md text-headline-md text-on-surface"><?= $r['to'] ?></span>
        </div>
        <p class="font-body-md text-body-md text-on-surface-variant mb-6"><?= $r['label'] ?></p>
        <div class="flex items-center justify-between pt-4 border-t border-outline-variant/20">
          <span class="font-label-sm text-label-sm text-on-surface-variant">from</span>
          <span class="font-label-md text-label-md text-primary">$<?= $r['price'] ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="max-w-container-max mx-auto mb-16">
    <div class="text-center mb-12">
      <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Traveler Stories</h2>
      <p class="font-body-md text-body-md text-on-surface-variant">Hear from our community of explorers.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
      <?php
      $reviews = [
        ['initials'=>'SJ','name'=>'Sarah Jenkins','sub'=>'Traveled to Santorini','rating'=>5,'quote'=>"Booking our honeymoon through StayGo was an absolute dream. The interface is beautiful and so easy to use. Found the perfect secluded villa in seconds.",'color'=>'bg-primary-container text-on-primary-container'],
        ['initials'=>'MR','name'=>'Michael Ross','sub'=>'Frequent Flyer','rating'=>5,'quote'=>"I travel for business constantly. StayGo helps me manage flights and hotels in one place without feeling overwhelmed. Highly recommend.",'color'=>'bg-tertiary-container text-on-tertiary-container'],
        ['initials'=>'EL','name'=>'Emma Lin','sub'=>'Family Traveler','rating'=>4.5,'quote'=>"The flight price tracking feature saved us over \$300 on our family trip to Hawaii. The curated recommendations are always spot on!",'color'=>'bg-secondary-container text-on-secondary-container'],
        ['initials'=>'AT','name'=>'Andre Torres','sub'=>'Adventure Traveler','rating'=>5,'quote'=>"Found an incredible cabin in Iceland through StayGo. The photos were accurate and check-in was seamless. Best booking experience I've had.",'color'=>'bg-primary-fixed text-on-primary-fixed'],
        ['initials'=>'PN','name'=>'Priya Nair','sub'=>'Solo Explorer','rating'=>5,'quote'=>"As a solo female traveler, safety is my priority. StayGo's verified properties and detailed reviews gave me total peace of mind in every booking.",'color'=>'bg-tertiary-fixed text-on-tertiary-fixed'],
        ['initials'=>'WK','name'=>'Wataru Kato','sub'=>'Traveled to Bali','rating'=>4.5,'quote'=>"The Ubud cabin booking was seamless and the property exceeded expectations. StayGo has earned a permanent spot on my travel toolkit.",'color'=>'bg-surface-container-high text-on-surface'],
      ];
      foreach ($reviews as $r):
      ?>
      <div class="bg-white p-8 shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-outline-variant/10 rounded-3xl">
        <div class="flex text-secondary-fixed mb-4">
          <?php for($i=0;$i<floor($r['rating']);$i++): ?>
          <span class="material-symbols-outlined icon-fill">star</span>
          <?php endfor; if($r['rating']!=floor($r['rating'])): ?>
          <span class="material-symbols-outlined">star_half</span>
          <?php endif; ?>
        </div>
        <p class="font-body-md text-body-md text-on-surface-variant mb-6">"<?= htmlspecialchars($r['quote']) ?>"</p>
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 rounded-full <?= $r['color'] ?> flex items-center justify-center font-label-md text-label-md"><?= $r['initials'] ?></div>
          <div>
            <h4 class="font-label-md text-label-md text-on-surface"><?= $r['name'] ?></h4>
            <p class="font-label-sm text-label-sm text-on-surface-variant"><?= $r['sub'] ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>
</main>

<?php require '_footer.php'; ?>

<script>
// ── Filter & Sort Logic ──────────────────────────────────────────
let allCards = [];
let currentFilter = 'all';
let currentSort = '';

document.addEventListener('DOMContentLoaded', function () {
  allCards = Array.from(document.querySelectorAll('.property-card'));
  renderCards();
});

function filterProperties(type) {
  currentFilter = type;
  // Update button styles
  document.querySelectorAll('.filter-btn').forEach(btn => {
    const isActive = btn.dataset.filter === type;
    btn.classList.toggle('bg-primary-container', isActive);
    btn.classList.toggle('text-on-primary-container', isActive);
    btn.classList.toggle('shadow-sm', isActive);
    btn.classList.toggle('bg-surface-container', !isActive);
    btn.classList.toggle('text-on-surface', !isActive);
  });
  renderCards();
}

function sortProperties(value) {
  currentSort = value;
  renderCards();
}

function renderCards() {
  const grid = document.getElementById('properties-grid');
  const noResults = document.getElementById('no-results');
  const label = document.getElementById('filter-label');

  // Filter
  let visible = allCards.filter(card => {
    return currentFilter === 'all' || card.dataset.type === currentFilter;
  });

  // Sort
  if (currentSort === 'price-asc') {
    visible.sort((a,b) => +a.dataset.price - +b.dataset.price);
  } else if (currentSort === 'price-desc') {
    visible.sort((a,b) => +b.dataset.price - +a.dataset.price);
  } else if (currentSort === 'rating') {
    visible.sort((a,b) => +b.dataset.rating - +a.dataset.rating);
  }

  // Render
  allCards.forEach(c => { c.style.display = 'none'; });
  visible.forEach(c => { c.style.display = ''; grid.appendChild(c); });

  noResults.classList.toggle('hidden', visible.length > 0);
  const typeLabel = currentFilter === 'all' ? 'all properties' : currentFilter + 's';
  label.textContent = `Showing ${visible.length} ${typeLabel}`;
}

// ── Favourites toggle ────────────────────────────────────────────
function toggleFav(btn) {
  const icon = btn.querySelector('.fav-icon');
  const isFaved = icon.textContent.trim() === 'favorite';
  icon.textContent = isFaved ? 'favorite_border' : 'favorite';
  icon.classList.toggle('text-red-500', !isFaved);
  icon.classList.toggle('text-on-surface-variant', isFaved);
}
// Set default dates
const today = new Date();
const tomorrow = new Date(today);
tomorrow.setDate(today.getDate() + 1);
const nextWeek = new Date(today);
nextWeek.setDate(today.getDate() + 7);
document.getElementById('homeCheckin').value = today.toISOString().split('T')[0];
document.getElementById('homeCheckout').value = nextWeek.toISOString().split('T')[0];
document.getElementById('homeCheckin').min = today.toISOString().split('T')[0];
document.getElementById('homeCheckout').min = tomorrow.toISOString().split('T')[0];

// Ensure checkout >= checkin
const ci = document.getElementById('homeCheckin');
const co = document.getElementById('homeCheckout');
ci.addEventListener('change', function() {
  co.min = this.value;
  if (co.value && co.value <= this.value) co.value = '';
});
</script>

</body>
</html>