<?php
final class SubOperation implements OperationInterface
{
    private $expression1;
    private $expression2;

    public function __construct(ImmutableCurrencyInterface $expression1, ImmutableCurrencyInterface $expression2)
    {
        $this->expression1 = $expression1;
        $this->expression2 = $expression2;
    }

	public function asFloat(array $currencyRates) : float
	{
		return $this->expression1->asFloat($currencyRates) - $this->expression2->asFloat($currencyRates);
	}

    public function describe(): string
    {
	    return $this->expression1->describe() . ' - ' . $this->expression2->describe();
    }

	public function collapse(): array
	{
		$collapse = $this->expression1->collapse();

		foreach ($this->expression2->collapse() as $currency => $amount) {
			$collapse[$currency] = ($collapse[$currency] ?? 0) - $amount;
		}

		return $collapse;
	}
}