<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class AdminController extends Controller
{
    //

      public function openDashboard(){

      $totalBookings = Reservation::all()->count();

        return view('dummy_pages.admins.dashboard', compact('totalBookings'));
    }
    


}
