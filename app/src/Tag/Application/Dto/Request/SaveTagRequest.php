<?php

declare(strict_types=1);

namespace App\Tag\Application\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveTagRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\NotBlank]
    public bool $isActive;

    public ?string $backgroundColor;

    public ?string $textColor;

    public function __construct(
        string $name,
        bool $isActive,
        ?string $backgroundColor = null,
        ?string $textColor = null,
    ) {
        $this->name = $name;
        $this->isActive = $isActive;
        $this->backgroundColor = $backgroundColor;
        $this->textColor = $textColor;
    }
}
