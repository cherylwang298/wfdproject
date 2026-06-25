<?php
$pageTitle = 'Flight Booking Confirmed - StayGo';
$currentPage = '';
require '_data.php';
session_start();

// Read all params from GET (passed by checkout.php redirect)
$outboundId  = (int)($_GET['outbound']    ?? 0);
$inboundId   = (int)($_GET['inbound']     ?? 0);
$adults      = (int)($_GET['adults']      ?? 1);
$children    = (int)($_GET['children']    ?? 0);
$departDate  = $_GET['departDate']         ?? date('Y-m-d');
$returnDate  = $_GET['returnDate']         ?? '';
$grandTotal  = (int)($_GET['grandTotal']  ?? 0);
$ref         = $_GET['ref']               ?? '';

// Resolve flights from data
$outboundFlight = null;
$inboundFlight  = null;
foreach ($flights as $f) {
    if ($f['id'] === $outboundId) $outboundFlight = $f;
    if ($inboundId && $f['id'] === $inboundId) $inboundFlight = $f;
}
if (!$outboundFlight) $outboundFlight = $flights[0]; // safe fallback

$totalPassengers = $adults + $children;
$isRoundTrip     = !empty($returnDate) && $inboundId > 0;

// Booking reference — use one from session if available, else from GET, else generate
$bookingRef = $ref;
if (!$bookingRef) {
    // Check session
    if (isset($_SESSION['bookings'])) {
        foreach (array_reverse($_SESSION['bookings']) as $b) {
            if ($b['type'] === 'flight') { $bookingRef = $b['id']; break; }
        }
    }
    if (!$bookingRef) $bookingRef = 'SG-FL-' . strtoupper(substr(uniqid(), -6));
}

// Recalculate grand total if not passed
if (!$grandTotal) {
    $grandTotal = $outboundFlight['price'] * $totalPassengers;
    if ($isRoundTrip && $inboundFlight) $grandTotal += $inboundFlight['price'] * $totalPassengers;
    $grandTotal = (int)round($grandTotal * 1.12);
}
$subtotal = (int)round($grandTotal / 1.12);
$taxes    = $grandTotal - $subtotal;
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?>
<style>
    .glass-card { background: rgba(255,255,255,0.7); backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.4); }
    .btn-gradient { background: linear-gradient(135deg, #004ce2 0%, #00d2ff 100%); }
    .dashed-sep { border-top: 2px dashed rgba(115,118,135,0.3); }
</style>
</head>
<body class="bg-background text-on-background min-h-screen">
<div class="fixed inset-0 pointer-events-none bg-[radial-gradient(circle_at_50%_0%,#dce1ff_0%,transparent_70%)] opacity-40"></div>

<main class="relative z-10 max-w-3xl mx-auto px-6 py-12 md:py-16">
    <!-- Logo -->
    <div class="flex justify-center items-center gap-2 mb-10">
        <span class="material-symbols-outlined text-4xl text-primary icon-fill">flight_takeoff</span>
        <span class="font-display text-3xl font-extrabold text-on-surface">Stay<span class="text-primary">Go</span></span>
    </div>

    <!-- Success Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-28 h-28 rounded-full bg-secondary-fixed mb-6 shadow-lg">
            <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-5xl text-on-primary icon-fill">check_circle</span>
            </div>
        </div>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-3">You're all set for your flight!</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant">Your e‑ticket is confirmed. Get ready for an amazing journey.</p>
    </div>

    <!-- Booking Reference -->
    <div class="mb-10 flex justify-center">
        <div class="glass-card px-6 py-3 rounded-xl flex items-center gap-4">
            <span class="font-label-md text-on-surface-variant">Booking Ref:</span>
            <span class="font-headline-md text-primary font-bold"><?= htmlspecialchars($bookingRef) ?></span>
            <button onclick="copyRef('<?= htmlspecialchars($bookingRef) ?>')" class="p-2 rounded-full hover:bg-primary-fixed/50 transition">
                <span class="material-symbols-outlined text-lg">content_copy</span>
            </button>
        </div>
    </div>

    <!-- Outbound Flight Card -->
    <div class="glass-card rounded-3xl overflow-hidden mb-6">
        <div class="bg-surface-container-low/80 px-6 py-4 border-b border-white/30 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">flight_takeoff</span>
            <span class="font-label-md uppercase text-on-surface-variant tracking-wider">Departure Flight</span>
            <span class="ml-auto text-sm text-on-surface-variant"><?= date('d M Y', strtotime($departDate)) ?></span>
        </div>
        <div class="p-6 md:p-8">
            <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-white shadow flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-2xl">flight</span>
                    </div>
                    <div>
                        <h3 class="font-headline-md"><?= htmlspecialchars($outboundFlight['airline']) ?></h3>
                        <p class="text-on-surface-variant text-sm"><?= htmlspecialchars($outboundFlight['class']) ?> · <?= htmlspecialchars($outboundFlight['code']) ?></p>
                    </div>
                </div>
                <div class="bg-secondary-fixed/50 px-4 py-1.5 rounded-full font-label-md text-sm">
                    <?= $totalPassengers ?> Passenger<?= $totalPassengers > 1 ? 's' : '' ?>
                </div>
            </div>

            <!-- Route -->
            <div class="flex justify-between items-center px-2 md:px-8 mb-6">
                <div class="text-center">
                    <div class="font-bold text-3xl"><?= htmlspecialchars($outboundFlight['from']) ?></div>
                    <div class="text-on-surface-variant text-sm"><?= htmlspecialchars($outboundFlight['from_city']) ?></div>
                    <div class="font-semibold mt-1"><?= htmlspecialchars($outboundFlight['dep']) ?></div>
                </div>
                <div class="flex-1 px-4 flex flex-col items-center gap-1">
                    <span class="text-xs text-on-surface-variant"><?= htmlspecialchars($outboundFlight['duration']) ?></span>
                    <div class="flex items-center w-full gap-1">
                        <div class="flex-1 h-px bg-outline-variant"></div>
                        <span class="material-symbols-outlined text-primary">flight</span>
                        <div class="flex-1 h-px bg-outline-variant"></div>
                    </div>
                    <span class="text-xs <?= $outboundFlight['stops'] == 0 ? 'text-secondary font-semibold' : 'text-on-surface-variant' ?>">
                        <?= $outboundFlight['stops'] == 0 ? 'Nonstop' : '1 stop · ' . htmlspecialchars($outboundFlight['stop_code'] ?? '') ?>
                    </span>
                </div>
                <div class="text-center">
                    <div class="font-bold text-3xl"><?= htmlspecialchars($outboundFlight['to']) ?></div>
                    <div class="text-on-surface-variant text-sm"><?= htmlspecialchars($outboundFlight['to_city']) ?></div>
                    <div class="font-semibold mt-1"><?= htmlspecialchars($outboundFlight['arr']) ?></div>
                </div>
            </div>

            <div class="border-t border-white/30 pt-4 flex flex-wrap gap-4 text-sm text-on-surface-variant">
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-primary text-base">airline_seat_recline_extra</span> Seat: Auto-assigned</span>
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-primary text-base">luggage</span> Baggage: 30kg + 7kg Cabin</span>
            </div>
        </div>
    </div>

    <?php if ($isRoundTrip && $inboundFlight): ?>
    <!-- Return Flight Card -->
    <div class="glass-card rounded-3xl overflow-hidden mb-6">
        <div class="bg-surface-container-low/80 px-6 py-4 border-b border-white/30 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">flight_land</span>
            <span class="font-label-md uppercase text-on-surface-variant tracking-wider">Return Flight</span>
            <span class="ml-auto text-sm text-on-surface-variant"><?= date('d M Y', strtotime($returnDate)) ?></span>
        </div>
        <div class="p-6 md:p-8">
            <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-white shadow flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-2xl">flight</span>
                    </div>
                    <div>
                        <h3 class="font-headline-md"><?= htmlspecialchars($inboundFlight['airline']) ?></h3>
                        <p class="text-on-surface-variant text-sm"><?= htmlspecialchars($inboundFlight['class']) ?> · <?= htmlspecialchars($inboundFlight['code']) ?></p>
                    </div>
                </div>
            </div>
            <div class="flex justify-between items-center px-2 md:px-8">
                <div class="text-center">
                    <div class="font-bold text-3xl"><?= htmlspecialchars($inboundFlight['to']) ?></div>
                    <div class="text-on-surface-variant text-sm"><?= htmlspecialchars($inboundFlight['to_city']) ?></div>
                    <div class="font-semibold mt-1"><?= htmlspecialchars($inboundFlight['dep']) ?></div>
                </div>
                <div class="flex-1 px-4 flex flex-col items-center gap-1">
                    <span class="text-xs text-on-surface-variant"><?= htmlspecialchars($inboundFlight['duration']) ?></span>
                    <div class="flex items-center w-full gap-1">
                        <div class="flex-1 h-px bg-outline-variant"></div>
                        <span class="material-symbols-outlined text-primary">flight</span>
                        <div class="flex-1 h-px bg-outline-variant"></div>
                    </div>
                    <span class="text-xs <?= $inboundFlight['stops'] == 0 ? 'text-secondary font-semibold' : 'text-on-surface-variant' ?>">
                        <?= $inboundFlight['stops'] == 0 ? 'Nonstop' : '1 stop · ' . htmlspecialchars($inboundFlight['stop_code'] ?? '') ?>
                    </span>
                </div>
                <div class="text-center">
                    <div class="font-bold text-3xl"><?= htmlspecialchars($inboundFlight['from']) ?></div>
                    <div class="text-on-surface-variant text-sm"><?= htmlspecialchars($inboundFlight['from_city']) ?></div>
                    <div class="font-semibold mt-1"><?= htmlspecialchars($inboundFlight['arr']) ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Payment Receipt -->
    <div class="glass-card rounded-3xl p-6 md:p-8 mb-10">
        <h3 class="font-headline-md text-center mb-6">Payment Receipt</h3>
        <div class="flex flex-col gap-4 mb-4">
            <div class="flex justify-between"><span class="text-on-surface-variant">Paid to</span><span class="font-medium flex items-center gap-1"><span class="material-symbols-outlined text-primary icon-fill text-base">flight_takeoff</span> StayGo Travel</span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Date & Time</span><span class="font-medium"><?= date('d M Y, H:i') ?> WIB</span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Payment Method</span><span class="font-medium">Credit Card (•••• 4242)</span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Transaction ID</span><span class="font-medium">SG-PAY-<?= strtoupper(substr($bookingRef, -6)) ?></span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Trip Type</span><span class="font-medium"><?= $isRoundTrip ? 'Round Trip' : 'One Way' ?></span></div>
            <div class="flex justify-between"><span class="text-on-surface-variant">Passengers</span><span class="font-medium"><?= $adults ?> Adult<?= $adults > 1 ? 's' : '' ?><?= $children > 0 ? ', ' . $children . ' Child' . ($children > 1 ? 'ren' : '') : '' ?></span></div>
        </div>
        <div class="dashed-sep my-5"></div>
        <div class="flex flex-col gap-3">
            <div class="flex justify-between text-on-surface-variant"><span>Subtotal</span><span>$<?= number_format($subtotal) ?></span></div>
            <div class="flex justify-between text-on-surface-variant"><span>Taxes & fees (12%)</span><span>$<?= number_format($taxes) ?></span></div>
        </div>
        <div class="dashed-sep my-5"></div>
        <div class="flex justify-between items-center">
            <span class="text-on-surface-variant font-semibold">Total Amount</span>
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
    navigator.clipboard.writeText(ref).then(() => {
        const btn = event.currentTarget;
        const icon = btn.querySelector('span');
        icon.textContent = 'check';
        setTimeout(() => { icon.textContent = 'content_copy'; }, 2000);
    });
}
</script>
</body>
</html>