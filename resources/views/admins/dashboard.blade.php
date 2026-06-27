@extends('layouts.admin')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between items-start">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Bookings</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalBookings }}</h3>
        </div>
        <div class="p-3 bg-blue-500 text-white rounded-2xl shadow-md shadow-blue-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
    </svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between items-start">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Revenue</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($totalRev, 0, ',', '.') }}</h3>
        </div>
        <div class="p-3 bg-cyan-400 text-white rounded-2xl shadow-md shadow-cyan-100">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 0 1 1.5 1.5v12a1.5 1.5 0 0 1-1.5 1.5H3.75a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Zm11.36 6c.07-.324.14-.654.21-.987M16.5 12h.008v.008H16.5V12Zm0 3h.008v.008H16.5V15Z" />
</svg>

        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between items-start">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Users</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUsers }}</h3>
        </div>
        <div class="p-3 bg-gray-100 text-gray-500 rounded-2xl">
            
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
</svg>


        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 my-6">
    
    {{-- CHART REVENUE--}}
    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 lg:col-span-2">
        <div class="flex justify-between items-center mb-6">
            <h4 class="font-bold text-gray-900 text-lg">Weekly Revenue Overview</h4>
            <select class="text-xs bg-gray-50 border border-gray-200 rounded-lg p-2 text-gray-500 focus:outline-none">
                <option>Last 7 Days</option>
            </select>
        </div>
        <div class="h-64 relative">
            <canvas id="revenueOverviewChart"></canvas>
        </div>
    </div> 

    {{-- RECENT BOOKINGS (DYNAMIC) --}}
    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-bold text-gray-900 text-lg">Recent Reservations</h4>
                <a href="{{ route('admin.reservations') }}" class="text-xs font-semibold text-blue-600 hover:underline">View All</a>
            </div>

            <div class="space-y-4">
                @forelse($Bookings as $booking)

<div class="flex items-center justify-between text-sm">
    <div class="flex items-center gap-3">

        @if($booking->booking_type == 'hotel')
            <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl font-bold text-base">
                🏨
            </div>
        @else
            <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold text-base">
                ✈️
            </div>
        @endif

        <div>

            @if($booking->booking_type == 'hotel')

                
                <p class="font-bold text-gray-800">
                    {{  $booking->guest_name ?? $booking->user->username }}
                </p>

                <p class="text-xs text-gray-400">
                    Accomodation • {{ $booking->id }}
                </p>

            @else

                @php
                $fullname = $booking->user->first_name . ' ' . $booking->user->last_name;
                @endphp
                <p class="font-bold text-gray-800">
                    {{ $booking->user->username ?? $fullname }}
                </p>

                <p class="text-xs text-gray-400">
                    Flight • {{ $booking->booking_code }}
                </p>

            @endif

        </div>
    </div>

    <div class="text-right">

        @if($booking->status == 'confirmed' || $booking->status == 'completed')
            <span class="block px-2 py-0.5 text-[10px] font-bold rounded-md bg-green-50 text-green-600 mb-1 uppercase">
                {{ $booking->status }}
            </span>

        @elseif($booking->status == 'pending')

            <span class="block px-2 py-0.5 text-[10px] font-bold rounded-md bg-orange-50 text-orange-600 mb-1 uppercase">
                Pending
            </span>

        @else

            <span class="block px-2 py-0.5 text-[10px] font-bold rounded-md bg-red-50 text-red-600 mb-1 uppercase">
                Cancelled
            </span>

        @endif

        <p class="font-bold text-gray-800">
    @if($booking->booking_type == 'hotel')
        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
    @else
        Rp {{ number_format($booking->payment->amount ?? 0, 0, ',', '.') }}
    @endif
</p>
    </div>
</div>

@empty
<p class="text-center text-gray-400 text-xs py-4">
    No recent bookings found.
</p>
@endforelse
            </div>
        </div>
    </div>
</div>

{{-- ALL RECENT TRANSACTIONS (DYNAMIC) --}}
<div class="bg-white rounded-[24px] shadow-sm border border-gray-50 p-6">
    <div class="flex justify-between items-center mb-6">
        <h4 class="font-bold text-gray-900 text-lg">All Recent Transactions</h4>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                    <th class="pb-3 font-semibold">Payment ID</th>
                    <th class="pb-3 font-semibold">Date</th>
                    <th class="pb-3 font-semibold">Amount</th>
                    <th class="pb-3 font-semibold text-right">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-50 font-medium text-gray-700">
                @forelse($RecentTrans as $trans)
                    <tr>
                        <td class="py-4 text-gray-800 font-bold">#TRX-{{ $trans->id }}</td>
                        <td class="py-4 text-gray-400">{{ optional($trans->created_at)->format('M d, Y') }}</td>
                        <td class="py-4 font-bold text-gray-800">Rp {{ number_format($trans->amount, 0, ',', '.') }}</td>
                        <td class="py-4 text-right">
                            {{-- Modifikasi badge status jika ada field status di table payments Anda --}}
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-50 text-green-500">
                                Paid
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-400">No transactions recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

 <script>
    const ctx = document.getElementById('revenueOverviewChart').getContext('2d');
    
    const chartGradient = ctx.createLinearGradient(0, 0, 0, 250);
    chartGradient.addColorStop(0, 'rgba(59, 130, 246, 0.15)');
    chartGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
           labels: @json($chartLabels),
            datasets: [{
                data: @json($chartData), 
                borderColor: '#3b82f6',
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: true,
                backgroundColor: chartGradient
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
    beginAtZero: true,
    ticks: {
        callback: function(value) {
            return 'Rp ' + value.toLocaleString('id-ID');
        },
        color: '#94a3b8',
        font: {
            size: 10
        }
    },
    grid: {
        color: '#f1f5f9'
    }
},
                x: {
                    ticks: { color: '#94a3b8', font: { size: 10 } },
                    grid: { display: false }
                }
            }
        }
    });
</script> 

@endsection