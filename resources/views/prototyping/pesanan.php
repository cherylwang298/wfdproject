<?php
// PESANAN
?>

<div id="page-pesanan" class="page-section active" style="padding-top:68px;min-height:100vh;background:var(--bg3)">
<section class="section">
  <div class="sec-head">
    <div>
      <div class="sec-tag">📋 Riwayat</div>
      <div class="sec-title">Pesanan Saya</div>
    </div>
  </div>

  <div id="pesananGuestMsg" style="text-align:center;padding:60px 24px">
    <div style="font-size:48px;margin-bottom:16px">🔒</div>
    <div style="font-size:18px;font-weight:700;color:var(--ink);margin-bottom:8px">Login untuk Melihat Pesanan</div>
    <div style="font-size:14px;color:var(--muted);margin-bottom:24px">Masuk atau daftar akun untuk mulai memesan</div>
    <button class="btn-solid" onclick="openAuthModal('login')">Masuk Sekarang</button>
  </div>

  <div id="pesananContent" class="hidden">
    <div class="chips" id="pesananTabs">
      <div class="chip active" data-pt="all">Semua</div>
      <div class="chip" data-pt="accom">Akomodasi</div>
      <div class="chip" data-pt="flight">Penerbangan</div>
    </div>
    <div style="display:flex;flex-direction:column;gap:16px" id="pesananList"></div>
  </div>
</section>
</div>

