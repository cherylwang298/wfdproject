<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Review;

class SearchController extends Controller
{
    //

    public function openAccomodationPage()
{
    $response = Http::get(env('API_BASE_URL') . '/properties');

    // dd($response->json());

    if (!$response->successful()) {
        return view('accomodations.search-accomodations', [
            'cities' => []
        ]);
    }

    $properties = $response->json();

    $cities = collect($properties)
        ->pluck('city')
        ->unique()
        ->sort()
        ->values();

    return view('accomodations.search-accomodations', compact('cities'));
}

public function searchAccomodations(Request $request)
{

    // dd($request->all());

    $request->validate([
        'city' => 'required|string',    
        'checkin' => 'required|date',
        'checkout' => 'required|date|after:checkin',
        'guests' => 'required|integer|min:1'
    ]);

    $properties = collect(Http::get(env('API_BASE_URL').'/properties')->json());
  

    $units = collect(Http::get(env('API_BASE_URL').'/units')->json());



    $reservations = collect(Http::get(env('API_BASE_URL').'/reservations')->json());


    $properties = $properties->where('city', $request->city);
 

    $images = collect(
    Http::get(env('API_BASE_URL').'/images')->json()
);

    $typeFilter = $request->query('type_filter', 'all');
    if ($typeFilter !== 'all') {
        $properties = $properties->where('type', $typeFilter);
    }

    $availableProperties = $properties->filter(function($property)
        use ($units, $reservations, $request)
    {

        $propertyUnits = $units
            ->where('property_id', $property['id'])
            ->where('capacity', '>=', $request->guests);
    
        foreach($propertyUnits as $unit){

            $reserved = false;

            foreach($reservations as $reservation){

                if($reservation['unit_id'] != $unit['id']){
                    continue;
                }

                $overlap =
                    $request->checkin < $reservation['check_out']
                    &&
                    $request->checkout > $reservation['check_in'];

                if($overlap){
                    $reserved = true;
                    break;
                }
            }


            if(!$reserved){
                return true;
            }
        }

        return false;

    });



$ratings = Review::selectRaw("
        property_id,
        AVG(rating) as avg_rating,
        COUNT(*) as review_count
    ")
    ->groupBy('property_id')
    ->get()
    ->keyBy('property_id');

$availableProperties = $availableProperties->map(function ($property) use ($images, $units, $ratings) {

    $image = $images
        ->where('property_id', $property['id'])
        ->first();

    $property['image'] = $image;

    $property['min_price'] = $units
        ->where('property_id', $property['id'])
        ->min('price');

    $rating = $ratings->get($property['id']);

    $property['avg_rating'] = $rating
        ? round($rating->avg_rating, 1)
        : 0;

    $property['review_count'] = $rating
        ? $rating->review_count
        : 0;

    return $property;
});



    $sort = $request->query('sort', 'default');
    if ($sort === 'price_asc') {
        $availableProperties = $availableProperties->sortBy('min_price');
    } elseif ($sort === 'price_desc') {
        $availableProperties = $availableProperties->sortByDesc('min_price');
   }elseif ($sort === 'rating_desc') {
    $availableProperties = $availableProperties->sortByDesc('avg_rating');
}

   
    $cities = collect(Http::get(env('API_BASE_URL').'/properties')->json())->pluck('city')->unique()->sort()->values();

    return view('accomodations.accomodations', [
        'properties' => $availableProperties->values(),
        'cities' => $cities,
        'checkin' => $request->checkin,
        'checkout' => $request->checkout,
        'guests' => $request->guests,
    ]);
}


public function openPropertyDetail(Request $request, $id)
{
    $properties = collect(
        Http::get(env('API_BASE_URL').'/properties')->json()
    );

    $units = collect(
        Http::get(env('API_BASE_URL').'/units')->json()
    );

    $images = collect(
        Http::get(env('API_BASE_URL').'/images')->json()
    );

    // Cari property
    $property = $properties->firstWhere('id', $id);

    if (!$property) {
        abort(404);
    }

    // Gambar property
    $property['image'] = $images
        ->where('property_id', $id)
        ->first();

    // Semua unit milik property
    $propertyUnits = $units
        ->where('property_id', $id)
        ->map(function ($unit) use ($images) {

            $unit['image'] = $images
                ->where('unit_id', $unit['id'])
                ->first();

            return $unit;
        });

        $isFavorite = Favorite::where('user_id', Auth::id())
        ->where('property_id', $property['id'])->exists();
    
        $reviews = Review::with('user')
        ->where('property_id', $id)
        ->latest()
        ->get();

    $property['avg_rating'] = round($reviews->avg('rating') ?? 0, 1);
    $property['review_count'] = $reviews->count();

    return view('accomodations.accomodation-details', [
        'property' => $property,
        'units' => $propertyUnits,
        'checkin' => $request->query('checkin'),
        'checkout' => $request->query('checkout'),
        'guests' => $request->query('guests'),
        'isFavorite' => $isFavorite,
        'reviews' => $reviews
    ]); 
}


}