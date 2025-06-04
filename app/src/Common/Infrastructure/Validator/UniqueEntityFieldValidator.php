<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueEntityFieldValidator extends ConstraintValidator
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueEntityField) {
            throw new UnexpectedTypeException($constraint, UniqueEntityField::class);
        }

        if ($this->shouldSkipValidation($value)) {
            return;
        }

        /** @phpstan-ignore-next-line */
        $repository = $this->getRepository($constraint->className);

        $object = $this->context->getObject();
        $entity = $repository->findOneBy([$constraint->field => $value]);

        if (
            $entity
            && null !== $object
            && \property_exists($object, 'id')
            && \method_exists($entity, 'getId')
            && $entity->getId() === $object->id
        ) {
            return;
        }

        if ($entity) {
            $this->context
                ->buildViolation($constraint->message)
                ->setTranslationDomain('messages')
                ->addViolation();
        }
    }

    private function shouldSkipValidation(mixed $value): bool
    {
        return null === $value || '' === $value;
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $className
     *
     * @return EntityRepository<T>
     */
    private function getRepository(string $className): EntityRepository
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("Class {$className} does not exist.");
        }

        /* @var EntityRepository<T> */
        return $this->entityManager->getRepository($className);
    }
}
