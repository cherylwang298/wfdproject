@extends('layouts.user')

@section('content')

@php
$currentPage = 'hotel';
@endphp
@include('partials.navbar')

<div class="max-w-7xl mx-auto px-6 pt-28 pb-20">

    {{-- Header --}}
    <div class="mb-10">

        <h1 class="text-4xl font-extrabold">
            Accommodations
        </h1>

        <p class="text-gray-500 mt-2">
              @php
                $cnt = count($properties);

                if ($cnt == 1) {
                    $word = 'stay';
                } else {
                    $word = 'stays';
                }
            @endphp
            {{ count($properties) }} {{ $word }} found
        </p>

        {{-- <div class="flex flex-wrap gap-4 mt-5 text-sm">

         

        </div> --}}

    </div>

    @if(count($properties))

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

            @foreach($properties as $property)

            {{-- {{ route('property.detail',$property['id']) }}  property.detail--}}
                <a
                   href="{{ route('property.detail', [
    'id' => $property['id'],
    'checkin' => $checkin,
    'checkout' => $checkout,
    'guests' => $guests,
]) }}"
                    class="group bg-white rounded-3xl overflow-hidden shadow hover:shadow-xl transition duration-300">

                    {{-- Image --}}
                    <div class="aspect-[4/3] overflow-hidden bg-gray-200">

                        @if(!empty($property['image_url']))
                            <img
                                src="{{ asset($property['image']['path']) }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                No Image
                            </div>
                        @endif

                    </div>

          
                    <div class="p-5">

                        <div class="flex justify-between items-start">

                            <h2 class="font-bold text-lg leading-tight">
                                {{ $property['name'] }}
                            </h2>

                            <span class="text-yellow-500">
                                ★5.0
                            </span>

                        </div>

                        <p class="text-gray-500 text-md font-semibold mt-2">
                             {{ $property['city'] }}
                        </p>

                        <p class="text-gray-600 text-sm mt-3 line-clamp-3">
                            {{ $property['description'] }}
                        </p>

                        <div class="mt-6 flex justify-between items-end">

                        <div>
                            <p class="text-xs text-gray-400">
                                Starting from
                            </p>

                            <p class="text-xl font-bold text-blue-600">
                                Rp {{ number_format($property['min_price'], 0, ',', '.') }}
                                <span class="text-sm font-medium text-gray-500">/night</span>
                            </p>
                        </div>
                    </div>

                    </div>

                </a>

            @endforeach

        </div>

    @else

        <div class="bg-white rounded-3xl shadow p-16 text-center">

            <div class="text-7xl mb-5">
                🏨
            </div>

            <h2 class="text-3xl font-bold">
                No accommodations found
            </h2>

            <p class="text-gray-500 mt-3">
                Try another city or choose different dates.
            </p>

            <a
                href="{{ route('accomodations.open') }}"
                class="inline-block mt-8 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">

                Search Again

            </a>

        </div>

    @endif

</div>

@endsection