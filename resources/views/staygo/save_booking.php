<?php
session_start();
require '_data.php';

$type = $_POST['type'] ?? '';
$grandTotal = $_POST['grandTotal'] ?? 0;

if ($type === 'flight') {
    $outboundId = $_POST['outboundId'] ?? 0;
    $inboundId = $_POST['inboundId'] ?? 0;
    $adults = $_POST['adults'] ?? 1;
    $children = $_POST['children'] ?? 0;
    $departDate = $_POST['departDate'] ?? date('Y-m-d');
    $returnDate = $_POST['returnDate'] ?? date('Y-m-d');
    
    foreach ($flights as $f) {
        if ($f['id'] == $outboundId) $outbound = $f;
        if ($f['id'] == $inboundId) $inbound = $f;
    }
    if (!isset($outbound)) $outbound = $flights[0];
    
    $bookingRef = 'SG-FL-' . strtoupper(substr(uniqid(), -6));
    $booking = [
        'id' => $bookingRef,
        'type' => 'flight',
        'name' => $outbound['airline'] . ' ' . $outbound['code'] . (isset($inbound) ? ' + return' : ''),
        'location' => $outbound['from_city'] . ' → ' . $outbound['to_city'],
        'dates' => date('d M Y', strtotime($departDate)) . (isset($inbound) ? ' - ' . date('d M Y', strtotime($returnDate)) : ''),
        'guests' => $adults + $children,
        'price' => $grandTotal,
        'status' => 'confirmed',
        'img' => null,
        'passengers' => json_decode($_POST['passengers'] ?? '[]', true)
    ];
} else {
    $hotelId = $_POST['id'] ?? 1;
    $checkin = $_POST['checkin'] ?? date('Y-m-d');
    $checkout = $_POST['checkout'] ?? date('Y-m-d', strtotime('+7 days'));
    $guests = $_POST['guests'] ?? 2;
    
    foreach ($hotels as $h) {
        if ($h['id'] == $hotelId) $hotel = $h;
    }
    if (!isset($hotel)) $hotel = $hotels[0];
    
    $bookingRef = 'SG-AC-' . strtoupper(substr(uniqid(), -6));
    $nights = (strtotime($checkout) - strtotime($checkin)) / 86400;
    $booking = [
        'id' => $bookingRef,
        'type' => 'hotel',
        'name' => $hotel['name'],
        'location' => $hotel['location'],
        'dates' => date('d M Y', strtotime($checkin)) . ' – ' . date('d M Y', strtotime($checkout)) . " ($nights nights)",
        'guests' => $guests,
        'price' => $grandTotal,
        'status' => 'confirmed',
        'img' => $hotel['img'],
        'checkin' => $checkin,
        'checkout' => $checkout
    ];
}

if (!isset($_SESSION['bookings'])) $_SESSION['bookings'] = [];
$_SESSION['bookings'][] = $booking;

echo json_encode(['success' => true, 'ref' => $bookingRef]);
?>