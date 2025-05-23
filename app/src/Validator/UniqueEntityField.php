<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueEntityField extends Constraint
{
    public string $field;
    public string $className;
    public string $message = 'base.validation.already_exists';
}
