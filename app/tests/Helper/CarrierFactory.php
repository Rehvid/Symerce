<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Common\Application\Factory\MoneyFactory;
use App\Common\Domain\Entity\Carrier;
use App\Common\Domain\ValueObject\MoneyVO;

final class CarrierFactory
{


    public static function valid(): Carrier
    {
        return self::custom(
            name: "DHL",
            isActive: true ,
            moneyVO: new MoneyVO('10.00', CurrencyFactory::valid())
        );
    }

    public static function custom(string $name, bool $isActive, MoneyVO $moneyVO): Carrier
    {
        $carrier = new Carrier();
        $carrier->setName($name);
        $carrier->setActive($isActive);
        $carrier->setFee($moneyVO->getFormattedAmount());

        return $carrier;
    }
}
