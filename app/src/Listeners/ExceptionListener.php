<?php

declare(strict_types=1);

namespace App\Listeners;

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
        $this->setEventResponse(
            $event,
            ['errors' => $exception->getMessage(), 'success' => false],
            $exception->getStatusCode()
        );
    }

    private function handleValidationException(ExceptionEvent $event, ValidationFailedException $exception): void
    {
        $this->logger->error($exception->getMessage(), ['exception' => $exception]);
        $this->setEventResponse(
            $event,
            $this->prepareResponseDataForValidationException($exception),
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
        $responseData = [
            'errors' => [],
            'success' => false,
        ];

        $violations = $exception->getViolations();
        foreach ($violations as $violation) {
            $responseData['errors'][$violation->getPropertyPath()] = [
                'message' => $violation->getMessage(),
            ];
        }

        return $responseData;
    }
}
