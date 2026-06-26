<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-lg bg-white rounded-2xl shadow-lg p-8">

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold">Create Account</h1>
        <p class="text-gray-500 mt-2">Register to start booking</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block mb-2 font-medium">First Name</label>
            <input
                type="text"
                name="first_name"
                value="{{ old('first_name') }}"
                required
                class="w-full border rounded-lg px-4 py-3"
            >
        </div>

        
        <div>
            <label class="block mb-2 font-medium">Last Name</label>
            <input
                type="text"
                name="last_name"
                value="{{ old('last_name') }}"
                required
                class="w-full border rounded-lg px-4 py-3"
            >
        </div>

        
        <div>
            <label class="block mb-2 font-medium">Username</label>
            <input
                type="text"
                name="username"
                value="{{ old('username') }}"
                required
                class="w-full border rounded-lg px-4 py-3"
            >
        </div>

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
            <label class="block mb-2 font-medium">Phone Number</label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
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

        <div>
            <label class="block mb-2 font-medium">Confirm Password</label>
            <input
                type="password"
                name="password_confirmation"
                required
                class="w-full border rounded-lg px-4 py-3"
            >
        </div>

        <button
            type="submit"
            class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700"
        >
            Register
        </button>
    </form>

    <div class="text-center mt-5">
        <p class="text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}"
               class="text-blue-600 font-semibold">
                Login
            </a>
        </p>
    </div>

</div>

</body>
</html>

