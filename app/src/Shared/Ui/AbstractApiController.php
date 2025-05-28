<?php

declare(strict_types=1);

namespace App\Shared\Ui;

use App\Shared\Infrastructure\Bus\Command\CommandBusInterface;
use App\Shared\Infrastructure\Bus\Query\QueryBusInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractApiController extends AbstractController
{
    public function __construct(
        protected readonly RequestDtoResolver $requestDtoResolver,
        protected readonly TranslatorInterface $translator,
        protected readonly CommandBusInterface $commandBus,
        protected readonly QueryBusInterface $queryBus,
    ) {
    }
}
