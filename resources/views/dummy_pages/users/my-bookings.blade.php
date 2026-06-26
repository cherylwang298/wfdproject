@extends('layouts.user') 

@php
$currentPage = 'bookings';
@endphp

@include('partials.navbar')

@section('content')
<div class="container mx-auto px-4 py-8">
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
                                
                                {{-- LOGIKA STATUS BADGE YANG BARU --}}
                                @if($booking->cancel_request)
                                    @if($booking->cancel_request->status === 'Pending')
                                        <span class="px-2 py-1 text-xs font-bold rounded bg-purple-100 text-purple-800">Cancel Request Sent</span>
                                    @elseif($booking->cancel_request->status === 'Approved')
                                        <span class="px-2 py-1 text-xs font-bold rounded bg-red-100 text-red-800">Cancelled</span>
                                    @elseif($booking->cancel_request->status === 'Rejected')
                                        {{-- Jika admin menolak pembatalan, balikkan ke status Paid semula --}}
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
                                {{-- LOGIKA TOMBOL AKSI KANAN --}}
                                @if($booking->cancel_request)
                                    {{-- Jika sudah ada CancelRequest, matikan semua tombol pembatalan/pembayaran --}}
                                    <button disabled class="inline-block bg-gray-100 text-gray-400 text-sm px-4 py-2 rounded w-full md:w-auto text-center cursor-not-allowed">
                                        Cancel Request Sent
                                    </button>
                                @else
                                    {{-- Jika BELUM ada cancel request --}}
                                    <button type="button" onclick="document.getElementById('modal-cancel-{{ $booking->id }}').showModal()" class="bg-red-500 text-white text-sm px-4 py-2 rounded hover:bg-red-600 transition w-full md:w-auto text-center">
                                        Cancel
                                    </button>
                                    
                                    @if($booking->payment && $booking->payment->status !== 'Paid')
                                        <a href="/payment/{{ $booking->id }}" class="inline-block bg-orange-500 text-white text-sm px-4 py-2 rounded hover:bg-orange-600 transition w-full md:w-auto text-center">
                                            Bayar Sekarang
                                        </a>
                                    @else
                                        <button disabled class="inline-block bg-gray-100 text-gray-400 text-sm px-4 py-2 rounded w-full md:w-auto text-center cursor-not-allowed">
                                            Selesai
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

                @endforeach
            </div>
        @endif
    @endif
</div>
@endsection