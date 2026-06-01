<?php
require_once 'data.php';

// If already logged in, redirect home
if (isLoggedIn()) {
    header('Location: index.php'); exit;
}

$tab      = $_GET['tab'] ?? 'login';
$redirect = $_GET['redirect'] ?? 'index.php';
$err      = $_GET['err'] ?? '';
$flash    = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk / Daftar — StayGo</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --ink:#0a1628;--ink2:#1e3a5f;--ink3:#334e6e;--muted:#6b88a8;
  --sky:#2563EB;--sky2:#1d4ed8;--sky3:#3b82f6;
  --gold:#f59e0b;--green:#16a34a;--red:#dc2626;--purple:#7c3aed;
  --bg:#f0f6ff;--bg2:#e8f1fb;--bg3:#f8faff;
  --radius:16px;--radius-sm:10px;--radius-lg:24px;
  --shadow:0 4px 24px rgba(10,22,40,.08);
  --shadow-lg:0 12px 48px rgba(10,22,40,.14);
  --shadow-xl:0 24px 80px rgba(10,22,40,.18);
}
html{scroll-behavior:smooth}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg3);color:var(--ink);min-height:100vh;display:flex;flex-direction:column}

/* TWO-COLUMN SPLIT */
.auth-page{display:grid;grid-template-columns:1fr 1fr;min-height:100vh}
@media(max-width:900px){.auth-page{grid-template-columns:1fr}}

/* LEFT — hero panel */
.auth-left{background:linear-gradient(160deg,#0a1628 0%,#0f2d5a 40%,#1e4d8c 70%,#2563eb 100%);padding:60px 56px;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden}
.auth-left-blob{position:absolute;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,.06) 0%,transparent 70%)}
.auth-left-blob-1{width:500px;height:500px;top:-180px;right:-180px}
.auth-left-blob-2{width:350px;height:350px;bottom:-100px;left:-100px}
.auth-left-logo{display:flex;align-items:center;gap:12px;text-decoration:none;position:relative;z-index:1}
.logo-mark{width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center}
.logo-mark svg{width:24px;height:24px;fill:white}
.logo-text{font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:700;color:white}
.logo-text span{color:var(--gold)}
.auth-left-body{position:relative;z-index:1}
.auth-left-title{font-family:'Cormorant Garamond',serif;font-size:clamp(36px,5vw,56px);font-weight:700;color:white;line-height:1.1;margin-bottom:20px}
.auth-left-title em{font-style:italic;color:var(--gold)}
.auth-left-sub{font-size:15px;color:rgba(255,255,255,.65);line-height:1.7;margin-bottom:36px;max-width:380px}
.auth-features{display:flex;flex-direction:column;gap:16px}
.auth-feat{display:flex;align-items:center;gap:14px}
.auth-feat-icon{width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.12);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.auth-feat-text{font-size:13px;color:rgba(255,255,255,.75)}
.auth-feat-text strong{color:white;font-weight:700;display:block;margin-bottom:2px}
.auth-left-stats{display:flex;gap:32px;position:relative;z-index:1}
.auth-stat-val{font-family:'Cormorant Garamond',serif;font-size:30px;font-weight:700;color:white}
.auth-stat-lbl{font-size:11px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px}
@media(max-width:900px){.auth-left{display:none}}

/* RIGHT — form panel */
.auth-right{display:flex;align-items:center;justify-content:center;padding:40px 24px;background:var(--bg3)}
.auth-card{background:white;border-radius:var(--radius-lg);padding:40px;box-shadow:var(--shadow-xl);width:100%;max-width:440px;border:1px solid rgba(10,22,40,.05)}
/* mobile logo */
.auth-mobile-logo{display:none;text-align:center;margin-bottom:28px}
@media(max-width:900px){.auth-mobile-logo{display:block}}
.auth-mobile-logo a{display:inline-flex;align-items:center;gap:10px}
.auth-mobile-logo .logo-mark{background:linear-gradient(135deg,var(--sky),var(--sky2));border:none}

.auth-card-title{font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:700;color:var(--ink);margin-bottom:6px}
.auth-card-sub{font-size:13px;color:var(--muted);margin-bottom:24px}

/* TABS */
.auth-tabs{display:flex;background:var(--bg);border-radius:12px;padding:4px;gap:2px;margin-bottom:24px}
.auth-tab{flex:1;padding:9px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;text-align:center;color:var(--muted);transition:all .2s;border:none;background:none;font-family:'Plus Jakarta Sans',sans-serif}
.auth-tab.active{background:white;color:var(--sky);box-shadow:var(--shadow)}

/* DEMO BOX */
.demo-box{background:var(--bg);border-radius:12px;padding:14px;margin-bottom:20px}
.demo-box-title{font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;margin-bottom:10px}
.demo-btn{display:flex;align-items:center;justify-content:space-between;width:100%;padding:9px 12px;border-radius:8px;background:white;border:1px solid rgba(37,99,235,.1);cursor:pointer;margin-bottom:6px;transition:all .2s;font-family:'Plus Jakarta Sans',sans-serif}
.demo-btn:last-child{margin-bottom:0}
.demo-btn:hover{border-color:var(--sky)}
.demo-btn-info{text-align:left}
.demo-btn-info span{display:block;font-size:12px;color:var(--ink);font-weight:600}
.demo-btn-info small{font-size:10px;color:var(--muted)}
.demo-role-badge{font-size:10px;font-weight:800;padding:3px 9px;border-radius:99px}
.demo-role-badge.admin{background:#fef3c7;color:#92400e}
.demo-role-badge.manager{background:#fce7f3;color:#9d174d}
.demo-role-badge.user{background:#eff6ff;color:var(--sky)}

/* FORM */
.auth-form{display:none}
.auth-form.active{display:block}
.form-field{display:flex;flex-direction:column;gap:8px;margin-bottom:16px}
.form-field label{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px}
.form-input{padding:12px 14px;border-radius:12px;border:1.5px solid rgba(10,22,40,.1);font-size:14px;font-weight:500;color:var(--ink);font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg3);outline:none;transition:all .2s;width:100%}
.form-input:focus{border-color:var(--sky);background:white;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
.form-input::placeholder{color:var(--muted);font-weight:400}
.form-submit{width:100%;padding:14px;border-radius:12px;background:var(--sky);color:white;font-size:15px;font-weight:700;border:none;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s;box-shadow:0 4px 16px rgba(37,99,235,.3);margin-top:4px}
.form-submit:hover{background:var(--sky2);transform:translateY(-1px)}
.form-submit:active{transform:translateY(0)}
.form-hint{font-size:12px;color:var(--muted);text-align:center;margin-top:16px}
.form-hint a{color:var(--sky);font-weight:700}
.input-wrap{position:relative}
.input-toggle{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--muted);font-size:13px}

/* FLASH */
.flash-msg{padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:18px;display:flex;align-items:center;gap:8px}
.flash-msg.success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
.flash-msg.error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}

/* DIVIDER */
.divider{display:flex;align-items:center;gap:12px;margin:16px 0;color:var(--muted);font-size:12px}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--bg2)}

/* PASSWORD STRENGTH */
.pwd-strength{height:4px;border-radius:99px;background:var(--bg2);margin-top:6px;overflow:hidden}
.pwd-strength-bar{height:100%;border-radius:99px;transition:all .3s;width:0}
</style>
</head>
<body>

<div class="auth-page">
  <!-- LEFT PANEL -->
  <div class="auth-left">
    <div class="auth-left-blob auth-left-blob-1"></div>
    <div class="auth-left-blob auth-left-blob-2"></div>

    <a href="index.php" class="auth-left-logo">
      <div class="logo-mark"><svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
      <div class="logo-text">Stay<span>Go</span></div>
    </a>

    <div class="auth-left-body">
      <h1 class="auth-left-title">Temukan <em>Surga</em><br>di Setiap Perjalanan</h1>
      <p class="auth-left-sub">Gabung bersama 150.000+ traveler Indonesia. Pesan villa, hotel, apartemen, dan tiket pesawat dengan harga terbaik.</p>
      <div class="auth-features">
        <div class="auth-feat"><div class="auth-feat-icon">🏖</div><div class="auth-feat-text"><strong>350+ Properti Premium</strong>Villa, hotel & apartemen terpilih di seluruh Indonesia</div></div>
        <div class="auth-feat"><div class="auth-feat-icon">✈️</div><div class="auth-feat-text"><strong>Tiket Pesawat Termurah</strong>Harga terbaik dari semua maskapai domestik</div></div>
        <div class="auth-feat"><div class="auth-feat-icon">🎁</div><div class="auth-feat-text"><strong>Promo Eksklusif Member</strong>Diskon hingga 50% untuk member setia StayGo</div></div>
        <div class="auth-feat"><div class="auth-feat-icon">⚡</div><div class="auth-feat-text"><strong>Konfirmasi Instan</strong>Booking terkonfirmasi dalam hitungan detik</div></div>
      </div>
    </div>

    <div class="auth-left-stats">
      <div><div class="auth-stat-val">350+</div><div class="auth-stat-lbl">Properti</div></div>
      <div><div class="auth-stat-val">50+</div><div class="auth-stat-lbl">Destinasi</div></div>
      <div><div class="auth-stat-val">4.9★</div><div class="auth-stat-lbl">Rating</div></div>
      <div><div class="auth-stat-val">24/7</div><div class="auth-stat-lbl">Support</div></div>
    </div>
  </div>

  <!-- RIGHT PANEL — FORM -->
  <div class="auth-right">
    <div class="auth-card">

      <!-- Mobile logo -->
      <div class="auth-mobile-logo">
        <a href="index.php">
          <div class="logo-mark" style="background:linear-gradient(135deg,var(--sky),var(--sky2));border:none"><svg viewBox="0 0 24 24" style="fill:white;width:24px;height:24px"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
          <span style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700;color:var(--ink)">Stay<span style="color:var(--sky)">Go</span></span>
        </a>
      </div>

      <div class="auth-card-title">Selamat Datang 👋</div>
      <div class="auth-card-sub">Masuk atau buat akun untuk mulai memesan</div>

      <?php if ($flash): ?>
      <div class="flash-msg <?= $flash['type'] ?>">
        <?= $flash['type']==='success' ? '✅' : '❌' ?> <?= h($flash['msg']) ?>
      </div>
      <?php endif; ?>

      <!-- TABS -->
      <div class="auth-tabs">
        <button class="auth-tab <?= $tab==='login'?'active':'' ?>" onclick="switchTab('login')">Masuk</button>
        <button class="auth-tab <?= $tab==='register'?'active':'' ?>" onclick="switchTab('register')">Daftar</button>
      </div>

      <!-- DEMO ACCOUNTS -->
      <div class="demo-box">
        <div class="demo-box-title">🔑 Akun Demo (Klik untuk Isi)</div>
        <button type="button" class="demo-btn" onclick="fillDemo('admin@staygo.id','admin123')">
          <div class="demo-btn-info"><span>admin@staygo.id</span><small>Password: admin123</small></div>
          <span class="demo-role-badge admin">ADMIN</span>
        </button>
        <button type="button" class="demo-btn" onclick="fillDemo('manager@staygo.id','manager123')">
          <div class="demo-btn-info"><span>manager@staygo.id</span><small>Password: manager123</small></div>
          <span class="demo-role-badge manager">MANAGER</span>
        </button>
        <button type="button" class="demo-btn" onclick="fillDemo('user@staygo.id','user123')">
          <div class="demo-btn-info"><span>user@staygo.id</span><small>Password: user123</small></div>
          <span class="demo-role-badge user">USER</span>
        </button>
      </div>

      <!-- LOGIN FORM -->
      <div class="auth-form <?= $tab==='login'?'active':'' ?>" id="loginForm">
        <form method="POST" action="data.php">
          <input type="hidden" name="_action" value="login">
          <input type="hidden" name="redirect" value="<?= h(urldecode($redirect)) ?>">

          <div class="form-field">
            <label for="login-email">Email</label>
            <input class="form-input" id="login-email" name="email" type="email" placeholder="email@contoh.com" autocomplete="email" required>
          </div>

          <div class="form-field">
            <label for="login-pass">Password</label>
            <div class="input-wrap">
              <input class="form-input" id="login-pass" name="password" type="password" placeholder="••••••••" autocomplete="current-password" required>
              <button type="button" class="input-toggle" onclick="togglePwd('login-pass',this)">👁</button>
            </div>
          </div>

          <button class="form-submit" type="submit">Masuk ke StayGo →</button>
        </form>
        <div class="form-hint">Belum punya akun? <a href="#" onclick="switchTab('register');return false">Daftar gratis</a></div>
      </div>

      <!-- REGISTER FORM -->
      <div class="auth-form <?= $tab==='register'?'active':'' ?>" id="registerForm">
        <form method="POST" action="data.php">
          <input type="hidden" name="_action" value="register">

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
            <div class="form-field">
              <label>Nama Lengkap</label>
              <input class="form-input" name="name" placeholder="Nama lengkap" required>
            </div>
            <div class="form-field">
              <label>No. Telepon</label>
              <input class="form-input" name="phone" type="tel" placeholder="+62...">
            </div>
          </div>

          <div class="form-field">
            <label>Email</label>
            <input class="form-input" name="email" type="email" placeholder="email@contoh.com" required>
          </div>

          <div class="form-field">
            <label>Password</label>
            <div class="input-wrap">
              <input class="form-input" id="reg-pass" name="password" type="password" placeholder="Min. 6 karakter" oninput="checkStrength(this.value)" required>
              <button type="button" class="input-toggle" onclick="togglePwd('reg-pass',this)">👁</button>
            </div>
            <div class="pwd-strength"><div class="pwd-strength-bar" id="strengthBar"></div></div>
          </div>

          <div class="form-field">
            <label>Konfirmasi Password</label>
            <div class="input-wrap">
              <input class="form-input" id="reg-conf" name="confirm" type="password" placeholder="Ulangi password" required>
              <button type="button" class="input-toggle" onclick="togglePwd('reg-conf',this)">👁</button>
            </div>
          </div>

          <button class="form-submit" type="submit">Buat Akun Gratis →</button>
        </form>
        <div class="form-hint">Sudah punya akun? <a href="#" onclick="switchTab('login');return false">Masuk</a></div>
      </div>

      <div class="divider">atau</div>
      <div style="text-align:center"><a href="index.php" style="font-size:13px;color:var(--muted)">← Kembali ke Beranda</a></div>

    </div>
  </div>
</div>

<script>
function switchTab(tab) {
  document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
  const idx = tab === 'login' ? 0 : 1;
  document.querySelectorAll('.auth-tab')[idx].classList.add('active');
  document.getElementById(tab === 'login' ? 'loginForm' : 'registerForm').classList.add('active');
}

function fillDemo(email, pass) {
  switchTab('login');
  document.getElementById('login-email').value = email;
  document.getElementById('login-pass').value = pass;
}

function togglePwd(id, btn) {
  const inp = document.getElementById(id);
  if (inp.type === 'password') { inp.type = 'text'; btn.textContent = '🙈'; }
  else { inp.type = 'password'; btn.textContent = '👁'; }
}

function checkStrength(v) {
  const bar = document.getElementById('strengthBar');
  let strength = 0;
  if (v.length >= 6) strength++;
  if (v.length >= 10) strength++;
  if (/[A-Z]/.test(v)) strength++;
  if (/[0-9]/.test(v)) strength++;
  if (/[^A-Za-z0-9]/.test(v)) strength++;
  const colors = ['','#ef4444','#f97316','#eab308','#22c55e','#16a34a'];
  const widths  = [0,20,40,60,80,100];
  bar.style.width  = widths[strength] + '%';
  bar.style.background = colors[strength] || '';
}
</script>
</body>
</html>