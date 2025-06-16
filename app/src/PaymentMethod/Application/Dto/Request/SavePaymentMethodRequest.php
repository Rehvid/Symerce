<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Dto\Request;

use App\Common\Application\Dto\FileData;
use App\Common\Application\Dto\Request\IdRequest;
use App\Common\Domain\Entity\PaymentMethod;
use App\Common\Infrastructure\Utils\BoolHelper;
use App\Common\Infrastructure\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;
use Symfony\Component\Validator\Constraints as Assert;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueCode;

final readonly class SavePaymentMethodRequest
{
    #[Assert\Valid]
    public IdRequest $idRequest;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\GreaterThanOrEqual(0)]
    #[Assert\Type('numeric')]
    #[CustomAssertCurrencyPrecision]
    public string $fee;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 100)]
    #[CustomAssertUniqueCode(options: ['field' => 'code', 'className' => PaymentMethod::class])]
    public string $code;

    public bool $isActive;

    public bool $isRequireWebhook;

    /** @var array<mixed, mixed> */
    public array $config;

    public ?FileData $fileData;

    /**
     * @param array<mixed, mixed>  $config
     * @param array<string, mixed> $thumbnail
     */
    public function __construct(
        string $name,
        string $fee,
        string $code,
        mixed $isActive,
        mixed $isRequireWebhook,
        string|int|null $id,
        array $config,
        ?array $thumbnail
    ) {
        $this->name = $name;
        $this->fee = $fee;
        $this->code = $code;
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
        $this->isRequireWebhook = BoolHelper::castOrFail($isRequireWebhook, 'isRequireWebhook');
        $this->config = $config;
        $this->fileData = $thumbnail ? FileData::fromArray($thumbnail) : null;
        $this->idRequest = new IdRequest($id);
    }
}
