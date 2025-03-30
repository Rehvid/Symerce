<?php

namespace App\Dto\Response\Profile;

use App\Dto\Response\ResponseInterfaceData;

final readonly class PersonalInformationResponseDTO implements ResponseInterfaceData
{
    private function __construct(
      public string $firstname,
      public string $surname,
      public string $email
    ){}


    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            firstname: $data['firstname'],
            surname: $data['surname'],
            email: $data['email']
        );
    }
}
