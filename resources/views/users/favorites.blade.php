@extends('layouts.user')

@section('content')

@php
$currentPage = 'favorites';
@endphp

@include('partials.navbar')

<div class="max-w-7xl mx-auto px-6 pt-28 pb-20">

    {{-- Header --}}
    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
            Your Favourites
        </h1>

        <p class="text-lg text-gray-500 max-w-2xl">
            Curated collections for your next atmospheric journey.
        </p>
    </div>

    {{-- Belum Login --}}
    @guest

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm py-24 px-6 flex flex-col items-center text-center">

            <span class="material-symbols-outlined text-[80px] text-gray-300">
                favorite_border
            </span>

            <h2 class="text-2xl font-bold text-gray-800 mt-6">
                Login to see your favourite accommodations
            </h2>

            <p class="text-gray-500 mt-3 max-w-md">
                Sign in to access all the places you've saved for your next stay.
            </p>

            <a href="{{ route('login') }}"
               class="mt-8 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-full transition">
                Login
            </a>

        </div>

    @else

        {{-- Login tapi belum ada favorite --}}
        @if(count($properties) == 0)

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm py-24 px-6 flex flex-col items-center text-center">

                <span class="material-symbols-outlined text-[80px] text-gray-300">
                    favorite_border
                </span>

                <h2 class="text-2xl font-bold text-gray-800 mt-6">
                    Find your favourite accommodations
                </h2>

                <p class="text-gray-500 mt-3 max-w-md">
                    Save accommodations you love and they'll appear here.
                </p>

                <a href="{{ route('homepage') }}"
                   class="mt-8 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-full transition">
                    Explore Properties
                </a>

            </div>

        @else

            {{-- Favorite List --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                @foreach($properties as $property)

                    <div class="group rounded-3xl overflow-hidden bg-white shadow hover:shadow-xl transition duration-300">

                        {{-- Image --}}
                        <div class="relative h-72 overflow-hidden">

                            @if(isset($property['image']))
                                <img
                                    src="{{ asset('storage/'.$property['image']['path']) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                                    No Image
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                            <div class="absolute top-5 right-5">

                                <div class="w-11 h-11 rounded-full bg-white/80 backdrop-blur flex items-center justify-center">

                                    <span class="material-symbols-outlined text-red-500"
                                          style="font-variation-settings:'FILL' 1;">
                                        favorite
                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- Content --}}
                        <div class="p-6">

                            <h2 class="text-xl font-bold text-gray-900">
                                {{ $property['name'] }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-2 flex items-center gap-1">
                                <span class="material-symbols-outlined text-base">
                                    location_on
                                </span>

                                {{ $property['city'] }}
                            </p>

                            <div class="mt-6 flex justify-between items-center">

                                <div>

                                    <p class="text-sm text-gray-400">
                                        Starting from
                                    </p>

                                    <p class="text-2xl font-bold text-blue-600">
                                        Rp{{ number_format($property['starting_price'] ?? 0,0,',','.') }}
                                    </p>

                                </div>

                                <a
                                    href="{{ route('property.detail', $property['id']) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-xl transition">

                                    View Details

                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    @endguest

</div>

@include('partials.footer')

@endsection