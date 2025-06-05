<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Domain\Traits\ActiveTrait;
use App\Common\Domain\Traits\CreatedAtTrait;
use App\Common\Domain\Traits\ProtectedTrait;
use App\Setting\Domain\Enums\SettingKey;
use App\Setting\Domain\Enums\SettingType;
use App\Setting\Domain\Enums\SettingValueType;
use App\Setting\Infrastructure\Repository\SettingDoctrineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Setting
{
    use CreatedAtTrait;
    use ActiveTrait;
    use ProtectedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $value;

    #[ORM\Column(type: 'string', enumType: SettingKey::class)]
    private SettingKey $key;

    #[ORM\Column(type: 'string', enumType: SettingType::class)]
    private SettingType $type;

    #[ORM\Column(type: 'string', enumType: SettingValueType::class)]
    private SettingValueType $valueType;

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

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getKey(): SettingKey
    {
        return $this->key;
    }

    public function setKey(SettingKey $key): void
    {
        $this->key = $key;
    }

    public function getValueType(): SettingValueType
    {
        return $this->valueType;
    }

    public function setValueType(SettingValueType $valueType): void
    {
        $this->valueType = $valueType;
    }
}
