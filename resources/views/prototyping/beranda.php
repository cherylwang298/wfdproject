<?php
// BERANDA
?>


<!-- ═══════════════════ HOME PAGE CONTENT ═══════════════════ -->
<div id="page-home" class="page-section active">

<section class="hero" id="hero">
  <div class="hero-bg-blur">
    <div class="hero-blob hero-blob-1"></div>
    <div class="hero-blob hero-blob-2"></div>
    <div class="hero-blob hero-blob-3"></div>
  </div>
  <div class="hero-content">
    <div class="hero-badge">
      <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
      Dipercaya 150.000+ Traveler Indonesia
    </div>
    <h1 class="hero-title">Temukan <em>Surga</em><br>di Setiap Perjalanan</h1>
    <p class="hero-sub">Villa mewah, hotel butik, apartemen premium — dan penerbangan terbaik. Semua dalam satu platform.</p>
    <div style="max-width:780px;margin:0 auto">
      <div class="search-tab-wrap">
        <div class="search-tab active" id="st-stay" onclick="switchSearchTab('stay')">🏠 Staycation</div>
        <div class="search-tab" id="st-flight" onclick="switchSearchTab('flight')">✈️ Penerbangan</div>
      </div>
      <div id="sw-stay" class="search-box">
        <div class="search-inner">
          <div class="search-field"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg><div><div class="search-field-lbl">Tujuan</div><div class="search-field-val">Bali, Batu, Surabaya...</div></div></div>
          <div class="search-field"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg><div><div class="search-field-lbl">Check-in</div><div class="search-field-val">Pilih tanggal</div></div></div>
          <div class="search-field"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg><div><div class="search-field-lbl">Tamu</div><div class="search-field-val">2 Tamu</div></div></div>
          <button class="search-btn" onclick="scrollToProps()"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>Cari</button>
        </div>
      </div>
      <div id="sw-flight" class="search-box" style="display:none">
        <div class="search-inner" style="flex-wrap:wrap;gap:8px">
          <div class="search-field" style="flex:1;min-width:130px"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg><div><div class="search-field-lbl">Dari</div><div class="search-field-val">Surabaya (SUB)</div></div></div>
          <div class="search-field" style="flex:1;min-width:130px"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg><div><div class="search-field-lbl">Ke</div><div class="search-field-val">Bali (DPS)</div></div></div>
          <div class="search-field" style="flex:1;min-width:120px"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg><div><div class="search-field-lbl">Tanggal</div><div class="search-field-val">20 Jul 2026</div></div></div>
          <button class="search-btn" onclick="location.href='penerbangan.php'"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>Cari Penerbangan</button>
        </div>
      </div>
    </div>
  </div>
  <div class="hero-stats">
    <div style="text-align:center"><div class="hero-stat-val">350+</div><div class="hero-stat-lbl">Properti</div></div>
    <div style="width:1px;height:36px;background:rgba(255,255,255,.2)"></div>
    <div style="text-align:center"><div class="hero-stat-val">50+</div><div class="hero-stat-lbl">Destinasi</div></div>
    <div style="width:1px;height:36px;background:rgba(255,255,255,.2)"></div>
    <div style="text-align:center"><div class="hero-stat-val">4.9★</div><div class="hero-stat-lbl">Rating</div></div>
    <div style="width:1px;height:36px;background:rgba(255,255,255,.2)"></div>
    <div style="text-align:center"><div class="hero-stat-val">24/7</div><div class="hero-stat-lbl">Support</div></div>
  </div>
</section>

<section class="section section-alt" style="padding-top:64px;padding-bottom:64px">
  <div class="sec-head">
    <div>
      <div class="sec-tag">🎁 Penawaran Spesial</div>
      <div class="sec-title">Promo Terbaik Minggu Ini</div>
    </div>
    <span class="see-all" onclick="location.href='promo.php'">Lihat Semua <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
  </div>
  <div class="promo-grid" id="promoGrid"></div>
</section>

<section class="section" id="propSection">
  <div class="sec-head">
    <div>
      <div class="sec-tag"><svg viewBox="0 0 24 24" style="width:12px;height:12px;fill:var(--sky)"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg> Akomodasi</div>
      <div class="sec-title">Destinasi Populer</div>
      <div class="sec-sub">Villa, hotel & apartemen terpilih</div>
    </div>
    <span class="see-all" onclick="renderProps('semua')">Lihat Semua <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
  </div>
  <div class="chips" id="filterChips">
    <div class="chip active" data-filter="semua">Semua</div>
    <div class="chip" data-filter="villa">🏖 Villa</div>
    <div class="chip" data-filter="hotel">🏨 Hotel</div>
    <div class="chip" data-filter="apartment">🏢 Apartemen</div>
    <div class="chip" data-filter="bali">📍 Bali</div>
    <div class="chip" data-filter="batu">📍 Batu</div>
    <div class="chip" data-filter="surabaya">📍 Surabaya</div>
  </div>
  <div class="prop-grid" id="propGrid"></div>
</section>

<section class="section section-alt" style="padding-top:64px;padding-bottom:64px">
  <div class="sec-head">
    <div>
      <div class="sec-tag">✈️ Penerbangan</div>
      <div class="sec-title">Rute Populer</div>
      <div class="sec-sub">Tiket murah ke destinasi favorit</div>
    </div>
    <span class="see-all" onclick="location.href='penerbangan.php'">Cari Tiket <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
  </div>
  <div class="route-grid">
    <div class="route-card" onclick="location.href='penerbangan.php'"><img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400" alt="Bali"><div class="route-overlay"><div class="route-cities">SUB → DPS</div><div class="route-price">Mulai Rp 450.000</div></div></div>
    <div class="route-card" onclick="location.href='penerbangan.php'"><img src="https://images.unsplash.com/photo-1555899434-94d1368aa7af?w=400" alt="Jakarta"><div class="route-overlay"><div class="route-cities">SUB → CGK</div><div class="route-price">Mulai Rp 380.000</div></div></div>
    <div class="route-card" onclick="location.href='penerbangan.php'"><img src="https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=400" alt="Lombok"><div class="route-overlay"><div class="route-cities">SUB → LOP</div><div class="route-price">Mulai Rp 520.000</div></div></div>
    <div class="route-card" onclick="location.href='penerbangan.php'"><img src="https://images.unsplash.com/photo-1513415277900-a62401e19be4?w=400" alt="Jogja"><div class="route-overlay"><div class="route-cities">SUB → JOG</div><div class="route-price">Mulai Rp 290.000</div></div></div>
    <div class="route-card" onclick="location.href='penerbangan.php'"><img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400" alt="Makassar"><div class="route-overlay"><div class="route-cities">SUB → UPG</div><div class="route-price">Mulai Rp 610.000</div></div></div>
    <div class="route-card" onclick="location.href='penerbangan.php'"><img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400" alt="Medan"><div class="route-overlay"><div class="route-cities">SUB → KNO</div><div class="route-price">Mulai Rp 890.000</div></div></div>
  </div>
</section>

<section class="section">
  <div class="sec-head">
    <div>
      <div class="sec-tag">❤️ Ulasan</div>
      <div class="sec-title">Yang Mereka Rasakan</div>
    </div>
  </div>
  <div class="testi-grid">
    <div class="testi-card"><div class="testi-stars"> <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div><p class="testi-text">"Villa di Canggu yang saya pesan melalui StayGo benar-benar luar biasa. Kolam renang private, view sawah, dan staff yang sangat ramah. Pasti balik lagi!"</p><div class="testi-author"><img class="testi-avatar" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80" alt=""><div><div class="testi-name">Jessica Gabriel</div><div class="testi-role">Surabaya · Verified Guest</div></div></div></div>
    <div class="testi-card"><div class="testi-stars"> <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div><p class="testi-text">"Booking tiket pesawat + hotel sekaligus jadi sangat mudah. Promo BALI40 beneran kerja, hemat ratusan ribu! Prosesnya cepat dan konfirmasi langsung masuk."</p><div class="testi-author"><img class="testi-avatar" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80" alt=""><div><div class="testi-name">Ahmad Fauzi</div><div class="testi-role">Jakarta · Verified Guest</div></div></div></div>
    <div class="testi-card"><div class="testi-stars"> <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div><p class="testi-text">"Nusa Dua Cliffside Mansion adalah surga tersembunyi. Worth every rupiah! Tim StayGo juga sangat responsif ketika saya butuh bantuan perubahan jadwal."</p><div class="testi-author"><img class="testi-avatar" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80" alt=""><div><div class="testi-name">Sari Dewi</div><div class="testi-role">Bandung · Verified Guest</div></div></div></div>
  </div>
</section>

<div class="cta-section">
  <div class="cta-blob cta-blob-1"></div><div class="cta-blob cta-blob-2"></div>
  <div class="cta-title">Siap Mulai Petualangan?</div>
  <p class="cta-sub">Pesan sekarang dan dapatkan promo eksklusif untuk member baru</p>
  <div class="cta-btns">
    <button class="cta-btn-primary" onclick="scrollToProps()">Jelajahi Akomodasi</button>
    <button class="cta-btn-ghost" onclick="location.href='penerbangan.php'">Cari Tiket Pesawat</button>
  </div>
</div>

<footer class="footer">
  <div class="footer-grid">
    <div class="footer-brand"><a href="beranda.php" class="nav-logo"><div class="nav-logo-mark"><svg viewBox="0 0 24 24" style="fill:white"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div><div class="nav-logo-text" style="color:white">Stay<span style="color:#60a5fa">Go</span></div></a><p>Platform booking staycation & penerbangan terpercaya untuk traveler Indonesia.</p></div>
    <div class="footer-col"><h4>Layanan</h4><ul><li><a>Villa & Resort</a></li><li><a>Hotel</a></li><li><a>Apartemen</a></li><li><a>Tiket Pesawat</a></li></ul></div>
    <div class="footer-col"><h4>Destinasi</h4><ul><li><a>Bali</a></li><li><a>Batu, Malang</a></li><li><a>Surabaya</a></li><li><a>Lombok</a></li></ul></div>
    <div class="footer-col"><h4>Bantuan</h4><ul><li><a>Pusat Bantuan</a></li><li><a>Kebijakan Privasi</a></li><li><a>Syarat & Ketentuan</a></li><li><a>Kontak Kami</a></li></ul></div>
  </div>
  <div class="footer-bottom"><p>© 2026 StayGo. All rights reserved.</p><p>Made with ♥ for Indonesian Travelers</p></div>
</footer>

</div>

