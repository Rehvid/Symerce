<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request\Address;

use App\Common\Application\Dto\Request\IdRequest;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAddressRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $street;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^[A-Za-z]?[0-9A-Za-z\s-]{3,9}$/',
        message: "Postal code must be 4 to 10 characters long and may contain letters, digits, spaces or hyphens. It can optionally start with a letter."
    )]
    public string $postalCode;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $city;


    #[Assert\Valid]
    public IdRequest $countryIdRequest;


    public function __construct(
        string $street,
        string $postalCode,
        string $city,
        int|string|null $countryId,
    ) {
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->countryIdRequest = new IdRequest($countryId);
    }
}
