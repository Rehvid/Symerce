<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\EventListener;

use App\Service\Response\ApiResponse;
use App\Shared\Application\DTO\Response\ApiErrorResponse;
use App\Shared\Infrastructure\Http\Exception\RequestValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
        $request = $event->getRequest();

        if ('json' === $request->getContentTypeFormat()) {
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


    }

    private function handleUnprocessableEntityException(
        ExceptionEvent $event,
        UnprocessableEntityHttpException $exception
    ): void {
        $this->logger->warning('UnprocessableEntityHttpException without ValidationFailedException.', ['exception' => $exception]);

        $errorDTO = ApiErrorResponse::fromArray([
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
        $errorDTO = ApiErrorResponse::fromArray([
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

    private function handleException(ExceptionEvent $event, \Throwable $exception): void
    {
        $statusCode = 0 === $exception->getCode() ? Response::HTTP_INTERNAL_SERVER_ERROR : $exception->getCode();
        $code = isset(Response::$statusTexts[$statusCode]) ? $statusCode : Response::HTTP_INTERNAL_SERVER_ERROR;

        $errorDTO = ApiErrorResponse::fromArray([
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

    private function createApiResponse(?ApiErrorResponse $error = null): ApiResponse
    {
        return new ApiResponse(error: $error);
    }
}
