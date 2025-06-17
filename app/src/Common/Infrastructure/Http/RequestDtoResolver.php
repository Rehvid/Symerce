<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Http;

use App\Common\Domain\Validation\ValidationErrorConfig;
use App\Common\Infrastructure\Http\Exception\RequestValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class RequestDtoResolver
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private KernelInterface $kernel,
    ) {
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $dtoClass
     *
     * @return T
     */
    public function mapAndValidate(Request $request, string $dtoClass): object
    {
        $json = $request->getContent();

        try {
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            throw new BadRequestHttpException('prod' === $this->kernel->getEnvironment() ? 'Invalid JSON payload.' : 'Invalid JSON: '.$e->getMessage());
        }

        $dto = $this->deserialize($dtoClass, $data, $json);
        $this->validate($dto);

        return $dto;
    }

    private function deserialize(string $dtoClass, mixed $data, mixed $json): mixed
    {
        try {
            return $this->serializer->deserialize($json, $dtoClass, 'json');
        } catch (\Throwable $e) {
            $message = 'prod' === $this->kernel->getEnvironment()
                ? 'Invalid request structure.'
                : 'Deserialization failed: '.$e->getMessage();
            throw new BadRequestHttpException($message, $e);
        }
    }

    private function validate(object $dto): void
    {
        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $path = $violation->getPropertyPath();
                $cause = $violation->getCause();

                $customPath = (is_array($cause) && isset($cause[ValidationErrorConfig::CUSTOM_PATH]))
                    ? $cause[ValidationErrorConfig::CUSTOM_PATH]
                    : null;

                $path = $customPath ?? (
                str_contains($violation->getPropertyPath(), '.')
                    ? array_slice(explode('.', $violation->getPropertyPath()), -1)[0]
                    : $violation->getPropertyPath()
                );

                $errors[$path] = ['message' => $violation->getMessage()];
            }

            throw new RequestValidationException($errors);
        }
    }
}
