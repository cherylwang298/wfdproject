<?php
$pageTitle = 'StayGo - Find Your Perfect Stay';
$currentPage = 'hotel';
require '_data.php';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?>
<style>
  .guest-counter { display: flex; align-items: center; gap: 12px; }
  .guest-counter button { width: 32px; height: 32px; border-radius: 50%; background: #f0f3ff; border: none; cursor: pointer; font-size: 20px; }
  .guest-counter span { min-width: 30px; text-align: center; font-size: 18px; font-weight: 600; }
</style>
</head>
<body class="bg-background text-on-background">
<?php require '_nav.php'; ?>

<header class="pt-32 pb-20 px-margin-mobile md:px-margin-desktop bg-gradient-to-b from-surface-container-low to-background">
    <div class="max-w-container-max mx-auto relative z-10">
        <h1 class="font-headline-lg text-headline-lg text-center mb-10">Find your perfect stay</h1>
        <div class="glass-panel rounded-2xl p-6 md:p-8">
            <form id="accommodationSearchForm" method="GET" action="hotel_list.php">
                <div class="grid grid-cols-1 md:grid-cols-11 gap-4 items-end">
                <!-- Location -->
                    <div class="md:col-span-3">
                        <div class="glass-input rounded-xl h-16 flex items-center px-4">
                            <div class="flex flex-col flex-grow">
                                <label class="font-label-sm text-label-sm text-tertiary">Location</label>
                                <select name="location" id="locationSelect" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-on-surface font-semibold outline-none w-full1">
                                <option value="">Select Location</option>
                                <?php
                                $uniqueLocations = array_unique(array_column($hotels, 'location'));
                                sort($uniqueLocations);
                                foreach ($uniqueLocations as $loc):
                                ?>
                                    <option value="<?= htmlspecialchars($loc) ?>"><?= htmlspecialchars($loc) ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                <!-- Check-in -->
                    <div class="md:col-span-3">
                        <div class="glass-input rounded-xl h-16 flex items-center px-4">
                            <div class="flex flex-col flex-grow">
                                <label class="font-label-sm text-label-sm text-tertiary">Check-in</label>
                            <input type="date" name="checkin" id="checkin" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-on-surface font-semibold outline-none w-full" min="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>
                <!-- Check-out -->
                    <div class="md:col-span-3">
                        <div class="glass-input rounded-xl h-16 flex items-center px-4">
                            <div class="flex flex-col flex-grow">
                                <label class="font-label-sm text-label-sm text-tertiary">Check-out</label>
                            <input type="date" name="checkout" id="checkout" class="bg-transparent border-none p-0 focus:ring-0 font-body-md text-on-surface font-semibold outline-none w-full" min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                            </div>
                        </div>
                    </div>
                <!-- Guests with +/- -->
                    <div class="md:col-span-2">
                        <div class="glass-input rounded-xl h-16 flex items-center px-4">
                            <div class="flex flex-col flex-grow">
                                <label class="font-label-sm text-label-sm text-tertiary">Guests</label>
                                <div class="guest-counter flex items-center justify-center gap-4 mt-1">
                                    <button type="button" id="guestMinus" class="w-8 h-8 rounded-full bg-surface-container hover:shadow-[0_0_0_3px_rgba(0,76,226,0.3)] flex items-center justify-center text-lg font-bold">-</button>
                                    <span id="guestCount" class="min-w-[24px] text-center font-body-md">1</span>
                                    <button type="button" id="guestPlus" class="w-8 h-8 rounded-full bg-surface-container hover:shadow-[0_0_0_3px_rgba(0,76,226,0.3)] flex items-center justify-center text-lg font-bold">+</button>
                                    <input type="hidden" name="guests" id="guestInput" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 flex items-center justify-center">
                    <button type="submit" class="gradient-button px-8 py-3 rounded-xl font-label-md flex items-center gap-2">
                        <span class="material-symbols-outlined">search</span> Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>

<script>
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

  // Date validation: checkout cannot be before checkin
  const checkinInput = document.getElementById('checkin');
  const checkoutInput = document.getElementById('checkout');
  checkinInput.addEventListener('change', function() {
    if (this.value) checkoutInput.min = this.value;
    if (checkoutInput.value && checkoutInput.value <= this.value) checkoutInput.value = '';
  });
</script>

<?php require '_footer.php'; ?>
</body>
</html>