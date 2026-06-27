<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayGo - Exclusive Deals</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
       
        .dashed-coupon-border {
            background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='16' ry='16' stroke='%232563eb' stroke-width='2' stroke-dasharray='6%2c6' stroke-dashoffset='0' stroke-opacity='0.3'/%3e%3c/svg%3e");
            border-radius: 16px;
        }
    </style>
</head>
<body class="bg-background text-on-surface antialiased min-h-screen flex flex-col">

@include('partials.navbar', ['currentPage' => 'promo'])

<main class="pt-20 flex-grow">
    <section class="bg-gradient-to-br from-blue-50 via-indigo-50/30 to-blue-100/50 pt-24 pb-40 px-6 md:px-16 text-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#2563eb_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <div class="max-w-3xl mx-auto relative z-10">
            <div class="inline-flex bg-blue-600 text-white text-xs font-bold uppercase tracking-wider px-4 py-1.5 rounded-full mb-6 shadow-sm">
                Exclusive Offers
            </div>
            <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">Unlock Your Next Escape</h1>
            <p class="text-md md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Discover atmospheric travel experiences with our curated promotions and limited-time discount vouchers.
            </p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 md:px-16 -mt-24 pb-32 w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($promos as $p)
                @php
                    // Normalisasi data objek Eloquent vs Array Fallback
                    $code = is_array($p) ? $p['code'] : $p->code;
                    $title = is_array($p) ? $p['title'] : ($p->title ?? 'Exclusive Discount Voucher');
                    $description = is_array($p) ? $p['description'] : ($p->description ?? 'Get extra cuts on your travel bookings using this voucher code.');
                    $category = is_array($p) ? $p['category'] : 'Special Deal';
                    $image = $p['image'] ?? 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=600';
                    $expiry = is_array($p) ? $p['expired_at'] : ($p->expired_at ? $p->expired_at->format('M d, Y') : 'Limited Time');
                    
                    // Format tampilan besaran nilai diskon dinamis
                    $type = is_array($p) ? $p['discount_type'] : $p->discount_type;
                    $val = is_array($p) ? $p['discount_value'] : $p->discount_value;
                    $discountText = $type === 'percentage' ? $val . '% OFF' : '$' . number_format($val);
                @endphp

                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:-translate-y-2 transition-all duration-300 flex flex-col group">
                    <div class="h-48 relative overflow-hidden bg-gray-100 shrink-0">
                        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-white/80 backdrop-blur-md text-blue-600 border border-white/40 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                {{ $category }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6 md:p-8 flex flex-col flex-grow justify-between gap-6">
                        <div>
                            <h2 class="text-3xl font-extrabold text-blue-600 mb-2 tracking-tight">{{ $discountText }}</h2>
                            <h3 class="text-lg font-bold text-gray-800 mb-3 leading-snug">{{ $title }}</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">{{ $description }}</p>
                        </div>
                        
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-2 text-xs font-medium text-gray-400">
                                <span class="material-symbols-outlined text-[16px]">calendar_today</span> 
                                <span>Valid until {{ $expiry }}</span>
                            </div>
                            
                            <div class="dashed-coupon-border bg-gray-50/50 p-4 flex justify-between items-center border border-transparent">
                                <div class="pl-1">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Use Voucher Code</p>
                                    <p class="text-lg font-extrabold text-gray-800 tracking-widest font-mono mt-0.5">{{ $code }}</p>
                                </div>
                                <button onclick="copyCode(this, '{{ $code }}')" 
                                        title="Click to copy code"
                                        class="w-10 h-10 rounded-full bg-white shadow-md border border-gray-100 text-gray-600 hover:text-blue-600 hover:scale-110 active:scale-95 flex items-center justify-center transition-all duration-200 focus:outline-none">
                                    <span class="material-symbols-outlined text-[18px]">content_copy</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</main>

@include('partials.footer')

<script>
   
    function copyCode(btn, code) {
        navigator.clipboard.writeText(code).then(() => {
            const icon = btn.querySelector('span');
            icon.textContent = 'check';
            icon.classList.add('text-green-600');
            
            // Kembalikan ke ikon salin semula setelah durasi delay 2 detik berlalu
            setTimeout(() => { 
                icon.textContent = 'content_copy'; 
                icon.classList.remove('text-green-600');
            }, 2000);
        }).catch(err => {
            console.error('Gagal menyalin teks kode kupon: ', err);
        });
    }
</script>
</body>
</html>