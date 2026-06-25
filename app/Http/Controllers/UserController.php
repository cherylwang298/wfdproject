<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\Promo;

class UserController extends Controller
{
    //
    public function openLogin(){
        return view('dummy_pages.users.login');
    }
 
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    return back()
        ->withInput()
        ->withErrors([
            'email' => 'Email atau password salah.',
        ]);
}

      public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('login.form')
            ->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request)
    {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login.form');
    }

 public function home()
{
    $response = Http::get(env('API_BASE_URL') . '/properties');

    if (!$response->successful()) {
        return view('dummy_pages.home', [
            'properties' => collect(),
            'featured' => collect(),
            'hotels' => collect(),
            'villas' => collect(),
        ]);
    }

    $properties = collect($response->json());

    $featured = $properties
        ->shuffle()
        ->take(6)
        ->values();

    $hotels = $properties
        ->where('type', 'hotel')
        ->values();

    $villas = $properties
        ->where('type', 'villa')
        ->values();

    $availPromos = Promo::all();

$promos = $availPromos
    ->shuffle()
    ->take(3)
    ->values();

return view('dummy_pages.home', compact(
    'properties',
    'featured',
    'hotels',
    'villas',
    'promos'
));


   
}

    public function home2()
    {
        // 1. Ambil data properti dari API
        $responseProperties = Http::get(env('API_BASE_URL') . '/properties');

        // 2. Ambil data penerbangan dari API Flights
        $flights = collect();
        try {
            $responseFlights = Http::get(env('API_BASE_URL') . '/flights'); // Hubungkan ke endpoint /units atau /flights Anda di API
            if ($responseFlights->successful()) {
                $flights = collect($responseFlights->json());
            }
        } catch (\Exception $e) {
            // Tetap biarkan kosong atau isi fallback jika API Flights mati
        }

        // 3. Ambil 3 promo random dari DB lokal
        $availPromos = Promo::all();
        $promos = $availPromos->shuffle()->take(3)->values();

        // 4. Proses data Properites jika API berhasil
        if ($responseProperties->successful()) {
            $properties = collect($responseProperties->json());
            $featuredProperties = $properties->shuffle()->take(6)->values();
        } else {
            $featuredProperties = collect();
        }

        // 5. Ambil 4 flights secara random dari API jika data flights tersedia
        $featuredRoutes = collect();
        if ($flights->isNotEmpty()) {
            // Jika data di database kurang dari 4, ambil semua yang ada agar tidak error
            $takeCount = $flights->count() >= 4 ? 4 : $flights->count();
            $featuredRoutes = $flights->random($takeCount)->values();
        } else {
            // Fallback dummy jika database penerbangan di API bener-bener kosong
            $featuredRoutes = collect([
                ['origin' => 'CGK', 'destination' => 'DPS', 'class' => 'economy', 'price' => 750000],
                ['origin' => 'SUB', 'destination' => 'SIN', 'class' => 'economy', 'price' => 1200000],
                ['origin' => 'CGK', 'destination' => 'NRT', 'class' => 'business', 'price' => 3500000],
                ['origin' => 'DPS', 'destination' => 'SYD', 'class' => 'economy', 'price' => 2800000],
            ]);
        }

        // Data static traveler stories
        $testimonials = collect([
            ['initials'=>'SJ','name'=>'Sarah Jenkins','sub'=>'Traveled to Santorini','rating'=>5,'quote'=>"Booking our honeymoon through StayGo was an absolute dream.",'color'=>'bg-primary-container text-on-primary-container'],
            ['initials'=>'MR','name'=>'Michael Ross','sub'=>'Frequent Flyer','rating'=>5,'quote'=>"I travel for business constantly. StayGo helps me manage flights and hotels.",'color'=>'bg-tertiary-container text-on-tertiary-container'],
            ['initials'=>'EL','name'=>'Emma Lin','sub'=>'Family Traveler','rating'=>4.5,'quote'=>"The flight price tracking feature saved us over $300 on our family trip!",'color'=>'bg-secondary-container text-on-secondary-container'],
        ]);

        return view('homepage', compact(
            'featuredProperties',
            'promos',
            'featuredRoutes',
            'testimonials'
        ));
    }


}