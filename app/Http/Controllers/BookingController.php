<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function openBookingPage(Request $request, $id)
    {
        // 1. Ambil data dari API
        $units = collect(Http::get(env('API_BASE_URL').'/units')->json());
        $properties = collect(Http::get(env('API_BASE_URL').'/properties')->json());
        $images = collect(Http::get(env('API_BASE_URL').'/images')->json());

        // 2. Cari unit dan property terkait
        $unit = $units->firstWhere('id', $id);
        if (!$unit) {
            abort(404, 'Unit tidak ditemukan');
        }
        $property = $properties->firstWhere('id', $unit['property_id']);

        // 3. Ambil tanggal dari request (fallback ke hari ini & besok jika kosong)
        $checkin = $request->query('checkin', now()->toDateString());
        $checkout = $request->query('checkout', now()->addDay()->toDateString());

        // 4. Hitung selisih malam (Nights)
        $dateIn = Carbon::parse($checkin);
        $dateOut = Carbon::parse($checkout);
        $nights = $dateIn->diffInDays($dateOut);
        $nights = $nights > 0 ? $nights : 1; // Minimal 1 malam jika input keliru

        // 5. Hitung total harga
        $totalPrice = $unit['price'] * $nights;

        // 6. Ambil data user login
        $user = auth()->user();

        // $fullname = $user->firstname . ' ' . $user->lastname;
        if (empty($user->last_name)) {
            $fullname = $user->first_name;
        } elseif (empty($user->first_name)) {
            $fullname = $user->last_name;
        } else {
            $fullname = $user->first_name . ' ' . $user->last_name;
        }

        // 7. Ambil gambar unit jika ada
        $unit['image'] = $images->where('unit_id', $id)->first();

        return view('dummy_pages.users.bookings', compact(
            'unit', 
            'property', 
            'checkin', 
            'checkout', 
            'nights', 
            'totalPrice', 
            'user',
            'fullname'
        ));
    }

    public function storeBooking(Request $request)
{
    $request->validate([
        'unit_id' => 'required',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
        'total_price' => 'required|numeric',

        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',

        'payment_method' => 'required'
    ]);

    DB::beginTransaction();

    try {

        /*
        |--------------------------------------------------------------------------
        | Reservation (Main Repo)
        |--------------------------------------------------------------------------
        */

        $reservation = Reservation::create([

            'user_id' => auth()->id(),

            'unit_id' => $request->unit_id,

            'check_in' => $request->check_in,

            'check_out' => $request->check_out,

            'total_price' => $request->total_price,

             'guest_name' => $request->name,

            'guest_email' => $request->email,

            'guest_phone_number' => $request->phone,

            'status' => 'Confirmed',

            'payment_status' => 'Paid',

            'promo_id' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Payment (Main Repo)
        |--------------------------------------------------------------------------
        */

        Payment::create([

            'reservation_id' => $reservation->id,

            'method' => $request->payment_method,

            'amount' => $reservation->total_price,

            'status' => 'Paid',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Reservation (API Repo)
        |--------------------------------------------------------------------------
        */

        // $response = Http::post(
        //     env('API_BASE_URL').'/reservations',
        //     [

        //         'unit_id' => $reservation->unit_id,

        //         'check_in' => $reservation->check_in,

        //         'check_out' => $reservation->check_out,

        //         'application_reservation_id' => $reservation->id,

        //     ]
        // );

        $response = Http::post(env('API_BASE_URL').'/reservations', [
    'unit_id'    => $reservation->unit_id,
    'check_in'   => $reservation->check_in->format('Y-m-d'),  // Dipaksa jadi format '2026-06-26'
    'check_out'  => $reservation->check_out->format('Y-m-d'), // Dipaksa jadi format '2026-06-27'
    'application_reservation_id' => $reservation->id,
]);

       if (!$response->successful()) {
    // Mengambil response body dari API (apakah error validasi atau error database)
    $apiError = $response->body();
    
    // Melempar error asli dari API agar muncul di halaman web kamu
    throw new \Exception('Gagal di API Repo. Detail: ' . $apiError);
}

        DB::commit();

        return redirect()
            ->route('booking.success')
            ->with('success', 'Booking berhasil dibuat.');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}
}