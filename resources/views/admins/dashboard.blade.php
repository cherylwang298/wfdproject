@extends('layouts.admin')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between items-start">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Bookings</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalBookings }}</h3>
        </div>
        <div class="p-3 bg-blue-500 text-white rounded-2xl shadow-md shadow-blue-200">
            📅
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between items-start">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Revenue</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($totalRev, 0, ',', '.') }}</h3>
        </div>
        <div class="p-3 bg-cyan-400 text-white rounded-2xl shadow-md shadow-cyan-100">
            💵
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between items-start">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Users</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUsers }}</h3>
        </div>
        <div class="p-3 bg-gray-100 text-gray-500 rounded-2xl">
            👥
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 my-6">
    
    {{-- CHART REVENUE
    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 lg:col-span-2">
        <div class="flex justify-between items-center mb-6">
            <h4 class="font-bold text-gray-900 text-lg">Revenue Overview</h4>
            <select class="text-xs bg-gray-50 border border-gray-200 rounded-lg p-2 text-gray-500 focus:outline-none">
                <option>Last 7 Days</option>
            </select>
        </div>
        <div class="h-64 relative">
            <canvas id="revenueOverviewChart"></canvas>
        </div>
    </div> --}}

    {{-- RECENT BOOKINGS (DYNAMIC) --}}
    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-bold text-gray-900 text-lg">Recent Bookings</h4>
                <a href="{{ route('admin.reservations') }}" class="text-xs font-semibold text-blue-600 hover:underline">View All</a>
            </div>

            <div class="space-y-4">
                @forelse($Bookings as $booking)
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl font-bold text-base">🏨</div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $booking->user->name ?? $booking->guest_name }}</p>
                                <p class="text-xs text-gray-400">ID: {{ $booking->booking_code }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @if($booking->status == 'confirmed' || $booking->status == 'completed')
                                <span class="block px-2 py-0.5 text-[10px] font-bold rounded-md bg-green-50 text-green-600 mb-1 uppercase">{{ $booking->status }}</span>
                            @elseif($booking->status == 'pending')
                                <span class="block px-2 py-0.5 text-[10px] font-bold rounded-md bg-orange-50 text-orange-600 mb-1 uppercase">PENDING</span>
                            @else
                                <span class="block px-2 py-0.5 text-[10px] font-bold rounded-md bg-red-50 text-red-600 mb-1 uppercase">CANCELLED</span>
                            @endif
                            <p class="font-bold text-gray-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-xs text-center py-4">No recent bookings found.</p>
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

{{-- <script>
    const ctx = document.getElementById('revenueOverviewChart').getContext('2d');
    
    const chartGradient = ctx.createLinearGradient(0, 0, 0, 250);
    chartGradient.addColorStop(0, 'rgba(59, 130, 246, 0.15)');
    chartGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                data: [1200, 1900, 1500, 2200, 1800, 2800, 2400], // Silakan modifikasi ini di masa depan jika grafik ingin dinamis
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
                    min: 0,
                    max: 3000,
                    ticks: {
                        stepSize: 500,
                        callback: function(value) { return '$' + value; },
                        color: '#94a3b8',
                        font: { size: 10 }
                    },
                    grid: { color: '#f1f5f9' },
                    border: { dash: [5, 5] }
                },
                x: {
                    ticks: { color: '#94a3b8', font: { size: 10 } },
                    grid: { display: false }
                }
            }
        }
    });
</script> --}}

@endsection