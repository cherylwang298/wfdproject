<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    //


   public function AdminLogin(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $admin = Admin::where('email', $credentials['email'])->first();

    if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    Auth::guard('admin')->login($admin);

  
    $request->session()->regenerate();

    return redirect()->route('admin.dashboard');
}
  


}
