<?php
final class ImmutableCurrency implements ImmutableCurrencyInterface
{
	/** @var OperationInterface|null */
	private $operation;
	private $currency;
	private $amount;

	public function __construct(string $currency, int $number, ?OperationInterface $operation = null)
	{
		$this->currency = $currency;
		$this->amount = $number;
		$this->operation = $operation;
	}

	public function getAmount(): int
	{
		return $this->amount;
	}

	public function getCurrency(): string
	{
		return $this->currency;
	}

	public function sub(ImmutableCurrencyInterface $expression): ImmutableCurrency
	{
		return new ImmutableCurrency($expression->getCurrency(), $expression->getAmount(), new SubOperation($this, $expression));
	}

	public function add(ImmutableCurrencyInterface $expression): ImmutableCurrency
	{
		return new ImmutableCurrency($expression->getCurrency(), $expression->getAmount(), new AddOperation($this, $expression));
	}

	public function mul(int $multiplier): ImmutableNumber
	{
		return new ImmutableNumber($multiplier, new MultOperation($this, $multiplier));
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