<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Application\Contracts\IdentifiableInterface;
use App\Common\Domain\Traits\ActiveTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Country implements IdentifiableInterface
{
    use ActiveTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private string $name;


    /** ISO 3166-1 alpha-2  */
    #[ORM\Column(length: 2, unique: true)]
    private string $code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}
