<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayGo - Create Account</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-panel-login {
            background-color: rgba(255,255,255,0.75);
            backdrop-filter: blur(30px); -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255,255,255,0.4);
            box-shadow: 0 32px 64px -12px rgba(0,76,226,0.12);
        }
        .icon-fill { font-variant-numeric: tabular-nums; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

<main class="min-h-screen w-full flex items-center justify-center p-6 relative bg-cover bg-center"
  style="background-image: url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1600&q=80');">
  
  <div class="absolute inset-0 bg-white/30 backdrop-blur-sm pointer-events-none"></div>
  
  <div class="glass-panel-login w-full max-w-[520px] p-8 md:p-12 relative z-10 rounded-2xl my-8">
    
    <div class="text-center mb-8">
      <a href="/" class="inline-flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-blue-600 text-4xl icon-fill">flight_takeoff</span>
        <span class="font-sans text-3xl font-extrabold tracking-tight text-gray-800">Stay<span class="text-blue-600">Go</span></span>
      </a>
      <h1 class="text-2xl font-extrabold text-gray-800 mb-1">Create your account</h1>
      <p class="text-sm font-medium text-gray-500">Start your atmospheric travel journey.</p>
    </div>

    {{-- LARAVEL ERRORS ALERT --}}
    @if ($errors->any())
        <div class="mb-5 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST" class="flex flex-col gap-5">
      @csrf

      {{-- ROW FIRST & LAST NAME --}}
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-2">
          <label class="text-sm font-semibold text-gray-700" for="first_name">First Name</label>
          <div class="relative flex items-center">
            <span class="material-symbols-outlined absolute left-4 text-gray-400 pointer-events-none text-[20px]">person</span>
            <input 
              class="w-full h-14 border border-gray-200 bg-white/60 pl-11 pr-4 text-sm font-medium text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all rounded-xl" 
              id="first_name" 
              name="first_name"
              value="{{ old('first_name') }}"
              placeholder="Sarah" 
              type="text" 
              required>
          </div>
        </div>
        <div class="flex flex-col gap-2">
          <label class="text-sm font-semibold text-gray-700" for="last_name">Last Name</label>
          <div class="relative flex items-center">
            <input 
              class="w-full h-14 border border-gray-200 bg-white/60 px-4 text-sm font-medium text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all rounded-xl" 
              id="last_name" 
              name="last_name"
              value="{{ old('last_name') }}"
              placeholder="Jenkins" 
              type="text" 
              required>
          </div>
        </div>
      </div>

      {{-- FIELD USERNAME --}}
      <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-gray-700" for="username">Username</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-gray-400 pointer-events-none text-[20px]">badge</span>
          <input 
            class="w-full h-14 border border-gray-200 bg-white/60 pl-12 pr-4 text-sm font-medium text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all rounded-xl" 
            id="username" 
            name="username"
            value="{{ old('username') }}"
            placeholder="sarahjenkins" 
            type="text" 
            required>
        </div>
      </div>

      {{-- FIELD EMAIL --}}
      <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-gray-700" for="email">Email Address</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-gray-400 pointer-events-none">mail</span>
          <input 
            class="w-full h-14 border border-gray-200 bg-white/60 pl-12 pr-4 text-sm font-medium text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all rounded-xl" 
            id="email" 
            name="email"
            value="{{ old('email') }}"
            placeholder="hello@staygo.com" 
            type="email" 
            required>
        </div>
      </div>

      {{-- FIELD PHONE NUMBER --}}
      <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-gray-700" for="phone">Phone Number</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-gray-400 pointer-events-none">phone</span>
          <input 
            class="w-full h-14 border border-gray-200 bg-white/60 pl-12 pr-4 text-sm font-medium text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all rounded-xl" 
            id="phone" 
            name="phone"
            value="{{ old('phone') }}"
            placeholder="081234567890" 
            type="tel">
        </div>
      </div>

      {{-- FIELD PASSWORD --}}
      <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-gray-700" for="password">Password</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-gray-400 pointer-events-none">lock</span>
          <input 
            class="w-full h-14 border border-gray-200 bg-white/60 pl-12 pr-12 text-sm font-medium text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all rounded-xl" 
            id="password" 
            name="password"
            placeholder="Min. 8 characters" 
            type="password" 
            required 
            minlength="8">
          <button type="button" onclick="togglePwd('password', 'pwd-eye')" class="absolute right-4 text-gray-400 hover:text-gray-700">
            <span class="material-symbols-outlined text-[20px]" id="pwd-eye">visibility_off</span>
          </button>
        </div>
      </div>

      {{-- FIELD CONFIRM PASSWORD --}}
      <div class="flex flex-col gap-2">
        <label class="text-sm font-semibold text-gray-700" for="password_confirmation">Confirm Password</label>
        <div class="relative flex items-center">
          <span class="material-symbols-outlined absolute left-4 text-gray-400 pointer-events-none">lock_reset</span>
          <input 
            class="w-full h-14 border border-gray-200 bg-white/60 pl-12 pr-12 text-sm font-medium text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all rounded-xl" 
            id="password_confirmation" 
            name="password_confirmation"
            placeholder="Repeat your password" 
            type="password" 
            required>
          <button type="button" onclick="togglePwd('password_confirmation', 'pwd-eye-confirm')" class="absolute right-4 text-gray-400 hover:text-gray-700">
            <span class="material-symbols-outlined text-[20px]" id="pwd-eye-confirm">visibility_off</span>
          </button>
        </div>
      </div>

      {{-- TERMS & POLICY AGREEMENT --}}
      <label class="flex items-start gap-3 cursor-pointer mt-1 select-none">
        <input class="w-5 h-5 mt-0.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500/20 shrink-0" type="checkbox" required>
        <span class="text-sm font-medium text-gray-500">I agree to the <a href="#" class="text-blue-600 hover:underline font-bold">Terms of Service</a> and <a href="#" class="text-blue-600 hover:underline font-bold">Privacy Policy</a></span>
      </label>

      {{-- SUBMIT BUTTON --}}
      <button class="mt-2 w-full h-14 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm shadow-md hover:scale-[1.02] hover:shadow-xl active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 rounded-xl" type="submit">
        <span>Create Account</span>
        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
      </button>
    </form>

    {{-- BACK TO LOGIN --}}
    <div class="mt-6 text-center">
      <p class="text-sm font-medium text-gray-500">
        Already have an account?
        <a class="text-sm font-bold text-blue-600 hover:underline ml-1" href="{{ route('login') }}">Sign in</a>
      </p>
    </div>
  </div>
</main>


<script>
  function togglePwd(inputId, eyeId) {
    const inp = document.getElementById(inputId);
    const eye = document.getElementById(eyeId);
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