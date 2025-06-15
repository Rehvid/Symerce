<?php

declare(strict_types=1);

namespace App\Common\Application\Hydrator;

use App\Common\Application\Dto\ContactDetailsData;
use App\Common\Domain\Entity\ContactDetails;

final readonly class ContactDetailsHydrator
{
    public function hydrate(ContactDetailsData $data, ContactDetails $contactDetails): ContactDetails
    {
        $contactDetails->setPhone($data->phone);
        $contactDetails->setFirstname($data->firstname);
        $contactDetails->setSurname($data->surname);

        return $contactDetails;
    }
}
