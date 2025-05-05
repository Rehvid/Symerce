<?php

declare(strict_types=1);

namespace App\DTO\Request\Product;

use App\DTO\Request\PersistableInterface;
use App\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class SaveProductRequestDTO implements PersistableInterface
{
    /**
     * @param array<int, mixed>         $categories
     * @param array<int, mixed>         $tags
     * @param array<int, mixed>         $deliveryTimes
     * @param array<int, mixed>         $images
     * @param array<string, mixed>      $attributes
     * @param array<string, mixed>|null $thumbnail
     */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $name,
        #[Assert\GreaterThanOrEqual(0)] #[Assert\Type('numeric')] #[CustomAssertCurrencyPrecision]  public string $regularPrice,
        #[Assert\GreaterThanOrEqual(0)] #[Assert\Type('numeric')] public string|int $quantity,
        public ?string $discountPrice = null,
        public bool $isActive,
        public array $categories = [],
        public array $tags = [],
        public array $deliveryTimes = [],
        public array $images = [],
        public array $attributes = [],
        public ?string $vendor = null,
        public ?string $slug = null,
        public ?string $description = null,
        public ?array $thumbnail = null,
    ) {
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        $validator = $context->getValidator();
        if ($this->discountPrice !== null && $this->discountPrice !== "") {
            $violations = $validator->validate($this->discountPrice, [
                new Assert\Type('numeric'),
                new Assert\GreaterThanOrEqual(0),
                new CustomAssertCurrencyPrecision(),
            ]);

            foreach ($violations as $violation) {
                $context->buildViolation((string) $violation->getMessage())
                    ->atPath('discountPrice')
                    ->addViolation();
            }
        }
    }
}
