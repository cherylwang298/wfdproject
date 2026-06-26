<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CancelRequest;

class AdminController extends Controller
{
    //

      public function openDashboard(){

      $admin = Auth::guard('admin')->user();
      $username = $admin->name;
      $totalBookings = Reservation::all()->count();

        return view('dummy_pages.admins.dashboard', compact('totalBookings', 'username'));
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

  return view('dummy_pages.admins.cancel-requests', compact('cancels', 'username'));
}


}
