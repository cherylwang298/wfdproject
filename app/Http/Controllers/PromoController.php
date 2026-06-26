<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data promo dari database lokal main repo
        $promos = Promo::all();

        // 2. Jika database kosong (belum di-seed), sediakan data fallback agar halaman tidak kosong melompong
        if ($promos->isEmpty()) {
            $promos = collect([
                [
                    'code' => 'SUNSEEKER25',
                    'discount_type' => 'percentage',
                    'discount_value' => 25,
                    'title' => 'Summer Breeze Getaway',
                    'description' => 'Escape to coastal paradise on minimum 3‑night stays at premium beachfront resorts.',
                    'expired_at' => now()->addMonths(2)->format('M d, Y'),
                    'category' => 'Resorts',
                    'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=600'
                ],
                [
                    'code' => 'ELEVATE150',
                    'discount_type' => 'fixed',
                    'discount_value' => 150,
                    'title' => 'Long-Haul Luxury Flights',
                    'description' => 'Upgrade your journey with instant discount on international business/first class bookings.',
                    'expired_at' => now()->addMonths(3)->format('M d, Y'),
                    'category' => 'Flights',
                    'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=600'
                ],
                [
                    'code' => 'URBANFREE',
                    'discount_type' => 'percentage',
                    'discount_value' => 100,
                    'title' => 'Urban Explorer Break',
                    'description' => 'Book 3 nights at curated boutique city hotels and get the 4th night absolutely free.',
                    'expired_at' => now()->addMonths(4)->format('M d, Y'),
                    'category' => 'City Breaks',
                    'image' => 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?q=80&w=600'
                ]
            ]);
        }

        return view('deals', compact('promos'));
    }
}