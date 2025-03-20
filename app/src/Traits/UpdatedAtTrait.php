<?php

declare(strict_types=1);

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait UpdatedAtTrait
{
    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTime $updateAt;

    public function getUpdatedAt(): \DateTime
    {
        return $this->updateAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updateAt = $updatedAt;
    }
}
