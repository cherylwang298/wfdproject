@extends('layouts.user')

@section('content')

@php
$currentPage = 'hotel';
@endphp

@include('partials.navbar')

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 md:pt-32 pb-16 md:pb-24">

    {{-- HERO IMAGE --}}
    <div class="rounded-2xl md:rounded-3xl overflow-hidden shadow-md">
        @if($property['image'])
            <img
                src="{{ asset('storage/'.$property['image']['path']) }}"
                class="w-full h-[220px] sm:h-[320px] md:h-[420px] object-cover">
        @else
            <div class="h-[220px] sm:h-[320px] md:h-[420px] bg-gray-200 flex items-center justify-center text-gray-500 font-medium">
                No Image
            </div>
        @endif
    </div>

    {{-- INFO --}}
    <div class="mt-6 md:mt-10 px-1">
        <h1 class="text-xl sm:text-2xl md:text-4xl font-bold tracking-tight text-gray-900 leading-tight">
            {{ $property['name'] }}
        </h1>

        <p class="text-xs sm:text-sm md:text-base text-gray-500 mt-2 leading-relaxed">
            <span class="inline-block mr-1">📍</span> {{ $property['city'] }}
            <span class="block text-xs sm:text-sm text-gray-400 mt-1">{{ $property['address'] }}</span>
        </p>

        <p class="mt-5 md:mt-8 text-xs sm:text-sm md:text-base text-gray-600 leading-6 md:leading-8">
            {{ $property['description'] }}
        </p>
    </div>

    {{-- UNITS --}}
    <div class="mt-12 md:mt-16">
        <h2 class="text-xl sm:text-2xl font-bold mb-6 px-1 text-gray-900">
            Available Units
        </h2>

        @if($units->count())
            <div class="space-y-5 md:space-y-6">
                @foreach($units as $unit)
                    <div class="bg-white rounded-2xl md:rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row overflow-hidden transition-all hover:shadow-md">

                        {{-- IMAGE UNIT --}}
                        <div class="w-full md:w-64 h-44 sm:h-52 md:h-auto bg-gray-100 shrink-0 relative">
                            @if($unit['image'])
                                <img
                                    src="{{ asset('storage/'.$unit['image']['path']) }}"
                                    class="w-full h-full object-cover md:absolute md:inset-0">
                            @else
                                <div class="w-full h-full md:absolute md:inset-0 flex items-center justify-center text-gray-400 text-xs">
                                    No Image
                                </div>
                            @endif
                        </div>

                        {{-- CONTENT UNIT --}}
                        <div class="flex-1 p-4 sm:p-6 md:p-8 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900">
                                    {{ $unit['name'] }}
                                </h3>

                                <p class="text-xs sm:text-sm text-gray-500 mt-1 flex items-center gap-1">
                                    <span class="text-gray-400">👥</span> Capacity: {{ $unit['capacity'] }} Guests
                                </p>

                                @isset($unit['description'])
                                    <p class="mt-2.5 text-xs sm:text-sm text-gray-500 leading-relaxed line-clamp-2 md:line-clamp-3">
                                        {{ $unit['description'] }}
                                    </p>
                                @endisset
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mt-5 pt-3 border-t border-gray-100 md:border-0 md:pt-0">
                                <div>
                                    <span class="text-xl sm:text-2xl font-black text-blue-600 block sm:inline">
                                        Rp{{ number_format($unit['price'], 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-gray-400 sm:ml-1">
                                        / night
                                    </span>
                                </div>

                                @if(auth()->check())
                                    <a href="{{ route('booking.open', ['id' => $unit['id'], 'checkin' => $checkin, 'checkout' => $checkout, 'guests' => $guests]) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-center px-5 py-2.5 rounded-xl font-semibold text-xs sm:text-sm transition-colors shadow-sm block w-full sm:w-auto">
                                        Book Now
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-center px-5 py-2.5 rounded-xl font-semibold text-xs sm:text-sm transition-colors shadow-sm block w-full sm:w-auto">
                                        Login to Book
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-50 rounded-2xl p-8 sm:p-12 text-center border border-dashed border-gray-200">
                <div class="text-4xl mb-3">🛏️</div>
                <h3 class="text-lg font-bold text-gray-800">No Units Available</h3>
                <p class="text-xs text-gray-500 mt-1 max-w-xs mx-auto">
                    This property currently has no available units for the selected criteria.
                </p>
            </div>
        @endif
    </div>

</div>

@endsection