<?php

declare(strict_types=1);

namespace App\Shop\Application\Hydrator;

use App\Shop\Application\DTO\Request\ContactDetails\SaveContactDetailsRequest;
use App\Shop\Domain\Entity\Embeddables\ContactDetails;

final readonly class ContactDetailsHydrator
{
    public function hydrate(SaveContactDetailsRequest $request, ContactDetails $contactDetails): ContactDetails
    {
        $contactDetails->setEmail($request->email);
        $contactDetails->setFirstName($request->firstname);
        $contactDetails->setSurname($request->surname);
        $contactDetails->setPhone($request->phone);

        return $contactDetails;
    }
}
