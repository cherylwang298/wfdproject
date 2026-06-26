@extends('layouts.user') 

@php
$currentPage = 'bookings';
@endphp

@include('partials.navbar')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl pt-28">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">My Bookings</h1>

    {{-- ALERT COMPONENT --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if(!auth()->check())
        <div class="bg-white rounded-lg shadow p-6 text-center max-w-md mx-auto">
            <div class="text-gray-400 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <p class="text-gray-500 mb-6">Silakan login terlebih dahulu untuk melihat riwayat reservasi Anda.</p>
            <a href="/login" class="inline-block bg-blue-600 text-white font-medium px-6 py-2 rounded hover:bg-blue-700 transition w-full">
                Login Sekarang
            </a>
        </div>
    @else
        <div class="flex gap-4 border-b border-gray-200 mb-6">
            <button onclick="switchBookingTab('tab-accommodation')" id="btn-tab-accommodation" class="pb-3 text-sm font-bold border-b-2 border-blue-600 text-blue-600 transition-all">
                🏨 Accommodations
            </button>
            <button onclick="switchBookingTab('tab-flights')" id="btn-tab-flights" class="pb-3 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all">
                ✈️ Flights
            </button>
        </div>

        {{-- ============================================================= --}}
        {{-- KELOMPOK TAB 1: RIWAYAT RESERVASI AKOMODASI ASLI 100%          --}}
        {{-- ============================================================= --}}
        <div id="section-accommodation" class="block">
            @if($bookings->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500 mb-4">Kamu belum memiliki riwayat reservasi.</p>
                    <a href="/" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Cari Unit Sekarang
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-sm font-semibold text-gray-500">ID: {{ substr($booking->id, 0, 8) }}...</span>
                                    
                                    @if($booking->cancel_request)
                                        @if($booking->cancel_request->status === 'Pending')
                                            <span class="px-2 py-1 text-xs font-bold rounded bg-purple-100 text-purple-800">Cancel Request Sent</span>
                                        @elseif($booking->cancel_request->status === 'approved')
                                            <span class="px-2 py-1 text-xs font-bold rounded bg-red-100 text-red-800">Cancelled</span>
                                        @elseif($booking->cancel_request->status === 'Rejected')
                                            <span class="px-2 py-1 text-xs font-bold rounded bg-green-100 text-green-800">Confirmed (Cancel Rejected)</span>
                                        @endif
                                    @else
                                        @if($booking->payment && $booking->payment->status === 'Paid')
                                            <span class="px-2 py-1 text-xs font-bold rounded bg-green-100 text-green-800">Confirmed</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-bold rounded bg-yellow-100 text-yellow-800">Pending Payment</span>
                                        @endif
                                    @endif
                                </div>

                                <h2 class="text-xl font-bold text-gray-800 mb-2">
                                    {{ $booking->unit_details['name'] ?? 'Unit #' . $booking->unit_id }}
                                </h2>

                                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                    <div>
                                        <span class="font-medium text-gray-400">Check In:</span> 
                                        {{ $booking->check_in->format('d M Y') }}
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-400">Check Out:</span> 
                                        {{ $booking->check_out->format('d M Y') }}
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-400">Durasi:</span> 
                                        {{ $booking->check_in->diffInDays($booking->check_out) }} Malam
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 md:mt-0 text-left md:text-right w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0 flex flex-col items-end gap-2">
                                <div>
                                    <p class="text-sm text-gray-500">Total Bayar</p>
                                    <p class="text-lg font-bold text-blue-600 mb-2">
                                        Rp {{ number_format($booking->payment->amount ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                                    @if($booking->cancel_request && $booking->cancel_request->status === 'Pending')
                                        <button disabled class="inline-block bg-gray-100 text-gray-400 text-sm px-4 py-2 rounded w-full md:w-auto text-center cursor-not-allowed">
                                            Cancel Request Sent
                                        </button>
                                    @elseif($booking->cancel_request && $booking->cancel_request->status === 'approved')
                                        <button disabled class="inline-block bg-gray-100 text-gray-400 text-sm px-4 py-2 rounded w-full md:w-auto text-center cursor-not-allowed">
                                            Cancelled
                                        </button>
                                    @else
                                        <button type="button" onclick="document.getElementById('modal-cancel-{{ $booking->id }}').showModal()" class="bg-red-500 text-white text-sm px-4 py-2 rounded hover:bg-red-600 transition w-full md:w-auto text-center">
                                            Cancel
                                        </button>
                                        
                                        @if($booking->payment && $booking->payment->status !== 'Paid')
                                            <a href="/payment/{{ $booking->id }}" class="inline-block bg-orange-500 text-white text-sm px-4 py-2 rounded hover:bg-orange-600 transition w-full md:w-auto text-center">
                                                Bayar Sekarang
                                            </a>
                                        @else
                                            {{-- BUTTON SELESAI DIGANTI JADI VIEW DETAILS --}}
                                            <button type="button" onclick="document.getElementById('modal-detail-accommodation-{{ $booking->id }}').showModal()" class="inline-block bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700 transition w-full md:w-auto text-center font-semibold">
                                                View Details
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- POPUP MODAL FORM PEMBATALAN PER BOOKING ID --}}
                        <dialog id="modal-cancel-{{ $booking->id }}" class="rounded-lg shadow-2xl p-6 w-full max-w-md backdrop:bg-gray-900/50">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-gray-900">Alasan Pembatalan</h3>
                                <button onclick="document.getElementById('modal-cancel-{{ $booking->id }}').close()" class="text-gray-400 hover:text-gray-600">&times;</button>
                            </div>
                            <form action="{{ route('booking.cancel.request', $booking->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="flight_booking_id" value="{{ $booking->flight_booking_id ?? '' }}">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mengapa Anda ingin membatalkan reservasi ini?</label>
                                    <textarea name="reason" rows="4" required class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-red-500 focus:outline-none placeholder-gray-400" placeholder="Tulis alasan pembatalan Anda di sini..."></textarea>
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="document.getElementById('modal-cancel-{{ $booking->id }}').close()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200 transition text-sm">
                                        Batal
                                    </button>
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition text-sm font-semibold">
                                        Kirim Permohonan
                                    </button>
                                </div>
                            </form>
                        </dialog>

                        {{-- POPUP MODAL DETAIL ACCOMMODATION --}}
                        <dialog id="modal-detail-accommodation-{{ $booking->id }}" class="rounded-xl shadow-2xl p-6 w-full max-w-lg backdrop:bg-gray-900/50 border border-gray-100">
                            <div class="flex justify-between items-center border-b pb-3 mb-4">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">🏨 Accommodation Details</h3>
                                <button onclick="document.getElementById('modal-detail-accommodation-{{ $booking->id }}').close()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                            </div>
                            <div class="space-y-4 text-sm text-gray-700">
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <h4 class="font-bold text-gray-800 mb-1">Unit Name</h4>
                                    <p class="text-base font-semibold text-blue-600">{{ $booking->unit_details['name'] ?? 'Unit #' . $booking->unit_id }}</p>
                                    <p class="text-xs text-gray-400 mt-2">Reservation ID: {{ $booking->id }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4 border-b pb-3">
                                    <div>
                                        <p class="text-xs text-gray-400 font-semibold uppercase">Check-In</p>
                                        <p class="font-bold text-gray-800">{{ $booking->check_in->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-semibold uppercase">Check-Out</p>
                                        <p class="font-bold text-gray-800">{{ $booking->check_out->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="bg-blue-50/50 border border-blue-100 p-4 rounded-xl">
                                    <h4 class="font-bold text-gray-800 mb-2">Payment Details</h4>
                                    <div class="space-y-1.5 text-xs">
                                        <div class="flex justify-between"><span>Status:</span><span class="font-bold text-green-600">Paid ✓</span></div>
                                        <div class="flex justify-between text-sm font-bold border-t pt-1.5 text-blue-600"><span>Total Payment:</span><span>Rp {{ number_format($booking->payment->amount ?? 0, 0, ',', '.') }}</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end mt-5">
                                <button type="button" onclick="document.getElementById('modal-detail-accommodation-{{ $booking->id }}').close()" class="bg-gray-100 text-gray-700 font-bold px-4 py-2 rounded text-xs hover:bg-gray-200 transition">Close</button>
                            </div>
                        </dialog>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ============================================================= --}}
        {{-- KELOMPOK TAB 2: SEKSI PENAMPILAN DAFTAR TIKET PESAWAT BARU     --}}
        {{-- ============================================================= --}}
        <div id="section-flights" class="hidden">
            @if($flightBookings->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500 mb-4">Kamu belum memiliki riwayat pemesanan tiket pesawat.</p>
                    <a href="/flights" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Cari Tiket Pesawat Sekarang
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($flightBookings as $flight)
                        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-sm font-mono font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded">{{ $flight->booking_code }}</span>
                                    
                                    @if(($flight->payment->status ?? 'pending') === 'Paid')
                                        <span class="px-2 py-1 text-xs font-bold rounded bg-green-100 text-green-800">Issued ✓</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-bold rounded bg-yellow-100 text-yellow-800">Pending Payment</span>
                                    @endif
                                </div>

                                <h2 class="text-xl font-bold text-gray-800 mb-2">
                                    {{ $flight->flight_details['airline'] ?? 'Flight Booking' }}
                                    <span class="text-xs font-normal text-gray-400">({{ $flight->tickets->count() }} Penumpang)</span>
                                </h2>

                                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                    @if($flight->flight_details)
                                        <div>
                                            <span class="font-medium text-gray-400">Rute:</span> 
                                            <span class="font-bold text-gray-800">{{ $flight->flight_details['origin'] }} → {{ $flight->flight_details['destination'] }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-400">Keberangkatan:</span> 
                                            {{ \Carbon\Carbon::parse($flight->flight_details['departure_time'])->format('d M Y · H:i') }}
                                        </div>
                                    @else
                                        <div class="text-gray-400 font-medium">Detail penerbangan sedang dimuat...</div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 md:mt-0 text-left md:text-right w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0 flex flex-col items-end gap-2">
                                <div>
                                    <p class="text-sm text-gray-500">Total Bayar</p>
                                    <p class="text-lg font-bold text-purple-600 mb-2">
                                        Rp {{ number_format($flight->payment->amount ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                                {{-- BUTTON E-TICKET DIGANTI JADI VIEW DETAILS --}}
                                <button type="button" onclick="document.getElementById('modal-detail-flight-{{ $flight->id }}').showModal()" class="inline-block bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700 transition w-full md:w-auto text-center font-semibold">
                                    View Details
                                </button>
                            </div>
                        </div>

                        {{-- POPUP MODAL DETAIL FLIGHT TICKET BOOKING --}}
                        <dialog id="modal-detail-flight-{{ $flight->id }}" class="rounded-xl shadow-2xl p-6 w-full max-w-xl backdrop:bg-gray-900/50 border border-gray-100">
                            <div class="flex justify-between items-center border-b pb-3 mb-4">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">✈️ Flight Booking Details</h3>
                                <button onclick="document.getElementById('modal-detail-flight-{{ $flight->id }}').close()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                            </div>
                            
                            <div class="space-y-4 text-sm text-gray-700 max-h-[60vh] overflow-y-auto pr-1">
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <p class="text-xs font-bold text-purple-500 uppercase tracking-wider mb-1">Flight Information</p>
                                    <p class="text-base font-bold text-gray-800">{{ $flight->flight_details['airline'] ?? 'Airlines Route' }}</p>
                                    <div class="grid grid-cols-2 gap-2 mt-2 text-xs">
                                        <p><span class="text-gray-400 font-semibold">Route:</span> {{ $flight->flight_details['origin'] ?? 'N/A' }} → {{ $flight->flight_details['destination'] ?? 'N/A' }}</p>
                                        <p><span class="text-gray-400 font-semibold">Class:</span> {{ ucfirst($flight->tickets->first()->seat_type ?? 'Economy') }}</p>
                                        <p class="col-span-2"><span class="text-gray-400 font-semibold">Departure:</span> {{ \Carbon\Carbon::parse($flight->flight_details['departure_time'])->format('d M Y · H:i') }}</p>
                                    </div>
                                </div>

                                <div class="p-4 bg-white border border-gray-200 rounded-xl">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">👥 Passengers</p>
                                    <div class="divide-y divide-gray-100">
                                        @if($flight->tickets && $flight->tickets->isNotEmpty())
                                            @foreach($flight->tickets as $ticket)
                                                <div class="py-2 flex justify-between items-center text-xs">
                                                    <div>
                                                        <p class="font-bold text-gray-800">{{ $ticket->passenger->name ?? 'Passenger Data Missing' }}</p>
                                                        <p class="text-gray-400 text-[11px]">Phone: {{ $ticket->passenger->phone_number ?? '-' }}</p>
                                                    </div>
                                                    <span class="font-mono bg-purple-50 text-purple-700 font-bold px-2 py-0.5 rounded border border-purple-100">
                                                        Seat: {{ $ticket->seat_number }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-xs text-gray-400 py-2 text-center">No passenger manifest bound.</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="bg-purple-50/40 border border-purple-100 p-4 rounded-xl">
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Payment Breakdown</p>
                                    <div class="space-y-1.5 text-xs">
                                        <div class="flex justify-between"><span>Status:</span><span class="font-bold text-green-600">{{ ucfirst($flight->payment->status ?? 'Paid') }} ✓</span></div>
                                        <div class="flex justify-between text-sm font-bold border-t pt-1.5 text-purple-700"><span>Grand Total Paid:</span><span>Rp {{ number_format($flight->payment->amount ?? 0, 0, ',', '.') }}</span></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center mt-5 pt-3 border-t">
                                <button type="button" onclick="triggerSimulatedDownload('{{ $flight->booking_code }}')" class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-4 py-2 rounded text-xs transition flex items-center gap-1">
                                    📥 Download All Tickets
                                </button>
                                <button type="button" onclick="document.getElementById('modal-detail-flight-{{ $flight->id }}').close()" class="bg-gray-100 text-gray-700 font-bold px-4 py-2 rounded text-xs hover:bg-gray-200 transition">
                                    Close
                                </button>
                            </div>
                        </dialog>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>

{{-- COMPONENT FLOATING TOAST POPUP NOTIFICATION --}}
<div id="toastNotification" class="fixed bottom-8 left-1/2 transform -translate-x-1/2 z-50 bg-gray-900/90 backdrop-blur-md text-white text-xs font-bold px-6 py-3 rounded-full shadow-2xl opacity-0 pointer-events-none transition-all duration-300">
    <span>Berhasil mendownload tiket!</span>
</div>

{{-- Skrip JavaScript Pemindah Tab Aktif & Toast --}}
<script>
function switchBookingTab(tabId) {
    const sectionAccom = document.getElementById('section-accommodation');
    const sectionFlights = document.getElementById('section-flights');
    const btnAccom = document.getElementById('btn-tab-accommodation');
    const btnFlights = document.getElementById('btn-tab-flights');

    if (tabId === 'tab-accommodation') {
        sectionAccom.classList.remove('hidden');
        sectionFlights.classList.add('hidden');
        btnAccom.className = "pb-3 text-sm font-bold border-b-2 border-blue-600 text-blue-600 transition-all";
        btnFlights.className = "pb-3 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all";
    } else {
        sectionFlights.classList.remove('hidden');
        sectionAccom.classList.add('hidden');
        btnFlights.className = "pb-3 text-sm font-bold border-b-2 border-blue-600 text-blue-600 transition-all";
        btnAccom.className = "pb-3 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all";
    }
}

// Fungsi Trigger Notifikasi Download Tiket Tiruan
function triggerSimulatedDownload(bookingCode) {
    const toast = document.getElementById('toastNotification');
    
    // Munculkan toast
    toast.classList.remove('opacity-0', 'pointer-events-none');
    toast.classList.add('opacity-100');

    // Hilangkan otomatis setelah 3 detik
    setTimeout(() => {
        toast.classList.remove('opacity-100');
        toast.classList.add('opacity-0', 'pointer-events-none');
    }, 3000);
}
</script>
@endsection