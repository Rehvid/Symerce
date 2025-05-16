<?php

declare(strict_types=1);

namespace App\Manager;

use App\DTO\Shop\Request\Checkout\SaveCheckoutAddressRequest;
use App\DTO\Shop\Request\ContactDetails\SaveContactDetailsRequest;
use App\Entity\Embeddables\ContactDetails;

class ContactDetailsManager
{
    public function createContactDetails(SaveContactDetailsRequest $request): ContactDetails
    {
        $contactDetails = new ContactDetails();
        $this->setCommonFields($request, $contactDetails);

        return $contactDetails;
    }

    public function updateContactDetails(SaveContactDetailsRequest $request, ContactDetails $contactDetails): ContactDetails
    {
        $this->setCommonFields($request, $contactDetails);

        return $contactDetails;
    }

    public function setCommonFields(SaveContactDetailsRequest $request, ContactDetails $contactDetails): void
    {
        $contactDetails->setEmail($request->email);
        $contactDetails->setFirstName($request->firstname);
        $contactDetails->setSurname($request->surname);
        $contactDetails->setPhone($request->phone);
    }
}
