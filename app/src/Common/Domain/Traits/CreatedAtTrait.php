<?php

declare(strict_types=1);

namespace App\Common\Domain\Traits;

use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = \DateTimeImmutable::createFromInterface($createdAt);
    }

    #[ORM\PrePersist]
    public function initializeCreatedAtTimestamp(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
