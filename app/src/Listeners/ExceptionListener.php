<?php

declare(strict_types=1);

namespace App\Listeners;

use App\DTO\Response\ErrorResponseDTO;
use App\Service\Response\ApiResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;
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

    private function handleValidationException(ExceptionEvent $event, ValidationFailedException $exception): void
    {
        $this->logger->error($exception->getMessage(), ['exception' => $exception]);

        $errorDTO = ErrorResponseDTO::fromArray([
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => $this->translator->trans('base.messages.errors.validation_failed'),
            'details' => $this->prepareResponseDataForValidationException($exception),
        ]);

        $this->setEventResponse(
            $event,
            $this->createApiResponse(error: $errorDTO)->toArray(),
            Response::HTTP_BAD_REQUEST
        );
    }

    /** @param array<string, mixed>  $responseData */
    private function setEventResponse(ExceptionEvent $event, array $responseData, int $statusCode): void
    {
        $response = new JsonResponse($responseData, $statusCode);
        $event->setResponse($response);
    }

    /**
     * @return array<string, mixed>
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

    private function createApiResponse(?ErrorResponseDTO $error = null): ApiResponse
    {
        return new ApiResponse(error: $error);
    }
}
