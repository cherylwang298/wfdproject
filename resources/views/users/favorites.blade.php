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

            @php
$dummyImages = [
    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=600&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1540518614846-7eded433c457?w=600&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1568495248636-6432b97bd949?w=600&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=600&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=600&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=600&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1529290130-4ca3753253ae?w=600&auto=format&fit=crop&q=80'
];
@endphp


            {{-- Favorite List --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                @foreach($properties as $property)

                @php
                $assignedDummy = $dummyImages[$loop->index % 10];
                @endphp

                    <div class="group rounded-3xl overflow-hidden bg-white shadow hover:shadow-xl transition duration-300">

                        {{-- Image --}}
                        <div class="relative h-72 overflow-hidden">

                           @if(!empty($property['image']))
    <img
        src="{{ asset('storage/'.$property['image']['path']) }}"
        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
@else
    <img
        src="{{ $assignedDummy }}"
        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
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