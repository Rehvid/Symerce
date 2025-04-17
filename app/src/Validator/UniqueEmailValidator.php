<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueEmailValidator extends ConstraintValidator
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueEmail) {
            throw new UnexpectedTypeException($constraint, UniqueEmail::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $object = $this->context->getObject();

        /** @var User|null $user */
        $user = $this->userRepository->findOneBy(['email' => $value]);

        if (null === $user) {
            return;
        }

        if (null !== $object && property_exists($object, 'id') && $object->id === $user->getId()) {
            return;
        }

        $this->context
            ->buildViolation($constraint->message)
            ->setTranslationDomain('messages')
            ->addViolation();
    }
}
