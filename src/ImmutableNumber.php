<?php
final class ImmutableNumber implements ImmutableNumberInterface
{
	/** @var OperationInterface */
	private $operation;
	private $amount;

	public function __construct(int $number, OperationInterface $operation)
	{
		$this->amount = $number;
		$this->operation = $operation;
	}

	public function getAmount(): int
	{
		return $this->amount;
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
		return $this->operation->collapse();
	}

	public function describe(): string
	{
		return $this->operation->describe();
	}

	public function asFloat(array $currencyRates): float
	{
		return $this->operation->asFloat($currencyRates);
	}
}