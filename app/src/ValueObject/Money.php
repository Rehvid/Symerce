<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Entity\Currency;

final readonly class Money implements \JsonSerializable
{
    /** @param string|numeric-string $amount */
    public function __construct(
        private string $amount,
        private Currency $currency
    ) {
        if (!is_numeric($this->amount)) {
            throw new \InvalidArgumentException('Amount must be a numeric string.');
        }
    }

    /**
     * @return numeric-string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getFormattedAmount(): string
    {
        return number_format(
            (float) $this->getAmount(),
            $this->currency->getRoundingPrecision(),
            '.',
            ''
        );
    }

    public function add(Money $money): self
    {
        $this->checkCurrencyCompatibility($money);

        return new self(
            bcadd($this->getAmount(), $money->getAmount(), $this->currency->getRoundingPrecision()),
            $this->currency
        );
    }

    public function subtract(Money $money): self
    {
        $this->checkCurrencyCompatibility($money);

        return new self(
            bcsub($this->getAmount(), $money->getAmount(), $this->currency->getRoundingPrecision()),
            $this->currency
        );
    }

    private function checkCurrencyCompatibility(Money $money): void
    {
        if ($this->currency->getCode() !== $money->currency->getCode()) {
            throw new \InvalidArgumentException('Currencies must be the same for this operation.');
        }
    }

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->getFormattedAmount(),
            'symbol' => $this->currency->getSymbol(),
        ];
    }
}
