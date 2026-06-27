<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        // 1. Ambil data promo yang tanggal expired-nya belum lewat DAN kuotanya masih ada
        $promos = Promo::where('expired_at', '>=', now())
            ->where('quota', '>', 0)
            ->get();

        // 2. Jika database kosong (belum di-seed) atau tidak ada promo yang aktif, sediakan data fallback
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
    public function apply(Request $request)
    {
        $promo = Promo::where('code', $request->promo_code)->first();

        if (!$promo) {
            return response()->json([
                'success' => false,
                'message' => 'Promo code not found.'
            ]);
        }

        $quotaNow = $promo->quota;

        if ($promo->expired_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Promo has expired.'
            ]);
        }

        $total = $request->total;

        if ($promo->discount_type == "percentage") {
            $discount = $total * ($promo->discount_value / 100);
        } else {
            $discount = $promo->discount_value;
        }

        $discount = min($discount, $total);
        $newQuota = $quotaNow - 1;

        $promo->update([
            'quota' => $newQuota
        ]);

        return response()->json([
            'success' => true,
            'promo_id' => $promo->id,
            'discount' => $discount,
            'new_total' => $total - $discount,
            'message' => 'Promo applied!'
        ]);
    }
}
