<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CurrencyPrecision extends Constraint
{
    public string $message = 'base.validation.too_many_decimal_places';
}
