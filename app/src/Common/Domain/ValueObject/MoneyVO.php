<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

use App\Common\Domain\Entity\Currency;

final readonly class MoneyVO implements \JsonSerializable
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

    public function add(MoneyVO $money): self
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

    public function subtract(MoneyVO|string|int|float $value): self
    {
        if ($value instanceof self) {
            $this->checkCurrencyCompatibility($value);
            $subtrahend = $value->getAmount();
            $scale = $value->currency->getRoundingPrecision();
        } elseif (is_numeric($value)) {
            $subtrahend = (string) $value;
            $scale = $this->currency->getRoundingPrecision();
        } else {
            throw new \InvalidArgumentException('Value for subtraction must be numeric or Money instance.');
        }

        $result = bcsub(
            $this->getAmount(),
            $subtrahend,
            $scale
        );

        return new self($result, $this->currency);
    }

    public function subtractPercentage(float|int|string $percent): self
    {
        if (!is_numeric((string) $percent)) {
        throw new \InvalidArgumentException('Percentage must be numeric.');
    }
        $scale = $this->currency->getRoundingPrecision();

        $multiplier = bcdiv(
        bcsub('100', (string) $percent, $scale + 2),
            '100',
            $scale + 2
        );

        $result = bcmul(
        $this->getAmount(),
            $multiplier,
            $scale
        );

        return new self($result, $this->currency);
    }

    public function equal(MoneyVO $money): bool
    {
        return $this->getFormattedAmount() === $money->getFormattedAmount();
    }

    private function checkCurrencyCompatibility(MoneyVO $money): void
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
