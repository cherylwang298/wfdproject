<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayGo Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
       <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f0f3fa] text-gray-800">
    <div class="flex h-screen overflow-hidden">
        
        <div class="w-64 bg-white flex flex-col justify-between border-r border-gray-100 rounded-r-[32px] my-4 ml-4 shadow-sm h-[calc(100vh-32px)]">
            <div>
                <div class="p-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600 text-[32px] icon-fill">flight_takeoff</span>
                    <span class="text-2xl font-bold text-[#1e293b]">Stay<span class="text-blue-600">Go</span></span>
                </div>

                <nav class="px-4 space-y-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-50 text-blue-600 font-semibold transition">
                        <span>📊</span> Dashboard
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition font-medium">
                        <span>📄</span> Bookings
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition font-medium">
                        <span>✈️</span> Flights
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition font-medium">
                        <span>🏢</span> Properties
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition font-medium">
                        <span>🏷️</span> Promos
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition font-medium">
                        <span>👥</span> Users
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img class="w-10 h-10 rounded-full border" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Admin">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Alex Jones</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
                <a href="/logout" class="text-red-400 hover:text-red-600 text-sm">➔</a>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden px-8 py-6">
            <header class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Overview</h1>
                </div>
                <div class="flex items-center gap-4">
                    <button class="p-2.5 bg-white rounded-full shadow-sm text-gray-500 hover:text-gray-700 border border-gray-100">
                        🔔
                    </button>
                    <img class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Admin avatar">
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto space-y-6 pr-2">
                @yield('content')
            </main>
        </div>

    </div>
</body>
</html>