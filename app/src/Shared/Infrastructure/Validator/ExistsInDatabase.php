<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ExistsInDatabase extends Constraint
{
    public string $field;
    public string $className;
    public string $message = 'base.validation.not_exist_field';
}
