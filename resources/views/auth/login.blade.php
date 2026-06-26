<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayGo - Sign In</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-panel-login {
            background-color: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 32px 64px -12px rgba(0, 76, 226, 0.12);
        }
        .icon-fill { font-variant-numeric: tabular-nums; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

<main class="min-h-screen w-full flex items-center justify-center p-6 relative bg-cover bg-center"
  style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAcDFYMpK1t2fQy0PNLJ39LjJOoKXKsH5ivanMDd7XZ1LuYK2D9gFrKBwDOCitLds4TFuE9ZcQ6Lf7Jkx0Nj82hC2mqtWG8lztSRaLvEAoi-zi37DwB5K9yW8ib6oSIC89oAn3ir9wNZnS-79YqBtmFI2yMIM0dOhxodVMmOiF69vAMnUgT2PWvRvAnhzhjn6vvrQ7dl2SZ7WGCw9u-01yuMHGWaYAmEtBd_J3CT9wznRndY4ii2FP84gudRBp4DfOMpojMt5xqHkY');">
  
  <div class="absolute inset-0 bg-white/20 mix-blend-overlay pointer-events-none"></div>
  
  <div class="glass-panel-login w-full max-w-[480px] p-8 md:p-12 relative z-10 rounded-2xl">
    
    {{-- LOGO BRANDING --}}
    <div class="text-center mb-8">
      <a href="/" class="inline-flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-blue-600 text-4xl icon-fill">flight_takeoff</span>
        <span class="font-sans text-3xl font-extrabold tracking-tight text-gray-800">Stay<span class="text-blue-600">Go</span></span>
      </a>
      <p class="text-sm font-medium text-gray-500">Your atmospheric travel companion.</p>
    </div>

    {{-- LARAVEL ALERT MESSAGES --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM SUBMIT LOGIN --}}
    <form action="{{ route('login.submit') }}" method="POST" class="flex flex-col gap-6">
      @csrf

      {{-- INPUT FIELD EMAIL --}}
      <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-gray-700" for="email">Email Address</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-gray-400 pointer-events-none">mail</span>
          <input 
            class="w-full h-16 border border-gray-200 bg-white/60 pl-12 pr-4 text-sm font-medium text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all duration-300 rounded-xl" 
            id="email" 
            name="email"
            value="{{ old('email') }}"
            placeholder="hello@staygo.com" 
            type="email" 
            required>
        </div>
      </div>

      {{-- INPUT FIELD PASSWORD --}}
      <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-gray-700" for="password">Password</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-gray-400 pointer-events-none">lock</span>
          <input 
            class="w-full h-16 border border-gray-200 bg-white/60 pl-12 pr-12 text-sm font-medium text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all duration-300 rounded-xl" 
            id="password" 
            name="password"
            placeholder="••••••••" 
            type="password" 
            required>
          <button type="button" onclick="togglePwd()" class="absolute right-4 text-gray-400 hover:text-gray-700 transition-colors">
            <span class="material-symbols-outlined text-[20px]" id="pwd-eye">visibility_off</span>
          </button>
        </div>
      </div>

      {{-- REMEMBER ME & FORGOT PASSWORD --}}
      <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer select-none">
          <input 
            class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500/20" 
            type="checkbox" 
            name="remember" 
            id="remember">
          <span class="text-sm font-medium text-gray-500">Remember me</span>
        </label>
        <a class="text-sm font-semibold text-blue-600 hover:underline" href="#">Forgot Password?</a>
      </div>

      {{-- BUTTON SUBMIT --}}
      <button class="mt-2 w-full h-16 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm shadow-md hover:scale-[1.02] hover:shadow-xl active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 rounded-xl" type="submit">
        <span>Sign In</span>
        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
      </button>
    </form>

    {{-- NAVIGASI FOOTER REGISTER --}}
    <div class="mt-8 text-center">
      <p class="text-sm font-medium text-gray-500">
        Don't have an account?
        <a class="text-sm font-bold text-blue-600 hover:underline ml-1" href="{{ route('register.form') }}">Sign up</a>
      </p>
    </div>

    {{-- TOMBOL BACK TO HOMEPAGE --}}
    <div class="mt-6 text-center">
      <a href="/" class="text-xs font-semibold text-gray-400 hover:text-blue-600 transition-colors flex items-center justify-center gap-1">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span>Back to homepage
      </a>
    </div>

  </div>
</main>

{{-- INTERACTIVE JAVASCRIPT --}}
<script>
  function togglePwd() {
    const inp = document.getElementById('password');
    const eye = document.getElementById('pwd-eye');
    if (inp.type === 'password') {
        inp.type = 'text';
        eye.textContent = 'visibility';
    } else {
        inp.type = 'password';
        eye.textContent = 'visibility_off';
    }
  }
</script>
</body>
</html>