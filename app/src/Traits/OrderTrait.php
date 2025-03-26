<?php

declare(strict_types=1);

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait OrderTrait
{
    #[ORM\Column(name: '`order`', type: 'integer', nullable: false, options: ['default' => '0'])]
    private int $order = 0;

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): void
    {
        $this->order = $order;
    }
}
