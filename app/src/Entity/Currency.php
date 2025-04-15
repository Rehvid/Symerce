<?php

declare(strict_types=1);

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(length: 3)]
    private string $code;

    #[ORM\Column(length: 10)]
    private string $symbol;

    #[ORM\Column(length: 50)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $roundingPrecision;


    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = strtoupper($code);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    public function getRoundingPrecision(): int
    {
        return $this->roundingPrecision;
    }

    public function setRoundingPrecision(int $roundingPrecision): void
    {
        $this->roundingPrecision = $roundingPrecision;
    }
}
