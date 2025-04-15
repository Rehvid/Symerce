<?php

declare(strict_types=1);

namespace App\Entity;
use App\Enums\SettingType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class GlobalSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string',  length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', enumType: SettingType::class)]
    private SettingType $type;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getType(): SettingType
    {
        return $this->type;
    }

    public function setType(SettingType $type): void
    {
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
