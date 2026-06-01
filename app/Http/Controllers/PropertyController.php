<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class PropertyController extends Controller
{
    //

    public function index(){

        $response =  Http::get(env('API_BASE_URL') . '/properties');

         if (!$response->successful()) {
            return view('test-api.properties', [
                'properties' => []
            ]);
        }

        $properties = $response->json();

        return view('test-api.properties', [
            'properties' => $properties
        ]);


    }
}
