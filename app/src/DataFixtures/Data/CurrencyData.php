<?php

declare(strict_types=1);

namespace App\DataFixtures\Data;

class CurrencyData
{
    /**
     * @return array<array,mixed>
     */
    public static function getData(): array
    {
        return [
            ['code' => 'EUR', 'symbol' => '€',  'name' => 'Euro',                      'roundingPrecision' => 2],
            ['code' => 'USD', 'symbol' => '$',  'name' => 'Dolar amerykański',         'roundingPrecision' => 2],
            ['code' => 'GBP', 'symbol' => '£',  'name' => 'Funt szterling',            'roundingPrecision' => 2],
            ['code' => 'PLN', 'symbol' => 'zł', 'name' => 'Polski złoty',              'roundingPrecision' => 2],
            ['code' => 'CHF', 'symbol' => 'CHF','name' => 'Frank szwajcarski',         'roundingPrecision' => 2],
            ['code' => 'JPY', 'symbol' => '¥',  'name' => 'Jen japoński',              'roundingPrecision' => 0],
            ['code' => 'CNY', 'symbol' => '¥',  'name' => 'Juan chiński',              'roundingPrecision' => 2],
            ['code' => 'AUD', 'symbol' => 'A$', 'name' => 'Dolar australijski',        'roundingPrecision' => 2],
            ['code' => 'CAD', 'symbol' => 'C$', 'name' => 'Dolar kanadyjski',          'roundingPrecision' => 2],
            ['code' => 'SEK', 'symbol' => 'kr', 'name' => 'Korona szwedzka',           'roundingPrecision' => 2],
            ['code' => 'NOK', 'symbol' => 'kr', 'name' => 'Korona norweska',           'roundingPrecision' => 2],
            ['code' => 'DKK', 'symbol' => 'kr', 'name' => 'Korona duńska',             'roundingPrecision' => 2],
            [ 'code' => 'CZK', 'symbol' => 'Kč', 'name' => 'Korona czeska',             'roundingPrecision' => 2],
            ['code' => 'HUF', 'symbol' => 'Ft', 'name' => 'Forint węgierski',          'roundingPrecision' => 0],
        ];
    }
}
