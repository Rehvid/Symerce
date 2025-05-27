<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Country;

use App\Admin\Application\DTO\Request\Country\SaveCountryRequest;
use App\Admin\Domain\Entity\Country;
use App\Admin\Domain\Repository\CountryRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

final readonly class CreateCountryUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
    ) {}

    /** @param SaveCountryRequest $requestDto */
    public function execute(RequestDtoInterface $requestDto): array
    {
        $country = new Country();
        $country->setName($requestDto->name);
        $country->setCode($requestDto->code);
        $country->setActive($requestDto->isActive);


        $this->countryRepository->save($country);

        return (new IdResponse($country->getId()))->toArray();
    }
}
