<?php
$pageTitle = 'StayGo - Deals';
$currentPage = 'promo';
require '_data.php';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?></head>
<body class="bg-background text-on-surface font-body-md antialiased">
<?php require '_nav.php'; ?>

<main class="pt-20">
  <!-- Hero -->
  <section class="bg-gradient-hero pt-24 pb-40 px-margin-mobile md:px-margin-desktop text-center">
    <div class="max-w-3xl mx-auto">
      <div class="inline-flex bg-primary text-on-primary font-label-sm px-4 py-1.5 rounded-full mb-6">Exclusive Offers</div>
      <h1 class="font-display text-display text-on-surface mb-6">Unlock Your Next Escape</h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant">Discover atmospheric travel experiences with our curated promotions.</p>
    </div>
  </section>

  <!-- Deals Grid -->
  <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop -mt-24 pb-32">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Card 1 -->
      <div class="bg-surface-container-lowest rounded-xl shadow-lg border border-surface-container-high overflow-hidden hover:-translate-y-2 transition">
        <div class="h-48 relative overflow-hidden">
          <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBOI9ZiuyScg8MVW2O0W2p8sFje4p2ZMFiv9Hn2Hhj5iQZwqcO4mjYEVvnP_r4Ht5kiA6mD-VsrE0J6NDwTQwBqP9hhnmKiCOPD0xIt2mAWc6w0-cGXtQ3B-VpSNuOwNRLXdsPgL1I3gtFsxRdqHEVMHiEjdV_blBMBkWd9qHQo4tvuB6CFe7nx25ALYUxxzz5DOrxm7QUfyqBUYeTq4OAzashKpA_PdUK4bhYdM7hoj0UoiQcMFqc8IEAhCA5SCXX_5Bg4DTgv4Pk" class="w-full h-full object-cover">
          <div class="absolute bottom-4 left-4"><span class="bg-surface-glass backdrop-blur-md text-primary px-3 py-1 rounded-full">Resorts</span></div>
        </div>
        <div class="p-8">
          <h2 class="text-4xl font-extrabold text-primary mb-2">25% OFF</h2>
          <h3 class="font-headline-md mb-3">Summer Breeze Getaway</h3>
          <p class="text-on-surface-variant mb-6">Escape to coastal paradise on minimum 3‑night stays at premium beachfront resorts.</p>
          <div class="flex items-center gap-2 text-on-surface-variant mb-6"><span class="material-symbols-outlined">calendar_today</span> Valid until Aug 31, 2025</div>
          <div class="dashed-border bg-surface-container-low p-4 rounded-2xl mb-6 flex justify-between items-center group">
            <div><p class="text-xs uppercase">Use Code</p><p class="font-headline-md tracking-widest">SUNSEEKER25</p></div>
            <button onclick="copyCode(this, 'SUNSEEKER25')" class="w-10 h-10 rounded-full bg-white shadow flex items-center justify-center"><span class="material-symbols-outlined">content_copy</span></button>
          </div>
        </div>
      </div>
      <!-- Card 2 (Flights) -->
      <div class="bg-surface-container-lowest rounded-xl shadow-lg border border-surface-container-high overflow-hidden hover:-translate-y-2 transition">
        <div class="h-48 relative overflow-hidden">
          <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuARDqPZga7KsG4I43qPJ7WczjCcPCk3TmFBaDeMzKc7Z7iFh_cjzfvAAPQj_MV0C0B1gLDZW4Il4LYLz2din7xmp7j2-j1hARBzeJrqnnYXrYKkoesc5jVYD8GqlkzdR7Cdl4s5DfKyVPSbH4GRagp3G1VOGyF87yzF76i_gdKPPtUqVzKdDdsN26SFx95JNychQalrlugXB3Mj2m3MgX-pCD-Opcc-lmFWZiG1lacPq3MTxzAWUlpl0UNcLXijV6mxmgjRTpsbvH8" class="w-full h-full object-cover">
          <div class="absolute bottom-4 left-4"><span class="bg-surface-glass backdrop-blur-md text-primary px-3 py-1 rounded-full">Flights</span></div>
        </div>
        <div class="p-8">
          <h2 class="text-4xl font-extrabold text-primary mb-2">$150 OFF</h2>
          <h3 class="font-headline-md mb-3">Long-Haul Luxury</h3>
          <p class="text-on-surface-variant mb-6">Upgrade your journey with instant discount on international business/first class.</p>
          <div class="flex items-center gap-2 text-on-surface-variant mb-6"><span class="material-symbols-outlined">calendar_today</span> Valid until Sep 15, 2025</div>
          <div class="dashed-border bg-surface-container-low p-4 rounded-2xl mb-6 flex justify-between items-center">
            <div><p class="text-xs uppercase">Use Code</p><p class="font-headline-md tracking-widest">ELEVATE150</p></div>
            <button onclick="copyCode(this, 'ELEVATE150')" class="w-10 h-10 rounded-full bg-white shadow flex items-center justify-center"><span class="material-symbols-outlined">content_copy</span></button>
          </div>
        </div>
      </div>
      <!-- Card 3 (City Breaks) -->
      <div class="bg-surface-container-lowest rounded-xl shadow-lg border border-surface-container-high overflow-hidden hover:-translate-y-2 transition">
        <div class="h-48 relative overflow-hidden">
          <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCqV8EoDVvxW4sCnxhdlzuXtWJtH0NtTDW7uQPeoytaWWtQYYyN7AU-_hqmk-LhTe-HRMZQUAMa8I3w_xMo69WSnBIh-G757KYTWaZh280Z9QRiD4gE9PEXH9h0FL5zsPkhm9tITsh7qJDeNaBBHPccCjCFsEn7e14fJEp5mHE5TMrOVu0H1vaZygsi_Vxm6bfKBsv04OJPLU4OJN1z6nhZUVzZaycDSYbu5zUE1PmiAwHLslIaGN4gCEUTEuAiLNa6cLYAgPz8rOM" class="w-full h-full object-cover">
          <div class="absolute bottom-4 left-4"><span class="bg-surface-glass backdrop-blur-md text-secondary px-3 py-1 rounded-full">City Breaks</span></div>
        </div>
        <div class="p-8">
          <h2 class="text-4xl font-extrabold text-on-surface mb-2">Free Night</h2>
          <h3 class="font-headline-md mb-3">Urban Explorer</h3>
          <p class="text-on-surface-variant mb-6">Book 3 nights at curated boutique city hotels, get the 4th night free.</p>
          <div class="flex items-center gap-2 text-on-surface-variant mb-6"><span class="material-symbols-outlined">calendar_today</span> Valid until Oct 31, 2025</div>
          <div class="dashed-border bg-surface-container-low p-4 rounded-2xl mb-6 flex justify-between items-center">
            <div><p class="text-xs uppercase">Use Code</p><p class="font-headline-md tracking-widest">URBANFREE</p></div>
            <button onclick="copyCode(this, 'URBANFREE')" class="w-10 h-10 rounded-full bg-white shadow flex items-center justify-center"><span class="material-symbols-outlined">content_copy</span></button>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require '_footer.php'; ?>
<script>
function copyCode(btn, code) {
  navigator.clipboard.writeText(code);
  const icon = btn.querySelector('span');
  icon.textContent = 'check';
  setTimeout(() => { icon.textContent = 'content_copy'; }, 2000);
}
</script>
<style>
.dashed-border { background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='16' ry='16' stroke='%23004ce2' stroke-width='2' stroke-dasharray='6%2c6' stroke-dashoffset='0' stroke-opacity='0.3'/%3e%3c/svg%3e"); border-radius: 16px; }
.bg-gradient-hero { background: linear-gradient(135deg, #e7eeff 0%, #f9f9ff 50%, #d8e3fb 100%); }
</style>
</body>
</html>