<?php // _footer.php — shared footer ?>
<footer class="w-full rounded-t-3xl bg-on-surface mt-12 relative z-30 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
  <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-12 border-b border-surface/10 pb-12">
      <!-- Brand & Newsletter -->
      <div class="flex flex-col gap-6 lg:col-span-2">
        <a href="homepage.php" class="flex items-center gap-2">
          <span class="material-symbols-outlined text-primary-container text-[36px] icon-fill">flight_takeoff</span>
          <span class="font-display text-headline-lg font-extrabold text-surface">Stay<span class="text-primary-container">Go</span></span>
        </a>
        <p class="font-body-md text-body-md text-surface-dim max-w-md">Subscribe to our newsletter for travel inspiration, exclusive offers, and the latest news.</p>
        <div class="flex flex-col sm:flex-row gap-3">
          <input class="bg-surface/10 border border-surface/20 rounded-xl px-6 py-3 text-surface placeholder-surface-dim focus:outline-none focus:border-primary w-full max-w-[280px]" placeholder="Your email address" type="email">
          <button class="bg-primary text-on-primary px-6 py-3 rounded-xl hover:bg-primary-container hover:text-on-primary-container transition-colors font-label-md whitespace-nowrap">Subscribe</button>
        </div>
      </div>
      <!-- Company -->
      <div class="flex flex-col gap-4">
        <h4 class="font-label-md text-label-md text-surface font-bold uppercase tracking-wider">Company</h4>
        <div class="flex flex-col gap-3">
          <a class="font-body-md text-body-md text-surface-dim hover:text-secondary-fixed transition-colors" href="#">About Us</a>
          <a class="font-body-md text-body-md text-surface-dim hover:text-secondary-fixed transition-colors" href="#">Careers</a>
          <a class="font-body-md text-body-md text-surface-dim hover:text-secondary-fixed transition-colors" href="admin.php">Admin</a>
        </div>
      </div>
      <!-- Support -->
      <div class="flex flex-col gap-4">
        <h4 class="font-label-md text-label-md text-surface font-bold uppercase tracking-wider">Support</h4>
        <div class="flex flex-col gap-3">
          <a class="font-body-md text-body-md text-surface-dim hover:text-secondary-fixed transition-colors" href="#">Help Center</a>
          <a class="font-body-md text-body-md text-surface-dim hover:text-secondary-fixed transition-colors" href="#">Safety</a>
          <a class="font-body-md text-body-md text-surface-dim hover:text-secondary-fixed transition-colors" href="#">Cancellation Options</a>
        </div>
      </div>
      <!-- Contact & Social -->
      <div class="flex flex-col gap-4">
        <h4 class="font-label-md text-label-md text-surface font-bold uppercase tracking-wider">Contact Us</h4>
        <div class="flex flex-col gap-3">
          <a class="font-body-md text-body-md text-surface-dim hover:text-secondary-fixed transition-colors" href="#">hello@staygo.com</a>
          <a class="font-body-md text-body-md text-surface-dim hover:text-secondary-fixed transition-colors" href="#">+1 (555) 123-4567</a>
        </div>
        <div class="flex gap-3 mt-2">
          <a class="w-10 h-10 rounded-xl bg-surface/10 flex items-center justify-center text-surface hover:bg-primary transition-colors" href="#"><span class="material-symbols-outlined text-[20px] icon-fill">share</span></a>
          <a class="w-10 h-10 rounded-xl bg-surface/10 flex items-center justify-center text-surface hover:bg-primary transition-colors" href="#"><span class="material-symbols-outlined text-[20px] icon-fill">chat</span></a>
          <a class="w-10 h-10 rounded-xl bg-surface/10 flex items-center justify-center text-surface hover:bg-primary transition-colors" href="#"><span class="material-symbols-outlined text-[20px] icon-fill">photo_camera</span></a>
        </div>
      </div>
    </div>
    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
      <p class="font-body-md text-body-md text-surface-dim">© 2025 StayGo. All rights reserved.</p>
      <div class="flex flex-wrap justify-center gap-6">
        <a class="font-body-md text-body-md text-surface-dim hover:text-secondary-fixed transition-colors" href="#">Privacy Policy</a>
        <a class="font-body-md text-body-md text-surface-dim hover:text-secondary-fixed transition-colors" href="#">Terms &amp; Conditions</a>
        <a class="font-body-md text-body-md text-surface-dim hover:text-secondary-fixed transition-colors" href="#">Sitemap</a>
      </div>
    </div>
  </div>
</footer>