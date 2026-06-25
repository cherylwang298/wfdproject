<?php
$pageTitle = 'StayGo - My Bookings';
$currentPage = 'bookings';
require '_data.php';

// Do NOT merge session bookings – use only dummy data
$allBookings = $bookings;

$activeTab = $_GET['tab'] ?? 'hotel';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?></head>
<body class="bg-background text-on-background">
<?php require '_nav.php'; ?>

<main class="pt-32 pb-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
  <h1 class="font-display text-headline-lg-mobile md:text-display mb-2">My Bookings</h1>
  <div class="flex gap-2 mb-8 bg-surface-container-low/50 p-1 rounded-full inline-flex">
    <a href="?tab=hotel" class="px-6 py-2 rounded-full font-label-sm hover:bg-surface-container-high <?= $activeTab === 'hotel' ? 'bg-primary text-on-primary shadow' : '' ?>">Accommodation</a>
    <a href="?tab=flight" class="px-6 py-2 rounded-full font-label-sm hover:bg-surface-container-high <?= $activeTab === 'flight' ? 'bg-primary text-on-primary shadow' : '' ?>">Flights</a>
  </div>

  <div class="flex flex-col gap-6">
    <?php
    $filtered = array_filter($allBookings, fn($b) => $b['type'] === $activeTab);
    if (empty($filtered)) echo '<p class="text-center py-12">No bookings found.</p>';
    foreach ($filtered as $booking):
      $statusColor = $booking['status'] === 'confirmed' ? 'bg-secondary-fixed text-on-secondary-fixed' : 'bg-surface-dim';
    ?>
    <div class="glass-panel rounded-3xl p-4 flex flex-col md:flex-row gap-6">
      <div class="w-full md:w-56 h-48 md:h-auto rounded-2xl overflow-hidden shrink-0 bg-surface-variant flex items-center justify-center">
        <?php if (isset($booking['img']) && $booking['img']): ?>
          <img src="<?= htmlspecialchars($booking['img']) ?>" class="w-full h-full object-cover">
        <?php else: ?>
          <span class="material-symbols-outlined text-5xl text-outline">flight</span>
        <?php endif; ?>
      </div>
      <div class="flex-1">
        <div class="flex flex-wrap justify-between items-start gap-2">
          <h2 class="font-headline-md"><?= htmlspecialchars($booking['name']) ?></h2>
          <span class="px-3 py-1 rounded-full text-sm <?= $statusColor ?>"><?= ucfirst($booking['status']) ?></span>
        </div>
        <p class="text-on-surface-variant flex items-center gap-1 mt-1"><span class="material-symbols-outlined text-base">location_on</span><?= htmlspecialchars($booking['location']) ?></p>
        <div class="flex flex-wrap gap-2 my-3">
          <span class="bg-surface-container-low px-3 py-1 rounded-full text-sm"><span class="material-symbols-outlined text-base align-middle">calendar_month</span> <?= $booking['dates'] ?></span>
          <span class="bg-surface-container-low px-3 py-1 rounded-full text-sm"><span class="material-symbols-outlined text-base align-middle">group</span> <?= $booking['guests'] ?> guest(s)</span>
        </div>
        <div class="flex justify-between items-end border-t pt-4">
          <div><span class="text-sm text-outline">Total</span><div class="font-headline-lg text-primary">$<?= number_format($booking['price']) ?></div></div>
          <a href="<?= $booking['type'] === 'flight' ? 'flight_receipt.php?ref='.$booking['id'] : 'accom_receipt.php?ref='.$booking['id'] ?>" class="bg-surface-container px-6 py-2 rounded-full hover:bg-primary hover:text-on-primary transition">View Invoice</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</main>

<?php require '_footer.php'; ?>
</body>
</html>