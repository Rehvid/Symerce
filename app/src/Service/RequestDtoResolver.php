<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\ArrayHydratableInterface;
use App\Exceptions\RequestValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class RequestDtoResolver
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
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
            throw new BadRequestHttpException('Invalid JSON: '.$e->getMessage());
        }

        if (in_array(ArrayHydratableInterface::class, class_implements($dtoClass), true)) {
            /** @var ArrayHydratableInterface $dtoClass */
            $dto = $dtoClass::fromArray($data);
        } else {
            try {
                $dto = $this->serializer->deserialize($json, $dtoClass, 'json');
            } catch (\Throwable $e) {
                throw new BadRequestHttpException('Deserialization failed: '.$e->getMessage());
            }
        }

        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = ['message' => $violation->getMessage()];
            }

            throw new RequestValidationException($errors);
        }

        return $dto;
    }
}
