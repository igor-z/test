<?php
final class MultOperation implements OperationInterface
{
    private $expression;
    private $multiplier;

    public function __construct(ImmutableCurrencyInterface $expression, float $multiplier)
    {
        $this->expression = $expression;
        $this->multiplier = $multiplier;
    }

	public function asFloat(array $currencyRates) : float
	{
		return $this->expression->asFloat($currencyRates) * $this->multiplier;
	}

    public function describe(): string
    {
        return '(' . $this->expression->describe() . ') * '.$this->multiplier;
    }

    public function collapse(): array
    {
    	$collapse = [];
	    foreach ($this->expression->collapse() as $currency => $amount) {
	    	$collapse[$currency] = $amount * $this->multiplier;
	    }

	    return $collapse;
    }
}