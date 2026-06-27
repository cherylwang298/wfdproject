<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::where('expired_at', '>=', now())
            ->where('quota', '>', 0)
            ->get();
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
