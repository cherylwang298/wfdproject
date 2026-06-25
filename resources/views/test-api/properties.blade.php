<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Properties</title>
</head>
<body>

    <h1 class="text-3xl font-bold mb-8 text-slate-800">
    All Property
</h1>
    
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
   @forelse($featured as $p)
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold">
            {{ $p['name'] }}
        </h2>

        <h2 class="text-xl font-bold">
            {{ $p['type'] }}
        </h2>

        <h2 class="text-xl font-bold">
            {{ $p['city'] }}
        </h2>

        <h2 class="text-xl font-bold">
            {{ $p['address'] }}
        </h2>

        <h2 class="text-xl font-bold">
            {{ $p['description'] }}
        </h2>
    </div>
    
@empty
    <p>No Property found</p>
@endforelse
</div>

    
</body>
</html>
