<?php

namespace App\Http\Controllers;

use App\Models\CancelRequest;
use App\Models\Payment;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function openBookingPage(Request $request, $id)
    {
      
        $units = collect(Http::get(env('API_BASE_URL').'/units')->json());
        $properties = collect(Http::get(env('API_BASE_URL').'/properties')->json());
        $images = collect(Http::get(env('API_BASE_URL').'/images')->json());

      
        $unit = $units->firstWhere('id', $id);
        if (!$unit) {
            abort(404, 'Unit tidak ditemukan');
        }
        $property = $properties->firstWhere('id', $unit['property_id']);

      
        $checkin = $request->query('checkin', now()->toDateString());
        $checkout = $request->query('checkout', now()->addDay()->toDateString());

     
        $dateIn = Carbon::parse($checkin);
        $dateOut = Carbon::parse($checkout);
        $nights = $dateIn->diffInDays($dateOut);
        $nights = $nights > 0 ? $nights : 1; 

    
        $accomPrice = $unit['price'] * $nights;
        $totalPrice = $accomPrice + ($accomPrice * 0.11);

       
        $user = auth()->user();

        
        if (empty($user->last_name)) {
            $fullname = $user->first_name;
        } elseif (empty($user->first_name)) {
            $fullname = $user->last_name;
        } else {
            $fullname = $user->first_name . ' ' . $user->last_name;
        }


        $unit['image'] = $images->where('unit_id', $id)->first();

        return view('users.bookings', compact(
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

        'payment_method' => 'required',
        'promo_id' => 'nullable'
    ]);



    DB::beginTransaction();

    try {
   
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
            'promo_id' => $request->promo_id,
        ]);

      


        Payment::create([
            'reservation_id' => $reservation->id,
            'method' => $request->payment_method,
            'amount' => $reservation->total_price,
            'status' => 'Paid',
        ]);

     

        $response = Http::post(env('API_BASE_URL').'/reservations', [
    'unit_id'    => $reservation->unit_id,
    'check_in'   => $reservation->check_in->format('Y-m-d'),  
    'check_out'  => $reservation->check_out->format('Y-m-d'), 
    'application_reservation_id' => $reservation->id,
]);

       if (!$response->successful()) {
    $apiError = $response->body();
    
    throw new \Exception('Gagal di API Repo. Detail: ' . $apiError);
}

        DB::commit();

        return redirect()
            ->route('bookings.success')
            ->with('success', 'Booking berhasil dibuat.');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

 
    public function requestFlightCancel(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        $existingRequest = CancelRequest::where('flight_booking_id', $id)
            ->whereIn('status', ['pending', 'approved'])
            ->orderByRaw("FIELD(status, 'approved', 'pending') ASC")
            ->first();

        if ($existingRequest) {
            if ($existingRequest->status === 'approved') {
                return back()->with('error', 'Penerbangan ini sudah berhasil dibatalkan sebelumnya.');
            }
            return back()->with('error', 'Anda sudah mengirimkan permohonan pembatalan untuk penerbangan ini dan sedang menunggu persetujuan.');
        }

        DB::beginTransaction();
        try {
            CancelRequest::create([
                'flight_booking_id' => $id,
                'user_id'           => auth()->id(),
                'reason'            => $request->reason,
                'status'            => 'pending'
            ]);

            DB::commit();
            return back()->with('success', 'Permohonan pembatalan penerbangan Anda berhasil dikirim.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengirim permohonan pembatalan: ' . $e->getMessage());
        }
    }
}