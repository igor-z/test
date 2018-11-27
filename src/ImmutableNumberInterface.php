<?php
interface ImmutableNumberInterface
{
	public function mul(int $multiplier) : ImmutableNumber;
	public function add(ImmutableCurrencyInterface $expression) : ImmutableCurrency;
	public function sub(ImmutableCurrencyInterface $expression) : ImmutableCurrency;
	public function describe() : string;
	public function collapse() : array;
	public function asFloat(array $currencyRates) : float;
	public function getAmount() : int;
}