<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AirlineController extends Controller
{
    //

    public function index(){

        $response =  Http::get(env('API_BASE_URL') . '/airlines');

         if (!$response->successful()) {
            return view('test-api.airlines', [
                'airlines' => []
            ]);
        }

        $airlines = $response->json();
        // dd($airlines);

        return view('test-api.airlines', [
            'airlines' => $airlines
        ]);


    }
}
