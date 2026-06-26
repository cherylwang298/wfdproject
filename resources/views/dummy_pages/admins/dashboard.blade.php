@extends('layouts.admin')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between items-start">
        <div>
            <p class="text-sm font-semibold text-gray-400">Total Bookings</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">{{$totalBookings}}</h3>
        </div>
        <div class="p-3 bg-blue-500 text-white rounded-2xl shadow-md shadow-blue-200">
            📅
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between items-start">
        <div>
            <p class="text-sm font-semibold text-gray-400">Monthly Revenue</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">$45,230</h3>
            <p class="text-xs text-green-500 mt-2 font-medium">↗ +8.5% <span class="text-gray-400">from last month</span></p>
        </div>
        <div class="p-3 bg-cyan-400 text-white rounded-2xl shadow-md shadow-cyan-100">
            💵
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex justify-between items-start">
        <div>
            <p class="text-sm font-semibold text-gray-400">Active Users</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">892</h3>
            <p class="text-xs text-gray-400 mt-2 font-medium">➔ Stable</p>
        </div>
        <div class="p-3 bg-gray-100 text-gray-500 rounded-2xl">
            👥
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 lg:col-span-2">
        <div class="flex justify-between items-center mb-6">
            <h4 class="font-bold text-gray-900 text-lg">Revenue Overview</h4>
            <select class="text-xs bg-gray-50 border border-gray-200 rounded-lg p-2 text-gray-500 focus:outline-none">
                <option>Last 7 Days</option>
                <option>Last Month</option>
            </select>
        </div>
        <div class="h-64 relative">
            <canvas id="revenueOverviewChart"></canvas>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-50 flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-bold text-gray-900 text-lg">Recent Bookings</h4>
                <a href="#" class="text-xs font-semibold text-blue-600 hover:underline">View All</a>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl font-bold text-base">🏨</div>
                        <div>
                            <p class="font-bold text-gray-800">Oceanview Villa</p>
                            <p class="text-xs text-gray-400">ID: #BK-0942</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block px-2 py-0.5 text-[10px] font-bold rounded-md bg-green-50 text-green-600 mb-1">CONFIRMED</span>
                        <p class="font-bold text-gray-800">$1,200</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold text-base">✈️</div>
                        <div>
                            <p class="font-bold text-gray-800">JFK to LHR</p>
                            <p class="text-xs text-gray-400">ID: #FL-8831</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block px-2 py-0.5 text-[10px] font-bold rounded-md bg-orange-50 text-orange-600 mb-1">PENDING</span>
                        <p class="font-bold text-gray-800">$850</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-purple-50 text-purple-600 rounded-xl font-bold text-base">🎡</div>
                        <div>
                            <p class="font-bold text-gray-800">City Tour Pass</p>
                            <p class="text-xs text-gray-400">ID: #EX-1102</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block px-2 py-0.5 text-[10px] font-bold rounded-md bg-green-50 text-green-600 mb-1">CONFIRMED</span>
                        <p class="font-bold text-gray-800">$120</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-sm border border-gray-50 p-6">
    <div class="flex justify-between items-center mb-6">
        <h4 class="font-bold text-gray-900 text-lg">All Recent Transactions</h4>
        <button class="p-2 bg-gray-50 border border-gray-100 text-gray-400 rounded-xl hover:text-gray-600">
            🎛️ Filter
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-xs font-bold text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                    <th class="pb-3 font-semibold">Order ID</th>
                    <th class="pb-3 font-semibold">Customer</th>
                    <th class="pb-3 font-semibold">Date</th>
                    <th class="pb-3 font-semibold">Amount</th>
                    <th class="pb-3 font-semibold">Status</th>
                    <th class="pb-3 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-50 font-medium text-gray-700">
                <tr>
                    <td class="py-4 text-gray-800 font-bold">#ORD-001</td>
                    <td class="py-4 text-gray-600">Sarah Jenkins</td>
                    <td class="py-4 text-gray-400">Oct 24, 2026</td>
                    <td class="py-4 font-bold text-gray-800">$1,450.00</td>
                    <td class="py-4">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-50 text-blue-500">Completed</span>
                    </td>
                    <td class="py-4 text-right">
                        <button class="text-gray-400 hover:text-blue-600 text-base">✏️</button>
                    </td>
                </tr>
                <tr>
                    <td class="py-4 text-gray-800 font-bold">#ORD-002</td>
                    <td class="py-4 text-gray-600">Michael Chen</td>
                    <td class="py-4 text-gray-400">Oct 23, 2026</td>
                    <td class="py-4 font-bold text-gray-800">$890.50</td>
                    <td class="py-4">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-orange-50 text-orange-400">Processing</span>
                    </td>
                    <td class="py-4 text-right">
                        <button class="text-gray-400 hover:text-blue-600 text-base">✏️</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    const ctx = document.getElementById('revenueOverviewChart').getContext('2d');
    
    // Efek Gradient di bawah garis grafik gelombang
    const chartGradient = ctx.createLinearGradient(0, 0, 0, 250);
    chartGradient.addColorStop(0, 'rgba(59, 130, 246, 0.15)');
    chartGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                data: [1200, 1900, 1500, 2200, 1800, 2800, 2400],
                borderColor: '#3b82f6',
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4, // Membuat garis gelombang mulus melengkung
                fill: true,
                backgroundColor: chartGradient
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false } // Sembunyikan label kotak atas bawaan
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
</script>

@endsection