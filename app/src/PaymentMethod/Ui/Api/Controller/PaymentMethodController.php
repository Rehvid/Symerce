<?php

declare(strict_types=1);

namespace App\PaymentMethod\Ui\Api\Controller;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Infrastructure\Http\RequestDtoResolver;
use App\Common\Ui\Controller\Api\AbstractApiController;
use App\PaymentMethod\Application\Command\CreatePaymentMethodCommand;
use App\PaymentMethod\Application\Command\DeletePaymentMethodCommand;
use App\PaymentMethod\Application\Command\UpdatePaymentMethodCommand;
use App\PaymentMethod\Application\Dto\Request\SavePaymentMethodRequest;
use App\PaymentMethod\Application\Factory\PaymentMethodDataFactory;
use App\PaymentMethod\Application\Query\GetPaymentMethodForEditQuery;
use App\PaymentMethod\Application\Query\GetPaymentMethodListQuery;
use App\Common\Infrastructure\Bus\Command\CommandBusInterface;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api/admin/payment-methods', name: 'api_admin_payment_method_')]
final class PaymentMethodController extends AbstractApiController
{
    public function __construct(
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        private readonly PaymentMethodDataFactory $paymentMethodDataFactory,
    ) {
        parent::__construct($requestDtoResolver, $translator, $commandBus, $queryBus);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->json(
            data: $this->queryBus->ask(new GetPaymentMethodListQuery($request)),
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $paymentMethodRequest = $this->requestDtoResolver->mapAndValidate($request, SavePaymentMethodRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreatePaymentMethodCommand(
               data: $this->paymentMethodDataFactory->fromRequest($paymentMethodRequest),
            )
        );

        return $this->json(
            data: new ApiResponse(
                data: $response->toArray(),
                message: $this->translator->trans('base.messages.store')
            ),
            status: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT'], format: 'json')]
    public function update(int $id, Request $request): JsonResponse
    {
        $paymentMethodRequest = $this->requestDtoResolver->mapAndValidate($request, SavePaymentMethodRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdatePaymentMethodCommand(
                data: $this->paymentMethodDataFactory->fromRequest($paymentMethodRequest),
                paymentMethodId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                data: $response->toArray(),
                message: $this->translator->trans('base.messages.update')
            )
        );
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                $this->queryBus->ask(
                    new GetPaymentMethodForEditQuery(
                        paymentMethodId: $id
                    )
                )
            ),
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        $this->commandBus->dispatch(
            new DeletePaymentMethodCommand(
                paymentMethodId: $id
            )
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
