<?php
$pageTitle = 'Checkout - StayGo';
$currentPage = '';
require '_data.php';
session_start();

$type = $_GET['type'] ?? 'hotel';

if ($type === 'flight') {
    $outboundId = (int)($_GET['outbound'] ?? 0);
    $inboundId = (int)($_GET['inbound'] ?? 0);
    $adults = (int)($_GET['adults'] ?? 1);
    $children = (int)($_GET['children'] ?? 0);
    $departDate = $_GET['departDate'] ?? date('Y-m-d');
    $returnDate = $_GET['returnDate'] ?? date('Y-m-d', strtotime('+1 day'));
    
    $outboundFlight = null;
    $inboundFlight = null;
    foreach ($flights as $f) {
        if ($f['id'] == $outboundId) $outboundFlight = $f;
        if ($f['id'] == $inboundId) $inboundFlight = $f;
    }
    if (!$outboundFlight) $outboundFlight = $flights[0];
    
    $itemName = $outboundFlight['airline'] . ' ' . $outboundFlight['code'];
    $itemSub = $outboundFlight['from_city'] . ' → ' . $outboundFlight['to_city'];
    if ($inboundFlight) $itemSub .= ' / ' . $inboundFlight['from_city'] . ' → ' . $inboundFlight['to_city'];
    $itemDate = date('d M Y', strtotime($departDate));
    if ($inboundFlight) $itemDate .= ' - ' . date('d M Y', strtotime($returnDate));
    $backLink = 'search_flights.php';
    $receiptLink = 'flight_receipt.php';
    $price = $outboundFlight['price'] + ($inboundFlight ? $inboundFlight['price'] : 0);
    $totalPassengers = $adults + $children;
} else {
    // Accommodation
    $id = (int)($_GET['id'] ?? 1);
    $checkin = $_GET['checkin'] ?? date('Y-m-d');
    $checkout = $_GET['checkout'] ?? date('Y-m-d', strtotime('+7 days'));
    $guests = (int)($_GET['guests'] ?? 2);
    $nights = (strtotime($checkout) - strtotime($checkin)) / 86400;
    if ($nights <= 0) $nights = 7;
    
    $hotel = null;
    foreach ($hotels as $h) {
        if ($h['id'] == $id) { $hotel = $h; break; }
    }
    if (!$hotel) $hotel = $hotels[0];
    
    $itemName = $hotel['name'];
    $itemSub = $hotel['location'];
    $itemDate = date('d M Y', strtotime($checkin)) . ' – ' . date('d M Y', strtotime($checkout)) . " ($nights nights)";
    $backLink = 'search_accommodations.php';
    $receiptLink = 'accom_receipt.php';
    $price = $hotel['price'] * $nights;
    $totalPassengers = $guests;
}

$taxes = round($price * 0.12);
$grandTotal = $price + $taxes;
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?></head>
<body class="bg-background text-on-background font-body-md text-body-md antialiased">
<?php require '_nav.php'; ?>

<main class="pt-28 pb-24 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
  <h1 class="font-headline-lg text-headline-lg text-on-surface mb-10">Complete your booking</h1>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
    <!-- Form Column -->
    <div class="lg:col-span-2 flex flex-col gap-8">
      <!-- Contact Info -->
      <div class="glass-panel p-8 rounded-2xl">
        <h2 class="font-headline-md mb-6">Contact Information</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <input type="text" id="firstName" placeholder="First Name" class="glass-input rounded-xl h-14 px-4" value="Sarah">
          <input type="text" id="lastName" placeholder="Last Name" class="glass-input rounded-xl h-14 px-4" value="Jenkins">
          <input type="email" id="email" placeholder="Email" class="glass-input rounded-xl h-14 px-4" value="sarah@example.com">
          <input type="tel" id="phone" placeholder="Phone" class="glass-input rounded-xl h-14 px-4" value="+1 555 123 4567">
        </div>
      </div>

      <?php if ($type === 'flight'): ?>
        <!-- Passenger Details -->
        <div class="glass-panel p-8 rounded-2xl">
          <h2 class="font-headline-md mb-6">Passenger Details</h2>
          <div id="passengersContainer"></div>
        </div>
      <?php else: ?>
        <!-- Guest Requests -->
        <div class="glass-panel p-8 rounded-2xl">
          <h2 class="font-headline-md mb-6">Special Requests</h2>
          <textarea class="glass-input rounded-xl p-4 w-full h-28" placeholder="Any special requests?"></textarea>
        </div>
      <?php endif; ?>

      <!-- Payment Method -->
      <div class="glass-panel p-8 rounded-2xl">
        <h2 class="font-headline-md mb-6">Payment Method</h2>
        <div class="flex gap-3 mb-6">
          <button onclick="showPayment('card')" class="pay-tab flex items-center gap-2 px-5 py-3 rounded-xl border-2 border-primary bg-primary-fixed/20">Card</button>
          <button onclick="showPayment('bank')" class="pay-tab flex items-center gap-2 px-5 py-3 rounded-xl border-2 border-outline-variant/40">Bank Transfer</button>
        </div>
        <div id="payment-card">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <input type="text" placeholder="Card Number" class="glass-input rounded-xl h-14 px-4 sm:col-span-2">
            <input type="text" placeholder="MM/YY" class="glass-input rounded-xl h-14 px-4">
            <input type="text" placeholder="CVV" class="glass-input rounded-xl h-14 px-4">
          </div>
        </div>
        <div id="payment-bank" class="hidden p-6 bg-surface-container rounded-xl text-center">
          <p>You will receive bank details via email.</p>
        </div>
      </div>
    </div>

    <!-- Order Summary -->
    <div class="lg:col-span-1">
      <div class="glass-panel p-6 rounded-2xl sticky top-28">
        <h3 class="font-headline-md mb-6">Booking Summary</h3>
        <div class="flex gap-4 pb-5 mb-5 border-b">
          <div class="w-16 h-16 rounded-xl overflow-hidden bg-surface-container flex items-center justify-center">
            <?php if ($type === 'flight'): ?>
              <span class="material-symbols-outlined text-primary text-3xl">flight</span>
            <?php else: ?>
              <img src="<?= htmlspecialchars($hotel['img']) ?>" class="w-full h-full object-cover">
            <?php endif; ?>
          </div>
          <div>
            <h4 class="font-label-md mb-1"><?= htmlspecialchars($itemName) ?></h4>
            <p class="text-sm text-on-surface-variant"><?= htmlspecialchars($itemSub) ?></p>
            <p class="text-sm text-on-surface-variant"><?= htmlspecialchars($itemDate) ?></p>
          </div>
        </div>
        <div class="flex flex-col gap-3 mb-6">
          <div class="flex justify-between"><span>Subtotal</span><span>$<?= $price ?></span></div>
          <div class="flex justify-between"><span>Taxes & fees (12%)</span><span>$<?= $taxes ?></span></div>
          <div class="flex justify-between font-bold text-primary border-t pt-3"><span>Total</span><span>$<?= $grandTotal ?></span></div>
        </div>
        <button id="confirmBookingBtn" class="gradient-button w-full py-4 rounded-xl text-center font-label-md">Confirm Booking — $<?= $grandTotal ?></button>
      </div>
    </div>
  </div>
</main>

<?php require '_footer.php'; ?>

<script>
function showPayment(type) {
  document.getElementById('payment-card').classList.toggle('hidden', type !== 'card');
  document.getElementById('payment-bank').classList.toggle('hidden', type !== 'bank');
}

<?php if ($type === 'flight'): ?>
  const totalPassengers = <?= $totalPassengers ?>;
  const adults = <?= $adults ?>;
  const container = document.getElementById('passengersContainer');
  for (let i = 1; i <= totalPassengers; i++) {
    const isAdult = i <= adults;
    const div = document.createElement('div');
    div.className = 'border-b pb-4 mb-4';
    div.innerHTML = `
      <h3 class="font-label-md mb-3">Passenger ${i} ${isAdult ? '(Adult)' : '(Child)'}</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="text" name="fullname[]" placeholder="Full Name" class="glass-input rounded-xl h-12 px-4" required>
        <input type="date" name="dob[]" placeholder="Date of Birth" class="glass-input rounded-xl h-12 px-4" required>
        <input type="text" name="passport[]" placeholder="Passport Number" class="glass-input rounded-xl h-12 px-4" required>
        <select name="nationality[]" class="glass-input rounded-xl h-12 px-4">
          <option>Indonesian</option><option>American</option><option>British</option>
        </select>
      </div>
    `;
    container.appendChild(div);
  }
<?php endif; ?>

document.getElementById('confirmBookingBtn').addEventListener('click', function() {
  let passengerData = [];
  <?php if ($type === 'flight'): ?>
    const names = document.querySelectorAll('input[name="fullname[]"]');
    const dobs = document.querySelectorAll('input[name="dob[]"]');
    const passports = document.querySelectorAll('input[name="passport[]"]');
    const nationalities = document.querySelectorAll('select[name="nationality[]"]');
    for (let i = 0; i < names.length; i++) {
      passengerData.push({
        name: names[i].value,
        dob: dobs[i].value,
        passport: passports[i].value,
        nationality: nationalities[i].value
      });
    }
    sessionStorage.setItem('passengerData', JSON.stringify(passengerData));
  <?php endif; ?>
  
  const formData = new URLSearchParams();
  formData.append('type', '<?= $type ?>');
  formData.append('grandTotal', '<?= $grandTotal ?>');
  <?php if ($type === 'flight'): ?>
    formData.append('outboundId', '<?= $outboundId ?>');
    formData.append('inboundId', '<?= $inboundId ?>');
    formData.append('adults', '<?= $adults ?>');
    formData.append('children', '<?= $children ?>');
    formData.append('departDate', '<?= $departDate ?>');
    formData.append('returnDate', '<?= $returnDate ?>');
  <?php else: ?>
    formData.append('id', '<?= $id ?>');
    formData.append('checkin', '<?= $checkin ?>');
    formData.append('checkout', '<?= $checkout ?>');
    formData.append('guests', '<?= $guests ?>');
  <?php endif; ?>
  formData.append('passengers', JSON.stringify(passengerData));
  
  fetch('save_booking.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData
  }).then(r => r.json()).then(data => {
    const ref = data.ref || '';
    <?php if ($type === 'hotel'): ?>
    window.location.href = '<?= $receiptLink ?>?ref=' + ref
      + '&id=<?= $id ?>'
      + '&price=<?= $hotel['price'] ?>'
      + '&grandTotal=<?= $grandTotal ?>'
      + '&checkin=<?= urlencode($checkin) ?>'
      + '&checkout=<?= urlencode($checkout) ?>'
      + '&guests=<?= $guests ?>';
    <?php else: ?>
    window.location.href = '<?= $receiptLink ?>?ref=' + ref
      + '&outbound=<?= $outboundId ?>'
      + '&inbound=<?= $inboundId ?>'
      + '&adults=<?= $adults ?>'
      + '&children=<?= $children ?>'
      + '&departDate=<?= $departDate ?>'
      + '&returnDate=<?= $returnDate ?>'
      + '&grandTotal=<?= $grandTotal ?>';
    <?php endif; ?>
  }).catch(() => {
    <?php if ($type === 'hotel'): ?>
    window.location.href = '<?= $receiptLink ?>?id=<?= $id ?>&price=<?= $hotel['price'] ?>&grandTotal=<?= $grandTotal ?>&checkin=<?= urlencode($checkin) ?>&checkout=<?= urlencode($checkout) ?>&guests=<?= $guests ?>';
    <?php else: ?>
    window.location.href = '<?= $receiptLink ?>?outbound=<?= $outboundId ?>&adults=<?= $adults ?>&children=<?= $children ?>&departDate=<?= $departDate ?>&grandTotal=<?= $grandTotal ?>';
    <?php endif; ?>
  });
});
</script>

</body>
</html>