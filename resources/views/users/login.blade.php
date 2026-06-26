<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold">Login</h1>
        <p class="text-gray-500 mt-2">Welcome back</p>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block mb-2 font-medium">Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="w-full border rounded-lg px-4 py-3"
            >
        </div>

        <div>
            <label class="block mb-2 font-medium">Password</label>
            <input
                type="password"
                name="password"
                required
                class="w-full border rounded-lg px-4 py-3"
            >
        </div>

        <button
            type="submit"
            class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700"
        >
            Login
        </button>
    </form>

    <div class="text-center mt-5">
        <p>
            Don't have an account?
            <a href="{{ route('register.form') }}" class="text-green-600 font-semibold">
                Register
            </a>
        </p>
    </div>

</div>

</body>
</html>