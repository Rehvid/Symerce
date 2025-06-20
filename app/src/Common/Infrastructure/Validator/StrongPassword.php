<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class StrongPassword extends Constraint
{
    public string $message = 'base.validation.strong_password';
}
