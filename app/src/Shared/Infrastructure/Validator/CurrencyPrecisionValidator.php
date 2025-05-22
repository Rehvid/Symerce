<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Validator;

use App\Shared\Application\Service\SettingsService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CurrencyPrecisionValidator extends ConstraintValidator
{
    public function __construct(private readonly SettingsService $settingManager)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof CurrencyPrecision) {
            throw new UnexpectedTypeException($constraint, CurrencyPrecision::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_numeric($value)) {
            throw new UnexpectedTypeException($value, 'numeric-string');
        }

        $precision = $this->settingManager->findDefaultCurrency()->getRoundingPrecision();

        $decimalPart = explode('.', (string) $value)[1] ?? '';

        if (strlen($decimalPart) > $precision) {
            $this->context
                ->buildViolation($constraint->message)
                ->setTranslationDomain('messages')
                ->setParameter('{{ precision }}', (string) $precision)
                ->addViolation();
        }
    }
}
