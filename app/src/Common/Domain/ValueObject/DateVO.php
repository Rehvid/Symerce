<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

final readonly class DateVO
{
    private \DateTimeInterface $date;
    private \DateTimeInterface $rawDate;

    public function __construct(string|\DateTimeInterface $value)
    {
        if ($value instanceof \DateTimeInterface) {
            $this->rawDate = $value instanceof \DateTimeImmutable
                ? $value
                : \DateTimeImmutable::createFromMutable($value);
        } else {
            try {
                $this->rawDate = new \DateTime($value, new \DateTimeZone('UTC'));
            } catch (\Exception $e) {
                throw new \InvalidArgumentException(sprintf('Incorrect format date: "%s"', $value), 0, $e);
            }
        }

        $this->date = (clone $this->rawDate)->setTimezone(new \DateTimeZone('Europe/Warsaw'));
    }

    public function get(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getRaw(): \DateTimeInterface
    {
        return $this->rawDate;
    }

    public function format(string $pattern = 'Y-m-d'): string
    {
        return $this->date->format($pattern);
    }

    public function formatRaw(string $pattern = 'Y-m-d H:i:s'): string
    {
        return $this->rawDate->format($pattern);
    }

    public function __toString(): string
    {
        return $this->format();
    }

    public function modify(string $modifier): self
    {
        $modifiedRaw = ($this->rawDate instanceof \DateTimeImmutable)
            ? $this->rawDate->modify($modifier)
            : \DateTimeImmutable::createFromMutable($this->rawDate)->modify($modifier);

        return new self($modifiedRaw);
    }

    public function addDays(int $days): self
    {
        return $this->modify(sprintf('+%d days', $days));
    }

    public function subDays(int $days): self
    {
        return $this->modify(sprintf('-%d days', $days));
    }

    public function isBefore(DateVO $other): bool
    {
        return $this->date < $other->date;
    }

    public function isAfter(DateVO $other): bool
    {
        return $this->date > $other->date;
    }

    public function equals(DateVO $other): bool
    {
        return $this->date === $other->date;
    }
}
