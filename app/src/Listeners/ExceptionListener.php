<?php

declare(strict_types=1);

namespace App\Listeners;

use App\DTO\Response\ErrorResponseDTO;
use App\Exceptions\RequestValidationException;
use App\Service\Response\ApiResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class ExceptionListener
{
    public function __construct(private LoggerInterface $logger, private TranslatorInterface $translator)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof UnprocessableEntityHttpException) {
            $this->handleUnprocessableEntityException($event, $exception);
        }

        if ($exception instanceof RequestValidationException) {
            $this->handleRequestValidationException($event, $exception);
        }

    }

    private function handleUnprocessableEntityException(
        ExceptionEvent $event,
        UnprocessableEntityHttpException $exception
    ): void {
        $this->logger->warning('UnprocessableEntityHttpException without ValidationFailedException.', ['exception' => $exception]);

        $errorDTO = ErrorResponseDTO::fromArray([
            'code' => $exception->getStatusCode(),
            'message' => $exception->getMessage(),
        ]);

        $this->setEventResponse(
            $event,
            $this->createApiResponse(error: $errorDTO)->toArray(),
            $exception->getStatusCode()
        );
    }

    private function handleRequestValidationException(ExceptionEvent $event, RequestValidationException $exception): void
    {
        $errorDTO = ErrorResponseDTO::fromArray([
            'code' => $exception->getStatusCode(),
            'details' => $exception->getErrors(),
            'message' =>  $this->translator->trans('base.messages.errors.validation_failed'),
        ]);

        $this->setEventResponse(
            $event,
            $this->createApiResponse(error: $errorDTO)->toArray(),
            $exception->getStatusCode()
        );
    }

    /** @param array<string, mixed>  $responseData */
    private function setEventResponse(ExceptionEvent $event, array $responseData, int $statusCode): void
    {
        $response = new JsonResponse($responseData, $statusCode);
        $event->setResponse($response);
    }

    private function createApiResponse(?ErrorResponseDTO $error = null): ApiResponse
    {
        return new ApiResponse(error: $error);
    }
}
