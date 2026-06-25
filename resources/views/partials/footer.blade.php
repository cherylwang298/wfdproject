<footer class="w-full rounded-t-3xl bg-neutral-900 mt-12 relative z-30 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] text-white" style="background-color: #171717;">
    <div class="max-w-7xl mx-auto px-6 md:px-16 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-12 border-b border-white/10 pb-12">
            
            <div class="flex flex-col gap-6 lg:col-span-2">
                <a href="{{ route('homepage') }}" class="flex items-center gap-2 w-fit">
                    <span class="material-symbols-outlined text-blue-400 text-[36px] icon-fill">flight_takeoff</span>
                    <span class="text-2xl font-extrabold tracking-tight">Stay<span class="text-blue-400">Go</span></span>
                </a>
                <p class="text-sm text-gray-400 max-w-md leading-relaxed">
                    Subscribe to our newsletter for travel inspiration, exclusive offers, and the latest news.
                </p>
                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input class="bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-full max-w-xs transition-colors" 
                           placeholder="Your email address" type="email" required>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-colors text-sm font-semibold whitespace-nowrap shadow-md">
                        Subscribe
                    </button>
                </form>
            </div>

            <div class="flex flex-col gap-4">
                <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400">Company</h4>
                <div class="flex flex-col gap-3 text-sm font-medium">
                    <a class="text-gray-400 hover:text-blue-400 transition-colors" href="#">About Us</a>
                    <a class="text-gray-400 hover:text-blue-400 transition-colors" href="#">Careers</a>
                    <a class="text-gray-400 hover:text-blue-400 transition-colors" href="#">Admin Portal</a>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400">Support</h4>
                <div class="flex flex-col gap-3 text-sm font-medium">
                    <a class="text-gray-400 hover:text-blue-400 transition-colors" href="#">Help Center</a>
                    <a class="text-gray-400 hover:text-blue-400 transition-colors" href="#">Safety Guidelines</a>
                    <a class="text-gray-400 hover:text-blue-400 transition-colors" href="#">Cancellation Options</a>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400">Contact Us</h4>
                <div class="flex flex-col gap-2 text-sm font-medium">
                    <a class="text-gray-400 hover:text-blue-400 transition-colors break-all" href="mailto:hello@staygo.com">hello@staygo.com</a>
                    <a class="text-gray-400 hover:text-blue-400 transition-colors" href="tel:+15551234567">+1 (555) 123-4567</a>
                </div>
                <div class="flex gap-3 mt-2">
                    <a aria-label="Share" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gray-300 hover:bg-blue-600 hover:text-white transition-colors border border-white/5 shadow-sm" href="#">
                        <span class="material-symbols-outlined text-[18px] icon-fill">share</span>
                    </a>
                    <a aria-label="Chat" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gray-300 hover:bg-blue-600 hover:text-white transition-colors border border-white/5 shadow-sm" href="#">
                        <span class="material-symbols-outlined text-[18px] icon-fill">chat</span>
                    </a>
                    <a aria-label="Instagram Gallery" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gray-300 hover:bg-blue-600 hover:text-white transition-colors border border-white/5 shadow-sm" href="#">
                        <span class="material-symbols-outlined text-[18px] icon-fill">photo_camera</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center gap-6 border-t border-white/5 pt-8 text-xs text-gray-500 font-medium">
            <p>© {{ date('Y') }} StayGo. All rights reserved.</p>
            <div class="flex flex-wrap justify-center gap-6">
                <a class="hover:text-blue-400 transition-colors" href="#">Privacy Policy</a>
                <a class="hover:text-blue-400 transition-colors" href="#">Terms &amp; Conditions</a>
                <a class="hover:text-blue-400 transition-colors" href="#">Sitemap</a>
            </div>
        </div>
    </div>
</footer>