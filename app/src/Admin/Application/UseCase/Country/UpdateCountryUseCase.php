<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Country;

use App\Admin\Application\DTO\Request\Country\SaveCountryRequest;
use App\Admin\Domain\Repository\CountryRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateCountryUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
    ) {}

    /** @param SaveCountryRequest $requestDto */
    public function execute(RequestDtoInterface $requestDto, int|string $entityId): mixed
    {
        $country = $this->countryRepository->findById($entityId);
        if (null === $country) {
            throw new EntityNotFoundException();
        }

        $country->setName($requestDto->name);
        $country->setCode($requestDto->code);
        $country->setActive($requestDto->isActive);


        $this->countryRepository->save($country);

        return (new IdResponse($country->getId()))->toArray();
    }
}
