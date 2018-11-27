<?php
final class MultOperation implements OperationInterface
{
    private $currency;
    private $multiplier;

    public function __construct(ImmutableCurrency $currency, float $multiplier)
    {
        $this->currency = $currency;
        $this->multiplier = $multiplier;
    }

	public function asFloat(array $currencyRates) : float
	{
		return $this->currency->asFloat($currencyRates) * $this->multiplier;
	}

    public function describe(): string
    {
        return '(' . $this->currency->describe() . ') * '.$this->multiplier;
    }

    public function collapse(): array
    {
    	$collapse = [];
	    foreach ($this->currency->collapse() as $currency => $amount) {
	    	$collapse[$currency] = $amount * $this->multiplier;
	    }

	    return $collapse;
    }
}