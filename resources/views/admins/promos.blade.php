@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Promo Management</h2>
        <p class="text-gray-400 mt-1">Create and manage promotional discounts.</p>
    </div>

    {{-- {{ route('admin.promos.create') }} --}}
    <a href=""
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold shadow">
        + Create Promo
    </a>
</div>

{{-- SUMMARY --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Promos</p>
            <h3 class="text-3xl font-bold mt-2">{{ $promos->count() }}</h3>
        </div>
        <div class="p-3 bg-blue-500 rounded-2xl text-white">
            🎁
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Active</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $promos->where('expired_at','>',now())->count() }}
            </h3>
        </div>
        <div class="p-3 bg-green-500 rounded-2xl text-white">
            ✅
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Expired</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $promos->where('expired_at','<',now())->count() }}
            </h3>
        </div>
        <div class="p-3 bg-red-500 rounded-2xl text-white">
            ⏰
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Quota</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $promos->sum('quota') }}
            </h3>
        </div>
        <div class="p-3 bg-purple-500 rounded-2xl text-white">
            🎟️
        </div>
    </div>

</div>

{{-- TABLE --}}
<div class="bg-white rounded-[24px] shadow-sm border border-gray-50">

    <div class="flex justify-between items-center p-6 border-b">

        <h3 class="font-bold text-lg">
            All Promos
        </h3>

        <input
            type="text"
            placeholder="Search promo..."
            class="border rounded-xl px-4 py-2 text-sm w-72 focus:ring-2 focus:ring-blue-500">

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="border-b bg-gray-50">

            <tr class="text-left text-xs uppercase tracking-wider text-gray-400">

                <th class="px-6 py-4">Promo Code</th>

                <th class="px-6 py-4">Discount</th>

                <th class="px-6 py-4">Min Purchase</th>

                <th class="px-6 py-4">Quota</th>

                <th class="px-6 py-4">Expired</th>

                <th class="px-6 py-4">Status</th>

                <th class="px-6 py-4 text-right">Actions</th>

            </tr>

            </thead>

            <tbody>

            @forelse($promos as $promo)

                @php

                    $expired = $promo->expired_at && \Carbon\Carbon::parse($promo->expired_at)->isPast();

                @endphp

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-6 py-5">

                        <span class="font-bold text-blue-600">
                            {{ $promo->code }}
                        </span>

                    </td>

                    <td class="px-6 py-5">

                        @if($promo->discount_type=='percentage')

                            {{ $promo->discount_value }}%

                        @else

                            Rp {{ number_format($promo->discount_value,0,',','.') }}

                        @endif

                    </td>

                    <td class="px-6 py-5">

                        Rp {{ number_format($promo->min_purchase,0,',','.') }}

                    </td>

                    <td class="px-6 py-5">

                        {{ $promo->quota }}

                    </td>

                    <td class="px-6 py-5">

                        {{ optional($promo->expired_at)->format('d M Y') }}

                    </td>

                    <td class="px-6 py-5">

                        @if($expired)

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold">
                                Expired
                            </span>

                        @elseif($promo->quota <= 0)

                            <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-bold">
                                Out of Quota
                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-bold">
                                Active
                            </span>

                        @endif

                    </td>

                    <td class="px-6 py-5">

                        <div class="flex justify-end gap-2">
{{-- {{ route('admin.promos.edit',$promo) }} --}}
                            <a href=""
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded-xl">
                                ✏️
                            </a>

                            {{-- {{ route('admin.promos.destroy',$promo) }} --}}
                            <form action="" method="POST">

                                @csrf

                                @method('DELETE')

                                <button
                                    onclick="return confirm('Delete promo?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl">

                                    🗑️

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="py-10 text-center text-gray-400">

                        No promos found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection