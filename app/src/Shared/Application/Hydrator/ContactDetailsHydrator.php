<?php

declare(strict_types=1);

namespace App\Shared\Application\Hydrator;

use App\Common\Domain\Entity\ContactDetails;
use App\Shared\Application\DTO\ContactDetailsData;

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
