<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Service;

use App\Common\Application\Contracts\SluggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Guid\Guid;
use Symfony\Component\String\Slugger\AsciiSlugger;

final readonly class SluggerService implements SluggerInterface
{
    private const string LIMITER = '-';
    private const int MAX_ATTEMPTS = 3;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private AsciiSlugger $slugger = new AsciiSlugger()
    ) {
    }

    private function slugify(string $value): string
    {
        return $this->slugger->slug($value)->lower()->toString();
    }

    public function slugifyUnique(string $value, string $entityClass, string $fieldName): string
    {
        $slug = $this->slugify($value);

        if (!$this->findExistingSlugs($slug, $entityClass, $fieldName)) {
            return $slug;
        }

        return $this->tryToGenerateUniqueSlug($slug, $entityClass, $fieldName);
    }

    private function findExistingSlugs(string $value, string $entityClass, string $fieldName): bool
    {
        if (!class_exists($entityClass)) {
            throw new \InvalidArgumentException("Class {$entityClass} does not exist.");
        }

        $count = $this->entityManager
            ->getRepository($entityClass)
            ->createQueryBuilder('c')
            ->select('COUNT(c.'.$fieldName.')')
            ->where('c.'.$fieldName.' = :value')
            ->setParameter('value', $value)
            ->getQuery()
            ->getSingleScalarResult();

        return $count > 0;
    }

    private function tryToGenerateUniqueSlug(string $slug, string $entityClass, string $fieldName): string
    {
        $guid = Guid::uuid4()->toString();
        $newSlug = $slug.self::LIMITER.$guid;

        if (!$this->findExistingSlugs($newSlug, $entityClass, $fieldName)) {
            return $newSlug;
        }

        $attempts = 1;
        while ($this->findExistingSlugs($newSlug, $entityClass, $fieldName) && $attempts <= self::MAX_ATTEMPTS) {
            ++$attempts;
            $newSlug = $slug.self::LIMITER.$attempts.self::LIMITER.Guid::uuid4()->toString();
        }

        if (self::MAX_ATTEMPTS === $attempts) {
            throw new \LogicException('Too many attempts to generate a unique slug');
        }

        return $newSlug;
    }
}
