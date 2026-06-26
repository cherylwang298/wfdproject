@extends('layouts.user') 

@php
$currentPage = 'bookings';
@endphp

@include('partials.navbar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">My Bookings</h1>

    @if(!auth()->check())
        {{-- TAMPILAN JIKA USER BELUM LOGIN --}}
        <div class="bg-white rounded-lg shadow p-6 text-center max-w-md mx-auto">
            <div class="text-gray-400 mb-4">
                {{-- Icon Gembok/Login Opsional --}}
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            {{-- <h2 class="text-xl font-semibold text-gray-700 mb-2">Yuk, Login Dulu!</h2> --}}
            <p class="text-gray-500 mb-6">Silakan login terlebih dahulu untuk melihat riwayat reservasi Anda.</p>
            <a href="/login" class="inline-block bg-blue-600 text-white font-medium px-6 py-2 rounded hover:bg-blue-700 transition w-full">
                Login Sekarang
            </a>
        </div>
    @else
        {{-- TAMPILAN JIKA USER SUDAH LOGIN --}}
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
                                
                                @if($booking->payment && $booking->payment->status === 'Paid')
                                    <span class="px-2 py-1 text-xs font-bold rounded bg-green-100 text-green-800">Confirmed</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-bold rounded bg-yellow-100 text-yellow-800">Pending Payment</span>
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

                        <div class="mt-4 md:mt-0 text-left md:text-right w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0">
                            <p class="text-sm text-gray-500">Total Bayar</p>
                            <p class="text-lg font-bold text-blue-600 mb-2">
                                Rp {{ number_format($booking->payment->amount ?? 0, 0, ',', '.') }}
                            </p>

                            <a href="#" onclick="return confirm('Apakah kamu yakin ingin membatalkan reservasi ini?')" class="inline-block bg-red-500 text-white text-sm px-4 py-2 rounded hover:bg-red-600 transition w-full md:w-auto text-center">
                                    Cancel
                            </a>
                            
                            @if($booking->payment && $booking->payment->status !== 'Paid')
                                <a href="/payment/{{ $booking->id }}" class="inline-block bg-orange-500 text-white text-sm px-4 py-2 rounded hover:bg-orange-600 transition w-full md:w-auto text-center">
                                    Bayar Sekarang
                                </a>
                            @else
                                <button disabled class="inline-block bg-gray-100 text-gray-400 text-sm px-4 py-2 rounded w-full md:w-auto text-center cursor-not-allowed">
                                    Selesai
                                </button>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
@endsection