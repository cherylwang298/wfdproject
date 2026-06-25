<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

      public function openDashboard(){
        return view('dummy_pages.admins.dashboard');
    }
    


}
