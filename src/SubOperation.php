<?php
final class SubOperation implements OperationInterface
{
    private $currency1;
    private $currency2;

    public function __construct(ImmutableCurrency $currency1, ImmutableCurrency $currency2)
    {
        $this->currency1 = $currency1;
        $this->currency2 = $currency2;
    }

	public function asFloat(array $currencyRates) : float
	{
		return $this->currency1->asFloat($currencyRates) - $this->currency2->asFloat($currencyRates);
	}

    public function describe(): string
    {
	    return $this->currency1->describe() . ' - ' . $this->currency2->describe();
    }

	public function collapse(): array
	{
		$collapse = $this->currency1->collapse();

		foreach ($this->currency2->collapse() as $currency => $amount) {
			$collapse[$currency] = ($collapse[$currency] ?? 0) - $amount;
		}

		return $collapse;
	}
}