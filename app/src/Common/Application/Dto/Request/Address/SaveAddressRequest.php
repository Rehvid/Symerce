<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request\Address;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAddressRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $street;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 100)]
    public string $postalCode;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $city;

    #[Assert\GreaterThan(value: 0)]
    public int $country;


    public function __construct(
        string $street,
        string $postalCode,
        string $city,
        int $country,
    ) {
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->country = $country;
    }
}
