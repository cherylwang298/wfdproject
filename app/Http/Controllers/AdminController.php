<?php

namespace App\Http\Controllers;

use App\Models\CancelRequest;
use App\Models\Reservation;
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

        return view('admins.dashboard', compact('totalBookings', 'username'));
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

}
