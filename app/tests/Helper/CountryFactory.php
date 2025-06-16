<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Common\Domain\Entity\Country;

final class CountryFactory
{
    public static function poland(): Country
    {
        return self::custom('PL', 'Poland', true);
    }

    public static function usa(): Country
    {
        return self::custom('US', 'United States', true);
    }

    public static function germany(): Country
    {
        return self::custom('DE', 'Germany', true);
    }

    public static function custom(string $code, string $name, bool $isActive): Country
    {
        $country = new Country();
        $country->setName($name);
        $country->setCode($code);
        $country->setActive($isActive);

        return $country;
    }

}
