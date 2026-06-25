<?php
$pageTitle = 'Search Results - StayGo';
$currentPage = 'hotel';
require '_data.php';

$location = $_GET['location'] ?? '';
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';
$guests = (int)($_GET['guests'] ?? 2);

// Filter hotels by location (case-insensitive partial match)
$filteredHotels = $hotels;
if (!empty($location)) {
    $filteredHotels = array_filter($hotels, fn($h) => stripos($h['location'], $location) !== false);
}
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?></head>
<body>
<?php require '_nav.php'; ?>
<main class="pt-32 pb-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
  <div class="mb-8">
    <h1 class="font-headline-lg"><?= count($filteredHotels) ?> stays found</h1>
    <p class="text-on-surface-variant"><?= htmlspecialchars($location ?: 'All destinations') ?> · <?= $guests ?> guests</p>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($filteredHotels as $hotel): ?>
      <a href="hotel_detail.php?id=<?= $hotel['id'] ?>&checkin=<?= urlencode($checkin) ?>&checkout=<?= urlencode($checkout) ?>&guests=<?= $guests ?>" class="group block">
        <div class="relative h-64 rounded-2xl overflow-hidden mb-3">
          <img src="<?= $hotel['img'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
          <button onclick="event.preventDefault(); toggleFavHotel(<?= $hotel['id'] ?>)" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/70 backdrop-blur flex items-center justify-center">
            <span class="material-symbols-outlined fav-icon-<?= $hotel['id'] ?>" style="font-variation-settings: 'FILL' 0;">favorite_border</span>
          </button>
          <?php if ($hotel['badge']): ?>
            <span class="absolute top-3 left-3 bg-secondary text-on-secondary px-2 py-1 rounded-full text-xs"><?= $hotel['badge'] ?></span>
          <?php endif; ?>
        </div>
        <h3 class="font-headline-md text-lg"><?= htmlspecialchars($hotel['name']) ?></h3>
        <p class="text-on-surface-variant"><?= htmlspecialchars($hotel['location']) ?></p>
        <p class="font-bold text-primary mt-1">$<?= $hotel['price'] ?> <span class="text-sm font-normal">/night</span></p>
      </a>
    <?php endforeach; ?>
  </div>
</main>
<?php require '_footer.php'; ?>
<script>
function toggleFavHotel(id) {
  let favs = JSON.parse(localStorage.getItem('staygo_favs') || '[]');
  const icon = document.querySelector(`.fav-icon-${id}`);
  const isFav = favs.includes(id.toString());
  if (isFav) {
    favs = favs.filter(f => f != id);
    icon.textContent = 'favorite_border';
    icon.style.fontVariationSettings = "'FILL' 0";
  } else {
    favs.push(id.toString());
    icon.textContent = 'favorite';
    icon.style.fontVariationSettings = "'FILL' 1";
    icon.classList.add('text-red-500');
  }
  localStorage.setItem('staygo_favs', JSON.stringify(favs));
}
// Initialize favourite icons
document.querySelectorAll('[class^="fav-icon-"]').forEach(el => {
  const id = el.className.match(/fav-icon-(\d+)/)[1];
  const favs = JSON.parse(localStorage.getItem('staygo_favs') || '[]');
  if (favs.includes(id)) {
    el.textContent = 'favorite';
    el.style.fontVariationSettings = "'FILL' 1";
    el.classList.add('text-red-500');
  }
});
</script>
</body>
</html>