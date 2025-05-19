<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Entity\Currency;

final readonly class Money implements \JsonSerializable
{
    /** @var numeric-string */
    private string $amount;

    private Currency $currency;

    public function __construct(string $amount, Currency $currency)
    {
        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException('Amount must be a numeric string.');
        }

        $this->amount = $amount;
        $this->currency = $currency;
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

    public function getFormattedAmountWithSymbol(): string
    {
        return $this->getFormattedAmount() . ' ' . $this->currency->getSymbol();
    }

    public function add(Money $money): self
    {
        $this->checkCurrencyCompatibility($money);

        return new self(
            bcadd($this->getAmount(), $money->getAmount(), $this->currency->getRoundingPrecision()),
            $this->currency
        );
    }

    public function multiply(int|string $multiplier): self
    {
        return new self(
            bcmul($this->getAmount(), (string) $multiplier, $this->currency->getRoundingPrecision()),
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
