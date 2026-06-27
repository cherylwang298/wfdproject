<?php

namespace App\Http\Controllers;

use App\Models\CancelRequest;
use App\Models\FlightBooking;
use App\Models\Payment;
use App\Models\Promo;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    //

    public function openDashboard()
    {

        $admin = Auth::guard('admin')->user();
        $username = $admin->name;
        $totalBookings = Reservation::all()->count() + FlightBooking::all()->count();
        $totalUsers = User::all()->count();
        $totalRev = Payment::all()->sum('amount');

        $RecentTrans = Payment::all()->take(5)->reverse();

        $hotelBookings = Reservation::with('user')
            ->latest()
            ->get()
            ->map(function ($booking) {
                $booking->booking_type = 'hotel';
                return $booking;
            });

        $flightBookings = FlightBooking::with('user')
            ->latest()
            ->get()
            ->map(function ($booking) {
                $booking->booking_type = 'flight';
                return $booking;
            });

        $Bookings = $hotelBookings
            ->concat($flightBookings)
            ->sortByDesc('created_at')
            ->take(5);


        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i);

            $chartLabels[] = $date->format('D'); // Mon, Tue, Wed...

            $chartData[] = Payment::whereDate('created_at', $date)
                ->sum('amount');
        }

        return view('admins.dashboard', compact('totalBookings', 'username', 'totalUsers', 'totalRev', 'Bookings', 'RecentTrans', 'chartLabels', 'chartData'));
    }

    public function AdminLogout(Request $request)
    {
        // 1. Proses logout khusus untuk guard admin
        Auth::guard('admin')->logout();

        // 2. Hancurkan session admin saat ini agar aman
        $request->session()->invalidate();

        // 3. Buat ulang token session baru untuk mencegah session fixation
        $request->session()->regenerateToken();

        // 4. Lempar kembali ke halaman login admin
        return redirect()->route('admin.login')->with('success', 'Logout successful.');
    }

    public function openCancelRequests()
    {
        $cancels = CancelRequest::all();
        $admin = Auth::guard('admin')->user();
        $username = $admin->name;

        return view('admins.cancel-requests', compact('cancels', 'username'));
    }

    public function approveCancelRequest($id)
    {
        // Cari data cancel request berdasarkan ID, jika tidak ada lepar error 404
        $cancelRequest = CancelRequest::findOrFail($id);

        // Pastikan hanya request berstatus 'pending' yang bisa diproses
        if ($cancelRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        // Jalankan Database Transaction agar kedua perubahan sukses bersamaan
        DB::transaction(function () use ($cancelRequest) {
            // 1. Ubah status cancel request menjadi approved
            $cancelRequest->update(['status' => 'approved']);

            // 2. Jika pembatalan untuk Hotel/Reservation, ubah status reservasi menjadi 'cancelled'
            if ($cancelRequest->reservation_id) {
                // Catatan: Pastikan kolom 'status' ada di table reservations Anda (misal: 'pending', 'success', 'cancelled')
                DB::table('reservations')
                    ->where('id', $cancelRequest->reservation_id)
                    ->update(['status' => 'cancelled']);
            }

            // 3. Jika pembatalan untuk Tiket Pesawat, ubah status flight booking menjadi 'cancelled'
            if ($cancelRequest->flight_booking_id) {
                DB::table('flight_bookings')
                    ->where('id', $cancelRequest->flight_booking_id)
                    ->update(['status' => 'cancelled']);
            }
        });

        return redirect()->back()->with('success', 'Cancel request approved.');
    }

    public function rejectCancelRequest($id)
    {
        $cancelRequest = CancelRequest::findOrFail($id);

        if ($cancelRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        // Jika ditolak, kita hanya perlu mengubah status cancel_requests menjadi 'rejected'
        // Data reservation / flight_bookings tidak berubah (tetap aktif/aman)
        $cancelRequest->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Cancel request rejected.');
    }

    public function openPromos()
    {
        $admin = Auth::guard('admin')->user();
        $username = $admin->name;
        $promos = Promo::all();

        return view('admins.promos', compact('promos', 'username'));
    }

    public function openUsers()
    {
        $admin = Auth::guard('admin')->user();
        $username = $admin->name;
        $users = User::all();

        return view('admins.manage-users', compact('users', 'username'));
    }

    public function openReserv()
    {
        $admin = Auth::guard('admin')->user();

        $username = $admin->name;

        $reservations = Reservation::with('user')
            ->latest()
            ->get();

        $bookings = FlightBooking::with('user')
            ->latest()
            ->get();

        return view('admins.reservations', compact(
            'reservations',
            'username',
            'bookings'
        ));
    }

    public function viewBooking($id)
    {
        $booking = FlightBooking::with('user')->findOrFail($id);
        return response()->json($booking);
    }

    public function editBooking(Request $request, $id)
    {
        $booking = FlightBooking::findOrFail($id);

        $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Reservation status updated.');
    }

    public function deleteBooking($id)
    {
        $booking = FlightBooking::findOrFail($id);
        $booking->delete();

        return redirect()->back()->with('success', 'Reservation deleted.');
    }

    public function viewReserv($id)
    {
        $reservation = Reservation::with('user')->findOrFail($id);
        return response()->json($reservation);
    }

    public function editReserv(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
        ]);

        $reservation->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Reservation status updated.');
    }

    public function deleteReserv($id)
    {
        $reservation = Reservation::findOrFail($id);
        $status = $reservation->status;

        if ($status == 'pending' || $status == 'confirmed') {
            return redirect()->back()->with('error', 'Reservation cannot be deleted.');
        } else {
            $reservation->delete();
        }

        return redirect()->back()->with('success', 'Reservation deleted.');
    }

    public function createPromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'discount_type' => 'required|string',
            'discount_value' => 'required|numeric',
            'min_purchase' => 'required|numeric',
            'quota' => 'required|numeric',
            'expired_at' => 'required|date|after_or_equal:now',
        ]);

        $promo = Promo::create([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_purchase' => $request->min_purchase,
            'quota' => $request->quota,
            'expired_at' => $request->expired_at,
        ]);

        return redirect()->back()->with('success', 'Promo created.');
    }

    public function editPromo(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);
        $request->validate([
            'code' => 'required|string|unique:promos,code,' . $promo->id,
            'discount_type' => 'required|string|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'quota' => 'required|numeric|min:0',
            'expired_at' => 'required|date|after_or_equal:now',
        ]);

        $promo->update([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_purchase' => $request->min_purchase,
            'quota' => $request->quota,
            'expired_at' => $request->expired_at,
        ]);
        return redirect()->back()->with('success', 'Promo updated.');
    }

    public function deletePromo($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();
        return redirect()->back()->with('success', 'Promo deleted.');
    }

    public function viewUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users', compact('user'));
    }

    // public function editUserStatus($id, Request $request){

    // $user = User::findOrFail($id);
    // $request -> validate([
    //   'status' => 'required|string|in:active,suspended',
    // ]);

    // $user->update([
    //     'status' => $request->status,
    // ]);

    // return redirect()->back()->with('success', 'Status user berhasil diperbarui.');
    // }

    public function editUserStatus($id, Request $request)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'status' => 'required|string|in:active,suspended',
            ]);

            $user->update([
                'status' => $validated['status'],
            ]);

            return redirect()->back()->with('success', 'User status updated.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user status.');
        }
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted.');
    }
}
