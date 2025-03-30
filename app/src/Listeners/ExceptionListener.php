<?php

declare(strict_types=1);

namespace App\Listeners;

use App\DTO\Response\ErrorDTO;
use App\Service\Response\ApiResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

final readonly class ExceptionListener
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof UnprocessableEntityHttpException) {
            $this->handleUnprocessableEntityException($event, $exception);
        }
    }

    private function handleUnprocessableEntityException(
        ExceptionEvent $event,
        UnprocessableEntityHttpException $exception
    ): void {
        $previousException = $exception->getPrevious();

        if ($previousException instanceof ValidationFailedException) {
            $this->handleValidationException($event, $previousException);

            return;
        }

        $this->logger->warning('UnprocessableEntityHttpException without ValidationFailedException.', ['exception' => $exception]);


        $errorDTO = ErrorDTO::fromArray([
            'code' => $exception->getStatusCode(),
            'message' => $exception->getMessage(),
        ]);
        $this->setEventResponse(
            $event,
            $this->createApiResponse(error: $errorDTO)->toArray(),
            $exception->getStatusCode()
        );
    }

    private function handleValidationException(ExceptionEvent $event, ValidationFailedException $exception): void
    {
        $this->logger->error($exception->getMessage(), ['exception' => $exception]);
        $errorDTO = ErrorDTO::fromArray([
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'message' => 'Validation failed',
            'details' => $this->prepareResponseDataForValidationException($exception)
        ]);
        $this->setEventResponse(
            $event,
            $this->createApiResponse(error: $errorDTO)->toArray(),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /** @param array{errors:mixed, success: bool} $responseData */
    private function setEventResponse(ExceptionEvent $event, array $responseData, int $statusCode): void
    {
        $response = new JsonResponse($responseData, $statusCode);
        $event->setResponse($response);
    }

    /**
     * @return array{errors: array<string, array{message: string|\Stringable}>, success: bool}
     */
    private function prepareResponseDataForValidationException(ValidationFailedException $exception): array
    {
        $responseData = [];

        $violations = $exception->getViolations();
        foreach ($violations as $violation) {
            $responseData[$violation->getPropertyPath()] = [
                'message' => $violation->getMessage(),
            ];
        }

        return $responseData;
    }

    private function createApiResponse(mixed $data = [], ?array $meta = null, ?ErrorDTO $error = null): ApiResponse
    {
        return new ApiResponse(
            data: $data,
            meta: $meta,
            error: $error,
        );
    }
}
