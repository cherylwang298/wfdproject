@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Reservations</h2>
        <p class="text-gray-400 mt-1">Monitor, approve, and manage customer bookings.</p>
    </div>

    {{-- {{ route('admin.reservations.create') }} --}}
    <a href=""
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold shadow transition">
        + Create Reservation
    </a>
</div>

{{-- SUMMARY --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Bookings</p>
            <h3 class="text-3xl font-bold mt-2">{{ $reservations->count() }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Pending Approval</p>
            <h3 class="text-3xl font-bold mt-2 text-amber-500">
                {{ $reservations->where('status', 'pending')->count() }}
            </h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Confirmed / Active</p>
            <h3 class="text-3xl font-bold mt-2 text-blue-600">
                {{ $reservations->where('status', 'confirmed')->count() }}
            </h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Revenue</p>
            <h3 class="text-3xl font-bold mt-2 text-green-600">
                Rp {{ number_format($reservations->where('status', '!=', 'cancelled')->sum('total_price'), 0, ',', '.') }}
            </h3>
        </div>
    </div>

</div>

{{-- TABLE --}}
<div class="bg-white rounded-[24px] shadow-sm border border-gray-50">

    <div class="flex justify-between items-center p-6 border-b">
        <h3 class="font-bold text-lg">
            All Reservations
        </h3>

        <input
            type="text"
            placeholder="Search code, customer name..."
            class="border rounded-xl px-4 py-2 text-sm w-72 focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="border-b bg-gray-50">
                <tr class="text-left text-xs uppercase tracking-wider text-gray-400">
                    <th class="px-6 py-4">Booking Code</th>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4">Reservation Date</th>
                    <th class="px-6 py-4">Total Payment</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($reservations as $reservation)
                <tr class="border-b hover:bg-gray-50">
                    
                    {{-- Kode Booking --}}
                    <td class="px-6 py-5">
                        <span class="font-bold text-blue-600 block">
                            {{ $reservation->booking_code }}
                        </span>
                        <span class="text-xs text-gray-400">
                            Created {{ optional($reservation->created_at)->format('d M Y') }}
                        </span>
                    </td>

                    {{-- Data Customer --}}
                    <td class="px-6 py-5">
                        <span class="font-semibold text-gray-900 block">
                            {{ $reservation->user->name ?? $reservation->customer_name }}
                        </span>
                        <span class="text-xs text-gray-400 block">
                            {{ $reservation->user->email ?? $reservation->customer_phone }}
                        </span>
                    </td>

                    {{-- Tanggal Reservasi --}}
                    <td class="px-6 py-5 text-gray-600">
                        <div class="text-sm font-medium">
                            {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }} WIB
                        </div>
                    </td>

                    {{-- Total Bayar --}}
                    <td class="px-6 py-5 font-semibold text-gray-900">
                        Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                    </td>

                    {{-- Status Badge Dinamis --}}
                    <td class="px-6 py-5">
                        @if($reservation->status == 'pending')
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-xs font-bold capitalize">
                                Pending
                            </span>
                        @elseif($reservation->status == 'confirmed')
                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-bold capitalize">
                                Confirmed
                            </span>
                        @elseif($reservation->status == 'completed')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-bold capitalize">
                                Completed
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold capitalize">
                                Cancelled
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            {{-- {{ route('admin.reservations.show', $reservation) }} --}}
                            <a href=""
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-xl text-sm font-medium transition">
                                Detail
                            </a>

                            {{-- {{ route('admin.reservations.edit', $reservation) }} --}}
                            <a href=""
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded-xl text-sm font-medium transition">
                                Edit
                            </a>

                            {{-- {{ route('admin.reservations.destroy', $reservation) }} --}}
                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    onclick="return confirm('Cancel or delete this reservation?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl text-sm font-medium transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-10 text-center text-gray-400">
                        No reservations found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection