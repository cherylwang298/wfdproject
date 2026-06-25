<?php
$pageTitle = 'StayGo - Favourites';
$currentPage = '';
require '_data.php';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?></head>
<body class="bg-background text-on-background">
<?php require '_nav.php'; ?>

<main class="pt-32 pb-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
  <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-4">Your Favourites</h1>
  <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mb-12">Curated collections for your next atmospheric journey.</p>
  <div id="favourites-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <div class="col-span-full text-center py-16 text-on-surface-variant">Loading favourites...</div>
  </div>
</main>

<?php require '_footer.php'; ?>
<script>
function getFavourites() {
  return JSON.parse(localStorage.getItem('staygo_favs') || '[]');
}
function saveFavourites(favs) {
  localStorage.setItem('staygo_favs', JSON.stringify(favs));
}
function addFavourite(id) { let favs = getFavourites(); if(!favs.includes(id)){ favs.push(id); saveFavourites(favs); } }
function removeFavourite(id) { let favs = getFavourites(); saveFavourites(favs.filter(f => f != id)); }
function isFavourite(id) { return getFavourites().includes(id); }

const hotelsData = <?= json_encode($hotels) ?>;
function renderFavourites() {
  const favIds = getFavourites();
  const container = document.getElementById('favourites-grid');
  if (favIds.length === 0) {
    container.innerHTML = '<div class="col-span-full text-center py-16"><span class="material-symbols-outlined text-6xl text-outline">favorite_border</span><p class="mt-4 text-on-surface-variant">No favourites yet. Start hearting your favourite stays!</p><a href="homepage.php" class="mt-4 inline-block bg-primary text-on-primary px-6 py-3 rounded-full">Explore Properties</a></div>';
    return;
  }
  const favHotels = hotelsData.filter(h => favIds.includes(h.id.toString()));
  container.innerHTML = favHotels.map(h => `
    <div class="group relative rounded-xl overflow-hidden bg-surface shadow-sm border border-outline-variant/20 h-[400px]">
      <button onclick="toggleFavFromPage(${h.id})" class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-white/70 backdrop-blur-md flex items-center justify-center text-error hover:scale-110 transition">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">favorite</span>
      </button>
      <div class="relative h-full w-full">
        <img src="${h.img}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600'">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-6">
          <h3 class="font-headline-md text-white">${h.name}</h3>
          <p class="text-surface-dim mb-3 flex items-center gap-1"><span class="material-symbols-outlined text-base">location_on</span>${h.location}</p>
          <div class="flex justify-between items-center mt-auto pt-4 border-t border-white/20">
            <p class="text-white"><span class="font-bold text-lg">$${h.price}</span> / night</p>
            <a href="hotel_detail.php?id=${h.id}" class="bg-primary text-white px-4 py-2 rounded-full text-sm">View Details</a>
          </div>
        </div>
      </div>
    </div>
  `).join('');
}
function toggleFavFromPage(id) {
  if (isFavourite(id)) removeFavourite(id);
  else addFavourite(id);
  renderFavourites();
}
renderFavourites();
</script>
</body>
</html>