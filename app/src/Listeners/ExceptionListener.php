<?php

declare(strict_types=1);

namespace App\Listeners;

use App\DTO\Admin\Response\ErrorResponseDTO;
use App\Exceptions\RequestValidationException;
use App\Service\Response\ApiResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Throwable;

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
            return;
        }

        if ($exception instanceof RequestValidationException) {
            $this->handleRequestValidationException($event, $exception);
            return;
        }

        $this->handleException($event, $exception);
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

    private function handleException(ExceptionEvent $event, Throwable $exception): void
    {
        $statusCode = $exception->getCode() === 0 ? Response::HTTP_INTERNAL_SERVER_ERROR : $exception->getCode();
        $code = isset(Response::$statusTexts[$statusCode]) ? Response::HTTP_INTERNAL_SERVER_ERROR : $statusCode;
        
        $errorDTO = ErrorResponseDTO::fromArray([
            'code' => (int) $code,
            'message' =>  $exception->getMessage(),
        ]);

        $this->setEventResponse(
            $event,
            $this->createApiResponse(error: $errorDTO)->toArray(),
            (int) $code
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
