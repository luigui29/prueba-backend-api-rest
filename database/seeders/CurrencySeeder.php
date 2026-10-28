<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'name' => 'Dólar estadounidense',
                'symbol' => '$',
                'exchange_rate' => 1.00,
            ],
            [
                'name' => 'Bolívares',
                'symbol' => 'Bs.',
                'exchange_rate' => 36.50,
            ],
            [
                'name' => 'Euro',
                'symbol' => '€',
                'exchange_rate' => 0.92,
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::updateOrCreate(
                ['name' => $currency['name'],
                'symbol' => $currency['symbol'],
                'exchange_rate' => $currency['exchange_rate']],
            );
        }
    }
}