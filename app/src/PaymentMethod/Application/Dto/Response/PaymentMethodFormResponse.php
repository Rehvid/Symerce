<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Dto\Response;

use App\Admin\Application\DTO\Response\FileResponse;
use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class PaymentMethodFormResponse
{
   public function __construct(
       public string                                  $code,
       public string                                  $name,
       public string                                  $fee,
       public bool                                    $isActive,
       public bool                                    $isRequireWebhook,
       public FileResponse|null $thumbnail,
       public array $config,
   ) {

   }
}
