<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Order\OrderDetail;

final readonly class OrderDetailContactResponse
{
    public function __construct(
        public ?string $firstname = null,
        public ?string $lastname = null,
        public ?string $phone = null,
        public ?string $email = null,
    ) {}
}
