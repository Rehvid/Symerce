<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class RepeatPasswordValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof RepeatPassword) {
            throw new UnexpectedTypeException($constraint, RepeatPassword::class);
        }

        $object = $this->context->getObject();
        if (!$value || null === $object || !property_exists($object, 'password') || !$object->password) {
            return;
        }

        if ($object->password !== $value) {
            $this->context
                ->buildViolation($constraint->message)
                ->setTranslationDomain('messages')
                ->addViolation()
            ;
        }
    }
}
