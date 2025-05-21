<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CurrencyPrecision extends Constraint
{
    public string $message = 'base.validation.too_many_decimal_places';
}
