<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayGo - Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .icon-fill { font-variation-settings: 'FILL' 1; }

        /* Sidebar slide transition */
        #sidebar {
            transition: transform 0.3s cubic-bezier(.4,0,.2,1);
        }

        /* ── MOBILE (<768px): drawer ── */
        @media (max-width: 767px) {
            #sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                z-index: 40;
                width: 240px;
                margin: 0;
                border-radius: 0 24px 24px 0;
                height: 100dvh;
                transform: translateX(-100%);
            }
            #sidebar.open {
                transform: translateX(0);
            }
            #main-content { padding-bottom: 72px; }
        }

        /* ── TABLET (768–1023px): icon-only sidebar ── */
        @media (min-width: 768px) and (max-width: 1023px) {
            #sidebar { width: 72px; }
            .sidebar-label,
            .brand-text,
            .user-info,
            .logout-btn { display: none; }
            #sidebar nav a { justify-content: center; padding-left: 0; padding-right: 0; }
            #sidebar .brand-area { justify-content: center; padding: 16px 8px; }
            #sidebar .user-area { justify-content: center; padding: 12px 8px; }
        }

        /* ── DESKTOP (≥1024px): full sidebar ── */
        @media (min-width: 1024px) {
            #sidebar { width: 256px; }
        }

        /* Hide bottom nav on non-mobile */
        @media (min-width: 768px) {
            #bottom-nav { display: none !important; }
            #hamburger-btn { display: none !important; }
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 99px; }
    </style>
</head>
<body class="bg-[#f0f3fa] text-gray-800">

    <!-- Overlay (mobile drawer backdrop) -->
    <div id="drawer-overlay"
         class="hidden fixed inset-0 bg-black/30 z-30"
         onclick="closeSidebar()">
    </div>

    <div class="flex h-screen overflow-hidden">


        <aside id="sidebar"
               class="bg-white flex flex-col justify-between border-r border-gray-100 rounded-r-[32px]
                      my-4 ml-4 shadow-sm h-[calc(100vh-32px)] flex-shrink-0">
            <div>
                <div class="brand-area p-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600 text-[28px] icon-fill flex-shrink-0">flight_takeoff</span>
                    <span class="brand-text text-xl font-bold text-[#1e293b] whitespace-nowrap">
                        Stay<span class="text-blue-600">Go</span>
                    </span>
                </div>

                <nav class="px-3 space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-3 rounded-xl transition
                              {{ Route::is('admin.dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                
                        <span class="sidebar-label">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.reservations') }}"
                       class="flex items-center gap-3 px-3 py-3 rounded-xl transition
                              {{ Route::is('admin.reservations') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                     
                        <span class="sidebar-label">Reservations</span>
                    </a>

                    <a href="{{ route('admin.cancel.requests') }}"
                       class="flex items-center gap-3 px-3 py-3 rounded-xl transition
                              {{ Route::is('admin.cancel.requests') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                     
                        <span class="sidebar-label">Cancel Requests</span>
                    </a>

                    <a href="{{ route('admin.promos') }}"
                       class="flex items-center gap-3 px-3 py-3 rounded-xl transition
                              {{ Route::is('admin.promos') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                       
                        <span class="sidebar-label">Promos</span>
                    </a>

                    <a href="{{ route('admin.users') }}"
                       class="flex items-center gap-3 px-3 py-3 rounded-xl transition
                              {{ Route::is('admin.users') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                       
                        <span class="sidebar-label">Users</span>
                    </a>
                </nav>
            </div>


            <div class="user-area p-4 border-t border-gray-50 flex items-center justify-between gap-2">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center
                                font-semibold text-blue-700 text-sm flex-shrink-0">
                        A
                    </div>
                    <div class="user-info min-w-0">
                        <p class="text-sm font-semibold text-gray-700 truncate">{{ $username }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="logout-btn flex-shrink-0">
                    @csrf
                    <button type="submit" class="text-red-400 hover:text-red-600 text-sm">➔</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden px-4 md:px-6 lg:px-8 py-4 md:py-6">

            <header class="flex justify-between items-center mb-5 md:mb-6">
                <div class="flex items-center gap-3">
                  
                    <button id="hamburger-btn"
                            onclick="openSidebar()"
                            class="p-2 rounded-xl bg-white border border-gray-100 shadow-sm
                                   text-gray-500 hover:text-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                </div>

          
            </header>

            {{-- Page content --}}
            <main id="main-content" class="flex-1 overflow-x-hidden overflow-y-auto space-y-6 pr-1">
                @yield('content')
            </main>
        </div>
    </div>

 

    @stack('modals')

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('drawer-overlay');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) closeSidebar();
        });
    </script>
</body>
</html>