<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Domain\Enums\FileMimeType;
use App\Common\Domain\Traits\CreatedAtTrait;
use App\Common\Domain\Traits\UpdatedAtTrait;
use App\Common\Infrastructure\Repository\FileDoctrineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
class File
{
    use CreatedAtTrait, UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $originalName;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $mimeType;

    #[ORM\Column(type: 'integer')]
    private int $size;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $path;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMimeType(): FileMimeType
    {
        return FileMimeType::from($this->mimeType);
    }

    public function setMimeType(FileMimeType $mimeType): void
    {
        $this->mimeType = $mimeType->value;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }
}
