<?php

declare(strict_types=1);

namespace App\Shared\Application\Hydrator;

use App\Shared\Application\DTO\ContactDetailsData;
use App\Shared\Domain\Entity\ContactDetails;

final readonly class ContactDetailsHydrator
{
    public function hydrate(ContactDetailsData $data, ?ContactDetails $contactDetails = null): ContactDetails
    {
        $contactDetails = $contactDetails ?? new ContactDetails();
        $contactDetails->setPhone($data->phone);
        $contactDetails->setFirstname($data->firstname);
        $contactDetails->setSurname($data->surname);

        return $contactDetails;
    }
}
