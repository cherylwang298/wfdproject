<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promo;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'code' => 'STAYGO50',
                'discount_type' => 'percentage',
                'discount_value' => 50,
                'min_purchase' => 500000,
                'quota' => 100,
                'expired_at' => Carbon::now()->addDays(7),
            ],
            [
                'code' => 'HOTEL25',
                'discount_type' => 'percentage',
                'discount_value' => 25,
                'min_purchase' => 300000,
                'quota' => 50,
                'expired_at' => Carbon::now()->addDays(10),
            ],
            [
                'code' => 'VILLA100K',
                'discount_type' => 'fixed',
                'discount_value' => 100000,
                'min_purchase' => 750000,
                'quota' => 30,
                'expired_at' => Carbon::now()->addDays(5),
            ],
            [
                'code' => 'NEWUSER30',
                'discount_type' => 'percentage',
                'discount_value' => 30,
                'min_purchase' => 200000,
                'quota' => 200,
                'expired_at' => Carbon::now()->addDays(14),
            ],
            [
                'code' => 'FLASH10',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'min_purchase' => 0,
                'quota' => 999,
                'expired_at' => Carbon::now()->addDays(2),
            ],
        ];

        foreach ($data as $d) {
            Promo::create($d);
        }
    }
}