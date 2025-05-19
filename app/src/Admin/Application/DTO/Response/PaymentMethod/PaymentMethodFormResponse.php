<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\PaymentMethod;

use App\DTO\Admin\Response\FileResponseDTO;
use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class PaymentMethodFormResponse
{
   public function __construct(
       public string $code,
       public string $name,
       public string $fee,
       public bool $isActive,
       public bool $isRequireWebhook,
       public FileResponseDTO|ResponseInterfaceData|null $thumbnail,
   ) {

   }
}
