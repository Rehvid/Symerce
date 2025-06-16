<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Request;

use App\Common\Application\Dto\Request\IdRequest;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final readonly class SaveOrderProductRequest
{

    #[Assert\Valid]
    public IdRequest $productId;

    public int|string $quantity;

    private int $index;

    public function __construct(
        int|string|null $productId,
        int|string $quantity,
        int $index
    ) {
        $this->productId = new IdRequest($productId);
        $this->quantity = $quantity;
        $this->index = $index;
    }

    #[Assert\Callback]
    public function validateQuantity(ExecutionContextInterface $context): void
    {
        if (!is_numeric($this->quantity) || (int)$this->quantity <= 0) {
            $context->buildViolation('Quantity must be greater than 0.')
                ->atPath("products.{$this->index}.quantity")
                ->addViolation();
        }
    }
}
