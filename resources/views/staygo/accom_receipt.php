<?php
require '_data.php';
session_start();

$ref = $_GET['ref'] ?? '';
$booking = null;

// Try to find booking in session
if (isset($_SESSION['bookings'])) {
    foreach ($_SESSION['bookings'] as $b) {
        if ($b['id'] === $ref) {
            $booking = $b;
            break;
        }
    }
}

// If not found, create a dummy booking from hotel data if 'id' is provided as fallback
$id = (int)($_GET['id'] ?? 0);
if (!$booking && $id > 0) {
    foreach ($hotels as $h) {
        if ($h['id'] === $id) {
            $booking = [
                'id' => 'SG-ACC-' . strtoupper(substr(uniqid(), -6)),
                'type' => 'hotel',
                'name' => $h['name'],
                'location' => $h['location'],
                'dates' => 'Dec 24 – Dec 31, 2025 (7 nights)',
                'guests' => 2,
                'price' => (int)($_GET['price'] ?? $h['price']) * 7,
                'status' => 'confirmed',
                'img' => $h['img'],
                'type_label' => $h['type']
            ];
            break;
        }
    }
}

// Final fallback
if (!$booking) {
    $booking = [
        'id' => 'SG-ACC-' . strtoupper(substr(uniqid(), -6)),
        'name' => 'Booking Not Found',
        'location' => 'Unknown',
        'dates' => 'N/A',
        'guests' => 1,
        'price' => 0,
        'status' => 'confirmed',
        'img' => null,
        'type_label' => 'property'
    ];
}

$bookingRef = $booking['id'];
$totalPrice = $booking['price'];
$taxes = round($totalPrice * 0.12);
$grandTotal = $totalPrice + $taxes;
// Extract nights from dates string (simple assumption)
$nights = 7;
if (preg_match('/(\d+) nights?/', $booking['dates'], $matches)) {
    $nights = (int)$matches[1];
}
$checkin = 'Dec 24, 2025';
$checkout = 'Dec 31, 2025';
if (preg_match('/([A-Za-z]+ \d+),? – ([A-Za-z]+ \d+)/', $booking['dates'], $matches)) {
    $checkin = $matches[1];
    $checkout = $matches[2];
}
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?>
<style>
    .glass-panel { background: rgba(255,255,255,0.7); backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.4); }
    .btn-gradient { background: linear-gradient(135deg, #004ce2 0%, #00d2ff 100%); }
    .receipt-dashed-line { border-top: 2px dashed rgba(115,118,135,0.3); }
</style>
</head>
<body class="bg-background text-on-background min-h-screen relative">
<div class="fixed inset-0 pointer-events-none">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,#dce1ff_0%,transparent_70%)] opacity-40"></div>
</div>

<main class="relative z-10 max-w-3xl mx-auto px-6 py-12 md:py-16">
    <!-- Logo -->
    <div class="flex justify-center items-center gap-2 mb-10">
        <span class="material-symbols-outlined text-4xl text-primary icon-fill">flight_takeoff</span>
        <span class="font-display text-3xl font-extrabold text-on-surface">Stay<span class="text-primary">Go</span></span>
    </div>

    <!-- Success Header -->
    <div class="text-center mb-10 animate-fade-in-up">
        <div class="inline-flex items-center justify-center w-28 h-28 rounded-full bg-secondary-fixed mb-6 shadow-lg">
            <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-5xl text-on-primary icon-fill">check</span>
            </div>
        </div>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-3">You're all set for your stay!</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant">Your booking has been confirmed. We're getting everything ready.</p>
    </div>

    <!-- Booking Reference -->
    <div class="mb-10 flex justify-center">
        <div class="glass-panel px-6 py-3 rounded-xl flex items-center gap-4">
            <span class="font-label-md text-on-surface-variant">Booking Ref:</span>
            <span class="font-headline-md text-primary font-bold"><?= htmlspecialchars($bookingRef) ?></span>
            <button onclick="copyRef('<?= htmlspecialchars($bookingRef) ?>')" class="p-2 rounded-full hover:bg-primary-fixed/50 transition">
                <span class="material-symbols-outlined text-lg">content_copy</span>
            </button>
        </div>
    </div>

    <!-- Booking Summary Card -->
    <div class="glass-panel rounded-3xl overflow-hidden mb-10">
        <div class="h-56 overflow-hidden relative">
            <?php if ($booking['img']): ?>
                <img src="<?= htmlspecialchars($booking['img']) ?>" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600'">
            <?php else: ?>
                <div class="w-full h-full bg-surface-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-6xl text-outline">hotel</span>
                </div>
            <?php endif; ?>
            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full text-sm font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">home_work</span> <?= ucfirst($booking['type_label'] ?? 'property') ?>
            </div>
        </div>
        <div class="p-6 md:p-8">
            <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
                <div>
                    <h2 class="font-headline-md text-headline-md mb-1"><?= htmlspecialchars($booking['name']) ?></h2>
                    <p class="text-on-surface-variant flex items-center gap-1"><span class="material-symbols-outlined text-base">location_on</span> <?= htmlspecialchars($booking['location']) ?></p>
                </div>
                <div class="flex gap-3">
                    <div class="bg-surface-container px-3 py-1.5 rounded-full flex items-center gap-1"><span class="material-symbols-outlined text-lg">group</span> <?= $booking['guests'] ?> Guest<?= $booking['guests'] > 1 ? 's' : '' ?></div>
                    <div class="bg-surface-container px-3 py-1.5 rounded-full flex items-center gap-1"><span class="material-symbols-outlined text-lg">night_shelter</span> <?= $nights ?> Nights</div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-surface-container-low/50 p-4 rounded-2xl">
                    <span class="block text-sm text-on-surface-variant uppercase">Check-in</span>
                    <span class="block font-headline-md text-xl"><?= htmlspecialchars($checkin) ?></span>
                    <span class="text-sm">After 3:00 PM</span>
                </div>
                <div class="bg-surface-container-low/50 p-4 rounded-2xl">
                    <span class="block text-sm text-on-surface-variant uppercase">Check-out</span>
                    <span class="block font-headline-md text-xl"><?= htmlspecialchars($checkout) ?></span>
                    <span class="text-sm">Before 11:00 AM</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Receipt -->
    <div class="glass-panel rounded-3xl p-6 md:p-8 mb-10">
        <h3 class="font-headline-md text-center mb-6">Payment Receipt</h3>
        <div class="flex flex-col gap-4 mb-6">
            <div class="flex justify-between"><span class="text-on-surface-variant">Paid to</span><span class="font-medium flex items-center gap-1"><span class="material-symbols-outlined text-primary icon-fill">flight_takeoff</span> StayGo Travel</span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Date & Time</span><span class="font-medium"><?= date('d M Y, H:i') ?> WIB</span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Payment Method</span><span class="font-medium">Credit Card (•••• 4242)</span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Transaction ID</span><span class="font-medium">SG-PAY-<?= substr($bookingRef, -6) ?></span></div>
        </div>
        <div class="receipt-dashed-line my-6"></div>
        <div class="flex justify-between items-center mb-6">
            <span class="text-on-surface-variant">Total Amount</span>
            <span class="font-headline-lg-mobile text-primary font-extrabold">$<?= number_format($grandTotal) ?></span>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="my_bookings.php" class="btn-gradient text-on-primary font-label-md text-center py-4 px-8 rounded-3xl shadow-lg">Go to My Bookings</a>
        <a href="homepage.php" class="bg-surface-container-highest text-on-surface font-label-md text-center py-4 px-8 rounded-3xl hover:bg-surface-dim transition">Back to Home</a>
    </div>
</main>

<script>
function copyRef(ref) {
    navigator.clipboard.writeText(ref);
    alert('Booking reference copied: ' + ref);
}
</script>
<style>
@keyframes fadeInUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
.animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
</style>
</body>
</html>