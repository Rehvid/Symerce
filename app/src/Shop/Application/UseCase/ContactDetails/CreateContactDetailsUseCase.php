<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\ContactDetails;

use App\Common\Domain\Entity\ContactDetails;
use App\Shop\Application\DTO\Request\ContactDetails\SaveContactDetailsRequest;
use App\Shop\Application\Hydrator\ContactDetailsHydrator;

final readonly class CreateContactDetailsUseCase
{
    public function __construct(
        private ContactDetailsHydrator $contactDetailsHydrator,
    ) {

    }

    public function execute(SaveContactDetailsRequest $request): ContactDetails
    {
        $contactDetails = new ContactDetails();

        return $this->contactDetailsHydrator->hydrate($request, $contactDetails);
    }
}
