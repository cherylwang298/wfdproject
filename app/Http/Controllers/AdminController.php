<?php

namespace App\Http\Controllers;

use App\Models\CancelRequest;
use App\Models\Payment;
use App\Models\Promo;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //

      public function openDashboard(){

      $admin = Auth::guard('admin')->user();
      $username = $admin->name;
      $totalBookings = Reservation::all()->count();
      $totalUsers = User::all()->count();
      $totalRev = Payment::all()->sum('amount');

      return view('admins.dashboard', compact('totalBookings', 'username', 'totalUsers', 'totalRev'));
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
    return redirect()->route('admin.login')->with('success', 'Anda berhasil logout.');
}

public function openCancelRequests(){
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
            return redirect()->back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
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

        return redirect()->back()->with('success', 'Permintaan pembatalan berhasil disetujui.');
    }

    public function rejectCancelRequest($id)
    {
        $cancelRequest = CancelRequest::findOrFail($id);

        if ($cancelRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        // Jika ditolak, kita hanya perlu mengubah status cancel_requests menjadi 'rejected'
        // Data reservation / flight_bookings tidak berubah (tetap aktif/aman)
        $cancelRequest->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Permintaan pembatalan telah ditolak.');
    }

    public function openPromos(){
      $admin = Auth::guard('admin')->user();
      $username = $admin->name;
      $promos = Promo::all();
      
      return view('admins.promos', compact('promos', 'username'));
    }

    public function openUsers(){
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

    return view('admins.reservations', compact(
        'reservations',
        'username'
    ));
}

public function viewReserv($id){
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

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui.');
    }

    public function deleteReserv($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->back()->with('success', 'Data reservasi berhasil dihapus.');
    }

    public function createPromo(Request $request){
    $request->validate([
        'code' => 'required|string',
        'discount_type' => 'required|string',
        'discount_value' => 'required|numeric',
        'min_purchase' => 'required|numeric',
        'quota' => 'required|numeric',
        'expired_at' => 'required|date',
    ]);

    $promo = Promo::create([
        'code' => $request->code,
        'discount_type' => $request->discount_type,
        'discount_value' => $request->discount_value,
        'min_purchase' => $request->min_purchase,
        'quota' => $request->quota,
        'expired_at' => $request->expired_at,
    ]);

    return redirect()->back()->with('success', 'Promo berhasil ditambahkan.');

    }

    public function editPromo(Request $request, $id)
    {
  
        $promo = Promo::findOrFail($id);
        $request->validate([
            'code' => 'required|string|unique:promos,code,' . $promo->id, // Abaikan pengecekan unik untuk ID ini sendiri
            'discount_type' => 'required|string|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'quota' => 'required|numeric|min:0',
            'expired_at' => 'required|date',
        ]);

        $promo->update([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_purchase' => $request->min_purchase,
            'quota' => $request->quota,
            'expired_at' => $request->expired_at,
        ]);
        return redirect()->back()->with('success', 'Promo berhasil diperbarui.');
    }

    public function deletePromo($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();
        return redirect()->back()->with('success', 'Promo berhasil dihapus.');
    }

    public function viewUser($id){
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

        return redirect()->back()->with('success', 'Status user berhasil diperbarui.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal memperbarui status user.');
    }
}

public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();
    return redirect()->back()->with('success', 'User berhasil dihapus.');


}


}