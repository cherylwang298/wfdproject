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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .glass-panel-login {
            background-color: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 32px 64px -12px rgba(0, 76, 226, 0.12);
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen">
<main class="min-h-screen w-full flex items-center justify-center p-6 relative bg-cover bg-center"
      style="background-image: url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=1200');">
    <div class="absolute inset-0 bg-white/20 mix-blend-overlay pointer-events-none"></div>
    
    <div class="glass-panel-login w-full max-w-[480px] p-8 md:p-12 relative z-10 rounded-2xl">
        <div class="text-center mb-8">
            <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary text-4xl icon-fill">flight_takeoff</span>
                <span class="font-display text-3xl font-extrabold tracking-tight text-on-surface">Stay<span class="text-primary">Go</span></span>
            </a>
            <p class="text-body-md text-on-surface-variant">Your atmospheric travel companion.</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form class="flex flex-col gap-6" method="POST" action="{{ route('login.post') }}">
            @csrf <div class="flex flex-col gap-2">
                <label class="text-label-md text-on-surface font-semibold" for="email">Email Address</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-outline pointer-events-none">mail</span>
                    <input class="w-full h-16 border border-outline-variant/40 bg-white/60 pl-12 pr-4 text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-300 rounded-xl" 
                           id="email" name="email" value="{{ old('email') }}" placeholder="hello@staygo.com" type="email" required>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-label-md text-on-surface font-semibold" for="password">Password</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-outline pointer-events-none">lock</span>
                    <input class="w-full h-16 border border-outline-variant/40 bg-white/60 pl-12 pr-12 text-on-surface placeholder:text-outline-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-300 rounded-xl" 
                           id="password" name="password" placeholder="••••••••" type="password" required>
                    <button type="button" onclick="togglePwd()" class="absolute right-4 text-outline hover:text-on-surface transition-colors">
                        <span class="material-symbols-outlined text-[20px]" id="pwd-eye">visibility_off</span>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input class="w-5 h-5 rounded border-2 border-outline-variant text-primary focus:ring-primary/20" name="remember" type="checkbox">
                    <span class="text-body-md text-on-surface-variant">Remember me</span>
                </label>
                <a class="text-label-md text-primary hover:underline" href="#">Forgot Password?</a>
            </div>

            <button class="mt-2 w-full h-16 bg-gradient-to-r from-primary to-secondary-container text-on-primary font-semibold shadow-lg hover:scale-[1.02] hover:shadow-xl active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 rounded-xl" type="submit">
                <span>Sign In</span>
                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-body-md text-on-surface-variant">
                Don't have an account?
                <a class="text-primary hover:underline ml-1" href="{{ route('register') }}">Sign up</a>
            </p>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('homepage') }}" class="text-label-sm text-on-surface-variant hover:text-primary transition-colors inline-flex items-center gap-1">
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
</script>
</body>
</html>