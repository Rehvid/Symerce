<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enums\SettingType;
use App\Repository\SettingRepository;
use App\Traits\ActiveTrait;
use App\Traits\CreatedAtTrait;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(RepositoryClass: SettingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Setting
{
    use CreatedAtTrait;
    use ActiveTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $value;

    #[ORM\Column(type: 'string', enumType: SettingType::class)]
    private SettingType $type;

    #[ORM\Column(type: 'boolean')]
    private bool $isProtected = false;

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

    public function isProtected(): bool
    {
        return $this->isProtected;
    }

    public function setIsProtected(bool $isProtected): void
    {
        $this->isProtected = $isProtected;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    #[ORM\PreRemove]
    public function preventRemovalIfProtected(): void
    {
        if ($this->isProtected) {
            throw new \RuntimeException(sprintf('Cannot delete protected setting: "%s"', $this->name));
        }
    }

    #[ORM\PreUpdate]
    public function preventUpdateIfProtected(PreUpdateEventArgs $event): void
    {
        if ($this->isProtected && ($event->hasChangedField('name') || $event->hasChangedField('type'))) {
            throw new \RuntimeException(sprintf('Cannot update protected setting: "%s"', $this->name));
        }
    }
}
