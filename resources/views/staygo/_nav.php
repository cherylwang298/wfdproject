<?php
// _nav.php — shared top navigation
$currentPage = $currentPage ?? '';
$navLinks = [
  ['label'=>'Home',          'href'=>'homepage.php',        'icon'=>'home',          'page'=>'home'],
  ['label'=>'Accommodations','href'=>'accommodations.php','icon'=>'hotel','page'=>'hotel'],
  ['label'=>'Flights',       'href'=>'search_flights.php',  'icon'=>'flight',        'page'=>'flights'],
  ['label'=>'Deals',         'href'=>'promo.php',           'icon'=>'local_offer',   'page'=>'promo'],
  ['label'=>'My Bookings',   'href'=>'my_bookings.php',     'icon'=>'luggage',       'page'=>'bookings'],
];
?>
<nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-white/30 shadow-sm transition-all duration-300">
  <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop flex justify-between items-center h-20">
    <!-- Brand -->
    <a class="flex items-center gap-2 hover:opacity-80 transition-opacity" href="homepage.php">
      <span class="material-symbols-outlined text-primary-container text-[32px] icon-fill">flight_takeoff</span>
      <span class="font-display text-headline-md text-on-surface tracking-tight font-bold">Stay<span class="text-primary-container">Go</span></span>
    </a>
    <!-- Desktop Nav -->
    <div class="hidden md:flex items-center gap-8">
      <?php foreach ($navLinks as $link): ?>
        <a href="<?= $link['href'] ?>"
           class="font-body-md text-body-md transition-colors <?= $currentPage===$link['page'] ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-on-surface-variant hover:text-primary' ?>">
          <?= $link['label'] ?>
        </a>
      <?php endforeach; ?>
    </div>
    <!-- Actions -->
    <div class="flex items-center gap-3">
      <a href="favourites.php"
         class="flex items-center gap-1.5 font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors px-3 py-2 rounded-xl hover:bg-surface-container/50">
        <span class="material-symbols-outlined text-primary-container text-[22px]">favorite</span>
        <span class="hidden lg:inline">Favourites</span>
      </a>
      <div class="flex items-center gap-3 pl-3 border-l border-outline-variant/30">
        <div class="hidden sm:flex flex-col items-end">
          <span class="font-label-md text-label-md text-on-surface leading-tight">Cheryl Wang</span>
        </div>
        <a href="login.php" class="relative w-10 h-10 rounded-full border-2 border-primary/20 overflow-hidden hover:border-primary transition-all duration-300 flex items-center justify-center bg-primary-container text-on-primary font-bold text-sm">
          CW
        </a>
      </div>
      <!-- Mobile menu button -->
      <button id="mobile-menu-btn" class="md:hidden text-on-surface p-2">
        <span class="material-symbols-outlined text-2xl">menu</span>
      </button>
    </div>
  </div>
  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-xl border-t border-outline-variant/20 px-margin-mobile py-4 flex flex-col gap-3">
    <?php foreach ($navLinks as $link): ?>
      <a href="<?= $link['href'] ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl font-body-md text-body-md text-on-surface hover:bg-surface-container transition-colors">
        <span class="material-symbols-outlined text-[20px] text-primary"><?= $link['icon'] ?></span>
        <?= $link['label'] ?>
      </a>
    <?php endforeach; ?>
    <a href="favourites.php" class="flex items-center gap-3 px-4 py-3 rounded-xl font-body-md text-body-md text-on-surface hover:bg-surface-container transition-colors">
      <span class="material-symbols-outlined text-[20px] text-primary">favorite</span>Favourites
    </a>
    <a href="login.php" class="flex items-center gap-3 px-4 py-3 rounded-xl font-body-md text-body-md text-on-surface hover:bg-surface-container transition-colors">
      <span class="material-symbols-outlined text-[20px] text-primary">person</span>Sign In
    </a>
  </div>
</nav>
<script>
  document.getElementById('mobile-menu-btn').addEventListener('click', function(){
    document.getElementById('mobile-menu').classList.toggle('hidden');
  });
</script>