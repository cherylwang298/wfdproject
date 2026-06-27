<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use App\Models\FlightBooking;
use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FlightCheckoutController extends Controller
{
    /**
     * Menampilkan halaman Form Checkout Penerbangan
     */
    public function showCheckout(Request $request)
    {
        $outboundId = $request->query('outbound');
        $inboundId = $request->query('inbound');
        $adults = (int) $request->query('adults', 1);
        $children = (int) $request->query('children', 0);
        $totalPassengers = $adults + $children;

        // 1. Ambil data master flights dari API
        $response = Http::get(env('API_BASE_URL') . '/flights');
        $rawFlights = $response->successful() ? $response->json() : [];

        // 2. Ambil master data Airlines dari API untuk menerjemahkan airline_id menjadi Nama Maskapai
        $responseAirlines = Http::get(env('API_BASE_URL') . '/airlines');
        $airlinesMaster = $responseAirlines->successful() ? $responseAirlines->json() : [];
        $airlineMap = collect($airlinesMaster)->pluck('name', 'id')->toArray();

        // 3. Transformasikan data penerbangan agar menyertakan string nama 'airline'
        $flights = collect($rawFlights)->map(function ($f) use ($airlineMap) {
            $f['airline'] = $airlineMap[$f['airline_id']] ?? 'Unknown Airline'; // Tambahkan key airline secara dinamis
            $f['from']        = $f['origin'];
            $f['to']          = $f['destination'];
            return $f;
        });

        $outboundFlight = $flights->firstWhere('id', $outboundId);
        $inboundFlight = $inboundId ? $flights->firstWhere('id', $inboundId) : null;

        if (!$outboundFlight) {
            return redirect()->route('flights')->with('error', 'Penerbangan tidak valid.');
        }

        // 4. Hitung harga dalam nominal asli Rupiah
        $pricePerPerson = (int) $outboundFlight['price'] + ($inboundFlight ? (int) $inboundFlight['price'] : 0);
        $subtotal = $pricePerPerson * $totalPassengers;
        $taxes = round($subtotal * 0.12);
        $grandTotal = $subtotal + $taxes;

        return view('checkout_flight', compact(
            'outboundFlight', 'inboundFlight', 'adults', 'children', 
            'totalPassengers', 'subtotal', 'taxes', 'grandTotal'
        ));
    }

    /**
     * Menyimpan data transaksi Booking, Penumpang, dan Tiket ke Database Lokal
     */
    /**
     * Menyimpan data transaksi Booking, Penumpang, dan Tiket ke Database Lokal & API
     */
    public function storeBooking(Request $request)
    {
        $request->validate([
            'outbound_id' => 'required',
            'contact_first_name' => 'required|string|max:255',
            'contact_last_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'passengers' => 'required|array',
            'passengers.*.name' => 'required|string',
            'passengers.*.phone' => 'required|string',
            'payment_method' => 'required', 
            'promo_id' => 'nullable'        
        ]);

        // Mulai database transaction lokal
        DB::beginTransaction();

        try {
            // 1. Simpan ke tabel flight_bookings lokal
            $booking = FlightBooking::create([
                'user_id' => Auth::id() ?? null,
                'booking_code' => 'STAYGO-' . strtoupper(Str::random(8)),
                'payment_status' => 'Paid',
                'status' => 'confirmed',
                'promo_id' => $request->promo_id // <-- PASTIKAN KOLOM INI ADA DI MIGRASI/MODEL FLIGHT BOOKINGS
            ]);

            if ($request->filled('promo_id')) {
                $promo = \App\Models\Promo::find($request->promo_id);
                if ($promo && $promo->quota > 0) {
                    $promo->decrement('quota');
                }
            }

            $totalAmount = 0;
            $ticketPayloads = []; 

            // input dinamis penumpang
            foreach ($request->passengers as $pData) {
                // Simpan ke tabel passengers lokal
                $passenger = Passenger::create([
                    'name' => $pData['name'],
                    'phone_number' => $pData['phone'],
                    'nik' => $pData['nik'] ?? null,
                    'passport_number' => $pData['passport'] ?? null
                ]);

                //  kursi acak
                $outboundSeat = 'ECO-' . rand(10, 99) . chr(rand(65, 70));

            
                Ticket::create([
                    'flight_id' => $request->outbound_id,
                    'flight_booking_id' => $booking->id,
                    'passenger_id' => $passenger->id,
                    'seat_number' => $outboundSeat,
                    'seat_type' => 'economy',
                    'price' => $request->outbound_price
                ]);
                $totalAmount += $request->outbound_price;

              
                $ticketPayloads[] = [
                    'flight_id' => $request->outbound_id,
                    'seat_number' => $outboundSeat,
                    'seat_type' => 'economy'
                ];

                if ($request->has('inbound_id') && $request->inbound_id) {
                    $inboundSeat = 'ECO-' . rand(10, 99) . chr(rand(65, 70));

                    Ticket::create([
                        'flight_id' => $request->inbound_id,
                        'flight_booking_id' => $booking->id,
                        'passenger_id' => $passenger->id,
                        'seat_number' => $inboundSeat,
                        'seat_type' => 'economy',
                        'price' => $request->inbound_price
                    ]);
                    $totalAmount += $request->inbound_price;

                    // Catat payload untuk API (Inbound)
                    $ticketPayloads[] = [
                        'flight_id' => $request->inbound_id,
                        'seat_number' => $inboundSeat,
                        'seat_type' => 'economy'
                    ];
                }
            }

            $grandTotalFinal = (int) $request->input('total_price');

           
            if (!$grandTotalFinal || $grandTotalFinal <= 0) {
                $finalTax = round($totalAmount * 0.12);
                $grandTotalFinal = $totalAmount + $finalTax;
            }

            Payment::create([
                'flight_booking_id' => $booking->id,
                'reservation_id' => null,
                'method' => $request->payment_method, // Menyimpan string metode baru secara seragam
                'amount' => $grandTotalFinal,
                'status' => 'Paid'
            ]);

         
            // Sesuaikan endpoint '/tickets' dengan endpoint di Controller API Anda yang memproses pengurangan seat
            $response = Http::post(env('API_BASE_URL') . '/tickets', [
                'application_booking_id' => $booking->id,
                'booking_code'           => $booking->booking_code,
                'tickets'                => $ticketPayloads // Mengirim array berisikan flight_id yang dibeli
            ]);

          
            if (!$response->successful()) {
                $apiError = $response->body();
                throw new \Exception('Gagal sinkronisasi data ke API Penerbangan. Detail: ' . $apiError);
            }

            // Jika semua proses aman, commit database transaksi lokal
            DB::commit();

            return response()->json([
                'success' => true,
                'redirect_url' => route('booking.receipt', ['code' => $booking->booking_code])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}