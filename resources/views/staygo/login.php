<?php
$pageTitle = 'StayGo - Sign In';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?>
<style>
  .glass-panel-login {
    background-color: rgba(255,255,255,0.75);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255,255,255,0.4);
    box-shadow: 0 32px 64px -12px rgba(0,76,226,0.12);
  }
</style>
</head>
<body class="bg-background text-on-background min-h-screen">
<main class="min-h-screen w-full flex items-center justify-center p-6 relative bg-cover bg-center"
  style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAcDFYMpK1t2fQy0PNLJ39LjJOoKXKsH5ivanMDd7XZ1LuYK2D9gFrKBwDOCitLds4TFuE9ZcQ6Lf7Jkx0Nj82hC2mqtWG8lztSRaLvEAoi-zi37DwB5K9yW8ib6oSIC89oAn3ir9wNZnS-79YqBtmFI2yMIM0dOhxodVMmOiF69vAMnUgT2PWvRvAnhzhjn6vvrQ7dl2SZ7WGCw9u-01yuMHGWaYAmEtBd_J3CT9wznRndY4ii2FP84gudRBp4DfOMpojMt5xqHkY');">
  <div class="absolute inset-0 bg-white/20 mix-blend-overlay pointer-events-none"></div>
  <div class="glass-panel-login w-full max-w-[480px] p-8 md:p-12 relative z-10 rounded-2xl">
    <div class="text-center mb-8">
      <a href="homepage.php" class="inline-flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-primary text-4xl icon-fill">flight_takeoff</span>
        <span class="font-display text-3xl font-extrabold tracking-tight text-on-surface">Stay<span class="text-primary">Go</span></span>
      </a>
      <p class="font-body-md text-body-md text-on-surface-variant">Your atmospheric travel companion.</p>
    </div>
    <form class="flex flex-col gap-6" onsubmit="handleLogin(event)">
      <div class="flex flex-col gap-2">
        <label class="font-label-md text-label-md text-on-surface" for="email">Email Address</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-outline pointer-events-none">mail</span>
          <input class="w-full h-16 border border-outline-variant/40 bg-white/60 pl-12 pr-4 font-body-md text-body-md text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-300 rounded-xl" id="email" placeholder="hello@staygo.com" type="email">
        </div>
      </div>
      <div class="flex flex-col gap-2">
        <label class="font-label-md text-label-md text-on-surface" for="password">Password</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-outline pointer-events-none">lock</span>
          <input class="w-full h-16 border border-outline-variant/40 bg-white/60 pl-12 pr-12 font-body-md text-body-md text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-300 rounded-xl" id="password" placeholder="••••••••" type="password">
          <button type="button" onclick="togglePwd()" class="absolute right-4 text-outline hover:text-on-surface transition-colors">
            <span class="material-symbols-outlined text-[20px]" id="pwd-eye">visibility_off</span>
          </button>
        </div>
      </div>
      <div class="flex items-center justify-between">
        <label class="flex items-center gap-3 cursor-pointer">
          <input class="w-5 h-5 rounded border-2 border-outline-variant text-primary focus:ring-primary/20" type="checkbox">
          <span class="font-body-md text-body-md text-on-surface-variant">Remember me</span>
        </label>
        <a class="font-label-md text-label-md text-primary hover:underline" href="#">Forgot Password?</a>
      </div>
      <button class="mt-2 w-full h-16 bg-gradient-to-r from-primary to-secondary-container text-on-primary font-label-md text-label-md shadow-lg hover:scale-[1.02] hover:shadow-xl active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 rounded-xl" type="submit">
        <span>Sign In</span>
        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
      </button>
    </form>
    <div class="mt-8 text-center">
      <p class="font-body-md text-body-md text-on-surface-variant">
        Don't have an account?
        <a class="font-label-md text-label-md text-primary hover:underline ml-1" href="register.php">Sign up</a>
      </p>
    </div>
    <div class="mt-6 text-center">
      <a href="homepage.php" class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors flex items-center justify-center gap-1">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span>Back to homepage
      </a>
    </div>
  </div>
</main>
<script>
  function togglePwd() {
    const inp = document.getElementById('password');
    const eye = document.getElementById('pwd-eye');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    eye.textContent = inp.type === 'password' ? 'visibility_off' : 'visibility';
  }
  function handleLogin(e) {
    e.preventDefault();
    window.location.href = 'homepage.php';
  }
</script>
</body>
</html>