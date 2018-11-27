<?php
final class ImmutableCurrencyExpression implements ImmutableCurrencyInterface
{
    /** @var OperationInterface */
    private $operation;
    private $currency;
    private $amount;

    public function __construct(string $currency, int $number)
    {
        $this->currency = $currency;
        $this->amount = $number;
    }

    public function sub(ImmutableCurrencyInterface $expression): ImmutableCurrencyInterface
    {
    	$cloneExpression = new ImmutableCurrency();
        $expression->operation = new SubOperation($this, $expression);

        return $expression;
    }

    public function add(ImmutableCurrencyInterface $expression): ImmutableCurrencyInterface
    {
        $expression->operation = new AddOperation($this, $expression);
        return $expression;
    }

    public function mul(int $multiplier): ImmutableCurrencyInterface
    {
        $this->operations[] = new MultOperation($this, $multiplier);
        return $this;
    }

    public function collapse(): array
    {
        // TODO: Implement collapse() method.
    }

    public function describe(): string
    {
        $description = '(';

        $description .= $this->amount . $this->currency;

        foreach ($this->operations as $operation) {
            $description .= $operation->describe();
        }

        $description .= ')';
        return $description;
    }

    public function asFloat(array $currencyRates): float
    {
        // TODO: Implement asFloat() method.
    }
}