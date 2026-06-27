<?php

namespace App\Http\Controllers;

// use App\Models\Property;
use App\Models\Review;
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

    public function showPropertyDetailDirect(Request $request, $id)
    {
        // 1. Tarik semua data mentah dari API
        $properties = collect(Http::get(env('API_BASE_URL').'/properties')->json());
        $units = collect(Http::get(env('API_BASE_URL').'/units')->json());
        $images = collect(Http::get(env('API_BASE_URL').'/images')->json());

        // 2. Cari properti yang diklik
        $property = $properties->firstWhere('id', $id);
        if (!$property) {
            abort(404);
        }

        // Average rating
$avgRating = Review::where('property_id', $id)->avg('rating');

$reviewCount = Review::where('property_id', $id)->count();

$reviews = Review::with(['user', 'images'])
    ->where('property_id', $id)
    ->latest()
    ->get();

$property['avg_rating'] = $avgRating ? round($avgRating, 1) : 0;
$property['review_count'] = $reviewCount;

        // 3. Pasangkan gambar utama properti
        $property['image'] = $images->where('property_id', $id)->first();

        // 4. Ambil semua unit kamar milik properti ini & pasangkan gambarnya masing-masing
        $propertyUnits = $units->where('property_id', $id)->map(function ($unit) use ($images) {
            $unit['image'] = $images->where('unit_id', $unit['id'])->first();
            return $unit;
        });

        // 5. Cek status favorit di database lokal
        $isFavorite = \App\Models\Favorite::where('user_id', auth()->id())
            ->where('property_id', $property['id'])->exists(); // Sesuaikan nama kolom jika 'unit_id'

        // 6. Oper data 'units' ke view property_detail!
       return view('property_detail', [
    'hotel' => $property,
    'units' => $propertyUnits,
    'reviews' => $reviews,

    'checkin' => $request->query('checkin', date('Y-m-d')),
    'checkout' => $request->query('checkout', date('Y-m-d', strtotime('+1 day'))),
    'guests' => $request->query('guests', 1),

    'isFavorite' => $isFavorite
]);
    }
}