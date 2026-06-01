<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('title')

    @yield('style')
</head>
<body>
    @yield('content')

    {{-- <h1 class="text-center text-7xl font-bold text-blue-300">Tes</h1> --}}

    @yield('script')
</body>
</html>