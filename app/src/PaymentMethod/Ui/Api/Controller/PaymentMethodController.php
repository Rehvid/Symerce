<?php

declare(strict_types=1);

namespace App\PaymentMethod\Ui\Api\Controller;

use App\Admin\Domain\Entity\PaymentMethod;
use App\PaymentMethod\Application\Command\CreatePaymentMethodCommand;
use App\PaymentMethod\Application\Command\DeletePaymentMethodCommand;
use App\PaymentMethod\Application\Command\UpdatePaymentMethodCommand;
use App\PaymentMethod\Application\Dto\PaymentMethodData;
use App\PaymentMethod\Application\Dto\Request\SavePaymentMethodRequest;
use App\PaymentMethod\Application\Query\GetPaymentMethodForEditQuery;
use App\PaymentMethod\Application\Query\GetPaymentMethodListQuery;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Ui\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/payment-methods', name: 'api_admin_payment_method_')]
final class PaymentMethodController extends AbstractApiController
{
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
        $storeRequest = $this->requestDtoResolver->mapAndValidate($request, SavePaymentMethodRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new CreatePaymentMethodCommand(
                new PaymentMethodData(
                    name: $storeRequest->name,
                    fee: $storeRequest->fee,
                    code: $storeRequest->code,
                    isActive: $storeRequest->isActive,
                    isRequireWebhook: $storeRequest->isRequireWebhook,
                    config: $storeRequest->config,
                    fileData: $storeRequest->fileData,
                    id: $storeRequest->id,
                )
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
    public function update(PaymentMethod $paymentMethod, Request $request): JsonResponse
    {
        $storeRequest = $this->requestDtoResolver->mapAndValidate($request, SavePaymentMethodRequest::class);

        /** @var IdResponse $response */
        $response = $this->commandBus->handle(
            new UpdatePaymentMethodCommand(
                paymentMethodData: new PaymentMethodData(
                    name: $storeRequest->name,
                    fee: $storeRequest->fee,
                    code: $storeRequest->code,
                    isActive: $storeRequest->isActive,
                    isRequireWebhook: $storeRequest->isRequireWebhook,
                    config: $storeRequest->config,
                    fileData: $storeRequest->fileData,
                    id: $storeRequest->id,
                ),
                paymentMethod: $paymentMethod
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
    public function show(PaymentMethod $paymentMethod): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                $this->queryBus->ask(new GetPaymentMethodForEditQuery($paymentMethod))
            ),
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(PaymentMethod $paymentMethod): JsonResponse
    {
        $this->commandBus->dispatch(new DeletePaymentMethodCommand($paymentMethod));

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.destroy')
            )
        );
    }
}
