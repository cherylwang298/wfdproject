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
        //    dd('LOGIN BERHASIL');

        $request->session()->regenerate();

    //      dd(
    //     Auth::check(),
    //     Auth::id(),
    //     session()->all()
    // );

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

 public function home(Request $request)
{

    // dd(Auth::check(), Auth::user());

    //  dd(
    //     session()->getId(),
    //     $request->cookie(config('session.cookie')),
    //     Auth::check(),
    //     Auth::user()
    // );
    $response = Http::get(env('API_BASE_URL') . '/properties');

    $user = Auth::user();

    if (!$response->successful()) {
        return view('dummy_pages.home', [
            'properties' => collect(),
            'featured' => collect(),
            'hotels' => collect(),
            'villas' => collect(),
            // 'user' => $user
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
    // 'user'
));   
}

    }
