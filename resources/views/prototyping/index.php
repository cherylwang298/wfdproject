cat > /mnt/user-data/outputs/index.php << 'PHPEOF'
<?php
/**
 * ============================================================
 *  StayGo — Sistem Informasi Staycation & Penerbangan
 * ============================================================
 *
 *  PROPOSAL ANSWER (Format Tugas 2):
 *  ----------------------------------
 *  2. SPESIFIKASI SISTEM & RUANG LINGKUP
 *
 *  Autentikasi (Login):
 *    - Ada halaman landing (Home) sebelum login.
 *    - User bisa klik "Masuk" → modal login muncul.
 *    - Login pakai email + password.
 *    - Setelah login, navbar & fitur berubah sesuai role.
 *    - Demo: admin@staygo.id / admin123 | user@staygo.id / user123
 *
 *  Manajemen Data (CRUD) — 5 entitas:
 *    1. CRUD Properti  (Villa/Hotel/Apartemen)
 *    2. CRUD Penerbangan
 *    3. CRUD Pemesanan (Booking)
 *    4. CRUD Promo / Voucher
 *    5. CRUD User / Akun
 *
 *  Middleware Role — 2 peran:
 *    - ADMIN  : full CRUD semua entitas, dashboard statistik,
 *               kelola user, approve/reject booking.
 *    - USER   : browse properti & penerbangan, booking, lihat
 *               riwayat pesanan, edit profil sendiri.
 *    (Route admin hanya muncul bila currentUser.role === 'admin')
 *
 *  Integrasi API:
 *    - Menyediakan REST API internal (simulasi endpoint):
 *      GET/POST/PUT/DELETE /api/properties
 *      GET/POST/PUT/DELETE /api/flights
 *      GET/POST/PUT/DELETE /api/bookings
 *      GET/POST/PUT/DELETE /api/promos
 *      GET/POST/PUT/DELETE /api/users
 *    - Mengonsumsi API eksternal: Unsplash (foto properti),
 *      Open Exchange Rates (konversi harga opsional).
 *    - Semua API dilindungi Bearer Token (simulasi JWT).
 *
 *  Responsive Design:
 *    - CSS Framework: Tailwind-inspired custom CSS variables.
 *    - Breakpoint utama: 768px (mobile) & 1024px (tablet).
 *    - Bottom navigation bar muncul di mobile.
 *    - Semua grid berubah ke single-column di mobile.
 * ============================================================
 */
header('Content-Type: text/html; charset=utf-8');
$pageTitle   = 'StayGo — Staycation & Penerbangan';
$heroBadge   = 'Dipercaya 150.000+ Traveler Indonesia';
$heroHeading = 'Temukan <em>Surga</em><br>di Setiap Perjalanan';
$heroSub     = 'Villa mewah, hotel butik, apartemen premium — dan penerbangan terbaik. Semua dalam satu platform.';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --ink:#0a1628;--ink2:#1e3a5f;--ink3:#334e6e;--muted:#6b88a8;
  --sky:#2563EB;--sky2:#1d4ed8;--sky3:#3b82f6;
  --gold:#f59e0b;--gold2:#d97706;
  --green:#16a34a;--red:#dc2626;--purple:#7c3aed;
  --bg:#f0f6ff;--bg2:#e8f1fb;--bg3:#f8faff;
  --white:#ffffff;
  --radius:16px;--radius-sm:10px;--radius-lg:24px;
  --shadow:0 4px 24px rgba(10,22,40,.08);
  --shadow-lg:0 12px 48px rgba(10,22,40,.14);
  --shadow-xl:0 24px 80px rgba(10,22,40,.18);
  --admin-bg:#0f172a;--admin-sidebar:#1e293b;--admin-card:#1e293b;
}
html{scroll-behavior:smooth}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg3);color:var(--ink);line-height:1.5;overflow-x:hidden}
::-webkit-scrollbar{width:6px}
::-webkit-scrollbar-track{background:var(--bg)}
::-webkit-scrollbar-thumb{background:var(--sky3);border-radius:99px}

/* ── NAV ── */
.nav{position:fixed;top:0;left:0;right:0;z-index:900;display:flex;align-items:center;justify-content:space-between;padding:0 48px;height:68px;background:rgba(248,250,255,.88);backdrop-filter:blur(20px);border-bottom:1px solid rgba(37,99,235,.08);box-shadow:0 2px 20px rgba(10,22,40,.06)}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo-mark{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--sky),var(--sky2));display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(37,99,235,.3)}
.nav-logo-mark svg{width:20px;height:20px;fill:white}
.nav-logo-text{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700;color:var(--ink)}
.nav-logo-text span{color:var(--sky)}
.nav-links{display:flex;align-items:center;gap:28px}
.nav-links a{font-size:14px;font-weight:500;color:var(--ink3);text-decoration:none;transition:color .2s;position:relative;cursor:pointer}
.nav-links a:hover,.nav-links a.active{color:var(--sky)}
.nav-links a.active::after{content:'';position:absolute;bottom:-4px;left:0;right:0;height:2px;background:var(--sky);border-radius:99px}
.nav-actions{display:flex;align-items:center;gap:10px}
.btn-ghost{padding:7px 16px;border-radius:var(--radius-sm);font-size:13px;font-weight:600;color:var(--sky);background:transparent;border:1.5px solid var(--sky);cursor:pointer;transition:all .2s;font-family:'Plus Jakarta Sans',sans-serif}
.btn-ghost:hover{background:var(--sky);color:white}
.btn-solid{padding:7px 18px;border-radius:var(--radius-sm);font-size:13px;font-weight:700;color:white;background:var(--sky);border:none;cursor:pointer;transition:all .2s;font-family:'Plus Jakarta Sans',sans-serif;box-shadow:0 4px 14px rgba(37,99,235,.25)}
.btn-solid:hover{background:var(--sky2);transform:translateY(-1px)}
.btn-danger{padding:7px 16px;border-radius:var(--radius-sm);font-size:13px;font-weight:600;color:white;background:var(--red);border:none;cursor:pointer;transition:all .2s;font-family:'Plus Jakarta Sans',sans-serif}
.btn-danger:hover{background:#b91c1c}
.btn-green{padding:7px 16px;border-radius:var(--radius-sm);font-size:13px;font-weight:600;color:white;background:var(--green);border:none;cursor:pointer;transition:all .2s;font-family:'Plus Jakarta Sans',sans-serif}
.user-chip{display:flex;align-items:center;gap:8px;padding:6px 14px;border-radius:99px;background:var(--bg);border:1.5px solid rgba(37,99,235,.15);cursor:pointer;font-size:13px;font-weight:600;color:var(--ink);position:relative}
.user-chip .avatar{width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,var(--sky),var(--purple));display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:white}
.user-dropdown{position:absolute;top:calc(100% + 8px);right:0;min-width:200px;background:white;border-radius:var(--radius);box-shadow:var(--shadow-lg);border:1px solid rgba(10,22,40,.06);padding:8px;display:none;z-index:100}
.user-chip:hover .user-dropdown,.user-chip.open .user-dropdown{display:block}
.user-dropdown a{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;font-size:13px;color:var(--ink3);text-decoration:none;cursor:pointer;transition:background .15s}
.user-dropdown a:hover{background:var(--bg);color:var(--sky)}
.role-badge{display:inline-block;padding:2px 8px;border-radius:99px;font-size:10px;font-weight:700;background:#eff6ff;color:var(--sky);margin-left:auto}
.role-badge.admin{background:#fef3c7;color:#92400e}

/* ── HERO ── */
.hero{padding-top:68px;min-height:100vh;background:linear-gradient(160deg,#0a1628 0%,#0f2d5a 40%,#1e4d8c 70%,#2563eb 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;position:relative;overflow:hidden}
.hero-bg-blur{position:absolute;inset:0;pointer-events:none}
.hero-blob{position:absolute;border-radius:50%;background:radial-gradient(circle,rgba(37,99,235,.4) 0%,transparent 70%)}
.hero-blob-1{width:600px;height:600px;top:-150px;right:-150px;animation:blob 14s ease-in-out infinite}
.hero-blob-2{width:400px;height:400px;bottom:-100px;left:-100px;animation:blob 18s ease-in-out infinite reverse}
.hero-blob-3{width:300px;height:300px;top:40%;left:50%;animation:blob 10s ease-in-out infinite 2s}
@keyframes blob{0%,100%{transform:scale(1) translate(0,0)}50%{transform:scale(1.12) translate(20px,-20px)}}
.hero-content{position:relative;z-index:10;text-align:center;padding:0 24px;max-width:900px}
.hero-badge{display:inline-flex;align-items:center;gap:8px;padding:8px 18px;border-radius:99px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);backdrop-filter:blur(10px);font-size:12px;font-weight:600;color:rgba(255,255,255,.85);margin-bottom:28px;letter-spacing:.4px}
.hero-badge svg{width:14px;height:14px;fill:var(--gold)}
.hero-title{font-family:'Cormorant Garamond',serif;font-size:clamp(48px,7vw,82px);font-weight:700;color:white;line-height:1.05;margin-bottom:20px;text-shadow:0 4px 30px rgba(0,0,0,.3)}
.hero-title em{font-style:italic;color:var(--gold)}
.hero-sub{font-size:17px;font-weight:400;color:rgba(255,255,255,.7);margin-bottom:48px;max-width:560px;margin-left:auto;margin-right:auto}
.hero-stats{display:flex;align-items:center;justify-content:center;gap:48px;margin-top:40px}
.hero-stat-val{font-family:'Cormorant Garamond',serif;font-size:36px;font-weight:700;color:white}
.hero-stat-lbl{font-size:11px;font-weight:500;color:rgba(255,255,255,.55);text-transform:uppercase;letter-spacing:.8px}

/* ── SEARCH BOX ── */
.search-box{position:relative;z-index:10;background:rgba(255,255,255,.14);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.25);border-radius:var(--radius-lg);padding:6px;display:flex;align-items:stretch;gap:4px;max-width:780px;width:100%}
.search-tab-wrap{display:flex;background:rgba(255,255,255,.12);border-radius:14px;padding:4px;gap:2px;margin-bottom:8px}
.search-tab{flex:1;padding:9px 20px;border-radius:10px;font-size:13px;font-weight:600;color:rgba(255,255,255,.65);cursor:pointer;transition:all .2s;text-align:center}
.search-tab.active{background:white;color:var(--ink)}
.search-inner{display:flex;align-items:stretch;gap:4px;width:100%}
.search-field{flex:1;display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:12px;background:rgba(255,255,255,.92);cursor:pointer;transition:background .2s}
.search-field:hover{background:white}
.search-field svg{width:18px;height:18px;stroke:var(--sky);fill:none;stroke-width:2;flex-shrink:0}
.search-field-lbl{font-size:10px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.4px}
.search-field-val{font-size:13px;font-weight:600;color:var(--ink)}
.search-btn{padding:12px 28px;border-radius:12px;background:var(--sky);color:white;font-size:14px;font-weight:700;border:none;cursor:pointer;transition:all .2s;font-family:'Plus Jakarta Sans',sans-serif;display:flex;align-items:center;gap:8px;box-shadow:0 4px 16px rgba(37,99,235,.35);flex-shrink:0}
.search-btn:hover{background:var(--sky2)}
.search-btn svg{width:16px;height:16px;fill:white}

/* ── SECTIONS ── */
.section{padding:80px 48px}
.section-alt{background:var(--bg)}
@media(max-width:900px){.section{padding:60px 24px}}
.sec-tag{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;color:var(--sky);text-transform:uppercase;letter-spacing:.8px;margin-bottom:12px}
.sec-title{font-family:'Cormorant Garamond',serif;font-size:clamp(28px,3.5vw,42px);font-weight:700;color:var(--ink);line-height:1.15;margin-bottom:8px}
.sec-sub{font-size:15px;color:var(--muted);max-width:480px}
.sec-head{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:36px;gap:20px;flex-wrap:wrap}
.see-all{font-size:13px;font-weight:600;color:var(--sky);text-decoration:none;display:flex;align-items:center;gap:6px;flex-shrink:0;cursor:pointer}
.see-all:hover{color:var(--sky2)}
.see-all svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2}

/* ── CHIPS ── */
.chips{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:32px}
.chip{padding:8px 18px;border-radius:99px;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;border:1.5px solid rgba(37,99,235,.15);background:white;color:var(--ink3)}
.chip:hover{border-color:var(--sky);color:var(--sky)}
.chip.active{background:var(--sky);color:white;border-color:var(--sky);box-shadow:0 4px 12px rgba(37,99,235,.25)}

/* ── PROPERTY GRID ── */
.prop-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px}
.prop-card{background:white;border-radius:var(--radius);overflow:hidden;border:1px solid rgba(10,22,40,.05);box-shadow:var(--shadow);transition:all .3s;cursor:pointer}
.prop-card:hover{transform:translateY(-6px);box-shadow:var(--shadow-xl)}
.prop-card-img{width:100%;height:200px;object-fit:cover;display:block}
.prop-card-body{padding:16px}
.prop-card-tag{display:inline-block;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700;color:var(--sky);background:#eff6ff;margin-bottom:8px}
.prop-card-name{font-family:'Cormorant Garamond',serif;font-size:19px;font-weight:700;color:var(--ink);margin-bottom:6px;line-height:1.2}
.prop-card-loc{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:4px;margin-bottom:12px}
.prop-card-loc svg{width:11px;height:11px;fill:var(--sky);flex-shrink:0}
.prop-card-footer{display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--bg2);padding-top:12px;margin-top:4px}
.prop-card-price{font-size:16px;font-weight:700;color:var(--ink)}
.prop-card-price span{font-size:11px;font-weight:400;color:var(--muted)}
.prop-card-rating{display:flex;align-items:center;gap:4px;font-size:12px;font-weight:700;color:var(--gold2)}
.prop-card-rating svg{width:12px;height:12px;fill:var(--gold)}
.prop-card-fac{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px}
.prop-card-fac span{font-size:10px;padding:3px 8px;border-radius:6px;background:var(--bg);color:var(--ink3)}

/* ── PROMO ── */
.promo-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px}
.promo-card{position:relative;border-radius:var(--radius);overflow:hidden;height:160px;cursor:pointer;transition:all .3s}
.promo-card:hover{transform:scale(1.02);box-shadow:var(--shadow-xl)}
.promo-card img{width:100%;height:100%;object-fit:cover;display:block}
.promo-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,22,40,.7),rgba(37,99,235,.35));padding:20px;display:flex;flex-direction:column;justify-content:flex-end}
.promo-badge{display:inline-block;padding:3px 10px;border-radius:99px;background:var(--gold);color:white;font-size:9px;font-weight:800;letter-spacing:.5px;margin-bottom:6px;align-self:flex-start}
.promo-title{font-size:15px;font-weight:700;color:white;margin-bottom:2px}
.promo-code{font-size:11px;color:rgba(255,255,255,.75)}

/* ── FLIGHT ── */
.flight-search{background:white;border-radius:var(--radius-lg);padding:32px;border:1px solid rgba(10,22,40,.06);box-shadow:var(--shadow);margin-bottom:40px}
.flight-type-tabs{display:flex;gap:8px;margin-bottom:24px}
.flight-tab{padding:8px 20px;border-radius:99px;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;border:1.5px solid rgba(37,99,235,.15);background:white;color:var(--ink3)}
.flight-tab.active{background:var(--sky);color:white;border-color:var(--sky)}
.flight-fields{display:grid;grid-template-columns:1fr auto 1fr 1fr 1fr auto;gap:12px;align-items:end}
@media(max-width:900px){.flight-fields{grid-template-columns:1fr 1fr;gap:12px}}
.flight-field{position:relative}
.flight-field label{display:block;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px}
.flight-input,.flight-pass-select{width:100%;padding:12px 14px 12px 42px;border-radius:12px;border:1.5px solid rgba(10,22,40,.1);font-size:14px;font-weight:600;color:var(--ink);font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg3);transition:all .2s;outline:none;appearance:none}
.flight-input:focus,.flight-pass-select:focus{border-color:var(--sky);background:white}
.flight-field-icon{position:absolute;bottom:13px;left:14px;width:16px;height:16px;stroke:var(--sky);fill:none;stroke-width:2;stroke-linecap:round}
.swap-btn{width:44px;height:44px;border-radius:12px;background:var(--bg3);border:1.5px solid rgba(10,22,40,.08);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;align-self:flex-end;flex-shrink:0}
.swap-btn:hover{background:var(--sky);border-color:var(--sky)}
.swap-btn:hover svg{stroke:white}
.swap-btn svg{width:18px;height:18px;stroke:var(--sky);fill:none;stroke-width:2;stroke-linecap:round;transition:stroke .2s}
.flight-search-btn{padding:12px 32px;border-radius:12px;background:var(--sky);color:white;font-size:14px;font-weight:700;border:none;cursor:pointer;transition:all .2s;font-family:'Plus Jakarta Sans',sans-serif;box-shadow:0 4px 14px rgba(37,99,235,.3);align-self:flex-end;white-space:nowrap}
.flight-search-btn:hover{background:var(--sky2);transform:translateY(-1px)}
.flight-result-wrap{display:flex;flex-direction:column;gap:14px}
.flight-card{background:white;border-radius:var(--radius);padding:20px 24px;border:1.5px solid rgba(10,22,40,.06);box-shadow:var(--shadow);display:flex;align-items:center;gap:20px;transition:all .2s;cursor:pointer;flex-wrap:wrap}
.flight-card:hover{border-color:var(--sky);box-shadow:var(--shadow-lg);transform:translateY(-2px)}
.airline-logo{width:56px;height:48px;border-radius:12px;background:linear-gradient(135deg,var(--sky),var(--purple));display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:white;letter-spacing:.5px;flex-shrink:0}
.flight-times{display:flex;align-items:center;gap:16px;flex:1;min-width:250px}
.flight-time-block{text-align:center}
.flight-time{font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:700;color:var(--ink)}
.flight-airport{font-size:11px;color:var(--muted);font-weight:600}
.flight-line{flex:1;display:flex;flex-direction:column;align-items:center;gap:4px}
.flight-duration{font-size:11px;font-weight:600;color:var(--muted)}
.flight-track{width:100%;height:1px;background:rgba(10,22,40,.15);position:relative;display:flex;align-items:center;justify-content:center}
.flight-track-plane{font-size:14px}
.flight-airline{font-size:12px;font-weight:700;color:var(--ink)}
.flight-price{margin-left:auto;text-align:right;flex-shrink:0}
.flight-price-val{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:700;color:var(--sky)}
.flight-price-note{font-size:10px;color:var(--muted);margin-bottom:8px}
.flight-book-btn{padding:8px 20px;border-radius:10px;background:var(--sky);color:white;border:none;font-size:13px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s;box-shadow:0 4px 12px rgba(37,99,235,.25)}
.flight-book-btn:hover{background:var(--sky2);transform:translateY(-1px)}

/* ── ROUTE CARDS ── */
.route-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px}
.route-card{position:relative;border-radius:var(--radius);overflow:hidden;height:140px;cursor:pointer;transition:all .3s}
.route-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-xl)}
.route-card img{width:100%;height:100%;object-fit:cover;display:block}
.route-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(10,22,40,.8),transparent 50%);padding:14px;display:flex;flex-direction:column;justify-content:flex-end}
.route-cities{font-size:14px;font-weight:800;color:white}
.route-price{font-size:11px;color:rgba(255,255,255,.75);margin-top:2px}

/* ── TESTIMONIALS ── */
.testi-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px}
.testi-card{background:white;border-radius:var(--radius);padding:24px;border:1px solid rgba(10,22,40,.05);box-shadow:var(--shadow)}
.testi-stars{display:flex;gap:4px;margin-bottom:12px}
.testi-stars svg{width:14px;height:14px;fill:var(--gold)}
.testi-text{font-size:14px;color:var(--ink3);line-height:1.7;margin-bottom:16px;font-style:italic}
.testi-author{display:flex;align-items:center;gap:12px}
.testi-avatar{width:38px;height:38px;border-radius:50%;object-fit:cover}
.testi-name{font-size:13px;font-weight:700;color:var(--ink)}
.testi-role{font-size:11px;color:var(--muted)}

/* ── CTA ── */
.cta-section{background:linear-gradient(135deg,var(--ink2),var(--sky));padding:80px 48px;text-align:center;position:relative;overflow:hidden}
.cta-blob{position:absolute;border-radius:50%;background:rgba(255,255,255,.05)}
.cta-blob-1{width:500px;height:500px;top:-200px;right:-100px}
.cta-blob-2{width:300px;height:300px;bottom:-100px;left:-50px}
.cta-title{font-family:'Cormorant Garamond',serif;font-size:clamp(32px,5vw,52px);font-weight:700;color:white;margin-bottom:14px;position:relative;z-index:1}
.cta-sub{font-size:16px;color:rgba(255,255,255,.7);margin-bottom:36px;position:relative;z-index:1}
.cta-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;position:relative;z-index:1}
.cta-btn-primary{padding:14px 36px;border-radius:var(--radius-sm);background:white;color:var(--sky);font-size:15px;font-weight:700;border:none;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s}
.cta-btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.2)}
.cta-btn-ghost{padding:14px 36px;border-radius:var(--radius-sm);background:transparent;color:white;font-size:15px;font-weight:700;border:2px solid rgba(255,255,255,.5);cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s}
.cta-btn-ghost:hover{border-color:white;background:rgba(255,255,255,.1)}

/* ── FOOTER ── */
.footer{background:var(--ink);padding:56px 48px 28px;color:rgba(255,255,255,.6)}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:40px;margin-bottom:48px}
.footer-brand p{font-size:13px;margin-top:14px;line-height:1.7}
.footer-col h4{font-size:13px;font-weight:700;color:white;margin-bottom:16px}
.footer-col ul{list-style:none}
.footer-col ul li{margin-bottom:10px}
.footer-col ul li a{font-size:13px;color:rgba(255,255,255,.5);text-decoration:none;transition:color .2s;cursor:pointer}
.footer-col ul li a:hover{color:white}
.footer-bottom{border-top:1px solid rgba(255,255,255,.08);padding-top:24px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;font-size:12px}
@media(max-width:768px){.footer-grid{grid-template-columns:1fr;gap:24px}}

/* ── MODAL ── */
.modal-overlay{position:fixed;inset:0;background:rgba(10,22,40,.55);backdrop-filter:blur(8px);z-index:1000;display:none;align-items:center;justify-content:center;padding:24px;overflow-y:auto}
.modal-overlay.active{display:flex}
.modal-box{background:white;border-radius:var(--radius-lg);max-width:600px;width:100%;box-shadow:var(--shadow-xl);animation:modalIn .3s ease}
@keyframes modalIn{from{opacity:0;transform:scale(.94) translateY(20px)}to{opacity:1;transform:scale(1) translateY(0)}}
.modal-img-wrap{position:relative}
.modal-img{width:100%;height:260px;object-fit:cover;border-radius:var(--radius-lg) var(--radius-lg) 0 0;display:block}
.modal-close{position:absolute;top:16px;right:16px;width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.9);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 12px rgba(0,0,0,.15)}
.modal-close svg{width:16px;height:16px;stroke:var(--ink);fill:none;stroke-width:2.5;stroke-linecap:round}
.modal-body{padding:28px}
.modal-tag{display:inline-block;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700;color:var(--sky);background:#eff6ff;margin-bottom:10px}
.modal-title{font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:700;color:var(--ink);margin-bottom:8px}
.modal-loc{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:6px;margin-bottom:14px}
.modal-loc svg{width:13px;height:13px;stroke:var(--sky);fill:none;stroke-width:2}
.modal-fac{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px}
.modal-fac span{font-size:12px;padding:5px 10px;border-radius:8px;background:var(--bg);color:var(--ink3)}
.modal-desc{font-size:14px;color:var(--ink3);line-height:1.7;margin-bottom:20px}
.modal-price-row{display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--bg2);padding-top:20px}
.modal-price{font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:700;color:var(--sky)}
.modal-book-btn{padding:12px 28px;border-radius:var(--radius-sm);background:var(--sky);color:white;border:none;font-size:14px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s}
.modal-book-btn:hover{background:var(--sky2);transform:translateY(-1px)}

/* ── BOOKING FORM ── */
.fform-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
@media(max-width:600px){.fform-grid{grid-template-columns:1fr}}
.fform-field{display:flex;flex-direction:column;gap:8px}
.fform-field label{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px}
.fform-input{padding:12px 14px;border-radius:12px;border:1.5px solid rgba(10,22,40,.1);font-size:14px;font-weight:500;color:var(--ink);font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg3);outline:none;transition:all .2s;width:100%}
.fform-input:focus{border-color:var(--sky);background:white;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
.fform-submit{width:100%;padding:14px;border-radius:12px;background:var(--sky);color:white;font-size:15px;font-weight:700;border:none;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s;box-shadow:0 4px 16px rgba(37,99,235,.3)}
.fform-submit:hover{background:var(--sky2)}
.order-summary{background:var(--bg3);border-radius:var(--radius);padding:16px;margin-bottom:20px}
.order-row{display:flex;justify-content:space-between;font-size:13px;margin-bottom:8px;color:var(--ink3)}
.order-row:last-child{border-top:1px dashed rgba(10,22,40,.12);padding-top:12px;margin-top:4px;font-weight:700;color:var(--ink);font-size:15px}

/* ── PESANAN PAGE ── */
.pesanan-card{background:white;border-radius:var(--radius);padding:20px;border:1px solid rgba(10,22,40,.05);box-shadow:var(--shadow);display:flex;gap:16px;align-items:flex-start;flex-wrap:wrap}
.pesanan-img{width:100px;height:80px;border-radius:10px;object-fit:cover;flex-shrink:0}
.pesanan-info{flex:1;min-width:200px}
.pesanan-name{font-size:16px;font-weight:700;color:var(--ink);margin-bottom:6px}
.pesanan-detail{font-size:12px;color:var(--muted);margin-bottom:4px}
.pesanan-badge{display:inline-block;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700}
.pesanan-badge.confirmed{background:#f0fdf4;color:#16a34a}
.pesanan-badge.pending{background:#fef9c3;color:#a16207}
.pesanan-badge.cancelled{background:#fef2f2;color:#dc2626}
.pesanan-price{font-size:17px;font-weight:700;color:var(--sky);align-self:center;white-space:nowrap}
.pesanan-actions{display:flex;gap:8px;margin-top:8px}
.pesanan-actions button{padding:5px 12px;border-radius:8px;font-size:11px;font-weight:600;cursor:pointer;border:none;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s}
.btn-cancel-booking{background:#fee2e2;color:#dc2626}
.btn-cancel-booking:hover{background:#fca5a5}
.btn-review{background:#eff6ff;color:var(--sky)}
.btn-review:hover{background:#bfdbfe}

/* ── PROFIL PAGE ── */
.profil-wrap{max-width:700px;margin:0 auto}
.profil-card{background:white;border-radius:var(--radius-lg);padding:36px;box-shadow:var(--shadow);margin-bottom:24px}
.profil-header{display:flex;align-items:center;gap:20px;margin-bottom:28px;padding-bottom:24px;border-bottom:1px solid var(--bg2)}
.profil-avatar{width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--sky),var(--purple));display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:white;flex-shrink:0}
.profil-name{font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:700;color:var(--ink)}
.profil-email{font-size:13px;color:var(--muted);margin-top:4px}
.profil-role-badge{display:inline-block;padding:4px 12px;border-radius:99px;font-size:11px;font-weight:700;margin-top:8px}
.profil-role-badge.admin{background:#fef3c7;color:#92400e}
.profil-role-badge.user{background:#eff6ff;color:var(--sky)}
.profil-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px}
.profil-stat{text-align:center;padding:20px;background:var(--bg);border-radius:var(--radius)}
.profil-stat-val{font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:700;color:var(--sky)}
.profil-stat-lbl{font-size:11px;color:var(--muted);font-weight:600;margin-top:4px}

/* ── ADMIN PANEL ── */
.admin-wrap{display:grid;grid-template-columns:240px 1fr;min-height:100vh;background:var(--admin-bg)}
.admin-sidebar{background:var(--admin-sidebar);padding:24px 0;position:sticky;top:68px;height:calc(100vh - 68px);overflow-y:auto}
.admin-sidebar-brand{padding:0 24px 24px;border-bottom:1px solid rgba(255,255,255,.06);margin-bottom:16px}
.admin-sidebar-brand div{font-size:11px;color:rgba(255,255,255,.4);font-weight:600;text-transform:uppercase;letter-spacing:.8px;margin-top:4px}
.admin-nav{list-style:none}
.admin-nav li a{display:flex;align-items:center;gap:10px;padding:12px 24px;font-size:13px;font-weight:600;color:rgba(255,255,255,.5);text-decoration:none;cursor:pointer;transition:all .2s;border-left:3px solid transparent}
.admin-nav li a:hover{background:rgba(255,255,255,.04);color:rgba(255,255,255,.8)}
.admin-nav li a.active{background:rgba(37,99,235,.15);color:#60a5fa;border-left-color:#60a5fa}
.admin-nav li a svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0}
.admin-content{padding:40px;overflow-y:auto}
.admin-page-title{font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:700;color:white;margin-bottom:28px}
.admin-stats-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;margin-bottom:40px}
.admin-stat-card{background:var(--admin-card);border-radius:var(--radius);padding:24px;border:1px solid rgba(255,255,255,.06)}
.admin-stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px}
.admin-stat-icon svg{width:20px;height:20px;stroke:white;fill:none;stroke-width:2}
.admin-stat-val{font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:700;color:white;margin-bottom:4px}
.admin-stat-lbl{font-size:12px;color:rgba(255,255,255,.4);font-weight:600}
.admin-stat-delta{font-size:11px;font-weight:700;margin-top:6px}
.admin-stat-delta.up{color:#4ade80}
.admin-stat-delta.down{color:#f87171}
.admin-table-wrap{background:var(--admin-card);border-radius:var(--radius);border:1px solid rgba(255,255,255,.06);overflow:hidden;margin-bottom:24px}
.admin-table-head{display:flex;align-items:center;justify-content:space-between;padding:20px 24px;border-bottom:1px solid rgba(255,255,255,.06)}
.admin-table-head h3{font-size:15px;font-weight:700;color:white}
.admin-table-actions{display:flex;gap:8px}
.admin-search-input{padding:8px 14px;border-radius:10px;border:1px solid rgba(255,255,255,.1);background:rgba(255,255,255,.06);color:white;font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;outline:none;width:200px}
.admin-search-input::placeholder{color:rgba(255,255,255,.3)}
.admin-search-input:focus{border-color:rgba(37,99,235,.5);background:rgba(255,255,255,.08)}
.admin-add-btn{padding:8px 16px;border-radius:10px;background:var(--sky);color:white;border:none;font-size:13px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;display:flex;align-items:center;gap:6px;transition:all .2s}
.admin-add-btn:hover{background:var(--sky2)}
.admin-add-btn svg{width:14px;height:14px;stroke:white;fill:none;stroke-width:2.5}
table{width:100%;border-collapse:collapse}
th{text-align:left;padding:12px 24px;font-size:11px;font-weight:700;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.6px;border-bottom:1px solid rgba(255,255,255,.06)}
td{padding:14px 24px;font-size:13px;color:rgba(255,255,255,.7);border-bottom:1px solid rgba(255,255,255,.04)}
tr:last-child td{border-bottom:none}
tr:hover td{background:rgba(255,255,255,.02)}
.td-actions{display:flex;gap:6px}
.td-edit{padding:4px 10px;border-radius:6px;background:rgba(37,99,235,.2);color:#60a5fa;border:none;font-size:11px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s}
.td-edit:hover{background:rgba(37,99,235,.35)}
.td-del{padding:4px 10px;border-radius:6px;background:rgba(220,38,38,.2);color:#f87171;border:none;font-size:11px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s}
.td-del:hover{background:rgba(220,38,38,.35)}
.td-badge{display:inline-block;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700}
.td-badge.active{background:rgba(22,163,74,.2);color:#4ade80}
.td-badge.inactive{background:rgba(220,38,38,.2);color:#f87171}
.td-badge.confirmed{background:rgba(22,163,74,.2);color:#4ade80}
.td-badge.pending{background:rgba(245,158,11,.2);color:#fbbf24}
.td-badge.cancelled{background:rgba(220,38,38,.2);color:#f87171}
.admin-chart-wrap{background:var(--admin-card);border-radius:var(--radius);padding:24px;border:1px solid rgba(255,255,255,.06);margin-bottom:24px}
.admin-chart-wrap h3{font-size:15px;font-weight:700;color:white;margin-bottom:24px}
.chart-bar-group{display:flex;align-items:flex-end;gap:8px;height:160px}
.chart-bar-wrap{flex:1;display:flex;flex-direction:column;align-items:center;gap:8px}
.chart-bar{width:100%;border-radius:6px 6px 0 0;background:linear-gradient(to top,var(--sky),var(--sky3));min-height:4px;transition:height .5s ease}
.chart-bar:hover{background:linear-gradient(to top,var(--sky2),var(--sky))}
.chart-label{font-size:10px;color:rgba(255,255,255,.4);font-weight:600}
.chart-val{font-size:11px;color:rgba(255,255,255,.6);font-weight:600}
.admin-form-overlay{position:fixed;inset:0;background:rgba(0,0,0,.6);backdrop-filter:blur(8px);z-index:1100;display:none;align-items:center;justify-content:center;padding:24px}
.admin-form-overlay.active{display:flex}
.admin-form-box{background:#1e293b;border-radius:var(--radius-lg);max-width:540px;width:100%;box-shadow:0 32px 80px rgba(0,0,0,.5);border:1px solid rgba(255,255,255,.08);animation:modalIn .3s ease;max-height:90vh;overflow-y:auto}
.admin-form-header{padding:24px 28px;border-bottom:1px solid rgba(255,255,255,.06);display:flex;align-items:center;justify-content:space-between}
.admin-form-header h3{font-size:17px;font-weight:700;color:white}
.admin-form-close{width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.06);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.5)}
.admin-form-close:hover{background:rgba(255,255,255,.1);color:white}
.admin-form-body{padding:24px 28px}
.admin-field{margin-bottom:16px}
.admin-field label{display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px}
.admin-input{width:100%;padding:11px 14px;border-radius:10px;border:1px solid rgba(255,255,255,.1);background:rgba(255,255,255,.06);color:white;font-size:14px;font-family:'Plus Jakarta Sans',sans-serif;outline:none;transition:all .2s}
.admin-input:focus{border-color:rgba(37,99,235,.5);background:rgba(255,255,255,.08)}
.admin-input::placeholder{color:rgba(255,255,255,.25)}
.admin-form-footer{padding:0 28px 24px;display:flex;gap:10px;justify-content:flex-end}
.admin-save-btn{padding:10px 24px;border-radius:10px;background:var(--sky);color:white;border:none;font-size:14px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s}
.admin-save-btn:hover{background:var(--sky2)}
.admin-cancel-btn{padding:10px 24px;border-radius:10px;background:rgba(255,255,255,.06);color:rgba(255,255,255,.6);border:1px solid rgba(255,255,255,.1);font-size:14px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s}
.admin-cancel-btn:hover{background:rgba(255,255,255,.1);color:white}
.admin-section{display:none}
.admin-section.active{display:block}
@media(max-width:900px){.admin-wrap{grid-template-columns:1fr}.admin-sidebar{display:none}}

/* ── AUTH MODAL ── */
.auth-tabs{display:flex;gap:2px;background:var(--bg);border-radius:12px;padding:4px;margin-bottom:24px}
.auth-tab{flex:1;padding:9px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;text-align:center;color:var(--muted);transition:all .2s}
.auth-tab.active{background:white;color:var(--sky);box-shadow:var(--shadow)}
.auth-form{display:none}
.auth-form.active{display:block}
.auth-hint{font-size:12px;color:var(--muted);text-align:center;margin-top:16px}
.auth-hint span{color:var(--sky);cursor:pointer;font-weight:600}
.demo-accounts{background:var(--bg);border-radius:10px;padding:14px;margin-bottom:20px}
.demo-accounts p{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px}
.demo-btn{display:flex;justify-content:space-between;align-items:center;padding:8px 12px;border-radius:8px;background:white;border:1px solid rgba(37,99,235,.1);cursor:pointer;margin-bottom:6px;transition:all .2s;width:100%}
.demo-btn:hover{border-color:var(--sky);background:var(--bg)}
.demo-btn:last-child{margin-bottom:0}
.demo-btn span{font-size:12px;color:var(--ink3);font-weight:500}
.demo-btn strong{font-size:11px;font-weight:700;padding:2px 8px;border-radius:6px}
.demo-btn strong.admin-tag{background:#fef3c7;color:#92400e}
.demo-btn strong.user-tag{background:#eff6ff;color:var(--sky)}

/* ── PAGES ── */
.page-section{display:none}.page-section.active{display:block}
.bottom-nav{position:fixed;bottom:0;left:0;right:0;z-index:800;background:rgba(255,255,255,.94);backdrop-filter:blur(16px);border-top:1px solid rgba(10,22,40,.06);display:none;align-items:center;justify-content:center;height:64px}
.bnav-item{flex:1;max-width:80px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;cursor:pointer;transition:all .2s;padding:8px 0;color:var(--muted)}
.bnav-item.active{color:var(--sky)}
.bnav-item svg{width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round}
.bnav-label{font-size:9px;font-weight:600}
@media(max-width:768px){.nav{padding:0 20px}.nav-links{display:none}.bottom-nav{display:flex}}

/* ── TOAST ── */
.toast{position:fixed;bottom:80px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--ink);color:white;padding:12px 24px;border-radius:12px;font-size:13px;font-weight:600;opacity:0;transition:all .3s;z-index:2000;box-shadow:var(--shadow-xl);pointer-events:none;white-space:nowrap}
.toast.show{opacity:1;transform:translateX(-50%) translateY(0)}

/* ── UTILS ── */
.hidden{display:none!important}
</style>
</head>
<body>

<!-- ═══════════════════════════════════ NAV ═══════════════════════════════════ -->
<nav class="nav" id="mainNav">
  <a href="#" class="nav-logo" onclick="showPage('home');return false">
    <div class="nav-logo-mark">
      <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
    </div>
    <div class="nav-logo-text">Stay<span>Go</span></div>
  </a>
  <div class="nav-links">
    <a class="active" id="nl-home" onclick="showPage('home')">Beranda</a>
    <a id="nl-flight" onclick="showPage('flight')">Penerbangan</a>
    <a id="nl-pesanan" onclick="showPage('pesanan')">Pesanan Saya</a>
    <a id="nl-promo" onclick="showPage('promo')">Promo</a>
    <a id="nl-admin" class="hidden" onclick="showPage('admin')" style="color:var(--gold)">⚙ Admin</a>
  </div>
  <div class="nav-actions" id="navActions">
    <button class="btn-ghost" onclick="openAuthModal('login')">Masuk</button>
    <button class="btn-solid" onclick="openAuthModal('register')">Daftar</button>
  </div>
</nav>

<!-- ═══════════════════ HOME PAGE ═══════════════════ -->
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
      <?= htmlspecialchars($heroBadge, ENT_QUOTES, 'UTF-8') ?>
    </div>
    <h1 class="hero-title"><?= $heroHeading ?></h1>
    <p class="hero-sub"><?= htmlspecialchars($heroSub, ENT_QUOTES, 'UTF-8') ?></p>
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
          <button class="search-btn" onclick="showPage('flight')"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>Cari Penerbangan</button>
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
    <div><div class="sec-tag">🎁 Penawaran Spesial</div><div class="sec-title">Promo Terbaik Minggu Ini</div></div>
    <span class="see-all" onclick="showPage('promo')">Lihat Semua <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
  </div>
  <div class="promo-grid" id="promoGrid"></div>
</section>

<section class="section" id="propSection">
  <div class="sec-head">
    <div><div class="sec-tag"><svg viewBox="0 0 24 24" style="width:12px;height:12px;fill:var(--sky)"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg> Akomodasi</div><div class="sec-title">Destinasi Populer</div><div class="sec-sub">Villa, hotel & apartemen terpilih</div></div>
    <span class="see-all">Lihat Semua <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
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
    <div><div class="sec-tag">✈️ Penerbangan</div><div class="sec-title">Rute Populer</div><div class="sec-sub">Tiket murah ke destinasi favorit</div></div>
    <span class="see-all" onclick="showPage('flight')">Cari Tiket <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
  </div>
  <div class="route-grid">
    <div class="route-card" onclick="showPage('flight')"><img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400" alt="Bali"><div class="route-overlay"><div class="route-cities">SUB → DPS</div><div class="route-price">Mulai Rp 450.000</div></div></div>
    <div class="route-card" onclick="showPage('flight')"><img src="https://images.unsplash.com/photo-1555899434-94d1368aa7af?w=400" alt="Jakarta"><div class="route-overlay"><div class="route-cities">SUB → CGK</div><div class="route-price">Mulai Rp 380.000</div></div></div>
    <div class="route-card" onclick="showPage('flight')"><img src="https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=400" alt="Lombok"><div class="route-overlay"><div class="route-cities">SUB → LOP</div><div class="route-price">Mulai Rp 520.000</div></div></div>
    <div class="route-card" onclick="showPage('flight')"><img src="https://images.unsplash.com/photo-1513415277900-a62401e19be4?w=400" alt="Jogja"><div class="route-overlay"><div class="route-cities">SUB → JOG</div><div class="route-price">Mulai Rp 290.000</div></div></div>
    <div class="route-card" onclick="showPage('flight')"><img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400" alt="Makassar"><div class="route-overlay"><div class="route-cities">SUB → UPG</div><div class="route-price">Mulai Rp 610.000</div></div></div>
    <div class="route-card" onclick="showPage('flight')"><img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400" alt="Medan"><div class="route-overlay"><div class="route-cities">SUB → KNO</div><div class="route-price">Mulai Rp 890.000</div></div></div>
  </div>
</section>

<section class="section">
  <div class="sec-head"><div><div class="sec-tag">❤️ Ulasan</div><div class="sec-title">Yang Mereka Rasakan</div></div></div>
  <div class="testi-grid">
    <div class="testi-card"><div class="testi-stars"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div><p class="testi-text">"Villa di Canggu yang saya pesan melalui StayGo benar-benar luar biasa. Kolam renang private, view sawah, dan staff yang sangat ramah. Pasti balik lagi!"</p><div class="testi-author"><img class="testi-avatar" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80" alt=""><div><div class="testi-name">Jessica Gabriel</div><div class="testi-role">Surabaya · Verified Guest</div></div></div></div>
    <div class="testi-card"><div class="testi-stars"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div><p class="testi-text">"Booking tiket pesawat + hotel sekaligus jadi sangat mudah. Promo BALI40 beneran kerja, hemat ratusan ribu! Prosesnya cepat dan konfirmasi langsung masuk."</p><div class="testi-author"><img class="testi-avatar" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80" alt=""><div><div class="testi-name">Ahmad Fauzi</div><div class="testi-role">Jakarta · Verified Guest</div></div></div></div>
    <div class="testi-card"><div class="testi-stars"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div><p class="testi-text">"Nusa Dua Cliffside Mansion adalah surga tersembunyi. Worth every rupiah! Tim StayGo juga sangat responsif ketika saya butuh bantuan perubahan jadwal."</p><div class="testi-author"><img class="testi-avatar" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80" alt=""><div><div class="testi-name">Sari Dewi</div><div class="testi-role">Bandung · Verified Guest</div></div></div></div>
  </div>
</section>

<div class="cta-section">
  <div class="cta-blob cta-blob-1"></div><div class="cta-blob cta-blob-2"></div>
  <div class="cta-title">Siap Mulai Petualangan?</div>
  <p class="cta-sub">Pesan sekarang dan dapatkan promo eksklusif untuk member baru</p>
  <div class="cta-btns">
    <button class="cta-btn-primary" onclick="scrollToProps()">Jelajahi Akomodasi</button>
    <button class="cta-btn-ghost" onclick="showPage('flight')">Cari Tiket Pesawat</button>
  </div>
</div>

<footer class="footer">
  <div class="footer-grid">
    <div class="footer-brand"><a href="#" class="nav-logo" onclick="showPage('home');return false"><div class="nav-logo-mark"><svg viewBox="0 0 24 24" style="fill:white"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div><div class="nav-logo-text" style="color:white">Stay<span style="color:#60a5fa">Go</span></div></a><p>Platform booking staycation & penerbangan terpercaya untuk traveler Indonesia.</p></div>
    <div class="footer-col"><h4>Layanan</h4><ul><li><a>Villa & Resort</a></li><li><a>Hotel</a></li><li><a>Apartemen</a></li><li><a>Tiket Pesawat</a></li></ul></div>
    <div class="footer-col"><h4>Destinasi</h4><ul><li><a>Bali</a></li><li><a>Batu, Malang</a></li><li><a>Surabaya</a></li><li><a>Lombok</a></li></ul></div>
    <div class="footer-col"><h4>Bantuan</h4><ul><li><a>Pusat Bantuan</a></li><li><a>Kebijakan Privasi</a></li><li><a>Syarat & Ketentuan</a></li><li><a>Kontak Kami</a></li></ul></div>
  </div>
  <div class="footer-bottom"><p>© 2026 StayGo. All rights reserved.</p><p>Made with ♥ for Indonesian Travelers</p></div>
</footer>
</div><!-- end home page -->

<!-- ═══════════════════ FLIGHT PAGE ═══════════════════ -->
<div id="page-flight" class="page-section" style="padding-top:68px;min-height:100vh;background:var(--bg3)">
<section class="section">
  <div class="sec-head" style="margin-bottom:24px">
    <div><div class="sec-tag">✈️ Penerbangan</div><div class="sec-title">Cari Tiket Pesawat</div><div class="sec-sub">Harga terbaik, penerbangan terpilih di seluruh Indonesia</div></div>
  </div>
  <div class="flight-search">
    <div class="flight-type-tabs">
      <div class="flight-tab active" id="ft-sekali" onclick="toggleFlightType('sekali')">Sekali Jalan</div>
      <div class="flight-tab" id="ft-pp" onclick="toggleFlightType('pp')">Pulang-Pergi</div>
    </div>
    <div class="flight-fields">
      <div class="flight-field"><label>Dari</label><svg class="flight-field-icon" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg><input class="flight-input" id="fi-from" value="Surabaya (SUB)" placeholder="Kota asal"></div>
      <div style="display:flex;align-items:flex-end"><button class="swap-btn" onclick="swapAirports()" title="Tukar"><svg viewBox="0 0 24 24"><path d="M8 3l4 4-4 4"/><path d="M4 7h16"/><path d="M16 21l-4-4 4-4"/><path d="M20 17H4"/></svg></button></div>
      <div class="flight-field"><label>Ke</label><svg class="flight-field-icon" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg><input class="flight-input" id="fi-to" value="Bali (DPS)" placeholder="Kota tujuan"></div>
      <div class="flight-field"><label>Tanggal Berangkat</label><svg class="flight-field-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg><input class="flight-input" id="fi-date" type="date" value="2026-07-20"></div>
      <div class="flight-field"><label>Penumpang & Kelas</label><svg class="flight-field-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg><select class="flight-pass-select" id="fi-pass"><option>1 Dewasa · Ekonomi</option><option>2 Dewasa · Ekonomi</option><option>1 Dewasa · Bisnis</option><option>2 Dewasa · Bisnis</option><option>1 Dewasa · First Class</option></select></div>
      <button class="flight-search-btn" onclick="searchFlights()">Cari Penerbangan</button>
    </div>
    <div id="returnDateField" class="flight-field" style="display:none;margin-top:16px;max-width:250px"><label>Tanggal Kembali</label><svg class="flight-field-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg><input class="flight-input" id="fi-return" type="date" value="2026-07-24"></div>
  </div>
  <div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px">
      <div><span style="font-size:20px;font-weight:700;color:var(--ink);font-family:'Cormorant Garamond',serif" id="flightResultTitle">Surabaya → Bali</span><span style="font-size:13px;color:var(--muted);margin-left:10px" id="flightResultSub">Senin, 20 Jul 2026 · 8 penerbangan tersedia</span></div>
      <div style="display:flex;gap:8px">
        <select style="padding:8px 14px;border-radius:10px;border:1.5px solid rgba(10,22,40,.1);font-size:13px;font-weight:600;color:var(--ink);background:white;font-family:'Plus Jakarta Sans',sans-serif;outline:none"><option>Harga Termurah</option><option>Waktu Tercepat</option><option>Keberangkatan Paling Pagi</option></select>
        <select style="padding:8px 14px;border-radius:10px;border:1.5px solid rgba(10,22,40,.1);font-size:13px;font-weight:600;color:var(--ink);background:white;font-family:'Plus Jakarta Sans',sans-serif;outline:none"><option>Semua Maskapai</option><option>Garuda Indonesia</option><option>Lion Air</option><option>Citilink</option><option>Batik Air</option></select>
      </div>
    </div>
    <div class="flight-result-wrap" id="flightResults"></div>
  </div>
</section>
</div>

<!-- ═══════════════════ PROMO PAGE ═══════════════════ -->
<div id="page-promo" class="page-section" style="padding-top:68px;min-height:100vh;background:var(--bg3)">
<section class="section">
  <div class="sec-head"><div><div class="sec-tag">🎁 Promo</div><div class="sec-title">Semua Penawaran Spesial</div><div class="sec-sub">Hemat lebih banyak dengan kode promo eksklusif kami</div></div></div>
  <div class="promo-grid" id="promoGridFull" style="grid-template-columns:repeat(auto-fill,minmax(300px,1fr))"></div>
</section>
</div>

<!-- ═══════════════════ PESANAN PAGE ═══════════════════ -->
<div id="page-pesanan" class="page-section" style="padding-top:68px;min-height:100vh;background:var(--bg3)">
<section class="section">
  <div class="sec-head"><div><div class="sec-tag">📋 Riwayat</div><div class="sec-title">Pesanan Saya</div></div></div>
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

<!-- ═══════════════════ PROFIL PAGE ═══════════════════ -->
<div id="page-profil" class="page-section" style="padding-top:68px;min-height:100vh;background:var(--bg3)">
<section class="section">
  <div class="profil-wrap">
    <div class="profil-card">
      <div class="profil-header">
        <div class="profil-avatar" id="profilAvatar">U</div>
        <div>
          <div class="profil-name" id="profilName">Nama User</div>
          <div class="profil-email" id="profilEmail">email@contoh.com</div>
          <div class="profil-role-badge user" id="profilRoleBadge">👤 User</div>
        </div>
      </div>
      <div class="profil-stats">
        <div class="profil-stat"><div class="profil-stat-val" id="pStatBooking">0</div><div class="profil-stat-lbl">Total Booking</div></div>
        <div class="profil-stat"><div class="profil-stat-val" id="pStatConfirmed">0</div><div class="profil-stat-lbl">Terkonfirmasi</div></div>
        <div class="profil-stat"><div class="profil-stat-val" id="pStatSpent">0</div><div class="profil-stat-lbl">Juta Dipakai</div></div>
      </div>
      <div style="margin-bottom:20px"><div style="font-size:14px;font-weight:700;color:var(--ink);margin-bottom:16px">Edit Profil</div>
        <div class="fform-grid">
          <div class="fform-field"><label>Nama Lengkap</label><input class="fform-input" id="editName" placeholder="Nama lengkap"></div>
          <div class="fform-field"><label>Email</label><input class="fform-input" id="editEmail" type="email" placeholder="email@contoh.com"></div>
          <div class="fform-field"><label>No. Telepon</label><input class="fform-input" id="editPhone" placeholder="+62..."></div>
          <div class="fform-field"><label>Kota</label><input class="fform-input" id="editCity" placeholder="Surabaya"></div>
        </div>
        <button class="btn-solid" onclick="saveProfile()" style="margin-top:8px">Simpan Perubahan</button>
      </div>
      <div style="border-top:1px solid var(--bg2);padding-top:20px">
        <div style="font-size:14px;font-weight:700;color:var(--ink);margin-bottom:16px">Keamanan Akun</div>
        <div class="fform-grid">
          <div class="fform-field"><label>Password Lama</label><input class="fform-input" type="password" placeholder="••••••••"></div>
          <div class="fform-field"><label>Password Baru</label><input class="fform-input" type="password" placeholder="Min. 8 karakter"></div>
        </div>
        <button class="btn-ghost" style="margin-top:8px">Ubah Password</button>
      </div>
    </div>
    <div style="text-align:center"><button class="btn-danger" onclick="logout()">🚪 Logout</button></div>
  </div>
</section>
</div>

<!-- ═══════════════════ ADMIN PAGE ═══════════════════ -->
<div id="page-admin" class="page-section" style="padding-top:68px;min-height:100vh">
<div class="admin-wrap">
  <!-- SIDEBAR -->
  <aside class="admin-sidebar">
    <div class="admin-sidebar-brand">
      <div style="font-size:15px;font-weight:700;color:white">⚙ Admin Panel</div>
      <div>StayGo Management</div>
    </div>
    <ul class="admin-nav">
      <li><a class="active" onclick="switchAdminSection('dashboard')"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>Dashboard</a></li>
      <li><a onclick="switchAdminSection('properties')"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>Properti</a></li>
      <li><a onclick="switchAdminSection('flights')"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.86 13c-.43-1.87-.5-3.82-.12-5.72.24-1.2.94-2.26 1.9-2.96L8.18 3M22 16.92A19.79 19.79 0 0118.93 8.3"/></svg>Penerbangan</a></li>
      <li><a onclick="switchAdminSection('bookings')"><svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>Pemesanan</a></li>
      <li><a onclick="switchAdminSection('promos')"><svg viewBox="0 0 24 24"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>Promo</a></li>
      <li><a onclick="switchAdminSection('users')"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>Pengguna</a></li>
    </ul>
  </aside>

  <!-- CONTENT -->
  <main class="admin-content">
    <!-- DASHBOARD -->
    <div class="admin-section active" id="adm-dashboard">
      <div class="admin-page-title">Dashboard Overview</div>
      <div class="admin-stats-grid">
        <div class="admin-stat-card"><div class="admin-stat-icon" style="background:linear-gradient(135deg,var(--sky),var(--sky2))"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg></div><div class="admin-stat-val" id="adm-stat-prop">16</div><div class="admin-stat-lbl">Total Properti</div><div class="admin-stat-delta up">↑ 3 bulan ini</div></div>
        <div class="admin-stat-card"><div class="admin-stat-icon" style="background:linear-gradient(135deg,var(--purple),#9333ea)"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07"/></svg></div><div class="admin-stat-val" id="adm-stat-flight">8</div><div class="admin-stat-lbl">Rute Penerbangan</div><div class="admin-stat-delta up">↑ 2 rute baru</div></div>
        <div class="admin-stat-card"><div class="admin-stat-icon" style="background:linear-gradient(135deg,var(--green),#15803d)"><svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg></div><div class="admin-stat-val" id="adm-stat-booking">24</div><div class="admin-stat-lbl">Total Booking</div><div class="admin-stat-delta up">↑ 12% bulan ini</div></div>
        <div class="admin-stat-card"><div class="admin-stat-icon" style="background:linear-gradient(135deg,var(--gold),var(--gold2))"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87"/></svg></div><div class="admin-stat-val">6</div><div class="admin-stat-lbl">Promo Aktif</div><div class="admin-stat-delta up">↑ 2 promo baru</div></div>
        <div class="admin-stat-card"><div class="admin-stat-icon" style="background:linear-gradient(135deg,#ec4899,#be185d)"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div><div class="admin-stat-val" id="adm-stat-user">3</div><div class="admin-stat-lbl">Pengguna Terdaftar</div><div class="admin-stat-delta up">↑ 1 baru</div></div>
        <div class="admin-stat-card"><div class="admin-stat-icon" style="background:linear-gradient(135deg,#f97316,#ea580c)"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div><div class="admin-stat-val">124 Jt</div><div class="admin-stat-lbl">Total Pendapatan</div><div class="admin-stat-delta up">↑ 18% bulan ini</div></div>
      </div>
      <div class="admin-chart-wrap">
        <h3>📊 Booking per Bulan (2026)</h3>
        <div class="chart-bar-group" id="adminChart"></div>
      </div>
      <div class="admin-table-wrap">
        <div class="admin-table-head"><h3>📋 Booking Terbaru</h3></div>
        <table><thead><tr><th>ID</th><th>Tamu</th><th>Produk</th><th>Total</th><th>Status</th></tr></thead>
        <tbody id="recentBookingsTable"></tbody></table>
      </div>
    </div>

    <!-- PROPERTIES CRUD -->
    <div class="admin-section" id="adm-properties">
      <div class="admin-page-title">Manajemen Properti</div>
      <div class="admin-table-wrap">
        <div class="admin-table-head">
          <h3>🏠 Daftar Properti</h3>
          <div class="admin-table-actions">
            <input class="admin-search-input" placeholder="Cari properti..." oninput="filterAdminTable('propAdminTable',this.value)">
            <button class="admin-add-btn" onclick="openAdminForm('property',null)"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Tambah</button>
          </div>
        </div>
        <table><thead><tr><th>Nama</th><th>Tipe</th><th>Kota</th><th>Harga/malam</th><th>Rating</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody id="propAdminTable"></tbody></table>
      </div>
    </div>

    <!-- FLIGHTS CRUD -->
    <div class="admin-section" id="adm-flights">
      <div class="admin-page-title">Manajemen Penerbangan</div>
      <div class="admin-table-wrap">
        <div class="admin-table-head">
          <h3>✈️ Daftar Penerbangan</h3>
          <div class="admin-table-actions">
            <input class="admin-search-input" placeholder="Cari penerbangan..." oninput="filterAdminTable('flightAdminTable',this.value)">
            <button class="admin-add-btn" onclick="openAdminForm('flight',null)"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Tambah</button>
          </div>
        </div>
        <table><thead><tr><th>Maskapai</th><th>Kode</th><th>Rute</th><th>Harga</th><th>Kelas</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody id="flightAdminTable"></tbody></table>
      </div>
    </div>

    <!-- BOOKINGS CRUD -->
    <div class="admin-section" id="adm-bookings">
      <div class="admin-page-title">Manajemen Pemesanan</div>
      <div class="admin-table-wrap">
        <div class="admin-table-head">
          <h3>📋 Semua Pemesanan</h3>
          <div class="admin-table-actions">
            <input class="admin-search-input" placeholder="Cari booking..." oninput="filterAdminTable('bookingAdminTable',this.value)">
          </div>
        </div>
        <table><thead><tr><th>ID</th><th>Tamu</th><th>Produk</th><th>Tanggal</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody id="bookingAdminTable"></tbody></table>
      </div>
    </div>

    <!-- PROMOS CRUD -->
    <div class="admin-section" id="adm-promos">
      <div class="admin-page-title">Manajemen Promo</div>
      <div class="admin-table-wrap">
        <div class="admin-table-head">
          <h3>🎁 Daftar Promo</h3>
          <div class="admin-table-actions">
            <input class="admin-search-input" placeholder="Cari promo...">
            <button class="admin-add-btn" onclick="openAdminForm('promo',null)"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Tambah</button>
          </div>
        </div>
        <table><thead><tr><th>Kode</th><th>Judul</th><th>Diskon</th><th>Min. Transaksi</th><th>Berlaku s/d</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody id="promoAdminTable"></tbody></table>
      </div>
    </div>

    <!-- USERS CRUD -->
    <div class="admin-section" id="adm-users">
      <div class="admin-page-title">Manajemen Pengguna</div>
      <div class="admin-table-wrap">
        <div class="admin-table-head">
          <h3>👥 Daftar Pengguna</h3>
          <div class="admin-table-actions">
            <input class="admin-search-input" placeholder="Cari user...">
            <button class="admin-add-btn" onclick="openAdminForm('user',null)"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Tambah</button>
          </div>
        </div>
        <table><thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Total Booking</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody id="userAdminTable"></tbody></table>
      </div>
    </div>
  </main>
</div>
</div>

<!-- ═══════════════════ MODALS ═══════════════════ -->

<!-- PROPERTY MODAL -->
<div class="modal-overlay" id="propModal" onclick="closePropModal(event)">
  <div class="modal-box" style="position:relative">
    <div class="modal-img-wrap"><img class="modal-img" id="modalImg" src="" alt=""><button class="modal-close" onclick="document.getElementById('propModal').classList.remove('active')"><svg viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg></button></div>
    <div class="modal-body">
      <div class="modal-tag" id="modalTag"></div>
      <div class="modal-title" id="modalTitle"></div>
      <div class="modal-loc"><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg><span id="modalLoc"></span></div>
      <div class="modal-fac" id="modalFac"></div>
      <p class="modal-desc" id="modalDesc"></p>
      <div class="modal-price-row"><div class="modal-price" id="modalPrice"></div><button class="modal-book-btn" id="modalBookBtn">Pesan Sekarang →</button></div>
    </div>
  </div>
</div>

<!-- BOOKING FORM MODAL -->
<div class="modal-overlay" id="bookModal" onclick="if(event.target===this)this.classList.remove('active')">
  <div class="modal-box" style="position:relative;padding:32px">
    <button class="modal-close" style="position:absolute;top:16px;right:16px;z-index:10" onclick="document.getElementById('bookModal').classList.remove('active')"><svg viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    <div style="font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:700;color:var(--ink);margin-bottom:20px">📋 Form Pemesanan</div>
    <div class="order-summary" id="bookSummary"></div>
    <div class="fform-grid">
      <div class="fform-field"><label>Nama Lengkap</label><input class="fform-input" id="bk-name" placeholder="Sesuai KTP"></div>
      <div class="fform-field"><label>Email</label><input class="fform-input" id="bk-email" type="email" placeholder="email@contoh.com"></div>
      <div class="fform-field"><label>No. Telepon</label><input class="fform-input" id="bk-phone" placeholder="+62..."></div>
      <div class="fform-field"><label>Jumlah Tamu</label><select class="fform-input" id="bk-guests"><option>1 Tamu</option><option>2 Tamu</option><option>3 Tamu</option><option>4 Tamu</option></select></div>
      <div class="fform-field"><label>Check-in</label><input class="fform-input" id="bk-cin" type="date"></div>
      <div class="fform-field"><label>Check-out</label><input class="fform-input" id="bk-cout" type="date"></div>
    </div>
    <div class="fform-field" style="margin-bottom:20px"><label>Metode Pembayaran</label><select class="fform-input" id="bk-pay"><option>💳 Credit Card (Visa/Mastercard)</option><option>🏦 Bank Transfer (BCA/Mandiri/BNI)</option><option>📱 E-Wallet (GoPay/OVO/DANA)</option></select></div>
    <button class="fform-submit" onclick="confirmBooking()">✅ Konfirmasi & Bayar</button>
  </div>
</div>

<!-- FLIGHT BOOKING MODAL -->
<div class="modal-overlay" id="flightModal" onclick="if(event.target===this)this.classList.remove('active')">
  <div class="modal-box" style="position:relative;padding:32px">
    <button class="modal-close" style="position:absolute;top:16px;right:16px;z-index:10" onclick="document.getElementById('flightModal').classList.remove('active')"><svg viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    <div style="font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:700;color:var(--ink);margin-bottom:20px">✈️ Pesan Tiket</div>
    <div class="order-summary" id="fModalSummary"></div>
    <div style="background:white;border-radius:12px;padding:16px;border:1px solid var(--bg2);margin-bottom:20px" id="fModalDetail"></div>
    <div class="fform-grid">
      <div class="fform-field"><label>Nama Lengkap</label><input class="fform-input" id="fp-name" placeholder="Sesuai KTP/Paspor"></div>
      <div class="fform-field"><label>Email</label><input class="fform-input" id="fp-email" type="email" placeholder="email@contoh.com"></div>
      <div class="fform-field"><label>Nomor HP</label><input class="fform-input" id="fp-phone" placeholder="+62..."></div>
      <div class="fform-field"><label>No. KTP / Paspor</label><input class="fform-input" id="fp-id" placeholder="Nomor identitas"></div>
    </div>
    <div class="fform-field" style="margin-bottom:20px"><label>Metode Pembayaran</label><select class="fform-input" id="fp-pay"><option>💳 Credit Card (Visa/Mastercard)</option><option>🏦 Bank Transfer (BCA/Mandiri/BNI)</option><option>📱 E-Wallet (GoPay/OVO/DANA)</option></select></div>
    <button class="fform-submit" onclick="confirmFlightBooking()">✅ Konfirmasi & Bayar</button>
  </div>
</div>

<!-- AUTH MODAL -->
<div class="modal-overlay" id="authModal" onclick="if(event.target===this)this.classList.remove('active')">
  <div class="modal-box" style="padding:32px;max-width:440px">
    <button class="modal-close" style="position:absolute;top:16px;right:16px" onclick="document.getElementById('authModal').classList.remove('active')"><svg viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    <div style="font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:700;color:var(--ink);margin-bottom:8px">Selamat Datang 👋</div>
    <div style="font-size:13px;color:var(--muted);margin-bottom:20px">Masuk atau buat akun baru untuk mulai memesan</div>
    <div class="auth-tabs">
      <div class="auth-tab active" id="at-login" onclick="switchAuthTab('login')">Masuk</div>
      <div class="auth-tab" id="at-register" onclick="switchAuthTab('register')">Daftar</div>
    </div>
    <div class="demo-accounts">
      <p>Akun Demo</p>
      <button class="demo-btn" onclick="fillDemo('admin@staygo.id','admin123')"><span>admin@staygo.id / admin123</span><strong class="admin-tag">ADMIN</strong></button>
      <button class="demo-btn" onclick="fillDemo('user@staygo.id','user123')"><span>user@staygo.id / user123</span><strong class="user-tag">USER</strong></button>
    </div>
    <!-- Login Form -->
    <div class="auth-form active" id="af-login">
      <div class="fform-field" style="margin-bottom:14px"><label>Email</label><input class="fform-input" id="login-email" type="email" placeholder="email@contoh.com"></div>
      <div class="fform-field" style="margin-bottom:20px"><label>Password</label><input class="fform-input" id="login-pass" type="password" placeholder="••••••••"></div>
      <button class="fform-submit" onclick="doLogin()">Masuk</button>
      <div class="auth-hint">Belum punya akun? <span onclick="switchAuthTab('register')">Daftar sekarang</span></div>
    </div>
    <!-- Register Form -->
    <div class="auth-form" id="af-register">
      <div class="fform-field" style="margin-bottom:14px"><label>Nama Lengkap</label><input class="fform-input" id="reg-name" placeholder="Nama lengkap"></div>
      <div class="fform-field" style="margin-bottom:14px"><label>Email</label><input class="fform-input" id="reg-email" type="email" placeholder="email@contoh.com"></div>
      <div class="fform-field" style="margin-bottom:14px"><label>No. Telepon</label><input class="fform-input" id="reg-phone" placeholder="+62..."></div>
      <div class="fform-field" style="margin-bottom:20px"><label>Password</label><input class="fform-input" id="reg-pass" type="password" placeholder="Min. 8 karakter"></div>
      <button class="fform-submit" onclick="doRegister()">Buat Akun</button>
      <div class="auth-hint">Sudah punya akun? <span onclick="switchAuthTab('login')">Masuk</span></div>
    </div>
  </div>
</div>

<!-- ADMIN FORM MODAL -->
<div class="admin-form-overlay" id="adminFormOverlay" onclick="if(event.target===this)this.classList.remove('active')">
  <div class="admin-form-box">
    <div class="admin-form-header">
      <h3 id="adminFormTitle">Tambah Data</h3>
      <button class="admin-form-close" onclick="document.getElementById('adminFormOverlay').classList.remove('active')">✕</button>
    </div>
    <div class="admin-form-body" id="adminFormBody"></div>
    <div class="admin-form-footer">
      <button class="admin-cancel-btn" onclick="document.getElementById('adminFormOverlay').classList.remove('active')">Batal</button>
      <button class="admin-save-btn" onclick="saveAdminForm()">Simpan</button>
    </div>
  </div>
</div>

<!-- BOTTOM NAV (mobile) -->
<nav class="bottom-nav">
  <div class="bnav-item active" id="bn-home" onclick="showPage('home')"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg><span class="bnav-label">Beranda</span></div>
  <div class="bnav-item" id="bn-flight" onclick="showPage('flight')"><svg viewBox="0 0 24 24"><path d="M22 2L11 13"/><path d="M22 2L15 22l-4-9-9-4 22-7z"/></svg><span class="bnav-label">Terbang</span></div>
  <div class="bnav-item" id="bn-promo" onclick="showPage('promo')"><svg viewBox="0 0 24 24"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/></svg><span class="bnav-label">Promo</span></div>
  <div class="bnav-item" id="bn-pesanan" onclick="showPage('pesanan')"><svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg><span class="bnav-label">Pesanan</span></div>
  <div class="bnav-item" id="bn-profil" onclick="requireLoginThen(()=>showPage('profil'))"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span class="bnav-label">Profil</span></div>
</nav>

<div class="toast" id="toast"></div>

<script>
// ═══════════════════ DATABASES ═══════════════════

// CRUD 1: Properti
let propertyDB=[
  {id:"v-001",name:"Sky View Private Villa",type:"Villa & Balcony",category:"villa",city:"Batu",locationDetail:"Oro-Oro Ombo, Batu",pricePerNight:850000,rating:4.8,facilities:["🏊 Pool","🌅 Balcony","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=500",status:"active",desc:"Villa premium dengan pemandangan kota Batu yang spektakuler. Dilengkapi kolam renang private dan balkon luas."},
  {id:"v-002",name:"Green Pine Family Homestay",type:"Villa Rumah",category:"villa",city:"Batu",locationDetail:"Songgokerto, Batu",pricePerNight:620000,rating:4.6,facilities:["👪 Fam Room","🌳 Garden","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=500",status:"active",desc:"Homestay keluarga yang nyaman di lereng Gunung Arjuno. Cocok untuk liburan bersama keluarga besar."},
  {id:"v-003",name:"Canggu Bliss Luxury Villa",type:"Private Pool Villa",category:"villa",city:"Bali",locationDetail:"Canggu, Bali",pricePerNight:1850000,rating:4.9,facilities:["🏊 Pool","🌅 Balcony","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500",status:"active",desc:"Villa mewah di jantung Canggu dengan kolam renang infinity dan desain interior modern Bali."},
  {id:"v-004",name:"Ubud Rainforest Retreat",type:"Resort Villa",category:"villa",city:"Bali",locationDetail:"Sayan, Ubud, Bali",pricePerNight:2100000,rating:4.9,facilities:["🏊 Pool","🌳 Garden","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=500",status:"active",desc:"Retreat tersembunyi di tengah hutan hujan Ubud. Nikmati harmoni alam dan kemewahan dalam satu tempat."},
  {id:"v-005",name:"Seminyak Sun & Surf Villa",type:"Private Pool Villa",category:"villa",city:"Bali",locationDetail:"Seminyak, Kuta, Bali",pricePerNight:1650000,rating:4.7,facilities:["🏊 Pool","🌅 Balcony","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1512915922686-57c11dde9b6b?w=500",status:"active",desc:"Villa pantai dekat Seminyak beach. Parfait untuk menikmati sunset Bali yang iconic."},
  {id:"h-001",name:"The Grand Palace Hotel",type:"Luxury Hotel",category:"hotel",city:"Surabaya",locationDetail:"Genteng, Surabaya Pusat",pricePerNight:1200000,rating:4.8,facilities:["🏊 Pool","🏋 Gym","🍳 Breakfast"],imageUrl:"https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500",status:"active",desc:"Hotel bintang 5 di pusat kota Surabaya. Fasilitas kelas dunia termasuk spa, rooftop bar, dan restoran fine dining."},
  {id:"h-002",name:"Neo Horizon Business Hotel",type:"Business Hotel",category:"hotel",city:"Surabaya",locationDetail:"Gubeng, Surabaya",pricePerNight:650000,rating:4.5,facilities:["💻 Meeting Rm","🍳 Breakfast","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=500",status:"active",desc:"Hotel bisnis modern dengan fasilitas meeting room state-of-the-art. Lokasi strategis dekat pusat bisnis."},
  {id:"h-003",name:"Batu Heritage Resort",type:"Boutique Hotel",category:"hotel",city:"Batu",locationDetail:"Sisir, Kota Batu",pricePerNight:890000,rating:4.6,facilities:["🏊 Pool","🌳 Garden","🍳 Breakfast"],imageUrl:"https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500",status:"active",desc:"Boutique hotel dengan arsitektur heritage Belanda. Dikelilingi kebun teh dan pemandangan Gunung Arjuno."},
  {id:"a-001",name:"Ciputra World Residence",type:"Service Apartment",category:"apartment",city:"Surabaya",locationDetail:"Ciputra World, Surabaya",pricePerNight:750000,rating:4.5,facilities:["🏊 Pool","🏋 Gym","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=500",status:"active",desc:"Apartemen service premium di kawasan Ciputra World. Dilengkapi gym, rooftop pool, dan akses mall."},
];

// CRUD 2: Penerbangan
let flightDB=[
  {id:"f-001",airline:"Garuda Indonesia",logo:"GA",code:"GA-401",from:"Surabaya",fromCode:"SUB",to:"Bali",toCode:"DPS",depart:"06:00",arrive:"07:10",duration:"1j 10m",stops:"Langsung",price:850000,class:"Ekonomi",status:"active"},
  {id:"f-002",airline:"Lion Air",logo:"JT",code:"JT-712",from:"Surabaya",fromCode:"SUB",to:"Bali",toCode:"DPS",depart:"08:30",arrive:"09:40",duration:"1j 10m",stops:"Langsung",price:450000,class:"Ekonomi",status:"active"},
  {id:"f-003",airline:"Citilink",logo:"QG",code:"QG-156",from:"Surabaya",fromCode:"SUB",to:"Jakarta",toCode:"CGK",depart:"10:00",arrive:"11:30",duration:"1j 30m",stops:"Langsung",price:380000,class:"Ekonomi",status:"active"},
  {id:"f-004",airline:"Batik Air",logo:"ID",code:"ID-7204",from:"Surabaya",fromCode:"SUB",to:"Jakarta",toCode:"CGK",depart:"13:15",arrive:"14:45",duration:"1j 30m",stops:"Langsung",price:520000,class:"Ekonomi",status:"active"},
  {id:"f-005",airline:"Garuda Indonesia",logo:"GA",code:"GA-700",from:"Surabaya",fromCode:"SUB",to:"Bali",toCode:"DPS",depart:"15:30",arrive:"16:40",duration:"1j 10m",stops:"Langsung",price:920000,class:"Bisnis",status:"active"},
  {id:"f-006",airline:"Super Air Jet",logo:"IU",code:"IU-301",from:"Surabaya",fromCode:"SUB",to:"Lombok",toCode:"LOP",depart:"07:00",arrive:"08:15",duration:"1j 15m",stops:"Langsung",price:320000,class:"Ekonomi",status:"active"},
  {id:"f-007",airline:"AirAsia",logo:"QZ",code:"QZ-7956",from:"Surabaya",fromCode:"SUB",to:"Jogja",toCode:"JOG",depart:"17:45",arrive:"18:30",duration:"45m",stops:"Langsung",price:290000,class:"Ekonomi",status:"active"},
  {id:"f-008",airline:"Garuda Indonesia",logo:"GA",code:"GA-370",from:"Surabaya",fromCode:"SUB",to:"Makassar",toCode:"UPG",depart:"09:00",arrive:"10:50",duration:"1j 50m",stops:"Langsung",price:610000,class:"Ekonomi",status:"active"},
];

// CRUD 3: Pemesanan
let bookingDB=[
  {id:"B-001",guest:"Jessica Gabriel",type:"accom",product:"Canggu Bliss Luxury Villa",checkin:"2026-06-10",checkout:"2026-06-13",total:5550000,status:"confirmed",paymentMethod:"Credit Card",bookedAt:"2026-06-01T10:30:00",imageUrl:"https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500",villaName:"Canggu Bliss Luxury Villa"},
  {id:"B-002",guest:"Ahmad Fauzi",type:"flight",product:"Garuda Indonesia GA-401",airline:"Garuda Indonesia",flightCode:"GA-401",from:"Surabaya (SUB)",to:"Bali (DPS)",depart:"06:00",date:"2026-07-20",passenger:"2 Dewasa",total:1870000,status:"confirmed",paymentMethod:"Bank Transfer",bookedAt:"2026-06-15T14:00:00"},
  {id:"B-003",guest:"Sari Dewi",type:"accom",product:"The Grand Palace Hotel",checkin:"2026-06-20",checkout:"2026-06-22",total:2400000,status:"pending",paymentMethod:"E-Wallet",bookedAt:"2026-06-18T09:00:00",imageUrl:"https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500",villaName:"The Grand Palace Hotel"},
];

// CRUD 4: Promo / Voucher
let promoDB=[
  {id:"p-001",code:"BALI40",title:"Diskon Bali 40%",discount:"40%",minTx:1000000,validUntil:"2026-07-31",status:"active",imageUrl:"https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400",desc:"Hemat 40% untuk semua properti di Bali"},
  {id:"p-002",code:"FLASH50",title:"Flash Sale 50%",discount:"50%",minTx:500000,validUntil:"2026-06-30",status:"active",imageUrl:"https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400",desc:"Flash sale khusus akhir Juni"},
  {id:"p-003",code:"NEWUSER",title:"Pengguna Baru",discount:"25%",minTx:200000,validUntil:"2026-12-31",status:"active",imageUrl:"https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=400",desc:"Diskon 25% untuk pemesanan pertama"},
  {id:"p-004",code:"TERBANG30",title:"Tiket Hemat 30%",discount:"30%",minTx:400000,validUntil:"2026-08-15",status:"active",imageUrl:"https://images.unsplash.com/photo-1555899434-94d1368aa7af?w=400",desc:"Diskon tiket pesawat semua rute"},
  {id:"p-005",code:"WEEKEND20",title:"Promo Weekend",discount:"20%",minTx:300000,validUntil:"2026-09-30",status:"active",imageUrl:"https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=400",desc:"Booking Sabtu-Minggu lebih hemat"},
  {id:"p-006",code:"SURABAYA15",title:"Explore Surabaya",discount:"15%",minTx:500000,validUntil:"2026-10-31",status:"active",imageUrl:"https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400",desc:"Khusus properti di Surabaya"},
];

// CRUD 5: Users
let userDB=[
  {id:"u-001",name:"Admin StayGo",email:"admin@staygo.id",phone:"+628111111111",role:"admin",city:"Surabaya",totalBookings:0,status:"active",password:"admin123"},
  {id:"u-002",name:"Budi Santoso",email:"user@staygo.id",phone:"+628222222222",role:"user",city:"Surabaya",totalBookings:2,status:"active",password:"user123"},
  {id:"u-003",name:"Jessica Gabriel",email:"jessica@mail.com",phone:"+628333333333",role:"user",city:"Surabaya",totalBookings:1,status:"active",password:"jess123"},
];

// ═══════════════════ AUTH SYSTEM (Middleware Role) ═══════════════════
let currentUser = null;

function doLogin(){
  const email=document.getElementById('login-email').value.trim();
  const pass=document.getElementById('login-pass').value;
  const u=userDB.find(u=>u.email===email&&u.password===pass);
  if(!u){showToast('Email atau password salah!');return}
  currentUser=u;
  document.getElementById('authModal').classList.remove('active');
  updateNavForUser();
  showToast(`Selamat datang, ${u.name.split(' ')[0]}! 🎉`);
}

function doRegister(){
  const name=document.getElementById('reg-name').value.trim();
  const email=document.getElementById('reg-email').value.trim();
  const phone=document.getElementById('reg-phone').value.trim();
  const pass=document.getElementById('reg-pass').value;
  if(!name||!email||!pass){showToast('Isi semua field!');return}
  if(userDB.find(u=>u.email===email)){showToast('Email sudah terdaftar!');return}
  const newUser={id:'u-'+Date.now(),name,email,phone,role:'user',city:'',totalBookings:0,status:'active',password:pass};
  userDB.push(newUser);
  currentUser=newUser;
  document.getElementById('authModal').classList.remove('active');
  updateNavForUser();
  renderAdminUsers();
  showToast(`Akun berhasil dibuat! Selamat datang, ${name.split(' ')[0]}! 🎊`);
}

function logout(){
  currentUser=null;
  updateNavForUser();
  showPage('home');
  showToast('Berhasil logout. Sampai jumpa! 👋');
}

function updateNavForUser(){
  const actions=document.getElementById('navActions');
  const adminLink=document.getElementById('nl-admin');
  const pesananContent=document.getElementById('pesananContent');
  const pesananGuest=document.getElementById('pesananGuestMsg');
  if(currentUser){
    const initials=currentUser.name.split(' ').map(n=>n[0]).join('').substring(0,2).toUpperCase();
    const roleBadge=currentUser.role==='admin'?'<span class="role-badge admin">Admin</span>':'<span class="role-badge">User</span>';
    actions.innerHTML=`<div class="user-chip" tabindex="0">
      <div class="avatar">${initials}</div>
      ${currentUser.name.split(' ')[0]}
      ${roleBadge}
      <div class="user-dropdown">
        <a onclick="showPage('profil')">👤 Profil Saya</a>
        <a onclick="showPage('pesanan')">📋 Pesanan Saya</a>
        ${currentUser.role==='admin'?'<a onclick="showPage(\'admin\')" style="color:var(--gold)">⚙ Admin Panel</a>':''}
        <a onclick="logout()" style="color:var(--red)">🚪 Logout</a>
      </div>
    </div>`;
    // Middleware: admin-only route
    if(currentUser.role==='admin') adminLink.classList.remove('hidden');
    else adminLink.classList.add('hidden');
    if(pesananContent) pesananContent.classList.remove('hidden');
    if(pesananGuest) pesananGuest.classList.add('hidden');
    updateProfilPage();
    renderPesanan('all');
  } else {
    actions.innerHTML=`<button class="btn-ghost" onclick="openAuthModal('login')">Masuk</button><button class="btn-solid" onclick="openAuthModal('register')">Daftar</button>`;
    adminLink.classList.add('hidden');
    if(pesananContent) pesananContent.classList.add('hidden');
    if(pesananGuest) pesananGuest.classList.remove('hidden');
  }
}

function requireLoginThen(fn){
  if(!currentUser){openAuthModal('login');showToast('Silakan login terlebih dahulu');return}
  fn();
}

function openAuthModal(tab){
  document.getElementById('authModal').classList.add('active');
  switchAuthTab(tab);
}

function switchAuthTab(tab){
  document.getElementById('at-login').classList.toggle('active',tab==='login');
  document.getElementById('at-register').classList.toggle('active',tab==='register');
  document.getElementById('af-login').classList.toggle('active',tab==='login');
  document.getElementById('af-register').classList.toggle('active',tab==='register');
}

function fillDemo(email,pass){
  document.getElementById('login-email').value=email;
  document.getElementById('login-pass').value=pass;
  switchAuthTab('login');
  showToast('Akun demo diisi! Klik Masuk');
}

function updateProfilPage(){
  if(!currentUser) return;
  document.getElementById('profilAvatar').textContent=currentUser.name.split(' ').map(n=>n[0]).join('').substring(0,2).toUpperCase();
  document.getElementById('profilName').textContent=currentUser.name;
  document.getElementById('profilEmail').textContent=currentUser.email;
  const rb=document.getElementById('profilRoleBadge');
  rb.className='profil-role-badge '+(currentUser.role==='admin'?'admin':'user');
  rb.textContent=currentUser.role==='admin'?'⚙ Administrator':'👤 User';
  document.getElementById('editName').value=currentUser.name;
  document.getElementById('editEmail').value=currentUser.email;
  document.getElementById('editPhone').value=currentUser.phone||'';
  document.getElementById('editCity').value=currentUser.city||'';
  const myBookings=bookingDB.filter(b=>b.guest===currentUser.name);
  document.getElementById('pStatBooking').textContent=myBookings.length;
  document.getElementById('pStatConfirmed').textContent=myBookings.filter(b=>b.status==='confirmed').length;
  const spent=myBookings.reduce((s,b)=>s+b.total,0);
  document.getElementById('pStatSpent').textContent=(spent/1000000).toFixed(1);
}

function saveProfile(){
  if(!currentUser){showToast('Silakan login terlebih dahulu');return}
  currentUser.name=document.getElementById('editName').value;
  currentUser.email=document.getElementById('editEmail').value;
  currentUser.phone=document.getElementById('editPhone').value;
  currentUser.city=document.getElementById('editCity').value;
  updateNavForUser();
  updateProfilPage();
  showToast('Profil berhasil diperbarui! ✅');
}

// ═══════════════════ RENDER FUNCTIONS ═══════════════════

const fmt=n=>new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0,maximumFractionDigits:0}).format(n);

function renderProps(filter){
  const grid=document.getElementById('propGrid');
  let data=propertyDB;
  if(filter&&filter!=='semua'){
    data=propertyDB.filter(p=>p.category===filter||p.city.toLowerCase()===filter.toLowerCase());
  }
  grid.innerHTML=data.map(p=>`
    <div class="prop-card" onclick="openPropModal('${p.id}')">
      <img class="prop-card-img" src="${p.imageUrl}" alt="${p.name}" loading="lazy">
      <div class="prop-card-body">
        <div class="prop-card-tag">${p.type}</div>
        <div class="prop-card-name">${p.name}</div>
        <div class="prop-card-loc"><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>${p.city}</div>
        <div class="prop-card-fac">${p.facilities.map(f=>`<span>${f}</span>`).join('')}</div>
        <div class="prop-card-footer">
          <div class="prop-card-price">${fmt(p.pricePerNight)}<span>/malam</span></div>
          <div class="prop-card-rating"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>${p.rating}</div>
        </div>
      </div>
    </div>`).join('');
}

function renderPromos(){
  const mini=document.getElementById('promoGrid');
  const full=document.getElementById('promoGridFull');
  const html=promoDB.filter(p=>p.status==='active').map(p=>`
    <div class="promo-card" onclick="copyPromo('${p.code}')">
      <img src="${p.imageUrl}" alt="${p.title}" loading="lazy">
      <div class="promo-overlay">
        <div class="promo-badge">${p.discount} OFF</div>
        <div class="promo-title">${p.title}</div>
        <div class="promo-code">Kode: <strong>${p.code}</strong> · Min. ${fmt(p.minTx)}</div>
      </div>
    </div>`).join('');
  if(mini) mini.innerHTML=html;
  if(full) full.innerHTML=html;
}

function renderFlights(){
  document.getElementById('flightResults').innerHTML=flightDB.map(f=>`
    <div class="flight-card" onclick="openFlightModal('${f.id}')">
      <div class="airline-logo"><span style="font-size:11px;letter-spacing:.5px">${f.logo}</span></div>
      <div class="flight-times">
        <div class="flight-time-block"><div class="flight-time">${f.depart}</div><div class="flight-airport">${f.from} (${f.fromCode})</div></div>
        <div class="flight-line"><div class="flight-duration">${f.duration}</div><div class="flight-track"><div class="flight-track-plane">✈</div></div><div style="font-size:10px;color:var(--green);font-weight:600">${f.stops}</div></div>
        <div class="flight-time-block"><div class="flight-time">${f.arrive}</div><div class="flight-airport">${f.to} (${f.toCode})</div></div>
      </div>
      <div style="flex:1;min-width:120px"><div class="flight-airline">${f.airline}</div><div style="font-size:11px;color:var(--muted)">${f.code} · ${f.class}</div></div>
      <div class="flight-price"><div class="flight-price-note">/ orang</div><div class="flight-price-val">${fmt(f.price)}</div><button class="flight-book-btn" onclick="event.stopPropagation();openFlightModal('${f.id}')">Pilih →</button></div>
    </div>`).join('');
}

// ═══════════════════ MODALS ═══════════════════

let currentProp=null, currentFlight=null;

function openPropModal(id){
  const p=propertyDB.find(x=>x.id===id);
  if(!p) return;
  currentProp=p;
  document.getElementById('modalImg').src=p.imageUrl;
  document.getElementById('modalTag').textContent=p.type;
  document.getElementById('modalTitle').textContent=p.name;
  document.getElementById('modalLoc').textContent=p.locationDetail;
  document.getElementById('modalFac').innerHTML=p.facilities.map(f=>`<span>${f}</span>`).join('');
  document.getElementById('modalDesc').textContent=p.desc||'Nikmati pengalaman menginap yang luar biasa di properti premium kami.';
  document.getElementById('modalPrice').textContent=fmt(p.pricePerNight)+'/malam';
  document.getElementById('propModal').classList.add('active');
}

function closePropModal(e){if(e.target===document.getElementById('propModal'))document.getElementById('propModal').classList.remove('active')}

document.getElementById('modalBookBtn').addEventListener('click',()=>{
  if(!currentUser){openAuthModal('login');showToast('Login dulu untuk memesan');return}
  document.getElementById('propModal').classList.remove('active');
  document.getElementById('bookSummary').innerHTML=`
    <div style="font-size:13px;font-weight:700;color:var(--ink);margin-bottom:12px">${currentProp.name}</div>
    <div class="order-row"><span>Harga per malam</span><span>${fmt(currentProp.pricePerNight)}</span></div>
    <div class="order-row"><span>Perkiraan Total (2 malam)</span><span style="color:var(--sky)">${fmt(currentProp.pricePerNight*2)}</span></div>`;
  document.getElementById('bk-name').value=currentUser.name;
  document.getElementById('bk-email').value=currentUser.email;
  document.getElementById('bookModal').classList.add('active');
});

function confirmBooking(){
  const name=document.getElementById('bk-name').value.trim();
  const cin=document.getElementById('bk-cin').value;
  const cout=document.getElementById('bk-cout').value;
  if(!name||!cin||!cout){showToast('Lengkapi semua field!');return}
  const nights=Math.max(1,Math.round((new Date(cout)-new Date(cin))/(1000*60*60*24)));
  const total=currentProp.pricePerNight*nights;
  const booking={id:'B-'+Date.now(),guest:name,type:'accom',product:currentProp.name,checkin:cin,checkout:cout,total,status:'confirmed',paymentMethod:document.getElementById('bk-pay').value,bookedAt:new Date().toISOString(),imageUrl:currentProp.imageUrl,villaName:currentProp.name};
  bookingDB.unshift(booking);
  document.getElementById('bookModal').classList.remove('active');
  renderPesanan('all');
  renderAdminBookings();
  showToast(`Booking ${currentProp.name} berhasil! ✅`);
  setTimeout(()=>showPage('pesanan'),1500);
}

function openFlightModal(id){
  const f=flightDB.find(x=>x.id===id);
  if(!f) return;
  currentFlight=f;
  document.getElementById('fModalDetail').innerHTML=`
    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
      <div class="airline-logo"><span>${f.logo}</span></div>
      <div style="flex:1">
        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
          <div><div style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700">${f.depart}</div><div style="font-size:11px;color:var(--muted)">${f.from} (${f.fromCode})</div></div>
          <div style="flex:1;text-align:center"><div style="font-size:11px;color:var(--muted)">${f.duration}</div><div style="font-size:18px">→</div><div style="font-size:10px;color:var(--green);font-weight:600">${f.stops}</div></div>
          <div><div style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700">${f.arrive}</div><div style="font-size:11px;color:var(--muted)">${f.to} (${f.toCode})</div></div>
        </div>
      </div>
      <div style="text-align:right"><div style="font-size:13px;font-weight:700">${f.airline}</div><div style="font-size:11px;color:var(--muted)">${f.code} · ${f.class}</div></div>
    </div>`;
  document.getElementById('fModalSummary').innerHTML=`
    <div style="font-size:13px;font-weight:700;color:var(--ink);margin-bottom:12px">Ringkasan Harga</div>
    <div class="order-row"><span>Harga tiket</span><span>${fmt(f.price)}</span></div>
    <div class="order-row"><span>Pajak & Biaya</span><span>${fmt(Math.round(f.price*.1))}</span></div>
    <div class="order-row"><span>Total Pembayaran</span><span style="color:var(--sky)">${fmt(Math.round(f.price*1.1))}</span></div>`;
  if(currentUser){document.getElementById('fp-name').value=currentUser.name;document.getElementById('fp-email').value=currentUser.email;}
  document.getElementById('flightModal').classList.add('active');
}

function confirmFlightBooking(){
  if(!currentUser){document.getElementById('flightModal').classList.remove('active');openAuthModal('login');showToast('Login dulu untuk memesan');return}
  const name=document.getElementById('fp-name').value.trim();
  if(!name){showToast('Isi nama lengkap terlebih dahulu');return}
  const booking={id:'B-'+Date.now(),guest:name,type:'flight',product:currentFlight.airline+' '+currentFlight.code,airline:currentFlight.airline,flightCode:currentFlight.code,from:currentFlight.from+' ('+currentFlight.fromCode+')',to:currentFlight.to+' ('+currentFlight.toCode+')',depart:currentFlight.depart,date:'2026-07-20',passenger:'1 Dewasa',total:Math.round(currentFlight.price*1.1),status:'confirmed',paymentMethod:document.getElementById('fp-pay').value,bookedAt:new Date().toISOString()};
  bookingDB.unshift(booking);
  document.getElementById('flightModal').classList.remove('active');
  renderPesanan('all');
  renderAdminBookings();
  showToast(`Tiket ${currentFlight.airline} berhasil dipesan! ✈`);
  setTimeout(()=>showPage('pesanan'),1500);
}

// ═══════════════════ PESANAN ═══════════════════

function renderPesanan(filter){
  const wrap=document.getElementById('pesananList');
  if(!wrap||!currentUser) return;
  let list=bookingDB.filter(b=>b.guest===currentUser.name);
  if(filter!=='all') list=list.filter(b=>b.type===(filter==='flight'?'flight':'accom'));
  if(list.length===0){wrap.innerHTML=`<div style="text-align:center;padding:60px;color:var(--muted);font-size:15px">Belum ada pesanan</div>`;return}
  wrap.innerHTML=list.map(b=>`
    <div class="pesanan-card">
      ${b.type==='accom'?`<img class="pesanan-img" src="${b.imageUrl||''}" alt="">`:
        `<div class="airline-logo" style="flex-shrink:0;width:60px;height:50px;border-radius:10px"><span>${(b.airline||'').substring(0,2).toUpperCase()}</span></div>`}
      <div class="pesanan-info">
        <div class="pesanan-name">${b.type==='accom'?b.villaName:b.airline+' · '+b.flightCode}</div>
        <div class="pesanan-detail">${b.type==='accom'?`📅 ${b.checkin} → ${b.checkout}`:`✈ ${b.from} → ${b.to} · ${b.depart} · ${b.date}`}</div>
        <div class="pesanan-detail">💳 ${b.paymentMethod}</div>
        <div class="pesanan-detail" style="margin-top:4px">Dipesan: ${new Date(b.bookedAt).toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'})}</div>
        <span class="pesanan-badge ${b.status}">${b.status==='confirmed'?'✓ Terkonfirmasi':b.status==='pending'?'⏳ Menunggu':'✕ Dibatalkan'}</span>
        ${b.status!=='cancelled'?`<div class="pesanan-actions"><button class="btn-cancel-booking" onclick="cancelBooking('${b.id}')">Batalkan</button><button class="btn-review">Beri Ulasan</button></div>`:''}
      </div>
      <div class="pesanan-price">${fmt(b.total)}</div>
    </div>`).join('');
}

function cancelBooking(id){
  const b=bookingDB.find(x=>x.id===id);
  if(b){b.status='cancelled';renderPesanan('all');renderAdminBookings();showToast('Booking dibatalkan');}
}

document.getElementById('pesananTabs').addEventListener('click',e=>{
  const c=e.target.closest('.chip');if(!c)return;
  document.querySelectorAll('#pesananTabs .chip').forEach(x=>x.classList.remove('active'));
  c.classList.add('active');
  renderPesanan(c.dataset.pt);
});

// ═══════════════════ ADMIN CRUD ═══════════════════

function renderAdminProps(){
  document.getElementById('propAdminTable').innerHTML=propertyDB.map((p,i)=>`
    <tr data-search="${p.name.toLowerCase()} ${p.city.toLowerCase()}">
      <td style="font-weight:600;color:white">${p.name}</td><td>${p.type}</td><td>${p.city}</td>
      <td>${fmt(p.pricePerNight)}</td><td>⭐ ${p.rating}</td>
      <td><span class="td-badge ${p.status}">${p.status==='active'?'Aktif':'Nonaktif'}</span></td>
      <td><div class="td-actions"><button class="td-edit" onclick="openAdminForm('property','${p.id}')">Edit</button><button class="td-del" onclick="deleteItem('property','${p.id}')">Hapus</button></div></td>
    </tr>`).join('');
  document.getElementById('adm-stat-prop').textContent=propertyDB.length;
}

function renderAdminFlights(){
  document.getElementById('flightAdminTable').innerHTML=flightDB.map(f=>`
    <tr data-search="${f.airline.toLowerCase()} ${f.code.toLowerCase()}">
      <td style="font-weight:600;color:white">${f.airline}</td><td>${f.code}</td>
      <td>${f.from} → ${f.to}</td><td>${fmt(f.price)}</td><td>${f.class}</td>
      <td><span class="td-badge ${f.status}">${f.status==='active'?'Aktif':'Nonaktif'}</span></td>
      <td><div class="td-actions"><button class="td-edit" onclick="openAdminForm('flight','${f.id}')">Edit</button><button class="td-del" onclick="deleteItem('flight','${f.id}')">Hapus</button></div></td>
    </tr>`).join('');
  document.getElementById('adm-stat-flight').textContent=flightDB.length;
}

function renderAdminBookings(){
  document.getElementById('bookingAdminTable').innerHTML=bookingDB.map(b=>`
    <tr data-search="${b.guest.toLowerCase()} ${b.product.toLowerCase()}">
      <td style="font-size:11px;color:rgba(255,255,255,.4)">${b.id}</td>
      <td style="font-weight:600;color:white">${b.guest}</td><td>${b.product}</td>
      <td style="font-size:11px">${new Date(b.bookedAt).toLocaleDateString('id-ID')}</td>
      <td>${fmt(b.total)}</td>
      <td><span class="td-badge ${b.status}">${b.status==='confirmed'?'Terkonfirmasi':b.status==='pending'?'Menunggu':'Dibatalkan'}</span></td>
      <td><div class="td-actions">
        ${b.status==='pending'?`<button class="td-edit" onclick="approveBooking('${b.id}')">Approve</button>`:''}
        <button class="td-del" onclick="deleteItem('booking','${b.id}')">Hapus</button>
      </div></td>
    </tr>`).join('');
  document.getElementById('adm-stat-booking').textContent=bookingDB.length;
  // Update recent bookings table
  const recent=document.getElementById('recentBookingsTable');
  if(recent) recent.innerHTML=bookingDB.slice(0,5).map(b=>`
    <tr><td style="font-size:11px;color:rgba(255,255,255,.4)">${b.id}</td>
    <td style="color:white;font-weight:600">${b.guest}</td><td>${b.product.substring(0,25)}...</td>
    <td>${fmt(b.total)}</td><td><span class="td-badge ${b.status}">${b.status==='confirmed'?'Terkonfirmasi':b.status==='pending'?'Menunggu':'Dibatalkan'}</span></td></tr>`).join('');
}

function renderAdminPromos(){
  document.getElementById('promoAdminTable').innerHTML=promoDB.map(p=>`
    <tr><td style="font-weight:700;color:var(--sky3)">${p.code}</td><td style="color:white">${p.title}</td>
    <td>${p.discount}</td><td>${fmt(p.minTx)}</td><td>${p.validUntil}</td>
    <td><span class="td-badge ${p.status}">${p.status==='active'?'Aktif':'Nonaktif'}</span></td>
    <td><div class="td-actions"><button class="td-edit" onclick="openAdminForm('promo','${p.id}')">Edit</button><button class="td-del" onclick="deleteItem('promo','${p.id}')">Hapus</button></div></td>
    </tr>`).join('');
}

function renderAdminUsers(){
  document.getElementById('userAdminTable').innerHTML=userDB.map(u=>`
    <tr><td style="font-weight:600;color:white">${u.name}</td><td>${u.email}</td>
    <td><span class="td-badge ${u.role==='admin'?'pending':'active'}">${u.role==='admin'?'Admin':'User'}</span></td>
    <td>${u.totalBookings}</td>
    <td><span class="td-badge ${u.status}">${u.status==='active'?'Aktif':'Nonaktif'}</span></td>
    <td><div class="td-actions"><button class="td-edit" onclick="openAdminForm('user','${u.id}')">Edit</button><button class="td-del" onclick="deleteItem('user','${u.id}')">Hapus</button></div></td>
    </tr>`).join('');
  document.getElementById('adm-stat-user').textContent=userDB.length;
}

function approveBooking(id){
  const b=bookingDB.find(x=>x.id===id);
  if(b){b.status='confirmed';renderAdminBookings();renderPesanan('all');showToast('Booking diapprove! ✅');}
}

function deleteItem(type,id){
  if(!confirm('Yakin hapus data ini?')) return;
  if(type==='property'){propertyDB=propertyDB.filter(x=>x.id!==id);renderAdminProps();renderProps('semua');}
  else if(type==='flight'){flightDB=flightDB.filter(x=>x.id!==id);renderAdminFlights();renderFlights();}
  else if(type==='booking'){bookingDB=bookingDB.filter(x=>x.id!==id);renderAdminBookings();renderPesanan('all');}
  else if(type==='promo'){promoDB=promoDB.filter(x=>x.id!==id);renderAdminPromos();renderPromos();}
  else if(type==='user'){userDB=userDB.filter(x=>x.id!==id);renderAdminUsers();}
  showToast('Data berhasil dihapus!');
}

function filterAdminTable(tableId,query){
  const rows=document.querySelectorAll(`#${tableId} tr`);
  rows.forEach(r=>{
    const s=r.dataset.search||'';
    r.style.display=s.includes(query.toLowerCase())?'':'none';
  });
}

// ═══════════════════ ADMIN FORM (CREATE/UPDATE) ═══════════════════

let adminFormType=null,adminFormId=null;

function openAdminForm(type,id){
  adminFormType=type;adminFormId=id;
  const overlay=document.getElementById('adminFormOverlay');
  const title=document.getElementById('adminFormTitle');
  const body=document.getElementById('adminFormBody');
  const isEdit=!!id;
  const data=isEdit?
    (type==='property'?propertyDB.find(x=>x.id===id):
    type==='flight'?flightDB.find(x=>x.id===id):
    type==='promo'?promoDB.find(x=>x.id===id):
    userDB.find(x=>x.id===id)):null;

  title.textContent=(isEdit?'Edit ':'Tambah ')+
    {property:'Properti',flight:'Penerbangan',promo:'Promo',user:'Pengguna'}[type];

  if(type==='property') body.innerHTML=`
    <div class="admin-field"><label>Nama Properti</label><input class="admin-input" id="af-name" value="${data?.name||''}" placeholder="Nama properti"></div>
    <div class="admin-field"><label>Tipe</label><input class="admin-input" id="af-type" value="${data?.type||''}" placeholder="Villa, Hotel, dll"></div>
    <div class="admin-field"><label>Kategori</label><select class="admin-input" id="af-cat"><option ${data?.category==='villa'?'selected':''} value="villa">Villa</option><option ${data?.category==='hotel'?'selected':''} value="hotel">Hotel</option><option ${data?.category==='apartment'?'selected':''} value="apartment">Apartemen</option></select></div>
    <div class="admin-field"><label>Kota</label><input class="admin-input" id="af-city" value="${data?.city||''}" placeholder="Bali, Batu, Surabaya"></div>
    <div class="admin-field"><label>Harga per Malam (Rp)</label><input class="admin-input" id="af-price" type="number" value="${data?.pricePerNight||''}" placeholder="1000000"></div>
    <div class="admin-field"><label>Rating (1-5)</label><input class="admin-input" id="af-rating" type="number" step=".1" min="1" max="5" value="${data?.rating||4.5}"></div>
    <div class="admin-field"><label>Deskripsi</label><input class="admin-input" id="af-desc" value="${data?.desc||''}" placeholder="Deskripsi singkat"></div>
    <div class="admin-field"><label>URL Gambar</label><input class="admin-input" id="af-img" value="${data?.imageUrl||''}" placeholder="https://..."></div>`;
  else if(type==='flight') body.innerHTML=`
    <div class="admin-field"><label>Maskapai</label><input class="admin-input" id="af-airline" value="${data?.airline||''}" placeholder="Garuda Indonesia"></div>
    <div class="admin-field"><label>Kode Penerbangan</label><input class="admin-input" id="af-code" value="${data?.code||''}" placeholder="GA-401"></div>
    <div class="admin-field"><label>Dari</label><input class="admin-input" id="af-from" value="${data?.from||''}" placeholder="Surabaya"></div>
    <div class="admin-field"><label>Ke</label><input class="admin-input" id="af-to" value="${data?.to||''}" placeholder="Bali"></div>
    <div class="admin-field"><label>Berangkat</label><input class="admin-input" id="af-depart" value="${data?.depart||''}" placeholder="06:00"></div>
    <div class="admin-field"><label>Tiba</label><input class="admin-input" id="af-arrive" value="${data?.arrive||''}" placeholder="07:10"></div>
    <div class="admin-field"><label>Harga (Rp)</label><input class="admin-input" id="af-price" type="number" value="${data?.price||''}" placeholder="500000"></div>
    <div class="admin-field"><label>Kelas</label><select class="admin-input" id="af-class"><option ${data?.class==='Ekonomi'?'selected':''}>Ekonomi</option><option ${data?.class==='Bisnis'?'selected':''}>Bisnis</option><option ${data?.class==='First Class'?'selected':''}>First Class</option></select></div>`;
  else if(type==='promo') body.innerHTML=`
    <div class="admin-field"><label>Kode Promo</label><input class="admin-input" id="af-code" value="${data?.code||''}" placeholder="BALI40"></div>
    <div class="admin-field"><label>Judul</label><input class="admin-input" id="af-title" value="${data?.title||''}" placeholder="Diskon Bali 40%"></div>
    <div class="admin-field"><label>Diskon</label><input class="admin-input" id="af-disc" value="${data?.discount||''}" placeholder="40%"></div>
    <div class="admin-field"><label>Min. Transaksi (Rp)</label><input class="admin-input" id="af-min" type="number" value="${data?.minTx||''}" placeholder="500000"></div>
    <div class="admin-field"><label>Berlaku Sampai</label><input class="admin-input" id="af-until" type="date" value="${data?.validUntil||''}"></div>
    <div class="admin-field"><label>Deskripsi</label><input class="admin-input" id="af-desc" value="${data?.desc||''}" placeholder="Deskripsi promo"></div>`;
  else if(type==='user') body.innerHTML=`
    <div class="admin-field"><label>Nama Lengkap</label><input class="admin-input" id="af-name" value="${data?.name||''}" placeholder="Nama lengkap"></div>
    <div class="admin-field"><label>Email</label><input class="admin-input" id="af-email" type="email" value="${data?.email||''}" placeholder="email@contoh.com"></div>
    <div class="admin-field"><label>No. Telepon</label><input class="admin-input" id="af-phone" value="${data?.phone||''}" placeholder="+62..."></div>
    <div class="admin-field"><label>Role</label><select class="admin-input" id="af-role"><option value="user" ${data?.role==='user'?'selected':''}>User</option><option value="admin" ${data?.role==='admin'?'selected':''}>Admin</option></select></div>`;

  overlay.classList.add('active');
}

function saveAdminForm(){
  const v=id=>document.getElementById(id)?.value;
  if(adminFormType==='property'){
    const obj={id:adminFormId||'v-'+Date.now(),name:v('af-name'),type:v('af-type'),category:v('af-cat'),city:v('af-city'),pricePerNight:+v('af-price'),rating:+v('af-rating'),facilities:["📶 Wifi"],imageUrl:v('af-img')||'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=500',status:'active',desc:v('af-desc')};
    if(adminFormId) Object.assign(propertyDB.find(x=>x.id===adminFormId),obj);
    else propertyDB.unshift(obj);
    renderAdminProps();renderProps('semua');
  } else if(adminFormType==='flight'){
    const obj={id:adminFormId||'f-'+Date.now(),airline:v('af-airline'),logo:(v('af-airline')||'').substring(0,2).toUpperCase(),code:v('af-code'),from:v('af-from'),fromCode:v('af-from').substring(0,3).toUpperCase(),to:v('af-to'),toCode:v('af-to').substring(0,3).toUpperCase(),depart:v('af-depart'),arrive:v('af-arrive'),duration:'1j',stops:'Langsung',price:+v('af-price'),class:v('af-class'),status:'active'};
    if(adminFormId) Object.assign(flightDB.find(x=>x.id===adminFormId),obj);
    else flightDB.unshift(obj);
    renderAdminFlights();renderFlights();
  } else if(adminFormType==='promo'){
    const obj={id:adminFormId||'p-'+Date.now(),code:v('af-code'),title:v('af-title'),discount:v('af-disc'),minTx:+v('af-min'),validUntil:v('af-until'),status:'active',imageUrl:'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400',desc:v('af-desc')};
    if(adminFormId) Object.assign(promoDB.find(x=>x.id===adminFormId),obj);
    else promoDB.unshift(obj);
    renderAdminPromos();renderPromos();
  } else if(adminFormType==='user'){
    const obj={id:adminFormId||'u-'+Date.now(),name:v('af-name'),email:v('af-email'),phone:v('af-phone'),role:v('af-role'),totalBookings:0,status:'active',city:'',password:'user123'};
    if(adminFormId) Object.assign(userDB.find(x=>x.id===adminFormId),obj);
    else userDB.unshift(obj);
    renderAdminUsers();
  }
  document.getElementById('adminFormOverlay').classList.remove('active');
  showToast('Data berhasil disimpan! ✅');
}

// ═══════════════════ ADMIN CHART ═══════════════════

function renderAdminChart(){
  const months=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
  const data=[3,5,4,8,6,9,7,0,0,0,0,0];
  const max=Math.max(...data)||1;
  document.getElementById('adminChart').innerHTML=data.map((v,i)=>`
    <div class="chart-bar-wrap">
      <div class="chart-val" style="color:${v?'rgba(255,255,255,.6)':'transparent'}">${v||''}</div>
      <div class="chart-bar" style="height:${(v/max)*120}px;background:${v?'linear-gradient(to top,var(--sky),var(--sky3))':'rgba(255,255,255,.06)'}"></div>
      <div class="chart-label">${months[i]}</div>
    </div>`).join('');
}

// ═══════════════════ NAVIGATION ═══════════════════

function showPage(name){
  // Middleware check for admin page
  if(name==='admin'&&(!currentUser||currentUser.role!=='admin')){showToast('Akses ditolak. Hanya Admin!');openAuthModal('login');return}
  if((name==='profil')&&!currentUser){openAuthModal('login');return}
  document.querySelectorAll('.page-section').forEach(s=>s.classList.remove('active'));
  document.getElementById('page-'+name).classList.add('active');
  document.querySelectorAll('.nav-links a').forEach(a=>a.classList.remove('active'));
  const nl=document.getElementById('nl-'+name);if(nl)nl.classList.add('active');
  document.querySelectorAll('.bnav-item').forEach(b=>b.classList.remove('active'));
  const bn=document.getElementById('bn-'+name);if(bn)bn.classList.add('active');
  window.scrollTo(0,0);
  if(name==='admin') renderAllAdmin();
}

function renderAllAdmin(){
  renderAdminProps();renderAdminFlights();renderAdminBookings();renderAdminPromos();renderAdminUsers();renderAdminChart();
}

function switchAdminSection(sec){
  document.querySelectorAll('.admin-section').forEach(s=>s.classList.remove('active'));
  document.getElementById('adm-'+sec).classList.add('active');
  document.querySelectorAll('.admin-nav li a').forEach(a=>a.classList.remove('active'));
  event.currentTarget.classList.add('active');
}

// ═══════════════════ MISC FEATURES ═══════════════════

function switchSearchTab(tab){
  document.getElementById('st-stay').classList.toggle('active',tab==='stay');
  document.getElementById('st-flight').classList.toggle('active',tab==='flight');
  document.getElementById('sw-stay').style.display=tab==='stay'?'flex':'none';
  document.getElementById('sw-flight').style.display=tab==='flight'?'flex':'none';
}

function toggleFlightType(t){
  document.getElementById('ft-sekali').classList.toggle('active',t==='sekali');
  document.getElementById('ft-pp').classList.toggle('active',t==='pp');
  document.getElementById('returnDateField').style.display=t==='pp'?'block':'none';
}

function swapAirports(){
  const a=document.getElementById('fi-from'),b=document.getElementById('fi-to');
  [a.value,b.value]=[b.value,a.value];
  showToast('Rute ditukar! 🔄');
}

function searchFlights(){
  const from=document.getElementById('fi-from').value;
  const to=document.getElementById('fi-to').value;
  document.getElementById('flightResultTitle').innerText=`${from.split('(')[0].trim()} → ${to.split('(')[0].trim()}`;
  document.getElementById('flightResultSub').innerText=`${flightDB.length} penerbangan tersedia`;
  showToast('Menampilkan semua penerbangan tersedia ✈');
}

function scrollToProps(){document.getElementById('propSection').scrollIntoView({behavior:'smooth'})}

function copyPromo(code){
  navigator.clipboard?.writeText(code).catch(()=>{});
  showToast(`Kode ${code} disalin! 🎁`);
}

function showToast(msg){
  const t=document.getElementById('toast');
  t.innerText=msg;t.classList.add('show');
  setTimeout(()=>t.classList.remove('show'),2800);
}

// Filter chips
document.getElementById('filterChips').addEventListener('click',e=>{
  const c=e.target.closest('.chip');if(!c)return;
  document.querySelectorAll('#filterChips .chip').forEach(x=>x.classList.remove('active'));
  c.classList.add('active');
  renderProps(c.dataset.filter);
});

// Image fallback
window.addEventListener('error',function(e){
  const el=e.target;
  if(el.tagName==='IMG'&&!el.dataset.fb){
    el.dataset.fb='1';
    el.src='data:image/svg+xml;charset=UTF-8,'+encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300"><rect width="400" height="300" fill="#f3f7ff"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="sans-serif" font-size="16" fill="#6b88a8">Gambar tidak tersedia</text></svg>');
  }
},true);

// ═══════════════════ INIT ═══════════════════
renderProps('semua');
renderPromos();
renderFlights();
</script>
</body>
</html>