<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    //

    public function openAccomodationPage()
{
    $response = Http::get(env('API_BASE_URL') . '/properties');

    // dd($response->json());

    if (!$response->successful()) {
        return view('dummy_pages.accomodations', [
            'cities' => []
        ]);
    }

    $properties = $response->json();

    $cities = collect($properties)
        ->pluck('city')
        ->unique()
        ->sort()
        ->values();

    return view('dummy_pages.search-accomodations', compact('cities'));
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

    // dd($properties->count());

//     $response = Http::get(env('API_BASE_URL').'/units');

// dd(
//     $response->successful(),
//     $response->status(),
//     $response->body()
// );

    $units = collect(Http::get(env('API_BASE_URL').'/units')->json());

    // dd($units->first());

    $reservations = collect(Http::get(env('API_BASE_URL').'/reservations')->json());

    // property di kota yang dipilih
    $properties = $properties->where('city', $request->city);

    $images = collect(
    Http::get(env('API_BASE_URL').'/images')->json()
);

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

            // kalau ada SATU unit available,
            // property langsung ditampilkan
            if(!$reserved){
                return true;
            }
        }

        return false;

    });

    $availableProperties = $availableProperties->map(function ($property) use ($images) {

    $image = $images
        ->where('property_id', $property['id'])
        ->first();

    $property['image'] = $image;

    return $property;
});



    return view(
        'dummy_pages.accomodations',
        [
            'properties' => $availableProperties,
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'guests' => $request->guests,
        ]
    );
}



public function openPropertyDetail($id)
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

    return view('dummy_pages.accomodation-details', [
        'property' => $property,
        'units' => $propertyUnits
    ]); 
}


}