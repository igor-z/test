<?php
final class ImmutableCurrency
{
    /** @var OperationInterface|null */
    private $operation;
    private $currency;
    private $amount;

    public function __construct(int $amount, string $currency, ?OperationInterface $operation = null)
    {
        $this->currency = $currency;
        $this->amount = $amount;
        $this->operation = $operation ? clone $operation : null;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function sub(ImmutableCurrency $currency): ImmutableCurrency
    {
        return new ImmutableCurrency($currency->getAmount(), $currency->getCurrency(), new SubOperation($this, $currency));
    }

    public function add(ImmutableCurrency $currency): ImmutableCurrency
    {
        return new ImmutableCurrency($currency->getAmount(), $currency->getCurrency(), new AddOperation($this, $currency));
    }

    public function mul(int $multiplier): ImmutableCurrency
    {
        return new ImmutableCurrency($multiplier, '', new MultOperation($this, $multiplier));
    }

    public function collapse(): array
    {
        if ($this->operation) {
            return $this->operation->collapse();
        } else {
            return [
                $this->currency => $this->amount,
            ];
        }
    }

    public function describe(): string
    {
        if ($this->operation) {
            return $this->operation->describe();
        } else {
            return $this->amount . $this->currency;
        }
    }

    public function asFloat(array $currencyRates): float
    {
        if ($this->operation) {
            return $this->operation->asFloat($currencyRates);
        } else {
            if (!array_key_exists($this->currency, $currencyRates)) {
                throw new ImmutableCurrencyNoRateException("No rate specified for \"{$this->currency}\"");
            }

            return $currencyRates[$this->currency] * $this->amount;
        }
    }
}