<?php
$pageTitle = 'The Azure Grand Hotel - StayGo';
$currentPage = 'hotel';
require '_data.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$hotel = null;
foreach ($hotels as $h) { if ($h['id'] === $id) { $hotel = $h; break; } }
if (!$hotel) $hotel = $hotels[0];
$pageTitle = htmlspecialchars($hotel['name']) . ' - StayGo';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?></head>
<body class="bg-background text-on-background font-body-md text-body-md antialiased">

<?php require '_nav.php'; ?>

<!-- Image Gallery Hero -->
<div class="pt-20">
  <div class="relative h-[60vh] min-h-[400px] max-h-[600px] overflow-hidden">
    <img alt="<?= htmlspecialchars($hotel['name']) ?>" class="w-full h-full object-cover" src="<?= $hotel['img'] ?>"
         onerror="this.src='https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1200'">
    <div class="absolute inset-0 bg-gradient-to-t from-on-surface/60 via-transparent to-transparent"></div>
    <!-- Back button -->
    <a href="accommodations.php" class="absolute top-6 left-6 glass-card w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform">
      <span class="material-symbols-outlined text-on-surface">arrow_back</span>
    </a>
    <!-- Favourite -->
    <button onclick="toggleFav(this, <?= $hotel['id'] ?>)" class="absolute top-6 right-6 glass-card w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform">
      <span class="material-symbols-outlined fav-icon text-on-surface">favorite_border</span>
    </button>
    <!-- Hotel name overlay -->
    <div class="absolute bottom-0 left-0 right-0 p-8">
      <div class="max-w-container-max mx-auto">
        <?php if ($hotel['badge']): ?>
        <span class="bg-secondary text-on-secondary px-3 py-1 rounded-full font-label-sm text-label-sm mb-3 inline-block"><?= $hotel['badge'] ?></span>
        <?php endif; ?>
        <h1 class="font-headline-lg text-headline-lg text-on-primary drop-shadow-lg mb-2"><?= htmlspecialchars($hotel['name']) ?></h1>
        <p class="font-body-lg text-body-lg text-surface-dim flex items-center gap-2">
          <span class="material-symbols-outlined text-[18px]">location_on</span><?= htmlspecialchars($hotel['location']) ?>
          <span class="flex items-center gap-1 ml-4"><span class="material-symbols-outlined text-[16px] text-secondary-fixed icon-fill">star</span><?= $hotel['rating'] ?> rating</span>
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Thumbnail Row -->
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop -mt-0 mb-8">
  <div class="flex gap-3 overflow-x-auto hide-scrollbar py-4">
    <?php
    $thumbImgs = [
      $hotel['img'],
      'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=300',
      'https://images.unsplash.com/photo-1540518614846-7eded433c457?w=300',
      'https://images.unsplash.com/photo-1568495248636-6432b97bd949?w=300',
      'https://images.unsplash.com/photo-1551918120-9739cb430c6d?w=300',
    ];
    foreach ($thumbImgs as $i => $img):
    ?>
    <div class="w-32 h-24 rounded-xl overflow-hidden shrink-0 <?= $i===0 ? 'ring-2 ring-primary' : '' ?> cursor-pointer hover:opacity-90 transition-opacity">
      <img src="<?= $img ?>" alt="" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=300'">
    </div>
    <?php endforeach; ?>
    <div class="w-32 h-24 rounded-xl overflow-hidden shrink-0 bg-surface-container flex items-center justify-center cursor-pointer hover:bg-surface-variant transition-colors">
      <span class="font-label-sm text-label-sm text-on-surface-variant text-center px-2">+12 more photos</span>
    </div>
  </div>
</div>

<!-- Main Content -->
<main class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop pb-24">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">

    <!-- Left: Details -->
    <div class="lg:col-span-2 flex flex-col gap-10">
      <!-- Overview -->
      <div>
        <div class="flex items-start justify-between mb-4">
          <div>
            <h2 class="font-headline-md text-headline-md text-on-surface mb-1">About this property</h2>
            <div class="flex items-center gap-4 flex-wrap">
              <span class="font-label-sm text-label-sm text-on-surface-variant capitalize bg-surface-container px-3 py-1 rounded-full"><?= $hotel['type'] ?></span>
              <span class="flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant"><span class="material-symbols-outlined text-[14px]">bed</span>3 bedrooms</span>
              <span class="flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant"><span class="material-symbols-outlined text-[14px]">bathtub</span>2 bathrooms</span>
              <span class="flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant"><span class="material-symbols-outlined text-[14px]">group</span>Up to 6 guests</span>
            </div>
          </div>
        </div>
        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
          Experience unparalleled luxury at <?= htmlspecialchars($hotel['name']) ?> in <?= htmlspecialchars($hotel['location']) ?>. This stunning property seamlessly blends contemporary design with the natural beauty of its surroundings. Floor-to-ceiling windows flood every room with natural light, while the infinity pool appears to merge with the horizon. Whether you're looking for a romantic retreat or a family escape, this property delivers an experience that transcends the ordinary.
        </p>
        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mt-4">
          The property sits on a prime elevated position, offering 360-degree panoramic views. Wake up to breathtaking sunrises, spend afternoons lounging by the pool, and witness unforgettable sunsets from the private terrace. The experienced concierge team is available 24/7 to curate bespoke experiences tailored to your preferences.
        </p>
      </div>

      <!-- Amenities -->
      <div>
        <h2 class="font-headline-md text-headline-md text-on-surface mb-6">Amenities</h2>
        <?php
        $amenities = [
          ['icon'=>'pool','label'=>'Infinity Pool'],
          ['icon'=>'wifi','label'=>'High-Speed WiFi'],
          ['icon'=>'ac_unit','label'=>'Air Conditioning'],
          ['icon'=>'local_parking','label'=>'Free Parking'],
          ['icon'=>'fitness_center','label'=>'Gym'],
          ['icon'=>'spa','label'=>'Spa Services'],
          ['icon'=>'restaurant','label'=>'Restaurant & Bar'],
          ['icon'=>'room_service','label'=>'24h Room Service'],
          ['icon'=>'beach_access','label'=>'Beach Access'],
          ['icon'=>'pets','label'=>'Pet Friendly'],
          ['icon'=>'local_laundry_service','label'=>'Laundry'],
          ['icon'=>'airport_shuttle','label'=>'Airport Transfer'],
        ];
        ?>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
          <?php foreach ($amenities as $a): ?>
          <div class="flex items-center gap-3 p-4 bg-surface-container rounded-xl">
            <span class="material-symbols-outlined text-primary text-[22px]"><?= $a['icon'] ?></span>
            <span class="font-body-md text-body-md text-on-surface"><?= $a['label'] ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Location / Map Placeholder -->
      <div>
        <h2 class="font-headline-md text-headline-md text-on-surface mb-4">Location</h2>
        <div class="w-full h-56 bg-surface-container rounded-2xl overflow-hidden flex items-center justify-center relative">
          <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-secondary-container/10"></div>
          <div class="relative z-10 flex flex-col items-center gap-3">
            <span class="material-symbols-outlined text-[48px] text-primary">location_on</span>
            <p class="font-label-md text-label-md text-on-surface"><?= htmlspecialchars($hotel['location']) ?></p>
            <a href="#" class="text-primary font-label-sm text-label-sm hover:underline">View on Maps</a>
          </div>
        </div>
      </div>

      <!-- Reviews -->
      <div>
        <div class="flex items-center justify-between mb-6">
          <h2 class="font-headline-md text-headline-md text-on-surface">Guest Reviews</h2>
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary-fixed icon-fill">star</span>
            <span class="font-headline-md text-headline-md text-on-surface"><?= $hotel['rating'] ?></span>
            <span class="font-body-md text-body-md text-on-surface-variant">/ 5.0 · 128 reviews</span>
          </div>
        </div>
        <?php
        $reviews = [
          ['initials'=>'SJ','name'=>'Sarah Jenkins','date'=>'Nov 2024','rating'=>5,'comment'=>'Absolutely magical. The infinity pool has the most stunning views. Staff were incredibly attentive to every detail. Would book again in a heartbeat.','color'=>'bg-primary-container text-on-primary-container'],
          ['initials'=>'MK','name'=>'Marco Klein','date'=>'Oct 2024','rating'=>5,'comment'=>'Exceeded every expectation. The architectural beauty of the property combined with impeccable service made this a truly once-in-a-lifetime stay.','color'=>'bg-tertiary-container text-on-tertiary-container'],
          ['initials'=>'AL','name'=>'Aiko Liang','date'=>'Sep 2024','rating'=>4.5,'comment'=>'Perfect romantic getaway. The sunsets from the terrace were jaw-dropping. Minor feedback: breakfast service was slightly slow on peak days.','color'=>'bg-secondary-container text-on-secondary-container'],
          ['initials'=>'RT','name'=>'Raj Thapar','date'=>'Aug 2024','rating'=>5,'comment'=>'The spa was incredible and the concierge arranged an exceptional private dining experience on the cliff edge. Worth every penny.','color'=>'bg-surface-container text-on-surface'],
        ];
        foreach ($reviews as $r):
        ?>
        <div class="mb-6 pb-6 border-b border-outline-variant/20 last:border-0">
          <div class="flex items-center gap-4 mb-3">
            <div class="w-10 h-10 rounded-full <?= $r['color'] ?> flex items-center justify-center font-label-md text-label-md text-sm"><?= $r['initials'] ?></div>
            <div class="flex-1">
              <div class="flex items-center justify-between">
                <h4 class="font-label-md text-label-md text-on-surface"><?= $r['name'] ?></h4>
                <span class="font-label-sm text-label-sm text-on-surface-variant"><?= $r['date'] ?></span>
              </div>
              <div class="flex gap-0.5">
                <?php for($i=0;$i<floor($r['rating']);$i++): ?><span class="material-symbols-outlined text-secondary-fixed text-[14px] icon-fill">star</span><?php endfor; ?>
                <?php if($r['rating']!=floor($r['rating'])): ?><span class="material-symbols-outlined text-secondary-fixed text-[14px]">star_half</span><?php endif; ?>
              </div>
            </div>
          </div>
          <p class="font-body-md text-body-md text-on-surface-variant"><?= htmlspecialchars($r['comment']) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Right: Booking Card -->
    <div class="lg:col-span-1">
      <div class="glass-panel p-6 rounded-2xl sticky top-28">
        <div class="flex items-baseline justify-between mb-6">
          <div>
            <span class="font-body-md text-body-md text-on-surface-variant">From</span>
            <div class="font-display text-headline-lg font-extrabold text-primary text-[36px]">$<?= $hotel['price'] ?></div>
            <span class="font-body-md text-body-md text-on-surface-variant">per night</span>
          </div>
          <div class="flex items-center gap-1">
            <span class="material-symbols-outlined text-secondary-fixed text-[18px] icon-fill">star</span>
            <span class="font-label-md text-label-md text-on-surface"><?= $hotel['rating'] ?></span>
          </div>
        </div>

        <!-- REPLACED DATE PICKERS WITH MIN DATE RESTRICTIONS -->
        <div class="grid grid-cols-2 gap-3 mb-4">
          <div class="glass-input rounded-xl p-3 flex flex-col">
            <span class="font-label-sm text-label-sm text-tertiary mb-1">Check-in</span>
            <input type="date" id="checkin" min="<?= date('Y-m-d') ?>" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-body-md text-on-surface outline-none w-full text-sm">
          </div>
          <div class="glass-input rounded-xl p-3 flex flex-col">
            <span class="font-label-sm text-label-sm text-tertiary mb-1">Check-out</span>
            <input type="date" id="checkout" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-body-md text-on-surface outline-none w-full text-sm">
          </div>
        </div>

        <!-- Guests -->
        <div class="glass-input rounded-xl p-3 flex items-center gap-3 mb-6">
            <span class="material-symbols-outlined text-outline text-[20px]">group</span>
            <div class="flex flex-grow items-center justify-between">
                <label class="font-label-sm text-label-sm text-tertiary">Guests</label>
                <div class="guest-counter flex items-center gap-4">
                    <button type="button" id="guestMinus" class="w-8 h-8 rounded-full bg-surface-container hover:shadow-[0_0_0_3px_rgba(0,76,226,0.3)] flex items-center justify-center text-lg font-bold">-</button>
                    <span id="guestCount" class="min-w-[24px] text-center font-body-md">1</span>
                    <button type="button" id="guestPlus" class="w-8 h-8 rounded-full bg-surface-container hover:shadow-[0_0_0_3px_rgba(0,76,226,0.3)] flex items-center justify-center text-lg font-bold">+</button>
                    <input type="hidden" name="guests" id="guestInput" value="1">
                </div>
            </div>
        </div>
        <!-- Price Breakdown -->
        <div class="flex flex-col gap-3 mb-6 p-4 bg-surface-container rounded-xl">
          <div class="flex justify-between font-body-md text-body-md text-on-surface-variant">
            <span>$<?= $hotel['price'] ?> × 7 nights</span>
            <span>$<?= $hotel['price']*7 ?></span>
          </div>
          <div class="flex justify-between font-body-md text-body-md text-on-surface-variant">
            <span>Cleaning fee</span><span>$80</span>
          </div>
          <div class="flex justify-between font-body-md text-body-md text-on-surface-variant">
            <span>Service fee</span><span>$<?= round($hotel['price']*7*0.12) ?></span>
          </div>
          <div class="flex justify-between font-label-md text-label-md text-on-surface border-t border-outline-variant/30 pt-3 mt-1">
            <span>Total</span>
            <span>$<?= $hotel['price']*7 + 80 + round($hotel['price']*7*0.12) ?></span>
          </div>
        </div>
        <a href="checkout.php?type=hotel&id=<?= $hotel['id'] ?>&price=<?= $hotel['price'] ?>"
           class="block w-full gradient-button font-label-md text-label-md py-4 rounded-xl text-center text-on-primary mb-3">
          Reserve Now
        </a>
        <button onclick="toggleFav(this.closest('button') || this, <?= $hotel['id'] ?>)" class="flex items-center justify-center w-full border-2 border-primary text-primary font-label-md text-label-md py-4 rounded-xl hover:bg-primary hover:text-on-primary transition-colors">
          <span class="material-symbols-outlined text-[18px] align-middle mr-1 fav-icon-bottom">favorite_border</span>Save to Favourites
        </button>
        <p class="text-center font-label-sm text-label-sm text-on-surface-variant mt-3">Free cancellation before Dec 1</p>
      </div>
    </div>

  </div>

  <!-- Similar Properties -->
  <section class="mt-20">
    <h2 class="font-headline-md text-headline-md text-on-surface mb-6">Similar Properties You May Like</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
      <?php
      $similar = array_filter($hotels, fn($h) => $h['id'] !== $hotel['id'] && $h['type'] === $hotel['type']);
      $similar = array_slice(array_values($similar), 0, 4);
      if (count($similar) < 4) {
        $extra = array_filter($hotels, fn($h) => $h['id'] !== $hotel['id']);
        $similar = array_slice(array_values($extra), 0, 4);
      }
      foreach ($similar as $s):
      ?>
      <a href="hotel_detail.php?id=<?= $s['id'] ?>" class="group block">
        <div class="relative h-48 overflow-hidden rounded-2xl mb-3">
          <img src="<?= $s['img'] ?>" alt="<?= htmlspecialchars($s['name']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" onerror="this.src='https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600'">
        </div>
        <h3 class="font-label-md text-label-md text-on-surface mb-1"><?= htmlspecialchars($s['name']) ?></h3>
        <p class="font-label-sm text-label-sm text-on-surface-variant mb-1"><?= htmlspecialchars($s['location']) ?></p>
        <p class="font-label-md text-label-md text-primary">$<?= $s['price'] ?><span class="text-on-surface-variant font-label-sm">/night</span></p>
      </a>
      <?php endforeach; ?>
    </div>
  </section>
</main>

<?php require '_footer.php'; ?>

<script>
function toggleFav(btn, hotelId) {
  let favs = JSON.parse(localStorage.getItem('staygo_favs') || '[]');
  const icon = btn.querySelector('.fav-icon');
  const isFaved = icon ? icon.textContent.trim() === 'favorite' : favs.includes(hotelId.toString());
  if (isFaved) {
    favs = favs.filter(f => f != hotelId.toString());
  } else {
    if (!favs.includes(hotelId.toString())) favs.push(hotelId.toString());
  }
  localStorage.setItem('staygo_favs', JSON.stringify(favs));
  // Update top hero button
  const heroIcon = document.querySelector('.fav-icon');
  if (heroIcon) {
    heroIcon.textContent = !isFaved ? 'favorite' : 'favorite_border';
    heroIcon.classList.toggle('text-red-500', !isFaved);
  }
  // Update bottom Save button
  const bottomIcon = document.querySelector('.fav-icon-bottom');
  if (bottomIcon) {
    bottomIcon.textContent = !isFaved ? 'favorite' : 'favorite_border';
    bottomIcon.style.fontVariationSettings = !isFaved ? "'FILL' 1" : "'FILL' 0";
  }
}

// Initialize favourite state on page load
document.addEventListener('DOMContentLoaded', function() {
  const favs = JSON.parse(localStorage.getItem('staygo_favs') || '[]');
  const hotelId = '<?= $hotel['id'] ?>';
  if (favs.includes(hotelId)) {
    const heroIcon = document.querySelector('.fav-icon');
    if (heroIcon) {
      heroIcon.textContent = 'favorite';
      heroIcon.classList.add('text-red-500');
    }
    const bottomIcon = document.querySelector('.fav-icon-bottom');
    if (bottomIcon) {
      bottomIcon.textContent = 'favorite';
      bottomIcon.style.fontVariationSettings = "'FILL' 1";
    }
  }
});

// Enforce that check-out date is not before check-in
const checkinInput = document.getElementById('checkin');
const checkoutInput = document.getElementById('checkout');
if (checkinInput && checkoutInput) {
  checkinInput.addEventListener('change', function() {
    const checkinDate = this.value;
    if (checkinDate) {
      checkoutInput.min = checkinDate;
      if (checkoutInput.value && checkoutInput.value <= checkinDate) {
        checkoutInput.value = '';
      }
    }
  });
}

const guestCountSpan = document.getElementById('guestCount');
const guestInput = document.getElementById('guestInput');
let guests = 1;
document.getElementById('guestMinus').addEventListener('click', () => {
if (guests > 1) { guests--; updateGuests(); }
});
document.getElementById('guestPlus').addEventListener('click', () => {
if (guests < 10) { guests++; updateGuests(); }
});
function updateGuests() {
guestCountSpan.innerText = guests;
guestInput.value = guests;
}
</script>

</body>
</html>