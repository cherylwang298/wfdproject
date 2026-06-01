<?php
// PENERBANGAN
?>

<div id="page-flight" class="page-section active" style="padding-top:68px;min-height:100vh;background:var(--bg3)">
<section class="section">
  <div class="sec-head" style="margin-bottom:24px">
    <div>
      <div class="sec-tag">✈️ Penerbangan</div>
      <div class="sec-title">Cari Tiket Pesawat</div>
      <div class="sec-sub">Harga terbaik, penerbangan terpilih di seluruh Indonesia</div>
    </div>
  </div>

  <div class="flight-search">
    <div class="flight-type-tabs">
      <div class="flight-tab active" id="ft-sekali" onclick="toggleFlightType('sekali')">Sekali Jalan</div>
      <div class="flight-tab" id="ft-pp" onclick="toggleFlightType('pp')">Pulang-Pergi</div>
    </div>

    <div class="flight-fields">
      <div class="flight-field">
        <label>Dari</label>
        <svg class="flight-field-icon" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <input class="flight-input" id="fi-from" value="Surabaya (SUB)" placeholder="Kota asal">
      </div>

      <div style="display:flex;align-items:flex-end">
        <button class="swap-btn" onclick="swapAirports()" title="Tukar">
          <svg viewBox="0 0 24 24"><path d="M8 3l4 4-4 4"/><path d="M4 7h16"/><path d="M16 21l-4-4 4-4"/><path d="M20 17H4"/></svg>
        </button>
      </div>

      <div class="flight-field">
        <label>Ke</label>
        <svg class="flight-field-icon" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <input class="flight-input" id="fi-to" value="Bali (DPS)" placeholder="Kota tujuan">
      </div>

      <div class="flight-field">
        <label>Tanggal Berangkat</label>
        <svg class="flight-field-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <input class="flight-input" id="fi-date" type="date" value="2026-07-20">
      </div>

      <div class="flight-field">
        <label>Penumpang & Kelas</label>
        <svg class="flight-field-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        <select class="flight-pass-select" id="fi-pass">
          <option>1 Dewasa · Ekonomi</option>
          <option>2 Dewasa · Ekonomi</option>
          <option>1 Dewasa · Bisnis</option>
          <option>2 Dewasa · Bisnis</option>
          <option>1 Dewasa · First Class</option>
        </select>
      </div>

      <button class="flight-search-btn" onclick="searchFlights()">Cari Penerbangan</button>
    </div>

    <div id="returnDateField" class="flight-field" style="display:none;margin-top:16px;max-width:250px">
      <label>Tanggal Kembali</label>
      <svg class="flight-field-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      <input class="flight-input" id="fi-return" type="date" value="2026-07-24">
    </div>
  </div>

  <div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px">
      <div>
        <span style="font-size:20px;font-weight:700;color:var(--ink);font-family:'Cormorant Garamond',serif" id="flightResultTitle">Surabaya → Bali</span>
        <span style="font-size:13px;color:var(--muted);margin-left:10px" id="flightResultSub">Senin, 20 Jul 2026 · 8 penerbangan tersedia</span>
      </div>
      <div style="display:flex;gap:8px">
        <select style="padding:8px 14px;border-radius:10px;border:1.5px solid rgba(10,22,40,.1);font-size:13px;font-weight:600;color:var(--ink);background:white;font-family:'Plus Jakarta Sans',sans-serif;outline:none">
          <option>Harga Termurah</option>
          <option>Waktu Tercepat</option>
          <option>Keberangkatan Paling Pagi</option>
        </select>
        <select style="padding:8px 14px;border-radius:10px;border:1.5px solid rgba(10,22,40,.1);font-size:13px;font-weight:600;color:var(--ink);background:white;font-family:'Plus Jakarta Sans',sans-serif;outline:none">
          <option>Semua Maskapai</option>
          <option>Garuda Indonesia</option>
          <option>Lion Air</option>
          <option>Citilink</option>
          <option>Batik Air</option>
        </select>
      </div>
    </div>

    <div class="flight-result-wrap" id="flightResults"></div>
  </div>
</section>
</div>

