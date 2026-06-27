<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class FlightSearchController extends Controller
{
    public function index()
    {
        // 1. Ambil data Flights dari API
        $responseFlights = Http::get(env('API_BASE_URL') . '/flights');
        $rawFlights = $responseFlights->successful() ? $responseFlights->json() : [];

        // 2. Ambil master data Airlines dari API
        $responseAirlines = Http::get(env('API_BASE_URL') . '/airlines');
        $airlinesMaster = $responseAirlines->successful() ? $responseAirlines->json() : [];

        // Membuat map [id => name] untuk mempermudah pencarian nama maskapai berdasarkan airline_id
        $airlineMap = collect($airlinesMaster)->pluck('name', 'id')->toArray();

        // 3. Ekstrak daftar kota (Cities) unik secara dinamis dari rute penerbangan yang ada di API
        $cities = collect($rawFlights)->flatMap(function ($f) {
            return [$f['origin'], $f['destination']];
        })->unique()->sort()->values()->toArray();

        // 4. Transformasikan data flights untuk digunakan oleh JavaScript di Blade View
        $flights = collect($rawFlights)->map(function ($f) use ($airlineMap) {
            $depTime = Carbon::parse($f['departure_time']);
            $arrTime = Carbon::parse($f['arrival_time']);
            
            $durationMinutes = $depTime->diffInMinutes($arrTime);
            $hours = floor($durationMinutes / 60);
            $minutes = $durationMinutes % 60;

            // Cari nama asli maskapai dari airlineMap, jika tidak ketemu gunakan fallback
            $airlineName = $airlineMap[$f['airline_id']] ?? 'Unknown Airline';

            return [
                'id'             => $f['id'],
                'from'           => $f['origin'],
                'to'             => $f['destination'],
                'from_city'      => $f['origin'], 
                'to_city'        => $f['destination'],
                'dep'            => $depTime->format('H:i'),
                'arr'            => $arrTime->format('H:i'),
                'departure_time' => $f['departure_time'],
                'duration'       => "{$hours}h {$minutes}m",
                'airline'        => $airlineName,
                'code'           => 'FL-' . rand(100, 999),
                'class'          => $f['class'],
                
                'price'          => (int) $f['price'], 
                
                'stops'          => 0,
                'badge'          => rand(0, 5) === 0 ? 'Cheapest' : null,
            ];
        });

        // 5. Ambil daftar nama maskapai unik yang benar-benar beroperasi di flights untuk filter sidebar
        $operatingAirlines = $flights->pluck('airline')->unique()->values()->toArray();

        return view('search_flights', compact('flights', 'cities', 'operatingAirlines'));
    }
}