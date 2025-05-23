<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class RepeatPassword extends Constraint
{
    public string $message = 'base.validation.repeat_password';
}
