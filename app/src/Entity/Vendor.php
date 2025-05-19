<?php

declare(strict_types=1);

namespace App\Entity;

use App\Admin\Domain\Contract\HasFileInterface;
use App\Admin\Infrastructure\Repository\VendorDoctrineRepository;
use App\Interfaces\IdentifiableEntityInterface;
use App\Traits\ActiveTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendorDoctrineRepository::class)]
class Vendor implements IdentifiableEntityInterface, HasFileInterface
{
    use ActiveTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;


    #[ORM\ManyToOne(targetEntity: File::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'image_id', referencedColumnName: 'id', nullable:true, onDelete: 'SET NULL')]
    private ?File $image = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
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

    public function getImage(): ?File
    {
        return $this->getFile();
    }

    public function setImage(?File $image): void
    {
        $this->image = $image;
    }

    public function setFile(File $file): void
    {
        $this->image = $file;
    }

    public function getFile(): ?File
    {
        return $this->image;
    }
}
