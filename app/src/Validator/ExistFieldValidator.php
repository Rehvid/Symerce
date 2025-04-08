<?php

declare(strict_types=1);

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ExistFieldValidator extends ConstraintValidator
{
    public function __construct(
        private readonly EntityManagerInterface $entityManagerInterface,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ExistField) {
            throw new UnexpectedTypeException($constraint, UniqueEmail::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!class_exists($constraint->className)) {
            throw new \InvalidArgumentException("Class {$constraint->className} does not exist.");
        }

        $repository = $this->entityManagerInterface->getRepository($constraint->className);
        $entity = $repository->findOneBy([$constraint->field => $value]);

        if (null === $entity) {
            $this->context
                ->buildViolation($constraint->message)
                ->setTranslationDomain('messages')
                ->addViolation();
        }
    }
}
