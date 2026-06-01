<?php
/**
 * layout.php — shared HTML head, navbar, CSS, toast
 * Usage: include 'layout.php';  then call layoutHeader($title, $activePage)
 *        at end of page call layoutFooter()
 */

function layoutHeader(string $title = 'StayGo', string $activePage = 'home'): void {
    $u = currentUser();
    $flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= h($title) ?> — StayGo</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --ink:#0a1628;--ink2:#1e3a5f;--ink3:#334e6e;--muted:#6b88a8;
  --sky:#2563EB;--sky2:#1d4ed8;--sky3:#3b82f6;
  --gold:#f59e0b;--gold2:#d97706;
  --green:#16a34a;--red:#dc2626;--purple:#7c3aed;
  --bg:#f0f6ff;--bg2:#e8f1fb;--bg3:#f8faff;--white:#fff;
  --radius:16px;--radius-sm:10px;--radius-lg:24px;
  --shadow:0 4px 24px rgba(10,22,40,.08);
  --shadow-lg:0 12px 48px rgba(10,22,40,.14);
  --shadow-xl:0 24px 80px rgba(10,22,40,.18);
}
html{scroll-behavior:smooth}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg3);color:var(--ink);line-height:1.5;overflow-x:hidden}
::-webkit-scrollbar{width:6px}::-webkit-scrollbar-track{background:var(--bg)}::-webkit-scrollbar-thumb{background:var(--sky3);border-radius:99px}
a{text-decoration:none;color:inherit}
/* NAV */
.nav{position:fixed;top:0;left:0;right:0;z-index:900;display:flex;align-items:center;justify-content:space-between;padding:0 48px;height:68px;background:rgba(248,250,255,.92);backdrop-filter:blur(20px);border-bottom:1px solid rgba(37,99,235,.08);box-shadow:0 2px 20px rgba(10,22,40,.06)}
.nav-logo{display:flex;align-items:center;gap:10px}
.nav-logo-mark{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--sky),var(--sky2));display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(37,99,235,.3)}
.nav-logo-mark svg{width:20px;height:20px;fill:white}
.nav-logo-text{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700;color:var(--ink)}
.nav-logo-text span{color:var(--sky)}
.nav-links{display:flex;align-items:center;gap:28px}
.nav-links a{font-size:14px;font-weight:500;color:var(--ink3);transition:color .2s;position:relative}
.nav-links a:hover,.nav-links a.active{color:var(--sky)}
.nav-links a.active::after{content:'';position:absolute;bottom:-4px;left:0;right:0;height:2px;background:var(--sky);border-radius:99px}
.nav-actions{display:flex;align-items:center;gap:10px}
/* BUTTONS */
.btn{padding:8px 18px;border-radius:var(--radius-sm);font-size:13px;font-weight:700;border:none;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s;display:inline-flex;align-items:center;gap:6px}
.btn-ghost{background:transparent;border:1.5px solid var(--sky);color:var(--sky)}
.btn-ghost:hover{background:var(--sky);color:white}
.btn-solid{background:var(--sky);color:white;box-shadow:0 4px 14px rgba(37,99,235,.25)}
.btn-solid:hover{background:var(--sky2);transform:translateY(-1px)}
.btn-danger{background:var(--red);color:white}
.btn-danger:hover{background:#b91c1c}
.btn-green{background:var(--green);color:white}
.btn-green:hover{background:#15803d}
.btn-gold{background:var(--gold);color:white}
.btn-sm{padding:5px 12px;font-size:12px;border-radius:8px}
/* USER CHIP DROPDOWN */
.user-chip{display:flex;align-items:center;gap:8px;padding:6px 14px;border-radius:99px;background:var(--bg);border:1.5px solid rgba(37,99,235,.15);cursor:pointer;font-size:13px;font-weight:600;color:var(--ink);position:relative}
.user-chip .uc-avatar{width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,var(--sky),var(--purple));display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:white;flex-shrink:0}
.user-chip .uc-role{font-size:10px;font-weight:700;padding:2px 7px;border-radius:99px}
.uc-role.admin{background:#fef3c7;color:#92400e}
.uc-role.manager{background:#fce7f3;color:#9d174d}
.uc-role.user{background:#eff6ff;color:var(--sky)}
.uc-dropdown{position:absolute;top:calc(100% + 8px);right:0;min-width:210px;background:white;border-radius:var(--radius);box-shadow:var(--shadow-lg);border:1px solid rgba(10,22,40,.06);padding:8px;display:none;z-index:200}
.user-chip:hover .uc-dropdown,.user-chip:focus-within .uc-dropdown{display:block}
.uc-dropdown a,.uc-dropdown button{display:flex;align-items:center;gap:10px;width:100%;padding:9px 12px;border-radius:8px;font-size:13px;color:var(--ink3);background:none;border:none;cursor:pointer;font-family:inherit;transition:background .15s;text-align:left}
.uc-dropdown a:hover,.uc-dropdown button:hover{background:var(--bg);color:var(--sky)}
.uc-sep{height:1px;background:var(--bg2);margin:4px 0}
/* SECTIONS */
.section{padding:80px 48px}
.section-alt{background:var(--bg)}
@media(max-width:900px){.section{padding:60px 24px}}
.sec-tag{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;color:var(--sky);text-transform:uppercase;letter-spacing:.8px;margin-bottom:12px}
.sec-title{font-family:'Cormorant Garamond',serif;font-size:clamp(28px,3.5vw,42px);font-weight:700;color:var(--ink);line-height:1.15;margin-bottom:8px}
.sec-sub{font-size:15px;color:var(--muted);max-width:480px}
.sec-head{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:36px;gap:20px;flex-wrap:wrap}
.see-all{font-size:13px;font-weight:600;color:var(--sky);display:flex;align-items:center;gap:6px;flex-shrink:0}
.see-all:hover{color:var(--sky2)}
.see-all svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2}
/* CHIPS */
.chips{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:32px}
.chip{padding:8px 18px;border-radius:99px;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;border:1.5px solid rgba(37,99,235,.15);background:white;color:var(--ink3)}
.chip:hover{border-color:var(--sky);color:var(--sky)}
.chip.active{background:var(--sky);color:white;border-color:var(--sky);box-shadow:0 4px 12px rgba(37,99,235,.25)}
/* PROPERTY GRID */
.prop-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px}
.prop-card{background:white;border-radius:var(--radius);overflow:hidden;border:1px solid rgba(10,22,40,.05);box-shadow:var(--shadow);transition:all .3s}
.prop-card:hover{transform:translateY(-6px);box-shadow:var(--shadow-xl)}
.prop-card-img{width:100%;height:200px;object-fit:cover;display:block}
.prop-card-body{padding:16px}
.prop-card-tag{display:inline-block;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700;color:var(--sky);background:#eff6ff;margin-bottom:8px}
.prop-card-name{font-family:'Cormorant Garamond',serif;font-size:19px;font-weight:700;color:var(--ink);margin-bottom:6px;line-height:1.2}
.prop-card-loc{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:4px;margin-bottom:12px}
.prop-card-fac{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px}
.prop-card-fac span{font-size:10px;padding:3px 8px;border-radius:6px;background:var(--bg);color:var(--ink3)}
.prop-card-footer{display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--bg2);padding-top:12px}
.prop-card-price{font-size:16px;font-weight:700;color:var(--ink)}
.prop-card-price span{font-size:11px;font-weight:400;color:var(--muted)}
.prop-card-rating{display:flex;align-items:center;gap:4px;font-size:12px;font-weight:700;color:var(--gold2)}
/* PROMO */
.promo-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px}
.promo-card{position:relative;border-radius:var(--radius);overflow:hidden;height:160px;cursor:pointer;transition:all .3s}
.promo-card:hover{transform:scale(1.02);box-shadow:var(--shadow-xl)}
.promo-card img{width:100%;height:100%;object-fit:cover;display:block}
.promo-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,22,40,.7),rgba(37,99,235,.35));padding:20px;display:flex;flex-direction:column;justify-content:flex-end}
.promo-badge{display:inline-block;padding:3px 10px;border-radius:99px;background:var(--gold);color:white;font-size:9px;font-weight:800;letter-spacing:.5px;margin-bottom:6px;align-self:flex-start}
.promo-title{font-size:15px;font-weight:700;color:white;margin-bottom:2px}
.promo-code{font-size:11px;color:rgba(255,255,255,.75)}
/* FLIGHT */
.flight-card{background:white;border-radius:var(--radius);padding:20px 24px;border:1.5px solid rgba(10,22,40,.06);box-shadow:var(--shadow);display:flex;align-items:center;gap:20px;transition:all .2s;flex-wrap:wrap}
.flight-card:hover{border-color:var(--sky);box-shadow:var(--shadow-lg);transform:translateY(-2px)}
.airline-logo{width:56px;height:48px;border-radius:12px;background:linear-gradient(135deg,var(--sky),var(--purple));display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:white;letter-spacing:.5px;flex-shrink:0}
.flight-times{display:flex;align-items:center;gap:16px;flex:1;min-width:240px}
.flight-time{font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:700;color:var(--ink)}
.flight-airport{font-size:11px;color:var(--muted);font-weight:600}
.flight-line{flex:1;display:flex;flex-direction:column;align-items:center;gap:4px}
.flight-duration{font-size:11px;font-weight:600;color:var(--muted)}
.flight-track{width:100%;height:1px;background:rgba(10,22,40,.15);display:flex;align-items:center;justify-content:center}
.flight-price-val{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:700;color:var(--sky)}
/* MODAL */
.modal-overlay{position:fixed;inset:0;background:rgba(10,22,40,.55);backdrop-filter:blur(8px);z-index:1000;display:none;align-items:center;justify-content:center;padding:24px;overflow-y:auto}
.modal-overlay.active{display:flex}
.modal-box{background:white;border-radius:var(--radius-lg);max-width:620px;width:100%;box-shadow:var(--shadow-xl);animation:modalIn .3s ease}
@keyframes modalIn{from{opacity:0;transform:scale(.94) translateY(20px)}to{opacity:1;transform:scale(1) translateY(0)}}
.modal-close-btn{position:absolute;top:14px;right:14px;width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,.9);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 12px rgba(0,0,0,.15)}
.modal-close-btn svg{width:14px;height:14px;stroke:var(--ink);fill:none;stroke-width:2.5;stroke-linecap:round}
/* FORM */
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
@media(max-width:600px){.form-grid{grid-template-columns:1fr}}
.form-field{display:flex;flex-direction:column;gap:8px}
.form-field label{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px}
.form-input{padding:12px 14px;border-radius:12px;border:1.5px solid rgba(10,22,40,.1);font-size:14px;font-weight:500;color:var(--ink);font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg3);outline:none;transition:all .2s;width:100%}
.form-input:focus{border-color:var(--sky);background:white;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
.form-input::placeholder{color:var(--muted)}
select.form-input{appearance:none}
.form-submit{width:100%;padding:14px;border-radius:12px;background:var(--sky);color:white;font-size:15px;font-weight:700;border:none;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s;box-shadow:0 4px 16px rgba(37,99,235,.3)}
.form-submit:hover{background:var(--sky2)}
/* ORDER SUMMARY */
.order-summary{background:var(--bg3);border-radius:var(--radius);padding:16px;margin-bottom:20px;border:1px solid var(--bg2)}
.order-row{display:flex;justify-content:space-between;font-size:13px;margin-bottom:8px;color:var(--ink3)}
.order-row.total{border-top:1px dashed rgba(10,22,40,.12);padding-top:12px;margin-top:4px;font-weight:700;color:var(--ink);font-size:15px}
/* FOOTER */
.footer{background:var(--ink);padding:56px 48px 28px;color:rgba(255,255,255,.6)}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:40px;margin-bottom:48px}
.footer-brand p{font-size:13px;margin-top:14px;line-height:1.7}
.footer-col h4{font-size:13px;font-weight:700;color:white;margin-bottom:16px}
.footer-col ul{list-style:none}
.footer-col ul li{margin-bottom:10px}
.footer-col ul li a{font-size:13px;color:rgba(255,255,255,.5);transition:color .2s}
.footer-col ul li a:hover{color:white}
.footer-bottom{border-top:1px solid rgba(255,255,255,.08);padding-top:24px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;font-size:12px}
@media(max-width:768px){.footer-grid{grid-template-columns:1fr;gap:24px}}
/* BOTTOM NAV */
.bottom-nav{position:fixed;bottom:0;left:0;right:0;z-index:800;background:rgba(255,255,255,.96);backdrop-filter:blur(16px);border-top:1px solid rgba(10,22,40,.06);display:none;align-items:center;justify-content:center;height:64px}
.bnav-item{flex:1;max-width:80px;display:flex;flex-direction:column;align-items:center;gap:4px;cursor:pointer;padding:8px 0;color:var(--muted);text-decoration:none}
.bnav-item.active{color:var(--sky)}
.bnav-item svg{width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round}
.bnav-label{font-size:9px;font-weight:600}
/* TOAST */
.toast{position:fixed;bottom:80px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--ink);color:white;padding:12px 24px;border-radius:12px;font-size:13px;font-weight:600;opacity:0;transition:all .4s;z-index:2000;box-shadow:var(--shadow-xl);pointer-events:none;white-space:nowrap;max-width:90vw}
.toast.show{opacity:1;transform:translateX(-50%) translateY(0)}
.toast.success{background:var(--green)}
.toast.error{background:var(--red)}
/* FLASH BANNER */
.flash-banner{padding:12px 24px;border-radius:var(--radius-sm);font-size:13px;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:10px}
.flash-banner.success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
.flash-banner.error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
/* BADGE */
.badge{display:inline-block;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700}
.badge-active,.badge-confirmed{background:#f0fdf4;color:#16a34a}
.badge-pending{background:#fef9c3;color:#a16207}
.badge-cancelled,.badge-inactive{background:#fef2f2;color:#dc2626}
.badge-admin{background:#fef3c7;color:#92400e}
.badge-manager{background:#fce7f3;color:#9d174d}
.badge-user{background:#eff6ff;color:var(--sky)}
/* HIDDEN */
.hidden{display:none!important}
/* RESPONSIVE NAV */
@media(max-width:768px){
  .nav{padding:0 20px}
  .nav-links{display:none}
  .bottom-nav{display:flex}
  body{padding-bottom:64px}
}
/* PAGE WRAPPER */
.page-wrap{padding-top:68px;min-height:100vh}
</style>
</head>
<body>

<!-- NAV -->
<nav class="nav">
  <a href="index.php" class="nav-logo">
    <div class="nav-logo-mark">
      <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
    </div>
    <div class="nav-logo-text">Stay<span>Go</span></div>
  </a>

  <div class="nav-links">
    <a href="index.php" class="<?= $activePage==='home'?'active':'' ?>">Beranda</a>
    <a href="penerbangan.php" class="<?= $activePage==='flight'?'active':'' ?>">Penerbangan</a>
    <a href="promo.php" class="<?= $activePage==='promo'?'active':'' ?>">Promo</a>
    <?php if (isLoggedIn()): ?>
    <a href="pesanan.php" class="<?= $activePage==='pesanan'?'active':'' ?>">Pesanan Saya</a>
    <?php endif; ?>
    <?php if (hasRole(['admin','manager'])): ?>
    <a href="admin.php" class="<?= $activePage==='admin'?'active':'' ?>" style="color:var(--gold)">⚙ Admin</a>
    <?php endif; ?>
  </div>

  <div class="nav-actions">
    <?php if ($u): ?>
    <div class="user-chip" tabindex="0">
      <div class="uc-avatar"><?= strtoupper(substr($u['name'],0,1)) ?></div>
      <?= h(explode(' ',$u['name'])[0]) ?>
      <span class="uc-role <?= $u['role'] ?>"><?= ucfirst($u['role']) ?></span>
      <div class="uc-dropdown">
        <a href="profil.php">👤 Profil Saya</a>
        <a href="pesanan.php">📋 Pesanan Saya</a>
        <?php if (hasRole(['admin','manager'])): ?>
        <a href="admin.php" style="color:var(--gold)">⚙ Admin Panel</a>
        <?php endif; ?>
        <div class="uc-sep"></div>
        <form method="POST" action="data.php">
          <input type="hidden" name="_action" value="logout">
          <button type="submit" style="color:var(--red)">🚪 Logout</button>
        </form>
      </div>
    </div>
    <?php else: ?>
    <a href="login.php" class="btn btn-ghost">Masuk</a>
    <a href="login.php?tab=register" class="btn btn-solid">Daftar</a>
    <?php endif; ?>
  </div>
</nav>

<!-- FLASH MESSAGE -->
<?php if ($flash): ?>
<div id="flashBanner" class="flash-banner <?= $flash['type'] ?>" style="position:fixed;top:78px;left:50%;transform:translateX(-50%);z-index:950;min-width:280px;text-align:center;box-shadow:var(--shadow)">
  <?= $flash['type']==='success'?'✅':'❌' ?> <?= h($flash['msg']) ?>
</div>
<script>setTimeout(()=>{const b=document.getElementById('flashBanner');if(b)b.style.opacity='0';setTimeout(()=>b?.remove(),400)},3000)</script>
<?php endif; ?>

<!-- BOTTOM NAV -->
<nav class="bottom-nav">
  <a href="index.php" class="bnav-item <?= $activePage==='home'?'active':'' ?>">
    <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
    <span class="bnav-label">Beranda</span>
  </a>
  <a href="penerbangan.php" class="bnav-item <?= $activePage==='flight'?'active':'' ?>">
    <svg viewBox="0 0 24 24"><path d="M22 2L11 13"/><path d="M22 2L15 22l-4-9-9-4 22-7z"/></svg>
    <span class="bnav-label">Terbang</span>
  </a>
  <a href="promo.php" class="bnav-item <?= $activePage==='promo'?'active':'' ?>">
    <svg viewBox="0 0 24 24"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/></svg>
    <span class="bnav-label">Promo</span>
  </a>
  <a href="<?= isLoggedIn()?'pesanan.php':'login.php' ?>" class="bnav-item <?= $activePage==='pesanan'?'active':'' ?>">
    <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
    <span class="bnav-label">Pesanan</span>
  </a>
  <a href="<?= isLoggedIn()?'profil.php':'login.php' ?>" class="bnav-item <?= $activePage==='profil'?'active':'' ?>">
    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    <span class="bnav-label">Profil</span>
  </a>
</nav>

<?php
}

function layoutFooter(): void {
?>
<footer class="footer">
  <div class="footer-grid">
    <div class="footer-brand">
      <a href="index.php" style="display:inline-flex;align-items:center;gap:10px;margin-bottom:4px">
        <div class="nav-logo-mark"><svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
        <span style="font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:700;color:white">Stay<span style="color:#60a5fa">Go</span></span>
      </a>
      <p>Platform booking staycation & penerbangan terpercaya untuk traveler Indonesia.</p>
    </div>
    <div class="footer-col"><h4>Layanan</h4><ul><li><a href="index.php">Villa & Resort</a></li><li><a href="index.php">Hotel</a></li><li><a href="index.php">Apartemen</a></li><li><a href="penerbangan.php">Tiket Pesawat</a></li></ul></div>
    <div class="footer-col"><h4>Destinasi</h4><ul><li><a href="index.php">Bali</a></li><li><a href="index.php">Batu, Malang</a></li><li><a href="index.php">Surabaya</a></li><li><a href="index.php">Lombok</a></li></ul></div>
    <div class="footer-col"><h4>Bantuan</h4><ul><li><a href="#">Pusat Bantuan</a></li><li><a href="#">Kebijakan Privasi</a></li><li><a href="#">Syarat & Ketentuan</a></li><li><a href="#">Kontak Kami</a></li></ul></div>
  </div>
  <div class="footer-bottom"><p>© 2026 StayGo. All rights reserved.</p><p>Made with ♥ for Indonesian Travelers</p></div>
</footer>
</body></html>
<?php
}