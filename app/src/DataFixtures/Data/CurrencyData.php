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
            ['code' => 'EUR', 'symbol' => '€',  'name' => 'Euro',                      'roundingPrecision' => 2, 'isProtected' => false],
            ['code' => 'USD', 'symbol' => '$',  'name' => 'Dolar amerykański',         'roundingPrecision' => 2, 'isProtected' => false],
            ['code' => 'GBP', 'symbol' => '£',  'name' => 'Funt szterling',            'roundingPrecision' => 2,    'isProtected' => false],
            ['code' => 'PLN', 'symbol' => 'zł', 'name' => 'Polski złoty',              'roundingPrecision' => 2,    'isProtected' => true],
            ['code' => 'CHF', 'symbol' => 'CHF', 'name' => 'Frank szwajcarski',        'roundingPrecision' => 2,    'isProtected' => false],
            ['code' => 'JPY', 'symbol' => '¥',  'name' => 'Jen japoński',              'roundingPrecision' => 0,    'isProtected' => false],
            ['code' => 'CNY', 'symbol' => '¥',  'name' => 'Juan chiński',              'roundingPrecision' => 2, 'isProtected' => false],
            ['code' => 'AUD', 'symbol' => 'A$', 'name' => 'Dolar australijski',        'roundingPrecision' => 2, 'isProtected' => false],
            ['code' => 'CAD', 'symbol' => 'C$', 'name' => 'Dolar kanadyjski',          'roundingPrecision' => 2, 'isProtected' => false],
            ['code' => 'SEK', 'symbol' => 'kr', 'name' => 'Korona szwedzka',           'roundingPrecision' => 2,    'isProtected' => false],
            ['code' => 'NOK', 'symbol' => 'kr', 'name' => 'Korona norweska',           'roundingPrecision' => 2, 'isProtected' => false],
            ['code' => 'DKK', 'symbol' => 'kr', 'name' => 'Korona duńska',             'roundingPrecision' => 2, 'isProtected' => false],
            ['code' => 'CZK', 'symbol' => 'Kč', 'name' => 'Korona czeska',             'roundingPrecision' => 2, 'isProtected' => false],
            ['code' => 'HUF', 'symbol' => 'Ft', 'name' => 'Forint węgierski',          'roundingPrecision' => 0,    'isProtected' => false],
        ];
    }
}
