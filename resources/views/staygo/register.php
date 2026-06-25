<?php
$pageTitle = 'StayGo - Create Account';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require '_head.php'; ?>
<style>
  .glass-panel-login {
    background-color: rgba(255,255,255,0.75);
    backdrop-filter: blur(30px); -webkit-backdrop-filter: blur(30px);
    border: 1px solid rgba(255,255,255,0.4);
    box-shadow: 0 32px 64px -12px rgba(0,76,226,0.12);
  }
</style>
</head>
<body class="bg-background text-on-background min-h-screen">
<main class="min-h-screen w-full flex items-center justify-center p-6 relative bg-cover bg-center"
  style="background-image: url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1600&q=80');">
  <div class="absolute inset-0 bg-white/30 backdrop-blur-sm pointer-events-none"></div>
  <div class="glass-panel-login w-full max-w-[520px] p-8 md:p-12 relative z-10 rounded-2xl my-8">
    <!-- Logo -->
    <div class="text-center mb-8">
      <a href="homepage.php" class="inline-flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-primary text-4xl icon-fill">flight_takeoff</span>
        <span class="font-display text-3xl font-extrabold tracking-tight text-on-surface">Stay<span class="text-primary">Go</span></span>
      </a>
      <h1 class="font-headline-md text-headline-md text-on-surface mb-1">Create your account</h1>
      <p class="font-body-md text-body-md text-on-surface-variant">Start your atmospheric travel journey.</p>
    </div>
    <!-- Form -->
    <form class="flex flex-col gap-5" onsubmit="handleRegister(event)">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-2">
          <label class="font-label-md text-label-md text-on-surface" for="firstname">First Name</label>
          <div class="relative flex items-center">
            <span class="material-symbols-outlined absolute left-4 text-outline pointer-events-none text-[20px]">person</span>
            <input class="w-full h-14 border border-outline-variant/40 bg-white/60 pl-11 pr-4 font-body-md text-body-md text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all rounded-xl" id="firstname" placeholder="Sarah" type="text">
          </div>
        </div>
        <div class="flex flex-col gap-2">
          <label class="font-label-md text-label-md text-on-surface" for="lastname">Last Name</label>
          <div class="relative flex items-center">
            <input class="w-full h-14 border border-outline-variant/40 bg-white/60 px-4 font-body-md text-body-md text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all rounded-xl" id="lastname" placeholder="Jenkins" required type="text">
          </div>
        </div>
      </div>
      <div class="flex flex-col gap-2">
        <label class="font-label-md text-label-md text-on-surface" for="email">Email Address</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-outline pointer-events-none">mail</span>
          <input class="w-full h-14 border border-outline-variant/40 bg-white/60 pl-12 pr-4 font-body-md text-body-md text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all rounded-xl" id="email" placeholder="hello@staygo.com" type="email">
        </div>
      </div>
      <div class="flex flex-col gap-2">
        <label class="font-label-md text-label-md text-on-surface" for="phone">Phone Number</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-outline pointer-events-none">phone</span>
          <input class="w-full h-14 border border-outline-variant/40 bg-white/60 pl-12 pr-4 font-body-md text-body-md text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all rounded-xl" id="phone" placeholder="+1 (555) 000-0000" type="tel">
        </div>
      </div>
      <div class="flex flex-col gap-2">
        <label class="font-label-md text-label-md text-on-surface" for="password">Password</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-outline pointer-events-none">lock</span>
          <input class="w-full h-14 border border-outline-variant/40 bg-white/60 pl-12 pr-12 font-body-md text-body-md text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all rounded-xl" id="password" placeholder="Min. 8 characters" type="password" minlength="8">
          <button type="button" onclick="togglePwd()" class="absolute right-4 text-outline hover:text-on-surface">
            <span class="material-symbols-outlined text-[20px]" id="pwd-eye">visibility_off</span>
          </button>
        </div>
      </div>
      <label class="flex items-start gap-3 cursor-pointer mt-1">
        <input class="w-5 h-5 mt-0.5 rounded border-2 border-outline-variant text-primary shrink-0" type="checkbox">
        <span class="font-body-md text-body-md text-on-surface-variant">I agree to the <a href="#" class="text-primary hover:underline">Terms of Service</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a></span>
      </label>
      <button class="mt-2 w-full h-14 bg-gradient-to-r from-primary to-secondary-container text-on-primary font-label-md text-label-md shadow-lg hover:scale-[1.02] hover:shadow-xl active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 rounded-xl" type="submit">
        <span>Create Account</span>
        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
      </button>
    </form>
    <div class="mt-6 text-center">
      <p class="font-body-md text-body-md text-on-surface-variant">
        Already have an account?
        <a class="font-label-md text-label-md text-primary hover:underline ml-1" href="login.php">Sign in</a>
      </p>
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
  function handleRegister(e) {
    e.preventDefault();
    window.location.href = 'homepage.php';
  }
</script>
</body>
</html>