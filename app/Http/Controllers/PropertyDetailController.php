<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PropertyDetailController extends Controller
{
    public function show($id)
    {
        // 1. Ambil data semua properti untuk mencari kesamaan data
        $responseAll = Http::get(env('API_BASE_URL') . '/properties');
        $properties = $responseAll->successful() ? collect($responseAll->json()) : collect();

        // 2. Ambil spesifik hotel berdasarkan ID dari parameter URL
        $hotel = $properties->firstWhere('id', $id);

        // Jika ID properti tidak ditemukan sama sekali, kembalikan ke homepage
        if (!$hotel) {
            return redirect()->route('homepage');
        }

        // 3. Ambil data gambar (images) yang terikat dengan property_id atau unit_id dari API
        $images = [];
        try {
            $responseImages = Http::get(env('API_BASE_URL') . '/units'); // Mengambil data units/images pendukung
            // Di sini kita bisa memetakan gambar mockup/asli dari API
        } catch (\Exception $e) {
            // Silently catch
        }

        // 4. Ambil 4 rekomendasi properti serupa (tipe akomodasi sama, tapi ID berbeda)
        $similarProperties = $properties
            ->filter(fn($p) => $p['id'] !== $id && $p['type'] === $hotel['type'])
            ->take(4)
            ->values();

        // Jika properti sejenis kurang dari 4, ambil properti acak lain sebagai tambahan
        if ($similarProperties->count() < 4) {
            $similarProperties = $properties->filter(fn($p) => $p['id'] !== $id)->take(4)->values();
        }

        return view('property_detail', compact('hotel', 'similarProperties'));
    }
}