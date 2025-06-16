<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\EventListener;

use App\Common\Application\Dto\Response\ApiErrorResponse;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Common\Infrastructure\Exception\InvalidBooleanValueException;
use App\Common\Infrastructure\Http\Exception\RequestValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class ExceptionJsonListener
{
    public function __construct(
        private LoggerInterface $logger,
        private TranslatorInterface $translator,
        private KernelInterface $kernel
    ) {
    }

    public function handle(ExceptionEvent $event): void
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

        if ($exception instanceof EntityNotFoundException) {
            $this->handleEntityNotFoundException($event);

            return;
        }

        if ($exception instanceof BadRequestHttpException && $exception->getPrevious() instanceof InvalidBooleanValueException) {
            $this->handleInvalidBooleanValueException($event, $exception->getPrevious());

            return;
        }

        $this->handleException($event, $exception);
    }

    private function handleUnprocessableEntityException(
        ExceptionEvent $event,
        UnprocessableEntityHttpException $exception
    ): void {
        $this->logger->warning('UnprocessableEntityHttpException without ValidationFailedException.', ['exception' => $exception]);

        $apiResponse = $this->buildErrorResult(
            message: $exception->getMessage(),
            code : $exception->getStatusCode(),
        );

        $this->setEventResponse($event, $apiResponse, $exception->getStatusCode());
    }

    private function handleEntityNotFoundException(ExceptionEvent $event): void
    {
        $code = Response::HTTP_NOT_FOUND;

        $apiResponse = $this->buildErrorResult(
            message: $this->translator->trans('base.messages.errors.not_found'),
            code: $code,
            details: 'prod' === $this->kernel->getEnvironment() ? [] : $event->getThrowable()->getTrace()
        );

        $this->setEventResponse($event, $apiResponse, $code);
    }

    private function handleRequestValidationException(ExceptionEvent $event, RequestValidationException $exception): void
    {
        $apiResponse = $this->buildErrorResult(
            message: $this->translator->trans('base.messages.errors.validation_failed'),
            code: $exception->getStatusCode(),
            details:  $exception->getErrors()
        );

        $this->setEventResponse($event, $apiResponse, $exception->getStatusCode());
    }

    private function handleInvalidBooleanValueException(ExceptionEvent $event, InvalidBooleanValueException $exception): void
    {
        $code = Response::HTTP_BAD_REQUEST;
        $apiResponse = $this->buildErrorResult(
            message: $this->translator->trans('base.messages.errors.validation_failed'),
            code: $code,
            details: [
                $exception->getFieldName() => ['message' => $exception->getMessage()],
            ]
        );

        $this->setEventResponse($event, $apiResponse, $code);
    }

    private function handleException(ExceptionEvent $event, \Throwable $exception): void
    {
        $statusCode = 0 === $exception->getCode() ? Response::HTTP_INTERNAL_SERVER_ERROR : $exception->getCode();
        $code = isset(Response::$statusTexts[$statusCode]) ? $statusCode : Response::HTTP_INTERNAL_SERVER_ERROR;

        $apiResponse = $this->buildErrorResult(
            message: $exception->getMessage(),
            code: $code
        );

        $this->setEventResponse($event, $apiResponse, $code);
    }

    private function setEventResponse(ExceptionEvent $event, ApiResponse $apiResponse, int $statusCode): void
    {
        $response = new JsonResponse($apiResponse, $statusCode);
        $event->setResponse($response);
    }

    private function buildErrorResult(string $message, int $code, ?array $details = null): ApiResponse
    {
        return new ApiResponse(
            error: new ApiErrorResponse(
                code: $code,
                message: $message,
                details: $details,
            )
        );
    }
}
