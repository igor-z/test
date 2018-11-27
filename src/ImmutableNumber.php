<?php
final class ImmutableNumber implements ImmutableNumberInterface
{
	/** @var OperationInterface|null */
	private $operation;
	private $amount;

	public function __construct(int $number, ?OperationInterface $operation = null)
	{
		$this->amount = $number;
		$this->operation = $operation;
	}

	public function getAmount(): int
	{
		return $this->amount;
	}

	public function sub(ImmutableCurrencyInterface $expression): ImmutableCurrencyInterface
	{
		$clonedExpression = new ImmutableCurrency($expression->getCurrency(), $expression->getAmount(), new SubOperation($this, $expression));
		return $clonedExpression;
	}

	public function add(ImmutableCurrencyInterface $expression): ImmutableCurrencyInterface
	{
		$clonedExpression = new ImmutableCurrency($expression->getCurrency(), $expression->getAmount(), new AddOperation($this, $expression));
		return $clonedExpression;
	}

	public function mul(int $multiplier): ImmutableNumberInterface
	{
		$expression = new ImmutableNumber($multiplier, new MultOperation($this, $multiplier));
		return $expression;
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
			return $this->amount;
		}
	}

	public function asFloat(array $currencyRates): float
	{
		if ($this->operation) {
			return $this->operation->asFloat($currencyRates);
		} else {
			return $this->amount;
		}
	}
}