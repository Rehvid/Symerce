<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request;

use App\Common\Application\Contracts\IdentifiableInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class IdRequest implements IdentifiableInterface
{
    #[Assert\When(
        expression: 'this.getId() !== null',
        constraints: [
            new Assert\GreaterThan(0),
        ]
    )]
    private ?int $id;

    public function __construct(?int $id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
