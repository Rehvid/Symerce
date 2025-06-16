<?php

declare(strict_types=1);

namespace App\Tag\Application\Dto\Request;

use App\Common\Infrastructure\Utils\BoolHelper;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveTagRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;


    public bool $isActive;

    #[Assert\When(
        expression: 'this.backgroundColor !== null',
        constraints: [
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $backgroundColor;

    #[Assert\When(
        expression: 'this.textColor !== null',
        constraints: [
            new Assert\Length(min: 2, max: 255),
        ]
    )]
    public ?string $textColor;

    public function __construct(
        string $name,
        mixed $isActive,
        ?string $backgroundColor = null,
        ?string $textColor = null,
    ) {
        $this->name = $name;
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
        $this->backgroundColor = $backgroundColor;
        $this->textColor = $textColor;
    }
}
