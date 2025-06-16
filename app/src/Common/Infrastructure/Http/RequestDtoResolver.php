<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Http;

use App\Common\Application\Contracts\ArrayHydratableInterface;
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
            throw new BadRequestHttpException($this->kernel->getEnvironment() === 'prod'
                ? 'Invalid JSON payload.'
                : 'Invalid JSON: ' . $e->getMessage()
            );
        }

        $dto = $this->deserialize($dtoClass, $data, $json);
        $this->validate($dto);

        return $dto;
    }

    private function deserialize(string $dtoClass, mixed $data, mixed $json)
    {
        if (in_array(ArrayHydratableInterface::class, class_implements($dtoClass), true)) {
            /** @var ArrayHydratableInterface $dtoClass */
            return $dtoClass::fromArray($data);
        }

        try {
            return $this->serializer->deserialize($json, $dtoClass, 'json');
        } catch (\Throwable $e) {
            $message = $this->kernel->getEnvironment() === 'prod'
                ? 'Invalid request structure.'
                : 'Deserialization failed: ' . $e->getMessage();
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
                $propertyPath = str_contains($path, '.')
                    ?  array_slice(explode('.', $path), -1)[0]
                    : $path;
                $errors[$propertyPath] = ['message' => $violation->getMessage()];
            }

            throw new RequestValidationException($errors);
        }
    }
}
