<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Common\Domain\Entity\PaymentMethod;
use App\Common\Domain\ValueObject\MoneyVO;

final class PaymentMethodFactory
{
    public static function card(): PaymentMethod
    {
        return self::custom(
            name: "Credit Card",
            code: "credit_card",
            moneyVO: new MoneyVO('10.00', CurrencyFactory::valid()),
            isActive: true
        );
    }

    public static function custom(string $name, string $code, MoneyVO $moneyVO, bool $isActive): PaymentMethod
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->setName($name);
        $paymentMethod->setCode($code);
        $paymentMethod->setFee($moneyVO->getFormattedAmount());
        $paymentMethod->setActive($isActive);

        return $paymentMethod;
    }
}
