<?php

namespace App\Http\Controllers;

use App\Models\CancelRequest;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\Favorite;

class UserController extends Controller
{
    //
    public function openLogin(){
        return view('auth.login');
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

        // dd(
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

    return redirect()->route('login');
    }




public function getAllBookings(){
    $user = Auth::user();
    $bookings = $user->reservations()->with('property')->get();
    return view('users.my-bookings', compact('bookings'));
}



public function myBookings()
{
    if (Auth::check()) {
        $user = Auth::user();

        // 1. DATA AKOMODASI ASLI (Jangan di-transform gabungan)
        $bookings = $user->reservations()->latest()->get();
        $bookingIds = $bookings->pluck('id');
        $cancelRequests = CancelRequest::whereIn('reservation_id', $bookingIds)->get();

        try {
            $response = Http::get(env('API_BASE_URL') . '/units');
            $units = $response->successful() ? collect($response->json()) : collect();
        } catch (\Exception $e) {
            $units = collect();
        }

        $bookings->transform(function ($booking) use ($units, $cancelRequests) {
            if ($units->isNotEmpty()) {
                $booking->unit_details = $units->firstWhere('id', $booking->unit_id); 
            } else {
                $booking->unit_details = null;
            }
            $booking->cancel_request = $cancelRequests->firstWhere('reservation_id', $booking->id); 
            return $booking;
        });

        // 2. DATA PENERBANGAN (Dikirim terpisah)
        $flightBookings = $user->flightBookings()->with(['tickets.passenger', 'payment'])->latest()->get();
        
        // Ambil master rute penerbangan dari API
        try {
            $responseFlights = Http::get(env('API_BASE_URL') . '/flights');
            $apiFlights = $responseFlights->successful() ? collect(Http::get(env('API_BASE_URL') . '/flights')->json()) : collect();
            
            // --- AMBIL MASTER DATA AIRLINES DARI API ---
            $responseAirlines = Http::get(env('API_BASE_URL') . '/airlines');
            $airlinesMaster = $responseAirlines->successful() ? $responseAirlines->json() : [];
            $airlineMap = collect($airlinesMaster)->pluck('name', 'id')->toArray();
            // ───────────────────────────────────────────
        } catch (\Exception $e) {
            $apiFlights = collect();
            $airlineMap = [];
        }

        // Transformasikan data penerbangan agar menyertakan string nama 'airline' asli
        $flightBookings->transform(function ($fb) use ($apiFlights, $airlineMap) {
            $firstTicket = $fb->tickets->first();
            
            if ($firstTicket && $apiFlights->isNotEmpty()) {
                // Cari detail rute dari API Flights
                $matchedFlight = $apiFlights->firstWhere('id', $firstTicket->flight_id);
                
                if ($matchedFlight) {
                    // KUNCI PERBAIKAN: Suntikkan nama asli maskapai berdasarkan airline_id ke dalam flight_details
                    $matchedFlight['airline'] = $airlineMap[$matchedFlight['airline_id']] ?? 'Unknown Airline';
                    $fb->flight_details = $matchedFlight;
                } else {
                    $fb->flight_details = null;
                }
            } else {
                $fb->flight_details = null;
            }
            return $fb;
        });

        // dd([
        //     'Jumlah Flight Bookings' => $flightBookings->count(),
        //     'Sample Booking Code'    => $flightBookings->first()?->booking_code,
        //     'Apakah Punya Tiket?'    => $flightBookings->first()?->tickets->isNotEmpty(),
        //     'ID Flight dari Tiket'   => $flightBookings->first()?->tickets->first()?->flight_id,
        //     'Semua ID dari API'      => $apiFlights->pluck('id')->toArray(),
        //     'Isi Detail Penerbangan' => $flightBookings->first()?->flight_details,
        // ]);

    } else {
        $bookings = collect();
        $flightBookings = collect();
    }

    // Kirim kedua variabel ke satu halaman view Blade
    return view('users.my-bookings', compact('bookings', 'flightBookings'));
}



    public function home2(Request $request)
    {
        // dd([
        //     'Apakah Auth mengenali User?' => Auth::check(),
        //     'Data User saat ini'          => Auth::user(),
        //     'Session ID'                  => session()->getId(),
        //     'Semua Isi Session'           => session()->all(),
        //     'Isi Cookie Session Browser'  => $request->cookie(config('session.cookie')),
        // ]);

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
            $featuredProperties = $properties->shuffle()->take(8)->values();
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
    
public function requestCancellation(Request $request, $id)
{
    // 1. Validasi input alasan
    $request->validate([
        'reason' => 'required|string|max:500',
    ]);

    // 2. Ambil data booking milik user yang sedang login untuk memastikan keamanan
    $booking = Auth::user()->reservations()->findOrFail($id);

    // 3. Cek apakah user sudah pernah mengajukan pembatalan untuk booking ini sebelumnya
    $existingRequest = CancelRequest::where('reservation_id', $booking->id)->first();
    if ($existingRequest) {
        return redirect()->back()->with('error', 'Kamu sudah mengajukan pembatalan untuk reservasi ini.');
    }

    // 4. Simpan pengajuan ke table cancel_requests
    CancelRequest::create([
        'reservation_id'    => $booking->id,
        'flight_booking_id' => $booking->flight_booking_id ?? null, // Sesuaikan jika ada flight_booking_id
        'reason'            => $request->reason,
        'status'            => 'Pending', // Status default saat pertama diajukan
    ]);

    // 5. (Opsional) Mengubah status booking lokal menjadi 'Cancellation Requested' 
    // $booking->update(['status' => 'Pending Cancellation']);

    return redirect()->back()->with('success', 'Permintaan pembatalan berhasil dikirim. Menunggu konfirmasi admin.');
}

// public function renderFavorites()
// {
//     // Semua property_id favorit user
//     $favoriteIds = Favorite::where('user_id', Auth::id())
//         ->pluck('property_id')
//         ->toArray();

//     // Ambil semua property dari API
//     $response = Http::get(env('API_BASE_URL') . '/properties');

//     $properties = [];

//     if ($response->successful()) {

//         $allProperties = $response->json();

//         // Ambil hanya yang ada di favorites
//         $properties = collect($allProperties)
//             ->whereIn('id', $favoriteIds)
//             ->values();
//     }

//     return view('users.favorites', compact('properties'));
// }


public function renderFavorites()
{
    // 1. Ambil semua property_id favorit user saat ini
    $favoriteIds = Favorite::where('user_id', Auth::id())
        ->pluck('property_id')
        ->toArray();

    $properties = collect();

    // 2. Ambil data properties dan data units dari API
    try {
        $responseProperties = Http::get(env('API_BASE_URL') . '/properties');
        $responseUnits = Http::get(env('API_BASE_URL') . '/units');
        
        $apiProperties = $responseProperties->successful() ? collect($responseProperties->json()) : collect();
        $apiUnits = $responseUnits->successful() ? collect($responseUnits->json()) : collect();
    } catch (\Exception $e) {
        $apiProperties = collect();
        $apiUnits = collect();
    }

    if ($apiProperties->isNotEmpty()) {
        // Filter properti yang hanya di-favoritkan oleh user
        $properties = $apiProperties->whereIn('id', $favoriteIds)->values();

        // 3. Inject starting_price (harga unit termurah) ke setiap properti
        $properties->transform(function ($property) use ($apiUnits) {
            // Filter unit yang memiliki property_id yang sama dengan properti ini
            $propertyUnits = $apiUnits->filter(function ($unit) use ($property) {
                return $unit['property_id'] == $property['id'];
            });

            // Ambil harga paling minimum, jika tidak ada unit set default ke 0
            $minPrice = $propertyUnits->isNotEmpty() ? $propertyUnits->min('price') : 0;

            // Masukkan attribute baru 'starting_price' ke dalam array properti
            $property['starting_price'] = $minPrice;
            
            return $property;
        });
    }

    return view('users.favorites', compact('properties'));
}


public function addToFav(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return response()->json([
                'status' => 'unauthorized', 
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        $request->validate([
            'property_id' => 'required|string',
        ]);

        $userId = Auth::id();
        $propertyId = $request->property_id;

        // Cari tahu apakah item sudah difavoritkan sebelumnya
        $favorite = Favorite::where('user_id', $userId)
                            ->where('property_id', $propertyId)
                            ->first();

        if ($favorite) {
            // Jika sudah ada, hapus dari database (unfavorite)
            $favorite->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Dihapus dari daftar favorit.'
            ]);
        } else {
            // Jika belum ada, tambahkan ke database (favorite)
            Favorite::create([
                'user_id' => $userId,
                'property_id' => $propertyId,
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Berhasil disimpan ke daftar favorit.'
            ]);
        }
    }

}