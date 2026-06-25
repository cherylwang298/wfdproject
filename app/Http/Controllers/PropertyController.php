<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class PropertyController extends Controller
{
    //

    // public function index(){

    //     $response =  Http::get(env('API_BASE_URL') . '/properties');

    //      if (!$response->successful()) {
    //         return view('test-api.properties', [
    //             'properties' => []
    //         ]);
    //     }

    //     $properties = $response->json();

    //     return view('test-api.properties', [
    //         'properties' => $properties
    //     ]);


    // }

    public function index()
{
    $response = Http::get(env('API_BASE_URL') . '/properties');

    if (!$response->successful()) {
        return view('dummy_pages.home', [
            'properties' => collect(),
            'featured' => collect(),
            'hotels' => collect(),
            'villas' => collect(),
        ]);
    }

    $properties = collect($response->json());

    $featured = $properties
        ->shuffle()
        ->take(6)
        ->values();

    // hotel & villa tetap normal
    $hotels = $properties
        ->where('type', 'hotel')
        ->values();

    $villas = $properties
        ->where('type', 'villa')
        ->values();

    return view('dummy_pages.home', compact(
        'properties',
        'featured',
        'hotels',
        'villas'
    ));
}


}