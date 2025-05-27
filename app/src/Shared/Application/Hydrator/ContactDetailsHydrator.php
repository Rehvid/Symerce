<?php

declare(strict_types=1);

namespace App\Shared\Application\Hydrator;

use App\Shared\Application\DTO\Request\ContactDetails\SaveContactDetailsRequest;
use App\Shop\Domain\Entity\Embeddables\ContactDetails;

final readonly class ContactDetailsHydrator
{
    public function hydrate(SaveContactDetailsRequest $request, ?ContactDetails $contactDetails = null): ContactDetails
    {
        $contactDetails = $contactDetails ?? new ContactDetails();
        $contactDetails->setEmail($request->email);
        $contactDetails->setPhone($request->phone);
        $contactDetails->setFirstname($request->firstname);
        $contactDetails->setSurname($request->surname);

        return $contactDetails;
    }
}
