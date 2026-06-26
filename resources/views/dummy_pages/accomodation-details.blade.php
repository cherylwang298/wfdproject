@extends('layouts.user')

@section('content')

@php
$currentPage = 'hotel';
@endphp

@include('partials.navbar')

<div class="max-w-7xl mx-auto px-6 pt-28 pb-20">

    {{-- HERO IMAGE --}}
    <div class="rounded-3xl overflow-hidden shadow-lg">

        @if($property['image'])

            <img
                src="{{ asset('storage/'.$property['image']['path']) }}"
                class="w-full h-[450px] object-cover">

        @else

            <div class="h-[450px] bg-gray-200 flex items-center justify-center">

                No Image

            </div>

        @endif

    </div>

    {{-- INFO --}}
    <div class="mt-10">

        <h1 class="text-4xl font-bold">

            {{ $property['name'] }}

        </h1>

        <p class="text-gray-500 mt-2">

            📍 {{ $property['city'] }}

            <br>

            {{ $property['address'] }}

        </p>

        <p class="mt-8 text-gray-700 leading-8">

            {{ $property['description'] }}

        </p>

    </div>

    {{-- UNITS --}}
    <div class="mt-14">

        <h2 class="text-3xl font-bold mb-8">

            Available Units

        </h2>

        @if($units->count())

            <div class="space-y-6">

                @foreach($units as $unit)

                    <div class="bg-white rounded-3xl shadow flex overflow-hidden">

                        {{-- IMAGE --}}
                        <div class="w-72 h-56 bg-gray-100">

                            @if($unit['image'])

                                <img
                                    src="{{ asset('storage/'.$unit['image']['path']) }}"
                                    class="w-full h-full object-cover">

                            @else

                                <div class="w-full h-full flex items-center justify-center">

                                    No Image

                                </div>

                            @endif

                        </div>

                        {{-- CONTENT --}}
                        <div class="flex-1 p-8 flex flex-col justify-between">

                            <div>

                                <h3 class="text-2xl font-bold">

                                    {{ $unit['name'] }}

                                </h3>

                                <p class="text-gray-500 mt-2">

                                    Capacity :
                                    {{ $unit['capacity'] }} Guests

                                </p>

                                @isset($unit['description'])
                                    <p class="mt-4 text-gray-600">
                                        {{ $unit['description'] }}
                                    </p>
                                @endisset

                            </div>

                            <div class="flex justify-between items-center mt-8">

                                <div>

                                    <span class="text-3xl font-bold text-blue-600">

                                        Rp{{ number_format($unit['price'],2) }}

                                    </span>

                                    <span class="text-gray-500">

                                        / night

                                    </span>

                                </div>


                                {{-- <a
                                    href="#"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

                                    Book Now

                                </a> --}}

                                @if(auth()->check())
{{--  --}}
    <a href="{{ route('booking.open', [
    'id' => $unit['id'],
    'checkin' => $checkin,
    'checkout' => $checkout,
    'guests' => $guests,
]) }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

        Book Now

    </a>

@else

    <a
        href="{{ route('login') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

        Login to Book

    </a>

@endif


                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="bg-gray-50 rounded-3xl p-16 text-center">

                <div class="text-6xl">

                    🛏️

                </div>

                <h3 class="text-2xl font-bold mt-5">

                    No Units Available

                </h3>

                <p class="text-gray-500 mt-3">

                    This property currently has no available units.

                </p>

            </div>

        @endif

    </div>

</div>

@endsection