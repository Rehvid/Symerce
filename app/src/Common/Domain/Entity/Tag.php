<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Domain\Contracts\PositionEntityInterface;
use App\Common\Domain\Traits\ActiveTrait;
use App\Common\Domain\Traits\PositionTrait;
use App\Tag\Infrastructure\Repository\TagDoctrineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagDoctrineRepository::class)]
class Tag implements PositionEntityInterface
{
    use ActiveTrait, PositionTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $backgroundColor;

    #[ORM\Column(type: 'string', length: 32,nullable: true)]
    private ?string $textColor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(?string $backgroundColor): void
    {
        $this->backgroundColor = $backgroundColor;
    }

    public function getTextColor(): ?string
    {
        return $this->textColor;
    }

    public function setTextColor(?string $textColor): void
    {
        $this->textColor = $textColor;
    }


}
