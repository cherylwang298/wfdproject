@extends('layouts.user')

@section('content')

@php
$currentPage = 'hotel';
@endphp

@include('partials.navbar')

<div class="max-w-7xl mx-auto px-6 pt-28 pb-20">
    <h1 class="text-4xl font-bold mb-10">Review & Book Your Accommodation</h1>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">
        {{ session('success') }}
    </div>
@endif

{{-- TAMBAHKAN BLOCK INI UNTUK MELIHAT ERROR --}}
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
        <strong>Error:</strong> {{ session('error') }}
    </div>
@endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        {{-- LEFT COLUMN: FORM DETAIL PEMESAN & PEMBAYARAN --}}
        {{-- {{ route('booking.store') }} --}}
        <div class="lg:col-span-2 space-y-8">
            <form action="{{ route('booking.store') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="unit_id" value="{{ $unit['id'] }}">
                <input type="hidden" name="check_in" value="{{ $checkin }}">
                <input type="hidden" name="check_out" value="{{ $checkout }}">
                <input type="hidden" name="total_price" value="{{ $totalPrice }}">

                {{-- DETAIL PEMESAN (EDITABLE) --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Contact Details</h2>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-gray-600 font-medium mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $fullname ?? '') }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror" required>
                            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" 
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror" required>
                                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone_number ?? '') }}" 
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500 @error('phone') border-red-500 @enderror" placeholder="e.g. 08123456789" required>
                                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- METODE PEMBAYARAN --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Payment Method</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="border border-gray-200 rounded-2xl p-4 flex items-center cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="payment_method" value="Bank Transfer" class="w-4 h-4 text-blue-600" checked>
                            <span class="ml-3 font-medium text-gray-700">Bank Transfer</span>
                        </label>
                        
                        <label class="border border-gray-200 rounded-2xl p-4 flex items-center cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="payment_method" value="E-Wallet" class="w-4 h-4 text-blue-600">
                            <span class="ml-3 font-medium text-gray-700">E-Wallet (Dana/OVO)</span>
                        </label>

                        <label class="border border-gray-200 rounded-2xl p-4 flex items-center cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="payment_method" value="Credit Card" class="w-4 h-4 text-blue-600">
                            <span class="ml-3 font-medium text-gray-700">Credit Card</span>
                        </label>
                    </div>
                    @error('payment_method') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- TOMBOL BOOK NOW --}}
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-blue-200 transition duration-200">
                    Book Now
                </button>
            </form>
        </div>

        {{-- RIGHT COLUMN: RINGKASAN BOOKING & HARGA TOTAL --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 sticky top-28">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Price Details</h2>
                
                {{-- Info Gambar & Nama --}}
                <div class="flex gap-4 pb-6 border-b border-gray-100">
                    <div class="w-24 h-20 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                        @if($unit['image'])
                            <img src="{{ asset('storage/'.$unit['image']['path']) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Image</div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 leading-tight">{{ $unit['name'] }}</h3>
                        <p class="text-sm text-gray-500 mt-1">📍 {{ $property['name'] ?? 'Property' }}, {{ $property['city'] ?? '' }}</p>
                    </div>
                </div>

                {{-- Detail Durasi Singgah --}}
                <div class="py-4 border-b border-gray-100 text-sm space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Check-in:</span>
                        <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($checkin)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Check-out:</span>
                        <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($checkout)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Duration:</span>
                        <span class="font-semibold text-gray-800">{{ $nights }} Night(s)</span>
                    </div>
                </div>

                {{-- Rincian Penghitungan Harga --}}
                <div class="pt-4 space-y-3">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Rp{{ number_format($unit['price'], 2) }} x {{ $nights }} night</span>
                        <span>Rp{{ number_format($unit['price'] * $nights, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Service Fee</span>
                        <span class="text-green-600 font-medium">Free</span>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <span class="text-base font-bold text-gray-800">Total Price</span>
                        <span class="text-2xl font-bold text-blue-600">Rp{{ number_format($totalPrice, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection