<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Application\Contracts\IdentifiableInterface;
use App\Common\Domain\Enums\DecimalPrecision;
use App\Common\Domain\Traits\ProtectedTrait;
use App\Currency\Infrastructure\Repository\CurrencyDoctrineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Currency implements IdentifiableInterface
{
    use ProtectedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\Column(length: 3, unique: true)]
    private string $code;

    #[ORM\Column(length: 10)]
    private string $symbol;

    #[ORM\Column(length: 255, unique: true)]
    private string $name;

    #[ORM\Column(type: 'smallint')]
    private int $roundingPrecision;

    public function getId(): ?int
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
        if ($roundingPrecision > DecimalPrecision::MAXIMUM_PRECISION->value) {
            $roundingPrecision = DecimalPrecision::MAXIMUM_PRECISION->value;
        }

        $this->roundingPrecision = $roundingPrecision;
    }
}
